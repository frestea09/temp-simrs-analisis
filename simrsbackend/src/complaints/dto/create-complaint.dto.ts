import { IsString, Length } from 'class-validator';

export class CreateComplaintDto {
  @IsString()
  @Length(3, 120)
  reporter!: string;

  @IsString()
  @Length(5, 500)
  description!: string;

  @IsString()
  @Length(2, 100)
  category!: string;
}
