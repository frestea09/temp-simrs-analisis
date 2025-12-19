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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_obgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Asesmen Awal Medis Obgyn</b></h4>
          <br>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5><b>Anamnesis</b></h5>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Keluhan Utama</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[keluhanUtama]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Keluhan Utama]" class="form-control" >{{@$assesment['keluhanUtama']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Riwayat penyakit sekarang</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[riwayat_penyakit_sekarang]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Riwayat penyakit sekarang]" class="form-control" >{{@$assesment['riwayat_penyakit_sekarang']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Riwayat Penyakit Lain lain</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[riwayatPenyakitLain]" style="display:inline-block; resize: vertical;" placeholder="[Riwayat penyakit Lain-lain]" class="form-control" >{{@$assesment['riwayatPenyakitLain']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Riwayat Penyakit Keluarga</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[riwayatPenyakitKeluarga]" style="display:inline-block; resize: vertical;" placeholder="[Riwayat Penyakit Keluarga]" class="form-control" >{{@$assesment['riwayatPenyakitKeluarga']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:bold; width: 50%;">Pemeriksaan Fisik</td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: 500;">a. Keadaan Umum</td>
                  <td>
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
                  <td style="width: 50%; font-weight: 500;">b. Kesadaran</td>
                  <td>
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
                    <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['tekanan_darah']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['nadi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['RR']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                    <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['temp']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                    <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['BB']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                    <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['TB']}}">
                  </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="form-check-label" style="font-weight: normal;">Saturasi</label><br/>
                        <input type="text" name="fisik[tanda_vital][saturasi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['saturasi']}}">
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
                    <textarea rows="3" name="fisik[riwayat_ginekologi]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Riwayat Ginekologi]" class="form-control" >{{@$assesment['riwayat_ginekologi']}}</textarea>
                  </td>
                </tr>
              </table>

              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                    
                    <tr>
                        <td style="font-weight: bold" colspan="2">Riwayat Psikologis</td>
                    </tr>

                    <tr>
                        <td>
                            <div style="display: flex; gap: 10px">
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][takut_terapi]"
                                    {{ @$assesment['riwayat_psikologis']['takut_terapi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Takut terhadap terapi / pembedahan / lingkungan RS</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][marah]"
                                    {{ @$assesment['riwayat_psikologis']['marah'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Marah / Tegang</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][sedih]"
                                    {{ @$assesment['riwayat_psikologis']['sedih'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Sedih</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][kecenderungan_bunuh_diri]"
                                    {{ @$assesment['riwayat_psikologis']['kecenderungan_bunuh_diri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Kecenderungan Bunuh Diri</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="fisik[riwayat_psikologis][lain_lain]"
                                    {{ @$assesment['riwayat_psikologis']['lain_lain'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lain-lain, sebutkan</label>
                                    <input type="text" class="form-control" placeholder="Sebutkan" name="fisik[riwayat_psikologis][lain_detail]" value="{{@$assesment['riwayat_psikologis']['lain_detail']}}" style="width: 100%">
                                </div>
                            </div>
                        </td>
                    </tr>
               </table>
          </div>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Obstetri</td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Kepala</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Kelopak mata</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][kepala][kelopak_mata]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['kepala']['kelopak_mata']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Konjungtiva</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][kepala][konjungtiva]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['kepala']['konjungtiva']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Sclera</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][kepala][sclera]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['kepala']['sclera']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Lain-lain</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][kepala][lain_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['kepala']['lain_lain']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnosa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosa]" class="form-control" >{{@$assesment['diagnosa']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Diagnosa Tambahan</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnosa_tambahan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosa Tambahan]" class="form-control" >{{@$assesment['diagnosa_tambahan']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Buah Dada</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Puting</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][buah_dada][puting]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['buah_dada']['puting']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">ASI</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][buah_dada][asi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['buah_dada']['asi']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Kebersihan</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][buah_dada][kebersihan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['buah_dada']['kebersihan']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Lain-lain</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][buah_dada][lain_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['buah_dada']['lain_lain']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Posterior</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Luka</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_posterior][luka]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_posterior']['luka']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Perut</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">TFU</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][tfu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['tfu']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Leopold I</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][leopold_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['leopold_1']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Leopold II</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][leopold_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['leopold_2']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Leopold III</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][leopold_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['leopold_3']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Leopold IV</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][leopold_4]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['leopold_4']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Leopold DJJ</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][perut][leopold_djj]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['perut']['leopold_djj']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Periksa Dalam</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Pembukaan</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][periksa_dalam][pembukaan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['periksa_dalam']['pembukaan']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Portio</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][periksa_dalam][portio]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['periksa_dalam']['portio']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Ketuban</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][periksa_dalam][ketuban]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['periksa_dalam']['ketuban']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Presentasi</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][periksa_dalam][presentasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['periksa_dalam']['presentasi']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Hodge</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][periksa_dalam][hodge]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['periksa_dalam']['hodge']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Ginekologi</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Inspekulo</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][inspekulo]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['inspekulo']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">inspeksi</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][inspeksi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['inspeksi']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Hymen</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][hymen]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['hymen']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Liang vagina</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][liang_vagina]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['liang_vagina']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Mukoso portio</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][mukoso_portio]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['mukoso_portio']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Fluksus</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][pemeriksaan_ginekologi][fluksus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['fluksus']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;" colspan="2">Palpasi</td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">QUE</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][que]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['que']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Adnexa</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][admexa]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['admexa']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">Parametrium</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][parametrium]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['parametrium']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">CU</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][cu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['cu']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">VU</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][vu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['vu']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: 500;">CD</td>
                    <td>
                        <input type="text" name="fisik[pemeriksaan_obstetri][palpasi][cd]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemeriksaan_obstetri']['palpasi']['cd']}}">
                    </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnossa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnossa]" class="form-control" >{{@$assesment['diagnossa']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Tindakan</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[tindakan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Tindakan]" class="form-control" >{{@$assesment['tindakan']}}</textarea>
                  </td>
                </tr>
                <tr>
                    <td style="width: 50%; font-weight: bold;">Pemeriksaan Penunjang</td>
                    <td style="padding: 5px;">
                      <textarea rows="3" name="fisik[pemeriksaan_penunjang]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Pemeriksaan Penunjang]" class="form-control" >{{@$assesment['pemeriksaan_penunjang']}}</textarea>
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
                            <p style="font-weight: bold;">Dapat Ditetapkan (x Hari)</p>
                                <span>Hari</span>
                                <input class="form-control" placeholder="x Hari" name="fisik[rencanaRanap][dapatDitetapkan][hari]" type="text" value="{{@$assesment['rencanaRanap']['dapatDitetapkan']['hari']}}">
                                <span>Tanggal Pulang</span>
                                <input class="form-control" name="fisik[rencanaRanap][dapatDitetapkan][tanggal]" type="date" value="{{@$assesment['rencanaRanap']['dapatDitetapkan']['tanggal']}}">
                        </div>
                        <div>
                            <p style="font-weight: bold;">Tidak Dapat Ditetapkan</p>
                            <input type="text" name="fisik[rencanaRanap][tidakDapatDitetapkan][alasan]" placeholder="Karena" class="form-control" value="{{@$assesment['rencanaRanap']['tidakDapatDitetapkan']['alasan']}}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Ketika pulang masih memerlukan perawatan lanjutan</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[rencanaRanap][perawatan_lanjutan]"
                                {{ @$assesment['rencanaRanap']['perawatan_lanjutan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[rencanaRanap][perawatan_lanjutan]"
                                {{ @$assesment['rencanaRanap']['perawatan_lanjutan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Ya</label>
                            <input type="text" name="fisik[rencanaRanap][perawatan_lanjutan_ya]" placeholder="Jelaskan" class="form-control" value="{{@$assesment['rencanaRanap']['perawatan_lanjutan_ya']}}">
                        </div>
                    </td>
                </tr>
            </table>
          </div>

          <div class="col-md-12" style="margin-bottom: 2rem;">
            <h5><b>RIWAYAT OBSTETRI</b></h5>
            <div style="display: flex; justify-content:end; margin-bottom: 1rem;">
                <button type="button" class="btn btn-primary btn-sm btn-flat" id="tambah_riwayat_obstetri"><i class="fa fa-plus"></i> Tambah</button>
            </div>
            <table class="border" style="width: 100%;" id="table_riwayat_obstetri">
                {{-- Template Row Table --}}
                <tr class="border" id="daftar_riwayat_obstetri_template" style="display: none;">
                    <td class="border bold p-1 text-center">1</td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][tanggal_lahir]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][jenis_kelamin]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][usia]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][jenis_persalinan]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][tempat_dan_penolong]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][bb_pb]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][asi_eksklusif]" value="" class="form-control"  disabled/>
                    </td>
                    <td class="border bold p-1 text-center">
                        <input type="text" name="fisik[riwayat_obstetri][1][keterangan]" value="" class="form-control"  disabled/>
                    </td>
                </tr>
                {{-- End Template Row Table --}}
                <tr class="border">
                    <td class="border bold p-1 text-center">NO</td>
                    <td class="border bold p-1 text-center">TANGGAL LAHIR</td>
                    <td class="border bold p-1 text-center">JENIS KELAMIN</td>
                    <td class="border bold p-1 text-center">USIA</td>
                    <td class="border bold p-1 text-center">JENIS PERSALINAN</td>
                    <td class="border bold p-1 text-center">TEMPAT & PENOLONG</td>
                    <td class="border bold p-1 text-center">BB & PB</td>
                    <td class="border bold p-1 text-center">ASI EKSKLUSIF</td>
                    <td class="border bold p-1 text-center">KETERANGAN</td>
                </tr>
                @if (isset($assesment['riwayat_obstetri']))
                  @foreach ($assesment['riwayat_obstetri'] as $key => $obat)
                    <tr class="border riwayat_obstetri">
                        <td class="border bold p-1 text-center">{{$key}}</td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][tanggal_lahir]" value="{{$obat['tanggal_lahir']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][jenis_kelamin]" value="{{$obat['jenis_kelamin']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][usia]" value="{{$obat['usia']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][jenis_persalinan]" value="{{$obat['jenis_persalinan']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][tempat_dan_penolong]" value="{{$obat['tempat_dan_penolong']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][bb_pb]" value="{{$obat['bb_pb']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][asi_eksklusif]" value="{{$obat['asi_eksklusif']}}" class="form-control" />
                        </td>
                        <td class="border bold p-1 text-center">
                            <input type="text" name="fisik[riwayat_obstetri][{{$key}}][keterangan]" value="{{$obat['keterangan']}}" class="form-control" />
                        </td>
                    </tr>
                  @endforeach
                @endif
            </table>
        </div>

          <div class="col-md-12">
            <div>
              <button class="btn btn-success pull-right">Simpan</button>
            </div>
          </div>
         
    </form>

          <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Dibuat</th>
                  <th class="text-center" style="vertical-align: middle;">Poli / Ruangan</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
            <tbody>
              
              @if (count($riwayats) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                  </tr>
              @endif
              @foreach ($riwayats as $riwayat)
                  <tr>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y')}}
                    </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        @if ($riwayat->registrasi->rawat_inap)
                            {{baca_kamar($riwayat->registrasi->rawat_inap->kamar_id)}}
                        @else
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        @endif
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <a href="{{ url("emr-soap/pemeriksaan/asesmen_awal_medis_pasien_obgyn/".$unit."/".@$riwayat->registrasi_id."?asessment_id=".@$riwayat->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ url("cetak-eresume-medis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) . "?source=asesmen" }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                            </a>
                        <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="4" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                      <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                    </td>
                  </tr>
              @endforeach
             
            </tbody>
          </table>
        </div>
          <br /><br />
        </div>
      </div>

      @if ($unit == "inap")
        <div class="col-md-12">
          @php
            $biaya_diagnosa_awal = @\App\PaguPerawatan::find($rawatinap->pagu_diagnosa_awal)->biaya ?? 0;
          @endphp
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title pull-left">
                    Total Tagihan Sementara Rp. {{ number_format($tagihan) }}
                </h3>
                <h3 class="box-title pull-right">Deposit : Rp.
                    {{ number_format(App\Deposit::where('registrasi_id', $reg->id)->sum('nominal')) }}</h3>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title pull-left">
                    Biaya Diagnosa Awal {{"Rp. " . number_format($biaya_diagnosa_awal)}}
                </h3>
            </div>
            @if ($biaya_diagnosa_awal > 0)
                <div class="box-header with-border">
                        @php
                            $sisa_biaya  = $biaya_diagnosa_awal - $tagihan;
                            $sisa_persen = sprintf("%.2f", ($sisa_biaya / $biaya_diagnosa_awal) * 100);
                        @endphp
                        @if ($sisa_persen <= 0)
                            <h5 class="pull-left blink_me">
                                Melebihi Biaya Diagnosa Awal {{"Rp. " . number_format($tagihan - $biaya_diagnosa_awal)}}
                            </h5>
                        @else
                            <h5 class="pull-left {{$sisa_persen <= 20 ? 'blink_me' : ''}}">
                                Biaya Diagnosa Awal Tersisa {{"Rp. " . number_format($biaya_diagnosa_awal - $tagihan)}} ({{$sisa_persen . '%'}})
                            </h5>
                        @endif
                </div>
            @endif
            <div class="box-body">
                <div class="box box-info">
                    <div class="box-body">
                        {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/entry-tindakan/save', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('jenis', $reg->bayar) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('dokter_id', @$rawatinap->dokter_id ? @$rawatinap->dokter_id : $reg->dokter_id) !!}
                        <div class="row">
                            <div class="col-md-7">
        
                                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-10">
                                        {{-- {!! Form::select('pelaksana', $dokter, session('pelaksana') ? session('pelaksana') : null, ['class' => 'select2', 'style'=>'width:100%']) !!} --}}
                                        <select name="pelaksana" class="select2 form-control" style="width: 100%">
                                            <option value="" selected>Pilih Pelaksana</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ @$rawatinap->dokter_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                    </div>
                                </div>
        
                                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-10">
                                        <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                                            multiple></select>
                                        <small class="text-info">Pilihan Tarif mengikuti kolom pilihan <b>Kelas</b>, tanpa harus
                                            mutasi</small>
                                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                    </div>
                                </div>
        
                                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                    </div>
                                    {!! Form::label('bayar', 'Bayar', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="cara_bayar_id" class="chosen-select">
                                            @foreach ($carabayar as $key => $item)
                                                @if ($key == $reg->bayar)
                                                    <option value="{{ $key }}" selected>{{ $item }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
                                    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="kelas_id" class="select2 form-control">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kelas as $key => $item)
                                                <option value="{{ $key }}"
                                                    {{ $key == @$rawatinap->kelas->id ? 'selected' : '' }}>{{ $item }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('waktu_visit_dokter') ? ' has-error' : '' }}">
                                    {!! Form::label('waktu_visit_dokter', 'Waktu Visit Dokter', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" name="waktu_visit_dokter">
                                        <small class="text-danger">{{ $errors->first('waktu_visit_dokter') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                                    {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        <select name="cyto" id="" class="form-control">
                                            <option value="" selected>Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('cyto') }}</small>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                    </div>
                                    <input type="hidden" name="dijamin" value="0">
                                    <div class="col-sm-4">
                                        <div class="btn-group pull-left">
                                            {!! Form::submit('Simpan', [
                                                'class' => 'btn btn-success btn-flat',
                                                'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
        
                            </div>
        
                            <div class="col-md-5">
                                <div class='table-responsive' style="overflow: hidden;">
                                    <table class='table-striped table-bordered table-hover table-condensed table'>
                                        <tbody>
                                            <tr>
                                                <th>Nama Pasien</th>
                                                <td>{{ $reg->pasien->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>No. RM</th>
                                                <td>{{ $reg->pasien->no_rm }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $reg->pasien->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cara Bayar</th>
                                                <td>{{ baca_carabayar($reg->bayar) }}
                                                    @if ($reg->bayar == '1')
                                                        @if (!empty($reg->tipe_jkn))
                                                            - {{ $reg->tipe_jkn }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($reg->bayar == '1')
                                                <tr>
                                                    <th>No. SEP</th>
                                                    <td>{{ $reg->no_sep ? $reg->no_sep : @\App\HistoriSep::where('registrasi_id', $reg->id)->first()->no_sep }}
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <th>Hak Kelas JKN </th>
                                                    <td>{{ $reg->hak_kelas_inap }}</td>
                                                </tr> --}}
                                            @endif
                                            <tr>
                                                {{-- <th>Kelas Perawatan </th> <td>{{ baca_kelas($reg->kelas_id) }}</td> --}}
                                                <th>Kelas Perawatan </th>
                                                <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                                @php
                                                    session(['kelas_id' => @$reg->kelas_id]);
                                                @endphp
                                            </tr>
                                            {{-- <tr>
                                                <th>DPJP IGD</th>
                                                <td>{{ baca_dokter($reg->dokter_id) }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>DPJP UTAMA</th>
                                                <td> <b> {{ baca_dokter(@$rawatinap->dokter_id) }} </b></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <td> {{ tanggal_eklaim(@$rawatinap->tgl_masuk) }} </td>
                                            </tr>
                                            <tr>
                                                <th>Kamar </th>
                                                <td>{{ baca_kamar(@$rawatinap->kamar_id) }}</td>
                                            </tr>
                                            <tr>
                                                <th>ICD 9</th>
                                                <td>
                                                  @if (!empty($icd9))
                                                      {{ implode(',', $icd9) }}
                                                  @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ICD 10</th>
                                                <td> 
                                                    @if (!empty($icd10))
                                                        {{ implode(',', $icd10) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Diagnosa Awal</th>
                                                <th>
                                                    <div class="form-group">
                                                        <div style="margin-left: 18px; width: 90%">
                                                            {{-- <input type="number" class="form-control" name="biaya_diagnosa_awal" value="{{$rawatinap->total_biaya_diagnosa_awal}}"> --}}
                                                            <select name="biaya_diagnosa_awal" class="form-control select2" id="" style="width: 100%;">
                                                                <option value="">-- Pilih --</option>
                                                                @foreach ($pagu as $p)
                                                                    <option value="{{ $p->id }}" {{$p->id == @$rawatinap->pagu_diagnosa_awal ? 'selected' : ''}}>{{ $p->diagnosa_awal .' - '.$p->biaya }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>
                                                    <button class="btn btn-success" type="button" id="update_diagnosa_awal"><i class="fa fa-save"></i></button>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
        
        
                    </div>
                </div>
                {{-- ======================================================================================================================= --}}
                <div class="dataTindakanIrna">
                    {{-- progress bar --}}
                    <div class="progress progress-sm active">
                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">97% Complete</span>
                        </div>
                    </div>
                </div>
        
                <div class="pull-right">
                    <a href="{{ url('rawat-inap/billing') }}" class="btn btn-primary btn-sm btn-flat"><i
                            class="fa fa-step-backward"></i> SELESAI</a>
                </div>
        
            </div>
          </div>
          
          <div class="modal fade" id="editTindakanModal">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"></h4>
                      </div>
                      <div class="modal-body">
                          {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'id' => 'editTindakanForm']) !!}
                          <input type="hidden" name="folio_id" value="">
                          <input type="hidden" name="registrasi_id" value="">
                          <input type="hidden" name="id_tarif" value="">
          
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                                      {!! Form::label('dpjp', 'DPJP IRNA', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          <select name="dpjp" class="select2form-control" style="width: 100%">
                                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                              @endforeach
                                          </select>
                                          <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                                      </div>
                                  </div>
                                  <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                      {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          <select name="pelaksana" class="form-control" style="width: 100%">
                                              @foreach ($dokter as $d)
                                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                              @endforeach
                                          </select>
                                          <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                      </div>
                                  </div>
          
                                  <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                                      {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          <select name="perawat" class="form-control select2" style="width: 100%">
                                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                              @endforeach
                                          </select>
                                          <small class="text-danger">{{ $errors->first('perawat') }}</small>
                                      </div>
                                  </div>
          
                                  <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                      {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          <select class="form-control select2" name="tarif_id" style="width: 100%">
                                              @foreach (Modules\Tarif\Entities\Tarif::whereIn('jenis', ['TI'])->get() as $d)
                                                  <option value="{{ $d->id }}">{{ $d->kode }} |
                                                      {{ $d->nama }} | {{ number_format($d->total) }}</option>
                                              @endforeach
                                          </select>
                                          <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                      </div>
                                  </div>
          
                                  <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                      {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                          <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                      </div>
                                  </div>
          
                                  <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                                      {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          <select name="cara_bayar_id" class="select2 form-control" style="width: 100%">
                                              @foreach ($carabayar as $key => $item)
                                                  @if ($key == $reg->bayar)
                                                      <option value="{{ $key }}" selected>{{ $item }}</option>
                                                  @else
                                                      <option value="{{ $key }}">{{ $item }}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                          <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                                      </div>
                                  </div>
          
                                  <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                      {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                          <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                      </div>
                                  </div>
                                  <div class="form-group{{ $errors->has('dijamin') ? ' has-error' : '' }}">
                                      {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-3 control-label']) !!}
                                      <div class="col-sm-9">
                                          {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                                          <small class="text-danger">{{ $errors->first('dijamin') }}</small>
                                      </div>
                                  </div>
                              </div>
                              {!! Form::close() !!}
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                              <button type="button" class="btn btn-primary btn-flat"
                                  onclick="saveEditTindakan()">Simpan</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      @endif
  </div>

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
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>

  <script>
    let key= $('.riwayat_obstetri').length + 1;
    $('#tambah_riwayat_obstetri').click(function (e) {
        let row = $('#daftar_riwayat_obstetri_template').clone();
        row.removeAttr('id').removeAttr('style');
        row.find('td:first').text(key);

        row.find('input[name^="fisik[riwayat_obstetri]"]').each(function() {
            let newName = $(this).attr('name').replace(/\d+/, key);
            $(this).attr('name', newName);
            $(this).prop('disabled', false);
        });

        key++;
        $('#table_riwayat_obstetri').append(row);
    });
  </script>

@if ($unit == "inap")
<script type="text/javascript">
  $(".skin-blue").addClass("sidebar-collapse");
  $(function() {
      //LOAD TINDAKAN IRNA
      var registrasi_id = $('input[name="registrasi_id"]').val()
      var loadData = $('.dataTindakanIrna').load('/rawat-inap/data-tindakan/' + registrasi_id);
      if (loadData == true) {
          $('.progress').addClass('hidden')
      }
  });
  // status_reg = "<?= substr($reg->status_reg, 0, 1) ?>"
  status_reg = "I"
  var settings = {
      kelas_id: "<?= @$rawatinap->kelas_id ? $rawatinap->kelas_id : 8 ?>"
  };
  // $('select[name="kelas_id"]').change(function(){
  //   settings.kelas_id = $('select[name="kelas_id"]').val()
  // });
  // function getURL() {
  //     $('select[name="kelas_id"]').change(function(){
  //       settings.kelas_id = $('select[name="kelas_id"]').val()
  //     });
  //     let kelas_id = $('select[name="kelas_id"]').val()
  //     return '/tindakan/ajax-tindakan/'+status_reg+'/'+kelas_id;
  // }


  // console.log(settings.kelas_id)
  $('.select2').select2();

  let kelas_id = $('select[name="kelas_id"]').val()

  $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama tindakan",
      width: '100%',
      ajax: {
          url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
          dataType: 'json',
          data: function(params) {
              return {
                  j: 1,
                  q: $.trim(params.term)
              };
          },
          escapeMarkup: function(markup) {
              return markup;
          },
          processResults: function(data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  function cloneDiagnosis() {
      let templateElement = $('#template-diagnosis');
      let clonedElement = templateElement.clone(); // Clone the template element
      clonedElement.removeAttr('id'); // Remove id attribute to avoid duplicate ids
      clonedElement.show(); // Ensure the cloned element is visible (if it was hidden)

      clonedElement.find('.new-diagnosa').select2();
      clonedElement.find('.new-diagnosa').attr('disabled', false);

      clonedElement.insertBefore(templateElement);
  }





  $('#update_diagnosa_awal').click(function (e) {
      e.preventDefault();
      if (confirm('Apakah anda yakin ingin mengganti Biaya Diagnosa awal?')) {
          var registrasi_id = $('input[name="registrasi_id"]').val()
          let biaya = $('select[name="biaya_diagnosa_awal"]').val()
          $.ajax({
              url: '/rawat-inap/entry-tindakan/update/pagu/' + registrasi_id,
              type: 'POST',
              data: {
                  "biaya_diagnosa_awal": biaya,
                  "_token": "{{ csrf_token() }}",
              },
              dataType: 'json',
              success: function(data) {
                  if (data == "ok") {
                      location.reload();
                  }
              }
          });
      }
  })

  // on kelas change
  $('select[name="kelas_id"]').on('change', function() {
      kelas_id = $(this).val();
      console.log(kelas_id);
      $('#select2Multiple').select2({
          placeholder: "Klik untuk isi nama tindakan",
          width: '100%',
          ajax: {
              url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
              dataType: 'json',
              data: function(params) {
                  return {
                      j: 1,
                      q: $.trim(params.term)
                  };
              },
              escapeMarkup: function(markup) {
                  return markup;
              },
              processResults: function(data) {
                  return {
                      results: data
                  };
              },
              cache: true
          }
      })
  });

  function editTindakan(folio_id, tarif_id) {
      $('#editTindakanModal').modal('show');
      $('.modal-title').text('Edit Tindakan');
      $('.select2').select2();
      $.ajax({
          url: '/rawat-inap/edit-tindakan/' + folio_id + '/' + tarif_id,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
              console.log(data);
              if (tarif_id != 10000) {
                  $('input[name="folio_id"]').val(data.folio.id);
                  $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                  $('input[name="id_tarif"]').val(data.folio.tarif_id);

                  $('select[name="dpjp"]').val(data.dokter.dokter_id).trigger('change');
                  $('select[name="pelaksana"]').val(data.folio.dokter_pelaksana).trigger('change');
                  $('select[name="perawat"]').val(data.folio.perawat).trigger('change');
                  $('select[name="cara_bayar_id"]').val(data.folio.cara_bayar_id).trigger('change');
                  $('select[name="tarif_id"]').val(data.folio.tarif_id).trigger('change');
                  $('input[name="dijamin"]').val(data.folio.dijamin);
              } else {
                  $('input[name="folio_id"]').val(data.folio.id);
                  $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                  $('input[name="id_tarif"]').val(data.folio.tarif_id);
              }
          }
      });
  }

  function saveEditTindakan() {
      var data = $('#editTindakanForm').serialize();
      $.ajax({
          url: '/rawat-inap/save-edit-tindakan',
          type: 'POST',
          dataType: 'json',
          data: data,
          success: function(data) {
              if (data.sukses == true) {
                  $('#editTindakanModal').modal('hide');
                  location.reload();
              }
          }
      });
  }

  function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  $('select[name="kategoritarif_id"]').on('change', function() {
      var tarif_id = $(this).val();
      var reg_id = {{ $reg_id }}
      if (tarif_id) {
          $.ajax({
              url: '/rawat-inap/getKategoriTarifID/' + tarif_id + '/' + reg_id,
              type: "GET",
              dataType: "json",
              success: function(data) {
                  //$('select[name="tarif_id"]').append('<option value=""></option>');
                  $('select[name="tarif_id"]').empty();
                  $.each(data, function(key, value) {
                      $('select[name="tarif_id"]').append('<option value="' + value.id +
                          '">' + value.nama + ' | ' + ribuan(value.total) +
                          '</option>');
                  });

              }
          });
      } else {
          $('select[name="tarif_id"]').empty();
      }
  });

  // tindakan inhealth
  $(document).on('click', '.inhealth-tindakan', function() {
      let id = $(this).attr('data-id');
      let body = {
          _token: "{{ csrf_token() }}",
          poli: $('input[name="poli_inhealth"]').val(),
          kodedokter: $('input[name="dokter_pelaksana_inhealth"]').val(),
          nosjp: $('input[name="no_sjp_inhealth"]').val(),
          jenispelayanan: $('input[name="jenis_pelayanan_inhealth"]').val(),
          kodetindakan: $('input[name="kode_tindakan_inhealth"]').val(),
          tglmasukrawat: $('input[name="tglmasukrawat"]').val()
      };
      if (confirm('Yakin akan di Sinkron Inhealth?')) {
          $.ajax({
              url: '/tindakan/inhealth/' + id,
              type: "POST",
              data: body,
              dataType: "json",
              beforeSend: function() {
                  $('button#btn-' + id).prop("disabled", true);
              },
              success: function(res) {
                  $('button#btn-' + id).prop("disabled", false);
                  if (res.status == true) {
                      $('button#btn-' + id).prop("disabled", true);
                      alert(res.msg);
                  } else {
                      alert(res.msg);
                  }
              }
          });
      }
  })
  $('select[name="bayar"]').on('change', function() {
      $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
          location.reload();
      });
  })
</script>
@endif
  @endsection