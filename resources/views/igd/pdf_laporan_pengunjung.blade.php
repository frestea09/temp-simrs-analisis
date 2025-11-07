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
    <h3>Laporan Kunjungan Rawat Darurat</h3>

      <table class='table table-bordered'>
        <thead>
          <tr>
            <th style="vertical-align: middle">No</th>
            <th style="vertical-align: middle">Nama</th>
            <th style="vertical-align: middle">No. RM</th>
            {{-- <th style="vertical-align: middle">Umur</th> --}}
            <th style="vertical-align: middle">L/P</th>
            <th style="vertical-align: middle">Poli Tujuan</th>
            <th style="vertical-align: middle">Dokter</th>
            <th style="vertical-align: middle">Cara Bayar</th>
            <th style="vertical-align: middle">Tanggal</th>
            <th style="vertical-align: middle">Status</th>
            <th style="vertical-align: middle">Petugas</th>
            <th style="vertical-align: middle">Tarif</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($reg as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->pasien->nama }}</td>
              <td>{{ $d->pasien->no_rm }}</td>
              {{-- <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td> --}}
              <td>{{ $d->pasien->kelamin }}</td>
              <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
              <td>{{ !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : '' }}</td>
              <td>{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
              <td>{{ date("d-m-Y", strtotime($d->tanggal)) }}</td>
              <td>
                @if ($d->status == 'baru')
                  Baru
                @elseif($d->status == 'lama')
                  Lama
                @endif
              </td>
              <td>{{ App\User::find($d->user_create)->name }}</td>
              <td class="text-right">{{ number_format($d->total) }}</td>
            </tr>
          @endforeach

        </tbody>
      </table>


  </body>
</html>
