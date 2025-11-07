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
</style>
@section('header')
<h1>ANESTESI</h1>
@endsection

@section('content')
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
    <form method="POST" action="{{ url('emr-anestesi-inap/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </ul>
          @php
          $dpjp = request()->get('dpjp');
          @endphp
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('record_id', @$history?$history->id : '') !!}
          {!! Form::hidden('dokter_id', @$dpjp?@$dpjp:$reg->dokter_id) !!}

          {{-- row 1 --}}
          <div class="row">
            <h4 class="text-center">ASSESMENT PRA-SEDASI / PRA-ANESTESI</h4>
          </div>
          <div class="row">
            <div class="col-md-6">
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td>Anamneses dari</td>
                  <td>
                    <input name="formulir[anmneses][pasien]" type="checkbox" {{@json_decode($data_emr,true)['anmneses']['pasien'] ? 'checked' : ''}}>
                    pasien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[anmneses][keluarga]" {{@json_decode($data_emr,true)['anmneses']['keluarga'] ? 'checked' : ''}} type="checkbox">
                    keluarga&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[anmneses][lainnya]" value="{{@json_decode($data_emr,true)['anmneses']['lainnya']}}" type="text" {{@$registrasi->pengirim_rujukan =='6' ?
                    'checked' :''}}> lainnya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Riwayat Anestesi</td>
                  <td>
                    <input name="formulir[riwayat][ada]" {{@json_decode($data_emr,true)['riwayat']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[riwayat][tidak]" {{@json_decode($data_emr,true)['riwayat']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[riwayat][lainnya]" value="{{@json_decode($data_emr,true)['riwayat']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Komplikasi</td>
                  <td>
                    <input type="checkbox" name="formulir[komp][ada]" {{@json_decode($data_emr,true)['komp']['ada'] ? 'checked' : ''}} >
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[komp][tidak]" {{@json_decode($data_emr,true)['komp']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[komp][lainnya]" value="{{@json_decode($data_emr,true)['komp']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Obat-obatan yang telah di komsumsi </td>
                  <td>
                    <textarea name="formulir[obat]" rows="3" style="width: 100%">{{@json_decode($data_emr,true)['obat']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>Riwayat alergi</td>
                  <td>
                    <input name="formulir[alergi][ada]" {{@json_decode($data_emr,true)['alergi']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[alergi][tidak]" {{@json_decode($data_emr,true)['alergi']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[alergi][lainnya]" value="{{@json_decode($data_emr,true)['alergi']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
              </table>
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td>BB : <input style="width:80px;" type="number" name="formulir[bb]" value="{{@json_decode($data_emr,true)['bb']}}"> Kg</td>
                  <td>TB : <input style="width:80px;" type="number" name="formulir[tb]" value="{{@json_decode($data_emr,true)['tb']}}"> Cm</td>
                  <td>SpO2 : <input style="width:80px;" type="number" name="formulir[spo2]" value="{{@json_decode($data_emr,true)['spo2']}}"> %</td>
                </tr>
                <tr>
                  <td rowspan="3" style="text-align:center;vertical-align:middle"><b>Tanda Vital</b></td>
                  <td>TD : <input style="width:80px;" type="text" name="formulir[td]" value="{{@json_decode($data_emr,true)['td']}}"> mmHg</td>
                  <td>Nadi : <input style="width:80px;" type="number" name="formulir[nadi]" value="{{@json_decode($data_emr,true)['nadi']}}"> x/menit</td>
                </tr>
                <tr>
                  <td>RR : <input style="width:80px;" type="number" name="formulir[rr]" value="{{@json_decode($data_emr,true)['rr']}}"> x/menit</td>
                  <td>Suhu : <input style="width:80px;" type="number" name="formulir[suhu]" value="{{@json_decode($data_emr,true)['suhu']}}"> °C</td>
                </tr>
                <tr>
                  <td>Skore Nyeri : <input style="width:80px;" type="number" placeholder="1 - 10" min="0" max="10"
                    name="formulir[skor]" value="{{@json_decode($data_emr,true)['skor']}}"></td>
                </tr>
              </table>

              {{-- Fungsi system organ --}}
               <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td class="text-center" colspan="3">
                    <b>Fungsi system organ</b>
                  </td>
                </tr>
                <tr>
                  <td class="text-center"><b>Pernafasan</b></td>
                  <td class="text-center">DBN <input name="formulir[pernafasan][dbn]" {{@json_decode($data_emr,true)['pernafasan']['dbn'] ? 'checked' : ''}} type="checkbox"></td>
                  <td class="text-center">catatan</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[pernafasan][asmah]" {{@json_decode($data_emr,true)['pernafasan']['asmah'] ? 'checked' : ''}}> Asmah</td>
                  <td><input type="checkbox" name="formulir[pernafasan][batuk]" {{@json_decode($data_emr,true)['pernafasan']['batuk'] ? 'checked' : ''}}> Batuk produktif</td>
                  <td class="text-center" rowspan="5"> <textarea name="formulir[pernafasan][catatan]" cols="30" rows="10">{{@json_decode($data_emr,true)['pernafasan']['catatan']}}</textarea></td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[pernafasan][bronchitis]" {{@json_decode($data_emr,true)['pernafasan']['bronchitis'] ? 'checked' : ''}}> Bronchitis</td>
                  <td><input type="checkbox" name="formulir[pernafasan][ispa]" {{@json_decode($data_emr,true)['pernafasan']['ispa'] ? 'checked' : ''}}> ISPA</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[pernafasan][dyspnea]" {{@json_decode($data_emr,true)['pernafasan']['dyspnea'] ? 'checked' : ''}}> Dyspnea</td>
                  <td><input type="checkbox" name="formulir[pernafasan][ppok]" {{@json_decode($data_emr,true)['pernafasan']['ppok'] ? 'checked' : ''}}> PPOK</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[pernafasan][orthopnea]" {{@json_decode($data_emr,true)['pernafasan']['orthopnea'] ? 'checked' : ''}}> Orthopnea</td>
                  <td><input type="checkbox" name="formulir[pernafasan][tuberkulosis]" {{@json_decode($data_emr,true)['pernafasan']['tuberkulosis'] ? 'checked' : ''}}> Tuberkulosis</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[pernafasan][pneumonia]" {{@json_decode($data_emr,true)['pernafasan']['pneumonia'] ? 'checked' : ''}}> Pneumonia</td>
                  <td><input type="checkbox" name="formulir[pernafasan][efusi]" {{@json_decode($data_emr,true)['pernafasan']['efusi'] ? 'checked' : ''}}> Efusi pleura</td>
                </tr>
                {{-- -------- --}}
                <tr>
                  <td class="text-center"><b>Kardiovaskular</b></td>
                  <td class="text-center">DBN <input type="checkbox" name="formulir[kardi][dbn]" {{@json_decode($data_emr,true)['kardi']['dbn'] ? 'checked' : ''}}></td>
                  <td class="text-center">catatan</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[kardi][Angina]" {{@json_decode($data_emr,true)['kardi']['Angina'] ? 'checked' : ''}}> Angina</td>
                  <td><input type="checkbox" name="formulir[kardi][HT]" {{@json_decode($data_emr,true)['kardi']['HT'] ? 'checked' : ''}}> HT</td>
                  <td class="text-center" rowspan="5"> <textarea name="formulir[kardi][catatan]" cols="30" rows="10">{{@json_decode($data_emr,true)['kardi']['catatan']}}</textarea></td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[kardi][Pacemaker]" {{@json_decode($data_emr,true)['kardi']['Pacemaker'] ? 'checked' : ''}}> Pacemaker</td>
                  <td><input type="checkbox" name="formulir[kardi][PJK]" {{@json_decode($data_emr,true)['kardi']['PJK'] ? 'checked' : ''}}> PJK</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[kardi][Disritmia]" {{@json_decode($data_emr,true)['kardi']['Disritmia'] ? 'checked' : ''}}> Disritmia</td>
                  <td><input type="checkbox" name="formulir[kardi][PJR]" {{@json_decode($data_emr,true)['kardi']['PJR'] ? 'checked' : ''}}> PJR</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[kardi][Limitasi]" {{@json_decode($data_emr,true)['kardi']['Limitasi'] ? 'checked' : ''}}> Limitasi aktivitas</td>
                  <td><input type="checkbox" name="formulir[kardi][CHD]" {{@json_decode($data_emr,true)['kardi']['CHD'] ? 'checked' : ''}}> CHD</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[kardi][jantung]" {{@json_decode($data_emr,true)['kardi']['jantung'] ? 'checked' : ''}}> Peny.jantung katup</td>
                  <td><input type="checkbox" name="formulir[kardi][Murmur]" {{@json_decode($data_emr,true)['kardi']['Murmur'] ? 'checked' : ''}}> Murmur</td>
                </tr>
                {{-- -------- --}}
                <tr>
                  <td class="text-center"><b>Neuro / Muskuloskeletal</b></td>
                  <td class="text-center">DBN <input name="formulir[neuro][dbn]" {{@json_decode($data_emr,true)['neuro']['dbn'] ? 'checked' : ''}} type="checkbox"></td>
                  <td class="text-center">catatan</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[neuro][Kelemahan]" {{@json_decode($data_emr,true)['neuro']['Kelemahan'] ? 'checked' : ''}}> Kelemahan otot</td>
                  <td><input type="checkbox" name="formulir[neuro][stroke]" {{@json_decode($data_emr,true)['neuro']['stroke'] ? 'checked' : ''}}> stroke</td>
                  <td class="text-center" rowspan="4"> <textarea name="formulir[neuro][catatan]" cols="30" rows="10">{{@json_decode($data_emr,true)['neuro']['catatan']}}</textarea></td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[neuro][Keluhan]" {{@json_decode($data_emr,true)['neuro']['Keluhan'] ? 'checked' : ''}}> Keluhan punggung</td>
                  <td><input type="checkbox" name="formulir[neuro][Kejang]" {{@json_decode($data_emr,true)['neuro']['Kejang'] ? 'checked' : ''}}> Kejang</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[neuro][Nyeri]" {{@json_decode($data_emr,true)['neuro']['Nyeri'] ? 'checked' : ''}}> Nyeri kepala</td>
                  <td><input type="checkbox" name="formulir[neuro][Epilepsi]" {{@json_decode($data_emr,true)['neuro']['Epilepsi'] ? 'checked' : ''}}> Epilepsi</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[neuro][Penurunan]" {{@json_decode($data_emr,true)['neuro']['Penurunan'] ? 'checked' : ''}}> Penurunan kesadaran</td>
                  <td><input type="checkbox" name="formulir[neuro][SOP]" {{@json_decode($data_emr,true)['neuro']['SOP'] ? 'checked' : ''}}> SOP</td>
                </tr>
                {{-- ----Renal  / Endokrin---- --}}
                <tr>
                  <td class="text-center"><b>Renal  / Endokrin</b></td>
                  <td class="text-center">DBN <input name="formulir[renal][dbn]" {{@json_decode($data_emr,true)['renal']['dbn'] ? 'checked' : ''}} type="checkbox"></td>
                  <td class="text-center">catatan</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[renal][DM]" {{@json_decode($data_emr,true)['renal']['DM'] ? 'checked' : ''}}> DM</td>
                  <td><input type="checkbox" name="formulir[renal][Thiroid]" {{@json_decode($data_emr,true)['renal']['Thiroid'] ? 'checked' : ''}}> Peny. Thiroid</td>
                  <td class="text-center" rowspan="2"> <textarea name="formulir[renal][catatan]" cols="30" rows="10">{{@json_decode($data_emr,true)['renal']['catatan']}}</textarea></td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[renal][Ginjal]" {{@json_decode($data_emr,true)['renal']['Ginjal'] ? 'checked' : ''}}> Peny.Ginjal</td>
                  <td><input type="checkbox" name="formulir[renal][Lain]" {{@json_decode($data_emr,true)['renal']['Lain'] ? 'checked' : ''}}> Peny. Lain</td>
                </tr>
                {{-- -------- --}}
                <tr>
                  <td class="text-center"><b>Hepato / Gastrointestinal</b></td>
                  <td class="text-center" name="formulir[hepato][dbn]" {{@json_decode($data_emr,true)['hepato']['dbn'] ? 'checked' : ''}}>DBN <input type="checkbox"></td>
                  <td class="text-center">catatan</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[hepato][Obstruksi]" {{@json_decode($data_emr,true)['hepato']['Obstruksi'] ? 'checked' : ''}}> Obstruksi usus</td>
                  <td><input type="checkbox" name="formulir[hepato][Sirosis]" {{@json_decode($data_emr,true)['hepato']['Sirosis'] ? 'checked' : ''}}> Sirosis</td>
                  <td class="text-center" rowspan="3"> <textarea name="formulir[hepato][catatan]" cols="30" rows="10">{{@json_decode($data_emr,true)['hepato']['catatan']}}</textarea></td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[hepato][Hepatitis]" {{@json_decode($data_emr,true)['hepato']['Hepatitis'] ? 'checked' : ''}}> Hepatitis/icterus</td>
                  <td><input type="checkbox" name="formulir[hepato][Tukak]" {{@json_decode($data_emr,true)['hepato']['Tukak'] ? 'checked' : ''}}> Tukak peptik</td>
                </tr>
                <tr>
                  <td><input type="checkbox" name="formulir[hepato][Hiatal]" {{@json_decode($data_emr,true)['hepato']['Hiatal'] ? 'checked' : ''}}> Hiatal hernia/efflux</td>
                  <td><input type="checkbox" name="formulir[hepato][Mual]" {{@json_decode($data_emr,true)['hepato']['Mual'] ? 'checked' : ''}}> Mual / Muntah</td>
                </tr>
              </table>

              <br/>
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td><b>PS ASA	Penyulit</b>	: 
                    1 <input name="formulir[ps][1]" {{@json_decode($data_emr,true)['ps']['1'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    2 <input name="formulir[ps][2]" {{@json_decode($data_emr,true)['ps']['2'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    3 <input name="formulir[ps][3]" {{@json_decode($data_emr,true)['ps']['3'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4 <input name="formulir[ps][4]" {{@json_decode($data_emr,true)['ps']['4'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    5 <input name="formulir[ps][4]" {{@json_decode($data_emr,true)['ps']['4'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D <input name="formulir[ps][d]" {{@json_decode($data_emr,true)['ps']['d'] ? 'checked' : ''}} type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    	
                    </td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              {{-- Evaluasi --}}
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td class="text-center" colspan="2">
                    <b>Evaluasi jalan napas</b>
                  </td>
                </tr>
                <tr>
                  <td>Bebas</td>
                  <td>
                    <input type="checkbox" name="formulir[bebas][ya]" {{@json_decode($data_emr,true)['bebas']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="formulir[bebas][tidak]" {{@json_decode($data_emr,true)['bebas']['tidak'] ? 'checked' : ''}}> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Protrusi mandibular</td>
                  <td>
                    <input type="checkbox" name="formulir[protusi][ya]" {{@json_decode($data_emr,true)['protusi']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[protusi][tidak]" {{@json_decode($data_emr,true)['protusi']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Buka mulut 3 jari</td>
                  <td>
                    <input type="checkbox" name="formulir[buka][normal]" {{@json_decode($data_emr,true)['buka']['normal'] ? 'checked' : ''}}>
                    normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[buka][tidak]" {{@json_decode($data_emr,true)['buka']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Jarak mentohyoid 3 jari</td>
                  <td>
                    <input type="checkbox" name="formulir[jarak][normal]" {{@json_decode($data_emr,true)['jarak']['normal'] ? 'checked' : ''}}>
                    normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[jarak][tidak]" {{@json_decode($data_emr,true)['jarak']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Jarak hyothiroid 2 jari</td>
                  <td>
                    <input type="checkbox" name="formulir[jarak2][normal]" {{@json_decode($data_emr,true)['jarak2']['normal'] ? 'checked' : ''}}>
                    normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[jarak2][tidak]" {{@json_decode($data_emr,true)['jarak2']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Leher</td>
                  <td>
                    <input type="checkbox" name="formulir[leher][pendek]" {{@json_decode($data_emr,true)['leher']['pendek'] ? 'checked' : ''}}>
                    pendek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[leher][tidak]" {{@json_decode($data_emr,true)['leher']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Gerak leher</td>
                  <td>
                    <input type="checkbox" name="formulir[gerak_leher][bebas]" {{@json_decode($data_emr,true)['gerak_leher']['bebas'] ? 'checked' : ''}}>
                    bebas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="formulir[gerak_leher][tidak]" {{@json_decode($data_emr,true)['gerak_leher']['tidak'] ? 'checked' : ''}}> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Mallampathy</td>
                  <td>
                    <input type="checkbox" name="formulir[Mallampathy][i]" {{@json_decode($data_emr,true)['Mallampathy']['i'] ? 'checked' : ''}}>I
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="formulir[Mallampathy][ii]" {{@json_decode($data_emr,true)['Mallampathy']['ii'] ? 'checked' : ''}}> II
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="formulir[Mallampathy][iii]" {{@json_decode($data_emr,true)['Mallampathy']['iii'] ? 'checked' : ''}}> III
                  </td>
                </tr>
                <tr>
                  <td>Obesitas</td>
                  <td>
                    <input type="checkbox" name="formulir[Obesitas][ya]" {{@json_decode($data_emr,true)['Obesitas']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[Obesitas][tidak]" {{@json_decode($data_emr,true)['Obesitas']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Massa</td>
                  <td>
                    <input type="checkbox" name="formulir[Massa][ya]" {{@json_decode($data_emr,true)['Massa']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[Massa][tidak]" {{@json_decode($data_emr,true)['Massa']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Gigi palsu</td>
                  <td>
                    <input type="checkbox" name="formulir[gigipalsu][ya]" {{@json_decode($data_emr,true)['gigipalsu']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[gigipalsu][tidak]" {{@json_decode($data_emr,true)['gigipalsu']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>
                <tr>
                  <td>Sulit ventilasi</td>
                  <td>
                    <input type="checkbox" name="formulir[sulitventilasi][ya]" {{@json_decode($data_emr,true)['sulitventilasi']['ya'] ? 'checked' : ''}}>
                    Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[sulitventilasi][tidak]" {{@json_decode($data_emr,true)['sulitventilasi']['tidak'] ? 'checked' : ''}} type="checkbox"> Tidak
                  </td>
                </tr>

              </table>

              {{-- RENCANA SEDASI / ANESTESI --}}
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td class="text-center" colspan="3">
                    <b>RENCANA SEDASI / ANESTESI</b>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">Obat premedikasi</td>
                  <td class="text-center">Dosis</td>
                  <td class="text-center">Cara</td>
                </tr>
                {{-- @for ($i = 0; $i <= 3; $i++) --}}
                <tr>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['obat']['0']}} name="formulir[rencana][obat][0]"></td>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['dosis']['0']}} name="formulir[rencana][dosis][0]"></td>
                  <td><input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['iv']['0'] ? 'checked' : ''}} name="formulir[rencana][cara][iv][0]">iv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['im']['0'] ? 'checked' : ''}} name="formulir[rencana][cara][im][0]"> im</td>
                </tr>
                <tr>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['obat']['1']}} name="formulir[rencana][obat][1]"></td>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['dosis']['1']}} name="formulir[rencana][dosis][1]"></td>
                  <td><input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['iv']['1'] ? 'checked' : ''}} name="formulir[rencana][cara][iv][1]">iv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['im']['1'] ? 'checked' : ''}} name="formulir[rencana][cara][im][1]"> im</td>
                </tr>
                <tr>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['obat']['2']}} name="formulir[rencana][obat][2]"></td>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['dosis']['2']}} name="formulir[rencana][dosis][2]"></td>
                  <td><input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['iv']['2'] ? 'checked' : ''}} name="formulir[rencana][cara][iv][2]">iv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['im']['2'] ? 'checked' : ''}} name="formulir[rencana][cara][im][2]"> im</td>
                </tr>
                <tr>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['obat']['3']}} name="formulir[rencana][obat][3]"></td>
                  <td class="text-center"><input type="text" {{@json_decode($data_emr,true)['rencana']['dosis']['3']}} name="formulir[rencana][dosis][3]"></td>
                  <td><input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['iv']['3'] ? 'checked' : ''}} name="formulir[rencana][cara][iv][3]">iv&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="checkbox" {{@json_decode($data_emr,true)['rencana']['cara']['im']['3'] ? 'checked' : ''}} name="formulir[rencana][cara][im][3]"> im</td>
                </tr>
                    
                {{-- @endfor --}}
              </table>

              {{-- Rencana Teknik Anestesi --}}
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td class="text-center">
                    <b>Rencana Teknik Anestesi</b>
                  </td>
                </tr>
                <tr>
                  <td>
                    General Anestesi : <br/>
                    <input type="checkbox" name="formulir[general][TIVA]" {{@json_decode($data_emr,true)['general']['TIVA'] ? 'checked' : ''}}>&nbsp;TIVA<br/>
                    <input type="checkbox" name="formulir[general][Face]" {{@json_decode($data_emr,true)['general']['Face'] ? 'checked' : ''}}>&nbsp;Face Mask<br/>
                    <input type="checkbox" name="formulir[general][LMA]" {{@json_decode($data_emr,true)['general']['LMA'] ? 'checked' : ''}}>&nbsp;LMA<br/>
                    <input type="checkbox" name="formulir[general][Intubasi]" {{@json_decode($data_emr,true)['general']['Intubasi'] ? 'checked' : ''}}>&nbsp;Intubasi
                  </td>
                </tr>
                <tr>
                  <td>Regional Anestesi :<br/>
                    <input type="checkbox" name="formulir[Regional][SAB]" {{@json_decode($data_emr,true)['Regional']['SAB'] ? 'checked' : ''}}>&nbsp;SAB<br/>
                    <input type="checkbox" name="formulir[Regional][Epidural]" {{@json_decode($data_emr,true)['Regional']['Epidural'] ? 'checked' : ''}}>&nbsp;Epidural<br/>
                    <input type="checkbox" name="formulir[Regional][PNB]" {{@json_decode($data_emr,true)['Regional']['PNB'] ? 'checked' : ''}}>&nbsp;PNB<br/>
                  </td>
                </tr>
              </table>

              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td class="text-center">Diperiksa Oleh<br>
                  ({{baca_dokter($reg->dokter_id)}})
                  </td>
                </tr>
              </table>
            </div>

          </div>

          {{-- row 2 --}}
          <h4 class="text-center">ASSESMENT PRA INDUKSI</h4>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td>Makan terakhir : <input style="width:80px;" type="text" name="formulir[makan_terakhir]" value="{{@json_decode($data_emr,true)['makan_terakhir']}}"> WIT</td>
                  <td>Minum terakhir : <input style="width:80px;" type="text" name="formulir[minum_terakhir]" value="{{@json_decode($data_emr,true)['minum_terakhir']}}"> WIT</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td rowspan="2" style="text-align:center;vertical-align:middle"><b>Vital sign</b></td>
                  <td>TD : 
                    <input style="width:80px;" type="number" name="formulir[pra_td]" value="{{@json_decode($data_emr,true)['pra_td']}}"> /
                    <input style="width:80px;" type="number" name="formulir[pra_td2]" value="{{@json_decode($data_emr,true)['pra_td2']}}"> mmHg
                  </td>
                  <td>RR : <input style="width:80px;" type="number" name="formulir[pra_rr]" value="{{@json_decode($data_emr,true)['pra_rr']}}"> x/menit</td>
                  <td>Skore Nyeri : <input style="width:80px;" type="number" placeholder="1 - 10" min="0" max="10"
                    name="formulir[pra_skor]" value="{{@json_decode($data_emr,true)['pra_skor']}}"></td>
                </tr>
                <tr>
                  <td>HR : <input style="width:80px;" type="number" name="formulir[pra_hr]" value="{{@json_decode($data_emr,true)['pra_hr']}}"> x/ menit</td>
                  <td>Suhu : <input style="width:80px;" type="number" name="formulir[pra_suhu]" value="{{@json_decode($data_emr,true)['pra_suhu']}}"> c</td>
                  <td>SpO2 : <input style="width:80px;" type="number" name="formulir[pra_spo2]" value="{{@json_decode($data_emr,true)['pra_spo2']}}"> %</td>
                </tr> 
                <tr>
                  <td>Masalah saat evaluasi pra induksi</td>
                  <td>
                    <input name="formulir[masalah][ada]" {{@json_decode($data_emr,true)['masalah']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[masalah][tidak]" {{@json_decode($data_emr,true)['masalah']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[masalah][lainnya]" value="{{@json_decode($data_emr,true)['masalah']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Perubahan rencana anestesi</td>
                  <td>
                    <input name="formulir[perubahan][ada]" {{@json_decode($data_emr,true)['perubahan']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[perubahan][tidak]" {{@json_decode($data_emr,true)['perubahan']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[perubahan][lainnya]" value="{{@json_decode($data_emr,true)['perubahan']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Persiapan darah</td>
                  <td>
                    <input name="formulir[persiapan][ada]" {{@json_decode($data_emr,true)['persiapan']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[persiapan][tidak]" {{@json_decode($data_emr,true)['persiapan']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[persiapan][lainnya]" value="{{@json_decode($data_emr,true)['persiapan']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
              </table>
            </div>
          </div>

          {{-- row 3 --}}
          <h4 class="text-center">INDUKSI</h4>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-striped table-bordered" cellpadding="3" style="width:100%;font-size:12px;">
                <tr>
                  <td>
                    Teknik induksi : <br/>
                    <input type="checkbox" name="formulir[teknik][Masker]" {{@json_decode($data_emr,true)['teknik']['Masker'] ? 'checked' : ''}}>&nbsp;Masker  02 <input style="width:80px;" value="{{@json_decode($data_emr,true)['teknik']['Masker_value']}}" type="text" name="formulir[teknik][Masker_value]"> LPM<br/>
                    <input type="checkbox" name="formulir[teknik][Nasal]" {{@json_decode($data_emr,true)['teknik']['Nasal'] ? 'checked' : ''}}>&nbsp;Nasal 02 <input style="width:80px;" value="{{@json_decode($data_emr,true)['teknik']['nasal_value']}}" type="text" name="formulir[teknik][nasal_value]">LPM<br/>
                    <input type="checkbox" name="formulir[teknik][preogsigenasi]" {{@json_decode($data_emr,true)['teknik']['preogsigenasi'] ? 'checked' : ''}}>&nbsp;preogsigenasi<br/>
                    <input type="checkbox" name="formulir[teknik][Intravena]" {{@json_decode($data_emr,true)['teknik']['Intravena'] ? 'checked' : ''}}>&nbsp;Induksi Intravena
                    <input type="checkbox" name="formulir[teknik][Inhalasi ]" {{@json_decode($data_emr,true)['teknik']['Inhalasi '] ? 'checked' : ''}}>&nbsp;Induksi Inhalasi 
                  </td>
                  <td>
                    Airway : <br/>
                    <input type="checkbox" name="formulir[airway][Masker]" {{@json_decode($data_emr,true)['airway']['Masker'] ? 'checked' : ''}}>&nbsp;Masker<br/>
                    <input type="checkbox" name="formulir[airway][SAD]" {{@json_decode($data_emr,true)['airway']['SAD'] ? 'checked' : ''}}>&nbsp;SAD : LMA/ I-Gel/ <input style="width:80px;" value="{{@json_decode($data_emr,true)['airway']['sad_value1']}}" type="text" name="formulir[airway][sad_value1]">
                    ukuran <input style="width:80px;" value="{{@json_decode($data_emr,true)['airway']['sad_value2']}}" type="text" name="formulir[airway][sad_value2]">
                    cuff <input style="width:80px;" value="{{@json_decode($data_emr,true)['airway']['sad_value3']}}" type="text" name="formulir[airway][sad_value3]">ml
                    <br/>
                    <input type="checkbox" name="formulir[airway][Intubasi]" {{@json_decode($data_emr,true)['airway']['Intubasi'] ? 'checked' : ''}}>&nbsp;Intubasi teknik<br/>
                    <input type="checkbox" name="formulir[airway][Sleep]" {{@json_decode($data_emr,true)['airway']['Sleep'] ? 'checked' : ''}}>&nbsp;Sleep    
                    <input type="checkbox" name="formulir[airway][Apnea]" {{@json_decode($data_emr,true)['airway']['Apnea'] ? 'checked' : ''}}>&nbsp;Apnea    
                    <input type="checkbox" name="formulir[airway][Oral]" {{@json_decode($data_emr,true)['airway']['Oral'] ? 'checked' : ''}}>&nbsp;Oral    
                    <input type="checkbox" name="formulir[airway][Direct]" {{@json_decode($data_emr,true)['airway']['Direct'] ? 'checked' : ''}}>&nbsp;Direct    
                    <input type="checkbox" name="formulir[airway][RSI]" {{@json_decode($data_emr,true)['airway']['RSI'] ? 'checked' : ''}}>&nbsp;RSI    
                    <br/>
                    <input type="checkbox" name="formulir[airway][Awake]" {{@json_decode($data_emr,true)['airway']['Awake'] ? 'checked' : ''}}>&nbsp;Awake    
                    <input type="checkbox" name="formulir[airway][Non_Apnea]" {{@json_decode($data_emr,true)['airway']['Non_Apnea'] ? 'checked' : ''}}>&nbsp;Non-Apnea    
                    <input type="checkbox" name="formulir[airway][Nasal]" {{@json_decode($data_emr,true)['airway']['Nasal'] ? 'checked' : ''}}>&nbsp;Nasal    
                    <input type="checkbox" name="formulir[airway][Blind]" {{@json_decode($data_emr,true)['airway']['Blind'] ? 'checked' : ''}}>&nbsp;Blind    
                    <input type="checkbox" name="formulir[airway][Cricoid_Pres]" {{@json_decode($data_emr,true)['airway']['Cricoid_Pres'] ? 'checked' : ''}}>&nbsp;Cricoid Pres    
                  </td>
                </tr>
                <tr>
                  <td rowspan="3" style="">
                    Alat : <br/>
                    <input type="checkbox" name="formulir[alat][Stylet]" {{@json_decode($data_emr,true)['alat']['Stylet'] ? 'checked' : ''}}>&nbsp;Stylet<br/>
                    <input type="checkbox" name="formulir[alat][Magil]" {{@json_decode($data_emr,true)['alat']['Magil'] ? 'checked' : ''}}>&nbsp;Magil<br/>
                    <input type="checkbox" name="formulir[alat][Laryngoscope ]" {{@json_decode($data_emr,true)['alat']['Laryngoscope '] ? 'checked' : ''}}>&nbsp;Laryngoscope sesuai ukuran <br/>
                    <input type="checkbox" name="formulir[alat][Video ]" {{@json_decode($data_emr,true)['alat']['Video '] ? 'checked' : ''}}>&nbsp;Video Laryngoscope
                  </td>
                  <td colspan="3">
                    ETT : <br/>
                    <input type="checkbox" name="formulir[ett][Reguler]" {{@json_decode($data_emr,true)['ett']['Reguler'] ? 'checked' : ''}}>&nbsp;Reguler
                    <input type="checkbox" name="formulir[ett][Reinforced]" {{@json_decode($data_emr,true)['ett']['Reinforced'] ? 'checked' : ''}}>&nbsp;Reinforced    
                    <input type="checkbox" name="formulir[ett][reformed]" {{@json_decode($data_emr,true)['ett']['reformed'] ? 'checked' : ''}}>&nbsp;reformed
                    <input type="checkbox" name="formulir[ett][Doble]" {{@json_decode($data_emr,true)['ett']['Doble'] ? 'checked' : ''}}>&nbsp;Doble Lumen D/S
                    <br/>
                    ukuran <input style="width:80px;" value="{{@json_decode($data_emr,true)['ett']['sad_value2']}}" type="text" name="formulir[ett][sad_value2]">
                    cuff <input style="width:80px;" value="{{@json_decode($data_emr,true)['ett']['sad_value3']}}" type="text" name="formulir[ett][sad_value3]">
                    <input type="checkbox" name="formulir[ett][oral]" {{@json_decode($data_emr,true)['ett']['oral'] ? 'checked' : ''}}>&nbsp;oral
                    <input type="checkbox" name="formulir[ett][Nasal]" {{@json_decode($data_emr,true)['ett']['Nasal'] ? 'checked' : ''}}>&nbsp;Nasal
                    <br/>
                    Upaya <input style="width:80px;" value="{{@json_decode($data_emr,true)['ett']['Upaya']}}" type="text" name="formulir[ett][Upaya]">x
                    <input type="checkbox" name="formulir[ett][ettco2]" {{@json_decode($data_emr,true)['ett']['ettco2'] ? 'checked' : ''}}>&nbsp;ETT CO2
                    <br/>
                    Fixasi <input style="width:80px;" value="{{@json_decode($data_emr,true)['ett']['Fixasi']}}" type="text" name="formulir[ett][Fixasi]">cm &nbsp;
                    <input type="checkbox" name="formulir[ett][Tampon]" {{@json_decode($data_emr,true)['ett']['Tampon'] ? 'checked' : ''}}>&nbsp;Tampon
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    Anestesi regional  : 
                    <input type="checkbox" name="formulir[anregional][SAB]" {{@json_decode($data_emr,true)['anregional']['SAB'] ? 'checked' : ''}}>&nbsp;SAB    
                    <input type="checkbox" name="formulir[anregional][CSE]" {{@json_decode($data_emr,true)['anregional']['CSE'] ? 'checked' : ''}}>&nbsp;CSE
                    <input type="checkbox" name="formulir[anregional][Epidural]" {{@json_decode($data_emr,true)['anregional']['Epidural'] ? 'checked' : ''}}>&nbsp;Epidural
                    <input type="checkbox" name="formulir[anregional][Caudal]" {{@json_decode($data_emr,true)['anregional']['Caudal'] ? 'checked' : ''}}>&nbsp;Caudal
                    <input type="checkbox" name="formulir[anregional][PNB]" {{@json_decode($data_emr,true)['anregional']['PNB'] ? 'checked' : ''}}>&nbsp;PNB
                  </td>
                </tr> 
                <tr>
                  <td colspan="3">
                    Jenis jarum<input style="width:250px;" value="{{@json_decode($data_emr,true)['last']['jarum']}}" type="text" name="formulir['last']['jarum']"><br/><br/>
                    Jenis PNB<input style="width:250px;" value="{{@json_decode($data_emr,true)['last']['pnb']}}" type="text" name="formulir['last']['pnb']">
                    <br/>
                    Obat <input style="width:80px;" value="{{@json_decode($data_emr,true)['last']['obat']}}" type="text" name="formulir[last][obat]">%
                    Dosis <input style="width:80px;" value="{{@json_decode($data_emr,true)['last']['dosis']}}" type="text" name="formulir[last][dosis]">mg
                    Vol <input style="width:80px;" value="{{@json_decode($data_emr,true)['last']['Vol']}}" type="text" name="formulir[last][Vol]">cc
                    <br/>
                    Epidural <input style="width:250px;" value="{{@json_decode($data_emr,true)['last']['Epidural']}}" type="text" name="formulir[ett][Epidural]">Test dose +/
                  </td>
                </tr>
                <tr>
                  <td>Masalah saat evaluasi pra induksi</td>
                  <td>
                    <input name="formulir[masalah][ada]" {{@json_decode($data_emr,true)['masalah']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[masalah][tidak]" {{@json_decode($data_emr,true)['masalah']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[masalah][lainnya]" value="{{@json_decode($data_emr,true)['masalah']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Perubahan rencana anestesi</td>
                  <td>
                    <input name="formulir[perubahan][ada]" {{@json_decode($data_emr,true)['perubahan']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[perubahan][tidak]" {{@json_decode($data_emr,true)['perubahan']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[perubahan][lainnya]" value="{{@json_decode($data_emr,true)['perubahan']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>Persiapan darah</td>
                  <td>
                    <input name="formulir[persiapan][ada]" {{@json_decode($data_emr,true)['persiapan']['ada'] ? 'checked' : ''}} type="checkbox">
                    Ada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="formulir[persiapan][tidak]" {{@json_decode($data_emr,true)['persiapan']['tidak'] ? 'checked' : ''}} type="checkbox"> tidak ada<br />(sebutkan jika ada) <input
                      type="text" name="formulir[persiapan][lainnya]" value="{{@json_decode($data_emr,true)['persiapan']['lainnya']}}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    Posisi :<br/>
                    <input type="checkbox" name="formulir[posisi][supine]" {{@json_decode($data_emr,true)['posisi']['supine'] ? 'checked' : ''}}>&nbsp;supine    
                    <input type="checkbox" name="formulir[posisi][prone]" {{@json_decode($data_emr,true)['posisi']['prone'] ? 'checked' : ''}}>&nbsp;prone
                    <input type="checkbox" name="formulir[posisi][Lithotomy]" {{@json_decode($data_emr,true)['posisi']['Lithotomy'] ? 'checked' : ''}}>&nbsp;Lithotomy    
                    <input type="checkbox" name="formulir[posisi][Lateral]" {{@json_decode($data_emr,true)['posisi']['Lateral'] ? 'checked' : ''}}>&nbsp;Lateral    
                    <input type="checkbox" name="formulir[posisi][Tredelenburg]" {{@json_decode($data_emr,true)['posisi']['Tredelenburg'] ? 'checked' : ''}}>&nbsp;Tredelenburg
                    <input type="text" name="formulir[posisi][lainnya]" value="{{@json_decode($data_emr,true)['posisi']['lainnya']}}"> Lainnya

                  </td>
                </tr>
              </table>
            </div>
          </div>

          <br /><br />
        </div>
      </div>

      <div class="col-md-12 text-right">
        <br />
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br />
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-center"><b>Catatan Medis</b></h4>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Penginput</th>
              <th>Tanggal</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($riwayat as $key=>$item)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{baca_user($item->user_id)}}</td>
              <td>{{date('d-m-Y H:i',strtotime($item->created_at))}}</td>
              <td>
                {{-- <button type="button" id="historipasien" id-data="{{@$item->id}}"
                  class="btn btn-warning btn-xs btn-flat">
                  <i class="fa fa-th-list"></i> Lihat
                </button> --}}
                <a class="btn btn-info btn-xs btn-flat" 
                  href="{{url('emr-anestesi-inap/'.$reg->id.'/'.$item->id.'/edit')}}"><i class="fa fa-eye"></i> Lihat</button>&nbsp;&nbsp;
                <a class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin akan menghapus data?')"
                  href="{{url('emr-anestesi-inap/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip"
                  title="Hapus"><i class="fa fa-trash"></i> Hapus</button>&nbsp;&nbsp;
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
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
         
        // HISTORY PASIEN
        $(document).on('click', '#historipasien', function (e) {
          $('#dataHistoriPasien').html('');
          var id = $(this).attr('id-data');
          $('#showHistoriPasien').modal('show');
          $('#dataHistoriPasien').load("/rekonsiliasi-obat-show/"+id);
        });

        // MASTER OBAT
        $('.masterObat').select2({
            placeholder: "Klik untuk isi nama obat",
            width: '100%',
            ajax: {
                url: '/penjualan/master-obat-rekonsiliasi/',
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
  </script>
  @endsection