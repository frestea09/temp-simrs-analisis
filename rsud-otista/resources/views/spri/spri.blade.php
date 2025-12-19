<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Perintah Rawat Inap</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
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
  @foreach ($spri as $d)
    <body>
      <table style="width: 100%; margin-left: 10px;">
        <tr>
          <td style="width:30%;">
            <img src="{{ public_path('images/logorsud-old.png') }}"style="width: 60px; float: left;">
          </td>
        </tr>
      </table>

      <div class="row">
        <div class="col-sm-12 text-center">
          <h4>{{config('app.nama_rs')}}</h4>
          <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
          <hr>
          <h5>SURAT PENGANTAR RAWAT INAP</h5>
        <br>
      </div>
      <div class="row">
        <div class="col-sm-12 text-left">
          <h5>INSTALASI GAWAT DARURAT / POLIKLINIK</h5>
          <p>
            Kepada  Yth.<br>
            Unit Admission<br>
            di-<br>
            Tempat
          </p>
        <br>
      </div>
          <table style="width: 100%;">
            <tbody class="table table-borderless">
            <tr>
                <td> <b>No. SPRI BPJS Kesehatan</b> </td>
                <td>:</td>
                <td> {{ @$d->no_spri }} </td>
            </tr>
            <tr>
                <td> Nama </td>
                <td>:</td>
                <td> {{ $d->nama }} </td>
            </tr>
            <tr>
                <td> Jenis Klamin / Umur</td>
                <td>:</td>
                <td> {{ $d->kelamin }} / {{ hitung_umur($d->tgllahir) }}</td>
            </tr>
            <tr>
                <td> Alamat </td>
                <td>:</td>
                <td> {{ $d->alamat }} </td>
            </tr>
            <tr>
                <td> Nomer RM </td>
                <td>:</td>
                <td> {{ $d->no_rm }} </td>
            </tr>
            <tr>
                <td> Diagnosa </td>
                <td>:</td>
                <td> {!! $d->diagnosa !!} </td>
            </tr>
            <tr>
                <td> Dokter Yang Merawat </td>
                <td>:</td>
                <td> {{ baca_dokter($d->dokter_rawat) }} </td>
            </tr>
            <tr>
                <td> Dokter Pengirim </td>
                <td>:</td>
                <td> {{ baca_dokter($d->dokter_pengirim) }} </td>
            </tr>
            <tr>
                <td> Pasien Memerlukan Kamar Perawatan </td>
                <td>:</td>
                <td> {{ $d->jenis_kamar }} </td>
            </tr>
            <tr>
                <td> Penjamin Pasien Selama Perawatan </td>
                <td>:</td>
                <td> {{ baca_carabayar($d->carabayar) }} </td>
            </tr>
            </tbody>
          </table>
          <br>
          <br>
        <div class="text-center" style="padding: 5px; float:right;">
          Palopo, {{ date('d-m-Y') }}
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <u>()</u><br>
          <hr>
        </div>
      </div>
    </body>
  @endforeach
</html>
