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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neonatus/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Asesmen Awal Medis Neonatus</b></h4>
          <br>

          <div class="row">
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <h5><b>DIKIRIM OLEH</b></h5>
                  <tr>
                    <td colspan="2">
                      <div>
                        <input class="form-check-input"
                            name="fisik[dikirm_oleh][kamar_bersalin]"
                            {{ @$assesment['dikirm_oleh']['kamar_bersalin'] == 'Kamar bersalin RS Otista' ? 'checked' : '' }}
                            type="checkbox" value="Kamar bersalin RS Otista">
                        <label class="form-check-label" style="font-weight: 400;">Kamar bersalin RS Otista</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[dikirm_oleh][dokter]"
                            {{ @$assesment['dikirm_oleh']['dokter'] == 'Dokter' ? 'checked' : '' }}
                            type="checkbox" value="Dokter">
                        <label class="form-check-label" style="font-weight: 400;">Dokter</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[dikirm_oleh][bidan]"
                            {{ @$assesment['dikirm_oleh']['bidan'] == 'Bidan' ? 'checked' : '' }}
                            type="checkbox" value="Bidan">
                        <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[dikirm_oleh][paraji]"
                            {{ @$assesment['dikirm_oleh']['paraji'] == 'Paraji' ? 'checked' : '' }}
                            type="checkbox" value="Paraji">
                        <label class="form-check-label" style="font-weight: 400;">Paraji</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[dikirm_oleh][lain_lain]"
                            {{ @$assesment['dikirm_oleh']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                            type="checkbox" value="Lain-lain">
                        <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                        <input type="text" name="fisik[dikirim_oleh][lain_detail]" style="display:inline-block; width: 100px;" placeholder="Lain-lain" class="form-control" id="" value="{{@$assesment['dikirim_oleh']['lain_detail']}}">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Nama</td>
                    <td style="padding: 5px;">
                      <input type="text" name="fisik[dikirim_oleh][nama]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dikirim_oleh']['nama'] ?? @$reg->pasien->nama}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Alamat</td>
                    <td style="padding: 5px;">
                      <input type="text" name="fisik[dikirim_oleh][alamat]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dikirim_oleh']['alamat'] ?? @$reg->pasien->alamat}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Atas Indikasi</td>
                    <td style="padding: 5px;">
                      <input type="text" name="fisik[dikirim_oleh][atas_indikasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dikirim_oleh']['atas_indikasi']}}">
                    </td>
                  </tr>
              </table>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5><b>RIWAYAT KEHAMILAN</b></h5>
                <tr>
                  <td style="font-weight: bold;">Kehamilan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][kehamilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['kehamilan']}}">
                  </td>
                  <td style="font-weight: bold;">Minggu</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][minggu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['minggu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Obat-obatan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][obat]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['obat']}}">
                  </td>
                  <td style="font-weight: bold;">Lamanya</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][lamanya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['lamanya']}}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Jamu-jamu</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][jamu_jamu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['jamu_jamu']}}">
                  </td>
                  <td style="font-weight: bold;">Lamanya</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[riwayat_kehamilan][lamanya_jamu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['lamanya_jamu']}}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Usia Kehamilan</td>
                  <td style="padding: 5px;" colspan="3">
                    <input type="text" name="fisik[riwayat_kehamilan][usia_kehamilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['usia_kehamilan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Komplikasi</td>
                  <td style="padding: 5px;" colspan="3">
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][eklampsia]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['eklampsia'] == 'Eklampsia' ? 'checked' : '' }}
                            type="checkbox" value="Eklampsia">
                        <label class="form-check-label" style="font-weight: 400;">Eklampsia</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][febris]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['febris'] == 'Febris' ? 'checked' : '' }}
                            type="checkbox" value="Febris">
                        <label class="form-check-label" style="font-weight: 400;">Febris</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][perdarahan]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['perdarahan'] == 'Perdarahan' ? 'checked' : '' }}
                            type="checkbox" value="Perdarahan">
                        <label class="form-check-label" style="font-weight: 400;">Perdarahan</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][hipertensi]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['hipertensi'] == 'Hipertensi' ? 'checked' : '' }}
                            type="checkbox" value="Hipertensi">
                        <label class="form-check-label" style="font-weight: 400;">Hipertensi</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][anemia]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['anemia'] == 'Anemia' ? 'checked' : '' }}
                            type="checkbox" value="Anemia">
                        <label class="form-check-label" style="font-weight: 400;">Anemia</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][komplikasi][lain_lain]"
                            {{ @$assesment['riwayat_kehamilan']['komplikasi']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                            type="checkbox" value="Lain-lain">
                        <label class="form-check-label" style="font-weight: 400;">Lain-lain</label> <br>
                        <input type="text" name="fisik[riwayat_kehamilan][komplikasi][lain_detail]" style="display:inline-block;" placeholder="Lain-lain" class="form-control" id="" value="{{@$assesment['riwayat_kehamilan']['komplikasi']['lain_detail']}}">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Gizi</td>
                  <td style="padding: 5px;" colspan="3">
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][baik]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['baik'] == 'Baik' ? 'checked' : '' }}
                            type="checkbox" value="Baik">
                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][kurang_baik]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['kurang_baik'] == 'Kurang baik' ? 'checked' : '' }}
                            type="checkbox" value="Kurang baik">
                        <label class="form-check-label" style="font-weight: 400;">Kurang baik</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][buruk]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['buruk'] == 'Buruk' ? 'checked' : '' }}
                            type="checkbox" value="Buruk">
                        <label class="form-check-label" style="font-weight: 400;">Buruk</label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Pemeriksaan antenatal</td>
                  <td style="padding: 5px;" colspan="3">
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][tidak_pernah]"
                            {{ @$assesment['riwayat_kehamilan']['pemeriksaan_antanetal']['tidak_pernah'] == 'Tidak pernah' ? 'checked' : '' }}
                            type="checkbox" value="Tidak pernah">
                        <label class="form-check-label" style="font-weight: 400;">Tidak pernah</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][tidak_teratur]"
                            {{ @$assesment['riwayat_kehamilan']['pemeriksaan_antanetal']['tidak_teratur'] == 'Tidak teratur' ? 'checked' : '' }}
                            type="checkbox" value="Tidak teratur">
                        <label class="form-check-label" style="font-weight: 400;">Tidak teratur</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][teratur]"
                            {{ @$assesment['riwayat_kehamilan']['pemeriksaan_antanetal']['teratur'] == 'Teratur' ? 'checked' : '' }}
                            type="checkbox" value="Teratur">
                        <label class="form-check-label" style="font-weight: 400;">Teratur</label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Gizi</td>
                  <td style="padding: 5px;" colspan="3">
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][baik]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['baik'] == 'Baik' ? 'checked' : '' }}
                            type="checkbox" value="Baik">
                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][kurang_baik]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['kurang_baik'] == 'Kurang baik' ? 'checked' : '' }}
                            type="checkbox" value="Kurang baik">
                        <label class="form-check-label" style="font-weight: 400;">Kurang baik</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kehamilan][gizi][buruk]"
                            {{ @$assesment['riwayat_kehamilan']['gizi']['buruk'] == 'Buruk' ? 'checked' : '' }}
                            type="checkbox" value="Buruk">
                        <label class="form-check-label" style="font-weight: 400;">Buruk</label>
                      </div>
                    </div>
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
                <h5><b>KELAHIRAN SEKARANG</b></h5>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Tempat</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][tempat]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['tempat']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Tgl.Lahir/tahun</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][tgl_lahir]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['tgl_lahir']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Pukul</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][pukul]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['pukul']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">BB</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][bb]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['bb']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Panjang</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][panjang]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['panjang']}}">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][lahir_mati]"
                          {{ @$assesment['kelahiran_sekarang']['lahir_mati'] == 'Lahir mati' ? 'checked' : '' }}
                          type="checkbox" value="Lahir mati">
                      <label class="form-check-label" style="font-weight: 400;">Lahir mati</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][lahir_hidup]"
                          {{ @$assesment['kelahiran_sekarang']['lahir_hidup'] == 'Lahir hidup' ? 'checked' : '' }}
                          type="checkbox" value="Lahir hidup">
                      <label class="form-check-label" style="font-weight: 400;">Lahir hidup</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][dirumah_bersalin]"
                          {{ @$assesment['kelahiran_sekarang']['dirumah_bersalin'] == 'Dirumah bersalin' ? 'checked' : '' }}
                          type="checkbox" value="Dirumah bersalin">
                      <label class="form-check-label" style="font-weight: 400;">Dirumah bersalin</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][dokter]"
                          {{ @$assesment['kelahiran_sekarang']['dokter'] == 'Dokter' ? 'checked' : '' }}
                          type="checkbox" value="Dokter">
                      <label class="form-check-label" style="font-weight: 400;">Dokter</label>
                      <input type="text" name="fisik[kelahiran_sekarang][dokter_detail]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['dokter_detail']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][dirumah_sakit]"
                          {{ @$assesment['kelahiran_sekarang']['dirumah_sakit'] == 'Dirumah sakit' ? 'checked' : '' }}
                          type="checkbox" value="Dirumah sakit">
                      <label class="form-check-label" style="font-weight: 400;">Dirumah sakit</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][bidan]"
                          {{ @$assesment['kelahiran_sekarang']['bidan'] == 'Bidan' ? 'checked' : '' }}
                          type="checkbox" value="Bidan">
                      <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                      <input type="text" name="fisik[kelahiran_sekarang][bidan_detail]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['bidan_detail']}}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][dirumah]"
                          {{ @$assesment['kelahiran_sekarang']['dirumah'] == 'Dirumah' ? 'checked' : '' }}
                          type="checkbox" value="Dirumah">
                      <label class="form-check-label" style="font-weight: 400;">Dirumah</label>
                    </div>
                    <div>
                      <input class="form-check-input"
                          name="fisik[kelahiran_sekarang][paraji]"
                          {{ @$assesment['kelahiran_sekarang']['paraji'] == 'Paraji' ? 'checked' : '' }}
                          type="checkbox" value="Paraji">
                      <label class="form-check-label" style="font-weight: 400;">Paraji</label>
                      <input type="text" name="fisik[kelahiran_sekarang][paraji_detail]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['paraji_detail']}}">
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                {{-- <h5><b>Ibu</b></h5> --}}
                <tr>
                  <td style="width: 50%; font-weight: bold;">Nama Ibu</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][text]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['text']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['text']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Perkawinan ke</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][perkawinan_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['perkawinan_ke']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['perkawinan_ke']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Usia Pernikahan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][usia_pernikahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['usia_pernikahan']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['usia_pernikahan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Umur</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][umur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['umur']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['umur']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Penghasilan/bulan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][penghasilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['penghasilan']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['penghasilan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Pendidikan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][pendidikan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['pendidikan']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['pendidikan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Penyakit</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][penyakit]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['penyakit']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['penyakit']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Golongan darah</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ibu][golongan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['golongan_darah']  ?? @$perinatologi['kelahiran_sekarang']['ibu']['golongan_darah']}}">
                  </td>
                </tr>
              </table>
            </div>
  
            <div class="col-md-6">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                {{-- <h5><b>Ayah</b></h5> --}}
                <tr>
                  <td style="width: 50%; font-weight: bold;">Nama Ayah</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][text]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['text']  ?? @$perinatologi['kelahiran_sekarang']['ayah']['text']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Perkawinan ke</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][perkawinan_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['perkawinan_ke'] ?? @$perinatologi['kelahiran_sekarang']['ayah']['perkawinan_ke']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Usia Pernikahan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][usia_pernikahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['usia_pernikahan'] ?? @$perinatologi['kelahiran_sekarang']['ayah']['usia_pernikahan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Umur</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][umur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['umur'] ?? @$perinatologi['kelahiran_sekarang']['ayah']['umur']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Penghasilan/bulan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][penghasilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['penghasilan']  ?? @$perinatologi['kelahiran_sekarang']['ayah']['penghasilan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Pendidikan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][pendidikan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['pendidikan']  ?? @$perinatologi['kelahiran_sekarang']['ayah']['pendidikan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Penyakit</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][penyakit]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['penyakit']  ?? @$perinatologi['kelahiran_sekarang']['ayah']['penyakit']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Golongan darah</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[kelahiran_sekarang][ayah][golongan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['golongan_darah']  ?? @$perinatologi['kelahiran_sekarang']['ayah']['golongan_darah']}}">
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" style="margin-bottom: 2rem;">
              <h5><b>PERSALINAN</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 50%; font-weight: bold;">Jenis persalinan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[persalinan][jenis_persalinan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['persalinan']['jenis_persalinan']}}">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div>
                      <input class="form-check-input"
                          name="fisik[persalinan][spontan]"
                          {{ @$assesment['persalinan']['spontan'] == 'Spontan' ? 'checked' : '' }}
                          type="checkbox" value="Spontan">
                      <label class="form-check-label" style="font-weight: 400;">Spontan</label>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][buatan]"
                            {{ @$assesment['persalinan']['buatan'] == 'Buatan' ? 'checked' : '' }}
                            type="checkbox" value="Buatan">
                        <label class="form-check-label" style="font-weight: 400;">Buatan</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][sc]"
                            {{ @$assesment['persalinan']['sc'] == 'SC' ? 'checked' : '' }}
                            type="checkbox" value="SC">
                        <label class="form-check-label" style="font-weight: 400;">SC</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][ektr_kaki_bokong]"
                            {{ @$assesment['persalinan']['ektr_kaki_bokong'] == 'Ektr. Kaki/Bokong' ? 'checked' : '' }}
                            type="checkbox" value="Ektr. Kaki/Bokong">
                        <label class="form-check-label" style="font-weight: 400;">Ektr. Kaki/Bokong</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][ektr_vac]"
                            {{ @$assesment['persalinan']['ektr_vac'] == 'Ektr. Vac' ? 'checked' : '' }}
                            type="checkbox" value="Ektr. Vac">
                        <label class="form-check-label" style="font-weight: 400;">Ektr. Vac</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][ektr_forc]"
                            {{ @$assesment['persalinan']['ektr_forc'] == 'Ektr. Forc' ? 'checked' : '' }}
                            type="checkbox" value="Ektr. Forc">
                        <label class="form-check-label" style="font-weight: 400;">Ektr. Forc</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][versixtr]"
                            {{ @$assesment['persalinan']['versixtr'] == 'Versixtr' ? 'checked' : '' }}
                            type="checkbox" value="Versixtr">
                        <label class="form-check-label" style="font-weight: 400;">Versixtr</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][lain]"
                            {{ @$assesment['persalinan']['lain'] == 'Lain' ? 'checked' : '' }}
                            type="checkbox" value="Lain">
                        <label class="form-check-label" style="font-weight: 400;">Lain</label>
                        <input type="text" name="fisik[persalinan][lain_detail]" style="display:inline-block; width: 100px;" placeholder="Lain-lain" class="form-control" id="" value="{{@$assesment['persalinan']['lain_detail']}}">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Indikasi</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[persalinan][indikasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['persalinan']['indikasi']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Obat-obatan selama persalinan</td>
                  <td style="padding: 5px;">
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][obat_obatan][anestesi]"
                            {{ @$assesment['persalinan']['obat_obatan']['anestesi'] == 'Anestesi' ? 'checked' : '' }}
                            type="checkbox" value="Anestesi">
                        <label class="form-check-label" style="font-weight: 400;">Anestesi</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][obat_obatan][analgetik]"
                            {{ @$assesment['persalinan']['obat_obatan']['analgetik'] == 'Analgetik' ? 'checked' : '' }}
                            type="checkbox" value="Analgetik">
                        <label class="form-check-label" style="font-weight: 400;">Analgetik</label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[persalinan][obat_obatan][lain_lain]"
                            {{ @$assesment['persalinan']['obat_obatan']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                            type="checkbox" value="Lain-lain">
                        <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                        <input type="text" name="fisik[persalinan][obat_obatan][lain_detail]" style="display:inline-block; width: 100px;" placeholder="Lain-lain" class="form-control" id="" value="{{@$assesment['persalinan']['obat_obatan']['lain_detail']}}">
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-12" style="margin-bottom: 2rem;">
              <h5><b>TANDA FETAL</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 50%; font-weight: bold;">Distress</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                          name="fisik[tanda_vital][distress][tidak_ada]"
                          {{ @$assesment['tanda_vital']['distress']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                          type="checkbox" value="Tidak ada">
                      <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][distress][ada]"
                            {{ @$assesment['tanda_vital']['distress']['ada'] == 'Ada' ? 'checked' : '' }}
                            type="checkbox" value="Ada">
                        <label class="form-check-label" style="font-weight: 400;">Ada : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][distress][dj160]"
                            {{ @$assesment['tanda_vital']['distress']['dj160'] == '> Dj. 160' ? 'checked' : '' }}
                            type="checkbox" value="> Dj. 160">
                        <label class="form-check-label" style="font-weight: 400;">> Dj. 160 : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][distress][dj_irreguler]"
                            {{ @$assesment['tanda_vital']['distress']['dj_irreguler'] == 'Dj. Irreguler' ? 'checked' : '' }}
                            type="checkbox" value="Dj. Irreguler">
                        <label class="form-check-label" style="font-weight: 400;">Dj. Irreguler : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][distress][dj_100]"
                            {{ @$assesment['tanda_vital']['distress']['dj_100'] == '< Dj. 100' ? 'checked' : '' }}
                            type="checkbox" value="< Dj. 100">
                        <label class="form-check-label" style="font-weight: 400;">< Dj. 100 : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][distress][meconium]"
                            {{ @$assesment['tanda_vital']['distress']['meconium'] == 'Meconium' ? 'checked' : '' }}
                            type="checkbox" value="Meconium">
                        <label class="form-check-label" style="font-weight: 400;">Meconium : </label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Air Ketuban</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                          name="fisik[tanda_vital][air_ketuban][biasa]"
                          {{ @$assesment['tanda_vital']['air_ketuban']['biasa'] == 'Biasa' ? 'checked' : '' }}
                          type="checkbox" value="Biasa">
                      <label class="form-check-label" style="font-weight: 400;">Biasa</label>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][luar_biasa]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['luar_biasa'] == 'Luar biasa' ? 'checked' : '' }}
                            type="checkbox" value="Luar biasa">
                        <label class="form-check-label" style="font-weight: 400;">Luar biasa : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][keruh]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['keruh'] == 'Keruh' ? 'checked' : '' }}
                            type="checkbox" value="Keruh">
                        <label class="form-check-label" style="font-weight: 400;">Keruh : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][berbau]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['berbau'] == 'Berbau' ? 'checked' : '' }}
                            type="checkbox" value="Berbau">
                        <label class="form-check-label" style="font-weight: 400;">Berbau : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][kurang]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['kurang'] == 'Kurang' ? 'checked' : '' }}
                            type="checkbox" value="Kurang">
                        <label class="form-check-label" style="font-weight: 400;">Kurang : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][berwarna]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['berwarna'] == 'Berwarna' ? 'checked' : '' }}
                            type="checkbox" value="Berwarna">
                        <label class="form-check-label" style="font-weight: 400;">Berwarna : </label>
                      </div>
                      <div>
                        <input class="form-check-input"
                            name="fisik[tanda_vital][air_ketuban][2liter]"
                            {{ @$assesment['tanda_vital']['air_ketuban']['2liter'] == '> 2 Liter' ? 'checked' : '' }}
                            type="checkbox" value="> 2 Liter">
                        <label class="form-check-label" style="font-weight: 400;">> 2 Liter : </label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Lamanya persalinan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][lamanya_persalinan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['lamanya_persalinan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Letak anak</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][letak_anak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['letak_anak']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Kehamilan tunggal / kembar</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][kehamilan_tunggal_kembar]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['kehamilan_tunggal_kembar']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Talipusat : Panjang</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][talipusat_panjang]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['talipusat_panjang']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Kelainan</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][kelainan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['kelainan']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Plasenta berat</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][plasenta_berat]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['plasenta_berat']}}">
                    <span>Ukuran</span>
                    <div class="btn-group" style="display: flex">
                      <input type="text" name="fisik[tanda_vital][ukuran][1]" value="{{@$assesment['tanda_vital']['ukuran']['1']}}" class="form-control" />
                      <button type="button" class="btn btn-default">x</button>
                      <input type="text" name="fisik[tanda_vital][ukuran][2]" value="{{@$assesment['tanda_vital']['ukuran']['2']}}" class="form-control" />
                      <button type="button" class="btn btn-default">cm</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Jumlah</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][jumlah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['jumlah']}}">
                    <span>Chorion</span>
                    <div class="btn-group" style="display: flex">
                      <input type="text" name="fisik[tanda_vital][chorion]" value="{{@$assesment['tanda_vital']['chorion']}}" class="form-control" />
                    </div>
                    <span>Amnoin</span>
                    <div class="btn-group" style="display: flex">
                      <input type="text" name="fisik[tanda_vital][amnion]" value="{{@$assesment['tanda_vital']['amnion']}}" class="form-control" />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Lingkar kepala</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][lingkar_kepala]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['lingkar_kepala']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Lingkar dada</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[tanda_vital][lingkar_dada]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanda_vital']['lingkar_dada']}}">
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">IMD</td>
                  <td style="padding: 5px;">
                    <div class="btn-group" style="display: flex">
                      <input type="text" name="fisik[tanda_vital][imd][1]" placeholder="+" value="{{@$assesment['tanda_vital']['imd']['1']}}" class="form-control" />
                      <button type="button" class="btn btn-default">/</button>
                      <input type="text" name="fisik[tanda_vital][imd][2]" placeholder="-" value="{{@$assesment['tanda_vital']['imd']['2']}}" class="form-control" />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; font-weight: bold;">Keluarga lain-lain</td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[keluarga_lain_lain]" style="display:inline-block; resize: vertical;" class="form-control" >{{@$assesment['keluarga_lain_lain']}}</textarea>
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-12" style="margin-bottom: 2rem;">
              <h5><b>RIWAYAT KEHAMILAN SEBELUMNYA</b></h5>
              <div style="display: flex; justify-content:end; margin-bottom: 1rem;">
                  <button type="button" class="btn btn-primary btn-sm btn-flat" id="tambah_riwayat_kehamilan_sebelumnya"><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <table class="border" style="width: 100%;" id="table_riwayat_kehamilan_sebelumnya">
                  {{-- Template Row Table --}}
                  <tr class="border" id="daftar_riwayat_kehamilan_sebelumnya_template" style="display: none;">
                      <td class="border bold p-1 text-center">1</td>
                      <td class="border bold p-1 text-center">
                          <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][1][kondisi]" value="" class="form-control"  disabled/>
                      </td>
                      <td class="border bold p-1 text-center">
                          <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][1][usia]" value="" class="form-control"  disabled/>
                      </td>
                      <td class="border bold p-1 text-center">
                          <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][1][lahir_mati]" value="" class="form-control"  disabled/>
                      </td>
                      <td class="border bold p-1 text-center">
                          <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][1][penyebab_kematian]" value="" class="form-control"  disabled/>
                      </td>
                  </tr>
                  {{-- End Template Row Table --}}
                  <tr class="border">
                      <td class="border bold p-1 text-center">No</td>
                      <td class="border bold p-1 text-center">Kondisi (Lahir/Mati)</td>
                      <td class="border bold p-1 text-center">Lahir Hidup (Usia)</td>
                      <td class="border bold p-1 text-center">Lahir Mati</td>
                      <td class="border bold p-1 text-center">Penyebab Kematian</td>
                  </tr>
                  @if (isset($assesment['riwayat_kehamilan_sebelumnya']))
                    @foreach ($assesment['riwayat_kehamilan_sebelumnya'] as $key => $obat)
                      <tr class="border riwayat_kehamilan_sebelumnya">
                          <td class="border bold p-1 text-center">{{$key}}</td>
                          <td class="border bold p-1 text-center">
                              <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][{{$key}}][kondisi]" value="{{$obat['kondisi']}}" class="form-control" />
                          </td>
                          <td class="border bold p-1 text-center">
                              <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][{{$key}}][usia]" value="{{$obat['usia']}}" class="form-control" />
                          </td>
                          <td class="border bold p-1 text-center">
                              <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][{{$key}}][lahir_mati]" value="{{$obat['lahir_mati']}}" class="form-control" />
                          </td>
                          <td class="border bold p-1 text-center">
                              <input type="text" name="fisik[riwayat_kehamilan_sebelumnya][{{$key}}][penyebab_kematian]" value="{{$obat['penyebab_kematian']}}" class="form-control" />
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
                        <a href="{{ url("emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neonatus/".$unit."/".@$riwayat->registrasi_id."?asessment_id=".@$riwayat->id) }}" class="btn btn-info btn-sm">
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
    let key= $('.riwayat_kehamilan_sebelumnya').length + 1;
    $('#tambah_riwayat_kehamilan_sebelumnya').click(function (e) {
        let row = $('#daftar_riwayat_kehamilan_sebelumnya_template').clone();
        row.removeAttr('id').removeAttr('style');
        row.find('td:first').text(key);

        row.find('input[name^="fisik[riwayat_kehamilan_sebelumnya]"]').each(function() {
            let newName = $(this).attr('name').replace(/\d+/, key);
            $(this).attr('name', newName);
            $(this).prop('disabled', false);
        });

        key++;
        $('#table_riwayat_kehamilan_sebelumnya').append(row);
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