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

  input.selected_point {
      width: 35px;
      height: 35px;
      padding: 0 !important;
      margin: 0 !important;
      /* visibility: hidden; */
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border: none;
      position: relative;
      -webkit-print-color-adjust: exact;//:For Chrome
      color-adjust: exact;//:For Firefox
  }

  input.selected_point:hover {
      cursor: pointer;
      background-color: rgb(255, 133, 133);
  }

  input.selected_point:checked {
      background-color: red;
  }

  @media print {
      input.chosen_point:checked {
          background-color: red !important;
      }   
  }
</style>
@section('header')
<h1>Usia Kehamilan</h1>
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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/usia_kehamilan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
          <br>

          <div class="col-md-12">
            <h5 class="text-center"><b>Usia Kehamilan</b></h5>
          </div>


            @php
              $assesment = @json_decode(@$usiaKehamilan->fisik, true);
            @endphp

          {{-- Denyut Jantung --}}
          <div class="col-md-12" style="display: flex; justify-content:center; margin-bottom: 2rem;">
              @php
                  $param_denyut_jantung = [
                      '4.200',
                      '4.000',
                      '3.800',
                      '3.600',
                      '3.400',
                      '3.200',
                      '3.000',
                      '2.800',
                      '2.600',
                      '2.400',
                      '2.200',
                      '2.000',
                      '1.800',
                      '1.600',
                      '1.400',
                      '1.200',
                      '1.000',
                      '800',
                      '600',
                      '400',
                      '200',
                      '0',
                  ]
              @endphp
              <table class="border" >
                      <tr>
                        <td>&nbsp;</td>
                        @for ($i = 24; $i <= 43; $i++)
                            <td class="bold text-center">{{$i}}</td>
                        @endfor
                      </tr>
                  @foreach ($param_denyut_jantung as $key => $param)
                      <tr>
                          <td style="width: 50px" class="text-right bold">{{$param}}</td>
                          @for ($i = 24; $i <= 43; $i++)
                              <td class="border">
                                  <input type="hidden" name="fisik[denyut_jantung][{{$param}}][{{$i}}]"  value="">
                                  <input type="checkbox" name="fisik[denyut_jantung][{{$param}}][{{$i}}]" class="selected_point" {{@$assesment['denyut_jantung'][$param][$i] == "selected" ? 'checked' : ''}} value="selected">
                              </td>
                          @endfor
                      </tr>
                  @endforeach
              </table>
          </div>

            <div class="col-md-12">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
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
              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-12">
                    {!! Form::submit(empty($usiaKehamilan) ? "Simpan" : "Perbarui", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                </div>
              </div> 
            </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
@endsection
        