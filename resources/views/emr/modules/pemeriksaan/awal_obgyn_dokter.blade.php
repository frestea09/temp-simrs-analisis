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
<h1>Asesmen</h1>
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
    {{-- <form method="POST" action="{{ url('emr-soap/pemeriksaan/obgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal"> --}}
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

          {{-- <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>Anamnesis</b></h5>
              <tr>
                <td style="width: 50%; font-weight: bold;">Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[keluhanUtama]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Keluhan Utama]" class="form-control" >{{@$assesment['keluhanUtama']}}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">Riwayat penyakit sekarang</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">a. Monorrhea umur</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][monorrhea]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['monorrhea']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">b. HPHT</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][hpht]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['hpht']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">c. TP</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][tp]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['tp']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">d. Hamil ke</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][hamilke]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['hamilke']}}"/>
                </td>
              </tr>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">e. Riwayat KB</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][riwayatKB]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['riwayatKB']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">f. Pernah dirawat</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatPenyakitSekarang][pernahDirawat]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['riwayatPenyakitSekarang']['pernahDirawat']}}"/>
                </td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight: bold;">Riwayat Penyakit Lain lain</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[riwayatPenyakitLain]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ><{{@$assesment['riwayatPenyakitLain']}}/textarea>
                </td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight: bold;">Riwayat Penyakit Keluarga</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[riwayatPenyakitKeluargaS]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{@$assesment['riwayatPenyakitKeluargaS']}}</textarea>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">Pemeriksaan Fisik</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">a. Keadaan Umum</td>
                <td>
                  <input type="radio" id="keadaanUmum_1" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Tampak Tidak Sakit" ? "checked" : ''}} value="Tampak Tidak Sakit">
                  <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                  <input type="radio" id="keadaanUmum_2" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Ringan" ? "checked" : ''}} value="Sakit Ringan">
                  <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                  <input type="radio" id="keadaanUmum_3" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Sedang" ? "checked" : ''}} value="Sakit Sedang">
                  <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                  <input type="radio" id="keadaanUmum_4" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Berat" ? "checked" : ''}} value="Sakit Berat">
                  <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">b. Kesadaran</td>
                <td>
                  <input type="radio" id="kesadaran_1" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Compos Mentis" ? "checked" : ''}} value="Compos Mentis">
                  <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                  <input type="radio" id="kesadaran_2" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Apatis" ? "checked" : ''}} value="Apatis">
                  <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                  <input type="radio" id="kesadaran_3" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Somnolen" ? "checked" : ''}} value="Somnolen">
                  <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                  <input type="radio" id="kesadaran_4" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Sopor" ? "checked" : ''}} value="Sopor">
                  <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                  <input type="radio" id="kesadaran_5" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Coma" ? "checked" : ''}} value="Coma">
                  <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label>
                </td>
              </tr>
              <tr>
                <td rowspan="3" style="width:25%; font-weight:500;">c. GCS</td>
                <td style="padding: 5px;">
                  <label class="form-check-label " style="margin-right: 20px;">E</label>
                  <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="{{@$assesment['GCS']['E']}}">
                </td>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "   style="margin-right: 20px;">M</label>
                    <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="{{@$assesment['GCS']['M']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "  style="margin-right: 20px;">V</label>
                      <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="{{@$assesment['GCS']['V']}}">
                  </td>
                </tr>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">d. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="number" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="number" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="number" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="number" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                  <input type="number" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['BB']}}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="number" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['TB']}}">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:500;">e. Tambahan</td>
                <td>
                  <textarea rows="3" name="fisik[tambahanPemeriksaanFisik]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Tambahan Pemeriksaan]" class="form-control" >{{@$assesment['tambahanPemeriksaanFisik']}}</textarea>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Riwayat Ginekologi</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[riwayatGinekologi]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Riwayat Ginekologi]" class="form-control" >{{@$assesment['riwayatGinekologi']}}</textarea>
                </td>
              </tr>
              
            </table>

            
          </div>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 style="visibility: hidden;"><b>Riwayat Ginekologi</b></h5>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">Pemeriksaan Obstetri</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">a. Kepala</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Kelopak Mata</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][kepala][kelopakMata]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['kepala']['kelopakMata']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Konjungtiva</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][kepala][konjungtiva]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['kepala']['konjungtiva']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Sclera</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][kepala][sclera]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['kepala']['sclera']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Lain lain</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][kepala][lain_lain]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['kepala']['lain_lain']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">b. Buah dada</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Puting</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][buahDada][puting]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['buahDada']['puting']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">ASI</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][buahDada][asi]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['buahDada']['asi']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Kebersihan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][buahDada][kebersihan]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['buahDada']['kebersihan']}}" />
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Lain lain</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][buahDada][lain_lain]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['buahDada']['lain_lain']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">c. Pemeriksaan Posterior</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Luka</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemerisaanPosterior][luka]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemerisaanPosterior']['luka']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">d. Perut</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">TFU</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][tfu]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['tfu']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Leopold I</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][leopold1]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['leopold1']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Leopold II</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][leopold2]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['leopold2']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Leopold III</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][leopold3]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['leopold3']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Leopold IV</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][leopold4]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['leopold4']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Leopold DJJ</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][perut][leopoldDjj]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['perut']['leopoldDjj']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">e. Periksa Dalam</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Pembukaan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][periksaDalam][pembukaan]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['periksaDalam']['pembukaan']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Portio</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][periksaDalam][portio]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['periksaDalam']['portio']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Ketuban</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][periksaDalam][ketuban]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['periksaDalam']['ketuban']}}" />
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Presentasi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][periksaDalam][presentasi]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['periksaDalam']['presentasi']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Hodge</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][periksaDalam][hodge]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['periksaDalam']['hodge']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">f. Pemeriksaan Ginekologi</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Inspekulo</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][inspekulo]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['inspekulo']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Inspeksi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][inspeksi]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['inspeksi']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Hymen</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][hymen]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['hymen']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Liang vagina</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][liang_vagina]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['liang_vagina']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Mukoso Portio</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][mukoso_portio]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['mukoso_portio']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Fluskus</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][pemeriksaanGinekologi][fluskus]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['pemeriksaanGinekologi']['fluskus']}}"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">g. Palpasi</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">QUE</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][que]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['que']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Adnexa</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][adnexa]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['adnexa']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Parametrium</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][parametrium]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['parametrium']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">CU</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][cu]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['cu']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">VU</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][vu]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['vu']}}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">CD</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[pemeriksaanObstetri][palpasi][cd]" style="display:inline-block;" placeholder="" class="form-control" value="{{@$assesment['pemeriksaanObstetri']['palpasi']['cd']}}"/>
                </td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[diagnosa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosa]" class="form-control" >{{@$assesment['diagnosa']}}</textarea>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: bold;">Tindakan</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[Tindakan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Tindakan]" class="form-control" >{{@$assesment['Tindakan']}}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">Discharge Planning</td>
              </tr>
              <tr>
                <td  style="width:40%; font-weight:500;">
                  Rencana Lama Rawat Inap
                </td>
                <td style="padding: 5px;">
                    <div>
                        <p style="font-weight: bold;">Dapat Ditetapkan</p>
                          <span>Hari</span>
                          <input class="form-control" name="fisik[rencanaRanap][dapatDitetapkan][hari]" type="text" value="{{@$assesment['rencanaRanap']['dapatDitetapkan']['hari']}}">
                          <span>Tanggal</span>
                          <input class="form-control" name="fisik[rencanaRanap][dapatDitetapkan][tanggal]" type="date" value="{{@$assesment['rencanaRanap']['dapatDitetapkan']['tanggal']}}">
                    </div>
                    <div>
                        <p style="font-weight: bold;">Tidak Dapat Ditetapkan</p>
                        <input type="text" name="fisik[rencanaRanap][tidakDapatDitetapkan][alasan]" placeholder="Karena" class="form-control" value="{{@$assesment['rencanaRanap']['tidakDapatDitetapkan']['alasan']}}">
                    </div>
                </td>
            </tr>
            </table>

            
            <button class="btn btn-success pull-right">Simpan</button>
          </div> --}}

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>II. DATA SUBJEKTIF</b></h5>
              <tr>
                <td style="width: 50%; font-weight: bold;">1. Keluhan Utama</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[keluhanUtama]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Keluhan Utama]" class="form-control" >{{ @$assesment['keluhanUtama'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight: bold;">2. Riwayat Penyakit / Kehamilan Sekarang</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[riwayatPenyakit]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Riwayat Penyakit]" class="form-control" >{{ @$assesment['riwayatPenyakit'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">3. Riwayat Menstruasi</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">a. HPHT</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][hpht]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['hpht'] }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">b. Dismenorrhoe</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][dismenorrhoe]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['dismenorrhoe'] }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">c. Lama</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][lama]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['lama'] }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">d. Banyaknya</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][banyaknya]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['banyaknya'] }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">e. Menorrhagia/Mentrorrhagia</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][menorrhagia]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['menorrhagia'] }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">f. Siklus</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][siklus]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['siklus'] }}" />
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">g. Nyeri</td>
                <td>
                  <input type="radio" id="nyeri_1" name="fisik[riwayatMenstruasi][nyeri]" value="Tidak" {{ @$assesment['riwayatMenstruasi']['nyeri'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="nyeri_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="nyeri_2" name="fisik[riwayatMenstruasi][nyeri]" value="Ya" {{ @$assesment['riwayatMenstruasi']['nyeri'] == 'Ya' ? 'checked' : '' }}>
                  <label for="nyeri_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">h. Teratur</td>
                <td>
                  <input type="radio" id="teratur_1" name="fisik[riwayatMenstruasi][teratur]" value="Tidak" {{ @$assesment['riwayatMenstruasi']['teratur'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="teratur_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="teratur_2" name="fisik[riwayatMenstruasi][teratur]" value="Ya" {{ @$assesment['riwayatMenstruasi']['teratur'] == 'Ya' ? 'checked' : '' }}>
                  <label for="teratur_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">i. TP</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatMenstruasi][tp]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['riwayatMenstruasi']['tp'] }}"/>
                </td>
              </tr>

              <tr>
                <td style="width: 50%; font-weight: bold;">4. Riwayat Pergerakan Janin Pertama Kali Dirasakan</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[riwayatPergerakanJanin]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['riwayatPergerakanJanin'] }}</textarea>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">5. Riwayat Imunisasi</td>
                <td>
                  <input type="radio" id="imunisasi_1" name="fisik[riwayatImunisasi]" value="Tidak" {{ @$assesment['riwayatImunisasi'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="imunisasi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="imunisasi_2" name="fisik[riwayatImunisasi]" value="Ya" {{ @$assesment['riwayatImunisasi'] == 'Ya' ? 'checked' : '' }}>
                  <label for="imunisasi_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">6. Riwayat Perkawinan</td>
                <td>
                  <input type="radio" id="perkawinan_1" name="fisik[riwayatPerkawinan][pilihan]" value="Tidak" {{ @$assesment['riwayatPerkawinan']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="perkawinan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="perkawinan_2" name="fisik[riwayatPerkawinan][pilihan]" value="Ya" {{ @$assesment['riwayatPerkawinan']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                  <label for="perkawinan_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  <input type="text" name="fisik[riwayatPerkawinan][ke]" style="display:inline-block; width: 120px;" placeholder="Perkawinan Ke-" class="form-control" value="{{ @$assesment['riwayatPerkawinan']['ke'] }}"/>
                  <input type="text" name="fisik[riwayatPerkawinan][lama]" style="display:inline-block; width: 120px;" placeholder="Lamanya" class="form-control" value="{{ @$assesment['riwayatPerkawinan']['lama'] }}"/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">7. Riwayat Kontrasepsi Yang Pernah Dipakai</td>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatKontrasepsi][pil]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatKontrasepsi][pil]" type="checkbox" value="Pil" id="flexCheckDefault" {{ @$assesment['riwayatKontrasepsi']['pil'] == 'Pil' ? 'checked' : '' }}>
                    Pil
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatKontrasepsi][suntik]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatKontrasepsi][suntik]" type="checkbox" value="Suntik" id="flexCheckDefault" {{ @$assesment['riwayatKontrasepsi']['suntik'] == 'Suntik' ? 'checked' : '' }}>
                    Suntik
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatKontrasepsi][iud]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatKontrasepsi][iud]" type="checkbox" value="IUD" id="flexCheckDefault" {{ @$assesment['riwayatKontrasepsi']['iud'] == 'IUD' ? 'checked' : '' }}>
                    IUD
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatKontrasepsi][implan]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatKontrasepsi][implan]" type="checkbox" value="Implan" id="flexCheckDefault" {{ @$assesment['riwayatKontrasepsi']['implan'] == 'Implan' ? 'checked' : '' }}>
                    Implan
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatKontrasepsi][mow]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatKontrasepsi][mow]" type="checkbox" value="MOW" id="flexCheckDefault" {{ @$assesment['riwayatKontrasepsi']['mow'] == 'MOW' ? 'checked' : '' }}>
                    MOW
                  </label>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">8. Riwayat Penyakit Dahulu</td>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][jantung]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][jantung]" type="checkbox" value="Jantung" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['jantung'] == 'Jantung' ? 'checked' : '' }}>
                    Jantung
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][asma]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][asma]" type="checkbox" value="Asma" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['asma'] == 'Asma' ? 'checked' : '' }}>
                    Asma
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][hipertensi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][hipertensi]" type="checkbox" value="Hipertensi" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['hipertensi'] == 'hipertensi' ? 'checked' : '' }}>
                    Hipertensi
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][dm]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][dm]" type="checkbox" value="DM" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['dm'] == 'DM' ? 'checked' : '' }}>
                     DM
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][hepatitis]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][hepatitis]" type="checkbox" value="Hepatitis" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['hepatitis'] == 'Hepatitis' ? 'checked' : '' }}>
                    Hepatitis
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][alergi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][alergi]" type="checkbox" value="Alergi" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['alergi'] == 'Alergi' ? 'checked' : '' }}>
                    Alergi
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][ginjal]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][ginjal]" type="checkbox" value="Ginjal" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['ginjal'] == 'Ginjal' ? 'checked' : '' }}>
                    Ginjal
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitDahulu][tidak]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitDahulu][tidak]" type="checkbox" value="Tidak Ada" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitDahulu']['tidak'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak Ada
                  </label>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">9. Riwayat Penyakit Keluarga</td>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][jantung]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][jantung]" type="checkbox" value="Jantung" id="flexCheckDefault " {{ @$assesment['riwayatPenyakitKeluarga']['jantung'] == 'Jantung' ? 'checked' : '' }}>
                    Jantung
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][asma]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][asma]" type="checkbox" value="Asma" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['asma'] == 'Asma' ? 'checked' : '' }}>
                    Asma
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][hipertensi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][hipertensi]" type="checkbox" value="Hipertensi" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['hipertensi'] == 'hipertensi' ? 'checked' : '' }}>
                    Hipertensi
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][dm]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][dm]" type="checkbox" value="DM" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['dm'] == 'DM' ? 'checked' : '' }}>
                     DM
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][hepatitis]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][hepatitis]" type="checkbox" value="Hepatitis" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['hepatitis'] == 'Hepatitis' ? 'checked' : '' }}>
                    Hepatitis
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][alergi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][alergi]" type="checkbox" value="Alergi" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['alergi'] == 'Alergi' ? 'checked' : '' }}>
                    Alergi
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][ginjal]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][ginjal]" type="checkbox" value="Ginjal" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['ginjal'] == 'Ginjal' ? 'checked' : '' }}>
                    Ginjal
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitKeluarga][tidak]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitKeluarga][tidak]" type="checkbox" value="Tidak Ada" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitKeluarga']['tidak'] == 'Tidak' ? 'checked' : '' }}>
                    Tidak Ada
                  </label>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">10. Riwayat Penyakit Gynecologi</td>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][infertilitas]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][infertilitas]" type="checkbox" value="Infertilitas" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['infertilitas'] == 'Infertilitas' ? 'checked' : '' }}>
                    Infertilitas
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][infeksi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][infeksi]" type="checkbox" value="Infeksi Virus" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['infeksi'] == 'Infeksi' ? 'checked' : '' }}>
                    Infeksi Virus
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][pms]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][pms]" type="checkbox" value="PMS" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['pms'] == 'PMS' ? 'checked' : '' }}>
                    PMS
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][cervicitis]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][cervicitis]" type="checkbox" value="Cervicitis Akut/Kronis" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['cervicitis'] == 'Cervicitis' ? 'checked' : '' }}>
                     Cervicitis Akut/Kronis
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][polyp]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][polyp]" type="checkbox" value="Polyp Cervix" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['polyp'] == 'Polyp Cervix' ? 'checked' : '' }}>
                    Polyp Cervix
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][myoma]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][myoma]" type="checkbox" value="Myoma" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['myoma'] == 'Myoma' ? 'checked' : '' }}>
                    Myoma
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][ca]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][ca]" type="checkbox" value="Ca Cervix" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['ca'] == 'Ca Cervix' ? 'checked' : '' }}>
                    Ca Cervix
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[riwayatPenyakitGynecologi][operasi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[riwayatPenyakitGynecologi][operasi]" type="checkbox" value="Operasi Kandungan" id="flexCheckDefault" {{ @$assesment['riwayatPenyakitGynecologi']['operasi'] == 'Operasi Kandungan' ? 'checked' : '' }}>
                    Operasi Kandungan
                  </label><br/>
                  <input type="text" name="fisik[riwayatPenyakitGynecologi][lainnya]" style="display:inline-block;" placeholder="Lainnya" class="form-control" value="{{ @$assesment['riwayatPenyakitGynecologi']['lainnya']  }}"/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">11. Riwayat Kehamilan, Persalinan dan Nifas Yang Lalu</td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Tgl / Tahun Persalinan</td>
                <td style="padding: 5px;">
                  <input type="date" name="fisik[riwayatKehamilan][tgl1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['tgl1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Tempat Persalinan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][tmp1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['tmp1']  }}" />
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Umur Persalinan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][umur1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['umur1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Jenis Persalinan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][jenis1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['jenis1']  }}" />
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Penolong</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][penolong1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['penolong1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Anak (JK)</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][jk1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['jk1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Anak (BB)</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][bb1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['bb1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Anak (PB)</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][pb1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['pb1']  }}" />
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">ASI Ekslusif</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][asi1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['asi1']  }}"/>
                </td>
              </tr>
              <tr>
                <td style="width: 50%; font-weight: 500;">Keterangan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayatKehamilan][ket1]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan']['ket1']  }}" />
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">12. Fungsional</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">a. Alat Bantu</td>
                <td>
                  <input type="radio" id="alatBantu_1" name="fisik[fungsional][alatBantu]" value="Tidak" {{ @$assesment['fungsional']['alatBantu'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="alatBantu_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="alatBantu_2" name="fisik[fungsional][alatBantu]" value="Ya" {{ @$assesment['fungsional']['alatBantu'] == 'Ya' ? 'checked' : '' }}>
                  <label for="alatBantu_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">b. Prosthesis</td>
                <td>
                  <input type="radio" id="prosthesis_1" name="fisik[fungsional][prosthesis]" value="Tidak" {{ @$assesment['fungsional']['prosthesis'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="prosthesis_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="prosthesis_2" name="fisik[fungsional][prosthesis]" value="Ya" {{ @$assesment['fungsional']['prosthesis'] == 'Ya' ? 'checked' : '' }}>
                  <label for="prosthesis_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">c. Cacat Tubuh</td>
                <td>
                  <input type="text" name="fisik[fungsional][cacatTubuh]" style="display:inline-block;" placeholder="" class="form-control" value="{{ @$assesment['fungsional']['cacatTubuh']}}" />
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">d. ADL</td>
                <td>
                  <input type="radio" id="adl_1" name="fisik[fungsional][adl]" value="Mandiri" {{ @$assesment['fungsional']['adl'] == 'Mandiri' ? 'checked' : '' }}>
                  <label for="adl_1" style="font-weight: normal; margin-right: 10px;">Mandiri</label>
                  <input type="radio" id="adl_2" name="fisik[fungsional][adl]" value="Dibantu" {{ @$assesment['fungsional']['adl'] == 'Dibantu' ? 'checked' : '' }}>
                  <label for="adl_2" style="font-weight: normal; margin-right: 10px;">Dibantu</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">e. Riwayat Jatuh 3 Bulan Terakhir</td>
                <td>
                  <input type="radio" id="jatuh_1" name="fisik[fungsional][jatuh]" value="Tidak" {{ @$assesment['fungsional']['jatuh'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="jatuh_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="jatuh_2" name="fisik[fungsional][jatuh]" value="Ya" {{ @$assesment['fungsional']['jatuh'] == 'Ya' ? 'checked' : '' }}>
                  <label for="jatuh_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">
                  13. Peningkatan Berat Badan <br/>
                  <span style="font-weight: 400; font-size: 8pt"><i>*Bila ada "Ya" rujuk ke ahli gizi untuk terapi nutrisi lebih lanjut (intensif)</i></span>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">a. Berat badan meningkat atau menurun yang tidak direncanakan lebih dari 5% pada bulan terakhir</td>
                <td>
                  <input type="radio" id="meningkat_1" name="fisik[peningkatanBB][meningkat]" value="Tidak" {{ @$assesment['peningkatanBB']['meningkat'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="meningkat_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="meningkat_2" name="fisik[peningkatanBB][meningkat]" value="Ya" {{ @$assesment['peningkatanBB']['meningkat'] == 'Ya' ? 'checked' : '' }}>
                  <label for="meningkat_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">b. Asupan makanan makin menurun pada 5(lima) hari terakhir</td>
                <td>
                  <input type="radio" id="asupan_1" name="fisik[peningkatanBB][asupan]" value="Tidak" {{ @$assesment['peningkatanBB']['asupan'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="asupan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="asupan_2" name="fisik[peningkatanBB][asupan]" value="Ya" {{ @$assesment['peningkatanBB']['asupan'] == 'Ya' ? 'checked' : '' }}>
                  <label for="asupan_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">c. Menderita sakit berat (ada gangguan metabolism nurtisi/butuh terapi intensif)</td>
                <td>
                  <input type="radio" id="sakitBerat_1" name="fisik[peningkatanBB][sakitBerat]" value="Tidak" {{ @$assesment['peningkatanBB']['sakitBerat'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="sakitBerat_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="sakitBerat_2" name="fisik[peningkatanBB][sakitBerat]" value="Ya" {{ @$assesment['peningkatanBB']['sakitBerat'] == 'Ya' ? 'checked' : '' }}>
                  <label for="sakitBerat_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width: 50%; font-weight: bold;">
                  14. Skrining Resiko Jatuh <br/>
                  <span style="font-weight: 400; font-size: 8pt"><i>*Bila ada "Ya" pasang gelang resiko jatuh dan setelah sampai ruangan lakukan asesmen ulang resiko jatuh dengan menggunakan skala morse (dewasa) dan humpty dumpty (anak-anak) </i></span>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">a. Perhatikan cara berjalan pasien saat akan duduk di kursi, apakah tampak tidak seimbang (sempoyongan/limbung)</td>
                <td>
                  <input type="radio" id="caraJalan_1" name="fisik[resikoJatuh][caraJalan]" value="Tidak" {{ @$assesment['resikoJatuh']['caraJalan'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="caraJalan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="caraJalan_2" name="fisik[resikoJatuh][caraJalan]" value="Ya" {{ @$assesment['resikoJatuh']['caraJalan'] == 'Ya' ? 'checked' : '' }}>
                  <label for="caraJalan_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">b. Apakah pasien memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan duduk</td>
                <td>
                  <input type="radio" id="penopang_1" name="fisik[resikoJatuh][penopang]" value="Tidak" {{ @$assesment['resikoJatuh']['penopang'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="penopang_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="penopang_2" name="fisik[resikoJatuh][penopang]" value="Ya" {{ @$assesment['resikoJatuh']['penopang'] == 'Ya' ? 'checked' : '' }}>
                  <label for="penopang_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:bold; width: 50%;">15. Status Psikologi</td>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[statusPsikologi][tenang]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[statusPsikologi][tenang]" type="checkbox" value="Tenang" id="flexCheckDefault" {{ @$assesment['statusPsikologi']['tenang'] == 'Tenang' ? 'checked' : '' }}>
                    Tenang
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[statusPsikologi][cemas]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[statusPsikologi][cemas]" type="checkbox" value="Cemas" id="flexCheckDefault" {{ @$assesment['statusPsikologi']['cemas'] == 'Cemas' ? 'checked' : '' }}>
                    Cemas
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[statusPsikologi][marah]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[statusPsikologi][marah]" type="checkbox" value="Marah" id="flexCheckDefault" {{ @$assesment['statusPsikologi']['marah'] == 'Marah' ? 'checked' : '' }}>
                    Marah
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[statusPsikologi][sedih]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[statusPsikologi][sedih]" type="checkbox" value="Sedih" id="flexCheckDefault" {{ @$assesment['statusPsikologi']['sedih'] == 'Sedih' ? 'checked' : '' }}>
                    Sedih
                  </label>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight:bold;">16. Assesmen Nyeri</td>
              </tr>
              <tr>
                <td>
                  <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak" {{ @$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                  <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                </td>
                <td>
                  <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada" {{ @$assesment['nyeri']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                  <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Provokatif</td>
                <td>
                  <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]" value="Benturan" {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Benturan' ? 'checked' : '' }}>
                  <label for="provokatif_1" style="font-weight: normal;">Benturan</label>
                  <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan" {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : '' }}>
                  <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                  <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]" value="Lain-Lain" {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                  <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                  <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['provokatif']['sebutkan'] }}">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Quality</td>
                <td>
                  <input type="radio" id="quality_1" name="fisik[nyeri][quality][pilihan]" value="Seperti Tertusuk" {{ @$assesment['nyeri']['quality']['pilihan'] == 'Seperti Tertusuk' ? 'checked' : '' }}>
                  <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda Tajam/Tumpul</label><br/>
                  <input type="radio" id="quality_2" name="fisik[nyeri][quality][pilihan]" value="Berdenyut Terbakar Teriris" {{ @$assesment['nyeri']['quality']['pilihan'] == 'Berdenyut Terbakar Teriris' ? 'checked' : '' }}>
                  <label for="quality_2" style="font-weight: normal;">Berdenyut Terbakar Teriris</label><br/>
                  <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['quality']['sebutkan'] }}">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Region</td>
                <td>
                  <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br/>
                  <input type="text" name="fisik[nyeri][region][terlokalisir]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['nyeri']['region']['terlokalisir'] }}"><br/>
                  <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br/>
                  <input type="text" name="fisik[nyeri][region][menyebar]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['nyeri']['region']['menyebar'] }}"><br/>
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                <td>
                  <input type="number" name="fisik[nyeri][durasi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['nyeri']['durasi'] }}">
                </td>
              </tr>

              <tr>
                <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                <td>
                  <input type="radio" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Minum Obat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Minum Obat' ? 'checked' : '' }}>
                  <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br/>
                  <input type="radio" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Istirahat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Istirahat' ? 'checked' : '' }}>
                  <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br/>
                  <input type="radio" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Berubah Posisi" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Berubah Posisi' ? 'checked' : '' }}>
                  <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br/>
                  <input type="radio" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Mendengarkan Musik" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Mendengarkan Musik' ? 'checked' : '' }}>
                  <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br/>
                  <input type="radio" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan]" value="Lain-Lain" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                  <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br/>
                  <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['nyeri_hilang']['sebutkan'] }}">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="font-weight:bold;">17. Sistem Organ</td>
              </tr>
              <tr>
                <td style="font-weight:500;">Keluhan</td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[sistem_organ][keluhan]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['sistem_organ']['keluhan'] }}</textarea>
                </td>
              </tr>
            </table>

            
          </div>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>III. DATA OBJEKTIF</b></h5>
              <tr>
                <td style="width:50%; font-weight:bold;">1. Keadadan Umum</td>
                <td>
                  {{-- 
                  <input type="radio" id="keadaanUmum_1" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Tampak Tidak Sakit" ? "checked" : ''}} value="Tampak Tidak Sakit">
                  <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                  <input type="radio" id="keadaanUmum_2" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Ringan" ? "checked" : ''}} value="Sakit Ringan">
                  <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                  <input type="radio" id="keadaanUmum_3" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Sedang" ? "checked" : ''}} value="Sakit Sedang">
                  <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                  <input type="radio" id="keadaanUmum_4" name="fisik[nyeri][keadaanUmum][pilihan]" {{@$assesment['nyeri']['keadaanUmum']['pilihan'] == "Sakit Berat" ? "checked" : ''}} value="Sakit Berat">
                  <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label> 
                  --}}
                  <input type="checkbox" id="keadaanUmum_1" name="fisik[nyeri][keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                  <label for="keadaanUmum_1" style="font-weight: normal;margin-right: 15px;">Tampak Tidak Sakit</label> 
                  <input type="checkbox" id="keadaanUmum_2" name="fisik[nyeri][keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                  <label for="keadaanUmum_2" style="font-weight: normal;margin-right: 10px;">Sakit Ringan</label> <br/>
                  <input type="checkbox" id="keadaanUmum_3" name="fisik[nyeri][keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                  <label for="keadaanUmum_3" style="font-weight: normal;margin-right: 50px;">Sakit Sedang</label> 
                  <input type="checkbox" id="keadaanUmum_4" name="fisik[nyeri][keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                  <label for="keadaanUmum_4" style="font-weight: normal;margin-right: 10px;">Sakit Berat</label>
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">2. Kesadaran</td>
                <td>
                  {{-- 
                  <input type="radio" id="kesadaran_1" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Compos Mentis" ? "checked" : ''}} value="Compos Mentis">
                  <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                  <input type="radio" id="kesadaran_2" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Apatis" ? "checked" : ''}} value="Apatis">
                  <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                  <input type="radio" id="kesadaran_3" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Somnolen" ? "checked" : ''}} value="Somnolen">
                  <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                  <input type="radio" id="kesadaran_4" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Sopor" ? "checked" : ''}} value="Sopor">
                  <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                  <input type="radio" id="kesadaran_5" name="fisik[nyeri][kesadaran][pilihan]" {{@$assesment['nyeri']['kesadaran']['pilihan'] == "Coma" ? "checked" : ''}} value="Coma">
                  <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label> 
                  --}}
                  <input type="checkbox" id="kesadaran_1" name="fisik[nyeri][kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$assesment['nyeri']['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                  <label for="kesadaran_1" style="font-weight: normal;margin-right: 15px;">Compos Mentis</label> 
                  <input type="checkbox" id="kesadaran_2" name="fisik[nyeri][kesadaran][pilihan][apatis]" value="Apatis" {{ @$assesment['nyeri']['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                  <label for="kesadaran_2" style="font-weight: normal;margin-right: 10px;">Apatis</label> <br/>
                  <input type="checkbox" id="kesadaran_3" name="fisik[nyeri][kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$assesment['nyeri']['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                  <label for="kesadaran_3" style="font-weight: normal;margin-right: 43px;">Somnolen</label> 
                  <input type="checkbox" id="kesadaran_4" name="fisik[nyeri][kesadaran][pilihan][sopor]" value="Sopor" {{ @$assesment['nyeri']['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                  <label for="kesadaran_4" style="font-weight: normal;margin-right: 25px;">Sopor</label>
                  <input type="checkbox" id="kesadaran_5" name="fisik[nyeri][kesadaran][pilihan][coma]" value="Coma" {{ @$assesment['nyeri']['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                  <label for="kesadaran_5" style="font-weight: normal;margin-right: 10px;">Coma</label>
                </td>
              </tr>

              <tr>
                <td rowspan="4" style="width:25%; font-weight:bold;">3. GCS</td>
                <td style="padding: 5px;">
                  <label class="form-check-label " style="margin-right: 20px;">E</label>
                  <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="0">
                </td>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "   style="margin-right: 20px;">M</label>
                    <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="0">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "  style="margin-right: 20px;">V</label>
                      <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="0">
                  </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">
                        <label class="form-check-label "  style="margin-right: 20px;">Total</label>
                        <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="Total" class="form-control" id="gcsScore" disabled value="0">
                    </td>
                    </td>
                </tr>
              </tr>
              <script>
                let gcs = document.getElementsByClassName('gcs');
                let gcsScore = document.getElementById('gcsScore');
                gcs = Array.from(gcs);
                gcs.forEach(el => {
                    el.addEventListener('input', function(){
                        let gcsVal = 0;
                        gcs.forEach(x => {
                            let val = parseInt(x.value)
                            if(isNaN(val)){
                                val = 0;
                            }
                            gcsVal += val;
                        })
                        gcsScore.value = gcsVal;
                    })
                });
            </script>
            

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">4. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['tekanan_darah'] }}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['nadi'] }}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['RR'] }}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['temp'] }}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                  <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['BB'] }}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['TB'] }}">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">Pemeriksaan Fisik</td>
              </tr>
              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Muka</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Cloasma Gravidarum</td>
                <td>
                  <input type="radio" id="cloasma_1" name="fisik[pemeriksaanFisik][muka][cloasma]" value="Tidak">
                  <label for="cloasma_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="cloasma_2" name="fisik[pemeriksaanFisik][muka][cloasma]" value="Ada">
                  <label for="cloasma_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Mata</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Konjungtiva</td>
                <td>
                  <input type="radio" id="konjungtiva_1" name="fisik[pemeriksaanFisik][mata][konjungtiva]" value="Tidak">
                  <label for="konjungtiva_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="konjungtiva_2" name="fisik[pemeriksaanFisik][mata][konjungtiva]" value="Anemis">
                  <label for="konjungtiva_2" style="font-weight: normal; margin-right: 10px;">Anemis</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Leher</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Kelenjar Tiroid Pembesaran</td>
                <td>
                  <input type="radio" id="tiroid_1" name="fisik[pemeriksaanFisik][leher][tiroid]" value="Tidak">
                  <label for="tiroid_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="tiroid_2" name="fisik[pemeriksaanFisik][leher][tiroid]" value="Ada">
                  <label for="tiroid_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Vena Jugularis Peningkatan</td>
                <td>
                  <input type="radio" id="vena_1" name="fisik[pemeriksaanFisik][leher][vena]" value="Tidak">
                  <label for="vena_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="vena_2" name="fisik[pemeriksaanFisik][leher][vena]" value="Ada">
                  <label for="vena_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">KGB Pembesaran</td>
                <td>
                  <input type="radio" id="kgb_1" name="fisik[pemeriksaanFisik][leher][kgb]" value="Tidak">
                  <label for="kgb_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="kgb_2" name="fisik[pemeriksaanFisik][leher][kgb]" value="Ada">
                  <label for="kgb_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Dada</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Payudara</td>
                <td>
                  <input type="radio" id="payudara_1" name="fisik[pemeriksaanFisik][dada][payudara]" value="Simetris">
                  <label for="payudara_1" style="font-weight: normal; margin-right: 10px;">Simetris</label>
                  <input type="radio" id="payudara_2" name="fisik[pemeriksaanFisik][dada][payudara]" value="Asimetris">
                  <label for="payudara_2" style="font-weight: normal; margin-right: 10px;">Asimetris</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Puting Susu Menonjol</td>
                <td>
                  <input type="radio" id="putingMenonjol_1" name="fisik[pemeriksaanFisik][dada][putingMenonjol]" value="Tidak">
                  <label for="putingMenonjol_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="putingMenonjol_2" name="fisik[pemeriksaanFisik][dada][putingMenonjol]" value="Ya">
                  <label for="putingMenonjol_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Kolostrum</td>
                <td>
                  <input type="radio" id="kolostrum_1" name="fisik[pemeriksaanFisik][dada][kolostrum]" value="Tidak">
                  <label for="kolostrum_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="kolostrum_2" name="fisik[pemeriksaanFisik][dada][kolostrum]" value="Ada">
                  <label for="kolostrum_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Masa / Benjolan</td>
                <td>
                  <input type="radio" id="benjolan_1" name="fisik[pemeriksaanFisik][dada][benjolan]" value="Tidak">
                  <label for="benjolan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="benjolan_2" name="fisik[pemeriksaanFisik][dada][benjolan]" value="Ada">
                  <label for="benjolan_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Retraksi</td>
                <td>
                  <input type="radio" id="retraksi_1" name="fisik[pemeriksaanFisik][dada][retraksi]" value="Tidak">
                  <label for="retraksi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="retraksi_2" name="fisik[pemeriksaanFisik][dada][retraksi]" value="Ada">
                  <label for="retraksi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Abdomen</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Striae Gravidarum</td>
                <td>
                  <input type="radio" id="striae_1" name="fisik[pemeriksaanFisik][abdomen][striae]" value="Tidak">
                  <label for="striae_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="striae_2" name="fisik[pemeriksaanFisik][abdomen][striae]" value="Ya">
                  <label for="striae_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Bekas Luka Operasi</td>
                <td>
                  <input type="radio" id="bekasLukaOperasi_1" name="fisik[pemeriksaanFisik][abdomen][bekasLukaOperasi]" value="Tidak">
                  <label for="bekasLukaOperasi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="bekasLukaOperasi_2" name="fisik[pemeriksaanFisik][abdomen][bekasLukaOperasi]" value="Ada">
                  <label for="bekasLukaOperasi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">TFU (Cm)</td>
                <td>
                  <input type="number" name="fisik[pemeriksaanFisik][tfu]" class="form-control" style="display: inline-block;" id="" placeholder="Cm">
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:500;">Palpasi</td>
                <td style="font-weight:500; width: 50%;">
                  <span style="margin-right: 20px;">Leopold I</span>
                  <input type="text" name="fisik[pemeriksaanFisik][palpasi][LI]" class="form-control" style="display: inline-block; width: 100px;" id="" placeholder=""><br/><br/>
                  <span style="margin-right: 15px;">Leopold II</span>
                  <input type="text" name="fisik[pemeriksaanFisik][palpasi][LII]" class="form-control" style="display: inline-block; width: 100px;" id="" placeholder=""><br/><br/>
                  <span style="margin-right: 10px;">Leopold III</span>
                  <input type="text" name="fisik[pemeriksaanFisik][palpasi][LIII]" class="form-control" style="display: inline-block; width: 100px;" id="" placeholder=""><br/><br/>
                  <span style="margin-right: 13px;">Leopold IV</span>
                  <input type="text" name="fisik[pemeriksaanFisik][palpasi][LIV]" class="form-control" style="display: inline-block; width: 100px;" id="" placeholder=""><br/><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Auskultasi</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">His (x/10 menit)</td>
                <td>
                  <input type="number" name="fisik[pemeriksaanFisik][auskultasi][his]" class="form-control" style="display: inline-block;" id="" placeholder="x/10 menit">
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Durasi (detik)</td>
                <td>
                  <input type="number" name="fisik[pemeriksaanFisik][auskultasi][durasi]" class="form-control" style="display: inline-block;" id="" placeholder="detik">
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">DJJ</td>
                <td>
                  <input type="text" name="fisik[pemeriksaanFisik][auskultasi][djj][text]" class="form-control" style="display: inline-block;" id="" placeholder=""><br/>
                  <input type="radio" id="djj_1" name="fisik[pemeriksaanFisik][auskultasi][djj][pilihan]" value="Reguler">
                  <label for="djj_1" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                  <input type="radio" id="djj_2" name="fisik[pemeriksaanFisik][auskultasi][djj][pilihan]" value="Irreguler">
                  <label for="djj_2" style="font-weight: normal; margin-right: 10px;">Irreguler</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">TBJA (gr)</td>
                <td>
                  <input type="number" name="fisik[pemeriksaanFisik][auskultasi][tbja]" class="form-control" style="display: inline-block;" id="" placeholder="gr">
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Saluran Kemih & Genitalia</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Pengeluaran</td>
                <td style="">
                  <input type="radio" id="pengeluaran_1" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Keputihan">
                  <label for="pengeluaran_1" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                  <input type="radio" id="pengeluaran_2" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Blood Show">
                  <label for="pengeluaran_2" style="font-weight: normal; margin-right: 10px;">Blood Show</label><br/>
                  <input type="radio" id="pengeluaran_3" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Flek">
                  <label for="pengeluaran_3" style="font-weight: normal; margin-right: 10px;">Flek</label><br/>
                  <input type="radio" id="pengeluaran_4" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Stosel">
                  <label for="pengeluaran_4" style="font-weight: normal; margin-right: 10px;">Stosel</label><br/>
                  <input type="radio" id="pengeluaran_5" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Ketuban">
                  <label for="pengeluaran_5" style="font-weight: normal; margin-right: 10px;">Ketuban</label><br/>
                  <input type="radio" id="pengeluaran_6" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Nanah">
                  <label for="pengeluaran_6" style="font-weight: normal; margin-right: 10px;">Nanah</label><br/>
                  <input type="radio" id="pengeluaran_7" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan]" value="Lainnya">
                  <label for="pengeluaran_7" style="font-weight: normal; margin-right: 10px;">Lainnya</label><br/>
                  <input type="text" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][jelaskan]" class="form-control" style="display: inline-block;" id="" placeholder="Jelaskan">
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Kelainan</td>
                <td>
                  <input type="radio" id="kelainan_1" name="fisik[pemeriksaanFisik][genitalia][kelainan][pilihan]" value="Tidak">
                  <label for="kelainan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="kelainan_2" name="fisik[pemeriksaanFisik][genitalia][kelainan][pilihan]" value="Ada">
                  <label for="kelainan_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Lochea</td>
                <td>
                  <input type="radio" id="lochea_1" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan]" value="Tidak">
                  <label for="lochea_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="lochea_2" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan]" value="Ada">
                  <label for="lochea_2" style="font-weight: normal; margin-right: 10px;">Ada</label>
                  <input type="radio" id="lochea_3" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan]" value="Rubra">
                  <label for="lochea_3" style="font-weight: normal; margin-right: 10px;">Rubra</label><br/>
                  <input type="radio" id="lochea_4" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan]" value="Sangulienta">
                  <label for="lochea_4" style="font-weight: normal; margin-right: 10px;">Sangulienta</label>
                  <input type="radio" id="lochea_5" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan]" value="Alba">
                  <label for="lochea_5" style="font-weight: normal; margin-right: 10px;">Alba</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Perineum</td>
                <td>
                  <input type="radio" id="perineum_1" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan]" value="Utuh">
                  <label for="perineum_1" style="font-weight: normal; margin-right: 10px;">Utuh</label>
                  <input type="radio" id="perineum_2" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan]" value="Jaringan Parut">
                  <label for="perineum_2" style="font-weight: normal; margin-right: 10px;">Jaringan Parut</label><br/>
                  <input type="radio" id="perineum_3" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan]" value="Varises">
                  <label for="perineum_3" style="font-weight: normal; margin-right: 10px;">Varises</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Jahitan</td>
                <td>
                  <input type="radio" id="jahitan_1" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan]" value="Baik">
                  <label for="jahitan_1" style="font-weight: normal; margin-right: 10px;">Baik</label>
                  <input type="radio" id="jahitan_2" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan]" value="Terlepas">
                  <label for="jahitan_2" style="font-weight: normal; margin-right: 10px;">Terlepas</label><br/>
                  <input type="radio" id="jahitan_3" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan]" value="Hematom">
                  <label for="jahitan_3" style="font-weight: normal; margin-right: 10px;">Hematom</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Robekan</td>
                <td>
                  <input type="radio" id="robekan_1" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan]" value="Grade I">
                  <label for="robekan_1" style="font-weight: normal; margin-right: 10px;">Grade I</label>
                  <input type="radio" id="robekan_2" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan]" value="Grade II">
                  <label for="robekan_2" style="font-weight: normal; margin-right: 10px;">Grade II</label><br/>
                  <input type="radio" id="robekan_3" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan]" value="Grade III">
                  <label for="robekan_3" style="font-weight: normal; margin-right: 10px;">Grade III</label>
                  <input type="radio" id="robekan_4" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan]" value="Grade IV">
                  <label for="robekan_4" style="font-weight: normal; margin-right: 10px;">Grade IV</label>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Anus</td>
                <td>
                  <input type="radio" id="anus_1" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan]" value="Haemoroid">
                  <label for="anus_1" style="font-weight: normal; margin-right: 10px;">Haemoroid</label>
                  <input type="radio" id="anus_2" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan]" value="Condiloma">
                  <label for="anus_2" style="font-weight: normal; margin-right: 10px;">Condiloma</label><br/>
                  <input type="radio" id="anus_3" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan]" value="T.A.K">
                  <label for="anus_3" style="font-weight: normal; margin-right: 10px;">T.A.K</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Nifas</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">TFU</td>
                <td>
                  <input type="text" name="fisik[pemeriksaanFisik][nifas][tfu]" class="form-control" style="display: inline-block;" id="" placeholder="">
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Kontraksi Uterus</td>
                <td>
                  <input type="radio" id="kontraksiUterus_1" name="fisik[pemeriksaanFisik][nifas][kontraksiUterus][pilihan]" value="Baik">
                  <label for="kontraksiUterus_1" style="font-weight: normal; margin-right: 10px;">Baik</label>
                  <input type="radio" id="kontraksiUterus_2" name="fisik[pemeriksaanFisik][nifas][kontraksiUterus][pilihan]" value="Tidak">
                  <label for="kontraksiUterus_2" style="font-weight: normal; margin-right: 10px;">Tidak</label><br/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Pemriksaan Dalam</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Vulva Vagina</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][vulvaVagina]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Portio</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][portio]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Ketuban</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][ketuban]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Pembukaan</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][pembukaan]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Presentase Fetus</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][presentaseFetus]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">Hodge/Station</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][hodge]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:500;">Gyonecologi</td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">a) Kelenjar Bartholini</td>
                <td>
                  <input type="radio" id="kelenjarBartholini_1" name="fisik[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" value="Ada Pembengkakan">
                  <label for="kelenjarBartholini_1" style="font-weight: normal; margin-right: 10px;">Ada Pembengkakan</label>
                  <input type="radio" id="kelenjarBartholini_2" name="fisik[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" value="Tidak">
                  <label for="kelenjarBartholini_2" style="font-weight: normal; margin-right: 10px;">Tidak</label><br/>
                </td>
              </tr>
              <tr>
                <td style="font-weight:500; width: 50%;">b) Inspekulo</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][gyonecologi][inspekulo]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Ekstremitas Atas dan Bawah</td>
                <td>
                  <textarea rows="3" name="fisik[pemeriksaanFisik][ekstremitasAtasBawah]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" ></textarea>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Oedem</td>
                <td>
                  <input type="radio" id="oedem_1" name="fisik[pemeriksaanFisik][oedem][pilihan]" value="Tidak">
                  <label for="oedem_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="oedem_2" name="fisik[pemeriksaanFisik][oedem][pilihan]" value="Ya">
                  <label for="oedem_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Varises</td>
                <td>
                  <input type="radio" id="varises_1" name="fisik[pemeriksaanFisik][varises][pilihan]" value="Tidak">
                  <label for="varises_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="varises_2" name="fisik[pemeriksaanFisik][varises][pilihan]" value="Ya">
                  <label for="varises_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Kekuatan Otot dan Sendi</td>
                <td>
                  <input type="radio" id="kekuatanOtot_1" name="fisik[pemeriksaanFisik][kekuatanOtot][pilihan]" value="Tidak">
                  <label for="kekuatanOtot_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="radio" id="kekuatanOtot_2" name="fisik[pemeriksaanFisik][kekuatanOtot][pilihan]" value="Ya">
                  <label for="kekuatanOtot_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                </td>
              </tr>

              <tr>
                <td style="font-weight:500; width: 50%;">Reflex</td>
                <td>
                  <input type="radio" id="reflex_1" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Normal">
                  <label for="reflex_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                  <input type="radio" id="reflex_2" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Hyper">
                  <label for="reflex_2" style="font-weight: normal; margin-right: 10px;">Hyper</label>
                  <input type="radio" id="reflex_3" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Hipo">
                  <label for="reflex_3" style="font-weight: normal; margin-right: 10px;">Hipo</label><br/>
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>IV. PEMERIKSAAN PENUNJANG</b></h5>
              <tr>
                <td style="text-align: center;">
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][laboratorium]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][laboratorium]" type="checkbox" value="Laboratorium" id="flexCheckDefault">
                    Laboratorium
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][ekg]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][ekg]" type="checkbox" value="EKG" id="flexCheckDefault">
                    EKG
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][radiologi]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][radiologi]" type="checkbox" value="Radiologi" id="flexCheckDefault">
                    Radiologi
                  </label>
                  <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                   <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][ctg]" type="hidden" value="" id="flexCheckDefault">
                   <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][ctg]" type="checkbox" value="CTG/NST" id="flexCheckDefault">
                    CTG/NST
                  </label>
                  <input type="text" name="fisik[pemeriksaanPenunjang][lainnya]" class="form-control" style="display: inline-block;" id="" placeholder="Lainnya">
                </td>
              </tr>
            </table>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                </td>
                <td>
                  <input type="text" id="waktuKontrol" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" id="listKontrol" data-dokterID="{{ $reg->dokter_id }}"
                    class="btn btn-info btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> Lihat List Kontrol
                  </button>
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesment['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][dirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirawat']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesment['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['meninggal']['waktu']}}">
                </td>
              </tr>
            </table>
            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5><b>V. RENCANA PEMULANGAN PASIEN (Discarge Planning)</b></h5>
              <tr>
                <td colspan="2">
                  <input type="radio" id="dischargePlanning_1" name="fisik[dischargePlanning][pilihan]" value="Pulang" {{@$assesment['dischargePlanning']['pilihan'] == 'Pulang' ? 'checked' : ''}}>
                  <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang</label><br/>
                  <input type="radio" id="dischargePlanning_2" name="fisik[dischargePlanning][pilihan]" value="Dirawat" {{@$assesment['dischargePlanning']['pilihan'] == 'Dirawat' ? 'checked' : ''}}>
                  <label for="dischargePlanning_2" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                  <input type="radio" id="dischargePlanning_3" name="fisik[dischargePlanning][pilihan]" value="Menolak Dirawat" {{@$assesment['dischargePlanning']['pilihan'] == 'Menolak Dirawat' ? 'checked' : ''}}>
                  <label for="dischargePlanning_3" style="font-weight: normal; margin-right: 10px;">Menolak Dirawat</label><br/>
                  <input type="radio" id="dischargePlanning_4" name="fisik[dischargePlanning][pilihan]" value="Dirujuk" {{@$assesment['dischargePlanning']['pilihan'] == 'Dirujuk' ? 'checked' : ''}}>
                  <label for="dischargePlanning_4" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                </td>
                {{-- <td>
                  <input type="radio" id="dischargePlanning_4" name="fisik[dischargePlanning][pilihan]" value="Perlu Pemasangan NGT" {{@$assesment['dischargePlanning']['pilihan'] == 'Perlu Pemasangan NGT' ? 'checked' : ''}}>
                  <label for="dischargePlanning_4" style="font-weight: normal; margin-right: 10px;">Perlu Pemasangan NGT</label><br/>
                  <input type="radio" id="dischargePlanning_5" name="fisik[dischargePlanning][pilihan]" value="Dirujuk Ke Tim Terapis" {{@$assesment['dischargePlanning']['pilihan'] == 'Dirujuk Ke Tim Terapis' ? 'checked' : ''}}>
                  <label for="dischargePlanning_5" style="font-weight: normal; margin-right: 10px;">Dirujuk Ke Tim Terapis</label><br/>
                  <input type="radio" id="dischargePlanning_6" name="fisik[dischargePlanning][pilihan]" value="Dirujuk ke yang lainnya" {{@$assesment['dischargePlanning']['pilihan'] == 'Dirujuk ke yang lainnya' ? 'checked' : ''}}>
                  <label for="dischargePlanning_6" style="font-weight: normal; margin-right: 10px;">Dirujuk ke yang lainnya</label><br/>
                  <input type="text" id="dischargePlanning_7" name="fisik[dischargePlanning][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['dischargePlanning']['sebutkan']}}">
                </td> 
              </tr>

              {{-- <tr>
                <td style="font-weight:500; width: 50%;">Ketika Pulang masih memerlukan perawatan lanjutan (kontrol)</td>
                <td>
                  <input type="radio" id="perawatanLanjutan_1" name="fisik[perawatanLanjutan][pilihan]" value="Tidak" {{@$assesment['perawatanLanjutan']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="perawatanLanjutan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label><br/>
                  <input type="radio" id="perawatanLanjutan_2" name="fisik[perawatanLanjutan][pilihan]" value="Ya" {{@$assesment['perawatanLanjutan']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                  <label for="perawatanLanjutan_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  <input type="text" id="perawatanLanjutan_3" name="fisik[perawatanLanjutan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['perawatanLanjutan']['sebutkan']}}">
                </td>
              </tr> 
            </table> --}}
          </div>
         
    {{-- </form> --}}

          <br /><br />
        </div>
      </div>
  </div>

  {{-- Modal List Kontrol ======================================================================== --}}
  <div class="modal fade" id="showListKontrol" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">List Kontrol</h4>
              </div>
              <div class="modal-body">
                  <div id="dataListKontrol">
                      <div class="spinner-square">
                          <div class="square-1 square"></div>
                          <div class="square-2 square"></div>
                          <div class="square-3 square"></div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
    </div>
    {{-- End Modal List Kontrol ======================================================================== --}}

  @endsection

  @section('script')
  
  <script type="text/javascript">
    status_reg = "<?= substr($reg->status_reg,0,1) ?>"

    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        // $("#date_tanpa_tanggal").datepicker( {
        //     format: "mm-yyyy",
        //     viewMode: "months", 
        //     minViewMode: "months"
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");
    
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var dataImage = document.getElementById("dataImage");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = dataImage.src;
        captionText.innerHTML = this.alt;
    }
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
        modal.style.display = "none";
    }
</script>
<script type="text/javascript">
  $(document).ready(function() {
      // Select2 Multiple
      $('.select2-multiple').select2({
          placeholder: "Pilih Multi Tindakan",
          allowClear: true
      });

  });

  // MASTER OBAT
$('#select2Multiple').select2({
    placeholder: "Klik untuk isi nama tindakan",
    width: '100%',
    ajax: {
        url: '/tindakan/ajax-tindakan/'+status_reg,
        dataType: 'json',
        data: function (params) {
            return {
                j: 1,
                q: $.trim(params.term)
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
})

$(document).ready(function() {

  $(document).on('click', '#listKontrol', function(e) {
    var id = $(this).attr('data-dokterID');
    var tgl = $('#waktuKontrol').val();
    
    if(tgl == null || tgl == ''){
      alert('Harap Isi Tanggal Kontrol');
    }else{
      $('#showListKontrol').modal('show');
      $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
    }
  });

  //TINDAKAN entry
  $('select[name="kategoriTarifID"]').on('change', function() {
      var tarif_id = $(this).val();
      if(tarif_id) {
          $.ajax({
              url: '/tindakan/getTarif/'+tarif_id,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  //$('select[name="tarif_id"]').append('<option value=""></option>');
                  $('select[name="tarif_id"]').empty();
                  $.each(data, function(id, nama, total) {
                      $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                  });

              }
          });
      }else{
          $('select[name="tarif_id"]').empty();
      }
  });
});

  $('#historiAskep').click( function(e) {
      var id = $(this).attr('data-pasienID');
      $('#showHistoriAskep').modal('show');
      $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
  });
</script>
<script>
  $('.select2-diagnosis').select2({
        placeholder: "Pilih Diagnosa",
        allowClear: true,
        width: '85%'
    });
    $('.select2-pemeriksaanDalam').select2({
        placeholder: "Pilih Intervensi",
        allowClear: true
    });
    $('.select2-fungsional').select2({
        placeholder: "Pilih Impelemntasi",
        allowClear: true
    });
</script>
  @endsection