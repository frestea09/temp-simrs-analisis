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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/perinatologi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
        
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <h4 style="text-align: center; padding: 10px"><b>Pengkajian Awal Keperawatan Neonatus</b></h4>
          <br>

          <div class="col-md-6">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <h5 class="text-center"><b>Keadaan Umum</b></h5>
              <tr>
                <td style=" font-weight:bold;">Diagnosa</td>
                <td style="" colspan="5">
                    <select name="fisik[keadaan_umum][diagnosa][dipilih]" class="select2" style="width: 100%;">
                        <option value="" selected disabled>-- Pilih Salah Satu --</option>
                        <option value="Menyusu tidak efektif" {{@$assesment['keadaan_umum']['diagnosa']['dipilih'] == "Menyusu tidak efektif" ? 'selected' : ''}}>Menyusu tidak efektif</option>
                        <option value="Hipotemi" {{@$assesment['keadaan_umum']['diagnosa']['dipilih'] == "Hipotemi" ? 'selected' : ''}}>Hipotemi</option>
                        <option value="Resiko Hipotermi" {{@$assesment['keadaan_umum']['diagnosa']['dipilih'] == "Resiko Hipotermi" ? 'selected' : ''}}>Resiko Hipotermi</option>
                        <option value="Termoregulasi tidak efektif" {{@$assesment['keadaan_umum']['diagnosa']['dipilih'] == "Termoregulasi tidak efektif" ? 'selected' : ''}}>Termoregulasi tidak efektif</option>
                        <option value="Ikterik neonatorum" {{@$assesment['keadaan_umum']['diagnosa']['dipilih'] == "Ikterik neonatorum" ? 'selected' : ''}}>Ikterik neonatorum</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">1. Pemeriksaan Tanda Vital</td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][tekanan_darah]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['tekanan_darah']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][nadi]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['nadi']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][RR]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['RR']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][temp]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['temp']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="4">
                  <label class="form-check-label" style="font-weight: normal;">APGAR SCORE</label><br/>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">1 menit</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][apgar_1menit]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['apgar_1menit']}}">
                </td>
                <td style="padding: 5px;" colspan="2">
                  <label class="form-check-label" style="font-weight: normal;">5 menit</label><br/>
                  <input type="text" name="fisik[keadaan_umum][tanda_vital][apgar_5menit]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['tanda_vital']['apgar_5menit']}}">
                </td>
              </tr>
              <tr>
                <td style="width:20%; font-weight:bold;" colspan="4">2. Kesadaran</td>
              </tr>
              <tr>
                <td colspan="4"> 
                    <h5 class="text-center">GRADING OF STATE</h5>
                    <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>STATE</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>BUTIR PENILAIAN</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>NILAI SKOR</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                <b>STATE 1</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;">
                                1.1 Eyes closed <br>
                                1.2 Regular respiration <br>
                                1.2 No Movement <br>
                            </td>
                            <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                <input type="text" name="fisik[keadaan_umum][keadaan_umum][kesadaran][grading_of_state][state1]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['keadaan_umum']['kesadaran']['grading_of_state']['state1']}}">
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                <b>STATE 2</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;">
                                2.2 Eyes closed <br>
                                2.3 Irregular Respiration <br>
                                2.4 No gross movements <br>
                            </td>
                            <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                <input type="text" name="fisik[keadaan_umum][keadaan_umum][kesadaran][grading_of_state][state2]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['keadaan_umum']['kesadaran']['grading_of_state']['state2']}}">
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                <b>STATE 3</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;">
                                3.1 Eyes open <br>
                                3.2 No gross movements <br>
                            </td>
                            <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                <input type="text" name="fisik[keadaan_umum][keadaan_umum][kesadaran][grading_of_state][state3]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['keadaan_umum']['kesadaran']['grading_of_state']['state3']}}">
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                <b>STATE 4</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;">
                                4.1 Eyes open <br>
                                4.2 No gross movements <br>
                                4.3 No crying <br>
                            </td>
                            <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                <input type="text" name="fisik[keadaan_umum][keadaan_umum][kesadaran][grading_of_state][state4]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['keadaan_umum']['kesadaran']['grading_of_state']['state4']}}">
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                <b>STATE 5</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;">
                                5.1 Eyes open or closed<br>
                                5.2 Crying <br>
                            </td>
                            <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                <input type="text" name="fisik[keadaan_umum][keadaan_umum][kesadaran][grading_of_state][state5]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['keadaan_umum']['keadaan_umum']['kesadaran']['grading_of_state']['state5']}}">
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>

            <tr>
                <td  style="width:20%; font-weight:bold;" colspan="2">
                    3. Asesmen Nyeri
                </td>
                <td style="padding: 5px;">
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri'] == 'Tidak' ? 'checked' : '' }}
                            type="radio" value="Tidak">
                        <label class="form-check-label">Tidak Ada</label>
                    </div>
                    <div>
                        <input class="form-check-input"
                            name="fisik[keadaan_umum][asesmenNyeri]"
                            {{ @$assesment['keadaan_umum']['asesmenNyeri'] == 'Ada' ? 'checked' : '' }}
                            type="radio" value="Ada">
                        <label class="form-check-label">Ada</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <h5 class="text-center">ASESMEN NYERI NIPS (NEONATAL INFANT PAIN SCALE)</h5>
                    <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>NO</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>RESPON NEONATUS</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>SKOR</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="3" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>1</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Ekspresi Wajah</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Otot wajah rileks, ekspresi netral
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no1]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no1'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Otot wajah tegang, alis berkerut, rahang dagu meruncing
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no1]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no1'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="4" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>2</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Tangisan</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Tenang, menangis kuat
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no2]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no2'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Mengerang, sebentar-sebentar menangis
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no2]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no2'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Terus menerus menangis melengking / Tidak menangis
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no2]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no2'] == '2' ? 'checked' : '' }}
                                type="radio" value="2">
                                <b>2</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="3" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>3</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Pola Nafas</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Rileks, nafas reguler
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no3]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no3'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Pola nafas berubah : tidak teratur, lebih cepat dari biasanya, tersedak, menahan nafas
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no3]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no3'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="3" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>4</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Tangan</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Rileks, otot tangan tidak kaku, kadang bergerak tidak beraturan
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no4]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no4'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Fleksi/ ekstensi kaku, meluruskan tapi dengan cepat melakukan fleksi/ekstensi yang kaku
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no4]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no4'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="3" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>5</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Kaki</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Rileks, otot tangan tidak kaku, kadang bergerak tidak beraturan
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no5]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no5'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Fleksi/ ekstensi kaku, meluruskan tapi dengan cepat melakukan fleksi/ekstensi yang kaku
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no5]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no5'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td rowspan="3" style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>6</b>
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <b>Kesadaran</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Tidur pulas atau cepat bangun, alert dan tenang
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no6]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no6'] == '0' ? 'checked' : '' }}
                                type="radio" value="0">
                                <b>0</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                Rewel, gelisah dan meronta-ronta
                            </td>
                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                <input onchange="totalSkor()" class="form-check-input skorNyeriNIPS"
                                name="fisik[keadaan_umum][asesmenNyeriNips][no6]"
                                {{ @$assesment['keadaan_umum']['asesmenNyeriNips']['no6'] == '1' ? 'checked' : '' }}
                                type="radio" value="1">
                                <b>1</b>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black;">&nbsp;</td>
                            <td style="border: 1px solid black; font-weight:bold;">Total Skor</td>
                            <td style="border: 1px solid black;">
                                <input type="text" class="form-control" name="fisik[keadaan_umum][asesmenNyeriNips][total]" id="totalSkorId" value="{{ @$assesment['keadaan_umum']['asesmenNyeriNips']['total'] }}" style="width: 100%" readonly>
                            </td>
                        </tr>
                        <tr style="border: 1px solid black;">
                            <td style="border: 1px solid black;">&nbsp;</td>
                            <td style="border: 1px solid black; font-weight:bold;">Skoring</td>
                            <td style="border: 1px solid black;">
                                <input type="text" class="form-control" name="fisik[keadaan_umum][asesmenNyeriNips][skoring]" id="skoringId" value="{{ @$assesment['keadaan_umum']['asesmenNyeriNips']['skoring'] }}" style="width: 100%" readonly>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                        <h5 class="text-center"><b>Riwayat Prenatal Dan Intranatal</b></h5>
                        <tr>
                            <td colspan="2" style="width: 50%;">1. Kehamilan Ibu</td>
                            <td>
                                <div>
                                    <label for="">G</label>
                                    <input type="text" class="form-control" placeholder="G" name="fisik[riwayat_prenatal_dan_intranatal][kehamilan_ibu][G]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['kehamilan_ibu']['G'] }}">
                                </div>
                                <div>
                                    <label for="">P</label>
                                    <input type="text" class="form-control" placeholder="P" name="fisik[riwayat_prenatal_dan_intranatal][kehamilan_ibu][P]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['kehamilan_ibu']['P'] }}">
                                </div>
                                <div>
                                    <label for="">A</label>
                                    <input type="text" class="form-control" placeholder="A" name="fisik[riwayat_prenatal_dan_intranatal][kehamilan_ibu][A]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['kehamilan_ibu']['A'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">2. Riwayat Penyakit</td>
                            <td>
                                <input type="text" class="form-control" placeholder="Riwayat penyakit" name="fisik[riwayat_prenatal_dan_intranatal][riwayat_penyakit]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['riwayat_penyakit'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">3. Ketuban</td>
                            <td>
                                <div>
                                    <label for="">KPSW</label>
                                    <input type="text" class="form-control" placeholder="KPSW" name="fisik[riwayat_prenatal_dan_intranatal][ketuban][kpsw]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['ketuban']['kpsw'] }}">
                                </div>
                                <div>
                                    <label for="">Jam, Warna</label>
                                    <input type="text" class="form-control" placeholder="Jam, Warna" name="fisik[riwayat_prenatal_dan_intranatal][ketuban][jam_warna]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['ketuban']['jam_warna'] }}">
                                </div>
                                <div>
                                    <label for="">Bau</label>
                                    <input type="text" class="form-control" placeholder="Bau" name="fisik[riwayat_prenatal_dan_intranatal][ketuban][bau]" value="{{ @$assesment['riwayat_prenatal_dan_intranatal']['ketuban']['bau'] }}">
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                        <h5 class="text-center"><b>Pemeriksaan Fisik</b></h5>
                        <tr>
                            <td colspan="2" style="width: 50%;">BB (gram)</td>
                            <td>
                                <input type="text" class="form-control" placeholder="gram" name="fisik[pemeriksaan_fisik][bb]" value="{{ @$assesment['pemeriksaan_fisik']['bb'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Panjang badan (cm)</td>
                            <td>
                                <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][panjang_badan]" value="{{ @$assesment['pemeriksaan_fisik']['panjang_badan'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Lingkar kepala (cm)</td>
                            <td>
                                <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][lingkar_kepala]" value="{{ @$assesment['pemeriksaan_fisik']['lingkar_kepala'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Lingkar lengan (cm)</td>
                            <td>
                                <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][lingkar_lengan]" value="{{ @$assesment['pemeriksaan_fisik']['lingkar_lengan'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Lingkar dada (cm)</td>
                            <td>
                                <input type="text" class="form-control" placeholder="cm" name="fisik[pemeriksaan_fisik][lingkar_dada]" value="{{ @$assesment['pemeriksaan_fisik']['lingkar_dada'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Kepala</td>
                            <td>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][kepala][pilihan]"
                                    {{ @$assesment['pemeriksaan_fisik']['kepala']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                    <label>Ya</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][kepala][pilihan]"
                                    {{ @$assesment['pemeriksaan_fisik']['kepala']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                    <label>Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Mata</td>
                            <td>
                                <div>
                                    <label for="">Sclera</label>
                                    <div>
                                        <input class="form-check-input"
                                        name="fisik[pemeriksaan_fisik][mata][sclera][pilihan]"
                                        {{ @$assesment['pemeriksaan_fisik']['mata']['sclera']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                        type="radio" value="Ya">
                                        <label style="font-weight: normal;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                        name="fisik[pemeriksaan_fisik][mata][sclera][pilihan]"
                                        {{ @$assesment['pemeriksaan_fisik']['mata']['sclera']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                        type="radio" value="Tidak">
                                        <label style="font-weight: normal;">Tidak</label>
                                    </div>
                                </div>
                                <div>
                                    <label for="">Conjuntiva</label>
                                    <div>
                                        <input class="form-check-input"
                                        name="fisik[pemeriksaan_fisik][mata][conjuntiva][pilihan]"
                                        {{ @$assesment['pemeriksaan_fisik']['mata']['conjuntiva']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                        type="radio" value="Ya">
                                        <label style="font-weight: normal;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                        name="fisik[pemeriksaan_fisik][mata][conjuntiva][pilihan]"
                                        {{ @$assesment['pemeriksaan_fisik']['mata']['conjuntiva']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                        type="radio" value="Tidak">
                                        <label style="font-weight: normal;">Tidak</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Hidung</td>
                            <td>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][hidung][pilihan]"
                                    {{ @$assesment['pemeriksaan_fisik']['hidung']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                    type="radio" value="Ya">
                                    <label>Ya</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][hidung][pilihan]"
                                    {{ @$assesment['pemeriksaan_fisik']['hidung']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                    type="radio" value="Tidak">
                                    <label>Tidak</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Telinga</td>
                            <td>
                                <div>
                                    <label for="">Elastisitas daun telinga kurang / cukup</label>
                                    <input type="text" class="form-control" placeholder="Elastisitas daun telinga" name="fisik[pemeriksaan_fisik][telinga][elastisitas_daun_telinga]" value="{{ @$assesment['pemeriksaan_fisik']['telinga']['elastisitas_daun_telinga'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Mulut</td>
                            <td>
                                <div>
                                    <label for="">Simetirs / Asimetris</label>
                                    <input type="text" class="form-control" placeholder="Simetris / Asimetris" name="fisik[pemeriksaan_fisik][mulut][simetris_asimetris]" value="{{ @$assesment['pemeriksaan_fisik']['mulut']['simetris_asimetris'] }}">
                                </div>
                                <div>
                                    <label for="">Palatum : keras / lunak / kelainan</label>
                                    <input type="text" class="form-control" placeholder="Palatum" name="fisik[pemeriksaan_fisik][mulut][palatum]" value="{{ @$assesment['pemeriksaan_fisik']['mulut']['palatum'] }}">
                                </div>
                                <div>
                                    <label for="">Bibir</label>
                                    <input type="text" class="form-control" placeholder="Bibir" name="fisik[pemeriksaan_fisik][mulut][bibir]" value="{{ @$assesment['pemeriksaan_fisik']['mulut']['bibir'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Kulit</td>
                            <td>
                                <div>
                                    <label for="">Tipis, banyak lanugo, lemak, subkutan kurang / cukup, keriput</label>
                                    <input type="text" class="form-control" placeholder="Kulit" name="fisik[pemeriksaan_fisik][kulit][detail]" value="{{ @$assesment['pemeriksaan_fisik']['kulit']['detail'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Rambut</td>
                            <td>
                                <div>
                                    <label for="">Tipis, Tumbuh sempurna</label>
                                    <input type="text" class="form-control" placeholder="Rambut" name="fisik[pemeriksaan_fisik][rambut][detail]" value="{{ @$assesment['pemeriksaan_fisik']['rambut']['detail'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Gerakan leher</td>
                            <td>
                                <div>
                                    <label for="">Kaku / Tidak kaku</label>
                                    <input type="text" class="form-control" placeholder="Gerakan leher" name="fisik[pemeriksaan_fisik][gerakan_leher][detail]" value="{{ @$assesment['pemeriksaan_fisik']['gerakan_leher']['detail'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Badan</td>
                            <td>
                                <div>
                                    <label for="">Warna, merah, kuning, pucat, cyanosis</label>
                                    <input type="text" class="form-control" placeholder="Badan" name="fisik[pemeriksaan_fisik][badan][detail]" value="{{ @$assesment['pemeriksaan_fisik']['badan']['detail'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Perut</td>
                            <td>
                                <div>
                                    <label for="">Bising usus</label>
                                    <input type="text" class="form-control" placeholder="Bising usus" name="fisik[pemeriksaan_fisik][perut][bising_usus]" value="{{ @$assesment['pemeriksaan_fisik']['perut']['bising_usus'] }}">
                                </div>
                                <div>
                                    <label for="">Benjolan</label>
                                    <input type="text" class="form-control" placeholder="Benjolan" name="fisik[pemeriksaan_fisik][perut][benjolan]" value="{{ @$assesment['pemeriksaan_fisik']['perut']['benjolan'] }}">
                                </div>
                                <div>
                                    <label for="">Tegang</label>
                                    <input type="text" class="form-control" placeholder="Tegang" name="fisik[pemeriksaan_fisik][perut][tegang]" value="{{ @$assesment['pemeriksaan_fisik']['perut']['tegang'] }}">
                                </div>
                                <div>
                                    <label for="">Umbilical</label>
                                    <input type="text" class="form-control" placeholder="Umbilical" name="fisik[pemeriksaan_fisik][perut][umbilical]" value="{{ @$assesment['pemeriksaan_fisik']['perut']['umbilical'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Dada</td>
                            <td>
                                <div>
                                    <label for="">Simetris / Asimetris</label>
                                    <input type="text" class="form-control" placeholder="Simetris / Asimetris" name="fisik[pemeriksaan_fisik][dada][simetris_asimetris]" value="{{ @$assesment['pemeriksaan_fisik']['dada']['simetris_asimetris'] }}">
                                </div>
                                <div>
                                    <label for="">Pernapasan dada / perut</label>
                                    <input type="text" class="form-control" placeholder="Dada / perut" name="fisik[pemeriksaan_fisik][dada][pernapasan]" value="{{ @$assesment['pemeriksaan_fisik']['dada']['pernapasan'] }}">
                                </div>
                                <div>
                                    <label for="">Paru-paru : Whezzing, ronchi, dyspnoe, apnoe distres</label>
                                    <input type="text" class="form-control" placeholder="Whezzing, ronchi, dyspnoe, apnoe distres" name="fisik[pemeriksaan_fisik][dada][paru_paru]" value="{{ @$assesment['pemeriksaan_fisik']['dada']['paru_paru'] }}">
                                </div>
                                <div>
                                    <label for="">Pernapasan, Bunyi jantung</label>
                                    <input type="text" class="form-control" placeholder="bunyi jantung" name="fisik[pemeriksaan_fisik][dada][bunyi jantung]" value="{{ @$assesment['pemeriksaan_fisik']['dada']['bunyi jantung'] }}">
                                </div>
                                <div>
                                    <label for="">Puting susu : Terbentuk baik / tidak cukup</label>
                                    <input type="text" class="form-control" placeholder="Terbentuk baik / tidak cukup" name="fisik[pemeriksaan_fisik][dada][puting_susu]" value="{{ @$assesment['pemeriksaan_fisik']['dada']['puting_susu'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Extremitas</td>
                            <td>
                                <div>
                                    <label for="">Jari - jari</label>
                                    <input type="text" class="form-control" placeholder="Jari - jari" name="fisik[pemeriksaan_fisik][extremitas][jari_jari]" value="{{ @$assesment['pemeriksaan_fisik']['extremitas']['jari_jari'] }}">
                                </div>
                                <div>
                                    <label for="">Plantar creasis 1 - 2 garis penuh melintang pada ujung kaki, posisi kaki</label>
                                    <input type="text" class="form-control" placeholder="Posisi kaki" name="fisik[pemeriksaan_fisik][extremitas][posisi_kaki]" value="{{ @$assesment['pemeriksaan_fisik']['extremitas']['posisi_kaki'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Lubang anus</td>
                            <td>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][lubang_anus]"
                                    {{ @$assesment['pemeriksaan_fisik']['lubang_anus'] == 'Ada' ? 'checked' : '' }}
                                    type="radio" value="Ada">
                                    <label>Ada</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][lubang_anus]"
                                    {{ @$assesment['pemeriksaan_fisik']['lubang_anus'] == 'Tidak ada' ? 'checked' : '' }}
                                    type="radio" value="Tidak ada">
                                    <label>Tidak ada</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Genitalia</td>
                            <td>
                                <div>
                                    <label for="">Perempuan : Labia terbuka / tertutup</label>
                                    <input type="text" class="form-control" placeholder="Labia terbuka / tertutup" name="fisik[pemeriksaan_fisik][genitalia][perempuan]" value="{{ @$assesment['pemeriksaan_fisik']['genitalia']['perempuan'] }}">
                                </div>
                                <div>
                                    <label for="">Laki-laki : Testis turun, lengkap/tidak lengkap</label>
                                    <input type="text" class="form-control" placeholder="Testis turun, lengkap/tidak lengkap" name="fisik[pemeriksaan_fisik][genitalia][laki_laki]" value="{{ @$assesment['pemeriksaan_fisik']['genitalia']['laki_laki'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Refleks</td>
                            <td>
                                <div>
                                    <label for="">Mengisap</label>
                                    <input type="text" class="form-control" placeholder="Mengisap" name="fisik[pemeriksaan_fisik][refleks][mengisap]" value="{{ @$assesment['pemeriksaan_fisik']['refleks']['mengisap'] }}">
                                </div>
                                <div>
                                    <label for="">Rooting</label>
                                    <input type="text" class="form-control" placeholder="Rooting" name="fisik[pemeriksaan_fisik][refleks][rooting]" value="{{ @$assesment['pemeriksaan_fisik']['refleks']['rooting'] }}">
                                </div>
                                <div>
                                    <label for="">Moro</label>
                                    <input type="text" class="form-control" placeholder="Moro" name="fisik[pemeriksaan_fisik][refleks][moro]" value="{{ @$assesment['pemeriksaan_fisik']['refleks']['moro'] }}">
                                </div>
                                <div>
                                    <label for="">Menggenggam</label>
                                    <input type="text" class="form-control" placeholder="Menggenggam" name="fisik[pemeriksaan_fisik][refleks][menggenggam]" value="{{ @$assesment['pemeriksaan_fisik']['refleks']['menggenggam'] }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Menangis</td>
                            <td>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][menangis]"
                                    {{ @$assesment['pemeriksaan_fisik']['menangis'] == 'Kuat' ? 'checked' : '' }}
                                    type="radio" value="Kuat">
                                    <label>Kuat</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                    name="fisik[pemeriksaan_fisik][menangis]"
                                    {{ @$assesment['pemeriksaan_fisik']['menangis'] == 'Lemah' ? 'checked' : '' }}
                                    type="radio" value="Lemah">
                                    <label>Lemah</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 50%;">Eliminasi</td>
                            <td>
                                <div>
                                    <label for="">BAB Frek</label>
                                    <input type="text" class="form-control" placeholder="BAB Frek x / hari" name="fisik[pemeriksaan_fisik][eliminasi][bab_frek1]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['bab_frek1'] }}">
                                </div>
                                <div>
                                    <label for="">Warna</label>
                                    <input type="text" class="form-control" placeholder="Warna" name="fisik[pemeriksaan_fisik][eliminasi][warna1]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['warna1'] }}">
                                </div>
                                <div>
                                    <label for="">BAB Frek</label>
                                    <input type="text" class="form-control" placeholder="BAB Frek x / hari" name="fisik[pemeriksaan_fisik][eliminasi][bab_frek2]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['bab_frek2'] }}">
                                </div>
                                <div>
                                    <label for="">Warna</label>
                                    <input type="text" class="form-control" placeholder="Warna" name="fisik[pemeriksaan_fisik][eliminasi][warna2]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['warna2'] }}">
                                </div>
                                <div>
                                    <label for="">BAK Frek</label>
                                    <input type="text" class="form-control" placeholder="BAK x / hari" name="fisik[pemeriksaan_fisik][eliminasi][bak_frek]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['bak_frek'] }}">
                                </div>
                                <div>
                                    <label for="">Warna</label>
                                    <input type="text" class="form-control" placeholder="Warna" name="fisik[pemeriksaan_fisik][eliminasi][warna_bak]" value="{{ @$assesment['pemeriksaan_fisik']['eliminasi']['warna_bak'] }}">
                                </div>
                            </td>
                        </tr>
                            <td colspan="2" style="width: 50%;">Minum</td>
                            <td>
                                <div>
                                    <label for="">Jenis Minuman</label>
                                    <input type="text" class="form-control" placeholder="Jenis Minuman" name="fisik[pemeriksaan_fisik][minum][jenis_minuman]" value="{{ @$assesment['pemeriksaan_fisik']['minum']['jenis_minuman'] }}">
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
                </td>
            </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>SKRINING GIZI NEONATUS</b></h5>
                <tr>
                    <td colspan="2" style="width: 50%;">Tanggal Lahir</td>
                    <td>
                        <input required type="date" class="form-control" placeholder="gram" name="fisik[skrining_gizi_neonatus][tanggal_lahir]" value="{{ @$assesment['skrining_gizi_neonatus']['tanggal_lahir'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">1. Penilaian Pertumbuhan</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Berat badan saat ini</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Berat badan saat ini" name="fisik[skrining_gizi_neonatus][bb_saat_ini]" value="{{ @$assesment['skrining_gizi_neonatus']['bb_saat_ini'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Lingkar kepala</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Lingkar kepala" name="fisik[skrining_gizi_neonatus][lingkar_kepala]" value="{{ @$assesment['skrining_gizi_neonatus']['lingkar_kepala'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Panjang badan</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Panjang badan" name="fisik[skrining_gizi_neonatus][panjang_badan]" value="{{ @$assesment['skrining_gizi_neonatus']['panjang_badan'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Berat badan lahir</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Berat badan lahir" name="fisik[skrining_gizi_neonatus][berat_badan_lahir]" value="{{ @$assesment['skrining_gizi_neonatus']['berat_badan_lahir'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Lingkar kepala lahir</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Lingkar kepala lahir" name="fisik[skrining_gizi_neonatus][lingkar_kepala_lahir]" value="{{ @$assesment['skrining_gizi_neonatus']['lingkar_kepala_lahir'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Panjang badan lahir</td>
                    <td>
                        <input required type="text" class="form-control" placeholder="Panjang badan lahir" name="fisik[skrining_gizi_neonatus][panjang_badan_lahir]" value="{{ @$assesment['skrining_gizi_neonatus']['panjang_badan_lahir'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">2. Ketentuan Golongan Risiko</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Risiko Tinggi</td>
                    <td>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Prematur usia < 28 minggu' ? 'checked' : '' }}
                                type="radio" value="Prematur usia < 28 minggu">
                            <label class="form-check-label">Prematur usia < 28 minggu</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Berat badan lahir sangat rendah < 1000 g' ? 'checked' : '' }}
                                type="radio" value="Berat badan lahir sangat rendah < 1000 g">
                            <label class="form-check-label">Berat badan lahir sangat rendah < 1000 g</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Bayi yang mengalami NEC setelah mendapat makanan' ? 'checked' : '' }}
                                type="radio" value="Bayi yang mengalami NEC setelah mendapat makanan">
                            <label class="form-check-label">Bayi yang mengalami NEC setelah mendapat makanan</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Atau bayi yang mengalami gastroinstestinal perforasi' ? 'checked' : '' }}
                                type="radio" value="Atau bayi yang mengalami gastroinstestinal perforasi">
                            <label class="form-check-label">Atau bayi yang mengalami gastroinstestinal perforasi</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)' ? 'checked' : '' }}
                                type="radio" value="Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)">
                            <label class="form-check-label">Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Risiko Sedang</td>
                    <td>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Prematur 28-31 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                type="radio" value="Prematur 28-31 minggu, dengan kondisi baik">
                            <label class="form-check-label">Prematur 28-31 minggu, dengan kondisi baik</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'IUGR (berat < 9 persentile)' ? 'checked' : '' }}
                                type="radio" value="IUGR (berat < 9 persentile)">
                            <label class="form-check-label">IUGR (berat < 9 persentile)</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Berat badan lahir sangat rendah 1000 - 1500 g' ? 'checked' : '' }}
                                type="radio" value="Berat badan lahir sangat rendah 1000 - 1500 g">
                            <label class="form-check-label">Berat badan lahir sangat rendah 1000 - 1500 g</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan' ? 'checked' : '' }}
                                type="radio" value="Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan">
                            <label class="form-check-label">Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Risiko Rendah</td>
                    <td>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Prematur 32 - 36 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                type="radio" value="Prematur 32 - 36 minggu, dengan kondisi baik">
                            <label class="form-check-label">Prematur 32 - 36 minggu, dengan kondisi baik</label>
                        </div>
                        <div>
                            <input required class="form-check-input"
                                name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko]"
                                {{ @$assesment['skrining_gizi_neonatus']['ketentuan_golongan_risiko']['risiko'] == 'Bayi > 37 minggu dengan kondisi baik' ? 'checked' : '' }}
                                type="radio" value="Bayi > 37 minggu dengan kondisi baik">
                            <label class="form-check-label">Bayi > 37 minggu dengan kondisi baik</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 50%; font-weight: bold;">2. Ketentuan Intervensi Dukungan Tim Nutrisi</td>
                </tr>
                <tr>
                    <td colspan="4">
                        Dukungan tim nutrisi pada bayi diberikan berdasarkan kriteria berikut :
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    Bayi yang termasuk golongan risiko tinggi
                                </td>
                                <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                    <input required type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param1][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['skrining_gizi_neonatus']['ketentuan_intervensi']['param1']['detail']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    Berat badan lahir tidak kembali dalam 2 minggu usia kelahiran
                                </td>
                                <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                    <input required type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param2][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['skrining_gizi_neonatus']['ketentuan_intervensi']['param2']['detail']}}">
                                </td>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    Penurunan berat badan > 15 %
                                </td>
                                <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                    <input required type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param3][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['skrining_gizi_neonatus']['ketentuan_intervensi']['param3']['detail']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    Penambahan berat badan < 10 g/kg/hari selama 2 minggu
                                </td>
                                <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                    <input required type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param4][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['skrining_gizi_neonatus']['ketentuan_intervensi']['param4']['detail']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    NEC atau operasi gastrointestinal
                                </td>
                                <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                    <input required type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param5][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['skrining_gizi_neonatus']['ketentuan_intervensi']['param5']['detail']}}">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

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

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            {{-- <h5><b>Ibu</b></h5> --}}
            <tr>
                <td style="width: 50%;">Nama Ibu</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][text]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['text']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Perkawinan ke</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][perkawinan_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['perkawinan_ke']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Usia Pernikahan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][usia_pernikahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['usia_pernikahan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Umur</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][umur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['umur']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Penghasilan/bulan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][penghasilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['penghasilan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Pendidikan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][pendidikan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['pendidikan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Penyakit</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][penyakit]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['penyakit']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Golongan darah</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ibu][golongan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ibu']['golongan_darah']}}">
                </td>
            </tr>
            </table>
    
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
            {{-- <h5><b>Ayah</b></h5> --}}
            <tr>
                <td style="width: 50%;">Nama Ayah</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][text]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['text']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Perkawinan ke</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][perkawinan_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['perkawinan_ke']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Usia Pernikahan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][usia_pernikahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['usia_pernikahan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Umur</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][umur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['umur']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Penghasilan/bulan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][penghasilan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['penghasilan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Pendidikan</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][pendidikan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['pendidikan']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Penyakit</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][penyakit]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['penyakit']}}">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Golongan darah</td>
                <td style="padding: 5px;">
                <input type="text" name="fisik[kelahiran_sekarang][ayah][golongan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kelahiran_sekarang']['ayah']['golongan_darah']}}">
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
                    <td style="width: 50%;">Radiologi</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[data_diganostik][radiologi]" id="" cols="30" rows="10" placeholder="Radiologi">{{ @$assesment['data_diganostik']['radiologi'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Lain-lain</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[data_diganostik][lain_lain]" id="" cols="30" rows="10" placeholder="Lain-lain">{{ @$assesment['data_diganostik']['lain_lain'] }}</textarea>
                    </td>
                </tr>
            </table>

            <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>II. DIAGNOSA KEPERAWATAN BERDASARKAN SKALA PRIORITAS</b></h5>
                <tr>
                    <td style="width: 25%;">1.</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][1]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['1'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;">2.</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][2]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['2'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;">3.</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][3]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['3'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;">4.</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][4]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['4'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;">5.</td>
                    <td colspan="2"> 
                        <textarea style="width: 100%;" name="fisik[diagnosa_keperawatan][5]" id="" cols="30" rows="3" placeholder="Diagnosa keperawatan">{{ @$assesment['diagnosa_keperawatan']['5'] }}</textarea>
                    </td>
                </tr>
              </table>

              <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Intervensi</b></h5>
                <tr>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan1]"
                                {{ @$assesment['intervensi']['pilihan1'] == 'Orientasi ruangan pada orang tua / keluarga' ? 'checked' : '' }}
                                type="checkbox" value="Orientasi ruangan pada orang tua / keluarga">
                            Orientasi ruangan pada orang tua / keluarga
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan2]"
                                {{ @$assesment['intervensi']['pilihan2'] == 'Dekatkan box bayi dengan ibu' ? 'checked' : '' }}
                                type="checkbox" value="Dekatkan box bayi dengan ibu">
                            Dekatkan box bayi dengan ibu
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan3]"
                                {{ @$assesment['intervensi']['pilihan3'] == 'Pastikan selalu ada pendamping' ? 'checked' : '' }}
                                type="checkbox" value="Pastikan selalu ada pendamping">
                            Pastikan selalu ada pendamping
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan4]"
                                {{ @$assesment['intervensi']['pilihan4'] == 'Pastikan laintai dan alas kaki tidak licin' ? 'checked' : '' }}
                                type="checkbox" value="Pastikan laintai dan alas kaki tidak licin">
                            Pastikan laintai dan alas kaki tidak licin
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan5]"
                                {{ @$assesment['intervensi']['pilihan5'] == 'Kontrol rutin oleh perawat / bidan' ? 'checked' : '' }}
                                type="checkbox" value="Kontrol rutin oleh perawat / bidan">
                            Kontrol rutin oleh perawat / bidan
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan6]"
                                {{ @$assesment['intervensi']['pilihan6'] == 'Bila dalam inkubator, pastikan semua jendela terkunci' ? 'checked' : '' }}
                                type="checkbox" value="Bila dalam inkubator, pastikan semua jendela terkunci">
                            Bila dalam inkubator, pastikan semua jendela terkunci
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[intervensi][pilihan7]"
                                {{ @$assesment['intervensi']['pilihan7'] == 'Edukasi orang tua / keluarga' ? 'checked' : '' }}
                                type="checkbox" value="Edukasi orang tua / keluarga">
                            Edukasi orang tua / keluarga
                        </div>
                    </td>
                </tr>
              </table>

              <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <h5 class="text-center"><b>Edukasi Yang Diberikan</b></h5>
                <tr>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan1]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan1'] == 'Tempatkan bayi ditempat aman' ? 'checked' : '' }}
                                type="checkbox" value="Tempatkan bayi ditempat aman">
                            Tempatkan bayi ditempat aman
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan2]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan2'] == 'Teknik menggendong bayi' ? 'checked' : '' }}
                                type="checkbox" value="Teknik menggendong bayi">
                            Teknik menggendong bayi
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan3]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan3'] == 'Cara membungkus bayi' ? 'checked' : '' }}
                                type="checkbox" value="Cara membungkus bayi">
                            Cara membungkus bayi
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan4]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan4'] == 'Segera istirahat apabila merasa lelah' ? 'checked' : '' }}
                                type="checkbox" value="Segera istirahat apabila merasa lelah">
                            Segera istirahat apabila merasa lelah
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan5]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan5'] == 'Tempatkan bayi pada boxnya' ? 'checked' : '' }}
                                type="checkbox" value="Tempatkan bayi pada boxnya">
                            Tempatkan bayi pada boxnya
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan6]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan6'] == 'Libatkan keluarga untuk mendampingi' ? 'checked' : '' }}
                                type="checkbox" value="Libatkan keluarga untuk mendampingi">
                            Libatkan keluarga untuk mendampingi
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[edukasi_yang_diberikan][pilihan7]"
                                {{ @$assesment['edukasi_yang_diberikan']['pilihan7'] == 'Segera panggil perawat bidan jika dibutuhkan' ? 'checked' : '' }}
                                type="checkbox" value="Segera panggil perawat bidan jika dibutuhkan">
                            Segera panggil perawat bidan jika dibutuhkan
                        </div>
                    </td>
                </tr>
              </table>

              <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td>
                        <h5><b>Sasaran Edukasi</b></h5>
                        <div>
                            <input class="form-check-input"
                                name="fisik[sasaran_edukasi][pilihan1]"
                                {{ @$assesment['sasaran_edukasi']['pilihan1'] == 'IBU' ? 'checked' : '' }}
                                type="checkbox" value="IBU">
                            IBU
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[sasaran_edukasi][pilihan2]"
                                {{ @$assesment['sasaran_edukasi']['pilihan2'] == 'BAPAK' ? 'checked' : '' }}
                                type="checkbox" value="BAPAK">
                            BAPAK
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[sasaran_edukasi][pilihan3]"
                                {{ @$assesment['sasaran_edukasi']['pilihan3'] == 'LAIN_LAIN' ? 'checked' : '' }}
                                type="checkbox" value="LAIN_LAIN">
                            LAIN_LAIN
                        </div>
                    </td>
                    <td>
                        <h5><b>Evaluasi</b></h5>
                        <div>
                            <input class="form-check-input"
                                name="fisik[evaluasi][pilihan1]"
                                {{ @$assesment['evaluasi']['pilihan1'] == 'Memahami dan mampu' ? 'checked' : '' }}
                                type="checkbox" value="Memahami dan mampu">
                            Memahami dan mampu
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[evaluasi][pilihan2]"
                                {{ @$assesment['evaluasi']['pilihan2'] == 'Mampu mendemonstrasikan' ? 'checked' : '' }}
                                type="checkbox" value="Mampu mendemonstrasikan">
                            Mampu mendemonstrasikan
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[evaluasi][pilihan3]"
                                {{ @$assesment['evaluasi']['pilihan3'] == 'Perlu edukasi ulang' ? 'checked' : '' }}
                                type="checkbox" value="Perlu edukasi ulang">
                            Perlu edukasi ulang
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
         
    function totalSkor(){
        var arr = $('.skorNyeriNIPS');
        var tot = 0;
        arr.each(function() {
            if ($(this).is(':checked')) {
                tot += parseInt($(this).val());
            }
        });

        $('#totalSkorId').val(tot);

        if (tot == 0) {
            $('#skoringId').val('Tidak nyeri');
        } else if (tot <= 2) {
            $('#skoringId').val('Nyeri ringan');
        } else if (tot <= 4) {
            $('#skoringId').val('Nyeri sedang');
        } else if (tot > 4) {
            $('#skoringId').val('Nyeri berat');
        }
    }
  </script>
  @endsection