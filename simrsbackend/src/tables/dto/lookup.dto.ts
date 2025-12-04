import { IsObject, IsOptional, IsString } from 'class-validator';

export class LookupDto {
  @IsObject()
  primary!: Record<string, any>;
}

export class MutateDto {
  @IsOptional()
  @IsObject()
  primary?: Record<string, any>;

  @IsObject()
  data!: Record<string, any>;
}

