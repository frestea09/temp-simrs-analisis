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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_anak/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Asesmen Awal Medis Anak</b></h4>
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
                  <td style="width: 50%; font-weight: bold;">Riwayat Penyakit Dahulu</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[riwayatPenyakitDahulu]" style="display:inline-block; resize: vertical;" placeholder="[Riwayat penyakit dahulu]" class="form-control" >{{@$assesment['riwayatPenyakitDahulu']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Pernah dirawat</td>
                  <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[rencanaRanap][pernah_dirawat]"
                            {{ @$assesment['rencanaRanap']['pernah_dirawat'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[rencanaRanap][pernah_dirawat]"
                            {{ @$assesment['rencanaRanap']['pernah_dirawat'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya, </label>
                        <label class="form-check-label">Kapan</label>
                        <input type="text" name="fisik[rencanaRanap][pernah_dirawat_kapan]" placeholder="Kapan" class="form-control" value="{{@$assesment['rencanaRanap']['pernah_dirawat_kapan']}}">
                        <label class="form-check-label">Dimana</label>
                        <input type="text" name="fisik[rencanaRanap][pernah_dirawat_dimana]" placeholder="Dimana" class="form-control" value="{{@$assesment['rencanaRanap']['pernah_dirawat_dimana']}}">
                        <label class="form-check-label">Diagnosa</label>
                        <textarea rows="3" name="fisik[rencanaRanap][pernah_dirawat_diagnosa]" style="display:inline-block; resize: vertical;" placeholder="[Diagnosa]" class="form-control" >{{@$assesment['rencanaRanap']['pernah_dirawat_diagnosa']}}</textarea>
                    </div>
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
                    <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                    <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp']}}">
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
                  <td style="width: 50%; font-weight: bold;">Antropometri</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[antropometri]" style="display:inline-block; resize: vertical;" placeholder="[Antropometri]" class="form-control" >{{@$assesment['antropometri']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Status Gizi</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[status_gizi]" style="display:inline-block; resize: vertical;" placeholder="[Status Gizi]" class="form-control" >{{@$assesment['status_gizi']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Kepala dan Leher</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[kepala_dan_leher]" style="display:inline-block; resize: vertical;" placeholder="[Kepala dan Leher]" class="form-control" >{{@$assesment['kepala_dan_leher']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="width:50%; font-weight:bold;">Dada dan punggung</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Paru</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][paru]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['paru']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Jantung</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][jantung]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['jantung']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Perut dan pinggang</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][perut_dan_pinggang]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['perut_dan_pinggang']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Anggota gerak</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][anggota_gerak]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['anggota_gerak']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Genitalia dan Anus</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][genitalia_dan_anus]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['genitalia_dan_anus']}}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Pemeriksaan neurologi</label><br/>
                    <input type="number" name="fisik[dada_dan_punggung][pemeriksaan_neurologi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['dada_dan_punggung']['pemeriksaan_neurologi']}}">
                  </td>
                </tr>
              </table>
          </div>
          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 50%; font-weight: bold;">Rekonsiliasi obat dan data obat yang digunakan saat masuk rumah sakit</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[rekonsiliasi_obat]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Rekonsiliasi Obat]" class="form-control" >{{@$assesment['rekonsiliasi_obat']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Riwayat pekerjaan, Sosial ekonomi, Kejiwaan dan kebiasaan</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[riwayat_pekerjaan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Riwayat pekerjaan]" class="form-control" >{{@$assesment['riwayat_pekerjaan']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnosa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosa]" class="form-control" >{{@$assesment['diagnosa']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Prognosa</td>
                </tr>
                <tr>
                  <td>Ad functionam</td>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_functionam]"
                              {{ @$assesment['prognosa']['ad_functionam'] == 'Ad Bonam' ? 'checked' : '' }}
                              type="radio" value="Ad Bonam">
                          <label class="form-check-label">Ad Bonam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_functionam]"
                              {{ @$assesment['prognosa']['ad_functionam'] == 'Ad Malam' ? 'checked' : '' }}
                              type="radio" value="Ad Malam">
                          <label class="form-check-label">Ad Malam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_functionam]"
                              {{ @$assesment['prognosa']['ad_functionam'] == 'Dubia ad Bonam' ? 'checked' : '' }}
                              type="radio" value="Dubia ad Bonam">
                          <label class="form-check-label">Dubia ad Bonam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_functionam]"
                              {{ @$assesment['prognosa']['ad_functionam'] == 'Dubia ad Malam' ? 'checked' : '' }}
                              type="radio" value="Dubia ad Malam">
                          <label class="form-check-label">Dubia ad Malam</label>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td>Ad Vitam</td>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_vitam]"
                              {{ @$assesment['prognosa']['ad_vitam'] == 'Ad Bonam' ? 'checked' : '' }}
                              type="radio" value="Ad Bonam">
                          <label class="form-check-label">Ad Bonam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_vitam]"
                              {{ @$assesment['prognosa']['ad_vitam'] == 'Ad Malam' ? 'checked' : '' }}
                              type="radio" value="Ad Malam">
                          <label class="form-check-label">Ad Malam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_vitam]"
                              {{ @$assesment['prognosa']['ad_vitam'] == 'Dubia ad Bonam' ? 'checked' : '' }}
                              type="radio" value="Dubia ad Bonam">
                          <label class="form-check-label">Dubia ad Bonam</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[prognosa][ad_vitam]"
                              {{ @$assesment['prognosa']['ad_vitam'] == 'Dubia ad Malam' ? 'checked' : '' }}
                              type="radio" value="Dubia ad Malam">
                          <label class="form-check-label">Dubia ad Malam</label>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td>Catatan</td>
                  <td>
                    <textarea rows="3" name="fisik[prognosa][prognosa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Catatan]" class="form-control" >{{@$assesment['prognosa']['prognosa']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Planning</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[planning]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >{{@$assesment['planning']}}</textarea>
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
            <button class="btn btn-success pull-right">Simpan</button>
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
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
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
                          {{ baca_poli($riwayat->registrasi->poli_id) }}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
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
  @endsection