import { Injectable } from '@nestjs/common';
import { CreateQueueDto, VisitType } from './dto/create-queue.dto';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

export interface QueueTicket extends CreateQueueDto {
  id: string;
  status: 'waiting' | 'called' | 'served';
  createdAt: Date;
}

@Injectable()
export class QueueService {
  private readonly tickets: QueueTicket[] = [];

  create(dto: CreateQueueDto): QueueTicket {
    const ticket: QueueTicket = {
      ...dto,
      id: `Q-${dto.destination}-${Date.now()}`,
      status: 'waiting',
      createdAt: new Date(),
    };
    this.tickets.push(ticket);
    return ticket;
  }

  list(visitType: VisitType | 'all', pagination: PaginationQueryDto): QueueTicket[] {
    const filtered = visitType === 'all'
      ? this.tickets
      : this.tickets.filter((ticket) => ticket.visitType === visitType);

    const start = (pagination.page! - 1) * pagination.limit!;
    return filtered.slice(start, start + pagination.limit!);
  }

  callNext(destination: string): QueueTicket | undefined {
    const ticket = this.tickets.find(
      (item) => item.destination === destination && item.status === 'waiting',
    );

    if (ticket) {
      ticket.status = 'called';
    }

    return ticket;
  }
}
