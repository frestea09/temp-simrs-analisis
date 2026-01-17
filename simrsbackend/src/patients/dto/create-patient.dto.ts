import { IsDateString, IsOptional, IsString, Length } from 'class-validator';

export class CreatePatientDto {
  @IsString()
  @Length(3, 120)
  name!: string;

  @IsOptional()
  @IsString()
  medicalRecordNumber?: string;

  @IsOptional()
  @IsDateString()
  birthDate?: string;

  @IsOptional()
  @IsString()
  address?: string;
}
