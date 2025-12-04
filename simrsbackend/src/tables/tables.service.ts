import { BadRequestException, Injectable, NotFoundException } from '@nestjs/common';
import { DatabaseService } from '../database/database.service';
import { SchemaLoaderService, TableSchema } from '../database/schema-loader.service';
import { TableQueryDto } from './dto/table-query.dto';

@Injectable()
export class TablesService {
  constructor(
    private readonly db: DatabaseService,
    private readonly schemaLoader: SchemaLoaderService,
  ) {}

  listTables(): TableSchema[] {
    return this.schemaLoader.listTables();
  }

  describe(table: string): TableSchema {
    const schema = this.schemaLoader.getTable(table);
    if (!schema) {
      throw new NotFoundException(`Table ${table} not found in schema`);
    }
    return schema;
  }

  async findAll(table: string, query: TableQueryDto) {
    const schema = this.describe(table);
    const orderBy = query.orderBy && schema.columns.find((c) => c.name === query.orderBy)
      ? `\`${query.orderBy}\``
      : schema.primaryKeys.length > 0
        ? `\`${schema.primaryKeys[0]}\``
        : undefined;

    const orderDir = query.orderDir ?? 'DESC';
    const limit = query.limit ?? 25;
    const offset = ((query.page ?? 1) - 1) * limit;

    const sql = [
      `SELECT * FROM \`${table}\``,
      orderBy ? `ORDER BY ${orderBy} ${orderDir}` : undefined,
      'LIMIT :limit OFFSET :offset',
    ]
      .filter(Boolean)
      .join(' ');

    return this.db.query(sql, { limit, offset });
  }

  async findByPrimary(table: string, primary: Record<string, any>) {
    const schema = this.describe(table);
    this.ensurePrimaryKeys(schema, primary);

    const where = this.buildWhereClause(primary);
    const rows = await this.db.query(`SELECT * FROM \`${table}\` WHERE ${where} LIMIT 1`, primary);
    if (!rows.length) {
      throw new NotFoundException(`Row not found for ${table}`);
    }
    return rows[0];
  }

  async create(table: string, data: Record<string, any>) {
    const schema = this.describe(table);
    const sanitized = this.sanitizePayload(schema, data);
    if (Object.keys(sanitized).length === 0) {
      throw new BadRequestException('Payload does not match any known columns');
    }

    const insertId = await this.db.insert(table, sanitized);
    const primaryPayload = this.buildInsertPrimary(schema, sanitized, insertId);
    return this.findByPrimary(table, primaryPayload);
  }

  async update(table: string, primary: Record<string, any>, data: Record<string, any>) {
    const schema = this.describe(table);
    this.ensurePrimaryKeys(schema, primary);
    const sanitized = this.sanitizePayload(schema, data);
    if (Object.keys(sanitized).length === 0) {
      throw new BadRequestException('Payload does not match any known columns');
    }

    const where = this.buildWhereClause(primary);
    await this.db.updateByWhere(table, sanitized, where, primary);
    return this.findByPrimary(table, primary);
  }

  async remove(table: string, primary: Record<string, any>) {
    const schema = this.describe(table);
    this.ensurePrimaryKeys(schema, primary);
    const where = this.buildWhereClause(primary);
    await this.db.deleteByWhere(table, where, primary);
    return { deleted: true };
  }

  private sanitizePayload(schema: TableSchema, payload: Record<string, any>) {
    const allowed = new Set(schema.columns.map((c) => c.name));
    return Object.fromEntries(Object.entries(payload).filter(([key]) => allowed.has(key)));
  }

  private ensurePrimaryKeys(schema: TableSchema, primary: Record<string, any>) {
    if (schema.primaryKeys.length === 0) {
      throw new BadRequestException(`Table ${schema.name} does not declare a primary key in the dump`);
    }

    const missing = schema.primaryKeys.filter((key) => !(key in primary));
    if (missing.length > 0) {
      throw new BadRequestException(`Missing primary key values: ${missing.join(', ')}`);
    }
  }

  private buildWhereClause(primary: Record<string, any>): string {
    return Object.keys(primary)
      .map((key) => `\`${key}\` = :${key}`)
      .join(' AND ');
  }

  private buildInsertPrimary(schema: TableSchema, data: Record<string, any>, insertId: number) {
    if (schema.primaryKeys.length === 1) {
      const pk = schema.primaryKeys[0];
      if (schema.columns.find((col) => col.name === pk)?.autoIncrement && !data[pk]) {
        return { [pk]: insertId };
      }
    }
    return Object.fromEntries(schema.primaryKeys.map((key) => [key, data[key]]));
  }
}

