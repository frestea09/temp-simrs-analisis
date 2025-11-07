@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }

  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  #myImg:hover {opacity: 0.7;}
  
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  
  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  
  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }
  
  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }
  
  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }
  
  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }
  
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }
  
  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  .select2-selection__rendered{
    padding-left: 20px !important;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  .border {
      border: 1px solid black;
  }

  .bold {
      font-weight: bold;
  }

  .p-1 {
      padding: 1rem;
  }
</style>
@section('header')
<h1>Ballard Score</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/ballard_score/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('poli_id', $poli) !!}
          {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          {!! Form::hidden('pelaksana', $reg->dokter_id) !!}
          {!! Form::hidden('tanggal', Carbon\Carbon::now()->format('d-m-Y')) !!}
          {!! Form::hidden('jumlah', 1) !!}
          <br>
            @php
              $ballardScore = @json_decode(@$ballardScore->fisik, true);
              $param = [
                "kulit" => [
                  "nama" => "KULIT",
                  "nilai" => [
                    "_2" => null,
                    "_1" => "Lengket friable transparan",
                    "0" => "Gelantinus merah translusen",
                    "1" => "Merah halus, tampak gambaran vena",
                    "2" => "Permukaan terkelupas dan atau ruam tampak vena",
                    "3" => "Pecah-pecah daerah gundul, ena sangat sedikit",
                    "4" => "Perkamen terbelah dalam, tak terlihat vena",
                    "5" => "Seperti kulit, pecah-pecah berkeriput",
                  ]
                ],
                "lanugo" => [
                  "nama" => "LANUGO",
                  "nilai" => [
                    "_2" => null,
                    "_1" => "Tidak ada",
                    "0" => "Jarang",
                    "1" => "Banyak",
                    "2" => "Halus",
                    "3" => "Daerah kebotakan",
                    "4" => "Umumnya tanpa lanugo",
                    "5" => null,
                  ]
                ],
                "permukaan_plantar" => [
                  "nama" => "PERMUKAAN PLANTAR",
                  "nilai" => [
                    "_2" => "Tumit-ibu jari kaki < 40mm",
                    "_1" => "Tumit-ibu jari kaki 40-50mm",
                    "0" => ">50mm tanpa garis kaki",
                    "1" => "Faint bercak kemerahan",
                    "2" => "Garis kaki hanya di anterior",
                    "3" => "Garis kaki sampai 2/3 anterior",
                    "4" => "Garis kaki diseluruh telapak kaki",
                    "5" => null,
                  ]
                ],
                "payudara" => [
                  "nama" => "PAYUDARA",
                  "nilai" => [
                    "_2" => null,
                    "_1" => "Imperceptible",
                    "0" => "Sedikit perceptible",
                    "1" => "Aerola rata, tanpa bantalan",
                    "2" => "Aerola agak menonjol, bantalan 1-2mm",
                    "3" => "Aerola menonjol, bantalan 3-4mm",
                    "4" => "Aerola sangat menonjol, bantalan 5-10mm",
                    "5" => null,
                  ]
                ],
                "mata_telinga" => [
                  "nama" => "MATA/TELINGA",
                  "nilai" => [
                    "_2" => "Kelopak menyatu erat",
                    "_1" => "Kelopak menyatu longgar",
                    "0" => "Kelopak terbuka, pina datar, tetap terlipat",
                    "1" => "Pinna sedikit bergelombang, rekoil lambat",
                    "2" => "Pinna bergelombang baik, lambek tapi siap rekoil",
                    "3" => "Kekerasan dan berbentuk segera rekoil",
                    "4" => "Kartilago tebel, daun telinga kaku",
                    "5" => null,
                  ]
                ],
                "genital" => [
                  "nama" => "GENITAL(PRIA)",
                  "nilai" => [
                    "_2" => null,
                    "_1" => "Skrotum datar dan halus",
                    "0" => "Skrotum kosong, rugae samar",
                    "1" => "Testis di kanal bagian atas, rugae jarang",
                    "2" => "Testis menuju kebawah sedikit rugae",
                    "3" => "Testis sudah turun, rugae jelas",
                    "4" => "Testis tergantung rugae dalam",
                    "5" => null,
                  ]
                ],
                "genitalia" => [
                  "nama" => "GENITALIA(WANITA)",
                  "nilai" => [
                    "_2" => null,
                    "_1" => "Klitoris menonjol, labia rata",
                    "0" => "Klitoris menonjol, labia minora kecil",
                    "1" => "Klitoris menonjol, labia minora membesar",
                    "2" => "Labia mayora dan minora menonjol",
                    "3" => "Labia mayora besar, labia minora kecil",
                    "4" => "Labia mayora menutupi klitoris dan labia minora",
                    "5" => null,
                  ]
                ],
              ]
            @endphp
            <div class="col-md-12">
              <h5 class="text-center"><b>NEW BALLARD SCORE</b></h5>
              <table class="border" style="width: 100%;">
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Parameter</td>
                    <td class="border bold p-1 text-center">Informasi Nilai</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">Nilai</td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Sikap tubuh</td>
                    <td rowspan="6">
                      <img style="width: 100%" src="{{asset('images/ballard_score.png')}}" alt="">
                    </td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][sikap_tubuh][nilai]" value="{{@$ballardScore['ballard_score']['sikap_tubuh']['nilai']}}">
                    </td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Persegi jendela (pergelangan tangan)</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][persegi_jendela][nilai]" value="{{@$ballardScore['ballard_score']['persegi_jendela']['nilai']}}">
                    </td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Rekoli lengan</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][rekoli_lengan][nilai]" value="{{@$ballardScore['ballard_score']['rekoli_lengan']['nilai']}}">
                    </td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Sudut popliteal</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][sudut_popliteal][nilai]" value="{{@$ballardScore['ballard_score']['sudut_popliteal']['nilai']}}">
                    </td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Tanda selempang</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][tanda_selempang][nilai]" value="{{@$ballardScore['ballard_score']['tanda_selempang']['nilai']}}">
                    </td>
                </tr>
                <tr class="border">
                    <td style="width: 25%" class="border bold p-1 text-center">Tumit ke kuping</td>
                    <td style="width: 10%;" class="border bold p-1 text-center">
                      <input type="text" class="form-control" name="fisik[ballard_score][tumit_ke_kuping][nilai]" value="{{@$ballardScore['ballard_score']['tumit_ke_kuping']['nilai']}}">
                    </td>
                </tr>
              </table>

              <table class="border" style="width: 100%; margin-top: 3rem;">
                <tr class="border">
                    <td class="border bold p-1 text-center">&nbsp;</td>
                    <td class="border bold p-1 text-center">-2</td>
                    <td class="border bold p-1 text-center">-1</td>
                    <td class="border bold p-1 text-center">0</td>
                    <td class="border bold p-1 text-center">1</td>
                    <td class="border bold p-1 text-center">2</td>
                    <td class="border bold p-1 text-center">3</td>
                    <td class="border bold p-1 text-center">4</td>
                    <td class="border bold p-1 text-center">5</td>
                    <td class="border bold p-1 text-center">Nilai</td>
                </tr>
                @foreach ($param as $key => $score)
                  <tr class="border">
                      <td class="border p-1 text-center bold" style="width: 10%;">{{$score['nama']}}</td>
                      @foreach ($score['nilai'] as $nilai)
                        <td class="border p-1 text-center bold" style="width: 10%;">{{$nilai}}</td>
                      @endforeach
                      <td class="border bold p-1 text-center" style="width: 10%;">
                        <input type="text" name="fisik[{{$key}}][nilai]" value="{{@$ballardScore[$key]['nilai']}}" class="form-control" />
                      </td>
                  </tr>
                @endforeach
              </table>
              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-12">
                    {!! Form::submit(empty($ballardScore) ? "Simpan Ballard Score" : "Perbarui Ballard Score", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                </div>
                <br>
                @if ($ballardScore)
                  <div class="col-sm-12">
                    <a href="{{url('emr-soap/pemeriksaan/cetak_ballard_score') . '/' . $reg->id}}" class="btn btn-warning btn-flat btn-sm">Cetak</a>
                  </div>
                @endif
              </div> 
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
@endsection
        