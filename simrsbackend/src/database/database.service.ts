import { Injectable, OnModuleDestroy, OnModuleInit } from '@nestjs/common';
import { createPool, Pool, RowDataPacket } from 'mysql2/promise';

export interface DatabaseConfig {
  host: string;
  port: number;
  user: string;
  password: string;
  database: string;
}

@Injectable()
export class DatabaseService implements OnModuleInit, OnModuleDestroy {
  private pool: Pool | null = null;

  constructor(private readonly config: DatabaseConfig) {}

  async onModuleInit() {
    this.pool = createPool({
      host: this.config.host,
      port: this.config.port,
      user: this.config.user,
      password: this.config.password,
      database: this.config.database,
      connectionLimit: 10,
      namedPlaceholders: true,
    });
  }

  async onModuleDestroy() {
    if (this.pool) {
      await this.pool.end();
    }
  }

  async query<T extends RowDataPacket[]>(sql: string, params: Record<string, any> = {}): Promise<T> {
    if (!this.pool) {
      throw new Error('Database pool not initialized');
    }

    const [rows] = await this.pool.query<T>(sql, params);
    return rows;
  }

  async execute(sql: string, params: Record<string, any> = {}): Promise<void> {
    if (!this.pool) {
      throw new Error('Database pool not initialized');
    }

    await this.pool.execute(sql, params);
  }

  async insert(table: string, payload: Record<string, any>): Promise<number> {
    const placeholders = Object.keys(payload)
      .map((key) => `:${key}`)
      .join(', ');
    const columns = Object.keys(payload)
      .map((key) => `\`${key}\``)
      .join(', ');

    const sql = `INSERT INTO \`${table}\` (${columns}) VALUES (${placeholders})`;
    if (!this.pool) {
      throw new Error('Database pool not initialized');
    }

    const [result] = await this.pool.execute<any>(sql, payload);
    return result.insertId ?? 0;
  }

  async updateByWhere(table: string, payload: Record<string, any>, where: string, params: Record<string, any>): Promise<void> {
    const setClause = Object.keys(payload)
      .map((key) => `\`${key}\` = :set_${key}`)
      .join(', ');

    const sql = `UPDATE \`${table}\` SET ${setClause} WHERE ${where}`;
    await this.execute(sql, { ...params, ...this.prefixParams(payload, 'set_') });
  }

  async deleteByWhere(table: string, where: string, params: Record<string, any>): Promise<void> {
    const sql = `DELETE FROM \`${table}\` WHERE ${where}`;
    await this.execute(sql, params);
  }

  private prefixParams(obj: Record<string, any>, prefix: string): Record<string, any> {
    return Object.entries(obj).reduce<Record<string, any>>((acc, [key, value]) => {
      acc[`${prefix}${key}`] = value;
      return acc;
    }, {});
  }
}

