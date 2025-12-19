<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak E-Klaim</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css" media="screen">
      body{
        font-size: 9pt;
        margin: 0 2cm;
      }
    </style>

  </head>
  <body>
      <table style="width: 100%; margin-left: 30px;">
        <tr>
          <td style="width:60%;">
            <img src="{{ asset('images/logo_bpjs.png') }}"style="width: 200px;">
          </td>
          <td class="text-center" style="width:40%; font-weight: bold;">
            <img src="{{ asset('images/logorsud.png') }}"style="width: 80px; float: right;">
            SURAT CETAK RESUME MEDIS<br>
            {{ config('app.name') }}
          </td>
        </tr>
      </table>
      <br>
      <br>
      <br>
      <hr>
      <br>
      <h4>Tindakan</h4>
      <table class="table table-bordered table-condensed">
        <thead class="thead-light">
          <tr>
            <th class="text-center" style="width:8%;">No</th>
            <th>Tindakan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tindakan as $key => $d)
          <tr>
            <td class="text-center">{{ $notindakan++ }}</td>
            <td>{{ $d->namatarif }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <h4>Dignosa</h4>
      <table class="table table-bordered table-condensed">
        <thead class="thead-light">
          <tr>
            <th class="text-center" style="width:8%;">No</th>
            <th>Dignosa</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($diagnosa as $key => $d)
          <tr>
            <td class="text-center">{{ $nodiagnosa++ }}</td>
            <td>{{ $d->nama }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <h4>Prosedur</h4>
      <table class="table table-bordered table-condensed">
        <thead class="thead-light">
          <tr>
            <th class="text-center" style="width:8%;">No</th>
            <th>Prosedur</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($prosedur as $key => $d)
          <tr>
            <td class="text-center">{{ $noprosedur++ }}</td>
            <td>{{ $d->nama }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <h4>Resep</h4>
      <table class="table table-bordered table-condensed">
        <thead class="thead-light">
          <tr>
            <th class="text-center" style="width:8%;" >No</th>
            <th>Resep</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penjulandetail as $key => $d)
          <tr>
            <td class="text-center">{{ $noobat++ }}</td>
            <td>{{ $d->nama }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <h4>Rincian Biaya Perawatan</h4>
      <table class="table table-bordered" style="width: 100%">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Tindakan</th>
            <th class="text-center">Biaya@</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($folio as $d)
            <tr>
              <td class="text-center">{{ $nobiaya++ }}</td>
              <td>{{ $d->tarif->nama }}</td>
              <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : '' }}</td>
              <td class="text-center">{{ ($d->tarif->total <> 0 ) ? ($d->total/$d->tarif->total) : '' }}</td>
              <td class="text-right">{{ number_format($d->total) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-right">Total Biaya Perawatan</th>
            <th class="text-right">{{ number_format($jml) }}</th>
          </tr>
        </tfoot>
      </table>

      <h4>Dokumen Rekammedis</h4>
      @foreach ($doc as $item)
          <img src="{{ asset('/dokumen_rekammedis/'.$item->radiologi) }}" style="max-width:600px;margin-top:10px;">
          <img src="{{ asset('/dokumen_rekammedis/'.$item->resummedis) }}" style="max-width:600px;margin-top:10px;">
          <img src="{{ asset('/dokumen_rekammedis/'.$item->operasi) }}" style="max-width:600px;margin-top:10px;">
          <img src="{{ asset('/dokumen_rekammedis/'.$item->laboratorium) }}" style="max-width:600px;margin-top:10px;">
          <img src="{{ asset('/dokumen_rekammedis/'.$item->pathway) }}" style="max-width:600px;margin-top:10px;">   
      @endforeach
  </body>
  </html>