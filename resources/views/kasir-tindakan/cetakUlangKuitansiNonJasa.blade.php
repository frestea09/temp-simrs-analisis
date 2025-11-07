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
        font-size: 14pt;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
    </style>
  </head>
  <body>
    <table style="width:500px; margin-bottom: -10px;">
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
                    <td>Dokter Konsultasi </td> <td>: {{ baca_dokter($d->dokter_pelaksana) }}</td>
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
                  <th class="text-center">Biaya @</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio as $d)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->tarif->nama }}</td>
                    <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                    @if ($d->tarif_id == 10000)
                        <td class="text-center">1</td>
                    @else
                        <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td>
                    @endif
                    @if ($d->tarif_id == 10000)
                        <td class="text-right">{{ number_format($d->total+$jasa_racik) }}</td>
                    @else
                        <td class="text-right">{{ number_format($d->total) }}</td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                {{-- <tr>
                  <th colspan="4" class="text-right">Jasa</th>
                  <th class="text-right">{{ number_format($jasa_racik) }}</th>
                </tr> --}}
                <tr>
                  <th colspan="4" class="text-right">Total Biaya Perawatan</th>
                  <th class="text-right">{{ number_format($jml+$jasa_racik) }}</th>
                </tr>

                <tr>
                  <th colspan="4" class="text-right">
                    @if ($reg->bayar == 1)
                      Di Jamin
                    @else
                      Sisa
                    @endif

                  </th>
                  <th class="text-right">{{ number_format($kuitansi->iur) }}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Diskon</th>
                  <th class="text-right">{{$kuitansi->diskon_persen}}%</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Total Bayar</th>
                  {{-- <th class="text-right">{{ number_format($kuitansi->dibayar-$jasa_racik-$uang_racik) }}</th> --}}
                  <th class="text-right">{{ number_format($jml+$jasa_racik) }}</th>
                </tr>
                {{--  <tr>
                  <th colspan="4" class="text-right">Harus Bayar</th>
                  <th class="text-right">{{ number_format($kuitansi->hrs_bayar) }}</th>
                </tr>  --}}
              </tfoot>
            </table>
          </div>
          <p><b><i>Terbilang: {{ terbilang($kuitansi->dibayar-$jasa_racik-$uang_racik) }} Rupiah</i></b></p>

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

          <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang, {{ date('d-m-Y')}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">Petugas</td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Penanggung Jawab Pasien,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"><br><br>({{ Auth::user()->name }})</td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"><br><br>( ..................)</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
    </table>

  </body>
</html>
