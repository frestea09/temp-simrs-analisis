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
    <h3>Laporan Stok Opname</h3>
      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal Opname</th>
            <th class="text-center">Nama Item</th>
            <th width="120px" class="text-center">Saldo Awal</th>
            {{-- <th class="text-center">Masuk</th>
            <th class="text-center">Keluar</th> --}}
            <th width="120px" class="text-center">Saldo Akhir</th>
            {{-- <th class="text-center">Keterangan</th> --}}
          </tr>
        </thead>
        <tbody>
            @foreach ($opnames as $o)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $o->tanggalopname }}</td>
                    <td>{{ $o->nama_item }}</td>
                    <td class="text-center" width="10px">{{ $o->stok_tercatat }}</td>
                    {{-- <td class="text-center">{{ opnameMasuk($o->id) }}</td>
                    <td class="text-center">{{ opnameKeluar($o->id) }}</td> --}}
                    <td class="text-center" width="10px">{{ $o->stok_sebenarnya }}</td>
                    {{-- <td>{{ $o->keterangan }}</td> --}}
                </tr>
            @endforeach
        </tbody>
      </table>
  </body>
</html>
