@extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection

<style>
  body {font-family: Arial, Helvetica, sans-serif;}
  
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .summ:focus {
      background-color: green !important;
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
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> 
        @include('emr.modules.addons.profile')
        <div class="row">
          @include('emr.modules.addons.tab-gizi')
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
                    {{-- List soap --}}
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <h5><b>Riwayat CPPT</b></h5>
                      </div>
                      <div class="col-md-12">  
                        <div class="table-responsive" style="max-height: 550px !important;border:1px solid blue">
                          <table class="table table-bordered" id="data" style="font-size: 12px;">
                               
                              <tbody>
                                @if (count($cppt) == 0)
                                    <tr>
                                      <td>Tidak ada riwayat</td>
                                    </tr>
                                @endif
                                <tr>
                                  <th>
                                    <button type="button" id="historiSoap" data-pasienID="{{ $reg->pasien_id }}"
                                      class="btn btn-info btn-sm btn-flat">
                                      <i class="fa fa-th-list"></i> HISTORY BARU
                                    </button>
                                    <button type="button" id="historiAsesmen" data-regID="{{ $reg->id }}"
                                      class="btn btn-warning btn-sm btn-flat">
                                      <i class="fa fa-th-list"></i> HISTORY ASESMEN
                                    </button>
                                  </th>
                                </tr>
                                  @foreach( $cppt as $key_a => $val_a )
                                      @php
                                        $id_ss = @json_decode(@$val_a->id_observation_ss);
                                      @endphp
                                  <tr style="background-color:#9ad0ef">
                                    <th>{{@$val_a->registrasi->reg_id}}</th>
                                    <th>
                                      @if ($val_a->unit == 'inap')
                                        Rawat Inap
                                        {{ @$val_a->registrasi->rawat_inap->kamar->nama }}
                                      @else
                                        POLI 
                                        {{ @$val_a->poli_id ? @strtoupper(baca_poli($val_a->poli_id)) : @strtoupper($val_a->registrasi->poli->nama)}}
                                      @endif
                                      {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
                                    </th>
                                  </tr>
                                  <tr style="background-color:#9ad0ef">
                                    <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
                                    <th>
                                      {{-- {{ $val_a->dokter_id ? baca_dokter($val_a->dokter_id) : @$val_a->registrasi->dokter_umum->nama}} --}}
                                      @php
                                         $dokterid = Modules\Registrasi\Entities\Registrasi::where('id', $val_a->registrasi_id)->first();
  
                                         if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4'){
                                         $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'gigi')->first();
                                         }elseif (@$reg->poli_id == '15') {
                                          $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'obgyn')->first();
                                         } else {
                                          $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'fisik')->first();
                                         }
  
                                      @endphp
                                      {{ baca_user($val_a->user_id)}}
  
                                    </th>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><b>S:</b> {!! $val_a->subject !!}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><b>O:</b> {!! $val_a->object !!}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><b>P:</b> {!! $val_a->planning !!}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><b>Diagnosa Tambahan:</b> {!! $val_a->diagnosistambahan !!}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2" data-idss="{{@$id_ss->edukasi}}">
                                          <b>Edukasi:</b> 
                                          {{@App\Edukasi::where('code', $val_a->edukasi)->first()->keterangan}}
                                          {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->edukasi}}">
                                              @if(@$id_ss->edukasi) 
                                                  <i class="fa fa-check" ></i>
                                              @else
                                                  <i class="fa fa-times" ></i>
                                              @endif
                                              SS
                                          </span>  --}}
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2" data-idss="{{@$id_ss->diet}}">
                                          <b>Diet:</b> 
                                          {!! @$val_a->diet !!}
                                          {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->diet}}">
                                              @if(@$id_ss->diet) 
                                                  <i class="fa fa-check" ></i>
                                              @else
                                                  <i class="fa fa-times" ></i>
                                              @endif
                                              SS
                                          </span>  --}}
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2" data-idss="{{@$id_ss->prognosis}}">
                                          <b>Prognosis:</b> 
                                          {{@App\Prognosis::where('code', $val_a->prognosis)->first()->keterangan}}
                                          {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->prognosis}}">
                                              @if(@$id_ss->prognosis) 
                                                  <i class="fa fa-check" ></i>
                                              @else
                                                  <i class="fa fa-times" ></i>
                                              @endif
                                              SS
                                          </span>  --}}
                                      </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Status Lokalis :</b>
                                      @if (@$val_a->emrPenilaian && @$val_a->emrPenilaian->image != null)
                                        <a id="myImg"><i class="fa fa-eye text-primary"></i></a>
                                          <input type="hidden" src="/images/{{ @$val_a->emrPenilaian->image }}" id="dataImage">
                                        
                                        <div id="myModal" class="modal">
                                          <span class="close" style="color: red; transform:scale(2); opacity:1">&times;</span>
                                          <img class="modal-content" id="img01" style="margin-top: -40px">
                                          <div id="caption">twat</div>
                                        </div>
                                      @else
                                        -
                                      @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><b>Discharge Planning :</b>
                                      @if (@$val_a->discharge)
                                        @php
                                            @$assesment  = @json_decode(@$val_a->discharge, true);
                                        @endphp
                                        {{-- JIKA PULANG --}}
                                        @if (@$assesment['dischargePlanning']['kontrol']['dipilih'])
                                          {{@$assesment['dischargePlanning']['kontrol']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrol']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['dirawat']['dipilih'])
                                          {{@$assesment['dischargePlanning']['dirawat']['dipilih']}} - {{@$assesment['dischargePlanning']['dirawat']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['kontrolPRB']['dipilih'])
                                          {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['Konsultasi']['dipilih'])
                                          {{@$assesment['dischargePlanning']['Konsultasi']['dipilih']}} - {{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['pulpak']['dipilih'])
                                          {{@$assesment['dischargePlanning']['pulpak']['dipilih']}} - {{@$assesment['dischargePlanning']['pulpak']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['observasi']['dipilih'])
                                          {{@$assesment['dischargePlanning']['observasi']['dipilih']}} - {{@$assesment['dischargePlanning']['observasi']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['aps']['dipilih'])
                                          {{@$assesment['dischargePlanning']['aps']['dipilih']}} - {{@$assesment['dischargePlanning']['aps']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['meninggal']['dipilih'])
                                          {{@$assesment['dischargePlanning']['meninggal']['dipilih']}} - {{@$assesment['dischargePlanning']['meninggal']['waktu']}}
                                        @else
                                          {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                                        @endif
                                      @endif
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <h5><b>Riwayat EWS Dewasa</b></h5>
                      </div>
                      <div class="col-md-12">
                        <table class="table table-bordered" id="data" style="font-size: 12px;">
                          <tbody>
                            @if (count($ews_dewasa) == 0)
                                <tr>
                                  <td>Tidak ada riwayat</td>
                                </tr>
                            @endif
                              @foreach( $ews_dewasa as $key_a => $val_a )
                                @php
                                    $ews = json_decode($val_a->diagnosis);
                                    $kesadaran = @explode(',', @$ews->tingkat_kesadaran)[1];
                                    $pernapasan = @explode(',', @$ews->pernapasan)[1];
                                    $saturasi_oksigen = @explode(',', @$ews->saturasi_oksigen)[1];
                                    $penggunaan_oksigen = @explode(',', @$ews->penggunaan_oksigen)[1];
                                    $tekanan_darah = @explode(',', @$ews->tekanan_darah)[1];
                                    $denyut_jantung = @explode(',', @$ews->denyut_jantung)[1];
                                    $suhu = @explode(',', @$ews->suhu)[1];
                                    $skor_ews = $kesadaran + $pernapasan + $saturasi_oksigen + $penggunaan_oksigen + $tekanan_darah + $denyut_jantung + $suhu;
                                @endphp
                              <tr class="bg-primary" style="font-size:11px;">
                                  <th>Penginput</th>
                                  <th>{{ baca_user($val_a->user_id) }}</th>
                              </tr>
                              <tr class="bg-primary" style="font-size:11px;">
                                  <th>Tanggal Input</th>
                                  <th>{{ date('d/m/Y',strtotime($val_a->tanggal)) . ' ' . date('H:i',strtotime($val_a->waktu)) }}</th>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Tingkat Kesadaran:</b> {{@$ews->tingkat_kesadaran ? @explode(',', @$ews->tingkat_kesadaran)[0] . '(' . @explode(',', @$ews->tingkat_kesadaran)[1] . ')' : '-'}} </td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernapasan ? @explode(',', @$ews->pernapasan)[0] . '(' . @explode(',', @$ews->pernapasan)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Saturasi Oksigen:</b> {{@$ews->saturasi_oksigen ? @explode(',', @$ews->saturasi_oksigen)[0] . '(' . @explode(',', @$ews->saturasi_oksigen)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Penggunaan Oksigen:</b> {{@$ews->penggunaan_oksigen ? @explode(',', @$ews->penggunaan_oksigen)[0] . '(' . @explode(',', @$ews->penggunaan_oksigen)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Tekanan Darah:</b> {{@$ews->tekanan_darah ? @explode(',', @$ews->tekanan_darah)[0] . '(' . @explode(',', @$ews->tekanan_darah)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Denyut Jantung:</b> {{@$ews->denyut_jantung ? @explode(',', @$ews->denyut_jantung)[0] . '(' . @explode(',', @$ews->denyut_jantung)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Suhu:</b> {{@$ews->suhu ? @explode(',', @$ews->suhu)[0] . '(' . @explode(',', @$ews->suhu)[1] . ')' : '-'}}</td>
                              </tr>
                              <tr>
                                  <td colspan="2"><b>Total Skor:</b> {{$skor_ews}}</td>
                              </tr>
                              @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-12">
                        <h5><b>Riwayat EWS Maternal</b></h5>
                      </div>
                      <div class="col-md-12">
                        <table class="table-bordered table" id="data"
                            style="font-size: 12px;margin-top:0px !important">
  
                            <tbody style="font-size:11px;">
                                @if (count($ews_maternal) == 0)
                                    <tr>
                                        <td>Tidak ada riwayat</td>
                                    </tr>
                                @endif
                                @foreach ($ews_maternal as $key_a => $val_a)
                                    @php
                                        $ews = json_decode($val_a->diagnosis);
                                    @endphp
                                    <tr class="bg-primary" style="font-size:11px;">
                                        <th>Penginput</th>
                                        <th>{{ baca_user($val_a->user_id) }}</th>
                                    </tr>
                                    <tr class="bg-primary" style="font-size:11px;">
                                        <th>Tanggal Input</th>
                                        <th>{{ date('d/m/Y',strtotime($val_a->tanggal)) . ' ' . date('H:i',strtotime($val_a->waktu)) }}</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernapasan ? @explode(',', @$ews->pernapasan)[0] . '(' . @explode(',', @$ews->pernapasan)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Sp.O2:</b> {{@$ews->spo2 ? @explode(',', @$ews->spo2)[0] . '(' . @explode(',', @$ews->spo2)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Suhu:</b> {{@$ews->suhu ? @explode(',', @$ews->suhu)[0] . '(' . @explode(',', @$ews->suhu)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Frekuensi Jantung:</b> {{@$ews->frekuensi_jantung ? @explode(',', @$ews->frekuensi_jantung)[0] . '(' . @explode(',', @$ews->frekuensi_jantung)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Tekanan Sistolik:</b> {{@$ews->sitolik ? @explode(',', @$ews->sitolik)[0] . '(' . @explode(',', @$ews->sitolik)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Tekanan Diastolik:</b> {{@$ews->diastolik ? @explode(',', @$ews->diastolik)[0] . '(' . @explode(',', @$ews->diastolik)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Nyeri:</b> {{@$ews->nyeri ? @explode(',', @$ews->nyeri)[0] . '(' . @explode(',', @$ews->nyeri)[1] . ')' : '-'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
                      <div class="col-md-12">
                        <h5><b>Riwayat EWS Anak</b></h5>
                      </div>
                      <div class="col-md-12">
                        <table class="table-bordered table" id="data"
                                  style="font-size: 12px;margin-top:0px !important">
  
                                  <tbody style="font-size:11px;">
                                      @if (count($ews_anak) == 0)
                                          <tr>
                                              <td>Tidak ada riwayat</td>
                                          </tr>
                                      @endif
                                      @foreach ($ews_anak as $key_a => $val_a)
                                          @php
                                              $ews = json_decode($val_a->diagnosis);
                                          @endphp
                                          <tr class="bg-primary" style="font-size:11px;">
                                              <th>Penginput</th>
                                              <th>{{ baca_user($val_a->user_id) }}</th>
                                          </tr>
                                          <tr class="bg-primary" style="font-size:11px;">
                                              <th>Tanggal Input</th>
                                              <th>{{ date('d/m/Y',strtotime($val_a->tanggal)) . ' ' . date('H:i',strtotime($val_a->waktu)) }}</th>
                                          </tr>
                                          <tr>
                                              <td colspan="2"><b>Perilaku:</b> {{@$ews->perilaku ? @explode(',', @$ews->perilaku)[0] . '(' . @explode(',', @$ews->perilaku)[1] . ')' : '-'}}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="2"><b>RT/Warna Kulit:</b> {{@$ews->kulit ? @explode(',', @$ews->kulit)[0] . '(' . @explode(',', @$ews->kulit)[1] . ')' : '-'}}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernafasan ? @explode(',', @$ews->pernafasan)[0] . '(' . @explode(',', @$ews->pernafasan)[1] . ')' : '-'}}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="2"><b>Skor Lain:</b> {{@$ews->skor_lain ? @explode(',', @$ews->skor_lain)[0] . '(' . @explode(',', @$ews->skor_lain)[1] . ')' : '-'}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                      </div>
                    </div>
                <hr/>
            </div>
        </div>
    </div>
  </div>  

  {{-- Tambahan --}}


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

  
@endsection
  
  <style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
  </style>
@section('script')
{{-- Handle draft cppt --}}
  <script>
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
      e.preventDefault();
      // Manual validasi
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
    })
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
    $('#showHistoriSoap').modal('show');
    $('#dataHistoriSoap').load("/soap/history/"+unit+"/" + id);
  });
  $(document).on('click', '#historiAsesmen', function(e) {
    var id = $(this).attr('data-regID');
    window.open('/emr/resume/igd/'+id, "Asesmen", 'width=700,height=700,scrollbars=yes');
    
  });

  $(document).on('change', '#registrasi_select', function(){
    var regId = $(this).val();
    var unit = $('input[name=unit]').val();
    // console.log(unit);
    $('#showHistoriSoap').modal('show');
    $('#dataHistoriSoap').load("/soap/history-filter/"+unit+"/" + regId);
  });

  $(document).on('click', '#listKontrol', function(e) {
    var id = $(this).attr('data-dokterID');
    var tgl = $('#waktuKontrol').val();
    
    if(tgl == null || tgl == ''){
      alert('Harap Isi Tanggal Kontrol');
    }else{
      $('#showListKontrol').modal('show');
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
        $('#myModalHistoryResep').modal('show');
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

@endsection
