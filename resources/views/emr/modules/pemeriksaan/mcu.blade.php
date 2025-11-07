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
</style>
@section('header')
<h1>fisik Fisik</h1>
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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/mcu/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <br>

          <h5 class="text-center"><b>FORMULIR PEMERIKSAAN DAN PENGUJIAN KESEHATAN (MCU)</b></h5>
          <div class="col-md-6">
            <input type="hidden" name="assesment_type" value="perawat">
            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              {{-- <tr>
                <td colspan="2" style="width:100%; font-weight:bold;">Keluhan Utama</td>
              </tr>
                <td colspan="2" style="padding: 5px; width: 100%;">
                  <textarea rows="3" name="fisik[keluhan_utama]" style="display:inline-block; width: 100%;" class="form-control" id="">{{ @$asesmen['anamnesa'] ?? @$assesment['keluhan_utama'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:bold;">Riwayat Penyakit Sebelumnya</td>
                <td style="padding: 5px; width: 50%;">
                  <input type="text" name="fisik[riwayat_penyakit_sebelumnya]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{ @$asesmen['riwayat_penyakit_sebelumnya'] ?? @$assesment['riwayat_penyakit_sebelumnya']  }}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:bold;">Riwayat Penyakit Dahulu</td>
                <td style="padding: 5px; width: 50%;">
                  <input type="text" name="fisik[riwayat_penyakit_dahulu]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{ @$asesmen['riwayat_penyakit_dahulu'] ?? @$assesment['riwayat_penyakit_dahulu']  }}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:bold;">Riwayat Penyakit Keluarga</td>
                <td style="padding: 5px; width: 50%;">
                  <input type="text" name="fisik[riwayat_penyakit_keluarga]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{ @$asesmen['riwayat_penyakit_keluarga'] ?? @$assesment['riwayat_penyakit_keluarga']  }}">
                </td>
              </tr> --}}
              <tr>
                <td colspan="2" style="font-weight: bold;">1. STATUS GENERALIS</td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold;">A. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px; width:50%;">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['tekanan_darah'] ?? @$asesmen['tanda_vital']['tekanan_darah']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi'] ?? @$asesmen['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR'] ?? @$asesmen['tanda_vital']['RR']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp'] ?? @$asesmen['tanda_vital']['temp']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                  <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="bb" value="{{@$assesment['tanda_vital']['BB'] ?? @$asesmen['tanda_vital']['BB']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="tb" value="{{@$assesment['tanda_vital']['TB'] ?? @$asesmen['tanda_vital']['TB']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Lingkar Perut (cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][lingkar_perut]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="bb" value="{{@$assesment['tanda_vital']['lingkar_perut'] ?? @$asesmen['tanda_vital']['lingkar_perut']}}">
                </td>
                <td style="padding: 5px;">
                </td>
              </tr>
              <tr>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">BMI</label><br/>
                  <input type="text" name="fisik[tanda_vital][BMI]" style="display:inline-block; width: 100%;" class="form-control" id="bmiScore" readonly value="{{@$assesment['tanda_vital']['BMI'] ?? @$asesmen['tanda_vital']['BMI'] ?? 0 }}">
                </td>
              </tr>
              <script>
                let bmiInputs = document.getElementsByClassName('bmi-input');
                let bmiScore = document.getElementById('bmiScore');
                bmiInputs = Array.from(bmiInputs);
                bmiInputs.forEach(el => {
                  el.addEventListener('input', function() {
                    let beratBadan = parseFloat(document.getElementById('bb').value);
                    let tinggiBadanCm = parseFloat(document.getElementById('tb').value);
              
                    if (beratBadan > 0 && tinggiBadanCm > 0) {
                      let tinggiBadanM = tinggiBadanCm / 100;
                      let bmi = beratBadan / (tinggiBadanM * tinggiBadanM);
                      
                      bmiScore.value = bmi.toFixed(2);
                    } else {
                      bmiScore.value = '0';
                    }
                  });
                });
              </script>
              <tr>
                <td colspan="2" style="width:100%; font-weight:bold;">Kesadaran</td>
              </tr>
              <tr>
                <td colspan="2">
                  <div style="display: flex; gap: 10px; flex-wrap: wrap">
                    <div>
                      <input type="radio" id="kesadaran1" name="fisik[statusGeneralis][keadaanUmum][kesadaran]" value="Menurun" {{@$assesment['statusGeneralis']['keadaanUmum']['kesadaran'] == 'Menurun' ? 'checked' : ''}}>
                      <label for="kesadaran1" style="font-weight: normal;">Menurun</label><br>
                    </div>
                    <div>
                      <input type="radio" id="kesadaran2" name="fisik[statusGeneralis][keadaanUmum][kesadaran]" value="Terganggu" {{@$assesment['statusGeneralis']['keadaanUmum']['kesadaran'] == 'Terganggu' ? 'checked' : ''}}>
                      <label for="kesadaran2" style="font-weight: normal;">Terganggu</label><br>
                    </div>
                    <div>
                      <input type="radio" id="kesadaran3" name="fisik[statusGeneralis][keadaanUmum][kesadaran]" value="Normal" {{@$assesment['statusGeneralis']['keadaanUmum']['kesadaran'] == 'Normal' ? 'checked' : ''}}>
                      <label for="kesadaran3" style="font-weight: normal;">Normal</label><br>
                    </div>
                  </div>
                </td>
              </tr>
              
              <tr>
                <td colspan="2" style="width:100%; font-weight:bold;">HABITUS</td>
              </tr>
              <tr>
                <td colspan="2">
                  <div style="display: flex; gap: 10px; flex-wrap: wrap">
                    <div>
                      <input type="radio" id="habitus1" name="fisik[statusGeneralis][keadaanUmum][habitus]" value="Piknis" {{@$assesment['statusGeneralis']['keadaanUmum']['habitus'] == 'Piknis' ? 'checked' : ''}}>
                      <label for="habitus1" style="font-weight: normal;">Piknis</label><br>
                    </div>
                    <div>
                      <input type="radio" id="habitus2" name="fisik[statusGeneralis][keadaanUmum][habitus]" value="Asthenis" {{@$assesment['statusGeneralis']['keadaanUmum']['habitus'] == 'Asthenis' ? 'checked' : ''}}>
                      <label for="habitus2" style="font-weight: normal;">Asthenis</label><br>
                    </div>
                    <div>
                      <input type="radio" id="habitus3" name="fisik[statusGeneralis][keadaanUmum][habitus]" value="Athletis" {{@$assesment['statusGeneralis']['keadaanUmum']['habitus'] == 'Athletis' ? 'checked' : ''}}>
                      <label for="habitus3" style="font-weight: normal;">Athletis</label><br>
                    </div>
                  </div>
                </td>
              </tr>
              
              {{-- <tr>
                <td colspan="2" style="width:100%; font-weight:bold;">B. Pemeriksaan Fisik</td>
              </tr>
              <tr>
                @php
                  $pemeriksaanFisik =  @$assesment['pemeriksaan_fisik'] ?? @$asesmen['pemeriksaan_fisik'];
                @endphp
                <td colspan="2" style="padding: 5px; width: 100%;">
                  <textarea rows="5" name="fisik[pemeriksaan_fisik]" style="display:inline-block; width: 100%;" class="form-control" id="">{{ @$pemeriksaanFisik }}</textarea>
                </td>
              </tr> --}}

              <tr>
                <td colspan="2" style="font-weight:bold;">C. Kelainan Kulit</td>
              </tr>
              <tr>
                <td>
                  <input type="radio" id="kelainanKulit_1" name="fisik[statusGeneralis][kelainanKulit][pilihan]" value="Tidak" {{@$assesment['statusGeneralis']['kelainanKulit']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanKulit_1" style="font-weight: normal;">Tidak</label><br>
                </td>
                <td>
                  <input type="radio" id="kelainanKulit_2" name="fisik[statusGeneralis][kelainanKulit][pilihan]" value="Ada" {{@$assesment['statusGeneralis']['kelainanKulit']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanKulit_2" style="font-weight: normal;">Ada</label><br>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">2. STATUS LOKALIS</td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold;">A. Kepala</td>
              </tr>
              <tr>
                {{-- <td>Ukuran Kepala</td>
                <td>
                  <div style="display: flex; gap: 10px; flex-wrap: wrap">
                      <div>
                          <input type="radio" id="kesadaran1" name="fisik[statusLokalis][ukuranKepala][ukuran]" value="Kecil" {{@$assesment['statusLokalis']['ukuranKepala']['ukuran'] == 'Kecil' ? 'checked' : ''}}>
                          <label for="ukuran1" style="font-weight: normal;">Kecil</label><br>
                      </div>
                      <div>
                          <input type="radio" id="ukuran2" name="fisik[statusLokalis][ukuranKepala][ukuran]" value="Sedang" {{@$assesment['statusLokalis']['ukuranKepala']['ukuran'] == 'Sedang' ? 'checked' : ''}}>
                          <label for="ukuran2" style="font-weight: normal;">Sedang</label><br>
                      </div>
                      <div>
                          <input type="radio" id="ukuran3" name="fisik[statusLokalis][ukuranKepala][ukuran]" value="Besar" {{@$assesment['statusLokalis']['ukuranKepala']['ukuran'] == 'Besar' ? 'checked' : ''}}>
                          <label for="ukuran3" style="font-weight: normal;">Besar</label><br>
                      </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Kelainan Mata</td>
                <td>
                  <input type="radio" id="kelainanMata_1" name="fisik[statusLokalis][kelainanMata][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kelainanMata']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanMata_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kelainanMata_2" name="fisik[statusLokalis][kelainanMata][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kelainanMata']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanMata_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][kelainanMata][sebutkan]" value="{{ @$assesment['statusLokalis']['kelainanMata']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Kacamata</td>
                <td>
                  <input type="radio" id="kacamata_1" name="fisik[statusLokalis][kacamata][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kacamata']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kacamata_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kacamata_2" name="fisik[statusLokalis][kacamata][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kacamata']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kacamata_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                </td>
              </tr> --}}
              <tr>
                <td colspan="2">
                  <textarea style="width: 100%;" name="fisik[statusLokalis][kepala]" id="" rows="5">{{ @$assesment['statusLokalis']['kepala'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold;">B. Telinga</td>
              </tr>
              {{-- <tr>
                <td>Percakapan Berbisik (Telinga Kanan) (M)</td>
                <td>
                  <input type="text" name="fisik[statusLokalis][berbisikKanan]" value="{{ @$assesment['statusLokalis']['berbisikKanan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Percakapan Berbisik (Telinga Kiri) (M)</td>
                <td>
                  <input type="text" name="fisik[statusLokalis][berbisikKiri]" value="{{ @$assesment['statusLokalis']['berbisikKiri'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Kelainan</td>
                <td>
                  <input type="radio" id="kelainanTelinga_1" name="fisik[statusLokalis][kelainanTelinga][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kelainanTelinga']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanTelinga_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kelainanTelinga_2" name="fisik[statusLokalis][kelainanTelinga][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kelainanTelinga']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanTelinga_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][kelainanTelinga][sebutkan]" value="{{ @$assesment['statusLokalis']['kelainanTelinga']['sebutkan'] }}" class="form-control">
                </td>
              </tr> --}}
              <tr>
                <td colspan="2">
                  <textarea style="width: 100%;" name="fisik[statusLokalis][telinga]" id="" rows="5">{{ @$assesment['statusLokalis']['telinga'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="font-weight: bold;">C. Hidung</td>
              </tr>
              <tr>
                <td>Kelainan</td>
                <td>
                  <input type="radio" id="kelainanHidung_1" name="fisik[statusLokalis][kelainanHidung][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kelainanHidung']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanHidung_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kelainanHidung_2" name="fisik[statusLokalis][kelainanHidung][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kelainanHidung']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanHidung_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][kelainanHidung][sebutkan]" value="{{ @$assesment['statusLokalis']['kelainanHidung']['sebutkan'] }}" class="form-control">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">D. Kerongkongan</td>
              </tr>
              <tr>
                <td>Kelainan</td>
                <td>
                  <input type="radio" id="kelainanKerongkongan_1" name="fisik[statusLokalis][kelainanKerongkongan][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kelainanKerongkongan']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanKerongkongan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kelainanKerongkongan_2" name="fisik[statusLokalis][kelainanKerongkongan][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kelainanKerongkongan']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanKerongkongan_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][kelainanKerongkongan][sebutkan]" value="{{ @$assesment['statusLokalis']['kelainanKerongkongan']['sebutkan'] }}" class="form-control">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">E. Suara</td>
              </tr>
              <tr>
                <td>Kelainan</td>
                <td>
                  <input type="radio" id="kelainanSuara_1" name="fisik[statusLokalis][kelainanSuara][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['kelainanSuara']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="kelainanSuara_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="kelainanSuara_2" name="fisik[statusLokalis][kelainanSuara][pilihan]" value="Ada" {{@$assesment['statusLokalis']['kelainanSuara']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="kelainanSuara_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][kelainanSuara][sebutkan]" value="{{ @$assesment['statusLokalis']['kelainanSuara']['sebutkan'] }}" class="form-control">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">F. Leher</td>
              </tr>
              <tr>
                <td>Pembesaran Kelenjar</td>
                <td>
                  <input type="radio" id="pembesaranKelenjar_1" name="fisik[statusLokalis][leher][pembesaranKelenjar][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['leher']['pembesaranKelenjar']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="pembesaranKelenjar_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="pembesaranKelenjar_2" name="fisik[statusLokalis][leher][pembesaranKelenjar][pilihan]" value="Ada" {{@$assesment['statusLokalis']['leher']['pembesaranKelenjar']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="pembesaranKelenjar_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                </td>
              </tr>
              <tr>
                <td>Pembesaran Vena Jugularis</td>
                <td>
                  <input type="radio" id="pembesaranVenaJugularis_1" name="fisik[statusLokalis][leher][pembesaranVenaJugularis][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['leher']['pembesaranVenaJugularis']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="pembesaranVenaJugularis_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="pembesaranVenaJugularis_2" name="fisik[statusLokalis][leher][pembesaranVenaJugularis][pilihan]" value="Ada" {{@$assesment['statusLokalis']['leher']['pembesaranVenaJugularis']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="pembesaranVenaJugularis_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">G. Dada</td>
              </tr>
              <tr>
                <td>Bentuk dan Gerak Paru-Paru</td>
                <td>
                  <input type="radio" id="bentukParu_1" name="fisik[statusLokalis][dada][bentukParu][pilihan]" value="Simetris" {{@$assesment['statusLokalis']['dada']['bentukParu']['pilihan'] == 'Simetris' ? 'checked' : ''}}>
                  <label for="bentukParu_1" style="font-weight: normal; margin-right: 10px;">Simetris</label>

                  <input type="radio" id="bentukParu_2" name="fisik[statusLokalis][dada][bentukParu][pilihan]" value="Asimetris" {{@$assesment['statusLokalis']['dada']['bentukParu']['pilihan'] == 'Asimetris' ? 'checked' : ''}}>
                  <label for="bentukParu_2" style="font-weight: normal; margin-right: 10px;">Asimetris</label>

                  <input type="radio" id="bentukParu_3" name="fisik[statusLokalis][dada][bentukParu][pilihan]" value="Tertentu" {{@$assesment['statusLokalis']['dada']['bentukParu']['pilihan'] == 'Tertentu' ? 'checked' : ''}}>
                  <label for="bentukParu_3" style="font-weight: normal; margin-right: 10px;">Tertentu</label><br>
                </td>
              </tr>

              <tr>
                <td>Periksa Raba (Palpasi)</td>
                <td>
                  <input type="radio" id="palpasi_1" name="fisik[statusLokalis][dada][palpasi][pilihan]" value="Ada" {{@$assesment['statusLokalis']['dada']['palpasi']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="palpasi_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="palpasi_2" name="fisik[statusLokalis][dada][palpasi][pilihan]" value="Tidak Ada Kelainan" {{@$assesment['statusLokalis']['dada']['palpasi']['pilihan'] == 'Tidak Ada Kelainan' ? 'checked' : ''}}>
                  <label for="palpasi_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada Kelainan</label><br>
                </td>
              </tr>

              <tr>
                <td>Periksa Ketok (Perkusi)</td>
                <td>
                  <input type="radio" id="perkusi_1" name="fisik[statusLokalis][dada][perkusi][pilihan]" value="Sonor" {{@$assesment['statusLokalis']['dada']['perkusi']['pilihan'] == 'Sonor' ? 'checked' : ''}}>
                  <label for="perkusi_1" style="font-weight: normal; margin-right: 10px;">Sonor</label>

                  <input type="radio" id="perkusi_2" name="fisik[statusLokalis][dada][perkusi][pilihan]" value="Hypersonor" {{@$assesment['statusLokalis']['dada']['perkusi']['pilihan'] == 'Hypersonor' ? 'checked' : ''}}>
                  <label for="perkusi_2" style="font-weight: normal; margin-right: 10px;">Hypersonor</label>

                  <input type="radio" id="perkusi_3" name="fisik[statusLokalis][dada][perkusi][pilihan]" value="Redup Pekak" {{@$assesment['statusLokalis']['dada']['perkusi']['pilihan'] == 'Redup Pekak' ? 'checked' : ''}}>
                  <label for="perkusi_3" style="font-weight: normal; margin-right: 10px;">Redup Pekak</label><br>
                </td>
              </tr>

              <tr>
                <td>Bising Nafas</td>
                <td>
                  <input type="radio" id="bisingNafas_1" name="fisik[statusLokalis][dada][bisingNafas][pilihan]" value="Vesiculer" {{@$assesment['statusLokalis']['dada']['bisingNafas']['pilihan'] == 'Vesiculer' ? 'checked' : ''}}>
                  <label for="bisingNafas_1" style="font-weight: normal; margin-right: 10px;">Vesiculer</label>

                  <input type="radio" id="bisingNafas_2" name="fisik[statusLokalis][dada][bisingNafas][pilihan]" value="Sub Bronchial / Bronchial" {{@$assesment['statusLokalis']['dada']['bisingNafas']['pilihan'] == 'Sub Bronchial / Bronchial' ? 'checked' : ''}}>
                  <label for="bisingNafas_2" style="font-weight: normal; margin-right: 10px;">Sub Bronchial / Bronchial</label><br>
                </td>
              </tr>

              <tr>
                <td>Ronchi Basah</td>
                <td>
                  <input type="radio" id="ronchiBasah_1" name="fisik[statusLokalis][dada][ronchiBasah][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['dada']['ronchiBasah']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="ronchiBasah_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>

                  <input type="radio" id="ronchiBasah_2" name="fisik[statusLokalis][dada][ronchiBasah][pilihan]" value="Ada" {{@$assesment['statusLokalis']['dada']['ronchiBasah']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="ronchiBasah_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][dada][ronchiBasah][sebutkan]" value="{{ @$assesment['statusLokalis']['dada']['ronchiBasah']['sebutkan'] }}" class="form-control">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">H. Jantung</td>
              </tr>
              <tr>
                <td>Iclus Cordis</td>
                <td>
                  <input type="radio" id="iclusCordis_1" name="fisik[statusLokalis][jantung][iclusCordis][pilihan]" value="Normal" {{@$assesment['statusLokalis']['jantung']['iclusCordis']['pilihan'] == 'Normal' ? 'checked' : ''}}>
                  <label for="iclusCordis_1" style="font-weight: normal; margin-right: 10px;">Normal</label>

                  <input type="radio" id="iclusCordis_2" name="fisik[statusLokalis][jantung][iclusCordis][pilihan]" value="Tidak Normal" {{@$assesment['statusLokalis']['jantung']['iclusCordis']['pilihan'] == 'Tidak Normal' ? 'checked' : ''}}>
                  <label for="iclusCordis_2" style="font-weight: normal; margin-right: 10px;">Tidak Normal</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][iclusCordis][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['iclusCordis']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Periksa Raba (Thrill)</td>
                <td>
                  <input type="radio" id="periksaRaba_1" name="fisik[statusLokalis][jantung][periksaRaba][pilihan]" value="Ada" {{@$assesment['statusLokalis']['jantung']['periksaRaba']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="periksaRaba_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="periksaRaba_2" name="fisik[statusLokalis][jantung][periksaRaba][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['jantung']['periksaRaba']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="periksaRaba_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][periksaRaba][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['periksaRaba']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Periksa Ketok</td>
                <td>
                  <input type="radio" id="periksaKetok_1" name="fisik[statusLokalis][jantung][periksaKetok][pilihan]" value="Ada" {{@$assesment['statusLokalis']['jantung']['periksaKetok']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="periksaKetok_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="periksaKetok_2" name="fisik[statusLokalis][jantung][periksaKetok][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['jantung']['periksaKetok']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="periksaKetok_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][periksaKetok][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['periksaKetok']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Periksa Dengar</td>
                <td>
                  <input type="radio" id="periksaDengar_1" name="fisik[statusLokalis][jantung][periksaDengar][pilihan]" value="Ada" {{@$assesment['statusLokalis']['jantung']['periksaDengar']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="periksaDengar_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="periksaDengar_2" name="fisik[statusLokalis][jantung][periksaDengar][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['jantung']['periksaDengar']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="periksaDengar_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][periksaDengar][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['periksaDengar']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Tambahan Bunyi Dasar</td>
                <td>
                  <input type="radio" id="bunyiDasar_1" name="fisik[statusLokalis][jantung][bunyiDasar][pilihan]" value="Ada" {{@$assesment['statusLokalis']['jantung']['bunyiDasar']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="bunyiDasar_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="bunyiDasar_2" name="fisik[statusLokalis][jantung][bunyiDasar][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['jantung']['bunyiDasar']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="bunyiDasar_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][bunyiDasar][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['bunyiDasar']['sebutkan'] }}" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Bising Jantung</td>
                <td>
                  <input type="radio" id="bisingJantung_1" name="fisik[statusLokalis][jantung][bisingJantung][pilihan]" value="Ada" {{@$assesment['statusLokalis']['jantung']['bisingJantung']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                  <label for="bisingJantung_1" style="font-weight: normal; margin-right: 10px;">Ada</label>

                  <input type="radio" id="bisingJantung_2" name="fisik[statusLokalis][jantung][bisingJantung][pilihan]" value="Tidak Ada" {{@$assesment['statusLokalis']['jantung']['bisingJantung']['pilihan'] == 'Tidak Ada' ? 'checked' : ''}}>
                  <label for="bisingJantung_2" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][jantung][bisingJantung][sebutkan]" value="{{ @$assesment['statusLokalis']['jantung']['bisingJantung']['sebutkan'] }}" class="form-control">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">I. Gigi dan Mulut</td>
              </tr>

              <tr>
                <td>Gigi</td>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td>8 7 6 5 4 3 2 1</td>
                      <td>:</td>
                      <td style="text-align: end;">1 2 3 4 5 6 7 8 </td>
                    </tr>
                    <tr>
                      <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                      <td>8 7 6 5 4 3 2 1</td>
                      <td>:</td>
                      <td style="text-align: end;">1 2 3 4 5 6 7 8 </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td style="text-align: end;">
                        <br><br>
                        <span style="font-weight: bold;">D: Berlubang</span> <br>
                        <span style="font-weight: bold;">M: Tanggul</span> <br>
                        <span style="font-weight: bold;">F: Sudah Ditambal</span> <br>
                      </td>
                    </tr>
                    <tr>
                      <td><b>D (Berlubang)</b></td>
                      <td colspan="2">
                        <br>
                          <textarea style="width: 100%;" name="fisik[statusLokalis][gigi_mulut][d]" id="" cols="30" rows="10">{{ @$assesment['statusLokalis']['gigi_mulut']['d'] }}</textarea>
                      </td>
                    </tr>
                    <tr>
                      <td><b>M (Tanggul)</b></td>
                      <td colspan="2">
                        <br>
                          <textarea style="width: 100%;" name="fisik[statusLokalis][gigi_mulut][m]" id="" cols="30" rows="10">{{ @$assesment['statusLokalis']['gigi_mulut']['m'] }}</textarea>
                      </td>
                    </tr>
                    <tr>
                      <td><b>F (Sudah Ditambal)</b></td>
                      <td colspan="2">
                        <br>
                          <textarea style="width: 100%;" name="fisik[statusLokalis][gigi_mulut][f]" id="" cols="30" rows="10">{{ @$assesment['statusLokalis']['gigi_mulut']['f'] }}</textarea>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Pemeriksaan Penunjang</td>
                <td>
                  <input type="text" name="fisik[penunjang]" value="{{ @$assesment['penunjang'] }}" class="form-control"></input>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: top">Kesimpulan</td>
                <td style="padding: 5px;">
                  <div>
                    <input type="radio" id="kesimpulan1" name="fisik[kesimpulan]" value="Sehat" {{ @$assesment['kesimpulan'] == 'Sehat' ? 'checked' : '' }}>
                    <label style="font-weight: normal;">Sehat</label>
                  </div>
                  <div>
                    <input type="radio" id="kesimpulan2" name="fisik[kesimpulan]" value="Tidak Sehat" {{ @$assesment['kesimpulan'] == 'Tidak Sehat' ? 'checked' : '' }}>
                    <label style="font-weight: normal;">Tidak Sehat</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Catatan</td>
                <td>
                  <textarea name="fisik[catatan]" class="form-control" rows="5">{{ @$assesment['catatan'] }}</textarea>
                </td>
              </tr>
              
              <tr>
                <td colspan="2" style="font-weight: bold;">3. ABDOMEN</td>
              </tr>

              <tr>
                <td>Inspeksi</td>
                <td>
                  <input type="radio" id="inspeksi_1" name="fisik[statusLokalis][abdomen][inspeksi][pilihan]" value="Cembung" {{@$assesment['statusLokalis']['abdomen']['inspeksi']['pilihan'] == 'Cembung' ? 'checked' : ''}}>
                  <label for="inspeksi_1" style="font-weight: normal; margin-right: 10px;">Cembung</label>

                  <input type="radio" id="inspeksi_2" name="fisik[statusLokalis][abdomen][inspeksi][pilihan]" value="Datar" {{@$assesment['statusLokalis']['abdomen']['inspeksi']['pilihan'] == 'Datar' ? 'checked' : ''}}>
                  <label for="inspeksi_2" style="font-weight: normal; margin-right: 10px;">Datar</label>

                  <input type="radio" id="inspeksi_3" name="fisik[statusLokalis][abdomen][inspeksi][pilihan]" value="Cekung" {{@$assesment['statusLokalis']['abdomen']['inspeksi']['pilihan'] == 'Cekung' ? 'checked' : ''}}>
                  <label for="inspeksi_3" style="font-weight: normal; margin-right: 10px;">Cekung</label><br>
                </td>
              </tr>
              <tr>
                <td>Palpasi</td>
                <td>
                  <input type="radio" id="abdomenPalpasi_1" name="fisik[statusLokalis][abdomen][palpasi][pilihan]" value="Lemas" {{@$assesment['statusLokalis']['abdomen']['palpasi']['pilihan'] == 'Lemas' ? 'checked' : ''}}>
                  <label for="abdomenPalpasi_1" style="font-weight: normal; margin-right: 10px;">Lemas</label>

                  <input type="radio" id="abdomenPalpasi_2" name="fisik[statusLokalis][abdomen][palpasi][pilihan]" value="Tegang" {{@$assesment['statusLokalis']['abdomen']['palpasi']['pilihan'] == 'Tegang' ? 'checked' : ''}}>
                  <label for="abdomenPalpasi_2" style="font-weight: normal; margin-right: 10px;">Tegang</label><br>
                </td>
              </tr>

              <tr>
                <td>Nyeri Tekan</td>
                <td>
                  <input type="radio" id="nyeriTekan_1" name="fisik[statusLokalis][abdomen][nyeriTekan][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['abdomen']['nyeriTekan']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="nyeriTekan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="nyeriTekan_2" name="fisik[statusLokalis][abdomen][nyeriTekan][pilihan]" value="Ada, Lokasi Pada" {{@$assesment['statusLokalis']['abdomen']['nyeriTekan']['pilihan'] == 'Ada, Lokasi Pada' ? 'checked' : ''}}>
                  <label for="nyeriTekan_2" style="font-weight: normal; margin-right: 10px;">Ada, Lokasi Pada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][abdomen][nyeriTekan][lokasi]" value="{{ @$assesment['statusLokalis']['abdomen']['nyeriTekan']['lokasi'] }}" class="form-control">
                </td>
              </tr>

              {{-- <tr>
                <td>Hernia</td>
                <td>
                  <input type="radio" id="hernia_1" name="fisik[statusLokalis][abdomen][hernia][pilihan]" value="Tidak" {{@$assesment['statusLokalis']['abdomen']['hernia']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="hernia_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                  <input type="radio" id="hernia_2" name="fisik[statusLokalis][abdomen][hernia][pilihan]" value="Ada, Lokasi Pada" {{@$assesment['statusLokalis']['abdomen']['hernia']['pilihan'] == 'Ada, Lokasi Pada' ? 'checked' : ''}}>
                  <label for="hernia_2" style="font-weight: normal; margin-right: 10px;">Ada, Lokasi Pada</label><br>
                  <br>
                  <input type="text" name="fisik[statusLokalis][abdomen][hernia][lokasi]" value="{{ @$assesment['statusLokalis']['abdomen']['hernia']['lokasi'] }}" class="form-control">
                </td>
              </tr> --}}
              
              <tr>
                <td colspan="2" style="font-weight: bold;">4. EKSTREMITAS ATAS</td>
              </tr>
              <tr>
                <td colspan="2"> 
                  <textarea rows="3" name="fisik[ekstremitas_atas]" style="display:inline-block; width: 100%;" class="form-control" id="">{{ @$assesment['ekstremitas_atas'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight: bold;">5. EKSTREMITAS BAWAH</td>
              </tr>
              <tr>
                <td colspan="2"> 
                  <textarea rows="3" name="fisik[ekstremitas_bawah]" style="display:inline-block; width: 100%;" class="form-control" id="">{{ @$assesment['ekstremitas_bawah'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2"><b>Status Lokalis :</b>
              </tr>
              <tr>
                  <td colspan="2" style="padding: 5px;">
                    <textarea rows="3" name="fisik[keterangan_status_lokalis]" style="display:inline-block; resize: vertical;" placeholder="Keterangan Status Lokalis" class="form-control" >{{ @$asesmen['keterangan_status_lokalis'] ?? @$assesment['keterangan_status_lokalis'] }}</textarea>
                  </td>
              </tr>
            </table>
            <div style="text-align: right;">
              <button class="btn btn-success">Simpan</button>
            </div>
            
            </form>

          </div>

          <div class="col-md-6">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  <th class="text-center" style="vertical-align: middle;">TTE</th>
                </tr>
              </thead>
            <tbody>
              
              @if (count($riwayats_perawat) == 0)
                  <tr>
                      <td colspan="4" class="text-center">Tidak Ada Riwayat Pemeriksaan</td>
                  </tr>
              @endif
              @foreach ($riwayats_perawat as $riwayat)
                  <tr>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                      </td>
                     
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="{{ url("emr-soap-print/cetak-mcu/".$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                          <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                            <i class="fa fa-trash"></i>
                          </a>
                      </td>
                      <td style="text-align: center;">
                          <button type="button" class="btn btn-danger btn-sm btn-flat proses-tte-mcu" data-registrasi-id="{{@$riwayat->registrasi->id}}" data-mcu-id="{{@$riwayat->id}}">
                            <i class="fa fa-pencil"></i>
                          </button>
                          @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                              <a href="{{ url('cetak-tte-mcu/pdf/'. $riwayat->registrasi->id . '/' . @$riwayat->id) }}"
                                  target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                      class="fa fa-download"></i> </a>
                          @elseif (!empty($riwayat->tte))
                            <a href="{{ url('/dokumen_tte/'. @$riwayat->tte) }}"
                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                    class="fa fa-download"></i> </a>
                          @endif
                      </td>
                  </tr>
                  <tr>
                    <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                      <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                    </td>
                  </tr>
              @endforeach
             
            </tbody>
          </table>
          </div>
          

          <br /><br />
        </div>
      </div>
      
    {{-- </form> --}}

  </div>

  <!-- Modal TTE MCU-->
  <div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <form id="form-tte-mcu" action="{{ url('tte-pdf-mcu') }}" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE MCU</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
            <input type="hidden" class="form-control" name="mcu_id" id="mcu_id" disabled>
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-mcu">Proses TTE</button>
        </div>
      </div>
      </form>

    </div>
  </div>

  @endsection

  @section('script')


  <script type="text/javascript">
  $('.dates').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd/mm/yyyy",
            autoclose: true
            // viewMode: "months", 
            // minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
  
  // TTE MCU
  $('.proses-tte-mcu').click(function () {
      $('#registrasi_id_hidden3').val($(this).data("registrasi-id"));
      $('#mcu_id').val($(this).data("mcu-id"));
      $('#myModal3').modal('show');
  })

  $('#form-tte-mcu').submit(function (e) {
      e.preventDefault();
      $('input').prop('disabled', false);
      $('#form-tte-mcu')[0].submit();
  })
  </script>
  @endsection