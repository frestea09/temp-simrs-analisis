import { HttpException, HttpStatus, Injectable } from '@nestjs/common';
import axios, { AxiosError } from 'axios';

interface BuatSepRequest {
  data: string;
}

interface RujukanCheckRequest {
  data?: string;
  no_rujukan?: string;
}

@Injectable()
export class BpjsService {
  private readonly baseUrl: string | undefined;

  constructor() {
    const rawBaseUrl = process.env.RSUD_OTISTA_BASE_URL;
    this.baseUrl = rawBaseUrl ? rawBaseUrl.replace(/\/$/, '') : undefined;
  }

  async buatSep(payload: BuatSepRequest) {
    if (!payload?.data) {
      throw new HttpException('Field "data" wajib diisi', HttpStatus.BAD_REQUEST);
    }

    return this.postToRsud('/buat-sep', payload);
  }

  async cekRujukanHabis(payload: RujukanCheckRequest) {
    if (!payload?.data && !payload?.no_rujukan) {
      throw new HttpException(
        'Field "data" atau "no_rujukan" wajib diisi',
        HttpStatus.BAD_REQUEST,
      );
    }

    const response = await this.postToRsud('/get-data-by-rujukan', payload);
    const normalized = this.normalizeResponse(response);
    const message = this.extractMessage(normalized);
    const expired = message
      ? message.toLowerCase().includes('masa berlaku habis')
      : false;

    return {
      expired,
      message,
      response: normalized,
    };
  }

  private async postToRsud(path: string, payload: Record<string, unknown>) {
    if (!this.baseUrl) {
      throw new HttpException(
        'RSUD_OTISTA_BASE_URL belum diset',
        HttpStatus.SERVICE_UNAVAILABLE,
      );
    }

    try {
      const { data } = await axios.post(`${this.baseUrl}${path}`, payload, {
        headers: {
          'Content-Type': 'application/json',
        },
      });
      return data;
    } catch (error) {
      if (error instanceof AxiosError) {
        const status = error.response?.status ?? HttpStatus.BAD_GATEWAY;
        throw new HttpException(error.response?.data ?? error.message, status);
      }
      throw error;
    }
  }

  private normalizeResponse(payload: unknown) {
    if (typeof payload === 'string') {
      try {
        return JSON.parse(payload);
      } catch (error) {
        return payload;
      }
    }
    return payload;
  }

  private extractMessage(payload: unknown): string | null {
    if (!payload) {
      return null;
    }

    if (Array.isArray(payload)) {
      const meta = payload.find((item) => item?.metaData)?.metaData;
      if (meta?.message) {
        return String(meta.message);
      }
    }

    if (typeof payload === 'object' && payload !== null) {
      const meta = (payload as { metaData?: { message?: string } }).metaData;
      if (meta?.message) {
        return String(meta.message);
      }
    }

    return String(payload);
  }
}
