import { Body, Controller, Get, Param, Post, Query } from '@nestjs/common';
import { PatientsService, Patient } from './patients.service';
import { CreatePatientDto } from './dto/create-patient.dto';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

@Controller('patients')
export class PatientsController {
  constructor(private readonly patientsService: PatientsService) {}

  @Post()
  create(@Body() dto: CreatePatientDto): Patient {
    return this.patientsService.create(dto);
  }

  @Get()
  list(@Query() pagination: PaginationQueryDto): Patient[] {
    return this.patientsService.list(pagination);
  }

  @Get(':id')
  findOne(@Param('id') id: string): Patient {
    return this.patientsService.findOne(id);
  }
}
