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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/maternitas/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Pengkajian Awal Keperawatan Maternitas</b></h4>
          <br>

          <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                  <td  style="width:40%; font-weight:bold;">
                      Cara Masuk
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[caraMasuk]"
                              {{ @$assesment['caraMasuk'] == 'IGD Ponek' ? 'checked' : '' }}
                              type="radio" value="IGD Ponek" id="crMasuk.1">
                          <label class="form-check-label" for="crMasuk.1">IGD Ponek</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[caraMasuk]"
                              {{ @$assesment['caraMasuk'] == 'Rawat Inap' ? 'checked' : '' }}
                              type="radio" value="Rawat Inap" id="crMasuk.2">
                          <label class="form-check-label" for="crMasuk.2">Rawat Inap</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[caraMasuk]"
                              {{ @$assesment['caraMasuk'] == 'Poli Obgyn' ? 'checked' : '' }}
                              type="radio" value="Poli Obgyn" id="crMasuk.3">
                          <label class="form-check-label" for="crMasuk.3">Poli Obgyn</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[caraMasuk]"
                              {{ @$assesment['caraMasuk'] == 'Langsung, Kamar bersalin' ? 'checked' : '' }}
                              type="radio" value="Langsung, Kamar bersalin" id="crMasuk.4">
                          <label class="form-check-label" for="crMasuk.4">Langsung, Kamar bersalin</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td  style="width:40%; font-weight:bold;">
                      Dokter yang merawat
                  </td>
                  <td style="padding: 5px;">
                      <select name="fisik[dokterPerawat]" class="select2" id="" style="width: 100%;">
                        <option value="" selected>Pilih salah satu</option>
                        @if (@$assesment['dokterPerawat'])
                            @foreach ($dokters as $dokter)
                                <option {{@$assesment['dokterPerawat'] == $dokter->id ? 'selected' : ''}} value="{{$dokter->id}}">{{$dokter->nama}}</option>
                            @endforeach
                        @else
                            @foreach ($dokters as $dokter)
                                <option {{$dokter->id == $reg->dokter_id ? 'selected' : ''}} value="{{$dokter->id}}">{{$dokter->nama}}</option>
                            @endforeach
                        @endif
                      </select>
                  </td>
              </tr>
              <tr>
                  <td  style="width:40%; font-weight:bold;">
                      Bidan / Perawat primer
                  </td>
                  <td style="padding: 5px;">
                      <select name="fisik[perawat]" class="select2" id="" style="width: 100%;" disabled>
                            @if (@$assesment['perawat'])
                                <option value="{{@$assesment['perawat']}}">{{baca_pegawai(@$assesment['perawat'])}}</option>
                            @else
                                <option value="{{Auth::user()->pegawai->id}}">{{Auth::user()->pegawai->nama}}</option>
                            @endif
                      </select>
                  </td>
              </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Keadaan Umum</b></h5>
              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">1. Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][tekanan_darah]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['tekanan_darah']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="number" name="fisik[keadaan_umum][tanda_vital][nadi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="number" name="fisik[keadaan_umum][tanda_vital][RR]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['RR']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][temp]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['temp']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br/>
                  <input type="number" name="fisik[keadaan_umum][tanda_vital][BB]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['BB']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br/>
                  <input type="number" name="fisik[keadaan_umum][tanda_vital][TB]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['TB']}}">
                </td>
              </tr>
              <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">2. Kesadaran</td>
                <td> 
                    <div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][ComposMentis]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['ComposMentis'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Compos Mentis</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Apatis]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Apatis'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Apatis</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Somnolen]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Somnolen'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Somnolen</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Lethargi]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Lethargi'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Lethargi</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Sopor]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Sopor'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Sopor</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Koma]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Koma'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Koma</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][Dellrium]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['Dellrium'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Dellrium</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[keadaan_umum][kesadaran][SemiKoma]"
                            {{ @$assesment['keadaan_umum']['kesadaran']['SemiKoma'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Semi Koma</label>
                        </div>
                    </div>
                </td>
            </tr>
            
            <tr>
              <td rowspan="3" style="width:25%; font-weight:500;" colspan="2">GCS</td>
              <td style="padding: 5px;">
                <label class="form-check-label " style="margin-right: 20px;">E</label>
                <input type="text" name="fisik[keadaan_umum][kesadaran][GCS][E]" style="display:inline-block; width: 100px;" placeholder="E" class="form-control gcs" id="" value="{{@$assesment['keadaan_umum']['kesadaran']['GCS']['E']}}">
              </td>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label "   style="margin-right: 20px;">M</label>
                  <input type="text" name="fisik[keadaan_umum][kesadaran][GCS][M]" style="display:inline-block; width: 100px;" placeholder="M" class="form-control gcs" id="" value="{{@$assesment['keadaan_umum']['kesadaran']['GCS']['M']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label "  style="margin-right: 20px;">V</label>
                    <input type="text" name="fisik[keadaan_umum][kesadaran][GCS][V]" style="display:inline-block; width: 100px;" placeholder="V" class="form-control gcs" id="" value="{{@$assesment['keadaan_umum']['kesadaran']['GCS']['V']}}">
                </td>
              </tr>
              </td>
            </tr>

            <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    3. Asesmen Nyeri
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][tidak]"
                            {{ @$assesment['asesmenNyeri'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak Ada</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][ada]"
                            {{ @$assesment['asesmenNyeri'] == 'Ada' ? 'checked' : '' }}
                            type="radio" value="Ada">
                        <label class="form-check-label">Ada (Lanjut ke deskripsi nyeri)</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td  style=""  colspan="2">
                    Provokatif
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Bantuan' ? 'checked' : '' }}
                            type="radio" value="Bantuan" id="crMasuk.1">
                        <label class="form-check-label">Bantuan</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Spontan' ? 'checked' : '' }}
                            type="radio" value="Spontan" id="crMasuk.2">
                        <label class="form-check-label">Spontan</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Aktivitas' ? 'checked' : '' }}
                            type="radio" value="Aktivitas" id="crMasuk.3">
                        <label class="form-check-label">Aktivitas</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][provokatif]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif'] == 'Lain - lain' ? 'checked' : '' }}
                            type="radio" value="Lain - lain" id="crMasuk.4">
                        <label class="form-check-label">Lain - lain</label>
                        <input name="fisik[keadaan_umum][asesmenNyeri][provokatif_lain]" type="text" class="form-control" placeholder="Isi jika lain-lain" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['provokatif_lain']}}">
                    </div>
                </td>
            </tr>
            <tr>
                <td  style="">
                    Quality
                </td>
                <td style="padding: 5px;">
                    <div style="width: 150px;">
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Seperti tertusuk benda tajam/tumpul' ? 'checked' : '' }}
                            type="radio" value="Seperti tertusuk benda tajam/tumpul" id="crMasuk.1">
                        <label class="form-check-label">Seperti tertusuk benda tajam/tumpul</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Berdenyut' ? 'checked' : '' }}
                            type="radio" value="Berdenyut" id="crMasuk.2">
                        <label class="form-check-label">Berdenyut</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terpelintir' ? 'checked' : '' }}
                            type="radio" value="Terpelintir" id="crMasuk.2">
                        <label class="form-check-label">Terpelintir</label>
                    </div>
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Terbakar' ? 'checked' : '' }}
                            type="radio" value="Terbakar" id="crMasuk.3">
                        <label class="form-check-label">Terbakar</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Tertindih' ? 'checked' : '' }}
                            type="radio" value="Tertindih" id="crMasuk.3">
                        <label class="form-check-label">Tertindih</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][quality]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['quality'] == 'Lain - lain' ? 'checked' : '' }}
                            type="radio" value="Lain - lain" id="crMasuk.4">
                        <label class="form-check-label">Lain - lain</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td  style=""  colspan="2">
                    Region
                </td>
                <td style="padding: 5px;">
                    <div>
                        <label class="form-check-label">Lokasi</label>
                        <input type="text" class="form-control" placeholder="Isi Lokasi" name="fisik[keadaan_umum][asesmenNyeri][region][lokasi]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['lokasi'] }}">
                    </div>
                    <div>
                        <label class="form-check-label">Menyebar</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][tidak]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['tidak'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][ya]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['ya'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input type="text" class="form-control" placeholder="Isi jika Ya" name="fisik[keadaan_umum][asesmenNyeri][region][menyebar][detail_ya]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['region']['menyebar']['detail_ya'] }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td  style=""  colspan="2">
                    Severity
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'NFS, Score' ? 'checked' : '' }}
                            type="radio" value="NFS, Score">
                        <label class="form-check-label">NFS, Score</label>
                        <input type="text" class="form-control" placeholder="NFS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][nfs_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['nfs_score'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'Wong Baker Face, Score' ? 'checked' : '' }}
                            type="radio" value="Wong Baker Face, Score">
                        <label class="form-check-label">Wong Baker Face, Score</label>
                        <input type="text" class="form-control" placeholder="Wong Baker Face, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][wong_baker_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['wong_baker_score'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'NIPS, Score' ? 'checked' : '' }}
                            type="radio" value="NIPS, Score">
                        <label class="form-check-label">NIPS, Score</label>
                        <input type="text" class="form-control" placeholder="NIPS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][nips_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['nips_score'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'FLACCS, Score' ? 'checked' : '' }}
                            type="radio" value="FLACCS, Score">
                        <label class="form-check-label">FLACCS, Score</label>
                        <input type="text" class="form-control" placeholder="FLACCS, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][flaccs_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['flaccs_score'] }}">
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][severity_selected]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['severity_selected'] == 'CPOT, Score' ? 'checked' : '' }}
                            type="radio" value="CPOT, Score">
                        <label class="form-check-label">CPOT, Score</label>
                        <input type="text" class="form-control" placeholder="CPOT, Score" name="fisik[keadaan_umum][asesmenNyeri][severity][cpot_score]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['severity']['cpot_score'] }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td  style=""  colspan="2">
                    Time (Durasi Nyeri)
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input type="text" class="form-control" placeholder="Durasi Nyeri" name="fisik[keadaan_umum][asesmenNyeri][durasi_nyeri]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['durasi_nyeri'] }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td  style=""  colspan="2">
                    Nyeri hilang jika
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang'] == 'Minum obat' ? 'checked' : '' }}
                            type="radio" value="Minum obat">
                        <label class="form-check-label" for="crMasuk.1">Minum obat</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang'] == 'Istirahat' ? 'checked' : '' }}
                            type="radio" value="Istirahat">
                        <label class="form-check-label" for="crMasuk.1">Istirahat</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang'] == 'Berubah posisi' ? 'checked' : '' }}
                            type="radio" value="Berubah posisi">
                        <label class="form-check-label" for="crMasuk.1">Berubah posisi</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang'] == 'Mendengar musik' ? 'checked' : '' }}
                            type="radio" value="Mendengar musik">
                        <label class="form-check-label" for="crMasuk.1">Mendengar musik</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang'] == 'Lain-lain' ? 'checked' : '' }}
                            type="radio" value="Lain-lain">
                        <label class="form-check-label" for="crMasuk.1">Lain-lain</label>
                        <input type="text" class="form-control" placeholder="Isi jika lain-lain" name="fisik[keadaan_umum][asesmenNyeri][nyeriHilang_lain]" value="{{ @$assesment['keadaan_umum']['asesmenNyeri']['nyeriHilang_lain'] }}">
                    </div>
                </td>
            </tr>
            </table>
            <hr style="border: 1px solid black;">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Riwayat Kesehatan</b></h5>
                <tr>
                  <td style="width:50%; font-weight:bold;">1. Keluhan Utama</td>
                    <td style="padding: 5px;">
                      <textarea name="fisik[riwayat_kesehatan][keluhan_utama]" class="form-control" style="resize: vertical; dispay: inline-block;" rows="3">{{ @$assesment['riwayat_kesehatan']['keluhan_utama'] }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="width:50%; font-weight:bold;">2. Riwayat Menstruasi</td>
                </tr>
                <tr>
                  <td>
                    <div>
                      <label class="form-check-label" style="font-weight: 400;" for="crMasuk.1">Umur Menarche (Tahun)</label>
                      <input type="text" class="form-control" placeholder="Tahun" name="fisik[riwayat_kesehatan][riwayat_menstruasi][umur_menarche]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['umur_menarche'] }}">
                  </div>
                  </td>
                  <td>
                    <div>
                      <label class="form-check-label" style="font-weight: 400;" for="crMasuk.1">Lamanya Haid (Hari)</label>
                      <input type="text" class="form-control" placeholder="Hari" name="fisik[riwayat_kesehatan][riwayat_menstruasi][lamanya_haid]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['lamanya_haid'] }}">
                  </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div>
                      <label class="form-check-label" style="font-weight: 400;" for="crMasuk.1">Ganti Pembalut (x/Hari)</label>
                      <input type="text" class="form-control" placeholder="x/Hari" name="fisik[riwayat_kesehatan][riwayat_menstruasi][ganti_pembalut]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['ganti_pembalut'] }}">
                  </div>
                  </td>
                </tr>
                <tr>
                  <td>HPPT</td>
                  <td style="padding: 5px;">
                    <input name="fisik[riwayat_kesehatan][riwayat_menstruasi][hppt]" placeholder="HPPT" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['hppt'] }}">
                  </td>
                </tr>
                <tr>
                  <td>HPL</td>
                  <td style="padding: 5px;">
                    <input name="fisik[riwayat_kesehatan][riwayat_menstruasi][hpl]" placeholder="HPL" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['hpl'] }}">
                  </td>
                </tr>
                <tr>
                  <td  style="">
                      Keluhan
                  </td>
                  <td style="padding: 5px;">
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_menstruasi][keluhan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['keluhan'] == 'Dismonorhoe' ? 'checked' : '' }}
                                type="radio" value="Dismonorhoe">
                            <label class="form-check-label">Dismonorhoe</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_menstruasi][keluhan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['keluhan'] == 'Spotting' ? 'checked' : '' }}
                                type="radio" value="Spotting">
                            <label class="form-check-label">Spotting</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_menstruasi][keluhan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['keluhan'] == 'Menorragia' ? 'checked' : '' }}
                                type="radio" value="Menorragia">
                            <label class="form-check-label">Menorragia</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_menstruasi][keluhan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_menstruasi']['keluhan'] == 'Metrorhagia' ? 'checked' : '' }}
                                type="radio" value="Metrorhagia">
                            <label class="form-check-label">Metrorhagia</label>
                        </div>
                    </td>
                </tr>
                <tr>
                  <td style="width:50%; font-weight:bold;">3. Riwayat Palko Sosial dan Spiritual</td>
                </tr>
                <tr>
                    <td  style="">
                        Status Perkawinan
                    </td>
                    <td style="padding: 5px;">
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_perkawinan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_perkawinan'] == 'Kawin' ? 'checked' : '' }}
                                type="radio" value="Kawin">
                            <label class="form-check-label">Kawin</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_perkawinan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_perkawinan'] == 'Belum Kawin' ? 'checked' : '' }}
                                type="radio" value="Belum Kawin">
                            <label class="form-check-label">Belum Kawin</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_perkawinan]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_perkawinan'] == 'Janda' ? 'checked' : '' }}
                                type="radio" value="Janda">
                            <label class="form-check-label">Janda</label>
                        </div>
                    </td>
                </tr>
                <tr>
                  <td style="width:50%; font-weight:bold;">Jumlah Perkawinan</td>
                </tr>
                <tr>
                  <td  style="">
                      <b>Istri</b>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][istri]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['istri'] == '1x' ? 'checked' : '' }}
                              type="radio" value="1x">
                          <label class="form-check-label" style="font-weight: 400;">1x</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][istri]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['istri'] == '2x' ? 'checked' : '' }}
                              type="radio" value="2x">
                          <label class="form-check-label" style="font-weight: 400;">2x</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][istri]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['istri'] == '>2x' ? 'checked' : '' }}
                              type="radio" value=">2x">
                          <label class="form-check-label" style="font-weight: 400;">>2x</label>
                      </div>
                  </td>
                  <td style="padding: 5px;">
                    <b>Suami</b>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][suami]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['suami'] == '1x' ? 'checked' : '' }}
                            type="radio" value="1x">
                        <label class="form-check-label" style="font-weight: 400;">1x</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][suami]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['suami'] == '2x' ? 'checked' : '' }}
                            type="radio" value="2x">
                        <label class="form-check-label" style="font-weight: 400;">2x</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][jumlah_perkawinan][suami]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['jumlah_perkawinan']['suami'] == '>2x' ? 'checked' : '' }}
                            type="radio" value=">2x">
                        <label class="form-check-label" style="font-weight: 400;">>2x</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td>Usia Perkawinan</td>
                <td style="padding: 5px;">
                  <input name="fisik[riwayat_kesehatan][riwayat_palko_sosial][usia_perkawinan]" placeholder="Tahun" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['usia_perkawinan'] }}">
                </td>
              </tr>
              <tr>
                <td>Keluarga Terdekat
                  <input name="fisik[riwayat_kesehatan][riwayat_palko_sosial][keluarga_terdekat]" placeholder="Nama Keluarga" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['keluarga_terdekat'] }}">
                </td>
                <td style="padding: 5px;">
                  Hubungan
                  <input name="fisik[riwayat_kesehatan][riwayat_palko_sosial][hubungan]" placeholder="Hubungan Keluarga" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['hubungan'] }}">
                </td>
              </tr>
              <tr>
                <td  style="">
                    Tinggal Dengan
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan'] == 'Orang Tua' ? 'checked' : '' }}
                            type="radio" value="Orang Tua">
                        <label class="form-check-label">Orang Tua</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan'] == 'Suami Istri' ? 'checked' : '' }}
                            type="radio" value="Suami Istri">
                        <label class="form-check-label">Suami Istri</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan'] == 'Anak' ? 'checked' : '' }}
                            type="radio" value="Anak">
                        <label class="form-check-label">Anak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan'] == 'Sendiri' ? 'checked' : '' }}
                            type="radio" value="Sendiri">
                        <label class="form-check-label">Sendiri</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan'] == 'Lainnya' ? 'checked' : '' }}
                            type="radio" value="Lainnya">
                        <label class="form-check-label" aria-placeholder="">Lainnya</label>
                        <input type="text" class="form-control" placeholder="Lainnya...." name="fisik[riwayat_kesehatan][riwayat_palko_sosial][tinggal_dengan_lainya]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['tinggal_dengan_lainya'] }}">
                    </div>
                </td>
              </tr>
              <tr>
                <td  style="">
                    Curiga Penganiayaan/Penelantaran
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][kecurigaan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['kecurigaan'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][kecurigaan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['kecurigaan'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td>Kegiatan Ibadah</td>
                <td style="padding: 5px;">
                  <input name="fisik[riwayat_kesehatan][riwayat_palko_sosial][kegiatan_ibadah]" placeholder="Kegiatan Ibadah" class="form-control" style="resize: vertical; dispay: inline-block;" value="{{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['kegiatan_ibadah'] }}">
                </td>
              </tr>
              <tr>
                <td  style="">
                    Status Emosional
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Normal' ? 'checked' : '' }}
                            type="radio" value="Normal">
                        <label class="form-check-label">Normal</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Tidak Semangat' ? 'checked' : '' }}
                            type="radio" value="Tidak Semangat">
                        <label class="form-check-label">Tidak Semangat</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Tertekan' ? 'checked' : '' }}
                            type="radio" value="Tertekan">
                        <label class="form-check-label">Tertekan</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Depresi' ? 'checked' : '' }}
                            type="radio" value="Depresi">
                        <label class="form-check-label">Depresi</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Cemas' ? 'checked' : '' }}
                            type="radio" value="Cemas">
                        <label class="form-check-label">Cemas</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_palko_sosial][status_emosional]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_palko_sosial']['status_emosional'] == 'Sulit Tidur' ? 'checked' : '' }}
                            type="radio" value="Sulit Tidur">
                        <label class="form-check-label">Sulit Tidur</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;">4. Riwayat Kehamilan Persalinan dan Nifas</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label " style="margin-right: 20px;">G</label>
                  <input type="text" name="fisik[riwayat_kesehatan][riwayat_kehamilan][G]" style="display:inline-block; width: 100px;" placeholder="G" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['riwayat_kehamilan']['G']}}">
                </td>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "   style="margin-right: 20px;">P</label>
                    <input type="text" name="fisik[riwayat_kesehatan][riwayat_kehamilan][P]" style="display:inline-block; width: 100px;" placeholder="P" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['riwayat_kehamilan']['P']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "  style="margin-right: 20px;">A</label>
                      <input type="text" name="fisik[riwayat_kesehatan][riwayat_kehamilan][A]" style="display:inline-block; width: 100px;" placeholder="H" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['riwayat_kehamilan']['A']}}">
                  </td>
                </tr>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;">5. Riwayat Hamil Ini</td>
              </tr>
              <tr>
                <td  style="">
                    TM I
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_1]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_1'] == 'Mual' ? 'checked' : '' }}
                            type="radio" value="Mual">
                        <label class="form-check-label">Mual</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_1]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_1'] == 'Muntah' ? 'checked' : '' }}
                            type="radio" value="Muntah">
                        <label class="form-check-label">Muntah</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_1]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_1'] == 'Perdarahan' ? 'checked' : '' }}
                            type="radio" value="Perdarahan">
                        <label class="form-check-label">Perdarahan</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_1]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_1'] == 'Lain-lain TT I' ? 'checked' : '' }}
                            type="radio" value="Lain-lain TT I">
                        <label class="form-check-label">Lain-lain TT I</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td  style="">
                    TM II - III
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_2]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_2'] == 'Pusing' ? 'checked' : '' }}
                            type="radio" value="Pusing">
                        <label class="form-check-label">Pusing</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_2]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_2'] == 'Sakit Kepala' ? 'checked' : '' }}
                            type="radio" value="Sakit Kepala">
                        <label class="form-check-label">Sakit Kepala</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_2]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_2'] == 'Perdarahan' ? 'checked' : '' }}
                            type="radio" value="Perdarahan">
                        <label class="form-check-label">Perdarahan</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_hamil_ini][tm_2]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_hamil_ini']['tm_2'] == 'Lain-lain TT I' ? 'checked' : '' }}
                            type="radio" value="Lain-lain TT I">
                        <label class="form-check-label">Lain-lain TT I</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;">6. Aktivitas Sehari hari dirumah</td>
              </tr>
              <tr>
                <td  style="font-weight: bold;">
                    a. Eliminasi
                </td>
              </tr>
              <tr>
                <td>1. Miksi
                  <div>
                    <input type="text" class="form-control" placeholder="x/Hari" name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][miksi]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['miksi'] }}">
                  </div>
                  Ada Kesukaran
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][miksi_kesukaran]"
                          {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['miksi_kesukaran'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label" aria-placeholder="">Tidak</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][miksi_kesukaran]"
                          {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['miksi_kesukaran'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label" aria-placeholder="">Ya</label>
                      <input type="text" class="form-control" placeholder="Isi jika ya" name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][miksi_kesukaran_ya]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['miksi_kesukaran_ya'] }}">
                  </div>
                </td>
                <td>2. Defeksi
                  <div>
                    <input type="text" class="form-control" placeholder="x/Hari" name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][defeksi]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['defeksi'] }}">
                  </div>
                  Ada Kesukaran
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][defeksi_kesukaran]"
                          {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['defeksi_kesukaran'] == 'Lainnya' ? 'checked' : '' }}
                          type="radio" value="Lainnya">
                      <label class="form-check-label" aria-placeholder="">Tidak</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_kesehatan][aktivitas_sehari][eliminasi][defeksi_kesukaran]"
                          {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['eliminasi']['defeksi_kesukaran'] == 'Lainnya' ? 'checked' : '' }}
                          type="radio" value="Lainnya">
                      <label class="form-check-label" aria-placeholder="">Ya</label>
                      <input type="text" class="form-control" placeholder="Isi jika ya" name="fisik[riwayat_kesehatan][aktivitas_sehari][defeksi_kesukaran_ya]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['defeksi_kesukaran_ya'] }}">
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="font-weight: bold;">
                    b. Makan
                    <input type="text" class="form-control" placeholder="x/Hari" name="fisik[riwayat_kesehatan][aktivitas_sehari][makan]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['makan'] }}">
                </td>
                <td  style="font-weight: bold;">
                    Nafsu Makan
                    <div>
                      <input class="form-check-input"
                          name="fisik[riwayat_kesehatan][aktivitas_sehari][nafsu_makan]"
                          {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['nafsu_makan'] == 'Baik' ? 'checked' : '' }}
                          type="radio" value="Baik">
                      <label class="form-check-label">Baik</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][nafsu_makan]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['nafsu_makan'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td  style="">
                    Porsi Makan Habis
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][porsi_makan]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['porsi_makan'] == '1 Porsi' ? 'checked' : '' }}
                            type="radio" value="1 Porsi">
                        <label class="form-check-label">1 Porsi</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][porsi_makan]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['porsi_makan'] == '1/2 Porsi' ? 'checked' : '' }}
                            type="radio" value="1/2 Porsi">
                        <label class="form-check-label">1/2 Porsi</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][porsi_makan]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['porsi_makan'] == '1/4 Porsi' ? 'checked' : '' }}
                            type="radio" value="1/4 Porsi">
                        <label class="form-check-label">1/4 Porsi</label>
                    </div>
                  </td>
              </tr>
              <tr>
                <td>
                  Nutrisi Lain
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Nutrisi Lain" name="fisik[riwayat_kesehatan][aktivitas_sehari][nutrisi_lain]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['nutrisi_lain'] }}">
                </td>
              </tr>
              <tr>
                <td  style="font-weight: bold;">
                    c. Personal Hvaiene
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label " style="margin-right: 20px; font-weight: 400;">Mandi</label>
                  <input type="text" name="fisik[riwayat_kesehatan][aktivitas_sehari][personal][mandi]" style="display:inline-block; width: 100px;" placeholder="x/Hari" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['aktivitas_sehari']['personal']['mandi']}}">
                </td>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "   style="margin-right: 20px; font-weight: 400;">Cuci Rambut</label>
                    <input type="text" name="fisik[riwayat_kesehatan][aktivitas_sehari][personal][cuci_rambut]" style="display:inline-block; width: 100px;" placeholder="x/Minggu" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['aktivitas_sehari']['personal']['cuci_rambut']}}">
                  </td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                  <label class="form-check-label "  style="margin-right: 20px; font-weight: 400;">Menggosok Gigi</label>
                      <input type="text" name="fisik[riwayat_kesehatan][aktivitas_sehari][personal][gosok_gigi]" style="display:inline-block; width: 100px;" placeholder="x/Hari" class="form-control gcs" id="" value="{{@$assesment['riwayat_kesehatan']['aktivitas_sehari']['personal']['gosok_gigi']}}">
                  </td>
                </tr>
                <tr>
                  <td  style="font-weight: bold;">
                      d. Kebiasaan merokok/Alkohol
                  </td>
                    <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][aktivitas_sehari][kebiasaan_merokok]"
                              {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['kebiasaan_merokok'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][aktivitas_sehari][kebiasaan_merokok]"
                              {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['kebiasaan_merokok'] == 'Ya, berapa kali' ? 'checked' : '' }}
                              type="radio" value="Ya, berapa kali">
                          <label class="form-check-label">Ya, berapa kali</label>
                          <input type="text" class="form-control" placeholder="Berapa kali" name="fisik[riwayat_kesehatan][aktivitas_sehari][kebiasaan_merokok_ya]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['kebiasaan_merokok_ya'] }}">
                      </div>
                  </td>
                </tr>
                <tr>
                  <td  style="font-weight: bold;">
                      e. Senam Hamil
                  </td>
                    <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][aktivitas_sehari][senam_hamil]"
                              {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['senam_hamil'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label">Tidak</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][aktivitas_sehari][senam_hamil]"
                              {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['senam_hamil'] == 'Ya, dimana' ? 'checked' : '' }}
                              type="radio" value="Ya, dimana">
                          <label class="form-check-label">Ya, dimana</label>
                          <input type="text" class="form-control" placeholder="dimana" name="fisik[riwayat_kesehatan][aktivitas_sehari][senam_hamil_ya]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['senam_hamil_ya'] }}">
                      </div>
                  </td>
                </tr>
                <tr>
                  <td  style="font-weight: bold;">
                      f. Hubungan Seksual
                  </td>
                  <td>
                    <input type="text" class="form-control" placeholder="Berapa kali" name="fisik[riwayat_kesehatan][aktivitas_sehari][hubungan_seksual][brp_kali]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['hubungan_seksual']['brp_kali'] }}">
                  </td>
                </tr>
                <tr>
                  <td  style="font-weight: bold;">
                      g. Tidur/istirahat berapa jam/hari
                  </td>
                  <td>
                    <input type="text" class="form-control" placeholder="jam/hari" name="fisik[riwayat_kesehatan][aktivitas_sehari][tidur]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['tidur'] }}">
                  </td>
                </tr>
                <tr>
                  <td>Miring</td>
                  <td>
                    <input type="text" class="form-control" placeholder="miring" name="fisik[riwayat_kesehatan][aktivitas_sehari][tidur_miring]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['tidur_miring'] }}">
                  </td>
                </tr>
                <tr>
                  <td>Pakai bantal</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][tidur_pakai_bantal]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['tidur_pakai_bantal'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][aktivitas_sehari][tidur_pakai_bantal]"
                            {{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['tidur_pakai_bantal'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Bila sukar tidur, apa yang dilakukan</td>
                  <td>
                    <input type="text" class="form-control" placeholder="jelaskan" name="fisik[riwayat_kesehatan][aktivitas_sehari][sukar_tidur]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['sukar_tidur'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="width:50%; font-weight:bold;">7. Riwayat kesehatan masa lalu dan keluarga</td>
                </tr>
                <tr>
                  <td>Apakah pasien pernah sakit</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_sakit]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_sakit'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_sakit]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_sakit'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input type="text" class="form-control" placeholder="Bila ya, sakit apa" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_sakit_ya]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_sakit_ya'] }}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Rumah sakit mana dan kapan</td>
                  <td>
                    <input type="text" class="form-control" placeholder="Rumah sakit mana dan kapan" name="fisik[riwayat_kesehatan][aktivitas_sehari][rumah_sakit_mana]" value="{{ @$assesment['riwayat_kesehatan']['aktivitas_sehari']['rumah_sakit_mana'] }}">
                  </td>
                </tr>
                <tr>
                  <td>Apakah pernah operasi</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_operasi]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_operasi'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_operasi]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_operasi'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][pernah_operasi_ya]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['pernah_operasi_ya'] }}">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Ada obat rutin yang digunakan</td>
                  <td>
                    <div>
                      <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat_rutin_digunakan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat_rutin_digunakan'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat_rutin_digunakan]"
                            {{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat_rutin_digunakan'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input type="text" class="form-control" placeholder="Jelaskan" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat_rutin_digunakan_ya]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat_rutin_digunakan_ya'] }}">
                    </div>
                  </td>
                </tr>
                <tr>
                    <td  style="">
                        Obat Apa
                    </td>
                    <td style="padding: 5px;">
                      <input type="text" class="form-control" placeholder="Obat Apa" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat][nama]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat']['nama'] }}">
                        <div>
                            <label class="form-check-label">Mulai</label>
                            <input type="text" class="form-control" placeholder="Mulai" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat][mulai]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat']['mulai'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Sampai</label>
                            <input type="text" class="form-control" placeholder="Sampai" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat][sampai]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat']['sampai'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Berapa kali</label>
                            <input type="text" class="form-control" placeholder="Berapa kali" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][obat][berapa_kali]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['obat']['berapa_kali'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                  <td>Riwayat kesehatan keluarga</td>
                  <td>
                    <input type="text" class="form-control" placeholder="Riwayat kesehatan keluarga" name="fisik[riwayat_kesehatan][riwayat_masa_lalu][riwayat_kesehatan_keluarga]" value="{{ @$assesment['riwayat_kesehatan']['riwayat_masa_lalu']['riwayat_kesehatan_keluarga'] }}">
                  </td>
                </tr>
                <tr>
                  <td  style="font-weight:bold;">
                      8. Riwayat penyakit keluarga (Ayah, Ibu, Adik, Paman, Bibi)
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][kanker]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['kanker'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Kanker</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][penyakit_hati]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['penyakit_hati'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Penyakit Hati</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][hipertensi]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['hipertensi'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Hipertensi</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][dm]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['dm'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">DM</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][ginjal]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['ginjal'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Penyakit Ginjal</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][penyakit_jiwa]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['penyakit_jiwa'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Penyakit jiwa</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][kelainan]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['kelainan'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Kelainan bawaan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][hamil_kembar]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['hamil_kembar'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Hamil kembar</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][tbc]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['tbc'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">TBC</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][epilepsi]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['epilepsi'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Epilepsi</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_penyakit_keluarga][riwayat_penyakit][alergi]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_penyakit_keluarga']['riwayat_penyakit']['alergi'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Alergi</label>
                      </div>
                    </td>
                </tr>
                <tr>
                  <td  style="font-weight:bold;">
                    9. Riwayat Gynekologi
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][Infertilitasi]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['Infertilitasi'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Infertilitasi</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][infeksi_virus]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['infeksi_virus'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Infeksi virus</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][pms]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['pms'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">PMS</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][cervicttis]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['cervicttis'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Cervicttis Chronic</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][Endometriosis]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['Endometriosis'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Endometriosis</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][Myoma]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['Myoma'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Myoma</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][polyp]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['polyp'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Polyp Servix</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][kanker_kandungan]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['kanker_kandungan'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Kanker Kandungan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][operasi_kandungan]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['operasi_kandungan'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Operasi Kandungan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][perkosaan]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['perkosaan'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Perkosaan</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit][lain]"
                              {{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit']['lain'] == 'true' ? 'checked' : '' }}
                              type="checkbox" value="true">
                          <label class="form-check-label">Lain-lain</label>
                        <input name="fisik[riwayat_kesehatan][riwayat_gynekologi][riwayat_penyakit_lain]" type="text" class="form-control" placeholder="Isi jika lain-lain" value="{{ @$assesment['riwayat_kesehatan']['riwayat_gynekologi']['riwayat_penyakit_lain']}}">
                      </div>
                    </td>
                </tr>
                <tr>
                  <td  style="font-weight:bold;">
                    10. Riwayat Keluarga Berencana
                  </td>
                </tr>
                <tr>
                  <td  style="">
                      Metode KB yang terakhir
                  </td>
                  <td style="padding: 5px;">
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'Pil KB' ? 'checked' : '' }}
                                type="radio" value="Pil KB">
                            <label class="form-check-label">Pil KB</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'Suntik' ? 'checked' : '' }}
                                type="radio" value="Suntik">
                            <label class="form-check-label">Suntik</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'IUD' ? 'checked' : '' }}
                                type="radio" value="IUD">
                            <label class="form-check-label">IUD</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'MOW / MOP' ? 'checked' : '' }}
                                type="radio" value="MOW / MOP">
                            <label class="form-check-label">MOW / MOP</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'MD' ? 'checked' : '' }}
                                type="radio" value="MD">
                            <label class="form-check-label">MD</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][metode_kb_terakhir]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['metode_kb_terakhir'] == 'Lain - lain' ? 'checked' : '' }}
                                type="radio" value="Lain - lain">
                            <label class="form-check-label">Lain - lain</label>
                        </div>
                    </td>
                </tr>
                <tr>
                  <td  style="">
                      Komplikasi dari KB
                  </td>
                  <td style="padding: 5px;">
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][komplikasi_kb]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['komplikasi_kb'] == 'Perdarahan' ? 'checked' : '' }}
                                type="radio" value="Perdarahan">
                            <label class="form-check-label">Perdarahan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][komplikasi_kb]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['komplikasi_kb'] == 'PID/Radang Panggul' ? 'checked' : '' }}
                                type="radio" value="PID/Radang Panggul">
                            <label class="form-check-label">PID/Radang Panggul</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kesehatan][riwayat_kb][komplikasi_kb]"
                                {{ @$assesment['riwayat_kesehatan']['riwayat_kb']['komplikasi_kb'] == 'Lain - lain' ? 'checked' : '' }}
                                type="radio" value="Lain - lain">
                            <label class="form-check-label">Lain - lain</label>
                        </div>
                    </td>
                </tr>
                <tr>
                  <td  style="font-weight:bold;">
                    11. Psikososial
                  </td>
                </tr>
                <tr>
                  <td  style="">
                      Penerimaan klien terhadap kehamilan ini
                  </td>
                  <td>
                    <input name="fisik[riwayat_kesehatan][psikososial][penerimaan_klien]" type="text" class="form-control" placeholder="Penerimaan klien terhadap kehamilan ini" value="{{ @$assesment['riwayat_kesehatan']['psikososial']['penerimaan_klien']}}">
                  </td>
                </tr>
                <tr>
                  <td  style="">
                      Sosial support dari
                  </td>
                  <td style="padding: 5px;">
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][psikososial][sosial_support]"
                              {{ @$assesment['riwayat_kesehatan']['psikososial']['sosial_support'] == 'Suami' ? 'checked' : '' }}
                              type="radio" value="Suami">
                          <label class="form-check-label">Suami</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][psikososial][sosial_support]"
                              {{ @$assesment['riwayat_kesehatan']['psikososial']['sosial_support'] == 'Orang lain' ? 'checked' : '' }}
                              type="radio" value="Orang lain">
                          <label class="form-check-label">Orang lain</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][psikososial][sosial_support]"
                              {{ @$assesment['riwayat_kesehatan']['psikososial']['sosial_support'] == 'Mertua' ? 'checked' : '' }}
                              type="radio" value="Mertua">
                          <label class="form-check-label">Mertua</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[riwayat_kesehatan][psikososial][sosial_support]"
                              {{ @$assesment['riwayat_kesehatan']['psikososial']['sosial_support'] == 'Keluarga lain' ? 'checked' : '' }}
                              type="radio" value="Keluarga lain">
                          <label class="form-check-label">Keluarga lain</label>
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
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Pemeriksaan Fisik</b></h5>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">1. Kepala Mata</td>
                    <td> 
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][pandangan_kabur]"
                            {{ @$assesment['pemeriksaan_fisik']['kepala']['pandangan_kabur'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Pandangan Kabur</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][Berkunang]"
                            {{ @$assesment['pemeriksaan_fisik']['kepala']['Berkunang'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Berkunang-kunang</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][Sklera]"
                            {{ @$assesment['pemeriksaan_fisik']['kepala']['Sklera'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Sklera</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][kepala][Conjungtiva]"
                            {{ @$assesment['pemeriksaan_fisik']['kepala']['Conjungtiva'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Conjungtiva</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">2. Dada dan Axila</td>
                    <td> 
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][dada_dan_axila][MamaeSymetris]"
                            {{ @$assesment['pemeriksaan_fisik']['dada_dan_axila']['MamaeSymetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Mamae symetris / asimetris</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][dada_dan_axila][Areola]"
                            {{ @$assesment['pemeriksaan_fisik']['dada_dan_axila']['Areola'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Areola Hiperpigmentasi</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][dada_dan_axila][PutingSusuMenonjol]"
                            {{ @$assesment['pemeriksaan_fisik']['dada_dan_axila']['PutingSusuMenonjol'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Puting susu menonjol</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][dada_dan_axila][Tumor]"
                            {{ @$assesment['pemeriksaan_fisik']['dada_dan_axila']['Tumor'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Tumor</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][dada_dan_axila][Pengeluaran]"
                            {{ @$assesment['pemeriksaan_fisik']['dada_dan_axila']['Pengeluaran'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Pengeluaran</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">3. Pemeriksaan khusus dan nifas</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">a. Obstretic</td>
                </tr>
                <tr>
                    <td>Abdomen</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Inspeksi</td>
                    <td> 
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][Membesar]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['Membesar'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Membesar dengan arah memanjang</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][Lineaalba]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['Lineaalba'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Linea alba</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][Lineanigra]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['Lineanigra'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Linea Nigra</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][striaelivida]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['striaelivida'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Striae livida</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][striaealbican]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['striaealbican'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Striae albican</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][lukabekasoperasi]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['lukabekasoperasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Luka bekas operasi</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi][lain_lain]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi']['lain_lain'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Lain-lain</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Palpasi TFU (cm)
                        <div>
                            <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][palpasi_tfu]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['palpasi_tfu'] }}">
                        </div>
                    </td>
                    <td> 
                        <div >
                            <label class="form-check-label">Leopold I</label>
                            <input type="text" class="form-control" placeholder="Leopold I" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][leopold1]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['leopold1'] }}">
                        </div>
                        <div >
                            <label class="form-check-label">Leopold II</label>
                            <input type="text" class="form-control" placeholder="Leopold II" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][leopold2]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['leopold2'] }}">
                        </div>
                        <div >
                            <label class="form-check-label">Leopold III</label>
                            <input type="text" class="form-control" placeholder="Leopold III" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][leopold3]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['leopold3'] }}">
                        </div>
                        <div >
                            <label class="form-check-label">Leopold IV</label>
                            <input type="text" class="form-control" placeholder="Leopold IV" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][leopold4]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['leopold4'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Persentasi</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][palpasi_tfu]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['palpasi_tfu'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Punggung</td>
                    <td> 
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][punggung][Nyeri_tekan]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['punggung']['Nyeri_tekan'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Nyeri tekan</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][punggung][Benjolan]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['punggung']['Benjolan'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Benjolan</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][punggung][Cekungan]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['punggung']['Cekungan'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Cekungan</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][punggung][lain_lain]"
                            {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['punggung']['lain_lain'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Lain-lain</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Taksiran berat janin</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="gram" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][taksiran_berat_janin]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['taksiran_berat_janin'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Auskulasi</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="djj/mnt" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][Auskulasi]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['Auskulasi'] }}">
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][Auskulasi_teratur]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['Auskulasi_teratur'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Teratur</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][Auskulasi_teratur]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['Auskulasi_teratur'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak Teratur</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Begian terendah</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="/s" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][begian]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['begian'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">His / Kontraksi</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Kontraksi" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][kontraksi]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['kontraksi'] }}">
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][kontraksi_pilihan]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['kontraksi_pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Teratur</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][kontraksi_pilihan]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['kontraksi_pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak Teratur</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Inspeksi</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Inspeksi" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][inspeksi]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['inspeksi'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Periksa Dalam</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Periksa Dalam" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][periksa_dalam]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['periksa_dalam'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Pengeluaran pervaginam</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Pengeluaran Pervaginam" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][pengeluaran_pervaginam]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['pengeluaran_pervaginam'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Kesan Panggul</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Kesan Panggul" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][obstretic][kesan_panggul]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['obstretic']['kesan_panggul'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">b. Gynekologi</td>
                </tr>
                <tr>
                    <td>Anc Genital</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Inpeksi Pengeluaran Pervaginam</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Inspeksi Pengeluaran Pervaginam" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][inspeksi_pengeluaran_pervaginam]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['inspeksi_pengeluaran_pervaginam'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Inspekuio</td>
                    <td>
                        <div>
                            <label class="form-check-label">Vagina</label>
                            <input type="text" class="form-control" placeholder="Vagina" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][vagina]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['vagina'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Portio</label>
                            <input type="text" class="form-control" placeholder="Portio" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][portio]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['portio'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Vagina toucher</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Vagina toucher" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][vagina_toucher]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['vagina_toucher'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Kesan Panggul</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Kesan Panggul" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][kesan_panggul]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['kesan_panggul'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Imbang foto pelvic</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Imbang foto pelvic" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][gynekologi][imbang]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['gynekologi']['imbang'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">C. Nifas</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Payudara</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Payudara" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][payudara]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['payudara'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">TFU</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="TFU" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][tfu]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['tfu'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Kontraksi ut</label>
                            <input type="text" class="form-control" placeholder="Kontraksi ut" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][kontraksi_ut]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['kontraksi_ut'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Lochea</label>
                            <input type="text" class="form-control" placeholder="Lochea" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][lochea]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['lochea'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Luka jalan lahir</td>
                    <td>
                        <div>
                            <input type="text" class="form-control" placeholder="Luka jalan lahir" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][luka_jalan_lahir]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['luka_jalan_lahir'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Luka post operasi</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][luka_post_operasi]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['luka_post_operasi'] == 'SC' ? 'checked' : '' }}
                                type="radio" value="SC">
                            <label class="form-check-label">SC</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][luka_post_operasi]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['luka_post_operasi'] == 'Histerectomy' ? 'checked' : '' }}
                                type="radio" value="Histerectomy">
                            <label class="form-check-label">Histerectomy</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][luka_post_operasi]"
                                {{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['luka_post_operasi'] == 'Lain-lain' ? 'checked' : '' }}
                                type="radio" value="Lain-lain">
                            <label class="form-check-label">Lain-lain</label>
                            <input type="text" class="form-control" placeholder="Lain-lain" name="fisik[pemeriksaan_fisik][pemeriksaan_khusus_dan_nifas][nifas][luka_post_operasi_lain]" value="{{ @$assesment['pemeriksaan_fisik']['pemeriksaan_khusus_dan_nifas']['nifas']['luka_post_operasi_lain'] }}">
                        </div>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Penilaian Risiko Jatuh Pada Pasien Dewasa dan Lansia</b></h5>
                <thead>
                    <tr>
                        <th style="width: 150px;">Risiko</th>
                        <th>Skala</th>
                        <th style="width: 100px;">Tgl/jam</th>
                        <th style="width: 100px;">Tgl/jam</th>
                        <th style="width: 100px;">Tgl/jam</th>
                        <th style="width: 100px;">Tgl/jam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2">Riwayat jatuh yang baru atau dalam bulan terakhir</td>
                        <td rowspan="2">
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Ya (25)</label>
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak (0)</label>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['tidak_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][riwayat_jatuh_baru][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['riwayat_jatuh_baru']['ya_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Diagnosa medis sekunder > 1</td>
                        <td rowspan="2">
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Ya (15)</label>
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak (0)</label>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['tidak_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][diagnosa_medis_sekunder][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['diagnosa_medis_sekunder']['ya_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Alat bantu jalan :
                            <ul>
                                <li>Bed rest / dibantu perawat</li>
                                <li>Penopang, tongkat / walker</li>
                                <li>Fumiture</li>
                            </ul>
                        </td>
                        <td rowspan="2">
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['pilihan'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                            <label class="form-check-label">0</label><br><br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['pilihan'] == '15' ? 'checked' : '' }}
                                type="radio" value="15">
                            <label class="form-check-label">15</label><br><br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['pilihan'] == '30' ? 'checked' : '' }}
                                type="radio" value="30">
                            <label class="form-check-label">30</label>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['tidak_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][alat_bantu_jalan][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['alat_bantu_jalan']['ya_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Memakai terapi heparin lock / IV</td>
                        <td rowspan="2">
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label">Ya (25)</label>
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label">Tidak (0)</label>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['ya_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][memakai_terapi_heparin][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['memakai_terapi_heparin']['tidak_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Cara berjalan / berpindah :
                            <ul>
                                <li>/Normal / bed rest / Imobilisasi</li>
                                <li>Lemah</li>
                                <li>Terganggu</li>
                            </ul>
                        </td>
                        <td rowspan="2">
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['pilihan'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                            <label class="form-check-label">0</label><br><br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['pilihan'] == '15' ? 'checked' : '' }}
                                type="radio" value="15">
                            <label class="form-check-label">15</label><br><br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['pilihan'] == '30' ? 'checked' : '' }}
                                type="radio" value="30">
                            <label class="form-check-label">30</label>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['tidak_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][cara_berjalan][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['cara_berjalan']['ya_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Status mental :
                            <ul>
                                <li>Orientasi sesuai kemampuan diri</li>
                                <li>Lupa keterbatasan diri</li>
                            </ul>
                        </td>
                        <td rowspan="2">
                            <br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][status_mental][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['status_mental']['pilihan'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                            <label class="form-check-label">0</label><br><br>
                            <input class="form-check-input"
                                name="fisik[penilaian_resiko_jatuh][status_mental][pilihan]"
                                {{ @$assesment['penilaian_resiko_jatuh']['status_mental']['pilihan'] == '15' ? 'checked' : '' }}
                                type="radio" value="15">
                            <label class="form-check-label">15</label><br>
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][tidak_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['tidak_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][tidak_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['tidak_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][tidak_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['tidak_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][tidak_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['tidak_tgl4']}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][ya_tgl1]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['ya_tgl1']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][ya_tgl2]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['ya_tgl2']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][ya_tgl3]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['ya_tgl3']}}">
                        </td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][status_mental][ya_tgl4]" placeholder="Tgl/jam" type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['status_mental']['ya_tgl4']}}">
                        </td>
                    </tr>

                    <tr>
                        <td>Total</td>
                        <td>
                            <input class="form-control"
                                name="fisik[penilaian_resiko_jatuh][total_skala]"
                                type="text" value="{{ @$assesment['penilaian_resiko_jatuh']['total_skala']}}" placeholder="Total">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="width: 50%; font-weight:bold;">Keterangan</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width: 50%; font-weight:bold;">
                            <ul>
                                <li>Skor 0 - 24 : Tidak berisiko</li>
                                <li>Skor 25 - 50 : Risiko Rendah</li>
                                <li>Skor > 51 : Risiko Tinggi</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Skrining Nutrisi Dewasa</b></h5>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight:bold;">Skrining kehamilan dan nifas (Berdasarkan sumber: RSCM)</td>
                </tr>
                <tr>
                    <td colspan="2">1. Apakah asupan makan berkurang, karena tidak nafsu makan?</td>
                    <td style="vertical-align: middle; width: 20%;">
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter1'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter1'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">2. Ada gangguan metabolisme (DM, gangguan fungsi tiroid, infeksi kronis, seperti HIV/AIDS, TB, Lupus, Lain-lain)</td>
                    <td style="vertical-align: middle; width: 20%;">
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter2'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                        <input type="text" class="form-control" placeholder="Sebutkan jika lain-lain" name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2_lain]" value="{{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter2_lain'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">3. Ada penambahan berat badan yang kurang atau lebih selama kehamilan?</td>
                    <td style="vertical-align: middle; width: 20%;">
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter3'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">4. Nilai Hb < 10 g/dl atau HCT < 30%</td>
                    <td style="vertical-align: middle; width: 20%;">
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter4'] == 'Ya' ? 'checked' : '' }}
                            type="radio" value="Ya">
                        <label class="form-check-label">Ya</label>
                        <input required class="form-check-input"
                            name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['skrining_kehamilan_dan_nifas']['parameter4'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%; font-weight:bold;">Total Skor</td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%; font-weight:bold;">
                        <ul>
                            <li>Jika jawaban ya 1 s/d 3 rujuk ke dietisien</li>
                            <li>Jika jawaban ya > 3, rujuk ke Dokter Spesialis Gizi Klinik</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Berat Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][berat_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan'] == 'Berat badan sangat kurang' ? 'selected' : '' }} value="Berat badan sangat kurang">Berat badan sangat kurang <b>(<-3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan'] == 'Berat badan kurang' ? 'selected' : '' }} value="Berat badan kurang">Berat badan kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan'] == 'Berat badan normal' ? 'selected' : '' }} value="Berat badan normal">Berat badan normal <b>(-2 sd +1)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan'] == 'Risiko berat badan lebih' ? 'selected' : '' }} value="Risiko berat badan lebih">Risiko berat badan lebih <b>(>+1)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Panjang Badan atau Tinggi Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][panjang_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['panjang_badan'] == 'Sangat pendek' ? 'selected' : '' }} value="Sangat pendek">Sangat pendek <b>(<-3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['panjang_badan'] == 'Pendek' ? 'selected' : '' }} value="Pendek">Pendek <b>(-3 sd <-2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['panjang_badan'] == 'Normal' ? 'selected' : '' }} value="Normal">Normal <b>(-2 sd +3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['panjang_badan'] == 'Tinggi' ? 'selected' : '' }} value="Tinggi">Tinggi <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Berat Badan Menurut Panjang Badan Atau Tinggi Badan <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][berat_badan_menurut_tinggi_badan]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Gizi buruk' ? 'selected' : '' }} value="Gizi buruk">Gizi buruk <b>(<-3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Berisiko gizi lebih' ? 'selected' : '' }} value="Berisiko gizi lebih">Berisiko gizi lebih <b>(>+1 sd +2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(>+2 sd +3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['berat_badan_menurut_tinggi_badan'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][imt_bayi]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Gizi buruk' ? 'selected' : '' }} value="Gizi buruk">Gizi buruk <b>(<-3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Berisiko gizi lebih' ? 'selected' : '' }} value="Berisiko gizi lebih">Berisiko gizi lebih <b>(>+1 sd +2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(>+2 sd +3)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_bayi'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+3)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 5 - 18 tahun</b></td>
                    <td colspan="2" style="padding: 5px;">
                        <select style="width: 100%;" name="fisik[skrining_nutrisi_dewasa][imt_anak]" class="select2">
                            <option value="" selected disabled>-- Pilih salah satu --</option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_anak'] == 'Gizi kurang' ? 'selected' : '' }} value="Gizi kurang">Gizi kurang <b>(-3 sd <-2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_anak'] == 'Gizi baik' ? 'selected' : '' }} value="Gizi baik">Gizi baik <b>(-2 sd +1)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_anak'] == 'Gizi lebih' ? 'selected' : '' }} value="Gizi lebih">Gizi lebih <b>(+1 sd +2)</b></option>
                            <option {{ @$assesment['skrining_nutrisi_dewasa']['imt_anak'] == 'Obesitas' ? 'selected' : '' }} value="Obesitas">Obesitas <b>(>+2)</b></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">Untuk pasien dengan masalah Ginekologi / Onkologi</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan?</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)' ? 'checked' : '' }}
                                type="radio" value="Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) (0)</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak yakin (tanyakan apakah baju/celana terasa longgar)' ? 'checked' : '' }}
                                type="radio" value="Tidak yakin (tanyakan apakah baju/celana terasa longgar)">
                            <label class="form-check-label" style="font-weight: 400;">Tidak yakin (tanyakan apakah baju/celana terasa longgar) (2)</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1'] == 'ya' ? 'checked' : '' }}
                                type="radio" value="ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, berapa penurunan berat badan tersebut?</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1_ya'] == '1 - 5 Kg' ? 'checked' : '' }}
                                type="radio" value="1 - 5 Kg">
                            <label class="form-check-label" style="font-weight: 400;">1 - 5 Kg (1)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1_ya'] == '6 - 10 Kg' ? 'checked' : '' }}
                                type="radio" value="6 - 10 Kg">
                            <label class="form-check-label" style="font-weight: 400;">6 - 10 Kg (2)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1_ya'] == '11 - 15 Kg' ? 'checked' : '' }}
                                type="radio" value="11 - 15 Kg">
                            <label class="form-check-label" style="font-weight: 400;">11 - 15 Kg (3)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1_ya'] == '> 15 Kg' ? 'checked' : '' }}
                                type="radio" value="> 15 Kg">
                            <label class="form-check-label" style="font-weight: 400;">> 15 Kg (4)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter1_ya'] == 'Tidak yakin' ? 'checked' : '' }}
                                type="radio" value="Tidak yakin">
                            <label class="form-check-label" style="font-weight: 400;"> Tidak yakin (2)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;">2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun? (Misalnya asupan makan hanya 1/4 dari biasanya)</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter2'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya (1)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;">3. Sakit Berat?</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['parameter3'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya (2)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;">Kesimpulan & Tindak lanjut</td>
                    <td colspan="2"> 
                        <div >
                            <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_lebih_2]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_lebih_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Total Skor > 2, rujuk ke dietisien untuk asesmen gizi</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_kurang_2]"
                            {{ @$assesment['skrining_nutrisi_dewasa']['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_kurang_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Total Skor < 2, Skrining ulang 7 hari</label>
                        </div>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Spiritual</b></h5>
                <tr>
                    <td colspan="2" style="width: 50%;">Agama</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][agama]"
                                {{ @$assesment['spiritual']['agama'] == 'Islam' ? 'checked' : '' }}
                                type="radio" value="Islam">
                            <label class="form-check-label" style="font-weight: 400;">Islam</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][agama]"
                                {{ @$assesment['spiritual']['agama'] == 'Kristen' ? 'checked' : '' }}
                                type="radio" value="Kristen">
                            <label class="form-check-label" style="font-weight: 400;">Kristen</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][agama]"
                                {{ @$assesment['spiritual']['agama'] == 'Hindu' ? 'checked' : '' }}
                                type="radio" value="Hindu">
                            <label class="form-check-label" style="font-weight: 400;">Hindu</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][agama]"
                                {{ @$assesment['spiritual']['agama'] == 'Budha' ? 'checked' : '' }}
                                type="radio" value="Budha">
                            <label class="form-check-label" style="font-weight: 400;">Budha</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][agama]"
                                {{ @$assesment['spiritual']['agama'] == 'Lainnya' ? 'checked' : '' }}
                                type="radio" value="Lainnya">
                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                            <input type="text" class="form-control" placeholder="Lain-lain" name="fisik[spiritual][agama_lain]" value="{{ @$assesment['spiritual']['agama_lain'] }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Perubahan pola ibadah setelah sakit</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][perubahan_pola_ibadah]"
                                {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Berhenti' ? 'checked' : '' }}
                                type="radio" value="Berhenti">
                            <label class="form-check-label" style="font-weight: 400;">Berhenti</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][perubahan_pola_ibadah]"
                                {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Tidak berubah' ? 'checked' : '' }}
                                type="radio" value="Tidak berubah">
                            <label class="form-check-label" style="font-weight: 400;">Tidak berubah</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][perubahan_pola_ibadah]"
                                {{ @$assesment['spiritual']['perubahan_pola_ibadah'] == 'Bertambah/meningkat' ? 'checked' : '' }}
                                type="radio" value="Bertambah/meningkat">
                            <label class="form-check-label" style="font-weight: 400;">Bertambah/meningkat</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Respon setelah sakit</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][respon_setelah_sakit]"
                                {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Cobaan Hidup' ? 'checked' : '' }}
                                type="radio" value="Cobaan Hidup">
                            <label class="form-check-label" style="font-weight: 400;">Cobaan Hidup</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][respon_setelah_sakit]"
                                {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Menyalahkan Tuhan' ? 'checked' : '' }}
                                type="radio" value="Menyalahkan Tuhan">
                            <label class="form-check-label" style="font-weight: 400;">Menyalahkan Tuhan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][respon_setelah_sakit]"
                                {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Tidak bergairah' ? 'checked' : '' }}
                                type="radio" value="Tidak bergairah">
                            <label class="form-check-label" style="font-weight: 400;">Tidak bergairah</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][respon_setelah_sakit]"
                                {{ @$assesment['spiritual']['respon_setelah_sakit'] == 'Merasa putus asa' ? 'checked' : '' }}
                                type="radio" value="Merasa putus asa">
                            <label class="form-check-label" style="font-weight: 400;">Merasa putus asa</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Tanggapan terhadap diri setelah sakit</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][tanggapan_setelah_sakit]"
                                {{ @$assesment['spiritual']['tanggapan_setelah_sakit'] == 'Merasa tidak berguna' ? 'checked' : '' }}
                                type="radio" value="Merasa tidak berguna">
                            <label class="form-check-label" style="font-weight: 400;">Merasa tidak berguna</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][tanggapan_setelah_sakit]"
                                {{ @$assesment['spiritual']['tanggapan_setelah_sakit'] == 'Ketidakberdayaan' ? 'checked' : '' }}
                                type="radio" value="Ketidakberdayaan">
                            <label class="form-check-label" style="font-weight: 400;">Ketidakberdayaan</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Dukungan dan lingkungan</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][dukungan_dan_lingkungan]"
                                {{ @$assesment['spiritual']['dukungan_dan_lingkungan'] == 'Sangat mendukung' ? 'checked' : '' }}
                                type="radio" value="Sangat mendukung">
                            <label class="form-check-label" style="font-weight: 400;">Sangat mendukung</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][dukungan_dan_lingkungan]"
                                {{ @$assesment['spiritual']['dukungan_dan_lingkungan'] == 'Tidak ada dukungan' ? 'checked' : '' }}
                                type="radio" value="Tidak ada dukungan">
                            <label class="form-check-label" style="font-weight: 400;">Tidak ada dukungan</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Dirujuk ke rohaniawan</td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][dirujuk_ke_rohaniawan]"
                                {{ @$assesment['spiritual']['dirujuk_ke_rohaniawan'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[spiritual][dirujuk_ke_rohaniawan]"
                                {{ @$assesment['spiritual']['dirujuk_ke_rohaniawan'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Diagnosis Medis</b></h5>
                <tr>
                    <td colspan="3" style="font-weight: bold;">1. Risiko Mainutrisi berdasarkan hasil skrining gizi oleh perawat, kondidi pasien termasuk kategori :</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;" colspan="2">
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Risiko Ringan (Nilai Strongkid 0-1)</label>
                        </div>
                        <br>
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Risiko Ringan (Nilai Strongkid > 2-3)</label>
                        </div>
                        <br>
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Risiko Ringan (Nilai Strongkid 4-5)</label>
                        </div>
                    </td>
                    <td colspan="1">
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param1][penjelasan_1]" placeholder="Risiko Ringan (Nilai Strongkid 0-1)" value="{{ @$assesment['diagnosis_medis']['param1']['penjelasan_1'] }}">

                        </div>
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param1][penjelasan_2]" placeholder="Risiko Ringan (Nilai Strongkid > 2-3)" value="{{ @$assesment['diagnosis_medis']['param1']['penjelasan_2'] }}">

                        </div>
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param1][penjelasan_3]" placeholder="Risiko Ringan (Nilai Strongkid 4-5)" value="{{ @$assesment['diagnosis_medis']['param1']['penjelasan_3'] }}">

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="font-weight: bold;">2. Pasien mempunyai kondisi khusus :</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;" colspan="2">
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <br>
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td colspan="1">
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param2][penjelasan_1]" placeholder="Ya" value="{{ @$assesment['diagnosis_medis']['param2']['penjelasan_1'] }}">

                        </div>
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param2][penjelasan_2]" placeholder="Tidak" value="{{ @$assesment['diagnosis_medis']['param2']['penjelasan_2'] }}">

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="font-weight: bold;">3. Alergi Makanan :</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;" colspan="2">
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Telur</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][telur]"
                                    {{ @$assesment['diagnosis_medis']['param3']['telur'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][telur]"
                                    {{ @$assesment['diagnosis_medis']['param3']['telur'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Susu sapi/produk olahannya</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][susu]"
                                    {{ @$assesment['diagnosis_medis']['param3']['susu'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][susu]"
                                    {{ @$assesment['diagnosis_medis']['param3']['susu'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Kacang kedelai / tanah</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][kacang]"
                                    {{ @$assesment['diagnosis_medis']['param3']['kacang'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][kacang]"
                                    {{ @$assesment['diagnosis_medis']['param3']['kacang'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Hazelnut/Almond</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][almond]"
                                    {{ @$assesment['diagnosis_medis']['param3']['almond'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][almond]"
                                    {{ @$assesment['diagnosis_medis']['param3']['almond'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: middle;" colspan="2">
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Gluten/Gandum</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][gluten]"
                                    {{ @$assesment['diagnosis_medis']['param3']['gluten'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][gluten]"
                                    {{ @$assesment['diagnosis_medis']['param3']['gluten'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Udang</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][udang]"
                                    {{ @$assesment['diagnosis_medis']['param3']['udang'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][udang]"
                                    {{ @$assesment['diagnosis_medis']['param3']['udang'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Ikan</span>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][ikan]"
                                    {{ @$assesment['diagnosis_medis']['param3']['ikan'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                <input class="form-check-input"
                                    name="fisik[diagnosis_medis][param3][ikan]"
                                    {{ @$assesment['diagnosis_medis']['param3']['ikan'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <span>Lain-lain</span>
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Lain-lain" name="fisik[diagnosis_medis][param3][lain_lain]" value="{{ @$assesment['diagnosis_medis']['param3']['lain_lain'] }}">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">4. Preskripsi diet :</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosis_medis][param4]" id="" cols="30" rows="10" placeholder="Preskripsi diet">{{ @$assesment['diagnosis_medis']['param4'] }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="font-weight: bold;">5. Tindak Lanjut :</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;" colspan="2">
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Edukasi</label>
                        </div>
                        <br>
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Perlu asuhan gizi</label>
                        </div>
                        <br>
                        <div>
                            <label class="form-check-label" style="font-weight: 400;">Belum perlu asuhan gizi</label>
                        </div>
                    </td>
                    <td colspan="1">
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param5][penjelasan_1]" placeholder="Edukasi" value="{{ @$assesment['diagnosis_medis']['param5']['penjelasan_1'] }}">

                        </div>
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param5][penjelasan_2]" placeholder="Perlu asuhan gizi" value="{{ @$assesment['diagnosis_medis']['param5']['penjelasan_2'] }}">

                        </div>
                        <div>
                            <input type="text" class="form-control" name="fisik[diagnosis_medis][param5][penjelasan_3]" placeholder="Belum perlu asuhan gizi" value="{{ @$assesment['diagnosis_medis']['param5']['penjelasan_3'] }}">

                        </div>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Assesmen Gizi</b></h5>
                <tr>
                    <td style="font-weight: bold;">Antropometri</td>
                    <td>
                        <div>
                            <label class="form-check-label">BB</label>
                            <input type="text" class="form-control" placeholder="BB" name="fisik[assesmen_gizi][antropometri][BB]" value="{{ @$assesment['assesmen_gizi']['antropometri']['BB'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">IMT</label>
                            <input type="text" class="form-control" placeholder="IMT" name="fisik[assesmen_gizi][antropometri][IMT]" value="{{ @$assesment['assesmen_gizi']['antropometri']['IMT'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">TB</label>
                            <input type="text" class="form-control" placeholder="TB" name="fisik[assesmen_gizi][antropometri][TB]" value="{{ @$assesment['assesmen_gizi']['antropometri']['TB'] }}">
                        </div>
                        <div>
                            <label class="form-check-label">Status Gizi</label>
                            <input type="text" class="form-control" placeholder="Status Gizi" name="fisik[assesmen_gizi][antropometri][status_gizi]" value="{{ @$assesment['assesmen_gizi']['antropometri']['status_gizi'] }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Biokimia</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[assesmen_gizi][biokimia]" id="" cols="30" rows="10" placeholder="Biokimia">{{ @$assesment['assesmen_gizi']['biokimia'] }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Klinis/Fisik</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[assesmen_gizi][klinis_fisik]" id="" cols="30" rows="10" placeholder="Klinis/Fisik">{{ @$assesment['assesmen_gizi']['klinis_fisik'] }}</textarea>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Diagnosa</b></h5>
                <tr>
                    <td>
                        <textarea style="width: 100%;" name="fisik[form_assesmen_gizi][diagnosa]" id="" cols="30" rows="10" placeholder="Diagnosa">{{ @$assesment['form_assesmen_gizi']['diagnosa'] }}</textarea>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Intervensi</b></h5>
                <tr>
                    <td>
                        <textarea style="width: 100%;" name="fisik[form_assesmen_gizi][intervensi]" id="" cols="30" rows="10" placeholder="Intervensi">{{ @$assesment['form_assesmen_gizi']['intervensi'] }}</textarea>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Monitoring & Evaluasi</b></h5>
                <tr>
                    <td>
                        <textarea style="width: 100%;" name="fisik[form_assesmen_gizi][monitoring_evaluasi]" id="" cols="30" rows="10" placeholder="Monitoring & Evaluasi">{{ @$assesment['form_assesmen_gizi']['monitoring_evaluasi'] }}</textarea>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Kebutuhan Edukasi</b></h5>
                <tr>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Hak untuk berpartisipasi dalam proses pelayanan' ? 'checked' : '' }}
                                type="radio" value="Hak untuk berpartisipasi dalam proses pelayanan">
                            <label class="form-check-label" style="font-weight: 400;">Hak untuk berpartisipasi dalam proses pelayanan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Proses pemberian informed consent' ? 'checked' : '' }}
                                type="radio" value="Proses pemberian informed consent">
                            <label class="form-check-label" style="font-weight: 400;">Proses pemberian informed consent</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Penggunaan Alat Medis yang aman' ? 'checked' : '' }}
                                type="radio" value="Penggunaan Alat Medis yang aman">
                            <label class="form-check-label" style="font-weight: 400;">Penggunaan Alat Medis yang aman</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Cuci tangan yang benar' ? 'checked' : '' }}
                                type="radio" value="Cuci tangan yang benar">
                            <label class="form-check-label" style="font-weight: 400;">Cuci tangan yang benar</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Lain-lain' ? 'checked' : '' }}
                                type="radio" value="Lain-lain">
                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                        </div>
                    </td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Kondisi kesehatan diagnosis pasati, dan penatalakanaanya' ? 'checked' : '' }}
                                type="radio" value="Kondisi kesehatan diagnosis pasati, dan penatalakanaanya">
                            <label class="form-check-label" style="font-weight: 400;">Kondisi kesehatan diagnosis pasati, dan penatalakanaanya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Penggunaan obat secara efektif dan aman, efek samping serta interaksinya' ? 'checked' : '' }}
                                type="radio" value="Penggunaan obat secara efektif dan aman, efek samping serta interaksinya">
                            <label class="form-check-label" style="font-weight: 400;">Penggunaan obat secara efektif dan aman, efek samping serta interaksinya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Prosedur pemeriksaan penunjangan' ? 'checked' : '' }}
                                type="radio" value="Prosedur pemeriksaan penunjangan">
                            <label class="form-check-label" style="font-weight: 400;">Prosedur pemeriksaan penunjangan</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Rujukan Edukasi' ? 'checked' : '' }}
                                type="radio" value="Rujukan Edukasi">
                            <label class="form-check-label" style="font-weight: 400;">Rujukan Edukasi</label>
                        </div>
                    </td>
                    <td> 
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Diet & Nutrisi' ? 'checked' : '' }}
                                type="radio" value="Diet & Nutrisi">
                            <label class="form-check-label" style="font-weight: 400;">Diet & Nutrisi</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Manajemen Nyeri' ? 'checked' : '' }}
                                type="radio" value="Manajemen Nyeri">
                            <label class="form-check-label" style="font-weight: 400;">Manajemen Nyeri</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Bahaya merokok' ? 'checked' : '' }}
                                type="radio" value="Bahaya merokok">
                            <label class="form-check-label" style="font-weight: 400;">Bahaya merokok</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_edukasi]"
                                {{ @$assesment['kebutuhan_edukasi'] == 'Teknik rehabilitasi' ? 'checked' : '' }}
                                type="radio" value="Teknik rehabilitasi">
                            <label class="form-check-label" style="font-weight: 400;">Teknik rehabilitasi</label>
                        </div>
                    </td>
                </tr>
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Rencana Pemulangan Pasien</b></h5>
                <tr>
                    <td>
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][perlu_home_care]"
                            {{ @$assesment['discharge_planning']['perlu_home_care'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Perlu pelayanan home care</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][perlu_pasang_implant]"
                            {{ @$assesment['discharge_planning']['perlu_pasang_implant'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Perlu pemasangan implant</label>
                        </div>
                    </td>
                    <td>
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][penggunaan_alat_bantu]"
                            {{ @$assesment['discharge_planning']['penggunaan_alat_bantu'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Penggunaan alat bantu</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_komunitas]"
                            {{ @$assesment['discharge_planning']['dirujuk_ke_komunitas'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Dirujuk ke komunitas tertentu</label>
                        </div>
                    </td>
                    <td> 
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_tim]"
                            {{ @$assesment['discharge_planning']['dirujuk_ke_tim'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Dirujuk ke tim terapis</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[discharge_planning][dirujuk_ke_gizi]"
                            {{ @$assesment['discharge_planning']['dirujuk_ke_gizi'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Dirujuk ke ahli gizi</label>
                        </div>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>I. Data Diganostik</b></h5>
                <tr>
                    <td style="width: 50%;">Laboratorium</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[data_diganostik][laboratorium]" id="" cols="30" rows="10" placeholder="Laboratorium">{{ @$assesment['data_diganostik']['laboratorium'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">CTG</td>
                    <td colspan="2"> 
                        <input type="text" class="form-control" placeholder="CTG" name="fisik[data_diganostik][ctg]" value="{{ @$assesment['data_diganostik']['ctg'] }}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">USG</td>
                    <td colspan="2"> 
                        <input type="text" class="form-control" placeholder="USG" name="fisik[data_diganostik][usg]" value="{{ @$assesment['data_diganostik']['usg'] }}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Lain-lain</td>
                    <td colspan="2"> 
                        <input type="text" class="form-control" placeholder="Lain-lain" name="fisik[data_diganostik][lain_lain]" value="{{ @$assesment['data_diganostik']['lain_lain'] }}">
                    </td>
                </tr>
            </table>
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>II. Diagnosa Perawat / Bidanan</b></h5>
                <tr>
                    <td> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_perawat_bidanan]" id="" cols="30" rows="10" placeholder="Diagnosa perawat / bidanan">{{ @$assesment['diagnosa_perawat_bidanan'] }}</textarea>
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
                  <th class="text-center" style="vertical-align: middle;">Ruangan</th>
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
                        {{$riwayat->registrasi->rawat_inap ? baca_kamar(@$riwayat->registrasi->rawat_inap->kamar_id) : baca_poli(@$riwayat->registrasi->poli_id)}}
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