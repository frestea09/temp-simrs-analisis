<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data PDF</title>
        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    </head>
    <body width="100%">
        <h4>Laporan Pendapatan Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped"  width="100%" style="font-size:10px">
            @php $no=1; $total = 0; @endphp
            @if(!empty($kategori))
              <thead>
                <tr>
                  <td colspan="6" class="text-right"><b>Total</b></td>
                  <td class="text-justify" colspan="3"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($pembayaran->sum('dibayar')) }}</b></td>
                  {{-- <td>&nbsp;</td> --}}
                </tr>
                <tr>
                  <th class="text-center" width="35px">NO</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">No. RM</th>
                  <th class="text-center">Poli / Ruangan</th>
                  <th class="text-center">No. Kwitansi</th>
                  <th class="text-center">Tagihan</th>
                  <th class="text-center">Diskon</th>
                  <th class="text-center">Dibayar</th>
                  <th class="text-center">Petugas</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pembayaran->get() as $item)
                  @php
                      if (!$item->pasien) {
                        @$namapasien = @\Modules\Registrasi\Entities\Registrasi::where('id',$item->registrasi_id)->first();
                      }
                  @endphp
                  <tr>
                    <td width="35px" class="text-center">{{$no++}}</td>
                    <td style="max-width: 20px;">{!!@$item->pasien->nama ? @$item->pasien->nama : @$namapasien->pasien->nama!!}</td>
                    <td>{{!empty($item->pasien->no_rm) ? $item->pasien->no_rm: @$namapasien->pasien->no_rm}}</td>
                    <td>
                      @if (@$item->registrasis->poli_id)
                        @if (@$item->registrasis->rawat_inap)
                          {{@baca_kamar($item->registrasis->rawat_inap->kamar_id)}}
                        @else
                          {{@baca_poli($item->registrasis->poli_id)}}
                        @endif
                      @else
                        @if (substr($namapasien->status_reg, 0, 1) == 'A')
                          Farmasi
                        @elseif (substr($namapasien->status_reg, 0, 1) == 'L')
                          Laboratorium
                        @else
                          Penjualan Bebas
                        @endif
                      @endif
                    </td>
                    <td>{{!empty($item->no_kwitansi) ? $item->no_kwitansi: '-'}}</td>
                    <td class="text-justify text-success"><span class="pull-left">Rp. </span><span class="pull-right">{{ ($item->total) }}</span></td>
                    <td class="text-justify text-red"><span class="pull-left">Rp. </span><span class="pull-right">{{ ($item->diskon_rupiah) }}</span></td>
                    <td class="text-justify text-primary"><span class="pull-left">Rp. </span><span class="pull-right">{{ $item->dibayar - $item->diskon_rupiah }}</span></td>
                    <td class="text-justify">{{@$item->user->name}}</td>
                  </tr>
                  @php
                      $total += $item->dibayar
                  @endphp
                @endforeach
                  {{-- <tr>
                    <td colspan="2" class="text-right"><b>Total UMUM</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><b>Total JKN</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($JKN) }}</b></td>
                  </tr> --}}
                  <tr>
                    <td colspan="6" class="text-right"><b>Total</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                    <td>&nbsp;</td>
                  </tr>
                
              </tbody>
            @else
              <thead>
                <tr>
                  <th class="text-center" width="50%">Uraian</th>
                  <th class="text-center" width="25%">Tanggal</th>
                  <th class="text-center" width="25%">Total</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($folio as $k => $f)
                  @if($k == 0)
                    <tr>
                      <td class="text-center" rowspan="{{ count($folio) }}"><b>{{ ($poliId == '') ? 'Rawat Inap' : baca_poli($poliId) }}</b></td>
                      <td class="text-center">{{ $f->tgl }}</td>
                      <td class="text-justify"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($f->total) }}</span></td>
                      @php $total += $f->total; @endphp
                    </tr>
                  @else
                    <tr>
                      <td class="text-center">{{ $f->tgl }}</td>
                      <td class="text-justify"><span class="pull-left">Rp. </span><span class="pull-right">{{ number_format($f->total) }}</span></td>
                      @php 
                        $total += $f->total;
                      @endphp
                    </tr>
                  @endif
                @endforeach --}}
                  {{-- <tr>
                    <td colspan="2" class="text-right"><b>Total UMUM</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><b>Total JKN</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($JKN) }}</b></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total + $JKN) }}</b></td>
                  </tr> --}}
                  {{--  @foreach ($tagihan as $t)
                    @if($t->lunas == 'Y')
                      <tr>
                        <td colspan="2" class="text-right"><b>Total Terbayar</b></td>
                        <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($t->total) }}</b></td>
                      </tr>
                    @else
                      <tr>
                        <td colspan="2" class="text-right"><b>Sisa Tagihan</b></td>
                        <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($t->total) }}</b></td>
                      </tr>
                    @endif
                  @endforeach  --}}
              </tbody>
            @endif
            </table>
          </div>
    </body>
</html>
