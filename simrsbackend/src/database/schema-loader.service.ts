import * as fs from 'fs';
import * as path from 'path';

export interface ColumnDefinition {
  name: string;
  type: string;
  nullable: boolean;
  defaultValue?: string | null;
  autoIncrement: boolean;
  raw: string;
}

export interface TableSchema {
  name: string;
  columns: ColumnDefinition[];
  primaryKeys: string[];
  raw: string;
}

export class SchemaLoaderService {
  private readonly schemaByTable: Map<string, TableSchema> = new Map();

  constructor(
    private readonly schemaPath = path.resolve(__dirname, '..', '..', '..', 'rsud_otista.sql'),
  ) {}

  load(): void {
    if (this.schemaByTable.size > 0) {
      return;
    }

    const sqlDump = fs.readFileSync(this.schemaPath, 'utf8');
    const tableRegex = /CREATE TABLE `([^`]+)` \(([^;]+?)\) ENGINE=/gms;

    let match: RegExpExecArray | null;
    while ((match = tableRegex.exec(sqlDump)) !== null) {
      const [, tableName, body] = match;
      const lines = body
        .split(/\r?\n/)
        .map((line) => line.trim())
        .filter(Boolean);

      const columns: ColumnDefinition[] = [];
      const primaryKeys: string[] = [];

      for (const line of lines) {
        if (line.startsWith('`')) {
          const columnMatch = /`([^`]+)`\s+([^\s,]+[^,]*)(?:,)?$/m.exec(line);
          if (!columnMatch) {
            continue;
          }

          const [, name, descriptor] = columnMatch;
          columns.push({
            name,
            type: descriptor,
            nullable: !/NOT NULL/i.test(descriptor),
            defaultValue: this.parseDefault(descriptor),
            autoIncrement: /AUTO_INCREMENT/i.test(descriptor),
            raw: line,
          });
        } else if (line.startsWith('PRIMARY KEY')) {
          const pkMatch = /\(([^)]+)\)/.exec(line);
          if (pkMatch) {
            primaryKeys.push(
              ...pkMatch[1]
                .split(',')
                .map((token) => token.replace(/[`\s]/g, ''))
                .filter(Boolean),
            );
          }
        }
      }

      this.schemaByTable.set(tableName, {
        name: tableName,
        columns,
        primaryKeys,
        raw: body,
      });
    }
  }

  listTables(): TableSchema[] {
    this.load();
    return Array.from(this.schemaByTable.values());
  }

  getTable(table: string): TableSchema | undefined {
    this.load();
    return this.schemaByTable.get(table);
  }

  private parseDefault(descriptor: string): string | null | undefined {
    const defaultMatch = /DEFAULT\s+([^\s,]+)/i.exec(descriptor);
    if (!defaultMatch) {
      return undefined;
    }

    const rawDefault = defaultMatch[1];
    if (rawDefault.toUpperCase() === 'NULL') {
      return null;
    }

    return rawDefault.replace(/^'|'$/g, '');
  }
}

