<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    
  </head>
  <body>
    <h3>Laporan Penjualan User</h3>

    <table class="table table-hover table-bordered table-condensed" id="data">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama User</th>
          <th>Nama Obat</th>
          <th>Total Harga</th>
          
        </tr>
      </thead>
      <tbody>
        @php
            $no = 0;
           
        @endphp
          @foreach (@$data as $d)
         <tr>
        <td>{{ $no++ }}</td>
        <td>{{ baca_user($d->user_id) }}</td>
        <td>{{ baca_obat(@$d->masterobat_id) }}</td>
        <td>{{ $d->jumlah }}</td>
        <td>{{ $d->hargajual }}</td>
              
              
              
             
             
            </tr>
          @endforeach
       
      </tbody>
    </table>
  </body>
</html>
