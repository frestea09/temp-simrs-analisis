import { IsIn, IsOptional, IsString } from 'class-validator';
import { PaginationQueryDto } from '../../common/dto/pagination-query.dto';

export class TableQueryDto extends PaginationQueryDto {
  @IsOptional()
  @IsString()
  orderBy?: string;

  @IsOptional()
  @IsIn(['ASC', 'DESC'])
  orderDir?: 'ASC' | 'DESC';
}

export class LookupByIdParams {
  @IsString()
  table!: string;

  @IsString()
  id!: string;
}

export class TableParams {
  @IsString()
  table!: string;
}

export class PagedResponse<T> {
  data: T[];
  pagination: { page: number; limit: number };
}

