<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 9pt;
        margin-left: 2.5cm;
        margin-right: 2.5cm;
      }
    </style>
  </head>
  <body>

    <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>

            </tbody>
          </table> <br>
      <hr> <br>

      <table style="width:100%">
            <tbody>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td style="width:25%">Nama / Jenis Kelamin</td> <td>: {{ strtoupper($reg->pasien->nama) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ $reg->pasien->kelamin }}</td>
              </tr>
              <tr>
                <td>Umur </td> <td>: {{ hitung_umur($reg->pasien->tgllahir) }}</td>
              </tr>
              <tr>
                <td style="width:25%">Nomor Rekam Medis</td> <td>: {{ $reg->pasien->no_rm }}</td>
              </tr>
              <tr>
                <td style="width:25%">Alamat</td> <td>: {{ strtoupper($reg->pasien->alamat) }} {{ strtoupper($reg->pasien->regency_id) }}</td>
              </tr>
              <tr>
                <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
              </tr>
              <tr>
                <td>Tanggal Registrasi</td><td>: {{ $reg->created_at }}</td>
              </tr>
              <tr>
                <td>Klinik Tujuan</td><td>:
                  @if (substr($kuitansi->no_kwitansi,0,1) == 'I')
                    {{ baca_kamar(App\Rawatinap::where('registrasi_id', $kuitansi->registrasi_id)->first()->kamar_id) }}
                  @elseif(substr($kuitansi->no_kwitansi,0,1) == 'R')
                    {{ strtoupper( baca_poli($reg->poli_id)) }}
                  @endif
              </tr>
              <tr>
                <td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
              </tr>
              @foreach ($dokter as $d)
                @if ($d->dokter_pelaksana <> null)
                  <tr>
                    <td>Dokter IGD </td> <td>: {{ baca_dokter($d->dokter_pelaksana) }}</td>
                  </tr>
                @endif
              @endforeach

            </tbody>
          </table>
          <br>
          @if (Auth::user()->hasRole('laboratorium'))
            <h5 style="text-align: center;">Rincian Biaya Pemeriksaan</h5>
          @else
            <h5 style="text-align: center;">Rincian Biaya Perawatan</h5>
          @endif


          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Tindakan</th>
                  {{-- <th class="text-center">Biaya @</th> --}}
                  {{-- <th class="text-center">Qty</th> --}}
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio as $d)
                  @php
                    $obat_uang_racik = \App\Penjualandetail::where('no_resep', $d->namatarif)->sum('uang_racik');
                    $uang_jasa_racik = \Modules\Registrasi\Entities\Folio::where('namatarif', $d->namatarif)->sum('jasa_racik');
                  @endphp
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->kelompok }}</td>
                    {{-- <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td> --}}
                    {{-- <td class="text-center">{{ ($d->tarif->total <> 0) ? round(($d->total / $d->tarif->total)) : NULL }}</td> --}}
                    <td class="text-right">
                    @if ($d->tarif_id == 10000)
                      {{ number_format($d->total+$jasa_racik+$uang_racik) }}
                    @else
                      {{ number_format($d->total) }}
                    @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-right">Total Biaya Perawatan</th>
                  <th class="text-right">{{ number_format($jml+$jasa_racik+$uang_racik) }}</th>
                </tr>

                <tr>
                  <th colspan="2" class="text-right">
                    @if ($reg->bayar == 1)
                      Di Jamin
                    @else
                      Sisa
                    @endif

                  </th>
                  <th class="text-right">{{ number_format($kuitansi->iur) }}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Diskon</th>
                  <th class="text-right">{{$kuitansi->diskon_persen}}%</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Bayar</th>
                  <th class="text-right">{{ number_format($kuitansi->dibayar) }}</th>
                </tr>
                {{--  <tr>
                  <th colspan="4" class="text-right">Harus Bayar</th>
                  <th class="text-right">{{ number_format($kuitansi->hrs_bayar) }}</th>
                </tr>  --}}
              </tfoot>
            </table>
          </div>
          <p><b><i>Terbilang: {{ terbilang($kuitansi->dibayar) }} Rupiah</i></b></p>

          {{--  <table style="width: 100%;">
            <tr>
              <td style="width: 50%;"></td>
              <td style="width: 50%;" class="text-center">
                {{ configrs()->kota }}, {{ date('d-m-Y') }}
                <br><br><br>
                <u>{{ Auth::user()->name }}</u><br>
                <small style="font-size: 8pt;">Kasir</small>
              </td>
            </tr>
          </table>  --}}

  </body>
</html>
