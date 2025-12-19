<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    $apgar = @json_decode(@$apgarScore->fisik, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>LEMBAR OBSERVASI OBGYN</b></h5>
    @php
        $observasi = @json_decode(@$observasi->keterangan, true);
    @endphp
    <table style="width:100%">
      <tr>
        <td style="width:150px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      
      <tr>
        <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td>
        <td>TANGGAL</td>
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>

      <tr>
        <td>DIAGNOSIS MEDIS</td>
        <td>: {{@$observasi['diagnosis_medis']}}</td>
        <td>DPJP</td>
        <td>: {{@$observasi['dpjp']}}</td>
      </tr>
    </table>
    <table class="border" style="width: 100%;" id="table_terapi">
        <tr class="border">
            <td class="border bold p-1 text-center">TGL</td>
            <td class="border bold p-1 text-center">JAM</td>
            <td class="border bold p-1 text-center">TENSI</td>
            <td class="border bold p-1 text-center">NADI</td>
            <td class="border bold p-1 text-center">RESPIRASI</td>
            <td class="border bold p-1 text-center">SUHU</td>
            <td class="border bold p-1 text-center">TINDAKAN</td>
            <td class="border bold p-1 text-center">NAMA PERAWAT</td>
        </tr>
        @if (isset($observasi['lembar_observasi']))
          @foreach ($observasi['lembar_observasi'] as $key => $obat)
            <tr class="border lembar_observasi">
                <td class="border bold p-1 text-center">
                  {{$obat['tanggal']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['jam']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['tensi']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['nadi']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['respirasi']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['suhu']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['tindakan']}}
                </td>
                <td class="border bold p-1 text-center">
                  {{$obat['nama_perawat']}}
                </td>
            </tr>
          @endforeach
        @endif
    </table>
  </div>
  </body>
</html>