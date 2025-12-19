@extends('master')

<style>
  .form-box td, select,input,textarea{
    font-size: 12px !important;
  }
  .history-family input[type=text]{
    height:20px !important;
    padding:0px !important;
  }
  .history-family-2 td{
    padding:1px !important;
  }
</style>
@section('header')
  <h1>Pemeriksaan Fisik - {{baca_unit($unit)}}</h1>
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
        <form method="POST" action="{{ url('emr-soap/pemeriksaan/fisikumum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">

          <div class="row">

            <div class="col-md-12">
              {{ csrf_field() }}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
              {!! Form::hidden('cara_bayar', $reg->bayar) !!}
              {!! Form::hidden('unit', $unit) !!} 
              <br> 
              @include('emr.modules.addons.tabs')
              
              <div class="col-md-6">
                <h5><b>Pemeriksaan Fisik</b></h5>
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                       style="font-size:12px;">
                       <td rowspan="100" style="width:20%;">Pemeriksaan Fisik</td>
                       <td rowspan="6"  style="width:20%;">Persarafan</td>
                       <td  style="padding: 5px;" class="pemeriksaan">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[persarafan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['tidak_ada_keluhan']) == 'Tidak Ada Keluhan') 
                          <input class="form-check-input"  name="pemeriksaan[persarafan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[persarafan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                       </td>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[persarafan][tremor]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['tremor']))
                              <input class="form-check-input"  name="pemeriksaan[persarafan][tremor]" type="checkbox" value="Tremor" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[persarafan][tremor]" type="checkbox" value="Tremor" id="flexCheckDefault">
                              @endif
                               Tremor
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[persarafan][kejang]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['kejang']))
                              <input class="form-check-input"  name="pemeriksaan[persarafan][kejang]" type="checkbox" value="Kejang" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[persarafan][kejang]" type="checkbox" value="Kejang" id="flexCheckDefault">
                              @endif
                               Kejang
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[persarafan][paralise]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['paralise']))
                              <input class="form-check-input"  name="pemeriksaan[persarafan][paralise]" type="checkbox" value="Paralise" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[persarafan][paralise]" type="checkbox" value="Paralise" id="flexCheckDefault">
                              @endif
                               Paralise
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[persarafan][hemiparese]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['hemiparese']))
                              <input class="form-check-input"  name="pemeriksaan[persarafan][hemiparese]" type="checkbox" value="Hemiparese/Hemiplegia" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[persarafan][hemiparese]" type="checkbox" value="Hemiparese/Hemiplegia" id="flexCheckDefault">
                              @endif
                               Hemiparese/Hemiplegia
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['persarafan']['text']))
                             <input name="pemeriksaan[persarafan][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['persarafan']['text'] }}" required>
                           @else
                             <input name="pemeriksaan[persarafan][text]" type="text" class="form-control" id="" value="" >
                           @endif
                            </td>
                         </tr>
                       </td>
                                 
       
       
                       <td rowspan="4"  style="width:20%;">Pernapasan</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[pernapasan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['pernapasan']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[pernapasan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[pernapasan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[pernapasan][sekret]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['pernapasan']['sekret']))
                              <input class="form-check-input"  name="pemeriksaan[pernapasan][sekret]" type="checkbox" value="Sekret" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[pernapasan][sekret]" type="checkbox" value="Sekret" id="flexCheckDefault">
                              @endif
                               Sekret
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[pernapasan][sesak_napas]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['pernapasan']['sesak_napas']))
                              <input class="form-check-input"  name="pemeriksaan[pernapasan][sesak_napas]" type="checkbox" value="Sesak Napas" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[pernapasan][sesak_napas]" type="checkbox" value="Sesak Napas" id="flexCheckDefault">
                              @endif
                               Sesak Napas
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['pernapasan']['text']))
                             <input name="pemeriksaan[pernapasan][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['pernapasan']['text'] }}" >
                           @else
                             <input name="pemeriksaan[pernapasan][text]" type="text" class="form-control" id="" value="" >
                           @endif
                           </td>
                         </tr>
                       </td>
                       
                       
       
       
       
       
       
                       <td rowspan="5"  style="width:20%;">Pencernaan</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[pencernaan][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['pencernaan']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[pencernaan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[pencernaan][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[pencernaan][konstipasi]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['pencernaan']['konstipasi']))
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][konstipasi]" type="checkbox" value="Konstipasi" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][konstipasi]" type="checkbox" value="konstipasi" id="flexCheckDefault">
                              @endif
                               Konstipasi
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[pencernaan][mual]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['pencernaan']['mual']))
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][mual]" type="checkbox" value="Mual" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][mual]" type="checkbox" value="Mual" id="flexCheckDefault">
                              @endif
                               Mual/Muntah
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[pencernaan][diare]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['pencernaan']['diare']))
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][diare]" type="checkbox" value="Diare" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[pencernaan][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                              @endif
                               Diare
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['pencernaan']['text']))
                            <input name="pemeriksaan[pencernaan][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['pencernaan']['text'] }}" >
                          @else
                            <input name="pemeriksaan[pencernaan][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>                  
                       </td>
       
                       {{-- @php
                           dd($riwayat);
                       @endphp --}}
       
                       <td rowspan="6"  style="width:20%;">Endokrin</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[endokrin][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[endokrin][tidak_ada_keluhan]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[endokrin][tidak_ada_keluhan]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[endokrin][keringat_banyak]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['keringat_banyak']))
                              <input class="form-check-input"  name="pemeriksaan[endokrin][keringat_banyak]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[endokrin][keringat_banyak]" type="checkbox" value="Keringat Banyak" id="flexCheckDefault">
                              @endif

                              Keringat Banyak

                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[endokrin][pembesaran_kelenjar_tiroid]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['pembesaran_kelenjar_tiroid']))
                              <input class="form-check-input"  name="pemeriksaan[endokrin][pembesaran_kelenjar_tiroid]" type="checkbox" value="Pembesaran Kelenjar Tiroid" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[endokrin][pembesaran_kelenjar_tiroid]" type="checkbox" value="Pembesaran Kelenjar Tiroid" id="flexCheckDefault">
                              @endif
                               Pembesaran Kelenjar Tiroid
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[endokrin][diare]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['diare']))
                              <input class="form-check-input"  name="pemeriksaan[endokrin][diare]" type="checkbox" value="Diare" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[endokrin][diare]" type="checkbox" value="Diare" id="flexCheckDefault">
                              @endif
                               Diare
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[endokrin][napas_baus]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['napas_baus']))
                              <input class="form-check-input"  name="pemeriksaan[endokrin][napas_baus]" type="checkbox" value="Napas Bau" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[endokrin][napas_baus]" type="checkbox" value="Napas Bau" id="flexCheckDefault">
                              @endif
                               Napas Bau
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['endokrin']['text']))
                            <input name="pemeriksaan[endokrin][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['endokrin']['text'] }}" >
                          @else
                            <input name="pemeriksaan[endokrin][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                         
                       </td>
       
       
       
       
       
                       <td rowspan="4"  style="width:20%;">Kardiovaskuler</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[kardiovaskuler][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['kardiovaskuler']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kardiovaskuler][oedema]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kardiovaskuler']['oedema']))
                              <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][oedema]" type="checkbox" value="Oedema" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][oedema]" type="checkbox" value="Oedema" id="flexCheckDefault">
                              @endif
                               Oedema
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kardiovaskuler][chest_pain]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kardiovaskuler']['chest_pain']))
                              <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][chest_pain]" type="checkbox" value="chest pain" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kardiovaskuler][chest_pain]" type="checkbox" value="chest pain" id="flexCheckDefault">
                              @endif
                               Chest Pain
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['kardiovaskuler']['text']))
                            <input name="pemeriksaan[kardiovaskuler][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['kardiovaskuler']['text'] }}" >
                          @else
                            <input name="pemeriksaan[kardiovaskuler][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                         
                       </td>
                       <td rowspan="10"  style="width:20%;">Abdomen</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[abdomen][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[abdomen][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[abdomen][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][membesar]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['membesar']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][membesar]" type="checkbox" value="Membesar" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][membesar]" type="checkbox" value="Membesar" id="flexCheckDefault">
                              @endif
                               Membesar
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][nyeri_tekan]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['nyeri_tekan']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][nyeri_tekan]" type="checkbox" value="Nyeri Tekan" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][nyeri_tekan]" type="checkbox" value="Nyeri Tekan" id="flexCheckDefault">
                              @endif
                               Nyeri Tekan
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][luka]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['luka']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][luka]" type="checkbox" value="Luka" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                              @endif
                               Luka
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][distensi]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['distensi']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][distensi]" type="checkbox" value="Distensi" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][distensi]" type="checkbox" value="Distensi" id="flexCheckDefault">
                              @endif
                               Distensi
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][L_I]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['L_I']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_I]" type="checkbox" value="L_I" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_I]" type="checkbox" value="L_I" id="flexCheckDefault">
                              @endif
                               L I
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][L_II]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['L_II']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_II]" type="checkbox" value="L_II" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_II]" type="checkbox" value="L_II" id="flexCheckDefault">
                              @endif
                               L II
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][L_III]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['L_III']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_III]" type="checkbox" value="L_III" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_III]" type="checkbox" value="L_III" id="flexCheckDefault">
                              @endif
                               L III
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[abdomen][L_IV]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['L_IV']))
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_IV]" type="checkbox" value="L_IV" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[abdomen][L_IV]" type="checkbox" value="L_IV" id="flexCheckDefault">
                              @endif
                               L IV
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['abdomen']['text']))
                            <input name="pemeriksaan[abdomen][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['abdomen']['text'] }}" >
                          @else
                            <input name="pemeriksaan[abdomen][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                         
                       </td>
       
       
       
                       <td rowspan="9"  style="width:20%;">Reproduksi</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[reproduksi][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[reproduksi][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[reproduksi][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][keputihan]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['keputihan']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][keputihan]" type="checkbox" value="Kpeutihan" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][keputihan]" type="checkbox" value="Kpeutihan" id="flexCheckDefault">
                              @endif
                              Keputihan
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][haid_teratur]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['haid_teratur']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][haid_teratur]" type="checkbox" value="Haid Teratur" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][haid_teratur]" type="checkbox" value="Haid Teratur" id="flexCheckDefault">
                              @endif
                               Haid Teratur
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][kb]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['kb']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][kb]" type="checkbox" value="KB" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][kb]" type="checkbox" value="KB" id="flexCheckDefault">
                              @endif
                               KB
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][hpht]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['hpht']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][hpht]" type="checkbox" value="HPHT" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][hpht]" type="checkbox" value="HPHT" id="flexCheckDefault">
                              @endif
                                 HPHT
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][tp]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['tp']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][tp]" type="checkbox" value="TP" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][tp]" type="checkbox" value="TP" id="flexCheckDefault">
                              @endif
                               TP
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][uk]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['uk']))
                            <input class="form-check-input"  name="pemeriksaan[reproduksi][uk]" type="checkbox" value="UK" id="flexCheckDefault" checked>
                            @else
                            <input class="form-check-input"  name="pemeriksaan[reproduksi][uk]" type="checkbox" value="UK" id="flexCheckDefault">
                            @endif
                               UK
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[reproduksi][dd]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['dd']))
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][dd]" type="checkbox" value="DD" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[reproduksi][dd]" type="checkbox" value="DD" id="flexCheckDefault">
                              @endif
                              DD
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['reproduksi']['text']))
                            <input name="pemeriksaan[reproduksi][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['reproduksi']['text'] }}" >
                          @else
                            <input name="pemeriksaan[reproduksi][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                         
                       </td>
       
       
       
       
                       <td rowspan="6"  style="width:20%;">Kulit</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[kulit][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[kulit][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[kulit][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kulit][luka]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['luka']))
                              <input class="form-check-input"  name="pemeriksaan[kulit][luka]" type="checkbox" value="Luka" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kulit][luka]" type="checkbox" value="Luka" id="flexCheckDefault">
                              @endif
                              Luka
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kulit][warna]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['warna']))
                              <input class="form-check-input"  name="pemeriksaan[kulit][warna]" type="checkbox" value="Warna" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kulit][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                              @endif
                               Warna
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kulit][lecet]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['lecet']))
                              <input class="form-check-input"  name="pemeriksaan[kulit][lecet]" type="checkbox" value="Lecet" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kulit][lecet]" type="checkbox" value="Lecet" id="flexCheckDefault">
                              @endif
                              Lecet
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[kulit][turgor]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['turgor']))
                              <input class="form-check-input"  name="pemeriksaan[kulit][turgor]" type="checkbox" value="Turgor" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[kulit][turgor]" type="checkbox" value="Turgor" id="flexCheckDefault">
                              @endif
                               Turgor
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['kulit']['text']))
                            <input name="pemeriksaan[kulit][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['kulit']['text'] }}" >
                          @else
                            <input name="pemeriksaan[kulit][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                         
                       </td>
       
       
       
       
       
       
                       <td rowspan="4"  style="width:20%;">Urinaria</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[urinaria][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['urinaria']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[urinaria][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[urinaria][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[urinaria][warna]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['urinaria']['warna']))
                              <input class="form-check-input"  name="pemeriksaan[urinaria][warna]" type="checkbox" value="Warna" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[urinaria][warna]" type="checkbox" value="Warna" id="flexCheckDefault">
                              @endif
                              Warna
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[urinaria][produksi]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['urinaria']['produksi']))
                              <input class="form-check-input"  name="pemeriksaan[urinaria][produksi]" type="checkbox" value="Produksi" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[urinaria][produksi]" type="checkbox" value="Produksi" id="flexCheckDefault">
                              @endif
                               Produksi
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['urinaria']['text']))
                            <input name="pemeriksaan[urinaria][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['urinaria']['text'] }}" >
                          @else
                            <input name="pemeriksaan[urinaria][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                       </td>
       
       
                       
                       <td rowspan="5"  style="width:20%;">Mata</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[mata][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['mata']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[mata][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[mata][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[mata][normal]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['mata']['normal']))
                              <input class="form-check-input"  name="pemeriksaan[mata][normal]" type="checkbox" value="Normal" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[mata][normal]" type="checkbox" value="Normal" id="flexCheckDefault">
                              @endif
                              Normal
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[mata][kuning]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['mata']['kuning']))
                              <input class="form-check-input"  name="pemeriksaan[mata][kuning]" type="checkbox" value="Kuning" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[mata][kuning]" type="checkbox" value="Kuning" id="flexCheckDefault">
                              @endif
                              Kuning
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[mata][pucat]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['mata']['pucat']))
                              <input class="form-check-input"  name="pemeriksaan[mata][pucat]" type="checkbox" value="Pucat" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[mata][pucat]" type="checkbox" value="Pucat" id="flexCheckDefault">
                              @endif
                              Pucat
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['mata']['text']))
                            <input name="pemeriksaan[mata][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['mata']['text'] }}" >
                          @else
                            <input name="pemeriksaan[mata][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                       </td>
       
       
                       <td rowspan="4"  style="width:20%;">Otot,Sendi, dan Tulang</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[ost][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['ost']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[ost][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[ost][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[ost][gerakan_terbatas]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['ost']['gerakan_terbatas']))
                              <input class="form-check-input"  name="pemeriksaan[ost][gerakan_terbatas]" type="checkbox" value="Gerakan Terbatas" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[ost][gerakan_terbatas]" type="checkbox" value="Gerakan Terbatas" id="flexCheckDefault">
                              @endif
                              Gerakan Terbatas
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[ost][nyeri]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['ost']['nyeri']))
                              <input class="form-check-input"  name="pemeriksaan[ost][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[ost][nyeri]" type="checkbox" value="Nyeri" id="flexCheckDefault">
                              @endif
                              Nyeri
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['ost']['text']))
                            <input name="pemeriksaan[ost][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['ost']['text'] }}" >
                          @else
                            <input name="pemeriksaan[ost][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                       </td>
       
       
                      
                       <td rowspan="6"  style="width:20%;">Keadaan Emosional</td>
                       <td  style="padding: 5px;">
                         <label class="form-check-label" for="flexCheckDefault">
                          <input class="form-check-input"   name="pemeriksaan[keadaan_emosional][tidak_ada_keluhan]" type="hidden" value="" id="flexCheckDefault">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['tidak_ada_keluhan']))
                          <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                          @else
                          <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][tidak_ada_keluhan]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                          @endif
                           Tidak ada keluhan
                         </label>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[keadaan_emosional][kooperatif]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['kooperatif']))
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][kooperatif]" type="checkbox" value="Kooperatif" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][kooperatif]" type="checkbox" value="Kooperatif" id="flexCheckDefault">
                              @endif
                              Koperatif
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[keadaan_emosional][butuh_pertolongan]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['butuh_pertolongan']))
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][butuh_pertolongan]" type="checkbox" value="Butuh Pertolongan" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][butuh_pertolongan]" type="checkbox" value="Butuh Pertolongan" id="flexCheckDefault">
                              @endif
                             Butuh Pertolongan
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[keadaan_emosional][ingin_tahu]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['ingin_tahu']))
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][ingin_tahu]" type="checkbox" value="Ingin Tahu" id="flexCheckDefault" checked>
                              @endif 
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][ingin_tahu]" type="checkbox" value="Ingin Tahu" id="flexCheckDefault">
                              Ingin Tahu
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td>
                             <label class="form-check-label" for="flexCheckDefault">
                              <input class="form-check-input"   name="pemeriksaan[keadaan_emosional][bingung]" type="hidden" value="" id="flexCheckDefault">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['bingung']))
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][bingung]" type="checkbox" value="Bingung" id="flexCheckDefault" checked>
                              @else
                              <input class="form-check-input"  name="pemeriksaan[keadaan_emosional][bingung]" type="checkbox" value="Bingung" id="flexCheckDefault">
                              @endif
                              Bingung
                             </label>
                           </td>
                         </tr>
                         <tr>
                           <td style="padding: 5px;">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['text']))
                            <input name="pemeriksaan[keadaan_emosional][text]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['keadaan_emosional']['text'] }}" >
                          @else
                            <input name="pemeriksaan[keadaan_emosional][text]" type="text" class="form-control" id="" value="" >
                          @endif
                           </td>
                         </tr>
                       </td> 
       
       
       
       
                       
                       <tr>
                        <td rowspan="2"  style="width:20%;">Gigi</td>
                        <td>
                         <input class="form-check-input"  name="pemeriksaan[gigi_check]" type="hidden" value="" id="flexCheckDefault">
                         @if (isset(json_decode(@$riwayat[0]->fisik,true)['gigi_check']))
                         <input class="form-check-input"  name="pemeriksaan[gigi_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                         @else
                         <input class="form-check-input"  name="pemeriksaan[gigi_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                         @endif
                         Tidak Ada Keluhan
                       </td>
                        <tr>
                        
                         <td  style="padding: 5px;">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['gigi']))
                          <input name="pemeriksaan[gigi]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['gigi'] }}" >
                        @else
                          <input name="pemeriksaan[gigi]" type="text" class="form-control" id="" value="" >
                        @endif
                         </td>
                        </tr>
                   </tr>   
                       
                       
                     <tr>
                           <td rowspan="2"  style="width:20%;">Telinga</td>
                           <td>
                            <input class="form-check-input"  name="pemeriksaan[telinga_check]" type="hidden" value="" id="flexCheckDefault">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['telinga_check']))
                            <input class="form-check-input"  name="pemeriksaan[telinga_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                            @else
                            <input class="form-check-input"  name="pemeriksaan[telinga_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                            @endif
                            Tidak Ada Keluhan
                          </td>
                           <tr>
                           
                            <td  style="padding: 5px;">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['telinga']))
                          <input name="pemeriksaan[telinga]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['telinga'] }}" >
                        @else
                          <input name="pemeriksaan[telinga]" type="text" class="form-control" id="" value="" >
                        @endif
                            </td>
                           </tr>
                      </tr>  
       
       
                      <tr>
                        <td rowspan="2"  style="width:20%;">Tenggorokan</td>
                        <td>
                         <input class="form-check-input"  name="pemeriksaan[tenggorokan_check]" type="hidden" value="" id="flexCheckDefault">
                         @if (isset(json_decode(@$riwayat[0]->fisik,true)['tenggorokan_check']))
                         <input class="form-check-input"  name="pemeriksaan[tenggorokan_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                         @else
                         <input class="form-check-input"  name="pemeriksaan[tenggorokan_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                         @endif
                         Tidak Ada Keluhan
                       </td>
                        <tr>
                        
                         <td  style="padding: 5px;">
                          @if (isset(json_decode(@$riwayat[0]->fisik,true)['tenggorokan']))
                          <input name="pemeriksaan[tenggorokan]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['tenggorokan'] }}" >
                        @else
                          <input name="pemeriksaan[tenggorokan]" type="text" class="form-control" id="" value="" >
                        @endif
                         </td>
                        </tr>
                   </tr>  
       
                      <tr>
                           <td rowspan="2"  style="width:20%;">Hidung / Muka</td>
                           <td>
                            <input class="form-check-input"  name="pemeriksaan[hidung_muka_check]" type="hidden" value="" id="flexCheckDefault">
                            @if (isset(json_decode(@$riwayat[0]->fisik,true)['hidung_muka_check']))
                            <input class="form-check-input"  name="pemeriksaan[hidung_muka_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault" checked>
                            @else
                            <input class="form-check-input"  name="pemeriksaan[hidung_muka_check]" type="checkbox" value="Tidak Ada Keluhan" id="flexCheckDefault">
                            @endif
                            Tidak Ada Keluhan
                          </td>
                           <tr>
                           
                            {{-- @php
                                dd(json_decode(@$riwayat[0]->fisik,true)['hidung_muka_check']);
                            @endphp --}}

                            <td  style="padding: 5px;">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['hidung_muka']))
                              <input name="pemeriksaan[hidung_muka]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['hidung_muka'] }}" >
                            @else
                              <input name="pemeriksaan[hidung_muka]" type="text" class="form-control" id="" value="" >
                            @endif
                            </td>
                           </tr>
                      </tr>  
                       <tr>
                           <td  colspan="2"  style="width:20%;">Keterangan</td>
                           <tr>
                           
                            {{-- @php
                                dd(json_decode(@$riwayat[0]->fisik,true)['hidung_muka_check']);
                            @endphp --}}

                            <td colspan="2" style="padding: 5px;">
                              @if (isset(json_decode(@$riwayat[0]->fisik,true)['keterangan']))
                              <input name="pemeriksaan[keterangan]" type="text" class="form-control" id="" value="{{ json_decode(@$riwayat[0]->fisik,true)['keterangan'] }}" >
                            @else
                              <input name="pemeriksaan[keterangan]" type="text" class="form-control" id="" value="" >
                            @endif
                            </td>
                           </tr>
                      </tr>  
       
       
       
       
       
       
       
       
       
                           </tr> 
                         </table>
                       </div> 
                       
                       @if (satusehat())
                         <div class="col-md-6">  
                           <h5><b>Satu Sehat</b></h5>
                           <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                             <tr class="history-family">
                               <td style="padding: 5px;">
                                 <table style="width:100%;" class="history-family-2">
                                     <td style="width:30%;">ID Observation Satu Sehat</td>
                                     <td><b>{{@$riwayat->id_observation_ss}}</b></td>
                                 </table>
                               </td>
                             </tr>
                           </table>
                         </div>
                       @endif
                       <div class="col-md-6">
                        <div class="box box-solid box-warning">
                          <div class="box-header">
                            <h5><b>Catatan Medis</b></h5>
                          </div>
                          <div class="box-body table-responsive" style="max-height: 400px">
                            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                            style="font-size:12px;">
                            @if (count($riwayat) == 0)
                            <tr>
                              <td><i>Belum ada catatan</i></td>
                            </tr>  
                            @endif
            
                            @php
                                $angka = 1;
                            @endphp
            
                            @foreach ($riwayat as $item)
                            <tr style="background-color:#9ad0ef">
                              {{-- <th>{{$val_a->registrasi->reg_id}}</th> --}}
                              <th colspan="2">Catatan {{ $angka++ }} 
                                {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
                              </th>
                            </tr>
                              @if ($item->fisik == null)
            
                              <tr>
                                <td><b>Menstruasi : - </b><br/>
                              </tr>
            
            
                              @else
            
                              <tr>
                                <td rowspan="7" style="width: 100px"><b>Persarafan :</b><br/>
                                 
                                   <tr>
                                     <td>
                                       <b>{{json_decode(@$item->fisik,true)['persarafan']['tidak_ada_keluhan']}}
                                     </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['persarafan']['tremor']}}
                                    </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['persarafan']['kejang']}}
                                    </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['persarafan']['paralise']}}
                                    </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['persarafan']['hemiparese']}}
                                    </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['persarafan']['text']}}
                                    </td>
                                   </tr>
                                 
                               </td> 
                                
                             </tr>
          
          
          
          
                             <tr>
                              <td rowspan="5" style="width: 100px"><b>Pernapasan :</b><br/>
                               
                                 <tr>
                                   <td>
                                     <b>{{json_decode(@$item->fisik,true)['pernapasan']['tidak_ada_keluhan']}}
                                   </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['pernapasan']['sekret']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['pernapasan']['sesak_napas']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['pernapasan']['text']}}
                                  </td>
                                 </tr>
                               
                             </td> 
                              
                           </tr>
          
          
                           <tr>
                            <td rowspan="6" style="width: 100px"><b>Pencernaan :</b><br/>
                             
                               <tr>
                                 <td>
                                   <b>{{json_decode(@$item->fisik,true)['pencernaan']['tidak_ada_keluhan']}}
                                 </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['pencernaan']['konstipasi']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['pencernaan']['mual']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['pencernaan']['diare']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['pencernaan']['text']}}
                                </td>
                               </tr>
                             
                           </td> 
                            
                         </tr>
          
          
                         <tr>
                          <td rowspan="7" style="width: 100px"><b>Endokrin :</b><br/>
                           
                             <tr>
                               <td>
                                 <b>{{json_decode(@$item->fisik,true)['endokrin']['tidak_ada_keluhan']}}
                               </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['endokrin']['keringat_banyak']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['endokrin']['pembesaran_kelenjar_tiroid']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['endokrin']['diare']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['endokrin']['napas_baus']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['endokrin']['text']}}
                              </td>
                             </tr>
                           
                         </td> 
                          
                       </tr>
          
          
          
          
                       <tr>
                        <td rowspan="5" style="width: 100px"><b>Kardiovaskuler :</b><br/>
                         
                           <tr>
                             <td>
                               <b>{{json_decode(@$item->fisik,true)['kardiovaskuler']['tidak_ada_keluhan']}}
                             </td>
                           </tr>
                           <tr>
                            <td>
                              <b>{{json_decode(@$item->fisik,true)['kardiovaskuler']['oedema']}}
                            </td>
                           </tr>
                           <tr>
                            <td>
                              <b>{{json_decode(@$item->fisik,true)['kardiovaskuler']['chest_pain']}}
                            </td>
                           </tr>
                           <tr>
                            <td>
                              <b>{{json_decode(@$item->fisik,true)['kardiovaskuler']['text']}}
                            </td>
                           </tr>
                         
                          </td> 
                            
                        </tr>
          
          
          
          
          
                        <tr>
                          <td rowspan="9" style="width: 100px"><b>Abdomen :</b><br/>
                           
                             <tr>
                               <td>
                                 <b>{{json_decode(@$item->fisik,true)['abdomen']['tidak_ada_keluhan']}}
                               </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['membesar']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['nyeri_tekan']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['luka']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['distensi']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['L_I']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['L_II']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['L_III']}}
                              </td>
                             </tr>
                             <tr>
                              <td>
                                <b>{{json_decode(@$item->fisik,true)['abdomen']['L_IV']}}
                              </td>
                             </tr>
                           
                            </td> 
                              
                          </tr>
          
                          
          
                          <tr>
                            <td rowspan="10" style="width: 100px"><b>Reproduksi :</b><br/>
                             
                               <tr>
                                 <td>
                                   <b>{{json_decode(@$item->fisik,true)['reproduksi']['tidak_ada_keluhan']}}
                                 </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['keputihan']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['haid_teratur']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['kb']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['hpht']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['tp']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['uk']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['dd']}}
                                </td>
                               </tr>
                               <tr>
                                <td>
                                  <b>{{json_decode(@$item->fisik,true)['reproduksi']['text']}}
                                </td>
                               </tr>
                             
                              </td> 
                                
                            </tr>
          
                            <tr>
                              <td rowspan="7" style="width: 100px"><b>Kulit :</b><br/>
                               
                                 <tr>
                                   <td>
                                     <b>{{json_decode(@$item->fisik,true)['kulit']['tidak_ada_keluhan']}}
                                   </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['kulit']['luka']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['kulit']['warna']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['kulit']['lecet']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['kulit']['turgor']}}
                                  </td>
                                 </tr>
                                 <tr>
                                  <td>
                                    <b>{{json_decode(@$item->fisik,true)['kulit']['text']}}
                                  </td>
                                 </tr>
                               
                                </td> 
                                  
                              </tr>
          
          
                              <tr>
                                <td rowspan="4" style="width: 100px"><b>Urinaria :</b><br/>
                                 
                                   <tr>
                                     <td>
                                       <b>{{json_decode(@$item->fisik,true)['urinaria']['tidak_ada_keluhan']}}
                                     </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['urinaria']['warna']}}
                                    </td>
                                   </tr>
                                   <tr>
                                    <td>
                                      <b>{{json_decode(@$item->fisik,true)['urinaria']['produksi']}}
                                    </td>
                                   </tr>
                                 
                                  </td> 
                                    
                                </tr>
                              
          
          
          
          
                                <tr>
                                  <td rowspan="4" style="width: 100px"><b>Mata :</b><br/>
                                   
                                     <tr>
                                       <td>
                                         <b>{{json_decode(@$item->fisik,true)['mata']['tidak_ada_keluhan']}}
                                       </td>
                                     </tr>
                                     <tr>
                                      <td>
                                        <b>{{json_decode(@$item->fisik,true)['mata']['normal']}}
                                      </td>
                                     </tr>
                                     <tr>
                                      <td>
                                        <b>{{json_decode(@$item->fisik,true)['mata']['kuning']}}
                                      </td>
                                     </tr>
                                     <tr>
                                      <td>
                                        <b>{{json_decode(@$item->fisik,true)['mata']['normal']}}
                                      </td>
                                     </tr>
                                     <tr>
                                      <td>
                                        <b>{{json_decode(@$item->fisik,true)['mata']['text']}}
                                      </td>
                                     </tr>
                                   
                                    </td> 
                                      
                                  </tr>
          
                                  
          
          
                                  <tr>
                                    <td rowspan="5" style="width: 100px"><b>Otot, Tulang, dan Sendi :</b><br/>
                                     
                                       <tr>
                                         <td>
                                           <b>{{json_decode(@$item->fisik,true)['ost']['tidak_ada_keluhan']}}
                                         </td>
                                       </tr>
                                       <tr>
                                        <td>
                                          <b>{{json_decode(@$item->fisik,true)['ost']['gerakan_terbatas']}}
                                        </td>
                                       </tr>
                                       <tr>
                                        <td>
                                          <b>{{json_decode(@$item->fisik,true)['ost']['nyeri']}}
                                        </td>
                                       </tr>
                                       <tr>
                                        <td>
                                          <b>{{json_decode(@$item->fisik,true)['ost']['text']}}
                                        </td>
                                       </tr>
                                     
                                      </td> 
                                        
                                    </tr>
          
                                    <tr>
                                      <td rowspan="7" style="width: 100px"><b>Keadaan Emosional :</b><br/>
                                       
                                         <tr>
                                           <td>
                                             <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['tidak_ada_keluhan']}}
                                           </td>
                                         </tr>
                                         <tr>
                                          <td>
                                            <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['kooperatif']}}
                                          </td>
                                         </tr>
                                         <tr>
                                          <td>
                                            <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['butuh_pertolongan']}}
                                          </td>
                                         </tr>
                                         <tr>
                                          <td>
                                            <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['bingung']}}
                                          </td>
                                         </tr>
                                         <tr>
                                          <td>
                                            <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['ingin_tahu']}}
                                          </td>
                                         </tr>
                                         <tr>
                                          <td>
                                            <b>{{json_decode(@$item->fisik,true)['keadaan_emosional']['text']}}
                                          </td>
                                         </tr>
                                       
                                        </td> 
                                          
                                      </tr>
          
                                      <tr> 
                                        <td colspan="2"><b>Gigi</b> : {{json_decode(@$item->fisik,true)['gigi']}}<br/></td>
                                      </tr> 
                                      <tr> 
                                        <td colspan="2"><b>Tidak Ada Keluhan Gigi</b> : {{json_decode(@$item->fisik,true)['gigi_check']}}<br/></td>
                                      </tr>
                                      <tr> 
                                        <td colspan="2"><b>Telinga</b> : {{json_decode(@$item->fisik,true)['telinga']}}<br/></td>
                                     </tr>
                                     <tr>
                                        <td colspan="2"><b>Tidak Ada Keluhan Telinga</b> : {{json_decode(@$item->fisik,true)['telinga_check']}}<br/></td>
                                      </tr>
                                      <tr> 
                                        <td colspan="2"><b>Tenggorokan</b> : {{json_decode(@$item->fisik,true)['tenggorokan']}}<br/></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"><b>Tidak Ada Keluhan Tenggorokan</b> : {{json_decode(@$item->fisik,true)['tenggorokan_check']}}<br/></td>
                                      </tr>
                                      <tr> 
                                        <td colspan="2"><b>Hidung / Muka</b> : {{json_decode(@$item->fisik,true)['hidung_muka']}}<br/></td>
                                     </tr>
                                     <tr>
                                        <td colspan="2"><b>Tidak Ada Keluhan Hidung / Muka</b> : {{json_decode(@$item->fisik,true)['hidung_muka_check']}}<br/></td>
                                      </tr>    
                                      
          
          
          
          
          
          
          
          
          
          
          
          
            
            
                              @endif  
                              <tr> 
                                  <td colspan="2"><b>Keterangan</b> : {{json_decode(@$item->fisik,true)['keterangan']}}<br/></td>
                              </tr>    
                              <tr>
                                  <td colspan="2"><b>Penginput</b> : {{baca_user($item->user_id)}}<br/></td>
                              </tr>
                              <tr>
                                <td colspan="2">{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                              </tr>    
                              {{-- <tr>
                                <td colspan="2"><span class="pull-right">
                                  <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-hapus-riwayat/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus Data" style="color:red"><i class="fa fa-trash"></i></a>
                                 
                                </span>
                                </td>
                              </tr>  --}}
                                 
                            
                            @endforeach
                          </table>
                          </div>
                          </div> 
                      </div>
                     </div>
                     
                   </div>
       

                </table>

              

         



                       
                        
            


          

            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan Data</button>
            </div>

          </div>
        </form> 
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
         // ADD RESEP
         
        // HISTORY RESEP 
        // BTN SAVE RESEP
         
        // BTN FINAL RESEP 

        // DELETE DETAIL RESEP 

        // MASTER OBAT  
    </script>
@endsection
