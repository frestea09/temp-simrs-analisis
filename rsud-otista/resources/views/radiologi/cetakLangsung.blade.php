<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
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
  <body onload="print()">

    <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 100%;">{{ configrs()->nama }} </h4>
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
                <td style="width:25%">Nama</td> <td>: {{ strtoupper($pasienLangsung->nama) }}</td>
              </tr>
              <tr>
                <td style="width:25%">Alamat</td> <td>: {{ strtoupper($pasienLangsung->alamat) }}</td>
              </tr>
              <tr>
                <td>Tanggal Registrasi</td><td>: {{ $pasienLangsung->created_at }}</td>
              </tr>
              <tr>
                <td>Klinik Tujuan</td><td>: {{ strtoupper( baca_poli($reg->poli_id)) }}</td>
              </tr>
              <tr>
                <td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
              </tr>
            </tbody>
          </table>
          <br>
          @if($status == 'laboratorium')
            <h5 style="text-align: center;">Rincian Biaya Pemeriksaan Laboratorium</h5>
          @elseif($status == 'radiologi')
            <h5 style="text-align: center;">Rincian Biaya Pemeriksaan Radiologi</h5>
          @else
            <h5 style="text-align: center;">Rincian Biaya Perawatan</h5>
          @endif

          <div class="table-responsive">
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Tindakan</th>
                  <th class="text-center">Biaya</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($folio as $d)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->tarif->nama }}</td>
                    <td class="text-right">{{ number_format($d->total) }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-right">Total Biaya Perawatan</th>
                  <th class="text-right">{{ number_format($jml) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <p><b><i>Terbilang: {{ terbilang($jml) }} Rupiah</i></b></p>
  </body>
</html>