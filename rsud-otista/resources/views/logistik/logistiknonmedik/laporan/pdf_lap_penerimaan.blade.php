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
        <table class="table table-bordered table-striped" id="data" border="1">
            <thead>
            <tr>
                <th class="text-center">No Faktur</th>
                <th class="text-center">Tanggal PO</th>
                <th class="text-center">Tanggal Penerimaan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Di terima</th>
                <th class="text-center">supplier</th>
            </tr>
            </thead>
            <tbody>
                @if (!empty($penerimaan))
                    @foreach ($penerimaan as $key => $d)
                    <tr>
                        <td>{{ $d->no_faktur }}</td>
                        <td>{{ $d->tanggal_po }}</td>
                        <td>{{ $d->tanggal_penerimaan }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>{{ $d->terima }}</td>
                        <td>{{ $d->supplier }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
  </body>
</html>
