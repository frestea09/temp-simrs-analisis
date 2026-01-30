import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { BpjsModule } from './bpjs/bpjs.module';

@Module({
  imports: [
    ConfigModule.forRoot({
      isGlobal: true,
    }),
    BpjsModule,
  ],
})
export class AppModule {}
