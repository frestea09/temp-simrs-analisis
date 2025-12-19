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
    <h3>Laporan Kunjungan Radiologi Gigi</h3>

    <table id='data' class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th style="vertical-align: middle;">No</th>
          <th style="vertical-align: middle;">No.RM</th>
          <th style="vertical-align: middle;">Nama </th>
          <th style="vertical-align: middle;">Alamat</th>
          <th style="vertical-align: middle;">Umur</th>
          <th style="vertical-align: middle;">L/P</th>
          <th style="vertical-align: middle;">Cara Bayar</th>
          <th style="vertical-align: middle;">Poli</th>
          <th style="vertical-align: middle;">Dokter Radiologi</th>
          <th style="vertical-align: middle;">Tanggal</th>
          <th style="vertical-align: middle;">Diagnosa Utama</th>
          <th style="vertical-align: middle;">Petugas</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reg as $key => $d)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->pasien->no_rm }}</td>
            <td>{{ $d->pasien->nama }}</td>
            <td>{{ $d->pasien->alamat }}</td>
            <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td>
            <td>{{ $d->pasien->kelamin }}</td>
            <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
            <td>{{ baca_poli($d->poli_id) }}</td>
            <td>{{ $d->dokter }}</td>
            <td>{{ tanggal($d->created_at) }}</td>
            <td>{!! $d->pemeriksaan !!}</td>
            <td>{{ $d->who_update }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>


  </body>
</html>
