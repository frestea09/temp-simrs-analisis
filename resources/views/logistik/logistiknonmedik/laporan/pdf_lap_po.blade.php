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
    <h3>Laporan PO</h3>
        <table class="table table-bordered table-striped" id="data" border="1">
            <thead>
            <tr>
                <th class="text-center">No PO</th>
                <th class="text-center">Tanggal Po</th>
                <th class="text-center">Jenis Pengadaan</th>
                <th class="text-center">supplier</th>
            </tr>
            </thead>
            <tbody>
                @if (!empty($po))
                    @foreach ($po as $key => $d)
                    <tr>
                        <td>{{ $d->no_po }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->jenis_pengadaan }}</td>
                        <td>{{ $d->supplier }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
  </body>
</html>
