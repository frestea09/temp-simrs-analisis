import { Module } from '@nestjs/common';
import { BpjsController } from './bpjs.controller';
import { BpjsService } from './bpjs.service';

@Module({
  controllers: [BpjsController],
  providers: [BpjsService],
})
export class BpjsModule {}
