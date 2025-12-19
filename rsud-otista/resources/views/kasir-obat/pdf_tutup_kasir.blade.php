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

    <h3>Laporan Pendapatan</h3>
    <h5>
      @if ($petugas)
        Petugas: {{ $petugas }},  &nbsp; Periode: {{ $periode }}
      @else
        Semua Petugas, Periode: {{ $periode }}
      @endif

    </h5>
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr class="info">
            <th style="vertical-align: middle;">#</th>
            <th style="vertical-align: middle;">No. Kuitansi</th>
            <th style="vertical-align: middle;">No. RM</th>
            <th style="vertical-align: middle;">Nama</th>
            <th style="vertical-align: middle;">Cara Bayar</th>
            <th style="vertical-align: middle;" class="text-center">Tunai</th>
            <th style="vertical-align: middle;" class="text-center">Piutang</th>
            <th style="vertical-align: middle;">Poli</th>
            <th style="vertical-align: middle;">Nama Dokter</th>
            {{-- <th style="vertical-align: middle;">Shift</th>
            <th style="vertical-align: middle;">Tipe Layanan</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach ($pembayaran as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->no_kwitansi }}</td>
              <td>{{ $d->no_rm }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
              <td class="text-right">{{ ($d->jenis == 'tunai') ? number_format($d->dibayar) : '' }}</td>
              <td class="text-right">{{ ($d->jenis == 'piutang') ? number_format($d->dibayar) : '' }}</td>
              <td>{{ baca_poli($d->poli_id) }}</td>
              <td>{{ baca_dokter($d->dokter_id) }}</td>
              {{-- <td></td>
              <td></td> --}}
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class="text-right">Total</th>
            <th class="text-right">{{ number_format($tunai) }}</th>
            <th class="text-right">{{ number_format($piutang) }}</th>
            <th colspan="6"></th>
          </tr>
          <tr>
            <th colspan="2">Total</th>
            <th colspan="10">Rp. {{ number_format($tunai + $piutang) }}</th>
          </tr>

          <tr>
            <th colspan="2"><i>Terbilang</i></th>
            <th colspan="10"><i>{{ terbilang($tunai + $piutang) }} Rupiah</i></th>
          </tr>
        </tfoot>
      </table>
    </div>

  </body>
</html>
