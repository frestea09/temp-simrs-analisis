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
    <h3>Laporan Pemakaian</h3>

      <table class='table table-bordered table-condensed'>
       <thead>
            <tr>
            <th>No</th>
            <th>Tanggal Pemakaian</th>
            <th>Obat</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($pemakaian))
            @foreach ($pemakaian as $key => $d)
                <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->created_at }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->jumlah }}</td>
                <td>{{ $d->keterangan }}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
      </table>
  </body>
</html>
