import { Module } from '@nestjs/common';
import { BridgingController } from './bridging.controller';
import { BridgingService } from './bridging.service';

@Module({
  controllers: [BridgingController],
  providers: [BridgingService],
  exports: [BridgingService],
})
export class BridgingModule {}
