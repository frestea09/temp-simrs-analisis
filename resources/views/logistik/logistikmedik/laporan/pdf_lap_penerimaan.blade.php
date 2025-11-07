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
    <h3>Laporan Penerimaan</h3>

      <table class='table table-bordered table-condensed'>
       <thead>
            <tr>
            <th>No</th>
            <th>No Faktur</th>
            <th>Tanggal Penerimaan</th>
            <th>Obat</th>
            <th>Jumlah Terima</th>
            <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($penerimaan))
            @foreach ($penerimaan as $key => $d)
                <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->no_faktur }}</td>
                <td>{{ $d->tanggal_penerimaan }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->terima }}</td>
                <td>{{ $d->supplier_id }}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
      </table>
  </body>
</html>
