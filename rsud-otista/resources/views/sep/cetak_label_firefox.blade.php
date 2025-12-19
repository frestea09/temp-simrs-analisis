<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Label Pasien</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    {{-- <style media="screen">
      *{
        margin:0px !important;
      }
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
    </style> --}}
    <style media="print">
      @page {
            width: 8cm;
            margin-left: 2.5cm;
            margin-top: 0.1cm;
            height: 2.5;
            font-size: 8pt;
        }
        .box{
          width: 7.5cm;
          height: 2 cm;
          margin: 0.2cm;
          margin-bottom: 0.3cm;
        }
      </style>
  </head>
  {{-- @php
  $arr = array(1,2,3,4);
  @endphp --}}
  {{-- <body onload="print()" style="margin-top:0pxfont-size:11px !important"> --}}
    <body onload="print()">
      <div class="box" style="font-size:12px !important">
        <div>No RM : {{ $data->pasien->no_rm }} </div>
        <div>Nama  : {{ strtoupper($data->pasien->nama ) }} </div>
        <div>Tgl.Lahir : {{ tgl_indo($data->pasien->tgllahir) }} </div>
        <div>Alamat  : {{ substr($data->pasien->alamat,0,23) . '..' }} </div>
      </div>
        {{-- <table border=0 style="margin-bottom:30px;font-size:12px">
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
            <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,23) . '..'}}</td>
          </tr>
        </table>

        <table border=0 style="margin-bottom:50px;font-size:12px">
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
            <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,23) . '..'}}</td>
          </tr>
        </table>

        <table border=0 style="margin-bottom:50px;font-size:12px">
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
            <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,23) . '..'}}</td>
          </tr>
        </table><br>

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
            <td style="padding-left:90px">Alamat</td> <td>: {{ substr($data->pasien->alamat,0,23) . '..'}}</td>
          </tr>
        </table> --}}
          <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ URL::previous() }}">
  </body>
</html>

