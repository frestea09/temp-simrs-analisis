<!--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Label Pasien</title>

    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">

    </style>
  </head>
  <body onload="print()" style="margin:0;">
  {{-- <body> --}}
    <div class="container">
    <div class="col-md-6 col-md-offset-3">
      <div class="row">
          <hr>
          <table border=0>
            <tr>
              <td>No.RM</td> 
              <td>: {{ $data->pasien->no_rm }}</td>
            </tr>

            <tr>
              <td>Nama</td> 
              <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td>Tgl Lahir</td> 
              <td>: {{ hitung_umur($data->pasien->tgllahir) }}</td>
            </tr>
            <tr>
              <td>Alamat</td> 
              <td>: {{ $data->pasien->alamat }}</td>
            </tr>
          </table>
      </div>
      </div>
    </div>
    <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ URL::previous() }}">
  </body>
</html>-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Label Pasien</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
      .text-center{
          border: none;
      }
      ul, li{
        line-height: 175%;
      }
    </style>
  </head>

  <body onload="print()">
        {{--@php
        $arr = array(1,2,3,4);
        @endphp
        @foreach ($arr as $value)@endforeach--}}

          <table border=0 style="margin-bottom:40px;font-size:12px">
            <tr>
              <td style="padding-left:90px">No.RM</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Nama</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Tgl.Lahir</td> <td>: {{ date('d-m-Y', strtotime($data->pasien->tgllahir)) }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,20) . ''}}</td>
            </tr>
          </table>

          <table border=0 style="margin-bottom:40px;font-size:12px">
            <tr>
              <td style="padding-left:90px">No.RM</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Nama</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Tgl.Lahir</td> <td>: {{ $data->pasien->tgllahir }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,20) . ''}}</td>
            </tr>
          </table>

          <table border=0 style="margin-bottom:40px;font-size:12px">
            <tr>
              <td style="padding-left:90px">No.RM</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Nama</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Tgl.Lahir</td> <td>: {{ $data->pasien->tgllahir }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,20) . ''}}</td>
            </tr>
          </table><br>

          <table border=0 style="margin-bottom:70px;font-size:12px">
            <tr>
              <td style="padding-left:90px">No.RM</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Nama</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Tgl.Lahir</td> <td>: {{ $data->pasien->tgllahir }}</td>
            </tr>
            <tr>
              <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,20) . ''}}</td>
            </tr>
          </table>
          <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ URL::previous() }}">
  </body>
</html>

