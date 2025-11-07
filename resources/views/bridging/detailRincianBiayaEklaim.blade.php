<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Eklaim</title>
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
  <body>

    <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:85px;">
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
                <td>Klinik Tujuan</td><td>: {{ strtoupper( baca_poli($reg->poli_id)) }}</td>
              </tr>
              <tr>
                <td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
              </tr>

            </tbody>
          </table>
          <br>

          <h6 style="text-align: center; font-weight: bold;">Tarif Rumah Sakit: Rp. {{ number_format($jml) }}</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Tindakan</th>
                  <th class="text-center">Tarif</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($mapping as $d)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->mapping }}</td>
                    <td class="text-right">{{ number_format( tarif_mapping($reg->id, $d->id) ) }}</td>
                  </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
          

  </body>
</html>