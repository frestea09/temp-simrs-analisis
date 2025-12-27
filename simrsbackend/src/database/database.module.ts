import { Module } from '@nestjs/common';
import { ConfigModule, ConfigService } from '@nestjs/config';
import { DatabaseService } from './database.service';
import { SchemaLoaderService } from './schema-loader.service';

@Module({
  imports: [ConfigModule],
  providers: [
    SchemaLoaderService,
    {
      provide: DatabaseService,
      useFactory: (configService: ConfigService) => {
        return new DatabaseService({
          host: configService.get<string>('DB_HOST', '127.0.0.1'),
          port: Number(configService.get<string>('DB_PORT', '3306')),
          user: configService.get<string>('DB_USER', 'root'),
          password: configService.get<string>('DB_PASSWORD', ''),
          database: configService.get<string>('DB_NAME', 'rsud_otista'),
        });
      },
      inject: [ConfigService],
    },
  ],
  exports: [DatabaseService, SchemaLoaderService],
})
export class DatabaseModule {}

