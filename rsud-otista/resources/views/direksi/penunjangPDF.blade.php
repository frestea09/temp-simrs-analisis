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
    <h3>Laporan Penunjang</h3>

      <table class='table table-bordered table-condensed'>
        <thead>
          <tr>
            <th>NO</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Jumlah Pendapatan</th>
            
          </tr>
        </thead>
        <tbody>



          @php
              $no = 1;
          @endphp


          @if (isset($laboratorium))
          <tr>
            <td>{{ $no++ }}</td>
            <td>Laboratorium</td>
            <td>{{ $laboratorium[0]->jumlah }}</td>
            <td>{{ number_format($laboratorium->sum('total')) }}</td>
          </tr>
          @endif
          
           
          @if (isset($radiologi))
          <tr>
            <td>{{ $no++ }}</td>
            <td>Radiologi</td>
            <td>{{ $radiologi[0]->jumlah }}</td>
            <td>{{ number_format($radiologi->sum('total')) }}</td>
          </tr>
          @endif


          @if (isset($usg))
          <tr>
            <td>{{ $no++ }}</td>
            <td>Usg</td>
            <td>{{ $usg[0]->jumlah }}</td>
            <td>{{ number_format($usg->sum('total')) }}</td>
          </tr>
          @endif



          @if (isset($fnab))
          <tr>
            <td>{{ $no++ }}</td>
            <td>Fnab</td>
            <td>{{ $fnab[0]->jumlah }}</td>
            <td>{{ number_format($fnab->sum('total')) }}</td>
          </tr>
          @endif

          @if (isset($citologi))
          <tr>
            <td>{{ $no++ }}</td>
            <td>Citologi</td>
            <td>{{ $citologi[0]->jumlah }}</td>
            <td>{{ number_format($citologi->sum('total')) }}</td>
          </tr>
          @endif



            
          @if (isset($pa_operasi))
          <tr>
            <td>{{ $no++ }}</td>
            <td>PA Operasi</td>
            <td>{{ $pa_operasi[0]->jumlah }}</td>
            <td>{{ number_format($pa_operasi->sum('total')) }}</td>
          </tr>
          @endif



              
          @if (isset($pa_biopsi))
          <tr>
            <td>{{ $no++ }}</td>
            <td>PA Biopsi</td>
            <td>{{ $pa_biopsi[0]->jumlah }}</td>
            <td>{{ number_format($pa_biopsi->sum('total')) }}</td>
          </tr>
          @endif
         
        </tbody>
      </table>
  </body>
</html>
