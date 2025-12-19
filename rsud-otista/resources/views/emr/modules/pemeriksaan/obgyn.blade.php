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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/obgyn/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[anamnesa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Anamnesa]" class="form-control" >{{ @$assesment['anamnesa'] ?? @$assesment['keluhanUtama'] }}</textarea>
                    @if($errors->has('fisik.anamnesa'))
                        <div class="error text-danger">{{ $errors->first('fisik.anamnesa') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>2. PEMERIKSAAN FISIK</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] ?? "Tekanan darah : " . (@$assesment['tanda_vital']['tekanan_darah'] ?? "") . ", Nadi : " . (@$assesment['tanda_vital']['nadi'] ?? "") . ", RR : " . (@$assesment['tanda_vital']['RR'] ?? "") . ", Suhu : " . (@$assesment['tanda_vital']['temp'] ?? "") . ", Berat Badan : " . (@$assesment['tanda_vital']['BB'] ?? "") . ", Tinggi Badan : " . (@$assesment['tanda_vital']['TB'] ?? "") }}</textarea>
                    @if($errors->has('fisik.pemeriksaan_fisik'))
                        <div class="error text-danger">{{ $errors->first('fisik.pemeriksaan_fisik') }}</div>
                    @endif
                  </td>
              </tr>
            </table>

            {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>3. STATUS PEDIATRI (diisi bila perlu)</b></h5>
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
            </table> --}}

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <h5>
                <b>4. STATUS LOKALIS</b>
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
            </table>
          </div>
          <div class="col-md-6">
            <h5><b>Asesmen</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>5. DIAGNOSIS</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[diagnosis]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis]" class="form-control" >{{ @$assesment['diagnosis'] }}</textarea>
                    @if($errors->has('fisik.diagnosis'))
                        <div class="error text-danger">{{ $errors->first('fisik.diagnosis') }}</div>
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
              <h5><b>6. PLANNING</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <textarea rows="3" required name="fisik[planning]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Planning]" class="form-control" >{{ @$assesment['planning'] }}</textarea>
                    @if($errors->has('fisik.planning'))
                        <div class="error text-danger">{{ $errors->first('fisik.planning') }}</div>
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

            {{-- {{ dd(json_decode(@$riwayat->fisik,true)['anamnesa']) }} --}}
            
          </div>

          @else
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
                  <td style="width:50%; font-weight:bold;">1. Keadaan Umum</td>
                  <td>
                    <input type="checkbox" id="keadaanUmum_1" name="fisik[nyeri][keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                    <label for="keadaanUmum_1" style="font-weight: normal; margin-right: 10px;">Tampak Tidak Sakit</label>
                    <input type="checkbox" id="keadaanUmum_2" name="fisik[nyeri][keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                    <label for="keadaanUmum_2" style="font-weight: normal; margin-right: 10px;">Sakit Ringan</label><br/>
                    <input type="checkbox" id="keadaanUmum_3" name="fisik[nyeri][keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                    <label for="keadaanUmum_3" style="font-weight: normal; margin-right: 10px;">Sakit Sedang</label>
                    <input type="checkbox" id="keadaanUmum_4" name="fisik[nyeri][keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$assesment['nyeri']['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                    <label for="keadaanUmum_4" style="font-weight: normal; margin-right: 10px;">Sakit Berat</label>
                  </td>
                </tr>

                <tr>
                  <td style="width:50%; font-weight:bold;">2. Kesadaran</td>
                  <td>
                    <input type="checkbox" id="kesadaran_1" name="fisik[nyeri][kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$assesment['nyeri']['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                    <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Compos Mentis</label>
                    <input type="checkbox" id="kesadaran_2" name="fisik[nyeri][kesadaran][pilihan][apatis]" value="Apatis" {{ @$assesment['nyeri']['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                    <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Apatis</label><br/>
                    <input type="checkbox" id="kesadaran_3" name="fisik[nyeri][kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$assesment['nyeri']['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                    <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Somnolen</label>
                    <input type="checkbox" id="kesadaran_4" name="fisik[nyeri][kesadaran][pilihan][sopor]" value="Sopor" {{ @$assesment['nyeri']['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                    <label for="kesadaran_4" style="font-weight: normal; margin-right: 10px;">Sopor</label><br/>
                    <input type="checkbox" id="kesadaran_5" name="fisik[nyeri][kesadaran][pilihan][coma]" value="Coma" {{ @$assesment['nyeri']['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                    <label for="kesadaran_5" style="font-weight: normal; margin-right: 10px;">Coma</label>
                  </td>
                </tr>

                <tr>
                  <td rowspan="4" style="width:25%; font-weight:bold;">3. GCS</td>
                  <td style="padding: 5px;">
                    <label class="form-check-label " style="margin-right: 20px;">E</label>
                    <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="{{ @$assesment['GCS']['E'] }}">
                  </td>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label "   style="margin-right: 20px;">M</label>
                      <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="{{ @$assesment['GCS']['M'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                    <label class="form-check-label "  style="margin-right: 20px;">V</label>
                        <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="{{ @$assesment['GCS']['V'] }}">
                    </td>
                  </tr>
                  <tr>
                      <td style="padding: 5px;">
                          <label class="form-check-label "  style="margin-right: 20px;">Total</label>
                          <input type="text" name="fisik[GCS][total]" style="display:inline-block; width: 100px;" placeholder="Total" class="form-control" id="gcsScore" readonly value="{{ @$assesment['GCS']['total'] }}">
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
                    <input type="text" name="fisik[tanda_vital][tekanan_darah]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['tekanan_darah'] }}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['nadi'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                    <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['RR'] }}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                    <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['temp'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                    <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['BB'] }}">
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                    <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{ @$assesment['tanda_vital']['TB'] }}">
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
                    <input type="radio" id="cloasma_1" name="fisik[pemeriksaanFisik][muka][cloasma]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['muka']['cloasma'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="cloasma_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="cloasma_2" name="fisik[pemeriksaanFisik][muka][cloasma]" value="Ada" {{ @$assesment['pemeriksaanFisik']['muka']['cloasma'] == 'Ya' ? 'checked' : '' }}>
                    <label for="cloasma_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Mata</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Konjungtiva</td>
                  <td>
                    <input type="radio" id="konjungtiva_1" name="fisik[pemeriksaanFisik][mata][konjungtiva]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['mata']['konjungtiva'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="konjungtiva_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="konjungtiva_2" name="fisik[pemeriksaanFisik][mata][konjungtiva]" value="Anemis" {{ @$assesment['pemeriksaanFisik']['mata']['konjungtiva'] == 'Anemis' ? 'checked' : '' }}>
                    <label for="konjungtiva_2" style="font-weight: normal; margin-right: 10px;">Anemis</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Leher</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Kelenjar Tiroid Pembesaran</td>
                  <td>
                    <input type="radio" id="tiroid_1" name="fisik[pemeriksaanFisik][leher][tiroid]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['leher']['tiroid'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="tiroid_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="tiroid_2" name="fisik[pemeriksaanFisik][leher][tiroid]" value="Ada" {{ @$assesment['pemeriksaanFisik']['leher']['tiroid'] == 'Ada' ? 'checked' : '' }}>
                    <label for="tiroid_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Vena Jugularis Peningkatan</td>
                  <td>
                    <input type="radio" id="vena_1" name="fisik[pemeriksaanFisik][leher][vena]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['leher']['vena'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="vena_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="vena_2" name="fisik[pemeriksaanFisik][leher][vena]" value="Ada" {{ @$assesment['pemeriksaanFisik']['leher']['vena'] == 'Ya' ? 'checked' : '' }}>
                    <label for="vena_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">KGB Pembesaran</td>
                  <td>
                    <input type="radio" id="kgb_1" name="fisik[pemeriksaanFisik][leher][kgb]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['leher']['kgb'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kgb_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="kgb_2" name="fisik[pemeriksaanFisik][leher][kgb]" value="Ada" {{ @$assesment['pemeriksaanFisik']['leher']['kgb'] == 'Ada' ? 'checked' : '' }}>
                    <label for="kgb_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Dada</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Payudara</td>
                  <td>
                    <input type="radio" id="payudara_1" name="fisik[pemeriksaanFisik][dada][payudara]" value="Simetris" {{ @$assesment['pemeriksaanFisik']['dada']['payudara'] == 'Simetris' ? 'checked' : '' }}>
                    <label for="payudara_1" style="font-weight: normal; margin-right: 10px;">Simetris</label>
                    <input type="radio" id="payudara_2" name="fisik[pemeriksaanFisik][dada][payudara]" value="Asimetris" {{ @$assesment['pemeriksaanFisik']['dada']['payudara'] == 'Asimetris' ? 'checked' : '' }}>
                    <label for="payudara_2" style="font-weight: normal; margin-right: 10px;">Asimetris</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Puting Susu Menonjol</td>
                  <td>
                    <input type="radio" id="putingMenonjol_1" name="fisik[pemeriksaanFisik][dada][putingMenonjol]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['dada']['putingMenonjol'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="putingMenonjol_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="putingMenonjol_2" name="fisik[pemeriksaanFisik][dada][putingMenonjol]" value="Ya" {{ @$assesment['pemeriksaanFisik']['dada']['putingMenonjol'] == 'Ya' ? 'checked' : '' }}>
                    <label for="putingMenonjol_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Kolostrum</td>
                  <td>
                    <input type="radio" id="kolostrum_1" name="fisik[pemeriksaanFisik][dada][kolostrum]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['dada']['kolostrum'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kolostrum_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="kolostrum_2" name="fisik[pemeriksaanFisik][dada][kolostrum]" value="Ada" {{ @$assesment['pemeriksaanFisik']['dada']['kolostrum'] == 'Ada' ? 'checked' : '' }}>
                    <label for="kolostrum_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Masa / Benjolan</td>
                  <td>
                    <input type="radio" id="benjolan_1" name="fisik[pemeriksaanFisik][dada][benjolan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['dada']['benjolan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="benjolan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="benjolan_2" name="fisik[pemeriksaanFisik][dada][benjolan]" value="Ada" {{ @$assesment['pemeriksaanFisik']['dada']['benjolan'] == 'Ada' ? 'checked' : '' }}>
                    <label for="benjolan_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Retraksi</td>
                  <td>
                    <input type="radio" id="retraksi_1" name="fisik[pemeriksaanFisik][dada][retraksi]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['dada']['retraksi'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="retraksi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="retraksi_2" name="fisik[pemeriksaanFisik][dada][retraksi]" value="Ada" {{ @$assesment['pemeriksaanFisik']['dada']['retraksi'] == 'Ada' ? 'checked' : '' }}>
                    <label for="retraksi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Abdomen</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Striae Gravidarum</td>
                  <td>
                    <input type="radio" id="striae_1" name="fisik[pemeriksaanFisik][abdomen][striae]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['abdomen']['striae'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="striae_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="striae_2" name="fisik[pemeriksaanFisik][abdomen][striae]" value="Ya" {{ @$assesment['pemeriksaanFisik']['abdomen']['striae'] == 'Ya' ? 'checked' : '' }}>
                    <label for="striae_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Bekas Luka Operasi</td>
                  <td>
                    <input type="radio" id="bekasLukaOperasi_1" name="fisik[pemeriksaanFisik][abdomen][bekasLukaOperasi]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['abdomen']['bekasLukaOperasi'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="bekasLukaOperasi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="bekasLukaOperasi_2" name="fisik[pemeriksaanFisik][abdomen][bekasLukaOperasi]" value="Ada" {{ @$assesment['pemeriksaanFisik']['abdomen']['bekasLukaOperasi'] == 'Ada' ? 'checked' : '' }}>
                    <label for="bekasLukaOperasi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">TFU (Cm)</td>
                  <td>
                    <input type="number" name="fisik[pemeriksaanFisik][tfu]" class="form-control" style="display: inline-block;" id="" placeholder="Cm" value="{{ @$assesment['pemeriksaanFisik']['tfu'] }}">
                  </td>
                </tr>

                <tr>
                  <td style="width:50%; font-weight:500;">Palpasi</td>
                  <td style="font-weight:500; width: 50%;">
                    <span style="margin-right: 20px;">Leopold I</span>
                    <input type="text" name="fisik[pemeriksaanFisik][palpasi][LI]" class="form-control" style="display: inline-block; width: 100px;" id="" value="{{ @$assesment['pemeriksaanFisik']['palpasi']['LI'] }}"><br/><br/>
                    <span style="margin-right: 15px;">Leopold II</span>
                    <input type="text" name="fisik[pemeriksaanFisik][palpasi][LII]" class="form-control" style="display: inline-block; width: 100px;" id="" value="{{ @$assesment['pemeriksaanFisik']['palpasi']['LII'] }}"><br/><br/>
                    <span style="margin-right: 10px;">Leopold III</span>
                    <input type="text" name="fisik[pemeriksaanFisik][palpasi][LIII]" class="form-control" style="display: inline-block; width: 100px;" id="" value="{{ @$assesment['pemeriksaanFisik']['palpasi']['LIII'] }}"><br/><br/>
                    <span style="margin-right: 13px;">Leopold IV</span>
                    <input type="text" name="fisik[pemeriksaanFisik][palpasi][LIV]" class="form-control" style="display: inline-block; width: 100px;" id="" value="{{ @$assesment['pemeriksaanFisik']['palpasi']['LIV'] }}"><br/><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Auskultasi</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">His (x/10 menit)</td>
                  <td>
                    <input type="number" name="fisik[pemeriksaanFisik][auskultasi][his]" class="form-control" style="display: inline-block;" id="" placeholder="x/10 menit" value="{{ @$assesment['pemeriksaanFisik']['auskultasi']['his'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Durasi (detik)</td>
                  <td>
                    <input type="number" name="fisik[pemeriksaanFisik][auskultasi][durasi]" class="form-control" style="display: inline-block;" id="" placeholder="detik" value="{{ @$assesment['pemeriksaanFisik']['auskultasi']['durasi'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">DJJ</td>
                  <td>
                    <input type="text" name="fisik[pemeriksaanFisik][auskultasi][djj][text]" class="form-control" style="display: inline-block;" id="" value="{{ @$assesment['pemeriksaanFisik']['auskultasi']['djj']['text'] }}"><br/>
                    <input type="radio" id="djj_1" name="fisik[pemeriksaanFisik][auskultasi][djj][pilihan]" value="Reguler" {{ @$assesment['pemeriksaanFisik']['auskultasi']['djj']['pilihan'] == 'Reguler' ? 'checked' : '' }}>
                    <label for="djj_1" style="font-weight: normal; margin-right: 10px;">Reguler</label>
                    <input type="radio" id="djj_2" name="fisik[pemeriksaanFisik][auskultasi][djj][pilihan]" value="Irreguler" {{ @$assesment['pemeriksaanFisik']['auskultasi']['djj']['pilihan'] == 'Irreguler' ? 'checked' : '' }}>
                    <label for="djj_2" style="font-weight: normal; margin-right: 10px;">Irreguler</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">TBJA (gr)</td>
                  <td>
                    <input type="number" name="fisik[pemeriksaanFisik][auskultasi][tbja]" class="form-control" style="display: inline-block;" id="" value="{{ @$assesment['pemeriksaanFisik']['auskultasi']['tbja'] }}" placeholder="gr">
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Saluran Kemih & Genitalia</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Pengeluaran</td>
                  <td style="">
                    <input type="checkbox" id="pengeluaran_1" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][keputihan]" value="Keputihan" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['keputihan'] == 'Keputihan' ? 'checked' : '' }}>
                    <label for="pengeluaran_1" style="font-weight: normal; margin-right: 10px;">Keputihan</label><br/>
                    <input type="checkbox" id="pengeluaran_2" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][blood_show]" value="Blood Show" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['blood_show'] == 'Blood Show' ? 'checked' : '' }}>
                    <label for="pengeluaran_2" style="font-weight: normal; margin-right: 10px;">Blood Show</label><br/>
                    <input type="checkbox" id="pengeluaran_3" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][flek]" value="Flek" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['flek'] == 'Flek' ? 'checked' : '' }}>
                    <label for="pengeluaran_3" style="font-weight: normal; margin-right: 10px;">Flek</label><br/>
                    <input type="checkbox" id="pengeluaran_4" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][stosel]" value="Stosel" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['stosel'] == 'Stosel' ? 'checked' : '' }}>
                    <label for="pengeluaran_4" style="font-weight: normal; margin-right: 10px;">Stosel</label><br/>
                    <input type="checkbox" id="pengeluaran_5" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][ketuban]" value="Ketuban" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['ketuban'] == 'Ketuban' ? 'checked' : '' }}>
                    <label for="pengeluaran_5" style="font-weight: normal; margin-right: 10px;">Ketuban</label><br/>
                    <input type="checkbox" id="pengeluaran_6" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][nanah]" value="Nanah" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['nanah'] == 'Nanah' ? 'checked' : '' }}>
                    <label for="pengeluaran_6" style="font-weight: normal; margin-right: 10px;">Nanah</label><br/>
                    <input type="checkbox" id="pengeluaran_7" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][pilihan][lainnya]" value="Lainnya" {{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']['lainnya'] == 'Lainnya' ? 'checked' : '' }}>
                    <label for="pengeluaran_7" style="font-weight: normal; margin-right: 10px;">Lainnya</label><br/>
                    <input type="text" name="fisik[pemeriksaanFisik][genitalia][pengeluaran][jelaskan]" class="form-control" style="display: inline-block;" id="" placeholder="Jelaskan" value="{{ @$assesment['pemeriksaanFisik']['genitalia']['pengeluaran']['jelaskan'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Kelainan</td>
                  <td>
                    <input type="radio" id="kelainan_1" name="fisik[pemeriksaanFisik][genitalia][kelainan][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kelainan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="kelainan_2" name="fisik[pemeriksaanFisik][genitalia][kelainan][pilihan]" value="Ada" {{ @$assesment['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                    <label for="kelainan_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Lochea</td>
                  <td>
                    <input type="checkbox" id="lochea_1" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan][tidak]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['genitalia']['lochea']['pilihan']['tidak'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="lochea_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="checkbox" id="lochea_2" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan][ada]" value="Ada" {{ @$assesment['pemeriksaanFisik']['genitalia']['lochea']['pilihan']['ada'] == 'Ada' ? 'checked' : '' }}>
                    <label for="lochea_2" style="font-weight: normal; margin-right: 10px;">Ada</label>
                    <input type="checkbox" id="lochea_3" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan][rubra]" value="Rubra" {{ @$assesment['pemeriksaanFisik']['genitalia']['lochea']['pilihan']['rubra'] == 'Rubra' ? 'checked' : '' }}>
                    <label for="lochea_3" style="font-weight: normal; margin-right: 10px;">Rubra</label><br/>
                    <input type="checkbox" id="lochea_4" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan][sangulienta]" value="Sangulienta" {{ @$assesment['pemeriksaanFisik']['genitalia']['lochea']['pilihan']['sangulienta'] == 'Sangulienta' ? 'checked' : '' }}>
                    <label for="lochea_4" style="font-weight: normal; margin-right: 10px;">Sangulienta</label>
                    <input type="checkbox" id="lochea_5" name="fisik[pemeriksaanFisik][genitalia][lochea][pilihan][alba]" value="Alba" {{ @$assesment['pemeriksaanFisik']['genitalia']['lochea']['pilihan']['alba'] == 'Alba' ? 'checked' : '' }}>
                    <label for="lochea_5" style="font-weight: normal; margin-right: 10px;">Alba</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Perineum</td>
                  <td>
                    <input type="checkbox" id="perineum_1" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan][utuh]" value="Utuh" {{ @$assesment['pemeriksaanFisik']['genitalia']['perineum']['pilihan']['utuh'] == 'Utuh' ? 'checked' : '' }}>
                    <label for="perineum_1" style="font-weight: normal; margin-right: 10px;">Utuh</label>
                    <input type="checkbox" id="perineum_2" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan][jaringan_parut]" value="Jaringan Parut" {{ @$assesment['pemeriksaanFisik']['genitalia']['perineum']['pilihan']['jaringan_parut'] == 'Jaringan Parut' ? 'checked' : '' }}>
                    <label for="perineum_2" style="font-weight: normal; margin-right: 10px;">Jaringan Parut</label><br/>
                    <input type="checkbox" id="perineum_3" name="fisik[pemeriksaanFisik][genitalia][perineum][pilihan][varises]" value="Varises" {{ @$assesment['pemeriksaanFisik']['genitalia']['perineum']['pilihan']['varises'] == 'Varises' ? 'checked' : '' }}>
                    <label for="perineum_3" style="font-weight: normal; margin-right: 10px;">Varises</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Jahitan</td>
                  <td>
                    <input type="checkbox" id="jahitan_1" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan][baik]" value="Baik" {{ @$assesment['pemeriksaanFisik']['genitalia']['jahitan']['pilihan']['baik'] == 'Baik' ? 'checked' : '' }}>
                    <label for="jahitan_1" style="font-weight: normal; margin-right: 10px;">Baik</label>
                    <input type="checkbox" id="jahitan_2" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan][terlepas]" value="Terlepas" {{ @$assesment['pemeriksaanFisik']['genitalia']['jahitan']['pilihan']['terlepas'] == 'Terlepas' ? 'checked' : '' }}>
                    <label for="jahitan_2" style="font-weight: normal; margin-right: 10px;">Terlepas</label><br/>
                    <input type="checkbox" id="jahitan_3" name="fisik[pemeriksaanFisik][genitalia][jahitan][pilihan][hematom]" value="Hematom" {{ @$assesment['pemeriksaanFisik']['genitalia']['jahitan']['pilihan']['hematom'] == 'Hematom' ? 'checked' : '' }}>
                    <label for="jahitan_3" style="font-weight: normal; margin-right: 10px;">Hematom</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Robekan</td>
                  <td>
                    <input type="checkbox" id="robekan_1" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan][grade_1]" value="Grade I" {{ @$assesment['pemeriksaanFisik']['genitalia']['robekan']['pilihan']['grade_1'] == 'Grade I' ? 'checked' : '' }}>
                    <label for="robekan_1" style="font-weight: normal; margin-right: 10px;">Grade I</label>
                    <input type="checkbox" id="robekan_2" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan][grade_2]" value="Grade II" {{ @$assesment['pemeriksaanFisik']['genitalia']['robekan']['pilihan']['grade_2'] == 'Grade II' ? 'checked' : '' }}>
                    <label for="robekan_2" style="font-weight: normal; margin-right: 10px;">Grade II</label><br/>
                    <input type="checkbox" id="robekan_3" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan][grade_3]" value="Grade III" {{ @$assesment['pemeriksaanFisik']['genitalia']['robekan']['pilihan']['grade_3'] == 'Grade III' ? 'checked' : '' }}>
                    <label for="robekan_3" style="font-weight: normal; margin-right: 10px;">Grade III</label>
                    <input type="checkbox" id="robekan_4" name="fisik[pemeriksaanFisik][genitalia][robekan][pilihan][grade_4]" value="Grade IV" {{ @$assesment['pemeriksaanFisik']['genitalia']['robekan']['pilihan']['grade_4'] == 'Grade IV' ? 'checked' : '' }}>
                    <label for="robekan_4" style="font-weight: normal; margin-right: 10px;">Grade IV</label>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Anus</td>
                  <td>
                    <input type="checkbox" id="anus_1" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan][haemoroid]" value="Haemoroid" {{ @$assesment['pemeriksaanFisik']['genitalia']['anus']['pilihan']['haemoroid'] == 'Haemoroid' ? 'checked' : '' }}>
                    <label for="anus_1" style="font-weight: normal; margin-right: 10px;">Haemoroid</label>
                    <input type="checkbox" id="anus_2" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan][condiloma]" value="Condiloma" {{ @$assesment['pemeriksaanFisik']['genitalia']['anus']['pilihan']['condiloma'] == 'Condiloma' ? 'checked' : '' }}>
                    <label for="anus_2" style="font-weight: normal; margin-right: 10px;">Condiloma</label><br/>
                    <input type="checkbox" id="anus_3" name="fisik[pemeriksaanFisik][genitalia][anus][pilihan][tak]" value="T.A.K" {{ @$assesment['pemeriksaanFisik']['genitalia']['anus']['pilihan']['tak'] == 'T.A.K' ? 'checked' : '' }}>
                    <label for="anus_3" style="font-weight: normal; margin-right: 10px;">T.A.K</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Nifas</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">TFU</td>
                  <td>
                    <input type="text" name="fisik[pemeriksaanFisik][nifas][tfu]" class="form-control" style="display: inline-block;" id="" value="{{ @$assesment['pemeriksaanFisik']['nifas']['tfu'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Kontraksi Uterus</td>
                  <td>
                    <input type="radio" id="kontraksiUterus_1" name="fisik[pemeriksaanFisik][nifas][kontraksiUterus][pilihan]" value="Baik" {{ @$assesment['pemeriksaanFisik']['nifas']['kontraksiUterus']['pilihan'] == 'Baik' ? 'checked' : '' }}>
                    <label for="kontraksiUterus_1" style="font-weight: normal; margin-right: 10px;">Baik</label>
                    <input type="radio" id="kontraksiUterus_2" name="fisik[pemeriksaanFisik][nifas][kontraksiUterus][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['nifas']['kontraksiUterus']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kontraksiUterus_2" style="font-weight: normal; margin-right: 10px;">Tidak</label><br/>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Pemriksaan Dalam</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Vulva Vagina</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][vulvaVagina]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVagina'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Portio</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][portio]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['portio'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Ketuban</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][ketuban]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['ketuban'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Pembukaan</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][pembukaan]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['pembukaan'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Presentase Fetus</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][presentaseFetus]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['presentaseFetus'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">Hodge/Station</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][pemeriksaanDalam][hodge]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['pemeriksaanDalam']['hodge'] }}</textarea>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" style="width:50%; font-weight:500;">Gyonecologi</td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">a) Kelenjar Bartholini</td>
                  <td>
                    <input type="radio" id="kelenjarBartholini_1" name="fisik[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" value="Ada Pembengkakan" {{ @$assesment['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] == 'Ada Pembengkakan' ? 'checked' : '' }}>
                    <label for="kelenjarBartholini_1" style="font-weight: normal; margin-right: 10px;">Ada Pembengkakan</label>
                    <input type="radio" id="kelenjarBartholini_2" name="fisik[pemeriksaanFisik][gyonecologi][kelenjarBartholini][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kelenjarBartholini_2" style="font-weight: normal; margin-right: 10px;">Tidak</label><br/>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:500; width: 50%;">b) Inspekulo</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][gyonecologi][inspekulo]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['gyonecologi']['inspekulo'] }}</textarea>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Ekstremitas Atas dan Bawah</td>
                  <td>
                    <textarea rows="3" name="fisik[pemeriksaanFisik][ekstremitasAtasBawah]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaanFisik']['ekstremitasAtasBawah'] }}</textarea>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Oedem</td>
                  <td>
                    <input type="radio" id="oedem_1" name="fisik[pemeriksaanFisik][oedem][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['oedem']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="oedem_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="oedem_2" name="fisik[pemeriksaanFisik][oedem][pilihan]" value="Ya" {{ @$assesment['pemeriksaanFisik']['oedem']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    <label for="oedem_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Varises</td>
                  <td>
                    <input type="radio" id="varises_1" name="fisik[pemeriksaanFisik][varises][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['varises']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="varises_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="varises_2" name="fisik[pemeriksaanFisik][varises][pilihan]" value="Ya" {{ @$assesment['pemeriksaanFisik']['varises']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    <label for="varises_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Kekuatan Otot dan Sendi</td>
                  <td>
                    <input type="radio" id="kekuatanOtot_1" name="fisik[pemeriksaanFisik][kekuatanOtot][pilihan]" value="Tidak" {{ @$assesment['pemeriksaanFisik']['kekuatanOtot']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                    <label for="kekuatanOtot_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                    <input type="radio" id="kekuatanOtot_2" name="fisik[pemeriksaanFisik][kekuatanOtot][pilihan]" value="Ya" {{ @$assesment['pemeriksaanFisik']['kekuatanOtot']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                    <label for="kekuatanOtot_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br/>
                  </td>
                </tr>

                <tr>
                  <td style="font-weight:500; width: 50%;">Reflex</td>
                  <td>
                    <input type="radio" id="reflex_1" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Normal" {{ @$assesment['pemeriksaanFisik']['reflex']['pilihan'] == 'Normal' ? 'checked' : '' }}>
                    <label for="reflex_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                    <input type="radio" id="reflex_2" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Hyper" {{ @$assesment['pemeriksaanFisik']['reflex']['pilihan'] == 'Hyper' ? 'checked' : '' }}>
                    <label for="reflex_2" style="font-weight: normal; margin-right: 10px;">Hyper</label>
                    <input type="radio" id="reflex_3" name="fisik[pemeriksaanFisik][reflex][pilihan]" value="Hipo" {{ @$assesment['pemeriksaanFisik']['reflex']['pilihan'] == 'Hipo' ? 'checked' : '' }}>
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
                    <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][laboratorium]" type="checkbox" value="Laboratorium" id="flexCheckDefault" {{ @$assesment['pemeriksaanPenunjang']['laboratorium'] == 'Laboratorium' ? 'checked' : '' }}>
                      Laboratorium
                    </label>
                    <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][ekg]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][ekg]" type="checkbox" value="EKG" id="flexCheckDefault" {{ @$assesment['pemeriksaanPenunjang']['ekg'] == 'EKG' ? 'checked' : '' }}>
                      EKG
                    </label>
                    <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][radiologi]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][radiologi]" type="checkbox" value="Radiologi" id="flexCheckDefault" {{ @$assesment['pemeriksaanPenunjang']['radiologi'] == 'Radiologi' ? 'checked' : '' }}>
                      Radiologi
                    </label>
                    <label class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">
                    <input class="form-check-input"   name="fisik[pemeriksaanPenunjang][ctg]" type="hidden" value="" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[pemeriksaanPenunjang][ctg]" type="checkbox" value="CTG/NST" id="flexCheckDefault" {{ @$assesment['pemeriksaanPenunjang']['ctg'] == 'CTG/NST' ? 'checked' : '' }}>
                      CTG/NST
                    </label>
                    <input type="text" name="fisik[pemeriksaanPenunjang][lainnya]" class="form-control" style="display: inline-block;" id="" placeholder="Lainnya" value="{{ @$assesment['pemeriksaanPenunjang']['lainnya'] }}">
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

            </div>

            <div class="col-md-12">
              <h5><b>Riwayat Kehamilan, Persalinan dan Nifas Yang Lalu</b></h5>
              <table style="width: 100%" class="daftar_kehamilan table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <thead>
                  <tr>
                    <th>Tgl / Tahun Persalinan</th>
                    <th>Tempat Persalinan</th>
                    <th>Umur Persalinan</th>
                    <th>Jenis Persalinan</th>
                    <th>Penolong</th>
                    <th>Anak (JK)</th>
                    <th>Anak (BB)</th>
                    <th>Anak (PB)</th>
                    <th>ASI Ekslusif</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @for ($i=1; $i <= 15; $i++)
                    <tr>
                      <td>
                        <input type="date" name="fisik[riwayatKehamilan][{{$i}}][tgl]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['tgl']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][tmp]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['tmp']  }}" />
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][umur]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['umur']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][jenis]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['jenis']  }}" />
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][penolong]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['penolong']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][jk]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['jk']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][bb]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['bb']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][pb]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['pb']  }}" />
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][asi]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['asi']  }}"/>
                      </td>
                      <td>
                        <input type="text" name="fisik[riwayatKehamilan][{{$i}}][ket]" style="display:inline-block;" class="form-control" value="{{ @$assesment['riwayatKehamilan'][$i]['ket']  }}" />
                      </td>
                    </tr>
                  @endfor
                </tbody>
              </table>

              <div style="">
                <button class="btn btn-success pull-right">Simpan</button>
              </div>
              
              </form>
            </div>

          @endif
          
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
                      {{-- @if ( $riwayat->id == request()->asessment_id )
                          <td style="text-align: center; background-color:rgb(172, 247, 162)">
                              {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                          </td>
                      @else
                          <td style="text-align: center;">
                              {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                          </td>
                      @endif --}}
                     
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        @if (@$dataPegawai == '1')
                        <a href="{{url('emr-soap/pemeriksaan/awal-obgyn/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" class="label label-sm label-info">Lihat Asesmen Perawat</a>
                        @endif
                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                          @if (substr($riwayat->registrasi->status_reg, 0, 1) == 'J')
                            @if (in_array($riwayat->registrasi->poli_id, ['3', '34', '4']))
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif ($riwayat->registrasi->poli_id == '15')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif ( $riwayat->registrasi->poli_id == "6")
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-mata/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm btn-flat">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif ($riwayat->registrasi->poli_id == '27')
                              <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="fa fa-print"></i>
                              </a>
                            @elseif ($riwayat->registrasi->poli_id == '41')
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
                    <a href="#askepCollapse" data-toggle="collapse">Asuhan Keperawatan</a>
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

                        <h4 style="text-align: center"><b>Asuhan Keperawatan</b></h4>

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

          
          <br /><br />
        </div>
        
      </div>

    @if (@$dataPegawai == '1')
      <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
        <h5><b>7. TINDAKAN</b></h5>
        <tr>
            <td style="padding: 5px;">
              {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('poli_id', $poli) !!}
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
</script>
  @endsection