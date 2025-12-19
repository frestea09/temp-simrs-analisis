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
    <h3>Laporan Po</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
            <tr>
                <th>No</th>
                <th>No Po</th>
                <th>Tanggal</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Diterima</th>
                <th>Satuan</th>
                <th>Sisa</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($penerimaan))
            @foreach ($penerimaan as $key => $d)
                <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->no_po }}</td>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->jumlah_dapat }}</td>
                <td>{{ $d->terima }}</td>
                <td>{{ $d->jumlah_dapat - $d->terima }}</td>
                <td>{{ $d->satuan }}</td>
                <td>{{ $d->supplier }}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
      </table>

  </body>
</html>
