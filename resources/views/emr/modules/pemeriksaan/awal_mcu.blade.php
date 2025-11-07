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
    {{-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> --}}

    @include('emr.modules.addons.profile')
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/awal-mcu/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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

          {{-- Anamnesis --}}
          @php
            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
            if(!@$dataPegawai){
                @$dataPegawai = 1;
            }
          @endphp

          @if (@$dataPegawai == '1')
          <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            @if (session('error_dp'))
              <div class="alert alert-danger">
                Gagal simpan, 
                  {{ session('error_dp') }}
              </div>
            @endif
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
                <h5><b>1. ANAMNESA</b></h5>
              <tr>
                  <td colspan="2" style="padding: 5px;">
                    <textarea rows="3" name="fisik[anamnesa]" required style="display:inline-block; resize: vertical;" placeholder="[Masukkan Anamnesa]" class="form-control" >{{ @$assesment['anamnesa'] ?? @$assesment['keluhan_utama'] }}</textarea>
                    @if($errors->has('fisik.anamnesa'))
                        <div class="error text-danger">{{ $errors->first('fisik.anamnesa') }}</div>
                    @endif
                  </td>
              </tr>
              <tr>
                <td style="width:20%;">A. Riwayat Penyakit Sebelumnya</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayat_penyakit_sebelumnya]" class="form-control" id="" value="{{ @$assesment['riwayat_penyakit_sebelumnya'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">B. Riwayat Pengobatan Sebelumnya</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayat_pengobatan_sebelumnya]" class="form-control" id="" value="{{ @$assesment['riwayat_pengobatan_sebelumnya'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">C. Riwayat Operasi / Tindakan</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayat_operasi_tindakan]" class="form-control" id="" value="{{ @$assesment['riwayat_operasi_tindakan'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">D. Riwayat Penyakit Keluarga</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayat_penyakit_keluarga]" class="form-control" id="" value="{{ @$assesment['riwayat_penyakit_keluarga'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">E. Riwayat Vaksin / Imunisasi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[riwayat_vaksin_imunisasi]" class="form-control" id="" value="{{ @$assesment['riwayat_vaksin_imunisasi'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>2. TANDA VITAL</b></h5>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah'] ?? @$asesmen['tanda_vital']['tekanan_darah']}}">
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
                  <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="bb" value="{{ @$assesment['tanda_vital']['BB'] ?? @$asesmen['tanda_vital']['BB'] }}">
                </td>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="tb" value="{{ @$assesment['tanda_vital']['TB'] ?? @$asesmen['tanda_vital']['TB'] }}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Lingkar Perut (cm)</label><br/>
                  <input type="text" name="fisik[tanda_vital][lingkar_perut]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['lingkar_perut'] ?? @$asesmen['tanda_vital']['lingkar_perut'] }}">
                </td>
                <td style="padding: 5px;">
                  
                </td>
              </tr>
              <tr>
                <td colspan="2" style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">BMI</label><br/>
                  <input type="text" name="fisik[tanda_vital][BMI]" style="display:inline-block; width: 100%;" class="form-control" id="bmiScore" readonly value="{{ @$assesment['tanda_vital']['BMI'] ?? @$asesmen['tanda_vital']['BMI'] ?? 0 }}">
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
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>3. PEMERIKSAAN FISIK</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] }}</textarea>
                    @if($errors->has('fisik.pemeriksaan_fisik'))
                        <div class="error text-danger">{{ $errors->first('fisik.pemeriksaan_fisik') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>4. STATUS PEDIATRI (diisi bila perlu)</b></h5>
              <tr>
                <td style="width:20%;">A. Status Gizi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][status_gizi]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['status_gizi'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">B. Riwayat Imunisasi</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][riwayat_imunisasi]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['riwayat_imunisasi'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">C. Riwayat Tumbuh Kembang</td>
                <td style="padding: 5px;">
                  <input type="text" name="fisik[status_pediatri][riwayat_tumbuh_kembang]" class="form-control" id="" value="{{ @$assesment['status_pediatri']['riwayat_tumbuh_kembang'] }}">
                </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5>
                <b>5. STATUS LOKALIS</b>
                  @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4')
                  <a href="{{url('/emr-soap/penilaian/gigi/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"></i> Isi Lokalis</a>&nbsp;&nbsp;
                  @elseif(@$reg->poli_id == '15')
                  <a href="{{url('/emr-soap/penilaian/obgyn/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;   
                  @elseif(@$reg->poli_id == '27')
                  <a href="{{url('/emr-soap/penilaian/hemodialisis/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                  @else
                  <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                  @endif
              </h5>
              <tr>
                <td><b>Status Lokalis :</b> 
                  
                   @if (@$gambar->image != null)
                    
                   {{-- <a id="myImg"><i class="fa fa-eye text-primary"></i></a> --}}
                    <br>
                    <img src="/images/{{ @$gambar['image'] }}" id="dataImage" style="width: 400px; height:300px;">
                    <br>
                    <label for="">Keterangan Lokalis</label>
                    <br>
                    <ol>
                      <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }} </li>
                      <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }} </li>
                    </ol>
                      
                  @else

                    -

                   @endif
                
                </td>
               </tr>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[keterangan_status_lokalis]" style="display:inline-block; resize: vertical;" placeholder="Keterangan Status Lokalis" class="form-control" >{{ @$assesment['keterangan_status_lokalis'] }}</textarea>
                  </td>
              </tr>
              {{-- Poli Klinik Urologi --}}
              @if ($reg->poli_id == 44) 
                <tr>
                    <td style="padding: 5px;">
                      <label for="">Riwayat Operasi</label>
                      <textarea rows="3" name="fisik[keterangan_riwayat_operasi]" style="display:inline-block; resize: vertical;" placeholder="Riwayat Operasi" class="form-control" >{{ @$assesment['keterangan_riwayat_operasi'] }}</textarea>
                    </td>
                </tr>
              @endif
            </table>            
          </div>
          
          <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>6. DIAGNOSIS</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[diagnosis]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis]" class="form-control" >{{ @$assesment['diagnosis'] }}</textarea>
                    @if($errors->has('fisik.diagnosis'))
                        <div class="error text-danger">{{ $errors->first('fisik.diagnosis') }}</div>
                    @endif
                    <br/>
                    <small style="display: block">Atau masukkan file jika perlu (<b>Max 2mb</b>)</small>
                    <input type="file" id="diagnosis_file" name="diagnosis_file" style="display:inline-block ">
                    @if (@$current_asessment->file_diagnosis)
                      <a target="_blank" href="{{ asset('/emr_file/'.@$current_asessment->file_diagnosis) }}">Lihat Dokumen</a>  
                    @endif
                  </td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[diagnosistambahan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis Tambahan]" class="form-control" >{{ @$assesment['diagnosistambahan'] }}</textarea>
                    <br/>
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>7. PLANNING</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    @if (@$reg->poli->bpjs == 'SAR')
                      @if (@$assesment['planning'])
                        <textarea rows="3" name="fisik[planning]" required style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >{{ @$assesment['planning'] }}</textarea>
                      @else
                        <textarea rows="3" name="fisik[planning]" required style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >@foreach(@$namaObat as $k => $v) {{ @$v['obat'] }}{{ @$v['signa']?'['.$v['signa'].']':'' }}, @endforeach</textarea>
                      @endif
                    @else
                      <textarea rows="3" name="fisik[planning]" required style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >{{ @$assesment['planning'] }}</textarea>
                    @endif

                    @if($errors->has('fisik.planning'))
                        <div class="error text-danger">{{ $errors->first('fisik.planning') }}</div>
                    @endif
                    <br/>
                    <small style="display: block">Atau masukkan file jika perlu (<b>Max 2mb</b>)</small>
                    <input type="file" id="planning_file" name="planning_file" style="display:inline-block ">
                    @if (@$current_asessment->file_planning)
                      <a target="_blank" href="{{ asset('/emr_file/'.@$current_asessment->file_planning) }}">Lihat Dokumen</a>  
                    @endif
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
                  <input type="text" id="waktuKontrol1" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" id="listKontrol1" data-dokterID="{{ $reg->dokter_id }}"
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
                  <input type="checkbox" id="dischargePlanning_dirujuk1" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                  <label for="dischargePlanning_dirujuk1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                </td>
              </tr>
              <tr id="rujukan" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                  <td  style="width:40%; font-weight:bold;">
                      Faskes Rujukan
                  </td>
                  <td>
                      <select id="faskes" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                          <option value="" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                          <option value="RS Kab. Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                          <option value="RS Kota Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                          <option value="RS Provinsi" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                      </select>
                  </td>
              </tr>
              <tr id="rs_rujukan" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                  <td  style="width:40%; font-weight:bold;">
                      Rumah Sakit Rujukan
                  </td>
                  <td>
                      <select id="faskes_rs_rujukan" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                          <option value="" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                          @foreach ($faskesRujukanRs as $rs)
                              <option value="{{$rs->id}}" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                          @endforeach
                      </select>
                  </td>
              </tr>
              <tr id="alasan_rujukan" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                  <td  style="width:40%; font-weight:bold;">
                      Alasan
                  </td>
                  <td>
                      <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesment['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
                  </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_3" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                  <label for="dischargePlanning_4" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_4" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                  <label for="dischargePlanning_4" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                </td>
              </tr>
              <tr>
                <td style="width:25%; font-weight:500;">
                  <input type="checkbox" id="dischargePlanning_5" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesment['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                  <label for="dischargePlanning_5" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                </td>
                <td>
                  <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['meninggal']['waktu']}}">
                </td>
              </tr>
            </table>

            <button class="btn btn-success">Simpan</button>
            </form>
            <br/>
            <br/>

            
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <form method="POST" action="{{ url('emr-soap/perencanaan/visum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                {!! Form::hidden('unit', $unit) !!}
                {!! Form::hidden('poli', $poli) !!}
                {!! Form::hidden('dpjp', $dpjp) !!}
                <br>
                <tr>
                  <td style="width:20%;">Visum</td>
                  <td style="padding: 5px;">
                    <textarea name="keterangan[pemeriksaanDokter]" id="" class="form-control" style="resize: vertical; dispay: inline-block;" rows="10">{{ @$visum['pemeriksaanDokter'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right;">
                    <button class="btn btn-success">Simpan Visum</button>
                  </td>
                </tr>
              </form>
            </table>

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
                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                          @if (substr(@$riwayat->registrasi->status_reg, 0, 1) == 'J')
                            @if (in_array(@$riwayat->registrasi->poli_id, ['3', '34', '4']))
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif (@$riwayat->registrasi->poli_id == '15')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif ( @$riwayat->registrasi->poli_id == "6")
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-mata/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm btn-flat">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif (@$riwayat->registrasi->poli_id == '27')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif (@$riwayat->registrasi->poli_id == '41')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-paru/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif (@$riwayat->registrasi->poli_id == '35')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-mcu/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @else
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @endif
                          @else
                          -
                          @endif
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
          @else
            @if ($reg->poli_id == 8 || $reg->poli_id == 10)
              <div class="col-md-6">
                <h5><b>Asesmen Keperawatan Pasien Anak</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <tr>
                    <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                    <td>
                      <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]" value="Tidak" {{@$assesment['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                      <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]" value="Ya" {{@$assesment['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_alergi']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                    <td>
                      <textarea name="fisik[keluhan_utama]" id="" rows="3" style="resize: vertical; display: inline-block;" class="form-control">{{@$assesment['keluhan_utama']}}</textarea>
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;">Riwayat Operasi</td>
                    <td>
                      <input type="radio" id="riwayat_operasi1" name="fisik[riwayat_operasi][pilihan]" value="Tidak" {{@$assesment['riwayat_operasi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="riwayat_operasi1" style="font-weight: normal;">Tidak</label><br>
                      <input type="radio" id="riwayat_operasi2" name="fisik[riwayat_operasi][pilihan]" value="Ya" {{@$assesment['riwayat_operasi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="riwayat_operasi2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="riwayat_operasi3" name="fisik[riwayat_operasi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_operasi']['sebutkan']}}">
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;" colspan="2">Riwayat Kelahiran</td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <span>Anak Ke </span> <input type="text" name="fisik[riwayat_kelahiran][anakKe]" style="display: inline-block; width: 50px;" value="{{@$assesment['riwayat_kelahiran']['anakKe']}}">
                      <span>dari</span> <input type="text" name="fisik[riwayat_kelahiran][saudara]" style="display: inline-block; width: 50px;" value="{{@$assesment['riwayat_kelahiran']['saudara']}}"> <span>Saudara</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:normal;">Cara Kelahiran</td>
                    <td>
                      <input type="radio" id="cara_kelahiran1" name="fisik[riwayat_kelahiran][cara_kelahiran][pilihan]" value="Spontan" {{@$assesment['riwayat_kelahiran']['cara_kelahiran']['pilihan'] == 'Spontan' ? 'checked' : ''}}>
                      <label for="cara_kelahiran1" style="font-weight: normal;">Spontan</label><br>
                      <input type="radio" id="cara_kelahiran2" name="fisik[riwayat_kelahiran][cara_kelahiran][pilihan]" value="Lainnya" {{@$assesment['riwayat_kelahiran']['cara_kelahiran']['pilihan'] == 'Lainnya' ? 'checked' : ''}}>
                      <label for="cara_kelahiran2" style="font-weight: normal;">Lainnya</label><br>
                      <input type="text" id="cara_kelahiran3" name="fisik[riwayat_kelahiran][cara_kelahiran][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_kelahiran']['cara_kelahiran']['sebutkan']}}">
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;">Riwayat Imunisasi</td>
                    <td>
                      <input type="radio" id="riwayat_imunisasi1" name="fisik[riwayat_imunisasi][pilihan]" value="Tidak" {{@$assesment['riwayat_imunisasi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="riwayat_imunisasi1" style="font-weight: normal;">Tidak</label><br>
                      <input type="radio" id="riwayat_imunisasi2" name="fisik[riwayat_imunisasi][pilihan]" value="Ya" {{@$assesment['riwayat_imunisasi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="riwayat_imunisasi2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="riwayat_imunisasi3" name="fisik[riwayat_imunisasi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_imunisasi']['sebutkan']}}">

                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="width:25%; font-weight:bold;">Riwayat Tumbuh Kembang</td>
                  </tr>
                  <tr>
                    <td>
                      <label for="" style="font-weight: normal;">Pertumbuhan gigi pertama</label>
                    </td>
                    <td>
                        <input type="checkbox" name="fisik[keperawatanAnak][riwayatTumbuhKembang][pertumbuhanGigiPertama]" id="" class="form-check-input" value="true" {{ @$assesment['keperawatanAnak']['riwayatTumbuhKembang']['pertumbuhanGigiPertama'] == 'true' ? 'checked' : '' }}>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="" style="font-weight: normal;">Berjalan Sendiri</label>
                    </td>
                    <td>
                      <input type="checkbox" name="fisik[keperawatanAnak][riwayatTumbuhKembang][berjalanSendiri]" id="" class="form-check-input" value="true" {{ @$assesment['keperawatanAnak']['riwayatTumbuhKembang']['berjalanSendiri'] == 'true' ? 'checked' : '' }}>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="" style="font-weight: normal;">Mulai bisa duduk</label>
                    </td>
                    <td>
                      <input type="checkbox" name="fisik[keperawatanAnak][riwayatTumbuhKembang][mulaiDuduk]" id="" class="form-check-input" value="true" {{ @$assesment['keperawatanAnak']['riwayatTumbuhKembang']['mulaiDuduk'] == 'true' ? 'checked' : '' }}>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="" style="font-weight: normal;">Mulai bisa bicara</label>
                    </td>
                    <td>
                      <input type="checkbox" name="fisik[keperawatanAnak][riwayatTumbuhKembang][mulaiBicara]" id="" class="form-check-input" value="true" {{ @$assesment['keperawatanAnak']['riwayatTumbuhKembang']['mulaiBicara'] == 'true' ? 'checked' : '' }}>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="" style="font-weight: normal;">Mulai bisa membaca</label>
                    </td>
                    <td>
                      <input type="checkbox" name="fisik[keperawatanAnak][riwayatTumbuhKembang][mulaiMembaca]" id="" class="form-check-input" value="true" {{ @$assesment['keperawatanAnak']['riwayatTumbuhKembang']['mulaiMembaca'] == 'true' ? 'checked' : '' }}>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="width:25%; font-weight:bold;">Riwayat Gizi</td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <span>BB/TB : </span> <input type="text" name="fisik[keperawatanAnak][riwayatGizi][bb_tb]" style="display: inline-block; width:50px; margin-right: 10px;" value="{{ @$assesment['keperawatanAnak']['riwayatGizi']['bb_tb'] }}">
                      <span>BB/U : </span> <input type="text" name="fisik[keperawatanAnak][riwayatGizi][bb_u]" style="display: inline-block; width:50px; margin-right: 10px;" value="{{ @$assesment['keperawatanAnak']['riwayatGizi']['bb_u'] }}">
                      <span>TB/U : </span> <input type="text" name="fisik[keperawatanAnak][riwayatGizi][tb_u]" style="display: inline-block; width:50px; margin-right: 10px;" value="{{ @$assesment['keperawatanAnak']['riwayatGizi']['tb_u'] }}">
                      <span>LK/U : </span> <input type="text" name="fisik[keperawatanAnak][riwayatGizi][lk_u]" style="display: inline-block; width:50px; margin-right: 10px;" value="{{ @$assesment['keperawatanAnak']['riwayatGizi']['lk_u'] }}">
                      <span>BMI/U : </span> <input type="text" name="fisik[keperawatanAnak][riwayatGizi][bmi_u]" style="display: inline-block; width:50px;" value="{{ @$assesment['keperawatanAnak']['riwayatGizi']['bmi_u'] }}">
                    </td>
                  </tr>
                </table>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;">PEMERIKSAAN FISIK</td>
                  </tr>
                  <tr>
                    <td style="padding: 5px; width: 50%">
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
                      <label class="form-check-label" style="font-weight: normal;"> Suhu (°C)</label><br/>
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
                    <td style="padding: 5px;" colspan="2">
                      <label class="form-check-label" style="font-weight: normal;">LK (Cm)</label><br/>
                      <input type="text" name="fisik[tanda_vital][LK]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['LK'] }}">
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="">
                      <span style="margin-right: 10px;">GCS</span> 
                      <label class="form-check-label" style="">E</label>
                      <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="E" class="form-control" id="" value="{{ @$assesment['GCS']['E'] }}">
                      <label class="form-check-label" style="">M</label>
                      <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="M" class="form-control" id="" value="{{ @$assesment['GCS']['M'] }}">
                      <label class="form-check-label" style="">V</label>
                      <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="V" class="form-control" id="" value="{{ @$assesment['GCS']['V'] }}">
                    </td>
                  </tr>

                  <tr>
                    <td style="font-weight:bold;">Nyeri</td>
                    <td>
                      <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak" {{@$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="nyeri_1" style="font-weight: normal; margin-right: 20px;">Tidak</label>
                      <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ya" {{@$assesment['nyeri']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="nyeri_2" style="font-weight: normal;">Ya</label><br>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">
                      <p style="text-align: left;">Skala</p>
                      <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 300px; height: 150px; padding-bottom: 10px;"><br/>
                      <input type="radio" id="skala_1" name="fisik[nyeri][skala][pilihan]" value="0" {{@$assesment['nyeri']['skala']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="skala_1" style="font-weight: normal;">0</label>
                      <input type="radio" id="skala_2" name="fisik[nyeri][skala][pilihan]" value="1-3" style="margin-left: 25px;" {{@$assesment['nyeri']['skala']['pilihan'] == '1-3' ? 'checked' : ''}}>
                      <label for="skala_2" style="font-weight: normal;">1-3</label>
                      <input type="radio" id="skala_3" name="fisik[nyeri][skala][pilihan]" value="4-6"  style="margin-left: 25px;" {{@$assesment['nyeri']['skala']['pilihan'] == '4-6' ? 'checked' : ''}}>
                      <label for="skala_3" style="font-weight: normal;">4-6</label>
                      <input type="radio" id="skala_4" name="fisik[nyeri][skala][pilihan]" value="7-9"  style="margin-left: 25px;" {{@$assesment['nyeri']['skala']['pilihan'] == '7-9' ? 'checked' : ''}}>
                      <label for="skala_4" style="font-weight: normal;">7-9</label>
                      <input type="radio" id="skala_5" name="fisik[nyeri][skala][pilihan]" value="10" style="margin-left: 25px;" {{@$assesment['nyeri']['skala']['pilihan'] == '10' ? 'checked' : ''}}>
                      <label for="skala_5" style="font-weight: normal;">10</label>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="font-weight: bold;">Risiko Jatuh</td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <input type="radio" id="risiko_jatuh1" name="fisik[risiko_jatuh][pilihan]" value="Tidak" {{@$assesment['risiko_jatuh']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="risiko_jatuh1" style="font-weight: normal;">Tidak</label>
                      <input type="radio" id="risiko_jatuh2" name="fisik[risiko_jatuh][pilihan]" value="Ya" {{@$assesment['risiko_jatuh']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="risiko_jatuh2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="risiko_jatuh3" name="fisik[risiko_jatuh][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['risiko_jatuh']['sebutkan']}}">
                    </td>
                  </tr>
                </table>
              </div>

              <div class="col-md-6">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <tr>
                    <td colspan="2" style="font-weight:bold;">PEMERIKSAAN FISIK</td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Pernyarafan</td>
                    <td>
                      <input type="radio" id="pernyarafan_1" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tidak ada keluhan">
                      <label for="pernyarafan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                      <input type="radio" id="pernyarafan_2" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tremor">
                      <label for="pernyarafan_2" style="font-weight: normal;">Tremor</label><br/>
                      <input type="radio" id="pernyarafan_3" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Hemiparase">
                      <label for="pernyarafan_3" style="font-weight: normal;">Hemiparase/Hemiplegia</label><br/>
                      <input type="radio" id="pernyarafan_4" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="ROM">
                      <label for="pernyarafan_4" style="font-weight: normal;">ROM</label><br/>
                      <input type="radio" id="pernyarafan_5" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Paralise">
                      <label for="pernyarafan_5" style="font-weight: normal;">Paralise</label><br/>
                      <input type="radio" id="pernyarafan_6" name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Lain-Lain">
                      <label for="pernyarafan_6" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="pernyarafan_7" name="fisik[pemeriksaanFisik][pernyarafan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Pernapasan</td>
                    <td>
                      <input type="radio" id="pernapasan_1" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Tidak ada keluhan">
                      <label for="pernapasan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                      <input type="radio" id="pernapasan_2" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Sekret">
                      <label for="pernapasan_2" style="font-weight: normal;">Sekret (+)</label><br/>
                      <input type="radio" id="pernapasan_3" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Vesikular">
                      <label for="pernapasan_3" style="font-weight: normal;">Vesikular</label><br/>
                      <input type="radio" id="pernapasan_4" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Ronchi">
                      <label for="pernapasan_4" style="font-weight: normal;">Ronchi</label><br/>
                      <input type="radio" id="pernapasan_5" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Wheezing">
                      <label for="pernapasan_5" style="font-weight: normal;">Wheezing</label><br/>
                      <input type="radio" id="pernapasan_6" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Menggunakan Otot Bantu">
                      <label for="pernapasan_6" style="font-weight: normal;">Menggunakan Otot Bantu</label><br/>
                      <input type="radio" id="pernapasan_7" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Retraksi Dada">
                      <label for="pernapasan_7" style="font-weight: normal;">Retraksi Dada / Inter Costa</label><br/>
                      <input type="radio" id="pernapasan_8" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Dada">
                      <label for="pernapasan_8" style="font-weight: normal;">Pernapasan Dada</label><br/>
                      <input type="radio" id="pernapasan_9" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Perut">
                      <label for="pernapasan_9" style="font-weight: normal;">Pernapasan Perut</label><br/>
                      <input type="radio" id="pernapasan_10" name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Lain-Lain">
                      <label for="pernapasan_10" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="pernapasan_11" name="fisik[pemeriksaanFisik][pernapasan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Kardiovaskuler</td>
                    <td style="">
                      <input type="radio" id="kardiovaskuler_1" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Tidak ada keluhan">
                      <label for="kardiovaskuler_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="kardiovaskuler_2" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Oedema">
                      <label for="kardiovaskuler_2" style="font-weight: normal; margin-right: 10px;">Oedema</label>
                      <input type="radio" id="kardiovaskuler_3" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Murmur">
                      <label for="kardiovaskuler_3" style="font-weight: normal; margin-right: 10px;">Murmur</label><br/>
                      <input type="radio" id="kardiovaskuler_4" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Chest Pain">
                      <label for="kardiovaskuler_4" style="font-weight: normal; margin-right: 10px;">Chest Pain</label>
                      <input type="radio" id="kardiovaskuler_5" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Reguler">
                      <label for="kardiovaskuler_5" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                      <input type="radio" id="kardiovaskuler_6" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Ireguler">
                      <label for="kardiovaskuler_6" style="font-weight: normal; margin-right: 10px;">Ireguler</label><br/>
                      <input type="radio" id="kardiovaskuler_7" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Gallop">
                      <label for="kardiovaskuler_7" style="font-weight: normal; margin-right: 10px;">Gallop</label>
                      <input type="radio" id="kardiovaskuler_8" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT < 2">
                      <label for="kardiovaskuler_8" style="font-weight: normal; margin-right: 10px;">CRT < 2</label>
                      <input type="radio" id="kardiovaskuler_9" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT > 2">
                      <label for="kardiovaskuler_9" style="font-weight: normal; margin-right: 10px;">CRT > 2</label><br/>
                      <input type="radio" id="kardiovaskuler_10" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Lain-Lain">
                      <label for="kardiovaskuler_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="kardiovaskuler_11" name="fisik[pemeriksaanFisik][kardiovaskuler][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Pencernaan</td>
                    <td style="">
                      <input type="radio" id="pencernaan_1" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Tidak ada keluhan">
                      <label for="pencernaan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="pencernaan_2" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="konstipasi">
                      <label for="pencernaan_2" style="font-weight: normal; margin-right: 10px;">konstipasi</label>
                      <input type="radio" id="pencernaan_3" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Diare">
                      <label for="pencernaan_3" style="font-weight: normal; margin-right: 10px;">Diare</label><br/>
                      <input type="radio" id="pencernaan_4" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Mual">
                      <label for="pencernaan_4" style="font-weight: normal; margin-right: 10px;">Mual / Muntah</label>
                      <input type="radio" id="pencernaan_5" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Anoreksia">
                      <label for="pencernaan_5" style="font-weight: normal; margin-right: 10px;">Anoreksia</label><br/>
                      <input type="radio" id="pencernaan_6" name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Lain-Lain">
                      <label for="pencernaan_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="pencernaan_7" name="fisik[pemeriksaanFisik][pencernaan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Endokrin</td>
                    <td style="">
                      <input type="radio" id="endokrin_1" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tidak ada keluhan">
                      <label for="endokrin_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="endokrin_2" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Pembesaran Kelenjar">
                      <label for="endokrin_2" style="font-weight: normal; margin-right: 10px;">Pembesaran Kelenjar</label><br/>
                      <input type="radio" id="endokrin_3" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tiroid">
                      <label for="endokrin_3" style="font-weight: normal; margin-right: 10px;">Tiroid</label>
                      <input type="radio" id="endokrin_4" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Keringat">
                      <label for="endokrin_4" style="font-weight: normal; margin-right: 10px;">Keringat Banyak</label>
                      <input type="radio" id="endokrin_5" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Napas Bau">
                      <label for="endokrin_5" style="font-weight: normal; margin-right: 10px;">Napas Bau</label><br/>
                      <input type="radio" id="endokrin_6" name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Lain-Lain">
                      <label for="endokrin_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="endokrin_7" name="fisik[pemeriksaanFisik][endokrin][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Reproduksi</td>
                    <td style="">
                      <input type="radio" id="reproduksi_1" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak ada keluhan">
                      <label for="reproduksi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="reproduksi_2" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Keputihan">
                      <label for="reproduksi_2" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                      <input type="radio" id="reproduksi_3" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Haid Tidak Teratur">
                      <label for="reproduksi_3" style="font-weight: normal; margin-right: 10px;">Haid Tidak Teratur</label>
                      <input type="radio" id="reproduksi_4" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak Haid">
                      <label for="reproduksi_4" style="font-weight: normal; margin-right: 10px;">Tidak Haid</label><br/>
                      <input type="radio" id="reproduksi_5" name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Lain-Lain">
                      <label for="reproduksi_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="reproduksi_6" name="fisik[pemeriksaanFisik][reproduksi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Abdomen</td>
                    <td style="">
                      <input type="radio" id="abdomen_1" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Tidak ada keluhan">
                      <label for="abdomen_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="abdomen_2" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Membesar">
                      <label for="abdomen_2" style="font-weight: normal; margin-right: 10px;">Membesar</label>
                      <input type="radio" id="abdomen_3" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Distensi">
                      <label for="abdomen_3" style="font-weight: normal; margin-right: 10px;">Distensi</label><br/>
                      <input type="radio" id="abdomen_4" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Nyeri Tekan">
                      <label for="abdomen_4" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                      <input type="radio" id="abdomen_5" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Luka">
                      <label for="abdomen_5" style="font-weight: normal; margin-right: 10px;">Luka</label>
                      <input type="radio" id="abdomen_6" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L I">
                      <label for="abdomen_6" style="font-weight: normal; margin-right: 10px;">L I</label>
                      <input type="radio" id="abdomen_7" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L II">
                      <label for="abdomen_7" style="font-weight: normal; margin-right: 10px;">L II</label><br/>
                      <input type="radio" id="abdomen_8" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L III">
                      <label for="abdomen_8" style="font-weight: normal; margin-right: 10px;">L III</label>
                      <input type="radio" id="abdomen_9" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="L IV">
                      <label for="abdomen_9" style="font-weight: normal; margin-right: 10px;">L IV</label><br/>
                      <input type="radio" id="abdomen_10" name="fisik[pemeriksaanFisik][abdomen][pilihan]" value="Lain-Lain">
                      <label for="abdomen_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="abdomen_11" name="fisik[pemeriksaanFisik][abdomen][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Kulit</td>
                    <td style="">
                      <input type="radio" id="kulit_1" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Tidak ada keluhan">
                      <label for="kulit_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="kulit_2" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Turgor">
                      <label for="kulit_2" style="font-weight: normal; margin-right: 10px;">Turgor Tidak Baik</label><br/>
                      <input type="radio" id="kulit_3" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Perubahan Warna">
                      <label for="kulit_3" style="font-weight: normal; margin-right: 10px;">Perubahan Warna</label>
                      <input type="radio" id="kulit_4" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Terdapat Lecet">
                      <label for="kulit_4" style="font-weight: normal; margin-right: 10px;">Terdapat Lecet</label><br/>
                      <input type="radio" id="kulit_5" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Terdapat Luka">
                      <label for="kulit_5" style="font-weight: normal; margin-right: 10px;">Terdapat Luka</label><br/>
                      <input type="radio" id="kulit_6" name="fisik[pemeriksaanFisik][kulit][pilihan]" value="Lain-Lain">
                      <label for="kulit_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="kulit_7" name="fisik[pemeriksaanFisik][kulit][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Mata</td>
                    <td style="">
                      <input type="radio" id="mata_1" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Tidak ada keluhan">
                      <label for="mata_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="mata_2" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Kuning">
                      <label for="mata_2" style="font-weight: normal; margin-right: 10px;">Kuning</label>
                      <input type="radio" id="mata_3" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Pucat">
                      <label for="mata_3" style="font-weight: normal; margin-right: 10px;">Pucat</label><br/>
                      <input type="radio" id="mata_4" name="fisik[pemeriksaanFisik][mata][pilihan]" value="VOD">
                      <label for="mata_4" style="font-weight: normal; margin-right: 10px;">VOD (Visus Ocula Dektra)</label>
                      <input type="radio" id="mata_5" name="fisik[pemeriksaanFisik][mata][pilihan]" value="VOS">
                      <label for="mata_5" style="font-weight: normal; margin-right: 10px;">VOS (Visus Okula Sinistra)</label><br/>
                      <input type="radio" id="mata_6" name="fisik[pemeriksaanFisik][mata][pilihan]" value="Lain-Lain">
                      <label for="mata_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="mata_7" name="fisik[pemeriksaanFisik][mata][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Genetalia</td>
                    <td style="">
                      <input type="radio" id="genetalia_1" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Tidak ada keluhan">
                      <label for="genetalia_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="genetalia_2" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Nyeri Tekan">
                      <label for="genetalia_2" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                      <input type="radio" id="genetalia_3" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Benjolan">
                      <label for="genetalia_3" style="font-weight: normal; margin-right: 10px;">Benjolan</label><br/>
                      <input type="radio" id="genetalia_4" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hipospsdia">
                      <label for="genetalia_4" style="font-weight: normal; margin-right: 10px;">Hipospsdia</label>
                      <input type="radio" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Epispadia">
                      <label for="genetalia_5" style="font-weight: normal; margin-right: 10px;">Epispadia</label>
                      <input type="radio" id="genetalia_6" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hidrochele">
                      <label for="genetalia_6" style="font-weight: normal; margin-right: 10px;">Hidrochele</label>
                      <input type="radio" id="genetalia_7" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lesi">
                      <label for="genetalia_7" style="font-weight: normal; margin-right: 10px;">Lesi</label><br/>
                      <input type="radio" id="genetalia_8" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Eritema">
                      <label for="genetalia_8" style="font-weight: normal; margin-right: 10px;">Eritema</label>
                      <input type="radio" id="genetalia_9" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Peradangan">
                      <label for="genetalia_9" style="font-weight: normal; margin-right: 10px;">Peradangan</label><br/>
                      <input type="radio" id="genetalia_10" name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lain-Lain">
                      <label for="genetalia_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="genetalia_11" name="fisik[pemeriksaanFisik][genetalia][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Urinaria</td>
                    <td style="">
                      <input type="radio" id="urinaria_1" name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Tidak ada keluhan">
                      <label for="urinaria_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="urinaria_2" name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Warna">
                      <label for="urinaria_2" style="font-weight: normal; margin-right: 10px;">Warna</label><br/>
                      <input type="radio" id="urinaria_3" name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Produksi">
                      <label for="urinaria_3" style="font-weight: normal; margin-right: 10px;">Produksi</label><br/>
                      <input type="radio" id="urinaria_4" name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Lain-Lain">
                      <label for="urinaria_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="urinaria_5" name="fisik[pemeriksaanFisik][urinaria][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Gigi</td>
                    <td style="">
                      <input type="radio" id="gigi_1" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Tidak ada keluhan">
                      <label for="gigi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label><br>
                      <input type="radio" id="gigi_4" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Lain-Lain">
                      <label for="gigi_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="gigi_5" name="fisik[pemeriksaanFisik][gigi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Ektremitas Atas</td>
                    <td style="">
                      <input type="radio" id="ektremitasAtas_1" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Tidak ada keluhan">
                      <label for="ektremitasAtas_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="ektremitasAtas_2" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Gerakan Terbatas">
                      <label for="ektremitasAtas_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                      <input type="radio" id="ektremitasAtas_3" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Nyeri">
                      <label for="ektremitasAtas_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                      <input type="radio" id="ektremitasAtas_4" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Lain-Lain">
                      <label for="ektremitasAtas_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="ektremitasAtas_5" name="fisik[pemeriksaanFisik][ektremitasAtas][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Ektremitas Bawah</td>
                    <td style="">
                      <input type="radio" id="ektremitasBawah_1" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Tidak ada keluhan">
                      <label for="ektremitasBawah_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="ektremitasBawah_2" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Gerakan Terbatas">
                      <label for="ektremitasBawah_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                      <input type="radio" id="ektremitasBawah_3" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Nyeri">
                      <label for="ektremitasBawah_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                      <input type="radio" id="ektremitasBawah_4" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Lain-Lain">
                      <label for="ektremitasBawah_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="ektremitasBawah_5" name="fisik[pemeriksaanFisik][ektremitasBawah][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Muka / Wajah</td>
                    <td style="">
                      <input type="radio" id="muka_1" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Tidak ada keluhan">
                      <label for="muka_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="muka_2" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Lain-Lain">
                      <label for="muka_2" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="muka_3" name="fisik[pemeriksaanFisik][muka][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Telinga</td>
                    <td style="">
                      <input type="radio" id="telinga_1" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Tidak ada keluhan">
                      <label for="telinga_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="telinga_2" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Tidak Simetris">
                      <label for="telinga_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                      <input type="radio" id="telinga_3" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Cerumen">
                      <label for="telinga_3" style="font-weight: normal; margin-right: 10px;">Cerumen</label><br/>
                      <input type="radio" id="telinga_4" name="fisik[pemeriksaanFisik][telinga][pilihan]" value="Lain-Lain">
                      <label for="telinga_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="telinga_5" name="fisik[pemeriksaanFisik][telinga][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Hidung</td>
                    <td style="">
                      <input type="radio" id="hidung_1" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Tidak ada keluhan">
                      <label for="hidung_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="hidung_2" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Tidak Simetris">
                      <label for="hidung_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                      <input type="radio" id="hidung_3" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Sekret">
                      <label for="hidung_3" style="font-weight: normal; margin-right: 10px;">Sekfret</label>
                      <input type="radio" id="hidung_4" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Cuping">
                      <label for="hidung_4" style="font-weight: normal; margin-right: 10px;">Pernafasan Cuping Hidung</label><br/>
                      <input type="radio" id="hidung_5" name="fisik[pemeriksaanFisik][hidung][pilihan]" value="Lain-Lain">
                      <label for="hidung_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="hidung_6" name="fisik[pemeriksaanFisik][hidung][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Tenggorokan</td>
                    <td style="">
                      <input type="radio" id="tenggorokan_1" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tidak ada keluhan">
                      <label for="tenggorokan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="radio" id="tenggorokan_2" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tonsil Ada Keluhan">
                      <label for="tenggorokan_2" style="font-weight: normal; margin-right: 10px;">Tonsil Ada Keluhan</label><br/>
                      <input type="radio" id="tenggorokan_3" name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Lain-Lain">
                      <label for="tenggorokan_3" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="tenggorokan_4" name="fisik[pemeriksaanFisik][tenggorokan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan">
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
                      <input type="text" id="waktuKontrol2" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <button type="button" id="listKontrol2" data-dokterID="{{ $reg->dokter_id }}"
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
                      <input type="checkbox" id="dischargePlanning_dirujuk2" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                      <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                    </td>
                    <td>
                      <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                    </td>
                  </tr>
                  <tr id="rujukan2" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Faskes Rujukan
                    </td>
                    <td>
                        <select id="faskes2" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            <option value="RS Kab. Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                            <option value="RS Kota Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                            <option value="RS Provinsi" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                        </select>
                    </td>
                  </tr>
                  <tr id="rs_rujukan2" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Rumah Sakit Rujukan
                    </td>
                    <td>
                        <select id="faskes_rs_rujukan2" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            @foreach ($faskesRujukanRs as $rs)
                                <option value="{{$rs->id}}" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                            @endforeach
                        </select>
                    </td>
                  </tr>
                  <tr id="alasan_rujukan2" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Alasan
                    </td>
                    <td>
                        <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesment['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
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

                <input type="hidden" name="fisik[perawat][tanggal]" value="{{ now() }}">
                <input type="hidden" name="fisik[perawat][nama]" value="{{ @Auth::user()->name }}">
    
                <div style="text-align: right;">
                  <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
                  <button class="btn btn-success">Simpan</button>
                </div>
                
                </form>
    
              </div>
            @elseif ($reg->poli_id == 19)
              <div class="col-md-6">
                <h5><b>Asesmen Keperawatan Pasien Jiwa</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <tr>
                    <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                    <td>
                      <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]" value="Tidak" {{@$assesment['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                      <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]" value="Ya" {{@$assesment['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_alergi']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                    <td>
                      <textarea name="fisik[keluhan_utama]" id="" rows="3" style="resize: vertical; display: inline-block;" class="form-control">
                        {{@$assesment['keluhan_utama']}}
                      </textarea>
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;">1. Keadaan Umum</td>
                    <td>
                      <input type="checkbox" id="keadaanUmum_1" name="fisik[keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$assesment['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                      <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                      <input type="checkbox" id="keadaanUmum_2" name="fisik[keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$assesment['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                      <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                      <input type="checkbox" id="keadaanUmum_3" name="fisik[keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$assesment['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                      <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                      <input type="checkbox" id="keadaanUmum_4" name="fisik[keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$assesment['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                      <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                    <td>
                      <input type="checkbox" id="kesadaran_1" name="fisik[kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$assesment['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                      <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                      <input type="checkbox" id="kesadaran_2" name="fisik[kesadaran][pilihan][apatis]" value="Apatis" {{ @$assesment['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                      <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                      <input type="checkbox" id="kesadaran_3" name="fisik[kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$assesment['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                      <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                      <input type="checkbox" id="kesadaran_4" name="fisik[kesadaran][pilihan][sopor]" value="Sopor" {{ @$assesment['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                      <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                      <input type="checkbox" id="kesadaran_5" name="fisik[kesadaran][pilihan][coma]" value="Coma" {{ @$assesment['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                      <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td rowspan="3" style="width:25%; font-weight:bold;">3. GCS</td>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">E</label>
                      <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control" id="" value="{{@$assesment['GCS']['E']}}">
                    </td>
                    <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">M</label>
                        <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control" id="" value="{{@$assesment['GCS']['M']}}">
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">V</label>
                          <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control" id="" value="{{@$assesment['GCS']['V']}}">
                      </td>
                    </tr>
                  </tr>
    
                  <tr>
                    <td colspan="2" style="width:50%; font-weight:bold;">4. Tanda Vital</td>
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
                    <td colspan="2" style="font-weight:bold;">5. Assesmen Nyeri</td>
                  </tr>
                  <tr>
                    <td>
                      <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak" {{@$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                    </td>
                    <td>
                      <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada" {{@$assesment['nyeri']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                      <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Provokatif</td>
                    <td>
                      <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]" value="Benturan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Benturan' ? 'checked' : ''}}>
                      <label for="provokatif_1" style="font-weight: normal;">Benturan</label>
                      <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : ''}}>
                      <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                      <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]" value="Lain-Lain" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                      <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]" value="{{@$assesment['nyeri']['provokatif']['sebutkan']}}" style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Quality</td>
                    <td>
                      <input type="checkbox" id="quality_1" name="fisik[nyeri][quality][pilihan][tertusuk]" value="Seperti Tertusuk" {{@$assesment['nyeri']['quality']['pilihan']['tertusuk'] == 'Seperti Tertusuk' ? 'checked' : ''}}>
                      <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda Tajam/Tumpul</label><br/>
                      <input type="checkbox" id="quality_2" name="fisik[nyeri][quality][pilihan][berdenyut]" value="Berdenyut" {{@$assesment['nyeri']['quality']['pilihan']['berdenyut'] == 'Berdenyut' ? 'checked' : ''}}>
                      <label for="quality_2" style="font-weight: normal;">Berdenyut</label><br/>
                      <input type="checkbox" id="quality_3" name="fisik[nyeri][quality][pilihan][terbakar]" value="Terbakar" {{@$assesment['nyeri']['quality']['pilihan']['terbakar'] == 'Terbakar' ? 'checked' : ''}}>
                      <label for="quality_3" style="font-weight: normal;">Terbakar</label><br/>
                      <input type="checkbox" id="quality_4" name="fisik[nyeri][quality][pilihan][teriris]" value="Teriris" {{@$assesment['nyeri']['quality']['pilihan']['teriris'] == 'Teriris' ? 'checked' : ''}}>
                      <label for="quality_4" style="font-weight: normal;">Teriris</label><br/>
                      <input type="checkbox" id="quality_5" name="fisik[nyeri][quality][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['nyeri']['quality']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['nyeri']['quality']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Region</td>
                    <td>
                      <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br/>
                      <input type="text" name="fisik[nyeri][region][terlokalisir]" value="{{@$assesment['nyeri']['region']['terlokalisir']}}" style="display:inline-block; width: 100px;" class="form-control" id=""><br/>
                      <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br/>
                      <input type="text" name="fisik[nyeri][region][menyebar]" value="{{@$assesment['nyeri']['region']['menyebar']}}" style="display:inline-block; width: 100px;" class="form-control" id=""><br/>
                    </td>
                  </tr>
    
                  <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">
                      <p style="text-align: left;">- Severity</p>
                      <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 300px; height: 150px; padding-bottom: 10px;"><br/>
                      <input type="radio" id="severity_1" name="fisik[nyeri][severity][pilihan]" value="0" {{@$assesment['nyeri']['severity']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="severity_1" style="font-weight: normal;">0</label>
                      <input type="radio" id="severity_2" name="fisik[nyeri][severity][pilihan]" value="1-3" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '1-3' ? 'checked' : ''}}>
                      <label for="severity_2" style="font-weight: normal;">1-3</label>
                      <input type="radio" id="severity_3" name="fisik[nyeri][severity][pilihan]" value="4-6"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '4-6' ? 'checked' : ''}}>
                      <label for="severity_3" style="font-weight: normal;">4-6</label>
                      <input type="radio" id="severity_4" name="fisik[nyeri][severity][pilihan]" value="7-9"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '7-9' ? 'checked' : ''}}>
                      <label for="severity_4" style="font-weight: normal;">7-9</label>
                      <input type="radio" id="severity_5" name="fisik[nyeri][severity][pilihan]" value="10" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '10' ? 'checked' : ''}}>
                      <label for="severity_5" style="font-weight: normal;">10</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                    <td>
                      <input type="number" name="fisik[nyeri][durasi]" value="{{@$assesment['nyeri']['durasi']}}" style="display:inline-block; width: 100px;" class="form-control" id="">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                    <td>
                      <input type="checkbox" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan][minum_obat]" value="Minum Obat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['minum_obat'] == 'Minum Obat' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br/>
                      <input type="checkbox" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan][istirahat]" value="Istirahat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['istirahat'] == 'Istirahat' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br/>
                      <input type="checkbox" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan][berubah_posisi]" value="Berubah Posisi" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['berubah_posisi'] == 'Berubah Posisi' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br/>
                      <input type="checkbox" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan][mendengarkan_musik]" value="Mendengarkan Musik" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['mendengarkan_musik'] == 'Mendengarkan Musik' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br/>
                      <input type="checkbox" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan][lain]" value="Lain-Lain" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['nyeri_hilang']['sebutkan'] }}">
                    </td>
                  </tr>
  
                </table>

                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <h5><b>I. FAKTOR PREDISPOSISI</b></h5>
                  <tr>
                    <td style="width:25%; font-weight:bold;">1. Pernah mengalami gangguan jiwa dimasa lalu</td>
                    <td>
                      <input type="radio" id="gangguanJiwaMasaLalu1" name="fisik[faktorPredisposisi][gangguanJiwaMasaLalu][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['gangguanJiwaMasaLalu']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="gangguanJiwaMasaLalu1" style="font-weight: normal;">Tidak</label><br>
                      <input type="radio" id="gangguanJiwaMasaLalu2" name="fisik[faktorPredisposisi][gangguanJiwaMasaLalu][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['gangguanJiwaMasaLalu']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="gangguanJiwaMasaLalu2" style="font-weight: normal;">Ya, Tahun</label><br>
                      <input type="text" id="gangguanJiwaMasaLalu3" name="fisik[faktorPredisposisi][gangguanJiwaMasaLalu][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Tahun" value="{{@$assesment['faktorPredisposisi']['gangguanJiwaMasaLalu']['sebutkan']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">2. Pengobatan Sebelumnya</td>
                    <td>
                      <input type="radio" id="pengobatanSebelumnya1" name="fisik[faktorPredisposisi][pengobatanSebelumnya][pilihan]" value="Berhasil" {{@$assesment['faktorPredisposisi']['pengobatanSebelumnya']['pilihan'] == 'Berhasil' ? 'checked' : ''}}>
                      <label for="pengobatanSebelumnya1" style="font-weight: normal; margin-right: 10px;">Berhasil</label>
                      <input type="radio" id="pengobatanSebelumnya2" name="fisik[faktorPredisposisi][pengobatanSebelumnya][pilihan]" value="Kurang Berhasil" {{@$assesment['faktorPredisposisi']['pengobatanSebelumnya']['pilihan'] == 'Kurang Berhasil' ? 'checked' : ''}}>
                      <label for="pengobatanSebelumnya2" style="font-weight: normal; margin-right: 10px;">Kurang Berhasil</label>
                      <input type="radio" id="pengobatanSebelumnya3" name="fisik[faktorPredisposisi][pengobatanSebelumnya][pilihan]" value="Tidak Berhasil" {{@$assesment['faktorPredisposisi']['pengobatanSebelumnya']['pilihan'] == 'Tidak Berhasil' ? 'checked' : ''}}>
                      <label for="pengobatanSebelumnya3" style="font-weight: normal;">Tidak Berhasil</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-weight:bold;">3. Masalah Penganiayaan</td>
                  </tr>
                  <tr>
                    <td style="width:25%;">Aniaya Fisik</td>
                    <td>
                      <input type="radio" id="aniayaFisik1" name="fisik[faktorPredisposisi][masalahPenganiayaan][aniayaFisik][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['aniayaFisik']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="aniayaFisik1" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="aniayaFisik2" name="fisik[faktorPredisposisi][masalahPenganiayaan][aniayaFisik][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['aniayaFisik']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="aniayaFisik2" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%;">Aniaya Seksual</td>
                    <td>
                      <input type="radio" id="aniayaSeksual1" name="fisik[faktorPredisposisi][masalahPenganiayaan][aniayaSeksual][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['aniayaSeksual']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="aniayaSeksual1" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="aniayaSeksual2" name="fisik[faktorPredisposisi][masalahPenganiayaan][aniayaSeksual][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['aniayaSeksual']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="aniayaSeksual2" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%;">Penolakan</td>
                    <td>
                      <input type="radio" id="penolakan1" name="fisik[faktorPredisposisi][masalahPenganiayaan][penolakan][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['penolakan']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="penolakan1" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="penolakan2" name="fisik[faktorPredisposisi][masalahPenganiayaan][penolakan][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['penolakan']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="penolakan2" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%;">Kekerasan Dalam Keluarga</td>
                    <td>
                      <input type="radio" id="kekerasanKeluarga1" name="fisik[faktorPredisposisi][masalahPenganiayaan][kekerasanKeluarga][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['kekerasanKeluarga']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="kekerasanKeluarga1" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="kekerasanKeluarga2" name="fisik[faktorPredisposisi][masalahPenganiayaan][kekerasanKeluarga][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['kekerasanKeluarga']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="kekerasanKeluarga2" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%;">Tindakan Criminal</td>
                    <td>
                      <input type="radio" id="tindakanCriminal1" name="fisik[faktorPredisposisi][masalahPenganiayaan][tindakanCriminal][pilihan]" value="Ya" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['tindakanCriminal']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="tindakanCriminal1" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="tindakanCriminal2" name="fisik[faktorPredisposisi][masalahPenganiayaan][tindakanCriminal][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['masalahPenganiayaan']['tindakanCriminal']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="tindakanCriminal2" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;">4. Adakah anggota keluarga yang mengalami gangguan jiwa</td>
                    <td>
                      <input type="radio" id="keluargaGangguanJiwa1" name="fisik[faktorPredisposisi][keluargaGangguanJiwa][pilihan]" value="Tidak" {{@$assesment['faktorPredisposisi']['keluargaGangguanJiwa']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="keluargaGangguanJiwa1" style="font-weight: normal;">Tidak</label>
                      <input type="radio" id="keluargaGangguanJiwa2" name="fisik[faktorPredisposisi][keluargaGangguanJiwa][pilihan]" value="Ada" {{@$assesment['faktorPredisposisi']['keluargaGangguanJiwa']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                      <label for="keluargaGangguanJiwa2" style="font-weight: normal;">Ada</label><br>
                      <input type="text" id="keluargaGangguanJiwa3" name="fisik[faktorPredisposisi][keluargaGangguanJiwa][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['faktorPredisposisi']['keluargaGangguanJiwa']['sebutkan']}}">
                    </td>
                  </tr>

                  <tr>
                    <td style="width:25%; font-weight:bold;">5. Pengalaman masa lalu yang tidak menyenangkan</td>
                    <td>
                      <input type="radio" id="pengalamanMasaLalu1" name="fisik[faktorPredisposisi][pengalamanMasaLalu][pilihan]" value="Perceraian" {{@$assesment['faktorPredisposisi']['pengalamanMasaLalu']['pilihan'] == 'Perceraian' ? 'checked' : ''}}>
                      <label for="pengalamanMasaLalu1" style="font-weight: normal;">Perceraian</label>
                      <input type="radio" id="pengalamanMasaLalu2" name="fisik[faktorPredisposisi][pengalamanMasaLalu][pilihan]" value="Konflik" {{@$assesment['faktorPredisposisi']['pengalamanMasaLalu']['pilihan'] == 'Konflik' ? 'checked' : ''}}>
                      <label for="pengalamanMasaLalu2" style="font-weight: normal;">Perpisahan/Konflik</label><br>
                      <input type="radio" id="pengalamanMasaLalu3" name="fisik[faktorPredisposisi][pengalamanMasaLalu][pilihan]" value="Lainnya" {{@$assesment['faktorPredisposisi']['pengalamanMasaLalu']['pilihan'] == 'Lainnya' ? 'checked' : ''}}>
                      <label for="pengalamanMasaLalu3" style="font-weight: normal;">Lainnya</label>
                      <input type="text" id="pengalamanMasaLalu3" name="fisik[faktorPredisposisi][pengalamanMasaLalu][sebutkan]" style="display:inline-block; width: 200px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['faktorPredisposisi']['pengalamanMasaLalu']['sebutkan']}}">
                    </td>
                  </tr>
                </table>
              </div>

              <div class="col-md-6">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <h5><b>III. STATUS MENTAL</b></h5>
                  <tr>
                    <td style="width:25%; font-weight:bold;">1. Penampilan</td>
                    <td>
                      <input type="radio" id="penampilan1" name="fisik[statusMental][penampilan][pilihan]" value="Tidak Rapi" {{@$assesment['statusMental']['penampilan']['pilihan'] == 'Tidak Rapi' ? 'checked' : ''}}>
                      <label for="penampilan1" style="font-weight: normal;">Tidak Rapi</label>
                      <input type="radio" id="penampilan2" name="fisik[statusMental][penampilan][pilihan]" value="Penggunaan Pakaian Tidak Sesuai" {{@$assesment['statusMental']['penampilan']['pilihan'] == 'Penggunaan Pakaian Tidak Sesuai' ? 'checked' : ''}}>
                      <label for="penampilan2" style="font-weight: normal;">Penggunaan Pakaian Tidak Sesuai</label><br>
                      <input type="radio" id="penampilan3" name="fisik[statusMental][penampilan][pilihan]" value="Cara Berpakaian Tidak Seperti Biasanya" {{@$assesment['statusMental']['penampilan']['pilihan'] == 'Cara Berpakaian Tidak Seperti Biasanya' ? 'checked' : ''}}>
                      <label for="penampilan3" style="font-weight: normal;">Cara Berpakaian Tidak Seperti Biasanya</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">2. Pembicaraan</td>
                    <td>
                      <input type="radio" id="pembicaraan1" name="fisik[statusMental][pembicaraan][pilihan]" value="Cepat Keras" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Cepat Keras' ? 'checked' : ''}}>
                      <label for="pembicaraan1" style="font-weight: normal; margin-right: 5px;">Cepat Keras</label>
                      <input type="radio" id="pembicaraan2" name="fisik[statusMental][pembicaraan][pilihan]" value="Gagap" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Gagap' ? 'checked' : ''}}>
                      <label for="pembicaraan2" style="font-weight: normal; margin-right: 5px;">Gagap</label>
                      <input type="radio" id="pembicaraan3" name="fisik[statusMental][pembicaraan][pilihan]" value="Inkoheren" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Inkoheren' ? 'checked' : ''}}>
                      <label for="pembicaraan3" style="font-weight: normal; margin-right: 5px;">Inkoheren</label>
                      <input type="radio" id="pembicaraan4" name="fisik[statusMental][pembicaraan][pilihan]" value="Apatis" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Apatis' ? 'checked' : ''}}>
                      <label for="pembicaraan4" style="font-weight: normal; margin-right: 5px;">Apatis</label><br>
                      <input type="radio" id="pembicaraan5" name="fisik[statusMental][pembicaraan][pilihan]" value="Lambat" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Lambat' ? 'checked' : ''}}>
                      <label for="pembicaraan5" style="font-weight: normal; margin-right: 5px;">Lambat</label>
                      <input type="radio" id="pembicaraan6" name="fisik[statusMental][pembicaraan][pilihan]" value="Membisu" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Membisu' ? 'checked' : ''}}>
                      <label for="pembicaraan6" style="font-weight: normal; margin-right: 5px;">Membisu</label>
                      <input type="radio" id="pembicaraan7" name="fisik[statusMental][pembicaraan][pilihan]" value="Tidak Mampu Memulai Bicara" {{@$assesment['statusMental']['pembicaraan']['pilihan'] == 'Tidak Mampu Memulai Bicara' ? 'checked' : ''}}>
                      <label for="pembicaraan7" style="font-weight: normal; margin-right: 5px;">Tidak Mampu Memulai Bicara</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">3. Aktivitas Motoric</td>
                    <td>
                      <input type="radio" id="aktivitasMotoric1" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Lesu" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Lesu' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric1" style="font-weight: normal; margin-right: 5px;">Lesu</label>
                      <input type="radio" id="aktivitasMotoric2" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Tegang" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Tegang' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric2" style="font-weight: normal; margin-right: 5px;">Tegang</label>
                      <input type="radio" id="aktivitasMotoric3" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Gelisah" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Gelisah' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric3" style="font-weight: normal; margin-right: 5px;">Gelisah</label>
                      <input type="radio" id="aktivitasMotoric4" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Agitasi" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Agitasi' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric4" style="font-weight: normal; margin-right: 5px;">Agitasi</label><br>
                      <input type="radio" id="aktivitasMotoric5" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Tik" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Tik' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric5" style="font-weight: normal; margin-right: 5px;">Tik</label>
                      <input type="radio" id="aktivitasMotoric6" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Grimasen" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Grimasen' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric6" style="font-weight: normal; margin-right: 5px;">Grimasen</label>
                      <input type="radio" id="aktivitasMotoric7" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Tremor" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Tremor' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric7" style="font-weight: normal; margin-right: 5px;">Tremor</label>
                      <input type="radio" id="aktivitasMotoric8" name="fisik[statusMental][aktivitasMotoric][pilihan]" value="Kompulsif" {{@$assesment['statusMental']['aktivitasMotoric']['pilihan'] == 'Kompulsif' ? 'checked' : ''}}>
                      <label for="aktivitasMotoric8" style="font-weight: normal; margin-right: 5px;">Kompulsif</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">4. Alam Perasaan</td>
                    <td>
                      <input type="radio" id="alamPerasaan1" name="fisik[statusMental][alamPerasaan][pilihan]" value="Sedih" {{@$assesment['statusMental']['alamPerasaan']['pilihan'] == 'Sedih' ? 'checked' : ''}}>
                      <label for="alamPerasaan1" style="font-weight: normal; margin-right: 5px;">Sedih</label>
                      <input type="radio" id="alamPerasaan2" name="fisik[statusMental][alamPerasaan][pilihan]" value="Ketakutan" {{@$assesment['statusMental']['alamPerasaan']['pilihan'] == 'Ketakutan' ? 'checked' : ''}}>
                      <label for="alamPerasaan2" style="font-weight: normal; margin-right: 5px;">Ketakutan</label>
                      <input type="radio" id="alamPerasaan3" name="fisik[statusMental][alamPerasaan][pilihan]" value="Putus Asa" {{@$assesment['statusMental']['alamPerasaan']['pilihan'] == 'Putus Asa' ? 'checked' : ''}}>
                      <label for="alamPerasaan3" style="font-weight: normal; margin-right: 5px;">Putus Asa</label><br>
                      <input type="radio" id="alamPerasaan4" name="fisik[statusMental][alamPerasaan][pilihan]" value="Khawatir" {{@$assesment['statusMental']['alamPerasaan']['pilihan'] == 'Khawatir' ? 'checked' : ''}}>
                      <label for="alamPerasaan4" style="font-weight: normal; margin-right: 5px;">Khawatir</label>
                      <input type="radio" id="alamPerasaan5" name="fisik[statusMental][alamPerasaan][pilihan]" value="Gembira Berlebihan" {{@$assesment['statusMental']['alamPerasaan']['pilihan'] == 'Gembira Berlebihan' ? 'checked' : ''}}>
                      <label for="alamPerasaan5" style="font-weight: normal; margin-right: 5px;">Gembira Berlebihan</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">5. Afek</td>
                    <td>
                      <input type="radio" id="afek1" name="fisik[statusMental][afek][pilihan]" value="Datar" {{@$assesment['statusMental']['afek']['pilihan'] == 'Datar' ? 'checked' : ''}}>
                      <label for="afek1" style="font-weight: normal; margin-right: 5px;">Datar</label>
                      <input type="radio" id="afek2" name="fisik[statusMental][afek][pilihan]" value="Tumpul" {{@$assesment['statusMental']['afek']['pilihan'] == 'Tumpul' ? 'checked' : ''}}>
                      <label for="afek2" style="font-weight: normal; margin-right: 5px;">Tumpul</label>
                      <input type="radio" id="afek3" name="fisik[statusMental][afek][pilihan]" value="Labil" {{@$assesment['statusMental']['afek']['pilihan'] == 'Labil' ? 'checked' : ''}}>
                      <label for="afek3" style="font-weight: normal; margin-right: 5px;">Labil</label>
                      <input type="radio" id="afek4" name="fisik[statusMental][afek][pilihan]" value="Tidak Sesuai" {{@$assesment['statusMental']['afek']['pilihan'] == 'Tidak Sesuai' ? 'checked' : ''}}>
                      <label for="afek4" style="font-weight: normal; margin-right: 5px;">Tidak Sesuai</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">6. Interaksis Elama Wawancara</td>
                    <td>
                      <input type="radio" id="interaksis1" name="fisik[statusMental][interaksis][pilihan]" value="Kooperatif" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Kooperatif' ? 'checked' : ''}}>
                      <label for="interaksis1" style="font-weight: normal; margin-right: 5px;">Kooperatif</label>
                      <input type="radio" id="interaksis2" name="fisik[statusMental][interaksis][pilihan]" value="Tidak Kooperatif" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Tidak Kooperatif' ? 'checked' : ''}}>
                      <label for="interaksis2" style="font-weight: normal; margin-right: 5px;">Tidak Kooperatif</label>
                      <input type="radio" id="interaksis3" name="fisik[statusMental][interaksis][pilihan]" value="Defensif" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Defensif' ? 'checked' : ''}}>
                      <label for="interaksis3" style="font-weight: normal; margin-right: 5px;">Defensif</label><br>
                      <input type="radio" id="interaksis4" name="fisik[statusMental][interaksis][pilihan]" value="Curiga" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Curiga' ? 'checked' : ''}}>
                      <label for="interaksis4" style="font-weight: normal; margin-right: 5px;">Curiga</label>
                      <input type="radio" id="interaksis5" name="fisik[statusMental][interaksis][pilihan]" value="Mudah Tersinggungan" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Mudah Tersinggungan' ? 'checked' : ''}}>
                      <label for="interaksis5" style="font-weight: normal; margin-right: 5px;">Mudah Tersinggungan</label><br>
                      <input type="radio" id="interaksis6" name="fisik[statusMental][interaksis][pilihan]" value="Kontak Mata Kurang" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Kontak Mata Kurang' ? 'checked' : ''}}>
                      <label for="interaksis6" style="font-weight: normal; margin-right: 5px;">Kontak Mata Kurang</label>
                      <input type="radio" id="interaksis7" name="fisik[statusMental][interaksis][pilihan]" value="Bermusuhan" {{@$assesment['statusMental']['interaksis']['pilihan'] == 'Bermusuhan' ? 'checked' : ''}}>
                      <label for="interaksis7" style="font-weight: normal; margin-right: 5px;">Bermusuhan</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">7. Persepsi / Halusinasi</td>
                    <td>
                      <input type="radio" id="persepsi1" name="fisik[statusMental][persepsi][pilihan]" value="Pendengaran" {{@$assesment['statusMental']['persepsi']['pilihan'] == 'Pendengaran' ? 'checked' : ''}}>
                      <label for="persepsi1" style="font-weight: normal; margin-right: 5px;">Pendengaran</label>
                      <input type="radio" id="persepsi2" name="fisik[statusMental][persepsi][pilihan]" value="Penglihatan" {{@$assesment['statusMental']['persepsi']['pilihan'] == 'Penglihatan' ? 'checked' : ''}}>
                      <label for="persepsi2" style="font-weight: normal; margin-right: 5px;">Penglihatan</label>
                      <input type="radio" id="persepsi3" name="fisik[statusMental][persepsi][pilihan]" value="Perabaan" {{@$assesment['statusMental']['persepsi']['pilihan'] == 'Perabaan' ? 'checked' : ''}}>
                      <label for="persepsi3" style="font-weight: normal; margin-right: 5px;">Perabaan</label><br>
                      <input type="radio" id="persepsi4" name="fisik[statusMental][persepsi][pilihan]" value="Pengecapan" {{@$assesment['statusMental']['persepsi']['pilihan'] == 'Pengecapan' ? 'checked' : ''}}>
                      <label for="persepsi4" style="font-weight: normal; margin-right: 5px;">Pengecapan</label>
                      <input type="radio" id="persepsi5" name="fisik[statusMental][persepsi][pilihan]" value="Penciuman" {{@$assesment['statusMental']['persepsi']['pilihan'] == 'Penciuman' ? 'checked' : ''}}>
                      <label for="persepsi5" style="font-weight: normal; margin-right: 5px;">Penciuman</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">8. Proses Pikir</td>
                    <td>
                      <input type="radio" id="prosesPikir1" name="fisik[statusMental][prosesPikir][pilihan]" value="Sircumstansial" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Sircumstansial' ? 'checked' : ''}}>
                      <label for="prosesPikir1" style="font-weight: normal; margin-right: 5px;">Sircumstansial</label>
                      <input type="radio" id="prosesPikir2" name="fisik[statusMental][prosesPikir][pilihan]" value="Tangensial" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Tangensial' ? 'checked' : ''}}>
                      <label for="prosesPikir2" style="font-weight: normal; margin-right: 5px;">Tangensial</label>
                      <input type="radio" id="prosesPikir3" name="fisik[statusMental][prosesPikir][pilihan]" value="Kehilangan Asosiasi" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Kehilangan Asosiasi' ? 'checked' : ''}}>
                      <label for="prosesPikir3" style="font-weight: normal; margin-right: 5px;">Kehilangan Asosiasi</label><br>
                      <input type="radio" id="prosesPikir4" name="fisik[statusMental][prosesPikir][pilihan]" value="Flightofidea" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Flightofidea' ? 'checked' : ''}}>
                      <label for="prosesPikir4" style="font-weight: normal; margin-right: 5px;">Flightofidea</label>
                      <input type="radio" id="prosesPikir5" name="fisik[statusMental][prosesPikir][pilihan]" value="Blocking" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Blocking' ? 'checked' : ''}}>
                      <label for="prosesPikir5" style="font-weight: normal; margin-right: 5px;">Blocking</label><br>
                      <input type="radio" id="prosesPikir6" name="fisik[statusMental][prosesPikir][pilihan]" value="Pengulangan Pembicaraan" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Pengulangan Pembicaraan' ? 'checked' : ''}}>
                      <label for="prosesPikir6" style="font-weight: normal; margin-right: 5px;">Pengulangan Pembicaraan</label>
                      <input type="radio" id="prosesPikir7" name="fisik[statusMental][prosesPikir][pilihan]" value="Persevarasi" {{@$assesment['statusMental']['prosesPikir']['pilihan'] == 'Persevarasi' ? 'checked' : ''}}>
                      <label for="prosesPikir7" style="font-weight: normal; margin-right: 5px;">Persevarasi</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">9. Isi Pikir</td>
                    <td>
                      <input type="radio" id="isiPikir1" name="fisik[statusMental][isiPikir][pilihan]" value="Obsesi" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Obsesi' ? 'checked' : ''}}>
                      <label for="isiPikir1" style="font-weight: normal; margin-right: 5px;">Obsesi</label>
                      <input type="radio" id="isiPikir2" name="fisik[statusMental][isiPikir][pilihan]" value="Fobia" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Fobia' ? 'checked' : ''}}>
                      <label for="isiPikir2" style="font-weight: normal; margin-right: 5px;">Fobia</label>
                      <input type="radio" id="isiPikir3" name="fisik[statusMental][isiPikir][pilihan]" value="Hipokondria" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Hipokondria' ? 'checked' : ''}}>
                      <label for="isiPikir3" style="font-weight: normal; margin-right: 5px;">Hipokondria</label><br>
                      <input type="radio" id="isiPikir4" name="fisik[statusMental][isiPikir][pilihan]" value="Dipersonalisasi" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Dipersonalisasi' ? 'checked' : ''}}>
                      <label for="isiPikir4" style="font-weight: normal; margin-right: 5px;">Dipersonalisasi</label>
                      <input type="radio" id="isiPikir5" name="fisik[statusMental][isiPikir][pilihan]" value="Ide Yang Terkait" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Ide Yang Terkait' ? 'checked' : ''}}>
                      <label for="isiPikir5" style="font-weight: normal; margin-right: 5px;">Ide Yang Terkait</label>
                      <input type="radio" id="isiPikir6" name="fisik[statusMental][isiPikir][pilihan]" value="Pikiran Magis" {{@$assesment['statusMental']['isiPikir']['pilihan'] == 'Pikiran Magis' ? 'checked' : ''}}>
                      <label for="isiPikir6" style="font-weight: normal; margin-right: 5px;">Pikiran Magis</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">10. Waham</td>
                    <td>
                      <input type="radio" id="waham1" name="fisik[statusMental][waham][pilihan]" value="Agama" {{@$assesment['statusMental']['waham']['pilihan'] == 'Agama' ? 'checked' : ''}}>
                      <label for="waham1" style="font-weight: normal; margin-right: 5px;">Agama</label>
                      <input type="radio" id="waham2" name="fisik[statusMental][waham][pilihan]" value="Somatik" {{@$assesment['statusMental']['waham']['pilihan'] == 'Somatik' ? 'checked' : ''}}>
                      <label for="waham2" style="font-weight: normal; margin-right: 5px;">Somatik</label>
                      <input type="radio" id="waham3" name="fisik[statusMental][waham][pilihan]" value="Kebesaran Curiga" {{@$assesment['statusMental']['waham']['pilihan'] == 'Kebesaran Curiga' ? 'checked' : ''}}>
                      <label for="waham3" style="font-weight: normal; margin-right: 5px;">Kebesaran Curiga</label>
                      <input type="radio" id="waham4" name="fisik[statusMental][waham][pilihan]" value="Nihilistik" {{@$assesment['statusMental']['waham']['pilihan'] == 'Nihilistik' ? 'checked' : ''}}>
                      <label for="waham4" style="font-weight: normal; margin-right: 5px;">Nihilistik</label><br>
                      <input type="radio" id="waham5" name="fisik[statusMental][waham][pilihan]" value="Sisip Piker" {{@$assesment['statusMental']['waham']['pilihan'] == 'Sisip Piker' ? 'checked' : ''}}>
                      <label for="waham5" style="font-weight: normal; margin-right: 5px;">Sisip Piker</label>
                      <input type="radio" id="waham6" name="fisik[statusMental][waham][pilihan]" value="Siap Pikir" {{@$assesment['statusMental']['waham']['pilihan'] == 'Siap Pikir' ? 'checked' : ''}}>
                      <label for="waham6" style="font-weight: normal; margin-right: 5px;">Siap Pikir</label>
                      <input type="radio" id="waham7" name="fisik[statusMental][waham][pilihan]" value="Kontrol Pikir" {{@$assesment['statusMental']['waham']['pilihan'] == 'Kontrol Pikir' ? 'checked' : ''}}>
                      <label for="waham7" style="font-weight: normal; margin-right: 5px;">Kontrol Pikir</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">11. Tingkat Kesadaran</td>
                    <td>
                      <input type="radio" id="tingkatKesadaran1" name="fisik[statusMental][tingkatKesadaran][pilihan]" value="Bingung" {{@$assesment['statusMental']['tingkatKesadaran']['pilihan'] == 'Bingung' ? 'checked' : ''}}>
                      <label for="tingkatKesadaran1" style="font-weight: normal; margin-right: 5px;">Bingung</label>
                      <input type="radio" id="tingkatKesadaran2" name="fisik[statusMental][tingkatKesadaran][pilihan]" value="Fobia" {{@$assesment['statusMental']['tingkatKesadaran']['pilihan'] == 'Fobia' ? 'checked' : ''}}>
                      <label for="tingkatKesadaran2" style="font-weight: normal; margin-right: 5px;">Fobia</label>
                      <input type="radio" id="tingkatKesadaran3" name="fisik[statusMental][tingkatKesadaran][pilihan]" value="Hipokondria" {{@$assesment['statusMental']['tingkatKesadaran']['pilihan'] == 'Hipokondria' ? 'checked' : ''}}>
                      <label for="tingkatKesadaran3" style="font-weight: normal; margin-right: 5px;">Hipokondria</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">12. Disorientasi</td>
                    <td>
                      <input type="radio" id="disorientasi1" name="fisik[statusMental][disorientasi][pilihan]" value="Waktu" {{@$assesment['statusMental']['disorientasi']['pilihan'] == 'Waktu' ? 'checked' : ''}}>
                      <label for="disorientasi1" style="font-weight: normal; margin-right: 5px;">Waktu</label>
                      <input type="radio" id="disorientasi2" name="fisik[statusMental][disorientasi][pilihan]" value="Tempat" {{@$assesment['statusMental']['disorientasi']['pilihan'] == 'Tempat' ? 'checked' : ''}}>
                      <label for="disorientasi2" style="font-weight: normal; margin-right: 5px;">Tempat</label>
                      <input type="radio" id="disorientasi3" name="fisik[statusMental][disorientasi][pilihan]" value="Orang" {{@$assesment['statusMental']['disorientasi']['pilihan'] == 'Orang' ? 'checked' : ''}}>
                      <label for="disorientasi3" style="font-weight: normal; margin-right: 5px;">Orang</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">13. Memori</td>
                    <td>
                      <input type="radio" id="memori1" name="fisik[statusMental][memori][pilihan]" value="Gangguan Daya Ingat Jangka Panjang" {{@$assesment['statusMental']['memori']['pilihan'] == 'Gangguan Daya Ingat Jangka Panjang' ? 'checked' : ''}}>
                      <label for="memori1" style="font-weight: normal; margin-right: 5px;">Gangguan Daya Ingat Jangka Panjang</label><br>
                      <input type="radio" id="memori2" name="fisik[statusMental][memori][pilihan]" value="Gangguan Daya Ingat Pendek" {{@$assesment['statusMental']['memori']['pilihan'] == 'Gangguan Daya Ingat Pendek' ? 'checked' : ''}}>
                      <label for="memori2" style="font-weight: normal; margin-right: 5px;">Gangguan Daya Ingat Pendek</label><br>
                      <input type="radio" id="memori3" name="fisik[statusMental][memori][pilihan]" value="Gangguan Daya Ingat Saat Ini" {{@$assesment['statusMental']['memori']['pilihan'] == 'Gangguan Daya Ingat Saat Ini' ? 'checked' : ''}}>
                      <label for="memori3" style="font-weight: normal; margin-right: 5px;">Gangguan Daya Ingat Saat Ini</label>
                      <input type="radio" id="memori4" name="fisik[statusMental][memori][pilihan]" value="Konfabulasi" {{@$assesment['statusMental']['memori']['pilihan'] == 'Konfabulasi' ? 'checked' : ''}}>
                      <label for="memori4" style="font-weight: normal; margin-right: 5px;">Konfabulasi</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">14. Tingkat Konsentrasi dan Berhitung</td>
                    <td>
                      <input type="radio" id="tingkatKonsentrasi1" name="fisik[statusMental][tingkatKonsentrasi][pilihan]" value="Mudah Bersedih" {{@$assesment['statusMental']['tingkatKonsentrasi']['pilihan'] == 'Mudah Bersedih' ? 'checked' : ''}}>
                      <label for="tingkatKonsentrasi1" style="font-weight: normal; margin-right: 5px;">Mudah Bersedih</label>
                      <input type="radio" id="tingkatKonsentrasi2" name="fisik[statusMental][tingkatKonsentrasi][pilihan]" value="Tidak Mampu Berkonsentrasi" {{@$assesment['statusMental']['tingkatKonsentrasi']['pilihan'] == 'Tidak Mampu Berkonsentrasi' ? 'checked' : ''}}>
                      <label for="tingkatKonsentrasi2" style="font-weight: normal; margin-right: 5px;">Tidak Mampu Berkonsentrasi</label><br>
                      <input type="radio" id="tingkatKonsentrasi3" name="fisik[statusMental][tingkatKonsentrasi][pilihan]" value="Tidak Mampu Berhitung Sederhana" {{@$assesment['statusMental']['tingkatKonsentrasi']['pilihan'] == 'Tidak Mampu Berhitung Sederhana' ? 'checked' : ''}}>
                      <label for="tingkatKonsentrasi3" style="font-weight: normal; margin-right: 5px;">Tidak Mampu Berhitung Sederhana</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">15. Kemampuan Penilaian</td>
                    <td>
                      <input type="radio" id="kemampuanPenilaian1" name="fisik[statusMental][kemampuanPenilaian][pilihan]" value="Gangguan Ringan" {{@$assesment['statusMental']['kemampuanPenilaian']['pilihan'] == 'Gangguan Ringan' ? 'checked' : ''}}>
                      <label for="kemampuanPenilaian1" style="font-weight: normal; margin-right: 5px;">Gangguan Ringan</label>
                      <input type="radio" id="kemampuanPenilaian2" name="fisik[statusMental][kemampuanPenilaian][pilihan]" value="Gangguan Bermakna" {{@$assesment['statusMental']['kemampuanPenilaian']['pilihan'] == 'Gangguan Bermakna' ? 'checked' : ''}}>
                      <label for="kemampuanPenilaian2" style="font-weight: normal; margin-right: 5px;">Gangguan Bermakna</label><br>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">16. Daya Tarik Diri</td>
                    <td>
                      <input type="radio" id="dayaTarikDiri1" name="fisik[statusMental][dayaTarikDiri][pilihan]" value="Mengingkari Penyakit Yang Diderita" {{@$assesment['statusMental']['dayaTarikDiri']['pilihan'] == 'Mengingkari Penyakit Yang Diderita' ? 'checked' : ''}}>
                      <label for="dayaTarikDiri1" style="font-weight: normal; margin-right: 5px;">Mengingkari Penyakit Yang Diderita</label> <br>
                      <input type="radio" id="dayaTarikDiri2" name="fisik[statusMental][dayaTarikDiri][pilihan]" value="Menyalahkan hal-hal Yang diluar dirinya" {{@$assesment['statusMental']['dayaTarikDiri']['pilihan'] == 'Menyalahkan hal-hal Yang diluar dirinya' ? 'checked' : ''}}>
                      <label for="dayaTarikDiri2" style="font-weight: normal; margin-right: 5px;">Menyalahkan hal-hal Yang diluar dirinya</label><br>
                  </tr>
                  
                </table>

                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <h5><b>IV. ACTIVITY DAILY LIFE</b></h5>
                  <tr>
                    <td style="width:25%; font-weight:bold;">1. Makan dan Minum</td>
                    <td>
                      <input type="radio" id="makanMinum1" name="fisik[activityDailyLife][makanMinum][pilihan]" value="Bantuan Minimal" {{@$assesment['activityDailyLife']['makanMinum']['pilihan'] == 'Bantuan Minimal' ? 'checked' : ''}}>
                      <label for="makanMinum1" style="font-weight: normal; margin-right: 5px;">Bantuan Minimal</label> 
                      <input type="radio" id="makanMinum2" name="fisik[activityDailyLife][makanMinum][pilihan]" value="Bantuan Total" {{@$assesment['activityDailyLife']['makanMinum']['pilihan'] == 'Bantuan Total' ? 'checked' : ''}}>
                      <label for="makanMinum2" style="font-weight: normal; margin-right: 5px;">Bantuan Total</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">2. Berpakaian / Berhias</td>
                    <td>
                      <input type="radio" id="berpakaian1" name="fisik[activityDailyLife][berpakaian][pilihan]" value="Bantuan Minimal" {{@$assesment['activityDailyLife']['berpakaian']['pilihan'] == 'Bantuan Minimal' ? 'checked' : ''}}>
                      <label for="berpakaian1" style="font-weight: normal; margin-right: 5px;">Bantuan Minimal</label> 
                      <input type="radio" id="berpakaian2" name="fisik[activityDailyLife][berpakaian][pilihan]" value="Bantuan Total" {{@$assesment['activityDailyLife']['berpakaian']['pilihan'] == 'Bantuan Total' ? 'checked' : ''}}>
                      <label for="berpakaian2" style="font-weight: normal; margin-right: 5px;">Bantuan Total</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">3. Mandi</td>
                    <td>
                      <input type="radio" id="mandi1" name="fisik[activityDailyLife][mandi][pilihan]" value="Bantuan Minimal" {{@$assesment['activityDailyLife']['mandi']['pilihan'] == 'Bantuan Minimal' ? 'checked' : ''}}>
                      <label for="mandi1" style="font-weight: normal; margin-right: 5px;">Bantuan Minimal</label> 
                      <input type="radio" id="mandi2" name="fisik[activityDailyLife][mandi][pilihan]" value="Bantuan Total" {{@$assesment['activityDailyLife']['mandi']['pilihan'] == 'Bantuan Total' ? 'checked' : ''}}>
                      <label for="mandi2" style="font-weight: normal; margin-right: 5px;">Bantuan Total</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">4. BAB/BAK</td>
                    <td>
                      <input type="radio" id="bab1" name="fisik[activityDailyLife][bab][pilihan]" value="Bantuan Minimal" {{@$assesment['activityDailyLife']['bab']['pilihan'] == 'Bantuan Minimal' ? 'checked' : ''}}>
                      <label for="bab1" style="font-weight: normal; margin-right: 5px;">Bantuan Minimal</label> 
                      <input type="radio" id="bab2" name="fisik[activityDailyLife][bab][pilihan]" value="Bantuan Total" {{@$assesment['activityDailyLife']['bab']['pilihan'] == 'Bantuan Total' ? 'checked' : ''}}>
                      <label for="bab2" style="font-weight: normal; margin-right: 5px;">Bantuan Total</label>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">5. Istirahat / Tidur</td>
                    <td>
                      <span>Tidur Siang : </span><br>
                      <input type="text" name="fisik[activityDailyLife][tidur][siang]" value="{{ @$assesment['activityDailyLife']['tidur']['siang'] }}" class="form-control" style="display: inline-block; width: 150px;"> <span> Jam</span> <br>
                      <span>Tidur Malam : </span><br>
                      <input type="text" name="fisik[activityDailyLife][tidur][malam]" value="{{ @$assesment['activityDailyLife']['tidur']['malam'] }}" class="form-control" style="display: inline-block; width: 150px;"> <span> Jam</span> <br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:bold;">6. Kegiatan Diluar Rumah</td>
                    <td>
                      <span>Bekerja : </span><br>
                      <input type="radio" id="kegiatanDiluarRumah1" name="fisik[activityDailyLife][kegiatanDiluarRumah][pilihan]" value="Tidak" {{@$assesment['activityDailyLife']['kegiatanDiluarRumah']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="kegiatanDiluarRumah1" style="font-weight: normal;">Tidak</label>
                      <input type="radio" id="kegiatanDiluarRumah2" name="fisik[activityDailyLife][kegiatanDiluarRumah][pilihan]" value="Ya" {{@$assesment['activityDailyLife']['kegiatanDiluarRumah']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                      <label for="kegiatanDiluarRumah2" style="font-weight: normal;">Ya</label><br>
                      <input type="text" id="kegiatanDiluarRumah3" name="fisik[activityDailyLife][kegiatanDiluarRumah][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['activityDailyLife']['kegiatanDiluarRumah']['sebutkan']}}">
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
                      <input type="text" id="waktuKontrol3" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <button type="button" id="listKontrol3" data-dokterID="{{ $reg->dokter_id }}"
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
                      <input type="checkbox" id="dischargePlanning_dirujuk3" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                      <label for="dischargePlanning_dirujuk3" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                    </td>
                    <td>
                      <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                    </td>
                  </tr>

                  <tr id="rujukan3" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Faskes Rujukan
                    </td>
                    <td>
                        <select id="faskes3" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            <option value="RS Kab. Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                            <option value="RS Kota Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                            <option value="RS Provinsi" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                        </select>
                    </td>
                  </tr>
                  <tr id="rs_rujukan3" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Rumah Sakit Rujukan
                    </td>
                    <td>
                        <select id="faskes_rs_rujukan3" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            @foreach ($faskesRujukanRs as $rs)
                                <option value="{{$rs->id}}" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                            @endforeach
                        </select>
                    </td>
                  </tr>
                  <tr id="alasan_rujukan3" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Alasan
                    </td>
                    <td>
                        <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesment['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
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
                

                <input type="hidden" name="fisik[perawat][tanggal]" value="{{ now() }}">
                <input type="hidden" name="fisik[perawat][nama]" value="{{ @Auth::user()->name }}">
    
                <div style="text-align: right;">
                  <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
                  <button class="btn btn-success">Simpan</button>
                </div>
                
                </form>

              </div>
            @else
              <div class="col-md-6">
                <h5><b>Asesmen</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                  <tr>
                    <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                    <td>
                        <div style="display: flex; gap: 10px">
                            <div>
                                <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]" value="Tidak" {{@$assesment['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                                <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                            </div>
                            <div>
                                <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]" value="Ya" {{@$assesment['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                                <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                            </div>
                        </div>
                        <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['riwayat_alergi']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                    <td>
                      <textarea name="fisik[keluhan_utama]" id="" rows="2" style="resize: vertical; display: inline-block;" class="form-control">{{@$assesment['keluhan_utama']}}</textarea>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">1. Keadaan Umum</td>
                    <td>
                      <input type="checkbox" id="keadaanUmum_1" name="fisik[keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$assesment['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                      <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                      <input type="checkbox" id="keadaanUmum_2" name="fisik[keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$assesment['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                      <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                      <input type="checkbox" id="keadaanUmum_3" name="fisik[keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$assesment['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                      <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                      <input type="checkbox" id="keadaanUmum_4" name="fisik[keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$assesment['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                      <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                    <td>
                      <input type="checkbox" id="kesadaran_1" name="fisik[kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$assesment['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                      <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                      <input type="checkbox" id="kesadaran_2" name="fisik[kesadaran][pilihan][apatis]" value="Apatis" {{ @$assesment['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                      <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                      <input type="checkbox" id="kesadaran_3" name="fisik[kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$assesment['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                      <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                      <input type="checkbox" id="kesadaran_4" name="fisik[kesadaran][pilihan][sopor]" value="Sopor" {{ @$assesment['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                      <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                      <input type="checkbox" id="kesadaran_5" name="fisik[kesadaran][pilihan][coma]" value="Coma" {{ @$assesment['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                      <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td rowspan="4" style="width:25%; font-weight:bold;">3. GCS</td>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">E</label>
                      <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="{{@$assesment['GCS']['E']}}">
                    </td>
                    <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">M</label>
                        <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="{{@$assesment['GCS']['M']}}">
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                      <label class="form-check-label" style="margin-right: 20px;">V</label>
                          <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="{{@$assesment['GCS']['V']}}">
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                          <label class="form-check-label "  style="margin-right: 20px;">Total</label>
                          <input type="text" name="fisik[GCS][Total]" style="display:inline-block; width: 100px;" placeholder="Total" class="form-control" id="gcsScore" disabled value="0">
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
                      <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['tekanan_darah']}}">
                    </td>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                      <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['nadi']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                      <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['RR']}}">
                    </td>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                      <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['tanda_vital']['temp']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                      <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="bb" value="{{ @$assesment['tanda_vital']['BB'] }}">
                    </td>
                    <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                      <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100%;" class="form-control bmi-input" id="tb" value="{{ @$assesment['tanda_vital']['TB'] }}">
                    </td>
                  </tr>
                  @if (@$reg->poli_id == '29')
                  <tr>
                    <td colspan="2" style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;">BMI</label><br/>
                      <input type="text" name="fisik[tanda_vital][BMI]" style="display:inline-block; width: 100%;" class="form-control" id="bmiScore" readonly value="0">
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
                  @endif

                  @if (@$reg->poli_id == 20)
                    <tr>
                      <td colspan="2">
                        <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis" class="btn btn-default btn-sm btn-flat" target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                      </td>
                    </tr>
                    @if (@$gambar->image != null)
                    <tr>
                      <td colspan="2"><b>Status Lokalis :</b> 
                        
                         
                          
                         {{-- <a id="myImg"><i class="fa fa-eye text-primary"></i></a> --}}
                          <br>
                          <img src="/images/{{ @$gambar['image'] }}" id="dataImage" style="width: 400px; height:300px;">
                          <br>
                          <label for="">Keterangan Lokalis</label>
                          <br>
                          <ol>
                            <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }} </li>
                            <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }} </li>
                          </ol>
                      </td>
                    </tr>
                    @endif
                  @endif
    
                  <tr>
                    <td colspan="2" style="font-weight:bold;">5. Assesmen Nyeri</td>
                  </tr>
                  <tr>
                    <td>
                      <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak" {{@$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                      <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                    </td>
                    <td>
                      <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada" {{@$assesment['nyeri']['pilihan'] == 'Ada' ? 'checked' : ''}}>
                      <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Provokatif</td>
                    <td>
                      <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]" value="Benturan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Benturan' ? 'checked' : ''}}>
                      <label for="provokatif_1" style="font-weight: normal;">Benturan</label>
                      <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : ''}}>
                      <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                      <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]" value="Lain-Lain" {{@$assesment['nyeri']['provokatif']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                      <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['nyeri']['provokatif']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Quality</td>
                    <td>
                      <input type="checkbox" id="quality_1" name="fisik[nyeri][quality][pilihan][tertusuk]" value="Seperti Tertusuk" {{@$assesment['nyeri']['quality']['pilihan']['tertusuk'] == 'Seperti Tertusuk' ? 'checked' : ''}}>
                      <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda Tajam/Tumpul</label><br/>
                      <input type="checkbox" id="quality_2" name="fisik[nyeri][quality][pilihan][berdenyut]" value="Berdenyut" {{@$assesment['nyeri']['quality']['pilihan']['berdenyut'] == 'Berdenyut' ? 'checked' : ''}}>
                      <label for="quality_2" style="font-weight: normal;">Berdenyut</label><br/>
                      <input type="checkbox" id="quality_3" name="fisik[nyeri][quality][pilihan][terbakar]" value="Terbakar" {{@$assesment['nyeri']['quality']['pilihan']['terbakar'] == 'Terbakar' ? 'checked' : ''}}>
                      <label for="quality_3" style="font-weight: normal;">Terbakar</label><br/>
                      <input type="checkbox" id="quality_4" name="fisik[nyeri][quality][pilihan][teriris]" value="Teriris" {{@$assesment['nyeri']['quality']['pilihan']['teriris'] == 'Teriris' ? 'checked' : ''}}>
                      <label for="quality_4" style="font-weight: normal;">Teriris</label><br/>
                      <input type="checkbox" id="quality_5" name="fisik[nyeri][quality][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['nyeri']['quality']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['nyeri']['quality']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Region</td>
                    <td>
                      <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br/>
                      <input type="text" name="fisik[nyeri][region][terlokalisir]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['nyeri']['region']['terlokalisir']}}"><br/>
                      <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br/>
                      <input type="text" name="fisik[nyeri][region][menyebar]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['nyeri']['region']['menyebar']}}"><br/>
                    </td>
                  </tr>
    
                  <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">
                      <p style="text-align: left;">- Severity</p>
                      <img src="/images/skalaNyeriFix.jpg" alt="" style="width: 300px; height: 150px; padding-bottom: 10px;"><br/>
                      <input type="radio" id="severity_1" name="fisik[nyeri][severity][pilihan]" value="0" {{@$assesment['nyeri']['severity']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="severity_1" style="font-weight: normal;">0</label>
                      <input type="radio" id="severity_2" name="fisik[nyeri][severity][pilihan]" value="1-3" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '1-3' ? 'checked' : ''}}>
                      <label for="severity_2" style="font-weight: normal;">1-3</label>
                      <input type="radio" id="severity_3" name="fisik[nyeri][severity][pilihan]" value="4-6"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '4-6' ? 'checked' : ''}}>
                      <label for="severity_3" style="font-weight: normal;">4-6</label>
                      <input type="radio" id="severity_4" name="fisik[nyeri][severity][pilihan]" value="7-9"  style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '7-9' ? 'checked' : ''}}>
                      <label for="severity_4" style="font-weight: normal;">7-9</label>
                      <input type="radio" id="severity_5" name="fisik[nyeri][severity][pilihan]" value="10" style="margin-left: 25px;" {{@$assesment['nyeri']['severity']['pilihan'] == '10' ? 'checked' : ''}}>
                      <label for="severity_5" style="font-weight: normal;">10</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                    <td>
                      <input type="number" name="fisik[nyeri][durasi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['nyeri']['durasi']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                    <td>
                      <input type="checkbox" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan][minum_obat]" value="Minum Obat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['minum_obat'] == 'Minum Obat' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br/>
                      <input type="checkbox" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan][istirahat]" value="Istirahat" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['istirahat'] == 'Istirahat' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br/>
                      <input type="checkbox" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan][berubah_posisi]" value="Berubah Posisi" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['berubah_posisi'] == 'Berubah Posisi' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br/>
                      <input type="checkbox" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan][mendengarkan_musik]" value="Mendengarkan Musik" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['mendengarkan_musik'] == 'Mendengarkan Musik' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br/>
                      <input type="checkbox" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan][lain]" value="Lain-Lain" {{ @$assesment['nyeri']['nyeri_hilang']['pilihan']['lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['nyeri']['nyeri_hilang']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td colspan="2" style="font-weight:bold;">6. Risiko Jatuh</td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Apakah ada riwayat jatuh dalam waktu 3 bulan sebab apapun</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input class="hitungResiko" type="radio" id="riwayatJatuh_1" name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="25" {{@$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '25' ? 'checked' : ''}}>
                                <label for="riwayatJatuh_1" style="font-weight: normal;">Ya <b>(25 Skor)</b></label><br/>
                            </div>
                            <div>
                                <input class="hitungResiko" type="radio" id="riwayatJatuh_2" name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="0" {{@$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '0' ? 'checked' : ''}}>
                                <label for="riwayatJatuh_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Diagnosis sekunder : Apakah memiliki lebih dari satu penyakit</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input class="hitungResiko" type="radio" id="diagnosisSekunder_1" name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="15" {{@$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '15' ? 'checked' : ''}}>
                                <label for="diagnosisSekunder_1" style="font-weight: normal;">Ya <b>(15 Skor)</b></label><br/>
                            </div>
                            <div>
                                <input class="hitungResiko" type="radio" id="diagnosisSekunder_2" name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="0" {{@$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '0' ? 'checked' : ''}}>
                                <label for="diagnosisSekunder_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Alat bantu berjalan</td>
                    <td>
                      <input class="hitungResiko" type="radio" id="alatBantu_1" name="fisik[risikoJatuh][alatBantu][pilihan]" value="0" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="alatBantu_1" style="font-weight: normal;">Dibantu perawat/tidak menggunakan alat bantu/bed rest <b>(0 Skor)</b></label><br/>
                      <input class="hitungResiko" type="radio" id="alatBantu_2" name="fisik[risikoJatuh][alatBantu][pilihan]" value="15" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '15' ? 'checked' : ''}}>
                      <label for="alatBantu_2" style="font-weight: normal;">Menggunakan alat bantu : kruk/tongka, kursi roda <b>(15 Skor)</b></label><br/>
                      <input class="hitungResiko" type="radio" id="alatBantu_3" name="fisik[risikoJatuh][alatBantu][pilihan]" value="30" {{@$assesment['risikoJatuh']['alatBantu']['pilihan'] == '30' ? 'checked' : ''}}>
                      <label for="alatBantu_3" style="font-weight: normal;">Merambat dengan berpegangan pada benda di sekitar (meja, kursi, lemari, dll) <b>(30 Skor)</b></label><br/>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Apakah terpasang infus/pemberian anti koagulan (heparin)/obat lain yang mempunyai efek samping risiko jatuh</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input class="hitungResiko" type="radio" id="efekSamping_1" name="fisik[risikoJatuh][efekSamping][pilihan]" value="20" {{@$assesment['risikoJatuh']['efekSamping']['pilihan'] == '20' ? 'checked' : ''}}>
                                <label for="efekSamping_1" style="font-weight: normal;">Ya <b>(20 Skor)</b></label><br/>
                            </div>
                            <div>
                                <input class="hitungResiko" type="radio" id="efekSamping_2" name="fisik[risikoJatuh][efekSamping][pilihan]" value="0" {{@$assesment['risikoJatuh']['efekSamping']['pilihan'] == '0' ? 'checked' : ''}}>
                                <label for="efekSamping_2" style="font-weight: normal;">Tidak <b>(0 Skor)</b></label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Kondisi untuk melakukan gerakan berpindah / mobilisasi</td>
                    <td>
                      <input class="hitungResiko" type="radio" id="mobilisasi_1" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="0" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="mobilisasi_1" style="font-weight: normal;">Normal/bed rest/Imobilisasi <b>(0 Skor)</b></label><br/>
                      <input class="hitungResiko" type="radio" id="mobilisasi_2" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="15" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '15' ? 'checked' : ''}}>
                      <label for="mobilisasi_2" style="font-weight: normal;">Lemah (tidak bertenaga) <b>(15 Skor)</b></label><br/>
                      <input class="hitungResiko" type="radio" id="mobilisasi_3" name="fisik[risikoJatuh][mobilisasi][pilihan]" value="30" {{@$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '30' ? 'checked' : ''}}>
                      <label for="mobilisasi_3" style="font-weight: normal;">Ada keterbatasan berjalan (pincang, diseret) <b>(30 Skor)</b></label><br/>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Bagaimana Status Mental</td>
                    <td>
                      <input class="hitungResiko" type="radio" id="statusMental_1" name="fisik[risikoJatuh][statusMental][pilihan]" value="0" {{@$assesment['risikoJatuh']['statusMental']['pilihan'] == '0' ? 'checked' : ''}}>
                      <label for="statusMental_1" style="font-weight: normal;">Menyadari kelemahannya <b>(0 Skor)</b></label><br/>
                      <input class="hitungResiko" type="radio" id="statusMental_2" name="fisik[risikoJatuh][statusMental][pilihan]" value="15" {{@$assesment['risikoJatuh']['statusMental']['pilihan'] == '15' ? 'checked' : ''}}>
                      <label for="statusMental_2" style="font-weight: normal;">Tidak menyadari kelemahannya <b>(15 Skor)</b></label><br/>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">JUMLAH SKOR</td>
                    <td>
                      <input type="number" name="fisik[risikoJatuh][jumlahSkor][angka]" style="display:inline-block; width: 100%;" class="form-control jumlahSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['angka']}}" readonly>
                      <br><br>
                      <input type="text" name="fisik[risikoJatuh][jumlahSkor][hasil]" style="display:inline-block; width: 100%;" class="form-control hasilSkorResiko" id="" value="{{@$assesment['risikoJatuh']['jumlahSkor']['hasil']}}" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-weight:bold;">7. Fungsional</td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Alat Bantu</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input type="radio" id="alatBantu_1" name="fisik[fungsional][alatBantu][pilihan]" value="Ya" {{@$assesment['fungsional']['alatBantu']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                                <label for="alatBantu_1" style="font-weight: normal;">Ya</label><br/>
                            </div>
                            <div>
                                <input type="radio" id="alatBantu_2" name="fisik[fungsional][alatBantu][pilihan]" value="Tidak" {{@$assesment['fungsional']['alatBantu']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                                <label for="alatBantu_2" style="font-weight: normal;">Tidak</label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Protesa</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input type="radio" id="protesa_1" name="fisik[fungsional][protesa][pilihan]" value="Ya" {{@$assesment['fungsional']['protesa']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                                <label for="protesa_1" style="font-weight: normal;">Ya</label><br/>
                            </div>
                            <div>
                                <input type="radio" id="protesa_2" name="fisik[fungsional][protesa][pilihan]" value="Tidak" {{@$assesment['fungsional']['protesa']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                                <label for="protesa_2" style="font-weight: normal;">Tidak</label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Cacat Tubuh</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input type="radio" id="cacatTubuh_1" name="fisik[fungsional][cacatTubuh][pilihan]" value="Ya" {{@$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                                <label for="cacatTubuh_1" style="font-weight: normal;">Ya</label><br/>
                            </div>
                            <div>
                                <input type="radio" id="cacatTubuh_2" name="fisik[fungsional][cacatTubuh][pilihan]" value="Tidak" {{@$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                                <label for="cacatTubuh_2" style="font-weight: normal;">Tidak</label><br/>
                            </div>
                        </div>
                     
                     
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Activity of Daily Living (ADL)</td>
                    <td>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input type="radio" id="adl_1" name="fisik[fungsional][adl][pilihan]" value="Mandiri" {{@$assesment['fungsional']['adl']['pilihan'] == 'Mandiri' ? 'checked' : ''}}>
                                <label for="adl_1" style="font-weight: normal;">Mandiri</label><br/>
                            </div>
                            <div>
                                <input type="radio" id="adl_2" name="fisik[fungsional][adl][pilihan]" value="Dibantu" {{@$assesment['fungsional']['adl']['pilihan'] == 'Dibantu' ? 'checked' : ''}}>
                                <label for="adl_2" style="font-weight: normal;">Dibantu</label><br/>
                            </div>
                        </div>
                    </td>
                  </tr>
    
                  <tr>
                    <td colspan="2" style="font-weight:bold;">PEMERIKSAAN FISIK</td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Pernyarafan</td>
                    <td>
                      <input type="checkbox" id="pernyarafan_1" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="pernyarafan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                      <input type="checkbox" id="pernyarafan_2" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][tremor]" value="Tremor" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['tremor'] == 'Tremor' ? 'checked' : ''}}>
                      <label for="pernyarafan_2" style="font-weight: normal;">Tremor</label><br/>
                      <input type="checkbox" id="pernyarafan_3" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][hemiparase]" value="Hemiparase" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['hemiparase'] == 'Hemiparase' ? 'checked' : ''}}>
                      <label for="pernyarafan_3" style="font-weight: normal;">Hemiparase/Hemiplegia</label><br/>
                      <input type="checkbox" id="pernyarafan_4" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][rom]" value="ROM" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['rom'] == 'ROM' ? 'checked' : ''}}>
                      <label for="pernyarafan_4" style="font-weight: normal;">ROM</label><br/>
                      <input type="checkbox" id="pernyarafan_5" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][paralise]" value="Paralise" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['paralise'] == 'Paralise' ? 'checked' : ''}}>
                      <label for="pernyarafan_5" style="font-weight: normal;">Paralise</label><br/>
                      <input type="checkbox" id="pernyarafan_6" name="fisik[pemeriksaanFisik][pernyarafan][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['pernyarafan']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="pernyarafan_6" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="pernyarafan_7" name="fisik[pemeriksaanFisik][pernyarafan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['pernyarafan']['sebutkan']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Pernapasan</td>
                    <td>
                      <input type="checkbox" id="pernapasan_1" name="fisik[pemeriksaanFisik][pernapasan][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="pernapasan_1" style="font-weight: normal;">Tidak ada keluhan</label><br/>
                      <input type="checkbox" id="pernapasan_2" name="fisik[pemeriksaanFisik][pernapasan][pilihan][sekret]" value="Sekret" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['sekret'] == 'Sekret' ? 'checked' : ''}}>
                      <label for="pernapasan_2" style="font-weight: normal;">Sekret (+)</label><br/>
                      <input type="checkbox" id="pernapasan_3" name="fisik[pemeriksaanFisik][pernapasan][pilihan][vesikular]" value="Vesikular" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['vesikular'] == 'Vesikular' ? 'checked' : ''}}>
                      <label for="pernapasan_3" style="font-weight: normal;">Vesikular</label><br/>
                      <input type="checkbox" id="pernapasan_4" name="fisik[pemeriksaanFisik][pernapasan][pilihan][ronchi]" value="Ronchi" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['ronchi'] == 'Ronchi' ? 'checked' : ''}}>
                      <label for="pernapasan_4" style="font-weight: normal;">Ronchi</label><br/>
                      <input type="checkbox" id="pernapasan_5" name="fisik[pemeriksaanFisik][pernapasan][pilihan][wheezing]" value="Wheezing" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['wheezing'] == 'Wheezing' ? 'checked' : ''}}>
                      <label for="pernapasan_5" style="font-weight: normal;">Wheezing</label><br/>
                      <input type="checkbox" id="pernapasan_6" name="fisik[pemeriksaanFisik][pernapasan][pilihan][otot_bantu]" value="Menggunakan Otot Bantu" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['otot_bantu'] == 'Menggunakan Otot Bantu' ? 'checked' : ''}}>
                      <label for="pernapasan_6" style="font-weight: normal;">Menggunakan Otot Bantu</label><br/>
                      <input type="checkbox" id="pernapasan_7" name="fisik[pemeriksaanFisik][pernapasan][pilihan][retraksi_dada]" value="Retraksi Dada" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['retraksi_dada'] == 'Retraksi Dada' ? 'checked' : ''}}>
                      <label for="pernapasan_7" style="font-weight: normal;">Retraksi Dada / Inter Costa</label><br/>
                      <input type="checkbox" id="pernapasan_8" name="fisik[pemeriksaanFisik][pernapasan][pilihan][pernapasan_dada]" value="Pernapasan Dada" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['pernapasan_dada'] == 'Pernapasan Dada' ? 'checked' : ''}}>
                      <label for="pernapasan_8" style="font-weight: normal;">Pernapasan Dada</label><br/>
                      <input type="checkbox" id="pernapasan_9" name="fisik[pemeriksaanFisik][pernapasan][pilihan][pernapasan_perut]" value="Pernapasan Perut" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['pernapasan_perut'] == 'Pernapasan Perut' ? 'checked' : ''}}>
                      <label for="pernapasan_9" style="font-weight: normal;">Pernapasan Perut</label><br/>
                      <input type="checkbox" id="pernapasan_10" name="fisik[pemeriksaanFisik][pernapasan][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['pernapasan']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="pernapasan_10" style="font-weight: normal;">Lain-Lain</label><br/>
                      <input type="text" id="pernapasan_11" name="fisik[pemeriksaanFisik][pernapasan][sebutkan]" style="display:inline-block;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['pernapasan']['sebutkan']}}">
                    </td>
                  </tr>
                </table>
              </div>
    
              <div class="col-md-6">
                <h5><b>Asesmen</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                    <td style="width:25%; font-weight:500;">Kardiovaskuler</td>
                    <td style="">
                      <input type="checkbox" id="kardiovaskuler_1" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][tidak_ada]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['tidak_ada'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="kardiovaskuler_2" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][oedema]" value="Oedema" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['oedema'] == 'Oedema' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_2" style="font-weight: normal; margin-right: 10px;">Oedema</label>
                      <input type="checkbox" id="kardiovaskuler_3" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][murmur]" value="Murmur" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['murmur'] == 'Murmur' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_3" style="font-weight: normal; margin-right: 10px;">Murmur</label><br/>
                      <input type="checkbox" id="kardiovaskuler_4" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][chest_pain]" value="Chest Pain" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['chest_pain'] == 'Chest Pain' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_4" style="font-weight: normal; margin-right: 10px;">Chest Pain</label>
                      <input type="checkbox" id="kardiovaskuler_5" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][reguler]" value="Reguler" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['reguler'] == 'Reguler' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_5" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                      <input type="checkbox" id="kardiovaskuler_6" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][ireguler]" value="Ireguler" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['ireguler'] == 'Ireguler' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_6" style="font-weight: normal; margin-right: 10px;">Ireguler</label><br/>
                      <input type="checkbox" id="kardiovaskuler_7" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][gallop]" value="Gallop" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['gallop'] == 'Gallop' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_7" style="font-weight: normal; margin-right: 10px;">Gallop</label>
                      <input type="checkbox" id="kardiovaskuler_8" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][crt_more_lower_2]" value="CRT < 2" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['crt_more_lower_2'] == 'CRT < 2' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_8" style="font-weight: normal; margin-right: 10px;">CRT < 2</label>
                      <input type="checkbox" id="kardiovaskuler_9" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][crt_more_higher_2]" value="CRT > 2" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['crt_more_higher_2'] == 'CRT > 2' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_9" style="font-weight: normal; margin-right: 10px;">CRT > 2</label><br/>
                      <input type="checkbox" id="kardiovaskuler_10" name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan][lainnya]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="kardiovaskuler_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="kardiovaskuler_11" name="fisik[pemeriksaanFisik][kardiovaskuler][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['kardiovaskuler']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Pencernaan</td>
                    <td style="">
                      <input type="checkbox" id="pencernaan_1" name="fisik[pemeriksaanFisik][pencernaan][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="pencernaan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="pencernaan_2" name="fisik[pemeriksaanFisik][pencernaan][pilihan][konstipasi]" value="Konstipasi" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['konstipasi'] == 'Konstipasi' ? 'checked' : '' }}>
                      <label for="pencernaan_2" style="font-weight: normal; margin-right: 10px;">Konstipasi</label>
                      <input type="checkbox" id="pencernaan_3" name="fisik[pemeriksaanFisik][pencernaan][pilihan][diare]" value="Diare" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['diare'] == 'Diare' ? 'checked' : '' }}>
                      <label for="pencernaan_3" style="font-weight: normal; margin-right: 10px;">Diare</label><br/>
                      <input type="checkbox" id="pencernaan_4" name="fisik[pemeriksaanFisik][pencernaan][pilihan][mual_muntah]" value="Mual / Muntah" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['mual_muntah'] == 'Mual / Muntah' ? 'checked' : '' }}>
                      <label for="pencernaan_4" style="font-weight: normal; margin-right: 10px;">Mual / Muntah</label>
                      <input type="checkbox" id="pencernaan_5" name="fisik[pemeriksaanFisik][pencernaan][pilihan][anoreksia]" value="Anoreksia" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['anoreksia'] == 'Anoreksia' ? 'checked' : '' }}>
                      <label for="pencernaan_5" style="font-weight: normal; margin-right: 10px;">Anoreksia</label><br/>
                      <input type="checkbox" id="pencernaan_6" name="fisik[pemeriksaanFisik][pencernaan][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="pencernaan_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="pencernaan_7" name="fisik[pemeriksaanFisik][pencernaan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['pencernaan']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Endokrin</td>
                    <td style="">
                      <input type="checkbox" id="endokrin_1" name="fisik[pemeriksaanFisik][endokrin][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="endokrin_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="endokrin_2" name="fisik[pemeriksaanFisik][endokrin][pilihan][pembesaran_kelenjar]" value="Pembesaran Kelenjar" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['pembesaran_kelenjar'] == 'Pembesaran Kelenjar' ? 'checked' : '' }}>
                      <label for="endokrin_2" style="font-weight: normal; margin-right: 10px;">Pembesaran Kelenjar</label><br/>
                      <input type="checkbox" id="endokrin_3" name="fisik[pemeriksaanFisik][endokrin][pilihan][tiroid]" value="Tiroid" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['tiroid'] == 'Tiroid' ? 'checked' : '' }}>
                      <label for="endokrin_3" style="font-weight: normal; margin-right: 10px;">Tiroid</label>
                      <input type="checkbox" id="endokrin_4" name="fisik[pemeriksaanFisik][endokrin][pilihan][keringat_banyak]" value="Keringat Banyak" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['keringat_banyak'] == 'Keringat Banyak' ? 'checked' : '' }}>
                      <label for="endokrin_4" style="font-weight: normal; margin-right: 10px;">Keringat Banyak</label><br/>
                      <input type="checkbox" id="endokrin_5" name="fisik[pemeriksaanFisik][endokrin][pilihan][napas_bau]" value="Napas Bau" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['napas_bau'] == 'Napas Bau' ? 'checked' : '' }}>
                      <label for="endokrin_5" style="font-weight: normal; margin-right: 10px;">Napas Bau</label>
                      <input type="checkbox" id="endokrin_6" name="fisik[pemeriksaanFisik][endokrin][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="endokrin_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="endokrin_7" name="fisik[pemeriksaanFisik][endokrin][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['endokrin']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Reproduksi</td>
                    <td style="">
                      <input type="checkbox" id="reproduksi_1" name="fisik[pemeriksaanFisik][reproduksi][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="reproduksi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="reproduksi_2" name="fisik[pemeriksaanFisik][reproduksi][pilihan][keputihan]" value="Keputihan" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['keputihan'] == 'Keputihan' ? 'checked' : '' }}>
                      <label for="reproduksi_2" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                      <input type="checkbox" id="reproduksi_3" name="fisik[pemeriksaanFisik][reproduksi][pilihan][haid_tidak_teratur]" value="Haid Tidak Teratur" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['haid_tidak_teratur'] == 'Haid Tidak Teratur' ? 'checked' : '' }}>
                      <label for="reproduksi_3" style="font-weight: normal; margin-right: 10px;">Haid Tidak Teratur</label>
                      <input type="checkbox" id="reproduksi_4" name="fisik[pemeriksaanFisik][reproduksi][pilihan][tidak_haid]" value="Tidak Haid" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['tidak_haid'] == 'Tidak Haid' ? 'checked' : '' }}>
                      <label for="reproduksi_4" style="font-weight: normal; margin-right: 10px;">Tidak Haid</label><br/>
                      <input type="checkbox" id="reproduksi_5" name="fisik[pemeriksaanFisik][reproduksi][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="reproduksi_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="reproduksi_6" name="fisik[pemeriksaanFisik][reproduksi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['reproduksi']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Abdomen</td>
                    <td style="">
                      <input type="checkbox" id="abdomen_1" name="fisik[pemeriksaanFisik][abdomen][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="abdomen_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="abdomen_2" name="fisik[pemeriksaanFisik][abdomen][pilihan][membesar]" value="Membesar" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['membesar'] == 'Membesar' ? 'checked' : '' }}>
                      <label for="abdomen_2" style="font-weight: normal; margin-right: 10px;">Membesar</label>
                      <input type="checkbox" id="abdomen_3" name="fisik[pemeriksaanFisik][abdomen][pilihan][distensi]" value="Distensi" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['distensi'] == 'Distensi' ? 'checked' : '' }}>
                      <label for="abdomen_3" style="font-weight: normal; margin-right: 10px;">Distensi</label><br/>
                      <input type="checkbox" id="abdomen_4" name="fisik[pemeriksaanFisik][abdomen][pilihan][nyeri_tekan]" value="Nyeri Tekan" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['nyeri_tekan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                      <label for="abdomen_4" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                      <input type="checkbox" id="abdomen_5" name="fisik[pemeriksaanFisik][abdomen][pilihan][luka]" value="Luka" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['luka'] == 'Luka' ? 'checked' : '' }}>
                      <label for="abdomen_5" style="font-weight: normal; margin-right: 10px;">Luka</label>
                      <input type="checkbox" id="abdomen_6" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_i]" value="L I" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_i'] == 'L I' ? 'checked' : '' }}>
                      <label for="abdomen_6" style="font-weight: normal; margin-right: 10px;">L I</label><br/>
                      <input type="checkbox" id="abdomen_7" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_ii]" value="L II" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_ii'] == 'L II' ? 'checked' : '' }}>
                      <label for="abdomen_7" style="font-weight: normal; margin-right: 10px;">L II</label>
                      <input type="checkbox" id="abdomen_8" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_iii]" value="L III" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_iii'] == 'L III' ? 'checked' : '' }}>
                      <label for="abdomen_8" style="font-weight: normal; margin-right: 10px;">L III</label>
                      <input type="checkbox" id="abdomen_9" name="fisik[pemeriksaanFisik][abdomen][pilihan][l_iv]" value="L IV" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['l_iv'] == 'L IV' ? 'checked' : '' }}>
                      <label for="abdomen_9" style="font-weight: normal; margin-right: 10px;">L IV</label><br/>
                      <input type="checkbox" id="abdomen_10" name="fisik[pemeriksaanFisik][abdomen][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="abdomen_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="abdomen_11" name="fisik[pemeriksaanFisik][abdomen][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['abdomen']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Kulit</td>
                    <td style="">
                      <input type="checkbox" id="kulit_1" name="fisik[pemeriksaanFisik][kulit][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="kulit_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="kulit_2" name="fisik[pemeriksaanFisik][kulit][pilihan][turgor_tidak_baik]" value="Turgor" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['turgor_tidak_baik'] == 'Turgor' ? 'checked' : '' }}>
                      <label for="kulit_2" style="font-weight: normal; margin-right: 10px;">Turgor Tidak Baik</label><br/>
                      <input type="checkbox" id="kulit_3" name="fisik[pemeriksaanFisik][kulit][pilihan][perubahan_warna]" value="Perubahan Warna" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['perubahan_warna'] == 'Perubahan Warna' ? 'checked' : '' }}>
                      <label for="kulit_3" style="font-weight: normal; margin-right: 10px;">Perubahan Warna</label>
                      <input type="checkbox" id="kulit_4" name="fisik[pemeriksaanFisik][kulit][pilihan][terdapat_lecet]" value="Terdapat Lecet" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['terdapat_lecet'] == 'Terdapat Lecet' ? 'checked' : '' }}>
                      <label for="kulit_4" style="font-weight: normal; margin-right: 10px;">Terdapat Lecet</label><br/>
                      <input type="checkbox" id="kulit_5" name="fisik[pemeriksaanFisik][kulit][pilihan][terdapat_luka]" value="Terdapat Luka" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['terdapat_luka'] == 'Terdapat Luka' ? 'checked' : '' }}>
                      <label for="kulit_5" style="font-weight: normal; margin-right: 10px;">Terdapat Luka</label><br/>
                      <input type="checkbox" id="kulit_6" name="fisik[pemeriksaanFisik][kulit][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="kulit_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="kulit_7" name="fisik[pemeriksaanFisik][kulit][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['kulit']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Mata</td>
                    <td style="">
                        <input type="checkbox" id="mata_1" name="fisik[pemeriksaanFisik][mata][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                        <label for="mata_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                        <input type="checkbox" id="mata_2" name="fisik[pemeriksaanFisik][mata][pilihan][kuning]" value="Kuning" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['kuning'] == 'Kuning' ? 'checked' : '' }}>
                        <label for="mata_2" style="font-weight: normal; margin-right: 10px;">Kuning</label>
                        <input type="checkbox" id="mata_3" name="fisik[pemeriksaanFisik][mata][pilihan][pucat]" value="Pucat" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['pucat'] == 'Pucat' ? 'checked' : '' }}>
                        <label for="mata_3" style="font-weight: normal; margin-right: 10px;">Pucat</label><br/>
                        <input type="checkbox" id="mata_4" name="fisik[pemeriksaanFisik][mata][pilihan][vod]" value="VOD" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['vod'] == 'VOD' ? 'checked' : '' }}>
                        <label for="mata_4" style="font-weight: normal; margin-right: 10px;">VOD (Visus Ocula Dektra)</label>
                        <input type="checkbox" id="mata_5" name="fisik[pemeriksaanFisik][mata][pilihan][vos]" value="VOS" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['vos'] == 'VOS' ? 'checked' : '' }}>
                        <label for="mata_5" style="font-weight: normal; margin-right: 10px;">VOS (Visus Okula Sinistra)</label><br/>
                        <input type="checkbox" id="mata_6" name="fisik[pemeriksaanFisik][mata][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['mata']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                        <label for="mata_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                        <input type="text" id="mata_7" name="fisik[pemeriksaanFisik][mata][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['mata']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Genetalia</td>
                    <td style="">
                      <input type="checkbox" id="genetalia_1" name="fisik[pemeriksaanFisik][genetalia][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="genetalia_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="genetalia_2" name="fisik[pemeriksaanFisik][genetalia][pilihan][nyeri_tekan]" value="Nyeri Tekan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['nyeri_tekan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                      <label for="genetalia_2" style="font-weight: normal; margin-right: 10px;">Nyeri Tekan</label>
                      <input type="checkbox" id="genetalia_3" name="fisik[pemeriksaanFisik][genetalia][pilihan][benjolan]" value="Benjolan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['benjolan'] == 'Benjolan' ? 'checked' : '' }}>
                      <label for="genetalia_3" style="font-weight: normal; margin-right: 10px;">Benjolan</label><br/>
                      <input type="checkbox" id="genetalia_4" name="fisik[pemeriksaanFisik][genetalia][pilihan][hipospsdia]" value="Hipospsdia" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['hipospsdia'] == 'Hipospsdia' ? 'checked' : '' }}>
                      <label for="genetalia_4" style="font-weight: normal; margin-right: 10px;">Hipospsdia</label>
                      <input type="checkbox" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan][epispadia]" value="Epispadia" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['epispadia'] == 'Epispadia' ? 'checked' : '' }}>
                      <label for="genetalia_5" style="font-weight: normal; margin-right: 10px;">Epispadia</label><br/>
                      <input type="checkbox" id="genetalia_5" name="fisik[pemeriksaanFisik][genetalia][pilihan][hidrochele]" value="Hidrochele" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['hidrochele'] == 'Hidrochele' ? 'checked' : '' }}>
                      <label for="genetalia_6" style="font-weight: normal; margin-right: 10px;">Hidrochele</label>
                      <input type="checkbox" id="genetalia_7" name="fisik[pemeriksaanFisik][genetalia][pilihan][lesi]" value="Lesi" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['lesi'] == 'Lesi' ? 'checked' : '' }}>
                      <label for="genetalia_7" style="font-weight: normal; margin-right: 10px;">Lesi</label><br/>
                      <input type="checkbox" id="genetalia_8" name="fisik[pemeriksaanFisik][genetalia][pilihan][eritema]" value="Eritema" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['eritema'] == 'Eritema' ? 'checked' : '' }}>
                      <label for="genetalia_8" style="font-weight: normal; margin-right: 10px;">Eritema</label>
                      <input type="checkbox" id="genetalia_9" name="fisik[pemeriksaanFisik][genetalia][pilihan][peradangan]" value="Peradangan" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['peradangan'] == 'Peradangan' ? 'checked' : '' }}>
                      <label for="genetalia_9" style="font-weight: normal; margin-right: 10px;">Peradangan</label><br/>
                      <input type="checkbox" id="genetalia_10" name="fisik[pemeriksaanFisik][genetalia][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="genetalia_10" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="genetalia_11" name="fisik[pemeriksaanFisik][genetalia][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['genetalia']['sebutkan'] }}">
                    </td>
                  
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Urinaria</td>
                    <td style="">
                      <input type="checkbox" id="urinaria_1" name="fisik[pemeriksaanFisik][urinaria][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="urinaria_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="urinaria_2" name="fisik[pemeriksaanFisik][urinaria][pilihan][warna]" value="Warna" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['warna'] == 'Warna' ? 'checked' : '' }}>
                      <label for="urinaria_2" style="font-weight: normal; margin-right: 10px;">Warna</label><br/>
                      <input type="checkbox" id="urinaria_3" name="fisik[pemeriksaanFisik][urinaria][pilihan][produksi]" value="Produksi" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['produksi'] == 'Produksi' ? 'checked' : '' }}>
                      <label for="urinaria_3" style="font-weight: normal; margin-right: 10px;">Produksi</label><br/>
                      <input type="checkbox" id="urinaria_4" name="fisik[pemeriksaanFisik][urinaria][pilihan][lainnya]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan']['lainnya'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="urinaria_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="urinaria_5" name="fisik[pemeriksaanFisik][urinaria][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['urinaria']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Gigi</td>
                    <td style="text-align: center">
                      <input type="radio" id="gigi_1" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="gigi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label><br>
                      <input type="radio" id="gigi_4" name="fisik[pemeriksaanFisik][gigi][pilihan]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="gigi_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="gigi_5" name="fisik[pemeriksaanFisik][gigi][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['gigi']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Ektremitas Atas</td>
                    <td style="">
                      <input type="checkbox" id="ektremitasAtas_1" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="ektremitasAtas_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="ektremitasAtas_2" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][gerakan_terbatas]" value="Gerakan Terbatas" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['gerakan_terbatas'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                      <label for="ektremitasAtas_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                      <input type="checkbox" id="ektremitasAtas_3" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][nyeri]" value="Nyeri" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['nyeri'] == 'Nyeri' ? 'checked' : '' }}>
                      <label for="ektremitasAtas_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                      <input type="checkbox" id="ektremitasAtas_4" name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="ektremitasAtas_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="ektremitasAtas_5" name="fisik[pemeriksaanFisik][ektremitasAtas][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Ektremitas Bawah</td>
                    <td style="">
                      <input type="checkbox" id="ektremitasBawah_1" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                      <label for="ektremitasBawah_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                  
                      <input type="checkbox" id="ektremitasBawah_2" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][gerakan_terbatas]" value="Gerakan Terbatas" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['gerakan_terbatas'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                      <label for="ektremitasBawah_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br/>
                  
                      <input type="checkbox" id="ektremitasBawah_3" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][nyeri]" value="Nyeri" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['nyeri'] == 'Nyeri' ? 'checked' : '' }}>
                      <label for="ektremitasBawah_3" style="font-weight: normal; margin-right: 10px;">Nyeri</label><br/>
                  
                      <input type="checkbox" id="ektremitasBawah_4" name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan][lain_lain]" value="Lain-Lain" {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : '' }}>
                      <label for="ektremitasBawah_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                  
                      <input type="text" id="ektremitasBawah_5" name="fisik[pemeriksaanFisik][ektremitasBawah][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['sebutkan'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Muka / Wajah</td>
                    <td style="">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap">
                            <div>
                                <input type="radio" id="muka_1" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                                <label for="muka_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                            </div>
                            <div>
                                <input type="radio" id="muka_2" name="fisik[pemeriksaanFisik][muka][pilihan]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Lain-Lain' ? 'checked' : ''}}>
                                <label for="muka_2" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                            </div>
                        </div>
                      <input type="text" id="muka_3" name="fisik[pemeriksaanFisik][muka][sebutkan]" style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['muka']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Telinga</td>
                    <td style="">
                      <input type="checkbox" id="telinga_1" name="fisik[pemeriksaanFisik][telinga][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="telinga_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="telinga_2" name="fisik[pemeriksaanFisik][telinga][pilihan][tidak_simetris]" value="Tidak Simetris" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['tidak_simetris'] == 'Tidak Simetris' ? 'checked' : ''}}>
                      <label for="telinga_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                      <input type="checkbox" id="telinga_3" name="fisik[pemeriksaanFisik][telinga][pilihan][cerumen]" value="Cerumen" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['cerumen'] == 'Cerumen' ? 'checked' : ''}}>
                      <label for="telinga_3" style="font-weight: normal; margin-right: 10px;">Cerumen</label><br/>
                      <input type="checkbox" id="telinga_4" name="fisik[pemeriksaanFisik][telinga][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['telinga']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="telinga_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="telinga_5" name="fisik[pemeriksaanFisik][telinga][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['telinga']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Hidung</td>
                    <td style="">
                      <input type="checkbox" id="hidung_1" name="fisik[pemeriksaanFisik][hidung][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="hidung_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="hidung_2" name="fisik[pemeriksaanFisik][hidung][pilihan][tidak_simetris]" value="Tidak Simetris" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['tidak_simetris'] == 'Tidak Simetris' ? 'checked' : ''}}>
                      <label for="hidung_2" style="font-weight: normal; margin-right: 10px;">Tidak Simetris</label><br/>
                      <input type="checkbox" id="hidung_3" name="fisik[pemeriksaanFisik][hidung][pilihan][sekret]" value="Sekret" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['sekret'] == 'Sekret' ? 'checked' : ''}}>
                      <label for="hidung_3" style="font-weight: normal; margin-right: 10px;">Sekfret</label>
                      <input type="checkbox" id="hidung_4" name="fisik[pemeriksaanFisik][hidung][pilihan][cuping]" value="Cuping" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['cuping'] == 'Cuping' ? 'checked' : ''}}>
                      <label for="hidung_4" style="font-weight: normal; margin-right: 10px;">Pernafasan Cuping Hidung</label><br/>
                      <input type="checkbox" id="hidung_5" name="fisik[pemeriksaanFisik][hidung][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['hidung']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="hidung_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="hidung_6" name="fisik[pemeriksaanFisik][hidung][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['hidung']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Tenggorokan</td>
                    <td style="">
                      <input type="checkbox" id="tenggorokan_1" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][tidak_ada_keluhan]" value="Tidak ada keluhan" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['tidak_ada_keluhan'] == 'Tidak ada keluhan' ? 'checked' : ''}}>
                      <label for="tenggorokan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada keluhan</label>
                      <input type="checkbox" id="tenggorokan_2" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][tonsil_ada_keluhan]" value="Tonsil Ada Keluhan" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['tonsil_ada_keluhan'] == 'Tonsil Ada Keluhan' ? 'checked' : ''}}>
                      <label for="tenggorokan_2" style="font-weight: normal; margin-right: 10px;">Tonsil Ada Keluhan</label><br/>
                      <input type="checkbox" id="tenggorokan_3" name="fisik[pemeriksaanFisik][tenggorokan][pilihan][lain_lain]" value="Lain-Lain" {{@$assesment['pemeriksaanFisik']['tenggorokan']['pilihan']['lain_lain'] == 'Lain-Lain' ? 'checked' : ''}}>
                      <label for="tenggorokan_3" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                      <input type="text" id="tenggorokan_4" name="fisik[pemeriksaanFisik][tenggorokan][sebutkan]" style="display:inline-block; width: 100px;" class="form-control" placeholder="Sebutkan" value="{{@$assesment['pemeriksaanFisik']['tenggorokan']['sebutkan']}}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Keadaan Emosional</td>
                    <td style="">
                      <input type="checkbox" id="keadaanEmosional_1" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Kooperatif" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'kooperatif' ? 'checked' : ''}}>
                      <label for="keadaanEmosional_1" style="font-weight: normal; margin-right: 10px;">Kooperatif</label>
                      <input type="checkbox" id="keadaanEmosional_2" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Butuh Pertolongan" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Butuh Pertolongan' ? 'checked' : ''}}>
                      <label for="keadaanEmosional_2" style="font-weight: normal; margin-right: 10px;">Butuh Pertolongan</label>
                      <input type="checkbox" id="keadaanEmosional_3" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Ingin Tahu" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Ingin Tahu' ? 'checked' : ''}}>
                      <label for="keadaanEmosional_3" style="font-weight: normal; margin-right: 10px;">Ingin Tahu</label>
                      <input type="checkbox" id="keadaanEmosional_4" name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Bingung" {{@$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Bingung' ? 'checked' : ''}}>
                      <label for="keadaanEmosional_4" style="font-weight: normal; margin-right: 10px;">Bingung</label>
                    </td>
                  </tr>
                  
                  <tr>
                    <td style="width:25%; font-weight:500;">Kebutuhan Edukasi dan Pengajaran</td>
                    <td style="">
                      <input type="checkbox" id="kebutuhanEdukasi_1" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][pasien]" value="Pasien" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['pasien'] == 'Pasien' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_1" style="font-weight: normal; margin-right: 10px;">Pasien</label>
                      <input type="checkbox" id="kebutuhanEdukasi_2" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][orang_tua]" value="Orang Tua" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['orang_tua'] == 'Orang Tua' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Orang Tua</label>
                      <input type="checkbox" id="kebutuhanEdukasi_3" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][anak]" value="Anak" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['anak'] == 'Anak' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Anak</label><br/>
                      <input type="checkbox" id="kebutuhanEdukasi_4" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][suami]" value="Suami" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['suami'] == 'Suami' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Suami</label>
                      <input type="checkbox" id="kebutuhanEdukasi_5" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][istri]" value="Istri" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['istri'] == 'Istri' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_5" style="font-weight: normal; margin-right: 10px;">Istri</label>
                      <input type="checkbox" id="kebutuhanEdukasi_6" name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan][keluarga_lainnya]" value="Keluarga Lainnya" {{@$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']['keluarga_lainnya'] == 'Keluarga Lainnya' ? 'checked' : ''}}>
                      <label for="kebutuhanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Keluarga Lainnya</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Bicara</td>
                    <td style="">
                      <input type="radio" id="bicara_1" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Normal" {{@$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Normal' ? 'checked' : ''}}>
                      <label for="bicara_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                      <input type="radio" id="bicara_2" name="fisik[pemeriksaanFisik][bicara][pilihan]" value="Gangguan Bicara" {{@$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Gangguan Bicara' ? 'checked' : ''}}>
                      <label for="bicara_2" style="font-weight: normal; margin-right: 10px;">Gangguan Bicara</label>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Bahasa Sehari-Hari</td>
                    <td style="">
                      <input type="checkbox" id="bahasa_1" name="fisik[pemeriksaanFisik][bahasa][pilihan][indonesia]" value="Indonesia" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['indonesia'] == 'Indonesia' ? 'checked' : ''}}>
                      <label for="bahasa_1" style="font-weight: normal; margin-right: 10px;">Indonesia</label>
                      <input type="checkbox" id="bahasa_2" name="fisik[pemeriksaanFisik][bahasa][pilihan][daerah]" value="Daerah" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['daerah'] == 'Daerah' ? 'checked' : ''}}>
                      <label for="bahasa_2" style="font-weight: normal; margin-right: 10px;">Daerah</label>
                      <input type="checkbox" id="bahasa_3" name="fisik[pemeriksaanFisik][bahasa][pilihan][inggris]" value="Inggris dan Lainnya" {{@$assesment['pemeriksaanFisik']['bahasa']['pilihan']['inggris'] == 'Inggris dan Lainnya' ? 'checked' : ''}}>
                      <label for="bahasa_3" style="font-weight: normal; margin-right: 10px;">Inggris dan Lainnya</label><br/>
                    </td>
                  </tr>    
                  
                  <tr>
                    <td style="width:25%; font-weight:500;">Perlu Penerjemah</td>
                    <td style="">
                      <input type="radio" id="penerjemah_1" name="fisik[pemeriksaanFisik][penerjemah][pilihan]" value="Perlu Penerjemah" {{@$assesment['pemeriksaanFisik']['penerjemah']['pilihan'] == 'Perlu Penerjemah' ? 'checked' : ''}}>
                      <label for="penerjemah_1" style="font-weight: normal; margin-right: 10px;">Perlu Penerjemah</label>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Hambatan Edukasi</td>
                    <td style="">
                      <input type="checkbox" id="hambatanEdukasi_1" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][bahasa]" value="Bahasa" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['bahasa'] == 'Bahasa' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_1" style="font-weight: normal; margin-right: 10px;">Bahasa</label>
                      <input type="checkbox" id="hambatanEdukasi_2" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][pendengaran]" value="Pendengaran" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['pendengaran'] == 'Pendengaran' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Pendengaran</label>
                      <input type="checkbox" id="hambatanEdukasi_3" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][hilang_memori]" value="Hilang Memori" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['hilang_memori'] == 'Hilang Memori' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Hilang Memori</label><br/>
                      <input type="checkbox" id="hambatanEdukasi_4" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][motivasi_buruk]" value="Motivasi Buruk" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['motivasi_buruk'] == 'Motivasi Buruk' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Motivasi Buruk</label>
                      <input type="checkbox" id="hambatanEdukasi_5" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][cemas]" value="Cemas" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['cemas'] == 'Cemas' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_5" style="font-weight: normal; margin-right: 10px;">Cemas</label><br/>
                      <input type="checkbox" id="hambatanEdukasi_6" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][masalah_penglihatan]" value="Masalah Penglihatan" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['masalah_penglihatan'] == 'Masalah Penglihatan' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Masalah Penglihatan</label>
                      <input type="checkbox" id="hambatanEdukasi_7" name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan][tidak_ditemukan_hambatan]" value="Tidak ditemukan Hambatan" {{@$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan']['tidak_ditemukan_hambatan'] == 'Tidak ditemukan Hambatan' ? 'checked' : ''}}>
                      <label for="hambatanEdukasi_7" style="font-weight: normal; margin-right: 10px;">Tidak ditemukan Hambatan</label>
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:25%; font-weight:500;">Edukasi yang diberikan</td>
                    <td style="">
                      <input type="checkbox" id="edukasi_1" name="fisik[pemeriksaanFisik][edukasi][pilihan][proses_penyakit]" value="Proses Penyakit" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['proses_penyakit'] == 'Proses Penyakit' ? 'checked' : ''}}>
                      <label for="edukasi_1" style="font-weight: normal; margin-right: 10px;">Proses Penyakit</label>
                      <input type="checkbox" id="edukasi_2" name="fisik[pemeriksaanFisik][edukasi][pilihan][pengobatan]" value="Pengobatan" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['pengobatan'] == 'Pengobatan' ? 'checked' : ''}}>
                      <label for="edukasi_2" style="font-weight: normal; margin-right: 10px;">Pengobatan</label>
                      <input type="checkbox" id="edukasi_3" name="fisik[pemeriksaanFisik][edukasi][pilihan][nutrisi]" value="Nutrisi" {{@$assesment['pemeriksaanFisik']['edukasi']['pilihan']['nutrisi'] == 'Nutrisi' ? 'checked' : ''}}>
                      <label for="edukasi_3" style="font-weight: normal; margin-right: 10px;">Nutrisi</label><br/>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Status Gizi</td>
                    <td>
                      <input type="text" id="statusGizi" name="fisik[pemeriksaanFisik][statusGizi]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['statusGizi']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Status Pediatrik</td>
                    <td>
                      <input type="text" id="statusPediatrik" name="fisik[pemeriksaanFisik][statusPediatrik]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['statusPediatrik']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Riwayat Imunisasi</td>
                    <td>
                      <input type="text" id="riwayatImunisasi" name="fisik[pemeriksaanFisik][riwayatImunisasi]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['riwayatImunisasi']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Riwayat Tumbuh Kembang</td>
                    <td>
                      <input type="text" id="riwayatTumbuh" name="fisik[pemeriksaanFisik][riwayatTumbuh]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['riwayatTumbuh']}}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:25%; font-weight:500;">Riwayat Penyakit Keluarga</td>
                    <td>
                      <input type="text" id="riwayatPenyakitKeluarga" name="fisik[pemeriksaanFisik][riwayatPenyakitKeluarga]" style="display:inline-block;" class="form-control" placeholder="" value="{{@$assesment['pemeriksaanFisik']['riwayatPenyakitKeluarga']}}">
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
                      <input type="text" id="waktuKontrol4" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <button type="button" id="listKontrol4" data-dokterID="{{ $reg->dokter_id }}"
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
                      <input type="checkbox" id="dischargePlanning_dirujuk4" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                      <label for="dischargePlanning_dirujuk4" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                    </td>
                    <td>
                      <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['dirujuk']['waktu']}}">
                    </td>
                  </tr>
                  <tr id="rujukan4" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Faskes Rujukan
                    </td>
                    <td>
                        <select id="faskes4" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            <option value="RS Kab. Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                            <option value="RS Kota Bandung" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                            <option value="RS Provinsi" {{@$assesment['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                        </select>
                    </td>
                  </tr>
                  <tr id="rs_rujukan4" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Rumah Sakit Rujukan
                    </td>
                    <td>
                        <select id="faskes_rs_rujukan4" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                            <option value="" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                            @foreach ($faskesRujukanRs as $rs)
                                <option value="{{$rs->id}}" {{@$assesment['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                            @endforeach
                        </select>
                    </td>
                  </tr>
                  <tr id="alasan_rujukan4" @if(@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                    <td  style="width:40%; font-weight:bold;">
                        Alasan
                    </td>
                    <td>
                        <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesment['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
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
                <div style="text-align: right;">
                  <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
                  <button class="btn btn-success">Simpan</button>
                </div>
                
                </form>
    
              </div>
            @endif
            <div class="col-md-12" style="margin-top: 10px;">
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
                              {{Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                          </td>
                        
                          <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                              @if (substr(@$riwayat->registrasi->status_reg, 0, 1) == 'J')
                                @if (in_array(@$riwayat->registrasi->poli_id, ['3', '34', '4']))
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif (@$riwayat->registrasi->poli_id == '15')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif (@$riwayat->registrasi->poli_id == '27')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @elseif (@$riwayat->registrasi->poli_id == '41')
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol-paru/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @else
                                  <a href="{{ url("cetak-resume-medis-rencana-kontrol/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-print"></i>
                                  </a>
                                @endif
                              @else
                              -
                              @endif
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

            <div class="col-md-12">
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4>
                      @if (@$reg->poli_id == '20')
                      <a href="#askepCollapse" data-toggle="collapse">Fisioterapi</a>
                      @else
                      <a href="#askepCollapse" data-toggle="collapse">Asuhan Keperawatan</a>
                      @endif
                    </h4>
                  </div>
                  <div id="askepCollapse" class="panel-collapse collapse">
                    <div class="panel-body">
                      @if (substr($reg->status_reg, 0, 1) == 'J')
                        <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                          {{ csrf_field() }}
                          {!! Form::hidden('registrasi_id', $reg->id) !!}
                          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                          {!! Form::hidden('unit', $unit) !!}
                          <br>
                          @if (@$reg->poli_id == '20')
                          <h4 style="text-align: center"><b>Fisioterapi</b></h4>
                          @else
                          <h4 style="text-align: center"><b>Asuhan Keperawatan</b></h4>
                          @endif

                          @include('emr.modules.pemeriksaan.select-askep')

                          <div style="text-align: right;">
                            <button class="btn btn-success">Simpan Askep</button>
                          </div>
                        </form>

                        @include('emr.modules.pemeriksaan.modal-tte-askep')

                      @elseif(substr($reg->status_reg, 0, 1) == 'I')
                        <h5><b>Diagnosa Keperawatan</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                          
                          <tr>
                            <td>
                              @if (@$diagnosis != null)
                                @foreach (@$diagnosis as $diagnosa)
                                - {{ $diagnosa }} <br>
                                @endforeach
                              @else
                                <i>Belum Ada Yang Dipilih</i>
                              @endif
                            </td>
                          </tr>
                        </table>
            
                        <h5><b>Intervensi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                          <tr>
                            <td>
                              @if (@$siki != null)
                                @foreach (@$siki as $siki)
                                * {{ $siki }} <br>
                                @endforeach
                              @else
                                <i>Belum Ada Yang Dipilih</i>
                              @endif
                            </td>
                          </tr>
                        </table>
            
                        <h5><b>Implementasi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                          style="font-size:12px;">
                          <tr>
                            <td>
                              @if (@$implementasi != null)
                                @foreach (@$implementasi as $i)
                                * {{ $i }} <br>
                                @endforeach
                              @else
                                <i>Belum Ada Yang Dipilih</i>
                              @endif
                            </td>
                          </tr>
                        </table>
                      @else

                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
          @endif
          <br /><br />
        </div>
      </div>
      
    {{-- </form> --}}

    @if (@$dataPegawai == '1')
    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
      <h5><b>8. TINDAKAN</b></h5>
      <tr>
          <td style="padding: 5px;">
            {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('poli_id', $reg->poli_id) !!}
            {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
            {!! Form::hidden('pelaksana', $reg->dokter_id) !!}
            {!! Form::hidden('tanggal', Carbon\Carbon::now()->format('d-m-Y')) !!}
            {!! Form::hidden('jumlah', 1) !!}
            <select name="tarif_id[]" id="select2Multiple" class="form-control" multiple="multiple"></select>
            <small class="text-danger">{{ $errors->first('tarif_id') }}</small> 
            <div class="form-group" style="margin-top: 10px;">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::submit("Simpan Tindakan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
              </div>
            </div> 
            {!! Form::close() !!}
          </td>
      </tr>
    </table>
    @endif

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
  $('.dates').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        // $(".date_tanpa_tanggal").datepicker( {
        //     format: "dd/mm/yyyy",
        //     autoclose: true
        //     // viewMode: "months", 
        //     // minViewMode: "months"
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
            autoclose: true
        });
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>
   <script>
    function diberikan() {
      var checkBox = document.getElementById("edukasiDiberikan");
      var text = document.getElementById("edukasiDiberikanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicara() {
      var checkBox = document.getElementById("bicaraId");
      var text = document.getElementById("bicaraText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicaraSeharihari() {
      var checkBox = document.getElementById("bicaraSeharihariId");
      var text = document.getElementById("bicaraSeharihariText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function alergi() {
      var checkBox = document.getElementById("alergiId");
      var text = document.getElementById("alergiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
  <script>
    var reg_id = '{{ $reg->id }}';
    let instance = 'asesmen_'+reg_id;
    let draftCppt = localStorage.getItem(instance);
    let element = [
      $('textarea[name="fisik[anamnesa]"]'),
      $('textarea[name="fisik[pemeriksaan_fisik]"]'),
      $('input[name="fisik[status_pediatri][status_gizi]"]'),
      $('input[name="fisik[status_pediatri][riwayat_imunisasi]"]'),
      $('input[name="fisik[status_pediatri][riwayat_tumbuh_kembang]"]'),
      $('textarea[name="fisik[diagnosis]"]'),
      $('textarea[name="fisik[diagnosistambahan]"]'),
      $('textarea[name="fisik[planning]"]'),
    ];

    handleDraft(element);

    function handleDraft(element) {
      element.forEach(function (e) {
        let key = e.attr("name");
        if (draftCppt) {
          let dataDraft = JSON.parse(draftCppt);
          if (dataDraft[key]) {
            e.val(dataDraft[key])
          }
        }

        e.on('change', function () {
          storeDraft(instance, key, e.val())
        });
      })
    }

    function storeDraft(instance, key, val) {
        try {
            let storage = localStorage.getItem(instance);
            let data;
            if (storage) {
                data = JSON.parse(storage);
            } else {
                data = {};
            }
            data[key] = val;
            localStorage.setItem(instance, JSON.stringify(data));
        } catch (error) {
            console.error('Gagal menyimpan draft:', error.message);
        }
    }

    function destroyDraft(instance) {
      localStorage.removeItem(instance);
    }

    // Hapus draft ketika submit
    $('.cppt-form').submit(function (e) {
      e.preventDefault();
      // Manual validasi
      let kontrol = $('input[name="fisik[dischargePlanning][kontrol][dipilih]"]').is(":checked")
      let kontrolPrb = $('input[name="fisik[dischargePlanning][kontrolPRB][dipilih]"]').is(":checked")
      let dirawat = $('input[name="fisik[dischargePlanning][dirawat][dipilih]"]').is(":checked")
      let dirujuk = $('input[name="fisik[dischargePlanning][dirujuk][dipilih]"]').is(":checked")
      let konsultasi = $('input[name="fisik[dischargePlanning][Konsultasi][dipilih]"]').is(":checked")
      let pulpak = $('input[name="fisik[dischargePlanning][pulpak][dipilih]"]').is(":checked")
      let meninggal = $('input[name="fisik[dischargePlanning][meninggal][dipilih]"]').is(":checked")

      if (!kontrol && !kontrolPrb && !dirawat && !dirujuk && !konsultasi && !pulpak && !meninggal) {
        alert('Discharge Planning wajib diisi')
      } else {
        destroyDraft(instance)
        $('.cppt-form')[0].submit();
      }
    })
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

  $('.hitungResiko').on('change', function (){
    var total = 0 ;
    var hasil = $('.hasilSkorResiko');
    $('.hitungResiko:checked').each(function (){
      total += parseInt($(this).val());
    });

    $('.jumlahSkorResiko').val(total);

    if(total <= 24){
      hasil.val('Tidak Berisiko');
    }else if(total <= 50){
      hasil.val('Risiko Rendah');
    }else if(total >50){
      hasil.val('Risiko Tinggi');
    }
  });

  $('#historiAskep').click( function(e) {
      var id = $(this).attr('data-pasienID');
      $('#showHistoriAskep').modal('show');
      $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
  });
</script>
<script>
  function countSkor(){
      var arr = document.getElementsByClassName('skorResikoJatuh');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalSkorId').value = tot;
    }
  
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

    $('#select2-diagnosis').change(function(e){
      var intervensi = $('#select2-pemeriksaanDalam');
      var implementasi = $('#select2-fungsional');
      var diagnosa = $(this).val();

      intervensi.empty();
      implementasi.empty();

      $.ajax({
        url: '/emr-get-askep?namaDiagnosa='+diagnosa,
        type: 'get',
        dataType: 'json',
      })
      .done(function(res) {
        if(res[0].metadata.code == 200){
          $.each(res[1], function(index, val){
            intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
          })
          $.each(res[2], function(index, val){
            implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
          })
        }
      })

    });

    $(document).on('click', '#listKontrol1', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol1').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });

    $(document).on('click', '#listKontrol2', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol2').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });

    $(document).on('click', '#listKontrol3', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol3').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });

    $(document).on('click', '#listKontrol4', function(e) {
      var id = $(this).attr('data-dokterID');
      var tgl = $('#waktuKontrol4').val();
      
      if(tgl == null || tgl == ''){
        alert('Harap Isi Tanggal Kontrol');
      }else{
        $('#showListKontrol').modal('show');
        $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
      }
    });
</script>

<script>
$(document).ready(function() {
  //Dirujuk 
  $('#dischargePlanning_dirujuk1').on('change', function(){
      if ($(this).is(':checked')) { 
        $('#rujukan').css('display', 'table-row');
        $('#rs_rujukan').css('display', 'table-row');
        $('#alasan_rujukan').css('display', 'table-row');

        $('#faskes').trigger('change');

      } else {
        $('#rujukan').css('display', 'none');
        $('#rs_rujukan').css('display', 'none');
        $('#alasan_rujukan').css('display', 'none');
      }
  });
  $('#faskes').on('change', function(){
      var selectedValue = $(this).val();
      console.log(selectedValue);
      if(selectedValue != ''){
          $('#faskes_rs_rujukan').val('');

          $('#faskes_rs_rujukan').select2({
              placeholder: "Pilh Faskes RS Rujukan",
              width: '100%',
              ajax: {
                  url: '/emr-soap/ajax-faskes-rs',
                  dataType: 'json',
                  data: function (params) {
                      return {
                          jenis_faskes: selectedValue
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
          
      }
  });

  //Dirujuk 
  $('#dischargePlanning_dirujuk2').on('change', function(){
        if ($(this).is(':checked')) { 
          $('#rujukan2').css('display', 'table-row');
          $('#rs_rujukan2').css('display', 'table-row');
          $('#alasan_rujukan2').css('display', 'table-row');

          $('#faskes2').trigger('change');

        } else {
          $('#rujukan2').css('display', 'none');
          $('#rs_rujukan2').css('display', 'none');
          $('#alasan_rujukan2').css('display', 'none');
        }
    });
    $('#faskes2').on('change', function(){
        var selectedValue = $(this).val();
        console.log(selectedValue);
        if(selectedValue != ''){
            $('#faskes_rs_rujukan2').val('');

            $('#faskes_rs_rujukan2').select2({
                placeholder: "Pilh Faskes RS Rujukan",
                width: '100%',
                ajax: {
                    url: '/emr-soap/ajax-faskes-rs',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            jenis_faskes: selectedValue
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
            
        }
    });

    //Dirujuk 
    $('#dischargePlanning_dirujuk3').on('change', function(){
      if ($(this).is(':checked')) { 
        $('#rujukan3').css('display', 'table-row');
        $('#rs_rujukan3').css('display', 'table-row');
        $('#alasan_rujukan3').css('display', 'table-row');

        $('#faskes3').trigger('change');

      } else {
        $('#rujukan3').css('display', 'none');
        $('#rs_rujukan3').css('display', 'none');
        $('#alasan_rujukan3').css('display', 'none');
      }
  });
  $('#faskes3').on('change', function(){
      var selectedValue = $(this).val();
      console.log(selectedValue);
      if(selectedValue != ''){
          $('#faskes_rs_rujukan3').val('');

          $('#faskes_rs_rujukan3').select2({
              placeholder: "Pilh Faskes RS Rujukan",
              width: '100%',
              ajax: {
                  url: '/emr-soap/ajax-faskes-rs',
                  dataType: 'json',
                  data: function (params) {
                      return {
                          jenis_faskes: selectedValue
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
          
      }
  });

  //Dirujuk 
  $('#dischargePlanning_dirujuk4').on('change', function(){
    if ($(this).is(':checked')) { 
      $('#rujukan4').css('display', 'table-row');
      $('#rs_rujukan4').css('display', 'table-row');
      $('#alasan_rujukan4').css('display', 'table-row');

      $('#faskes4').trigger('change');

    } else {
      $('#rujukan4').css('display', 'none');
      $('#rs_rujukan4').css('display', 'none');
      $('#alasan_rujukan4').css('display', 'none');
    }
  });
  $('#faskes4').on('change', function(){
    var selectedValue = $(this).val();
    console.log(selectedValue);
    if(selectedValue != ''){
        $('#faskes_rs_rujukan4').val('');

        $('#faskes_rs_rujukan4').select2({
            placeholder: "Pilh Faskes RS Rujukan",
            width: '100%',
            ajax: {
                url: '/emr-soap/ajax-faskes-rs',
                dataType: 'json',
                data: function (params) {
                    return {
                        jenis_faskes: selectedValue
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
        
    }
  });


});
</script>
  
@endsection