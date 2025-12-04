import { Body, Controller, Get, Post, Query } from '@nestjs/common';
import { ComplaintsService, Complaint } from './complaints.service';
import { CreateComplaintDto } from './dto/create-complaint.dto';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

@Controller('complaints')
export class ComplaintsController {
  constructor(private readonly complaintsService: ComplaintsService) {}

  @Post()
  create(@Body() dto: CreateComplaintDto): Complaint {
    return this.complaintsService.create(dto);
  }

  @Get()
  list(@Query() pagination: PaginationQueryDto): Complaint[] {
    return this.complaintsService.list(pagination);
  }
}
