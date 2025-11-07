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
         }
      </style>
  </head>
   <body>
      <h4 class="text-center">Laporan Sensus Keluar Rawat Inap Periode {{ $tga }} s/d {{ $tgb }}</h4>
      <br/>
      <table class="table table-bordered" id="sensus">
         <thead>
            <tr>
                <th class="text-center" width="15px">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">No RM</th>
                <th class="text-center">Umur</th>
                <th class="text-center">Tgl Masuk Ruangan</th>
                <th class="text-center">Lama Rawat</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Jaminan</th>
                <th class="text-center">Diagnosa</th>
                <th class="text-center">Dokter</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($pasien as $p)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->no_rm }}</td>
                    <td>{{ hitung_umur($p->tgllahir) }}</td>
                    <td>{{ date('d M Y H:i:s', strtotime($p->tgl_masuk)) }}</td>
                    <td>{{ lamaInap($p->tgl_masuk, $p->tgl_keluar) }}</td>
                    <td>{{ baca_kelas($p->kelas_id) }}</td>
                    <td>{{ baca_carabayar($p->bayar) }}</td>
                    <td>{!! $p->icd10 !!}</td>
                    <td>{{ ($p->dokter_id != '') ? baca_dokter($p->dokter_id) : '' }}</td>
                </tr>
            @endforeach
         </tbody>
      </table>
   </body>
</html>