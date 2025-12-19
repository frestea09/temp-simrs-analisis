<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

  </head>
  <body>
    <h3>Laporan Kunjungan Rawat Inap</h3>

    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th style="vertical-align: middle;">No</th>
          <th style="vertical-align: middle;">No. RM</th>
          <th style="vertical-align: middle;">Nama</th>
          <th style="vertical-align: middle;">Alamat</th>
          <th style="vertical-align: middle;">Tgl Masuk</th>
          <th style="vertical-align: middle;">Cara Bayar</th>
          <th style="vertical-align: middle;">Kelas</th>
          <th style="vertical-align: middle;">Kamar</th>
          <th style="vertical-align: middle;">Bed</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($irna as $key => $d)
          @php
            $pasien = Modules\Pasien\Entities\Pasien::where('id', $d->pasien_id)->first()
          @endphp
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $pasien->no_rm }}</td>
            <td>{{ $pasien->nama }}</td>
            <td>{{ $pasien->alamat }}</td>
            <td>{{ tanggal($d->created_at) }}</td>
            <td>{{ baca_carabayar($d->carabayar_id) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
            <td>{{ baca_kelas($d->kelas_id) }}</td>
            <td>{{ baca_kamar($d->kamar_id) }}</td>
            <td>{{ baca_bed($d->bed_id) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
