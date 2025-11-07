<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="print">
    @page {
          width: 9.5cm;
          height: 5cm;
          margin-left: 0.1cm;
          margin-top: 0.1cm;
      }
      .box{
        /*border: 1px solid red;*/
        width: 9cm;
        padding: 2cm 1cm 0.5cm 0.5cm;
        height: 2.5cm;
        margin: 0.2cm;
        margin-bottom: 0.3cm;
      }
    </style>

  </head>
  <body onload="print()">
      <div class="box">
        <div style="font-weight:bold; font-weight: 16pt;" class="text-right"> {{ strtoupper($pasien->nama) }} </div>
        <div class="text-right"><b>{{ no_rm($pasien->no_rm) }}</div>
        <div class="text-right">{{ hitung_umur($pasien->tgllahir) }}</div>
        <div class="text-right">
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($pasien->no_rm, "C128",1,24,array(1,1,1), true) }}" alt="">
        </div>
      </div>
      <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ url('frontoffice/cetak') }}">
  </body>
</html>
