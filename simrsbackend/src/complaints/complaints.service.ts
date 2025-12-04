import { Injectable } from '@nestjs/common';
import { CreateComplaintDto } from './dto/create-complaint.dto';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

export interface Complaint extends CreateComplaintDto {
  id: string;
  status: 'open' | 'in-progress' | 'resolved';
  createdAt: Date;
}

@Injectable()
export class ComplaintsService {
  private readonly complaints: Complaint[] = [];

  create(dto: CreateComplaintDto): Complaint {
    const complaint: Complaint = {
      ...dto,
      id: `C-${Date.now()}`,
      status: 'open',
      createdAt: new Date(),
    };
    this.complaints.push(complaint);
    return complaint;
  }

  list(pagination: PaginationQueryDto): Complaint[] {
    const start = (pagination.page! - 1) * pagination.limit!;
    return this.complaints.slice(start, start + pagination.limit!);
  }
}
