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
    <h3>Laporan Tagihan</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
            <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Obat</th>
                <th>Terima</th>
                <th>Harga</th>
                <th>Sub Total</th>
                <th>PPn</th>
                <th>Diskon</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
        @if (!empty($penerimaan))
        @foreach ($penerimaan as $key => $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->supplier_id }}</td>
                <td>{{ $d->tanggal_po }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->terima}}</td>
                <td>{{ number_format($d->hna) }}</td>
                <td>{{ number_format($d->total_hna) }}</td>
                <td>{{ number_format($d->ppn) }}</td>
                <td>{{ !empty(number_format($d->diskon_rupiah)) ? $d->diskon_persen : number_format($d->diskon_rupiah) }}</td>
                <td>{{ number_format($d->harga_jual) }}</td>
            </tr>
        @endforeach
        @endif
        </tbody>
      </table>

  </body>
</html>
