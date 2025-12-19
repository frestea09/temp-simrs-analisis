<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Tracer</title>
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

      ul, li{
        line-height: 175%;
      } 
    </style>
  </head>
  <body onload="print()" style="margin:0;">
  {{-- <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <h5 class="text-center" style="font-weight: bold; font-size: 30pt;">
            {{ strtoupper(configrs()->nama) }} <br> {{ strtoupper(configrs()->alamat) }} <br/>
          </h5> --}}
          <hr>
          <h5 class="text-center" style="font-weight: bold; font-size: 15pt;">
            {{-- ANTRIAN POLI --}}
            TRACER
          </h5>
          <table class="table table-condensed table-borderless" style="width:70%; margin:auto; font-size:15pt;">
            <tr>
              <td>Tanggal / Jam</td> <td>: {{ $data->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
           {{-- <tr>
              <td>No. Pendaftaran</td> <td>: {{ $data->reg_id }}</td>
            </tr>--}}
            <tr>
              <td>No. Rekam Medis</td> <td>: {{ $data->pasien->no_rm }}</td>
            </tr>
            {{--<tr>
              <td>Cara Bayar</td> <td>: {{ baca_carabayar($data->bayar) }} {{ !empty($data->tipe_jkn) ? $data->tipe_jkn : '' }}</td>
            </tr>--}}
            <tr>
              <td>Nama Pasien</td> <td>: {{ $data->pasien->nama }}</td>
            </tr>
            {{--<tr>
              <td>Umur</td> <td>: {{ hitung_umur($data->pasien->tgllahir) }}</td>
            </tr>--}}
            <tr>
              <td>Klinik Tujuan</td> <td>: {{ !empty($data->poli_id) ? $data->poli->nama : NULL }}</td>
            </tr>
            <tr>
              <td>Dokter</td> <td>: {{ baca_dokter($data->dokter_id)}}</td>
            </tr>
            @if (satusehat())
            <tr>
              <td>Id Encounter Satu Sehat</td> <td>: {{ @$data->id_encounter_ss}}</td>
            </tr>
                
            @endif
            {{-- <tr>
              <td>Antrian</td> <td>: 
                @if (@$data->antrian_poli_id)
                  {{ \App\AntrianPoli::where('id',@$data->antrian_poli_id)->first()->kelompok }}{{ @\App\AntrianPoli::where('id',@$data->antrian_poli_id)->first()->nomor }} 
                @endif
              </td>
            </tr> --}}
          </table>

          {{-- <h5 class="text-center" style="font-weight: bold; font-size: 10pt;">
            Nomor Antrian Poli Anda :
          </h5> --}}
          {{-- <h5 class="text-center" style="font-weight: bold; font-size: 30pt;"> --}}
          {{-- <h5 class="text-center" style="font-weight: bold; font-size: 40pt;">
            @if (@$data->antrian_poli_id)
            <b>{{ \App\AntrianPoli::where('id',@$data->antrian_poli_id)->first()->kelompok }}{{ @\App\AntrianPoli::where('id',@$data->antrian_poli_id)->first()->nomor }} </b>
           @endif

          </h5> --}}


        </div>
      </div>
    </div>

    <META HTTP-EQUIV="REFRESH" CONTENT="2; URL={{ URL::previous() }}">

  </body>
</html>
