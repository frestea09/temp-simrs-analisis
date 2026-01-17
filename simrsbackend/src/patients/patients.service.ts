import { Injectable, NotFoundException } from '@nestjs/common';
import { CreatePatientDto } from './dto/create-patient.dto';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

export interface Patient extends CreatePatientDto {
  id: string;
  createdAt: Date;
}

@Injectable()
export class PatientsService {
  private readonly patients: Patient[] = [];

  create(dto: CreatePatientDto): Patient {
    const patient: Patient = {
      ...dto,
      id: `P-${Date.now()}`,
      createdAt: new Date(),
    };
    this.patients.push(patient);
    return patient;
  }

  list(pagination: PaginationQueryDto): Patient[] {
    const start = (pagination.page! - 1) * pagination.limit!;
    return this.patients.slice(start, start + pagination.limit!);
  }

  findOne(id: string): Patient {
    const patient = this.patients.find((item) => item.id === id);
    if (!patient) {
      throw new NotFoundException(`Patient ${id} not found`);
    }
    return patient;
  }
}
