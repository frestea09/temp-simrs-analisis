<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 8.5cm;
          margin-right: 0cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }

    </style>

  </head>
  <body>
    <div class="row">
      <div class="col-sm-12">
        <br><br><br><br><br><br>
        <p style="font-size:16px; margin-left: 11cm;">
        {{ $pasien->no_rm }}</p>
        <p style="margin-top: 0.9cm;">
        {{ $pasien->nama }}
        &nbsp; NO RM {{ $pasien->no_rm }}
         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ Modules\Pasien\Entities\Agama::find($pasien->agama_id)->agama }}<br>
        </p>
        <p style="margin-bottom: 0.3cm;">
        {{ $pasien->tmplahir }}, {{ tgl_indo($pasien->tgllahir) }}
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $pasien->no_jkn }}
        </p>
        <p style="margin-bottom: 0.3cm;">
        {{ $pasien->tmplahir }}, {{ tgl_indo($pasien->tgllahir) }}
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $pasien->no_jkn }}
        </p>
         <p style="margin-bottom: 0.3cm;">
        {{ Modules\Pekerjaan\Entities\Pekerjaan::find($pasien->pekerjaan_id)->pekerjaan }}<br>
        </p>
         <p style="margin-bottom: 0.3cm;">
        {{ $pasien->alamat }}<br> RT {{ $pasien->rt }} RW {{ $pasien->rw }}<br>
        </p>
        <p style="margin-bottom: 0.3cm;">
        {{ $pasien->nohp }}<br>
        </p>
      </div>
    </div>
  </body>
</html>

