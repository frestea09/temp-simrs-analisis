import { Body, Controller, Get, Param, Post, Query } from '@nestjs/common';
import { CreateQueueDto, VisitType } from './dto/create-queue.dto';
import { QueueService, QueueTicket } from './queue.service';
import { PaginationQueryDto } from '../common/dto/pagination-query.dto';

@Controller('queue')
export class QueueController {
  constructor(private readonly queueService: QueueService) {}

  @Post()
  create(@Body() dto: CreateQueueDto): QueueTicket {
    return this.queueService.create(dto);
  }

  @Get()
  list(
    @Query('type') type: VisitType | 'all' = 'all',
    @Query() pagination: PaginationQueryDto,
  ): QueueTicket[] {
    return this.queueService.list(type, pagination);
  }

  @Post(':destination/call-next')
  callNext(@Param('destination') destination: string): QueueTicket | undefined {
    return this.queueService.callNext(destination);
  }
}
