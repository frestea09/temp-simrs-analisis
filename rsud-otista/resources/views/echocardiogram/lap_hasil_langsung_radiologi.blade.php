<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Hasil Radiologi</title>
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
  <body>
    <table style="width: 100%; margin-left: 10px;">
      <tr>
        <td style="width:30%;">
          <img src="{{ public_path('images/logorsud-old.png') }}"style="width: 80px; float: left;">
        </td>
      </tr>
    </table>

    <div class="row">
      <div class="col-sm-12 text-center">
          <h4>{{config('app.nama_rs')}}</h4>
          <h5>UNIT RADIOLOGI</h5>
          <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
          <hr>
          <h5>HASIL PEMERIKSAAN RADIOLOGI</h5>
        <br>
      </div>
        <table style="width: 100%;">
          <tbody class="table table-borderless">
            <tr>
              <td> Nomer</td>
              <td>:</td>
              <td> {{ $radiologi->no_dokument }} </td>

              <td> Tanggal </td>
              <td>:</td>
              <td>  {{  $radiologi->created_at->format('d-m-Y') }} </td>
            </tr>
            <tr>
              <td> Nama </td>
              <td>:</td>
              <td> {{ $radiologi->nama }} </td>

              <td> Alamat </td>
              <td>:</td>
              <td> {{ $radiologi->alamat }} </td>
            </tr>
            {{-- <tr>
              <td> Cara Bayar </td>
              <td>:</td>
              <td> {{ baca_carabayar($d->bayar) }} </td>
            </tr> --}}
            <tr>
                <td> Tanggal Ekpertise </td>
                <td>:</td>
                <td> {{ $radiologi->tanggal_eksp }} </td>
            </tr>
            <tr>
              <td>Dokter </td>
              <td>:</td>
              <td> {{ !empty($radiologi->dokter_id) ? baca_dokter($radiologi->dokter_id) :'' }} </td>
            </tr>
            <tr>
              <td>Klinis </td>
              <td>:</td>
              <td> {{ $radiologi->klinis }} </td>
            </tr>
          </tbody>
        </table>
        <hr>
          {{-- <h5 style="margin-bottom: 0; margin-top: 10px;">Tindakan :
            @foreach ($folio as $item)
              {{ !empty($item->tarif_id) ? baca_tarif($item->tarif_id) : '' }},
            @endforeach
           </h5> --}}
          <h5 style="margin-bottom: 0; margin-top: 10px;">Ekpertise :</h5>
          <div style="border:1px solid gray; padding: 5px; border-radius: 5px; word-wrap: break-word;">
            {!! $radiologi->ekspertise !!}
          </div>
        <div class="text-center" style="padding: 5px; float:right;">
          Radiologist,
          <br>
          <br>
          <br>
          <br>
          <u>{{ !empty($dokter) ? $dokter->nama : '' }}</u><br>
            SIP {{ !empty($dokter) ? $dokter->sip : '' }}
          <hr>
        </div>
    </div>
  </body>
</html>
