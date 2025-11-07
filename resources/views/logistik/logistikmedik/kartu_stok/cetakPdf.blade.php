<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        body{
            margin: 1.5cm;
        }
    </style>
  </head>
  <body>
    <h3>Laporan Stok Opname {{ $obat }}</h3>
      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Masuk</th>
            <th class="text-center">Keluar</th>
            <th width="120px" class="text-center">Saldo</th>
            <th class="text-center">Keterangan</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($stock as $o)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $o->created_at }}</td>
                    <td class="text-center" width="10px">{{ $o->masuk }}</td>
                    <td class="text-center" width="10px">{{ $o->keluar }}</td>
                    <td class="text-center" width="10px">{{ $o->total }}</td>
                    <td>{{ $o->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
  </body>
</html>
