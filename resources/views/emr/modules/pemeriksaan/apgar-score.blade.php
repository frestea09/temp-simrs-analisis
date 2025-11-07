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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/apgar_score/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
          {!! Form::hidden('apgar_score_id', @$apgarScore->id) !!}
          <br>
            @php
              $apgar = @json_decode(@$apgarScore->fisik, true);
            @endphp
            <div class="col-md-12">
              <h5 class="text-center"><b>APGAR SCORE</b></h5>
              <table class="border" style="width: 100%;" id="table_terapi">
                <tr class="border">
                    <td class="border bold p-1 text-center">KATEGORI</td>
                    <td class="border bold p-1 text-center">1 MENIT</td>
                    <td class="border bold p-1 text-center">5 MENIT</td>
                    <td class="border bold p-1 text-center">10 MENIT</td>
                    <td class="border bold p-1 text-center">>15 MENIT</td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center">Warna</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][warna][1_menit]" value="{{@$apgar['kategori']['warna']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][warna][5_menit]" value="{{@$apgar['kategori']['warna']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][warna][10_menit]" value="{{@$apgar['kategori']['warna']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][warna][15_menit]" value="{{@$apgar['kategori']['warna']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center">Denyut Jantung</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][denyut_jantung][1_menit]" value="{{@$apgar['kategori']['denyut_jantung']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][denyut_jantung][5_menit]" value="{{@$apgar['kategori']['denyut_jantung']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][denyut_jantung][10_menit]" value="{{@$apgar['kategori']['denyut_jantung']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][denyut_jantung][15_menit]" value="{{@$apgar['kategori']['denyut_jantung']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center">Reflek</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][reflek][1_menit]" value="{{@$apgar['kategori']['reflek']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][reflek][5_menit]" value="{{@$apgar['kategori']['reflek']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][reflek][10_menit]" value="{{@$apgar['kategori']['reflek']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][reflek][15_menit]" value="{{@$apgar['kategori']['reflek']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center">Tonus otot</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][tonus_otot][1_menit]" value="{{@$apgar['kategori']['tonus_otot']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][tonus_otot][5_menit]" value="{{@$apgar['kategori']['tonus_otot']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][tonus_otot][10_menit]" value="{{@$apgar['kategori']['tonus_otot']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][tonus_otot][15_menit]" value="{{@$apgar['kategori']['tonus_otot']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center">Pernapasan</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][pernapasan][1_menit]" value="{{@$apgar['kategori']['pernapasan']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][pernapasan][5_menit]" value="{{@$apgar['kategori']['pernapasan']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][pernapasan][10_menit]" value="{{@$apgar['kategori']['pernapasan']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][pernapasan][15_menit]" value="{{@$apgar['kategori']['pernapasan']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
                <tr class="border">
                    <td class="border p-1 text-center bold">Jumlah</td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][jumlah][1_menit]" value="{{@$apgar['kategori']['jumlah']['1_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][jumlah][5_menit]" value="{{@$apgar['kategori']['jumlah']['5_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][jumlah][10_menit]" value="{{@$apgar['kategori']['jumlah']['10_menit']}}" class="form-control" />
                    </td>
                    <td class="border bold p-1 text-center">
                      <input type="text" name="fisik[kategori][jumlah][15_menit]" value="{{@$apgar['kategori']['jumlah']['15_menit']}}" class="form-control" />
                    </td>
                </tr>
              </table>
              <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 30%; font-weight: bold;">Tanggal</td>
                  <td>
                    <input type="date" name="fisik[tanggal]" class="form-control" value="{{@$apgar['tanggal']}}">
                  </td>
                </tr>
                  <tr>
                      <td style="width:30%; font-weight:bold;">Obat-obatan</td>
                      <td>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][tidak_diberikan]"
                                  {{ @$apgar['obat_obatan']['tidak_diberikan'] == 'Tidak diberikan' ? 'checked' : '' }}
                                  type="checkbox" value="Tidak diberikan">
                              <label class="form-check-label" style="font-weight: 400;">Tidak diberikan</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][hepatitis_b]"
                                  {{ @$apgar['obat_obatan']['hepatitis_b'] == 'Hepatitis B' ? 'checked' : '' }}
                                  type="checkbox" value="Hepatitis B">
                              <label class="form-check-label" style="font-weight: 400;">Hepatitis B</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][salep_mata]"
                                  {{ @$apgar['obat_obatan']['salep_mata'] == 'Salep mata' ? 'checked' : '' }}
                                  type="checkbox" value="Salep mata">
                              <label class="form-check-label" style="font-weight: 400;">Salep mata</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][cardiotonika]"
                                  {{ @$apgar['obat_obatan']['cardiotonika'] == 'Cardiotonika' ? 'checked' : '' }}
                                  type="checkbox" value="Cardiotonika">
                              <label class="form-check-label" style="font-weight: 400;">Cardiotonika</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][antibiotika]"
                                  {{ @$apgar['obat_obatan']['antibiotika'] == 'Antibiotika' ? 'checked' : '' }}
                                  type="checkbox" value="Antibiotika">
                              <label class="form-check-label" style="font-weight: 400;">Antibiotika</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[obat_obatan][vitamin]"
                                  {{ @$apgar['obat_obatan']['vitamin'] == 'Vitamin 1mg/0.5mg' ? 'checked' : '' }}
                                  type="checkbox" value="Vitamin 1mg/0.5mg">
                              <label class="form-check-label" style="font-weight: 400;">Vitamin k1</label>
                              <br>
                              <div style="margin-left: 1.2rem;">
                                <input class="form-check-input"
                                    name="fisik[obat_obatan][vitamin_pilihan]"
                                    {{ @$apgar['obat_obatan']['vitamin_pilihan'] == '1mg' ? 'checked' : '' }}
                                    type="checkbox" value="1mg"> 1mg
                                <input class="form-check-input"
                                name="fisik[obat_obatan][vitamin_pilihan]"
                                {{ @$apgar['obat_obatan']['vitamin_pilihan'] == '0.5mg' ? 'checked' : '' }}
                                type="checkbox" value="0.5mg"> 0.5mg
                              </div>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td style="width:30%; font-weight:bold;">Tindakan Resusitasi</td>
                      <td>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][resusitasi_tanpa_tindak_lanjut]"
                                  {{ @$apgar['resusitasi']['resusitasi_tanpa_tindak_lanjut'] == 'Resusitasi tanpa tindak lanjut' ? 'checked' : '' }}
                                  type="checkbox" value="Resusitasi tanpa tindak lanjut">
                              <label class="form-check-label" style="font-weight: bold;">Tidak</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][resusitasi_dengan_tindak_lanjut]"
                                  {{ @$apgar['resusitasi']['resusitasi_dengan_tindak_lanjut'] == 'Resusitasi dengan tindak lanjut' ? 'checked' : '' }}
                                  type="checkbox" value="Resusitasi dengan tindak lanjut">
                              <label class="form-check-label" style="font-weight: bold;">Ya</label>
                          </div>
                          <div style="margin-left: 1rem;">
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][langkah_awal]"
                                  {{ @$apgar['resusitasi']['langkah_awal'] == 'Langkah awal' ? 'checked' : '' }}
                                  type="checkbox" value="Langkah awal">
                              <label class="form-check-label" style="font-weight: 400;">Langkah awal</label>
                            </div>
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][perawatan_rutin]"
                                  {{ @$apgar['resusitasi']['perawatan_rutin'] == 'Perawatan rutin' ? 'checked' : '' }}
                                  type="checkbox" value="Perawatan rutin">
                              <label class="form-check-label" style="font-weight: 400;">Perawatan rutin</label>
                            </div>
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][vtp]"
                                  {{ @$apgar['resusitasi']['vtp'] == 'VTP' ? 'checked' : '' }}
                                  type="checkbox" value="VTP">
                              <label class="form-check-label" style="font-weight: 400;">VTP</label>
                            </div>
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][intubasi]"
                                  {{ @$apgar['resusitasi']['intubasi'] == 'Intubasi' ? 'checked' : '' }}
                                  type="checkbox" value="Intubasi">
                              <label class="form-check-label" style="font-weight: 400;">Intubasi</label>
                            </div>
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][kompres_dada]"
                                  {{ @$apgar['resusitasi']['kompres_dada'] == 'Kompres dada' ? 'checked' : '' }}
                                  type="checkbox" value="Kompres dada">
                              <label class="form-check-label" style="font-weight: 400;">Kompres dada</label>
                            </div>
                            <div>
                              <input class="form-check-input"
                                  name="fisik[resusitasi][obat_obatan]"
                                  {{ @$apgar['resusitasi']['obat_obatan'] == 'Obat obatan' ? 'checked' : '' }}
                                  type="checkbox" value="Obat obatan">
                              <label class="form-check-label" style="font-weight: 400;">Obat obatan</label>
                              <div style="margin-left: 1.5rem;">
                                <label for="">1.</label>
                                <input type="text" class="form-control" placeholder="Obat 1" name="fisik[resusitasi][daftar_obat][1]" value="{{@$apgar['resusitasi']['daftar_obat']['1']}}">
                                <label for="">2.</label>
                                <input type="text" class="form-control" placeholder="Obat 2" name="fisik[resusitasi][daftar_obat][2]" value="{{@$apgar['resusitasi']['daftar_obat']['2']}}">
                                <label for="">3.</label>
                                <input type="text" class="form-control" placeholder="Obat 3" name="fisik[resusitasi][daftar_obat][3]" value="{{@$apgar['resusitasi']['daftar_obat']['3']}}">
                                <label for="">4.</label>
                                <input type="text" class="form-control" placeholder="Obat 4" name="fisik[resusitasi][daftar_obat][4]" value="{{@$apgar['resusitasi']['daftar_obat']['4']}}">
                                <label for="">5.</label>
                                <input type="text" class="form-control" placeholder="Obat 5" name="fisik[resusitasi][daftar_obat][5]" value="{{@$apgar['resusitasi']['daftar_obat']['5']}}">
                              </div>
                            </div>
                          </div>
                      </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">PEMERIKSAAN FISIk</td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Warna</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][warna][biasa]"
                                {{ @$apgar['pemeriksaan_fisik']['warna']['biasa'] == 'Biasa' ? 'checked' : '' }}
                                type="checkbox" value="Biasa">
                            <label class="form-check-label" style="font-weight: 400;">Biasa</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][warna][pucat]"
                                {{ @$apgar['pemeriksaan_fisik']['warna']['pucat'] == 'Pucat' ? 'checked' : '' }}
                                type="checkbox" value="Pucat">
                            <label class="form-check-label" style="font-weight: 400;">Pucat</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][warna][pletora]"
                                {{ @$apgar['pemeriksaan_fisik']['warna']['pletora'] == 'Pletora' ? 'checked' : '' }}
                                type="checkbox" value="Pletora">
                            <label class="form-check-label" style="font-weight: 400;">Pletora</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][warna][sianosis]"
                                {{ @$apgar['pemeriksaan_fisik']['warna']['sianosis'] == 'Sianosis' ? 'checked' : '' }}
                                type="checkbox" value="Sianosis">
                            <label class="form-check-label" style="font-weight: 400;">Sianosis</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][warna][ikterus]"
                                {{ @$apgar['pemeriksaan_fisik']['warna']['ikterus'] == 'Ikterus' ? 'checked' : '' }}
                                type="checkbox" value="Ikterus">
                            <label class="form-check-label" style="font-weight: 400;">Ikterus</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Pernapasan</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pernapasan][frekuensi]"
                                {{ @$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi'] == 'Frekuensi' ? 'checked' : '' }}
                                type="checkbox" value="Frekuensi">
                            <label class="form-check-label" style="font-weight: 400;">Frekuensi</label>
                            <span>Frekuensi x/menit</span>
                            <input type="text" name="fisik[pemeriksaan_fisik][pernapasan][frekuensi_detail]" value="{{@$apgar['pemeriksaan_fisik']['pernapasan']['frekuensi_detail']}}" class="form-control" />
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pernapasan][tipe_abodminothoracal]"
                                {{ @$apgar['pemeriksaan_fisik']['pernapasan']['tipe_abodminothoracal'] == 'Tipe Abdomonithoracal' ? 'checked' : '' }}
                                type="checkbox" value="Tipe Abdomonithoracal">
                            <label class="form-check-label" style="font-weight: 400;">Tipe Abdomonithoracal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][pernapasan][tipe_detail]" value="{{@$apgar['pemeriksaan_fisik']['pernapasan']['tipe_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Keadaan umum</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][state]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['state'] == 'State' ? 'checked' : '' }}
                                type="checkbox" value="State">
                            <label class="form-check-label" style="font-weight: 400;">State</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][1]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['1'] == '1' ? 'checked' : '' }}
                                type="checkbox" value="1">
                            <label class="form-check-label" style="font-weight: 400;">1</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][2]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['2'] == '2' ? 'checked' : '' }}
                                type="checkbox" value="2">
                            <label class="form-check-label" style="font-weight: 400;">2</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][3]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['3'] == '3' ? 'checked' : '' }}
                                type="checkbox" value="3">
                            <label class="form-check-label" style="font-weight: 400;">3</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][4]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['4'] == '4' ? 'checked' : '' }}
                                type="checkbox" value="4">
                            <label class="form-check-label" style="font-weight: 400;">4</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][keadaan_umum][5]"
                                {{ @$apgar['pemeriksaan_fisik']['keadaan_umum']['5'] == '5' ? 'checked' : '' }}
                                type="checkbox" value="5">
                            <label class="form-check-label" style="font-weight: 400;">5</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Kepala</td>
                    <td>
                        <div>
                            {{-- <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kepala][simetris]"
                                {{ @$apgar['pemeriksaan_fisik']['kepala']['simetris'] == 'Simetris/Asimetris' ? 'checked' : '' }}
                                type="checkbox" value="Simetris/Asimetris">
                            <label class="form-check-label" style="font-weight: 400;">Simetris/Asimetris</label> --}}
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][kepala][pergerakan_simetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['kepala']['pergerakan_simetris'] == 'Simetris' ? 'checked' : '' }}
                                  type="checkbox" value="Simetris"> Simetris
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][kepala][pergerakan_asimetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['kepala']['pergerakan_asimetris'] == 'Asimetris' ? 'checked' : '' }}
                                  type="checkbox" value="Asimetris"> Asimetris
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kepala][caput]"
                                {{ @$apgar['pemeriksaan_fisik']['kepala']['caput'] == 'Caput Sukcadaneum' ? 'checked' : '' }}
                                type="checkbox" value="Caput Sukcadaneum">
                            <label class="form-check-label" style="font-weight: 400;">Caput Sukcadaneum</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kepala][sefal_hematoma]"
                                {{ @$apgar['pemeriksaan_fisik']['kepala']['sefal_hematoma'] == 'Sefal hematoma' ? 'checked' : '' }}
                                type="checkbox" value="Sefal hematoma">
                            <label class="form-check-label" style="font-weight: 400;">Sefal hematoma</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kepala][lain]"
                                {{ @$apgar['pemeriksaan_fisik']['kepala']['lain'] == 'Lain-lain' ? 'checked' : '' }}
                                type="checkbox" value="Lain-lain">
                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                            <input type="text" placeholder="Lain-lain" name="fisik[pemeriksaan_fisik][kepala][lain_detail]" value="{{@$apgar['pemeriksaan_fisik']['kepala']['lain_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Fontanel</td>
                    <td>
                        <div>
                            {{-- <span>Frekuensi</span> --}}
                            <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][frekuensi1]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['frekuensi1']}}" class="form-control" />x
                            <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][frekuensi2]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['frekuensi2']}}" class="form-control" /><br/>
                            <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][fontanel][kelainan]" value="{{@$apgar['pemeriksaan_fisik']['fontanel']['kelainan']}}" class="form-control" />
                        </div> 
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Sutura</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][sutura][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['sutura']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][sutura][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['sutura']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][sutura][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['sutura']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Rambut</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][rambut][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['rambut']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][rambut][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['rambut']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][rambut][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['rambut']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Mata</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][mata][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['mata']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][mata][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['mata']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][mata][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['mata']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Hidung</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][hidung][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['hidung']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][hidung][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['hidung']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][hidung][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['hidung']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Mulut</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][mulut][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['mulut']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][mulut][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['mulut']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][mulut][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['mulut']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Lidah</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][lidah][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['lidah']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][lidah][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['lidah']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][lidah][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['lidah']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Gigi</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][gigi][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['gigi']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][gigi][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['gigi']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][gigi][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['gigi']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Leher</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][leher][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['leher']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][leher][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['leher']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][leher][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['leher']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Telinga</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][telinga][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['telinga']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][telinga][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['telinga']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][telinga][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['telinga']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Kulit</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kulit][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['kulit']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][kulit][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['kulit']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][kulit][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['kulit']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Jaringan subkutis</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][jaringan_subkutis][kurang]"
                                {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['kurang'] == 'Kurang' ? 'checked' : '' }}
                                type="checkbox" value="Kurang">
                            <label class="form-check-label" style="font-weight: 400;">Kurang</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][jaringan_subkutis][cukup]"
                                {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['cukup'] == 'Cukup' ? 'checked' : '' }}
                                type="checkbox" value="Cukup">
                            <label class="form-check-label" style="font-weight: 400;">Cukup</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][jaringan_subkutis][tidak_ada]"
                                {{ @$apgar['pemeriksaan_fisik']['jaringan_subkutis']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                                type="checkbox" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Genitalia</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][genitalia][l]"
                                {{ @$apgar['pemeriksaan_fisik']['genitalia']['l'] == 'L' ? 'checked' : '' }}
                                type="checkbox" value="L">
                            <label class="form-check-label" style="font-weight: 400;">L</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][genitalia][p]"
                                {{ @$apgar['pemeriksaan_fisik']['genitalia']['p'] == 'P' ? 'checked' : '' }}
                                type="checkbox" value="P">
                            <label class="form-check-label" style="font-weight: 400;">P</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][genitalia][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['genitalia']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][genitalia][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['genitalia']['tidak_normal'] == 'Tidak Normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak Normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak Normal</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Testiskulorum</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][testiskulorum][belum_lengkap]"
                                {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['belum_lengkap'] == 'Belum lengkap' ? 'checked' : '' }}
                                type="checkbox" value="Belum lengkap">
                            <label class="form-check-label" style="font-weight: 400;">Belum lengkap</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][testiskulorum][lengkap]"
                                {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['lengkap'] == 'Lengkap' ? 'checked' : '' }}
                                type="checkbox" value="Lengkap">
                            <label class="form-check-label" style="font-weight: 400;">Lengkap</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][testiskulorum][tidak_ada]"
                                {{ @$apgar['pemeriksaan_fisik']['testiskulorum']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                                type="checkbox" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Neurologi</td>
                    <td>
                        <div>
                            <span>Reflek Moro</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="" name="fisik[pemeriksaan_fisik][neurologi][reflek_moro_plus]" value="{{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_moro_plus']}}" class="form-control" />
                            </div>
                        </div>
                        <div>
                            <span>Reflek Hidap</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="" name="fisik[pemeriksaan_fisik][neurologi][reflek_hisap_plus]" value="{{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_hisap_plus']}}" class="form-control" />
                            </div>
                        </div>
                        <div>
                            <span>Reflek Pegang</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="" name="fisik[pemeriksaan_fisik][neurologi][reflek_pegang_plus]" value="{{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_pegang_plus']}}" class="form-control" />
                            </div>
                        </div>
                        <div>
                            <span>Reflek Rooting</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="" name="fisik[pemeriksaan_fisik][neurologi][reflek_rooting_plus]" value="{{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_rooting_plus']}}" class="form-control" />
                            </div>
                        </div>
                        <div>
                            <span>Reflek Babinsky</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="" name="fisik[pemeriksaan_fisik][neurologi][reflek_babynsky_plus]" value="{{@$apgar['pemeriksaan_fisik']['neurologi']['reflek_babynsky_plus']}}" class="form-control" />
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Toraks</td>
                    <td>
                        <div>
                            <b><span>Bentuk</span></b><br>
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][toraks][bentuk_simetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['toraks']['bentuk_simetris'] == 'Simetris' ? 'checked' : '' }}
                                  type="checkbox" value="Simetris"> Simetris
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][toraks][bentuk_asimetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['toraks']['bentuk_asimetris'] == 'Asimetris' ? 'checked' : '' }}
                                  type="checkbox" value="Asimetris"> Asimetris
                        </div>
                        <div>
                            <b><span>Pergerakan</span></b><br>
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][toraks][pergerakan_simetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['toraks']['pergerakan_simetris'] == 'Simetris' ? 'checked' : '' }}
                                  type="checkbox" value="Simetris"> Simetris
                            <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][toraks][pergerakan_asimetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['toraks']['pergerakan_asimetris'] == 'Asimetris' ? 'checked' : '' }}
                                  type="checkbox" value="Asimetris"> Asimetris
                        </div>
                        <div>
                            <b><span>Retraksi Intercostal</span></b><br>
                            <div class="btn-group" style="display: flex">
                              <input class="form-check-input"
                                  name="fisik[pemeriksaan_fisik][toraks][retraksi_intercostal_simetris]"
                                  {{ @$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_simetris'] == 'Simetris' ? 'checked' : '' }}
                                  type="checkbox" value="Simetris"> Simetris
                              <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][toraks][retraksi_intercostal_asimetris]"
                                    {{ @$apgar['pemeriksaan_fisik']['toraks']['retraksi_intercostal_asimetris'] == 'Asimetris' ? 'checked' : '' }}
                                    type="checkbox" value="Asimetris"> Asimetris
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Paru-paru</td>
                    <td>
                        <div>
                            <span>Suara pernafasan bronchovascular</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="+" name="fisik[pemeriksaan_fisik][paru_paru][suara_pernapasan_plus]" value="{{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_plus']}}" class="form-control" />
                              <input type="text" placeholder="-" name="fisik[pemeriksaan_fisik][paru_paru][suara_pernapasan_minus]" value="{{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_pernapasan_minus']}}" class="form-control" />
                            </div>
                        </div>
                        <div>
                            <span>Suara tambahan</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="+" name="fisik[pemeriksaan_fisik][paru_paru][suara_tambahan_plus]" value="{{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_plus']}}" class="form-control" />
                              <input type="text" placeholder="-" name="fisik[pemeriksaan_fisik][paru_paru][suara_tambahan_minus]" value="{{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_minus']}}" class="form-control" />
                            </div>
                            <input type="text" placeholder="Jelaskan" name="fisik[pemeriksaan_fisik][paru_paru][suara_tambahan_detail]" value="{{@$apgar['pemeriksaan_fisik']['paru_paru']['suara_tambahan_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Jantung</td>
                    <td>
                        <div>
                            <span>Frekuensi</span>
                            <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][jantung][frekuensi]" value="{{@$apgar['pemeriksaan_fisik']['jantung']['frekuensi']}}" class="form-control" />
                        </div>
                        <div>
                            <span>Bising</span>
                            <div class="btn-group" style="display: flex">
                              <input type="text" placeholder="+" name="fisik[pemeriksaan_fisik][jantung][bising_plus]" value="{{@$apgar['pemeriksaan_fisik']['jantung']['bising_plus']}}" class="form-control" />
                              <input type="text" placeholder="-" name="fisik[pemeriksaan_fisik][jantung][bising_minus]" value="{{@$apgar['pemeriksaan_fisik']['jantung']['bising_minus']}}" class="form-control" />
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Abdomen</td>
                    <td>
                        <input type="text" placeholder="x/menit" name="fisik[pemeriksaan_fisik][abdomen]" value="{{@$apgar['pemeriksaan_fisik']['abdomen']}}" class="form-control" />
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Hati</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][hati][tidak_teraba]"
                                {{ @$apgar['pemeriksaan_fisik']['hati']['tidak_teraba'] == 'Tidak teraba' ? 'checked' : '' }}
                                type="checkbox" value="Tidak teraba">
                            <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][hati][teraba]"
                                {{ @$apgar['pemeriksaan_fisik']['hati']['teraba'] == 'Teraba' ? 'checked' : '' }}
                                type="checkbox" value="Teraba">
                            <label class="form-check-label" style="font-weight: 400;">Teraba</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][hati][teraba_detail]" value="{{@$apgar['pemeriksaan_fisik']['hati']['teraba_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Limpa</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][limpa][tidak_teraba]"
                                {{ @$apgar['pemeriksaan_fisik']['limpa']['tidak_teraba'] == 'Tidak teraba' ? 'checked' : '' }}
                                type="checkbox" value="Tidak teraba">
                            <label class="form-check-label" style="font-weight: 400;">Tidak teraba</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][limpa][teraba]"
                                {{ @$apgar['pemeriksaan_fisik']['limpa']['teraba'] == 'Teraba' ? 'checked' : '' }}
                                type="checkbox" value="Teraba">
                            <label class="form-check-label" style="font-weight: 400;">Teraba, Schiffner</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][limpa][teraba_detail]" value="{{@$apgar['pemeriksaan_fisik']['limpa']['teraba_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Umbilikus</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][umbilikus][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['umbilikus']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][umbilikus][kelainan]"
                                {{ @$apgar['pemeriksaan_fisik']['umbilikus']['kelainan'] == 'Kelainan' ? 'checked' : '' }}
                                type="checkbox" value="Kelainan">
                            <label class="form-check-label" style="font-weight: 400;">Kelainan</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][umbilikus][kelainan_detail]" value="{{@$apgar['pemeriksaan_fisik']['umbilikus']['kelainan_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Pembesaran kelenjar di</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][ada]"
                                {{ @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['ada'] == 'Ada' ? 'checked' : '' }}
                                type="checkbox" value="Ada">
                            <label class="form-check-label" style="font-weight: 400;">Ada</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][tidak_ada]"
                                {{ @$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                                type="checkbox" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][pembesaran_kelenjar][tidak_ada_detail]" value="{{@$apgar['pemeriksaan_fisik']['pembesaran_kelenjar']['tidak_ada_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Anus</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][anus][ada]"
                                {{ @$apgar['pemeriksaan_fisik']['anus']['ada'] == 'Ada' ? 'checked' : '' }}
                                type="checkbox" value="Ada">
                            <label class="form-check-label" style="font-weight: 400;">Ada</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][anus][tidak_ada]"
                                {{ @$apgar['pemeriksaan_fisik']['anus']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                                type="checkbox" value="Tidak ada">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Ektremitas bawah</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][ektremitas_bawah][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][ektremitas_bawah][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][ektremitas_bawah][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['ektremitas_bawah']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Ektremitas atas</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][ektremitas_atas][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['ektremitas_atas']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][ektremitas_atas][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][ektremitas_atas][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['ektremitas_atas']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%; font-weight:bold;">Tulang-tulang</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][tulang_tulang][normal]"
                                {{ @$apgar['pemeriksaan_fisik']['tulang_tulang']['normal'] == 'Normal' ? 'checked' : '' }}
                                type="checkbox" value="Normal">
                            <label class="form-check-label" style="font-weight: 400;">Normal</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][tulang_tulang][tidak_normal]"
                                {{ @$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal'] == 'Tidak normal' ? 'checked' : '' }}
                                type="checkbox" value="Tidak normal">
                            <label class="form-check-label" style="font-weight: 400;">Tidak normal</label>
                            <input type="text" name="fisik[pemeriksaan_fisik][tulang_tulang][tidak_normal_detail]" value="{{@$apgar['pemeriksaan_fisik']['tulang_tulang']['tidak_normal_detail']}}" class="form-control" />
                        </div>
                    </td>
                  </tr>
              </table>
              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-12">
                    {!! Form::submit(empty($apgarScore) ? "Simpan Apgar Score" : "Perbarui Apgar Score", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                    @if (!empty($apgarScore))
                      <a href="{{ url("emr-soap/pemeriksaan/apgar_score/".$unit."/".@$reg->id) }}" class="btn btn-info btn-flat">
                        Batal Edit
                      </a>
                    @endif
                </div>
              </div> 
            </div>

            <div class="col-md-12">
              <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                  </tr>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($riwayats_apgar_score) == 0)
                      <tr>
                          <td colspan="4" class="text-center">Tidak Ada Riwayat Apgar Score</td>
                      </tr>
                  @endif
                  @foreach ($riwayats_apgar_score as $riwayat)
                  @php
                    @$apgar_score = @json_decode(@$riwayat->fisik);
                  @endphp
                      <tr>
                          <td style="text-align: center; {{ $riwayat->id == request()->apgar_score_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            @if(!empty(@$apgar_score->tanggal))
                              {{@Carbon\Carbon::parse(@$apgar_score->tanggal)->format('d-m-Y')}}
                            @else
                              {{@Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y')}}
                            @endif
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->apgar_score_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              <a href="{{ url("emr-soap/pemeriksaan/apgar_score/".$unit."/".@$riwayat->registrasi_id."?apgar_score_id=".@$riwayat->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-pencil"></i>
                              </a>
                              <a href="{{ url("emr-soap/pemeriksaan/cetak_apgar_score/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                              <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                <i class="fa fa-trash"></i>
                              </a>
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
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
@endsection
        