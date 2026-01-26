import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { QueueModule } from './queue/queue.module';
import { PatientsModule } from './patients/patients.module';
import { BridgingModule } from './bridging/bridging.module';
import { ComplaintsModule } from './complaints/complaints.module';
import { TablesModule } from './tables/tables.module';

@Module({
  imports: [
    ConfigModule.forRoot({ isGlobal: true, envFilePath: ['.env', '../.env'] }),
    QueueModule,
    PatientsModule,
    BridgingModule,
    ComplaintsModule,
    TablesModule,
  ],
})
export class AppModule {}
