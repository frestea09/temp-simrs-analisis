<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data PDF</title>
  <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

</head>

<body>
  <h3>Laporan Kunjungan Rawat Jalan</h3>

  <table class='table table-bordered table-condensed'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No. RM</th>
        <th>Umur</th>
        <th>L/P</th>
        <th>Klinik Tujuan</th>
        <th>Dokter DPJP</th>
        <th>Cara Bayar</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($reg as $key => $d)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->no_rm }}</td>
        <td>{{ hitung_umur($d->tgllahir) }}</td>
        <td class="text-center">{{ $d->kelamin }}</td>
        <td>{{ baca_poli($d->poli_id) }}</td>
        <td>{{ baca_dokter($d->dokter_id) }}</td>
        <td>{{ baca_carabayar($d->bayar) }} {{ ($d->bayar == 1) ? $d->tipe_jkn : NULL }}</td>
        <td>{{ $d->created_at->format('d-m-Y') }}</td>
      </tr>
      @endforeach

    </tbody>
  </table>

</body>

</html>