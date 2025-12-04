import { IsEnum, IsInt, IsString, Min } from 'class-validator';

enum VisitType {
  POLI = 'poli',
  IGD = 'igd',
  RADIOLOGY = 'radiology',
  LAB = 'lab',
}

export class CreateQueueDto {
  @IsString()
  patientId!: string;

  @IsEnum(VisitType)
  visitType!: VisitType;

  @IsString()
  destination!: string;

  @IsInt()
  @Min(1)
  ticketNumber!: number;
}

export { VisitType };
