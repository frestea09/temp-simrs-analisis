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
    <h3>Laporan Retur Obat</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>No Resep</th>
            <th>Retur inacbg</th>
            <th>Retur Kronis</th>
            
          </tr>
        </thead>
        <tbody>
          
            @foreach ($returobatrusak as $d)
            @php
                $no = 1;
            @endphp
              <tr>
                <td>{{ $no++ }}</td>
              
                <td>{{ baca_obat($d->materobat_id) }}</td>
                <td>{{ @$d->no_resep }}</td>
                <td>{{ $d->retur_inacbg }}</td>
                <td>{{ $d->retur_kronis }}</td>
               
              </tr>
            @endforeach
         
        </tbody>
      </table>
  </body>
</html>
