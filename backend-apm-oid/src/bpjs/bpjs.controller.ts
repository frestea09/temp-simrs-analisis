import { Body, Controller, Post } from '@nestjs/common';
import { BpjsService } from './bpjs.service';

interface BuatSepRequest {
  data: string;
}

interface RujukanCheckRequest {
  data?: string;
  no_rujukan?: string;
}

@Controller('bpjs')
export class BpjsController {
  constructor(private readonly bpjsService: BpjsService) {}

  @Post('buat-sep')
  async buatSep(@Body() body: BuatSepRequest) {
    return this.bpjsService.buatSep(body);
  }

  @Post('cek-rujukan-habis')
  async cekRujukanHabis(@Body() body: RujukanCheckRequest) {
    return this.bpjsService.cekRujukanHabis(body);
  }
}
