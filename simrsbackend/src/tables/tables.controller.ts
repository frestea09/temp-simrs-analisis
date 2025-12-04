import {
  BadRequestException,
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Patch,
  Post,
  Query,
} from '@nestjs/common';
import { TablesService } from './tables.service';
import { LookupDto, MutateDto } from './dto/lookup.dto';
import { LookupByIdParams, TableParams, TableQueryDto } from './dto/table-query.dto';

@Controller('tables')
export class TablesController {
  constructor(private readonly tablesService: TablesService) {}

  @Get()
  listTables() {
    return this.tablesService.listTables();
  }

  @Get(':table')
  listRows(@Param() params: TableParams, @Query() query: TableQueryDto) {
    return this.tablesService.findAll(params.table, query);
  }

  @Get(':table/:id')
  getById(@Param() params: LookupByIdParams) {
    const schema = this.tablesService.describe(params.table);
    if (schema.primaryKeys.length !== 1) {
      throw new BadRequestException(
        'This table uses a composite primary key. Please use POST /tables/:table/lookup with a full primary object.',
      );
    }

    return this.tablesService.findByPrimary(params.table, {
      [schema.primaryKeys[0]]: params.id,
    });
  }

  @Post(':table/lookup')
  lookup(@Param() params: TableParams, @Body() body: LookupDto) {
    return this.tablesService.findByPrimary(params.table, body.primary);
  }

  @Post(':table')
  create(@Param() params: TableParams, @Body() body: MutateDto) {
    return this.tablesService.create(params.table, body.data);
  }

  @Patch(':table/:id')
  updateById(@Param() params: LookupByIdParams, @Body() body: MutateDto) {
    const schema = this.tablesService.describe(params.table);
    if (schema.primaryKeys.length !== 1) {
      throw new BadRequestException(
        'This table uses a composite primary key. Please use PATCH /tables/:table with a primary object.',
      );
    }

    return this.tablesService.update(
      params.table,
      { [schema.primaryKeys[0]]: params.id },
      body.data,
    );
  }

  @Patch(':table')
  update(@Param() params: TableParams, @Body() body: MutateDto) {
    if (!body.primary) {
      throw new BadRequestException('Primary key payload is required for this operation');
    }
    return this.tablesService.update(params.table, body.primary, body.data);
  }

  @Delete(':table/:id')
  deleteById(@Param() params: LookupByIdParams) {
    const schema = this.tablesService.describe(params.table);
    if (schema.primaryKeys.length !== 1) {
      throw new BadRequestException(
        'This table uses a composite primary key. Please use DELETE /tables/:table with a primary object.',
      );
    }

    return this.tablesService.remove(params.table, {
      [schema.primaryKeys[0]]: params.id,
    });
  }

  @Delete(':table')
  delete(@Param() params: TableParams, @Body() body: LookupDto) {
    return this.tablesService.remove(params.table, body.primary);
  }
}

