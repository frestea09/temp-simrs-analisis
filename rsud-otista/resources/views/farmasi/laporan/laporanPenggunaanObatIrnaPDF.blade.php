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
    <h3>Laporan Penggunaan Obat Rawat Inap</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Obat</th>
            <th>Nama Obat</th>
            <th>Total Penggunaan</th>
            
          </tr>
        </thead>
        <tbody>
            @foreach (@$penggunaan as $d)
              <tr>
                <td>{{ $no++ }}</td>
          <td>{{ $d->kode_obat }}</td>
          <td>{{ baca_obat(@$d->nama_obat) }}</td>
          <td>{{ $d->radar }}</td>
                
                
                
               
               
              </tr>
            @endforeach
         
        </tbody>
      </table>
  </body>
</html>
