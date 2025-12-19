@extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection

<style>
  body {font-family: Arial, Helvetica, sans-serif;}
  #loader img {
    width: 50px;
    height: 50px;
}
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .summ:focus {
      background-color: green !important;
    }
  
  #myImg:hover {opacity: 0.7;}
  /* Warna merah untuk tanggal merah yang di-disable */
.libur-merah.disabled,
.libur-merah span,
.libur-merah {
    color: red !important;
    font-weight: bold;
    opacity: 1 !important; /* supaya tidak pudar */
}

/* Jika ingin background juga agak beda */
.libur-merah.disabled.active,
.libur-merah:hover {
    background-color: #ffe6e6 !important;
}
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

  .prb {
    padding: 10px;
    background-color: #ffecec;      
    border: 1px solid #ff6b6b;     
    border-radius: 6px;
    width: fit-content;
    margin: 20px auto 0 auto;
  }

  .prb h3 {
    color: #c70000;                  
    margin: 0;
    font-weight: bold;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  </style>








<style>
  .new{
    background-color:#e4ffe4;
  }
</style>
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
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  --}}
        @include('emr.modules.addons.profile')
        <div class="row">
          @include('emr.modules.addons.tabs')
          @if((($ketPRB ?? '') == 'ya')&&($unit == "jalan")) 
            <div class="prb">  
              <h3>Pasien Potensi PRB</h3>
            </div>
          @endif
          @if (in_array(@$reg->poli_id, ['3', '4', '34']))
            <div class="col-md-12">
              <table style="width: 100%" style="font-size:12px;">
                @if (@$gambar->image != null) 
                <tr>
                  <td style="text-align: center;">
                    <h4>Status Lokalis</h4>
                  </td>
                </tr>
                <tr>
                  
                  <td style="text-align: center;">
                    <img src="/images/{{ @$gambar['image'] }}" alt="status_lokalis" style="width: 500px; height:300px;">
                  </td>
                </tr>
                @else
                <tr>
                  <td style="text-align: center;">
                    <h4>Status Lokalis Belum Dibuat</h4>
                  </td>
                </tr>
                @endif
              </table>
            </div>
          @endif
            <div class="col-md-12">
                @if (!$emr)
                  <form method="POST" action="{{ url('save-emr') }}" class="form-horizontal cppt-form">
                @else
                  <form method="POST" action="{{ url('update-soap') }}" class="form-horizontal cppt-form">
                  {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', @$reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('poli_id', @$poli ? @$poli : @$reg->poli_id) !!}
                    {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br>
                    
                
                    <div id="listSoap">
                      <div id="loader" style="display: none; text-align: center; margin-top: 20px;">
                          <img src="{{asset('images/loader.gif')}}" alt="Loading..." />
                          <p>Sedang load history SOAP...</p>
                      </div>
                  </div>
                    
                    {{-- Soap Input --}}
                      <div class="col-md-6" style="margin-bottom: 10px;">  
                        @if ($unit == "jalan" && !empty(@$assesment_dokter))
                        <button onclick="openWindow('{{ url('cetak-eresume-medis/pdf/' . @$assesment_dokter->registrasi_id . '/' . @$assesment_dokter->id)  . '?source=asesmen&tipe=dokter' }}')" class="btn btn-flat btn-info btn-xs">Asesmen</button>
                        @endif
                        <table style="width: 100%" style="font-size:12px;">
                          @if ($unit == "inap")
                          <tr>
                              <td style="width:50px;"><b>Ruangan</b></td>
                              <td style="padding: 5px;">
                               <select id="histori_ranap_id" class="form-control select2">
                                    @foreach ($histori_ranap as $item)
                                        <option value="{{$item->id}}">{{baca_kamar($item->kamar_id)}}</option>
                                    @endforeach
                                </select>
                              </td> 
                          </tr>
                          @endif
                          <tr>
                              <td style="width:50px;"><b>Subjective(S)</b></td>
                              <td style="padding: 5px;">
                                @if ($unit == "igd")
                                  @if (@$asesmen_igd_dokter)
                                    <textarea style="resize: vertical;" class="form-control" id="subjective" name="subject" required> {{$emr ? $emr->subject : @$asesmen_igd_dokter['igdAwal']['riwayatPenyakit']}}</textarea>
                                  @else
                                    <textarea style="resize: vertical;" class="form-control" id="subjective" name="subject" required> {{$emr ? $emr->subject : @$currentEmr->subject}}</textarea>
                                  @endif
                                @else
                                  @if (@$cppt_perawat || @$aswal_inap)
                                    <textarea style="resize: vertical;" class="form-control" id="subjective" name="subject" required> @if ($emr){{$emr->subject}}@else {{@$cppt_perawat->subject}} &#13; {{@$aswal_inap['keluhanUtama']}}@endif</textarea>
                                  @else
                                    <textarea style="resize: vertical;" class="form-control" id="subjective" name="subject" required> {{$emr ? $emr->subject : @$currentEmr->subject}}</textarea>
                                  @endif
                                @endif
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Objective(O)</b></td>
                              <td style="padding: 5px;">
                                @if ($unit == "igd")
                                  @if (@$asesmen_igd_ttv)
                                    <textarea style="resize: vertical;" class="form-control" id="objective" name="object" required>@if ($emr){{$emr->object}}@else Tanda Vital : &#13; Tekanan darah : {{@$asesmen_igd_ttv['tekananDarah'] ?? @$asesmen_igd_ttv['tekanan_darah']}} &#13; Nadi : {{@$asesmen_igd_ttv['frekuensiNadi'] ?? @$asesmen_igd_ttv['nadi']}} &#13; Frekuensi Nafas : {{@$asesmen_igd_ttv['RR'] ?? @$asesmen_igd_ttv['frekuensi_nafas']}} &#13; Suhu : {{@$asesmen_igd_ttv['suhu'] ?? @$asesmen_igd_ttv['suhu']}} &#13; Berat Badan : {{@$asesmen_igd_ttv['BB'] ?? @$asesmen_igd_ttv['BB']}}@endif</textarea>
                                  @else
                                    <textarea style="resize: vertical;" class="form-control" id="objective" name="object" required>{{$emr ? $emr->object : @$currentEmr->object}}</textarea>
                                  @endif
                                @else
                                  {{-- Poli Syaraf --}}
                                  @if (@$reg->poli_id == 21)
                                    <textarea style="resize: vertical;" class="form-control" id="objective" name="object" required>{{$emr ? $emr->object : ''}}</textarea>
                                  @else
                                    @if (@$cppt_perawat)
                                      <textarea style="resize: vertical;" class="form-control" id="objective" name="object" required>@if ($emr){{$emr->object}}@else Tanda Vital : &#13; Tekanan darah : {{@$cppt_perawat->tekanan_darah}} &#13; Nadi : {{@$cppt_perawat->nadi}} &#13; Frekuensi Nafas : {{@$cppt_perawat->frekuensi_nafas}} &#13; Suhu : {{@$asesmen_igd_ttv['suhu'] ?? @$cppt_perawat->suhu}} &#13; Berat Badan : {{@$cppt_perawat->berat_badan}} &#13; &#13; {{@$cppt_perawat->object}} &#13; &#13; @if(@$reg->poli_id == 6) Pemeriksaan Visus &#13; - OD : {{@$assesment_mata['pemeriksaanVisus']['od'] ?? '-'}} &#13; - OS : {{@$assesment_mata['pemeriksaanVisus']['os'] ?? '-'}} &#13; @endif @endif</textarea>
                                    @else
                                      <textarea style="resize: vertical;" class="form-control" id="objective" name="object" required>{{$emr ? $emr->object : @$currentEmr->object}}</textarea>
                                    @endif
                                  @endif
                                @endif
                              </td> 
                          </tr>
                          <tr>
                            <td style="vertical-align: top;"><b>Hasil Penunjang</b></td>
                            <td style="padding: 5px;">
                                <select id="hasil_penunjang" class="form-control select2" onchange="tampilkanPenunjang()">
                                    <option value="">Pilih Hasil Penunjang</option>
                                    <option value="usg_kandungan">USG Kandungan</option>
                                    <option value="echo">Echo</option>
                                    <option value="ekg">EKG</option>
                                    <option value="eeg">EEG</option>
                                    <option value="ctg">CTG</option>
                                    <option value="spirometri">Spirometri</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <div id="input_penunjang" style="margin-top: 10px;">
                                    <!-- Inputan dinamis akan muncul di sini -->
                                </div>
                            </td>
                          </tr>
                          <tr>
                              <td><b>Assesment/Diagnosis(A)</b><br><b>Diagnosa Utama</b></td>
                              <td style="padding: 5px;">
                                @if ($unit == "igd")
                                  @if (@$asesmen_igd_dokter)
                                    <textarea style="resize: vertical;" class="form-control" id="diagnosa_utama" name="assesment" required>{{$emr ? @$emr->assesment : @$asesmen_igd_dokter['igdAwal']['diagnosa']}}</textarea>
                                  @else
                                    <textarea style="resize: vertical;" class="form-control" id="diagnosa_utama" name="assesment" required>{{$emr ? @$emr->assesment : ''}}</textarea>
                                  @endif
                                @else
                                  <textarea style="resize: vertical;" class="form-control" id="diagnosa_utama" name="assesment" required>{{$emr ? @$emr->assesment : ''}}</textarea>
                                @endif
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Assesment/Diagnosis(A)</b><br><b>Diagnosa Tambahan</b></td>
                              <td style="padding: 5px;">
                                  <textarea style="resize: vertical;" class="form-control" required name="assesment_tambahan" >{{$emr ? @$emr->diagnosistambahan : ''}}</textarea>
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Planning(P)</b></td>
                            <td style="padding: 5px;">
                              @if ($unit == "igd")
                                @if (@$asesmen_igd_dokter)
                                  <textarea style="resize: vertical;" id="planning" class="form-control" name="planning" required>@if ($emr){{$emr->planning}}@else {{@$asesmen_igd_dokter['igdAwal']['tindakan_pengobatan']}} @endif</textarea>
                                @else
                                  <textarea style="resize: vertical;" id="planning" class="form-control" name="planning" required>@if ($emr){{$emr->planning}}@else @foreach(@$namaObat as $k => $v) {{ @$v['obat'] }}{{ @$v['signa']?'['.$v['signa'].']':'' }}, @endforeach &#13; {{@$aswal_inap['Tindakan']}} @endif</textarea>
                                @endif
                              @else
                                <textarea style="resize: vertical;" id="planning" class="form-control" name="planning" required>@if ($emr){{$emr->planning}}@else @foreach(@$namaObat as $k => $v) {{ @$v['obat'] }}{{ @$v['signa']?'['.$v['signa'].']':'' }}, @endforeach &#13; {{@$aswal_inap['Tindakan']}} @endif</textarea>
                              @endif
                            </td> 
                          </tr>
                            @if (@$reg->poli_id == 20)
                              <tr>
                                <td><b>ICD9</b></td>
                                <td style="padding: 5px;">
                                  <textarea style="resize: vertical;" class="form-control" name="icd9"></textarea>
                                </td> 
                              </tr> 
                            @endif
                            <tr>
                                <td><b>Edukasi</b></td>
                                <td style="padding: 5px;">
                                    <select name="edukasi" class="form-control select2"
                                        style="width: 100%">
                                        <option value="">-- Pilih Edukasi --</option>
                                        @foreach ($edukasi as $edu)
                                            <option  value="{{ $edu->code }}">{{ $edu->keterangan }} </option>
                                        @endforeach
                                    </select>
                                </td> 
                            </tr>
                            <tr>
                                <td><b>Diet</b></td>
                                <td style="padding: 5px;">
                                    <textarea style="resize: vertical;" class="form-control" name="diet" >{{$emr ? @$emr->diet : ''}}</textarea>
                                </td> 
                            </tr>
                            <tr>
                                <td><b>Prognosis</b></td>
                                <td style="padding: 5px;">
                                    <select name="prognosis" class="form-control select2"
                                        style="width: 100%">
                                        <option value="">-- Pilih Prognosis --</option>
                                        @foreach ($prognosis as $prog)
                                            <option  value="{{ $prog->code }}">{{ $prog->display }} - {{ $prog->keterangan }} </option>
                                        @endforeach
                                    </select>
                                </td> 
                            </tr>
                            <tr>
                              <td><b>Tanggal</b></td>
                              <td style="padding: 5px;">
                                <input type="datetime-local" name="created_at" class="form-control" value="{{@$emr ? date('Y-m-d\TH:i', strtotime($emr->created_at)) : date('Y-m-d\TH:i')}}">
                              </td> 
                          </tr>
                          

                          @php
                              $kondisi = App\KondisiAkhirPasien::all();
                              @$assesments  = @json_decode(@$emr->discharge, true);
                          @endphp
                          
                          
                        </table>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                          <tr>
                            <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
                          </tr>
                          
                          @if ($unit == 'igd')  
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_1" class="discargePlanningCheckbox"  name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['kontrol']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_2" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol PRB" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                                <label for="dischargePlanning_2" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['kontrolPRB']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_3" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Dirawat" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                                <label for="dischargePlanning_3" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][dirawat][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['dirawat']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_4" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Dirujuk" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                                <label for="dischargePlanning_4" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['dirujuk']['waktu']}}">
                              </td>
                            </tr>
                            <tr id="igd_rujukan" @if(@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Faskes Rujukan
                                </td>
                                <td>
                                    <select id="igd_faskes" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                                        <option value="" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                        <option value="RS Kab. Bandung" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                                        <option value="RS Kota Bandung" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                                        <option value="RS JAKARTA" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS JAKARTA' ? 'selected' : ''}}>RS JAKARTA</option>
                                        <option value="RS TASIKMALAYA" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS TASIKMALAYA' ? 'selected' : ''}}>RS TASIKMALAYA</option>
                                        <option value="RS BEKASI" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS BEKASI' ? 'selected' : ''}}>RS BEKASI</option>
                                        <option value="RS Provinsi" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                                        <option value="RS KOTA CIMAHI" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS KOTA CIMAHI' ? 'selected' : ''}}>RS KOTA CIMAHI</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="igd_rs_rujukan" @if(@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Rumah Sakit Rujukan
                                </td>
                                <td>
                                    <select id="igd_faskes_rs_rujukan" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                                        <option value="" {{@$assesments['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                        @foreach ($faskesRujukanRs as $rs)
                                            <option value="{{$rs->id}}" {{@$assesments['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr id="igd_alasan_rujukan" @if(@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Alasan
                                </td>
                                <td>
                                    <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesments['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_5" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                                <label for="dischargePlanning_5" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['Konsultasi']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_6" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Observasi" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Observasi' ? 'checked' : ''}}>
                                <label for="dischargePlanning_6" style="font-weight: normal; margin-right: 10px;">Observasi</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][observasi][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['observasi']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_7" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="APS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'APS' ? 'checked' : ''}}>
                                <label for="dischargePlanning_7" style="font-weight: normal; margin-right: 10px;">APS</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][aps][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['aps']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="radio" id="dischargePlanning_8" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="Meninggal" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                                <label for="dischargePlanning_8" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['meninggal']['waktu']}}">
                              </td>
                            </tr>
                          @else
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_9" class="discargePlanningCheckbox"  name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                                <label for="dischargePlanning_9" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                              </td>
                              <td>
                                <input type="text" id="waktuKontrol" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['kontrol']['waktu']}}">
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
                                <input type="checkbox" id="dischargePlanning_10" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB" {{@$assesments['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : ''}}>
                                <label for="dischargePlanning_10" style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['kontrolPRB']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_11" class="discargePlanningCheckbox" name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat" {{@$assesments['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : ''}}>
                                <label for="dischargePlanning_11" style="font-weight: normal; margin-right: 10px;">Dirawat</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][dirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['dirawat']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_12" class="discargePlanningCheckbox" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                                <label for="dischargePlanning_12" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['dirujuk']['waktu']}}">
                              </td>
                            </tr>
                            <tr id="rujukan" @if(@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Faskes Rujukan
                                </td>
                                <td>
                                    <select id="faskes" name="fisik[dischargePlanning][dirujuk][diRujukKe]" class="form-control select2" style="width: 100%">
                                        <option value="" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                        <option value="RS Kab. Bandung" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                                        <option value="RS Kota Bandung" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                                        <option value="RS JAKARTA" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS JAKARTA' ? 'selected' : ''}}>RS JAKARTA</option>
                                        <option value="RS TASIKMALAYA" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS TASIKMALAYA' ? 'selected' : ''}}>RS TASIKMALAYA</option>
                                        <option value="RS BEKASI" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS BEKASI' ? 'selected' : ''}}>RS BEKASI</option>
                                        <option value="RS Provinsi" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                                        <option value="RS KOTA CIMAHI" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS KOTA CIMAHI' ? 'selected' : ''}}>RS KOTA CIMAHI</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="rs_rujukan" @if(@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Rumah Sakit Rujukan
                                </td>
                                <td>
                                    <select id="faskes_rs_rujukan" name="fisik[dischargePlanning][dirujuk][rsRujukan]" class="form-control select2" style="width: 100%">
                                        <option value="" {{@$assesments['dischargePlanning']['dirujuk']['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                        @foreach ($faskesRujukanRs as $rs)
                                            <option value="{{$rs->id}}" {{@$assesments['dischargePlanning']['dirujuk']['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr id="alasan_rujukan" @if(@$assesments['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk') style="display: table-row" @else style="display: none" @endif>
                                <td  style="width:40%; font-weight:bold;">
                                    Alasan
                                </td>
                                <td>
                                    <input type="text" style="width: 100%" name="fisik[dischargePlanning][dirujuk][alasanRujuk]" value="{{@$assesments['dischargePlanning']['dirujuk']['alasanRujuk']}}" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_13" class="discargePlanningCheckbox" name="fisik[dischargePlanning][Konsultasi][dipilih]" value="Konsultasi selesai / tidak kontrol ulang" {{@$assesments['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : ''}}>
                                <label for="dischargePlanning_13" style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak kontrol ulang</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['Konsultasi']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_14" class="discargePlanningCheckbox" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesments['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                                <label for="dischargePlanning_14" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['pulpak']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_15" class="discargePlanningCheckbox" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesments['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                                <label for="dischargePlanning_15" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesments['dischargePlanning']['meninggal']['waktu']}}">
                              </td>
                            </tr>
                          @endif
                          
                        </table>
                      </div>
                      
                      @if ($unit == "inap")
                        <div class="text-right">
                          <input type="checkbox" name="transfer_internal_keluar" value="true"> <label for="">Buat Transfer Internal Keluar Ruangan Ketika Simpan</label>
                        </div>
                      @endif
                      <div class="text-right">
                        Sudah Sesuai ?
                        <input type="radio" name="sesuai" value="Y" checked> <label for="">Sudah</label>
                        <input type="radio" name="sesuai" value="N"> <label for="">Belum</label>
                      </div>
                      <div class="form-group">
                        <div class="text-right" style="padding: 0 2rem 0 0">
                        @if ($poli == 20)
                          <div class="btn-group">
                            <button type="button" class="btn btn-info" onclick="saveToEvaluasi()">Simpan Evaluasi</button>
                            <button type="button" class="btn btn-info" onclick="saveToRehab()">Simpan Ke Rehab</button>
                                {{-- <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                              <li><a class="dropdown-item" href="#" onclick="saveToLayananRehab()">Layanan Kedokteran dan Rehabilitasi</a></li>
                              <li><a class="dropdown-item" href="#" onclick="saveToProgramTerapi()">Program Terapi</a></li>
                              <li><a class="dropdown-item" href="#" onclick="saveToUjiFungsi()">Hasil Tindakan Uji Fungsi</a></li>
                            </ul> --}}
                          </div>
                        @endif
                            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat btn-save-cppt', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                        </div>                
                      </div>
                    <br/><br/> 
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', @$reg->id) !!}
                  {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                  {!! Form::hidden('cara_bayar', @$reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form> 
            </div>
        </div>
    </div>
  </div>  

  {{-- Tambahan --}}
  @if ($unit == "jalan")
  <div id="listTindakan">
    <div id="loader" style="display: none; text-align: center; margin-top: 20px;">
        <img src="{{asset('images/loader.gif')}}" alt="Loading..." />
        <p>Sedang load history SOAP...</p>
    </div>
  </div>
  @endif

@if ($unit == "inap")
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
                                <select name="tarif_id[]" id="select2Multiple2" class="form-control" required
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
                                            <option value="{{ $key }}" selected>{{ $item->carabayar }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $item->carabayar }}</option>
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
                        <div class="form-group{{ $errors->has('eksekutif') ? ' has-error' : '' }}">
                          {!! Form::label('eksekutif', 'Eksekutif', ['class' => 'col-sm-2 control-label']) !!}
                          <div class="col-sm-4">
                              <select name="eksekutif" id="eksekutif" class="form-control">
                                  <option value="" selected>Tidak</option>
                                  <option value="1">Ya</option>
                              </select>
                              <small class="text-danger">{{ $errors->first('eksekutif') }}</small>
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
                                    @endif
                                    <tr>
                                        
                                        <th>Kelas Perawatan </th>
                                        <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                        @php
                                            session(['kelas_id' => @$reg->kelas_id]);
                                        @endphp
                                    </tr>
                                    
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
                                        <th>Tarif IDRG Sementara</th>
                                        <td>{{ number_format(@$reg->tarif_idrg) }}</td>
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
@endif

  {{-- Modal History SOAP ======================================================================== --}}
  <div class="modal fade" id="showHistoriSoap" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">History SOAP Sebelumnya</h4>
            </div>
            <div class="modal-body">
                <div id="dataHistoriSoap">
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
  {{-- End Modal History SOAP ======================================================================== --}}

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

  {{-- Modal History GIZI ======================================================================== --}}
  <div class="modal fade" id="showHistoriGizi" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">History Gizi</h4>
            </div>
            <div class="modal-body">
                <div id="dataHistoriGizi">
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
  
@endsection
  
  <style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
  </style>
@section('script')
@parent
{{-- Handle draft cppt --}}
  <script>
    // $('#listSoap').load("{{ url('/emr-list-soap/'.$unit.'/'.$reg->id.'/'.$reg->pasien->id) }}");
    $('#listSoap').html('<div id="loader" style="text-align: center; margin-top: 20px;">' +
        '<img src="{{ asset('images/loader.gif') }}" alt="Loading..." />' +
        '<p>Sedang load history SOAP...</p>' +
        '</div>');

    // Load data SOAP dan sembunyikan loader setelah selesai
    $('#listSoap').load("{{ url('/emr-list-soap/'.$unit.'/'.$reg->id.'/'.$reg->pasien->id) }}", function(response, status, xhr) {
        if (status == "error") {
            $('#listSoap').html('<p>Error loading data.</p>');
        }
    });
    
    // LIST TINDAKAN
    $('#listTindakan').html('<div id="loader" style="text-align: center; margin-top: 20px;">' +
        '<img src="{{ asset('images/loader.gif') }}" alt="Loading..." />' +
        '<p>Sedang load Tindakan...</p>' +
        '</div>');

    // Load data SOAP dan sembunyikan loader setelah selesai
    $('#listTindakan').load("{{ url('/emr-list-tindakan/'.$unit.'/'.$reg->id.'/'.$reg->pasien->id) }}", function(response, status, xhr) {
        if (status == "error") {
            $('#listTindakan').html('<p>Error loading data.</p>');
        }else {
          // Inisialisasi ulang Select2 di dalam elemen yang baru dimuat
          $('.select2').select2();
          select2multi()
      }
    });


    var reg_id = '{{$reg->id}}';
    let instance = 'cppt_'+reg_id;
    let draftCppt = localStorage.getItem(instance);
    
    let element = [
      $('textarea[name=subject]'),
      $('textarea[name=object]'),
      $('textarea[name=assesment]'),
      $('textarea[name=assesment_tambahan]'),
      $('textarea[name=diet]'),
      $('input[name=created_at]'),
      $('select[name=edukasi]'),
      $('select[name=prognosis]'),
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
      let unit = "{{$unit}}";
      e.preventDefault();
      // Manual validasi untuk Rajal & IGD
      if (unit != "inap") {
        let kontrol = $('input[name="fisik[dischargePlanning][kontrol][dipilih]"]').is(":checked")
        let kontrolPrb = $('input[name="fisik[dischargePlanning][kontrolPRB][dipilih]"]').is(":checked")
        let dirawat = $('input[name="fisik[dischargePlanning][dirawat][dipilih]"]').is(":checked")
        let dirujuk = $('input[name="fisik[dischargePlanning][dirujuk][dipilih]"]').is(":checked")
        let konsultasi = $('input[name="fisik[dischargePlanning][Konsultasi][dipilih]"]').is(":checked")
        let pulpak = $('input[name="fisik[dischargePlanning][pulpak][dipilih]"]').is(":checked")
        let observasi = $('input[name="fisik[dischargePlanning][observasi][dipilih]"]').is(":checked")
        let meninggal = $('input[name="fisik[dischargePlanning][meninggal][dipilih]"]').is(":checked")
  
        if (!kontrol && !kontrolPrb && !dirawat && !dirujuk && !konsultasi && !pulpak && !meninggal && !observasi) {
          alert('Discharge Planning wajib diisi')
        } else {
          destroyDraft(instance)
          $('.cppt-form')[0].submit();
        }
      } else {
        destroyDraft(instance)
        $('.cppt-form')[0].submit();
      }
    })

    // $('.sidebar').click(function (e) {
    //   draftCppt = localStorage.getItem(instance);
    //   if (draftCppt != null) {
    //     e.preventDefault()
    //     alert('CPPT belum disimpan, harap simpan CPPT terlebih dahulu')
    //   }
    // })

    // $('.logo').click(function (e) {
    //   draftCppt = localStorage.getItem(instance);
    //   if (draftCppt != null) {
    //     e.preventDefault()
    //     alert('CPPT belum disimpan, harap simpan CPPT terlebih dahulu')
    //   }
    // })

    // $('#myTab').click(function (e) {
    //   draftCppt = localStorage.getItem(instance);
    //   if (draftCppt != null) {
    //     e.preventDefault()
    //     alert('CPPT belum disimpan, harap simpan CPPT terlebih dahulu')
    //   }
    // })
  </script>

    <script type="text/javascript">
        $(".skin-blue").addClass( "sidebar-collapse" );
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
        // $.getJSON("https://api-harilibur.vercel.app/api", function (data) {
        $.getJSON("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json", function (data) {
          const tanggalMerah = Object.keys(data)
              .filter(key => data[key].holiday === true)
              .map(key => {
                  const [y, m, d] = key.split("-");
                  return `${d}-${m}-${y}`;
              });

          $(".date_tanpa_tanggal").datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              todayHighlight: true,
              beforeShowDay: function (date) {
                  const d = ("0" + date.getDate()).slice(-2);
                  const m = ("0" + (date.getMonth() + 1)).slice(-2);
                  const y = date.getFullYear();
                  const dateStr = `${d}-${m}-${y}`;
                  const day = date.getDay(); // 0 = Minggu

                  // Hari Minggu
                  if (day === 0) {
                      return {
                          enabled: false,
                          classes: "libur-merah",
                          tooltip: "Hari Minggu"
                      };
                  }

                  // Tanggal merah nasional
                  if (tanggalMerah.includes(dateStr)) {
                      return {
                          enabled: false,
                          classes: "libur-merah",
                          tooltip: data[`${y}-${m}-${d}`]?.description || "Tanggal Merah"
                      };
                  }

                  return true;
              }
          });
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
  if(img){
    img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = dataImage.src;
      captionText.innerHTML = this.alt;
    }
  }
  
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() { 
    modal.style.display = "none";
  }
</script>

<script>
  $(document).ready(function() {
      // Select2 Multiple
      $('.select2-multiple').select2({
          placeholder: "Pilih Multi Tindakan",
          allowClear: true
      });

  });

  $(document).on('click', '#historiSoap', function(e) {
    
    var id = $(this).attr('data-pasienID');
    var unit = $('input[name=unit]').val();
    // $('#showHistoriSoap').modal('show');
    $('#showHistoriSoap').modal({
        backdrop: false,
        show : true
    });
    $('#dataHistoriSoap').load("/soap/history/"+unit+"/" + id);
  });
  $(document).on('click', '#historiAsesmen', function(e) {
    var id = $(this).attr('data-regID');
    window.open('/emr/resume/igd/'+id, "Asesmen", 'width=700,height=700,scrollbars=yes');
    
  });
  function openWindow(url, title) {
    window.open(url, title, 'width=700,height=700,scrollbars=yes');
    
  }

  $(document).on('change', '#registrasi_select', function(){
    var regId = $(this).val();
    var unit = $('input[name=unit]').val();
    // console.log(unit);
    // $('#showHistoriSoap').modal('show');
    $('#showHistoriSoap').modal({
        backdrop: false,
        show : true
    });
    $('#dataHistoriSoap').load("/soap/history-filter/"+unit+"/" + regId);
  });
  $(document).on('click', '#historiGizi', function(e) {
    var id = $(this).attr('data-giziID');
    // $('#showHistoriGizi').modal('show');
    $('#showHistoriGizi').modal({
        backdrop: false,
        show : true
    });
    $('#dataHistoriGizi').load("/soap/history-gizi/" + id);
  });

  $(document).on('click', '#listKontrol', function(e) {
    var id = $(this).attr('data-dokterID');
    var tgl = $('#waktuKontrol').val();
    
    if(tgl == null || tgl == ''){
      alert('Harap Isi Tanggal Kontrol');
    }else{
      // $('#showListKontrol').modal('show');
      $('#showListKontrol').modal({
        backdrop: false,
        show : true
    });
      $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
    }
  });
</script>
<script type="text/javascript">
status_reg = "<?= substr($reg->status_reg,0,1) ?>"
$('.select2').select2();
$('select[name="bayar"]').on('change', function(){
$.get('/tindakan/updateCaraBayar/'+$(this).attr('id')+'/'+$(this).val(), function(){
  location.reload();
});
})

// MASTER OBAT
function select2multi(){
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
}



$(document).on('click','.btn-history-resep',function(){
    let id = $(this).attr('data-id');
    $.ajax({
        url: '/tindakan/e-resep/history/'+id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
        $('#listHistoryResep').html('');
        },
        success: function (res){
        $('#listHistoryResep').html(res.html);
        // $('#myModalHistoryResep').modal('show');
        $('#myModalHistoryResep').modal({
        backdrop: false,
        show : true
    });
        }
    });
    })

function ribuan(x) {
return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function lunas(){
var data = $('#formLunas').serialize();
if(confirm('Yakin akan di lunaskan?')){
  $.post('/tindakan/lunas', data, function(resp){
    if(resp.sukses == true){
      location.reload()
    }
  })
}
}
function belumLunas(){
var data = $('#formLunas').serialize();
if(confirm('Yakin belum lunas?')){
  $.post('/tindakan/belumLunas', data, function(resp){
    if(resp.sukses == true){
      location.reload()
    }
  })
}
}

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

    $('#select2Multiple2').select2({
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
        $('#select2Multiple2').select2({
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
    });
    $('select[name="bayar"]').on('change', function() {
        $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
            location.reload();
        });
    });
        
  </script>
@endif


<script>
$(document).ready(function() {
  //Dirujuk from RJ / RI
  $('input[name="fisik[dischargePlanning][dirujuk][dipilih]"]').on('change', function(){
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

  //Dirujuk from IGD
  $('#dischargePlanning_4').on('change', function(){
      if ($(this).is(':checked')) { 
        $('#igd_rujukan').css('display', 'table-row');
        $('#igd_rs_rujukan').css('display', 'table-row');
        $('#igd_alasan_rujukan').css('display', 'table-row');

        $('#igd_faskes').trigger('change');

      } else {
        $('#igd_rujukan').css('display', 'none');
        $('#igd_rs_rujukan').css('display', 'none');
        $('#igd_alasan_rujukan').css('display', 'none');
      }
  });

  $('#igd_faskes').on('change', function(){
      var selectedValue = $(this).val();
      console.log(selectedValue);
      if(selectedValue != ''){
          $('#igd_faskes_rs_rujukan').val('');

          $('#igd_faskes_rs_rujukan').select2({
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
<script>
  function saveToEvaluasi() {
    const diagnosaValue = document.getElementById('diagnosa_utama').value;
    const planningValue = document.getElementById('planning').value;
    const objectiveValue = document.getElementById('objective').value;
    const subjectiveValue = document.getElementById('subjective').value;

    localStorage.setItem('dataDiagnosa', diagnosaValue);
    localStorage.setItem('dataPlanning', planningValue);
    localStorage.setItem('dataObjective', objectiveValue);
    localStorage.setItem('dataSubjective', subjectiveValue);

    alert('Data berhasil disimpan. Silakan buka halaman Rehab Medik.');
  }
  function saveToRehab() {
    const diagnosaValue2 = document.getElementById('diagnosa_utama').value;
    const planningValue2 = document.getElementById('planning').value;
    const objectiveValue2 = document.getElementById('objective').value;
    const subjectiveValue2 = document.getElementById('subjective').value;

    localStorage.setItem('dataDiagnosa2', diagnosaValue2);
    localStorage.setItem('dataPlanning2', planningValue2);
    localStorage.setItem('dataObjective2', objectiveValue2);
    localStorage.setItem('dataSubjective2', subjectiveValue2);

    alert('Data berhasil disimpan ke layanan rehab dan program terapi. Silakan buka halaman Rehab Medik.');
  }
  // function saveToLayananRehab() {
  //   const diagnosaValue = document.getElementById('diagnosa_utama').value;
  //   const planningValue = document.getElementById('planning').value;
  //   const objectiveValue = document.getElementById('objective').value;
  //   const subjectiveValue = document.getElementById('subjective').value;

  //   localStorage.setItem('dataDiagnosa', diagnosaValue);
  //   localStorage.setItem('dataPlanning', planningValue);
  //   localStorage.setItem('dataObjective', objectiveValue);
  //   localStorage.setItem('dataSubjective', subjectiveValue);

  //   alert('Data berhasil disimpan ke layanan rehab. Silakan buka halaman Rehab Medik.');
  // }
  // function saveToProgramTerapi() {
  //   const planningValue2 = document.getElementById('planning').value;

  //   localStorage.setItem('dataPlanning2', planningValue2);

  //   alert('Data berhasil disimpan ke program terapi. Silakan buka halaman Rehab Medik.');
  // }
  // function saveToUjiFungsi() {
  //   const diagnosaValue3 = document.getElementById('diagnosa_utama').value;
  //   const planningValue3 = document.getElementById('planning').value;
  //   const objectiveValue3 = document.getElementById('objective').value;

  //   localStorage.setItem('dataDiagnosa3', diagnosaValue3);
  //   localStorage.setItem('dataObjective3', objectiveValue3);
  //   localStorage.setItem('dataPlanning3', planningValue3);

  //   alert('Data berhasil disimpan ke uji fungsi. Silakan buka halaman Rehab Medik.');
  // }
</script>
<script>
  function tampilkanPenunjang() {
    var hasilPenunjang = document.getElementById("hasil_penunjang").value;
    var inputDiv = document.getElementById("input_penunjang");
    inputDiv.innerHTML = ""; // Kosongkan div setiap kali pilihan berubah

    if (hasilPenunjang === "usg_kandungan") {
        inputDiv.innerHTML = `
            <textarea name="hasil_usg" placeholder="Masukkan hasil USG" class="form-control" rows="5">{{$emr ? $emr->hasil_usg : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "ekg") {
        inputDiv.innerHTML = `
            <textarea name="hasil_ekg" placeholder="Masukkan hasil EKG" class="form-control" rows="5">{{$emr ? $emr->hasil_ekg : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "echo") {
        inputDiv.innerHTML = `
            <textarea name="hasil_echo" placeholder="Masukkan hasil ECHO" class="form-control" rows="5">{{$emr ? $emr->hasil_echo : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "eeg") {
        inputDiv.innerHTML = `
            <textarea name="hasil_eeg" placeholder="Masukkan hasil EEG" class="form-control" rows="5">{{$emr ? $emr->hasil_eeg : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "ctg") {
        inputDiv.innerHTML = `
            <textarea name="hasil_ctg" placeholder="Masukkan hasil CTG" class="form-control" rows="5">{{$emr ? $emr->hasil_ctg : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "spirometri") {
        inputDiv.innerHTML = `
            <textarea name="hasil_spirometri" placeholder="Masukkan hasil Spirometri" class="form-control" rows="5">{{$emr ? $emr->hasil_spirometri : ''}}</textarea>
        `;
    } else if (hasilPenunjang === "lainnya") {
        inputDiv.innerHTML = `
            <textarea name="hasil_lainnya" placeholder="Masukkan hasil Lainnya" class="form-control" rows="5">{{$emr ? $emr->hasil_lainnya : ''}}</textarea>
        `;
    }
  }
</script>
@endsection
