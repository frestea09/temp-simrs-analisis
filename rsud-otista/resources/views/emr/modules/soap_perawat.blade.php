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
          @include('emr.modules.addons.tabs')
            <div class="col-md-12">
                @if (!$emr)
                <form method="POST" action="{{ url('save-emr-perawat') }}" class="form-horizontal cppt-form">
                @else
                  <form method="POST" action="{{ url('update-soap-perawat') }}" class="form-horizontal cppt-form">
                  {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('user_id', Auth::user()) !!}
                    {!! Form::hidden('registrasi_id', @$reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('poli_id', @$poli ? @$poli : @$reg->poli_id) !!}
                    {!! Form::hidden('cara_bayar', @$reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br>
                    {{-- List soap --}}
                    <div class="col-md-6">  
                      <div class="table-responsive" style="max-height: 1300px !important;border:1px solid blue">
                        <table class="table table-bordered" id="data" style="font-size: 12px;">
                             
                            <tbody>
                              @if (count($all_resume) == 0)
                                  <tr>
                                    <td>Tidak ada record</td>
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
                                    <button type="button" id="historiEWS"  data-reg="{{ $reg->id }}" class="btn btn-success btn-sm btn-flat">
                                      <i class="fa fa-th-list"></i> HISTORY EWS
                                    </button>
                                    {{-- <button type="button" id="historiGizi" data-giziID="{{ $reg->pasien_id }}"
                                      class="btn btn-danger btn-sm btn-flat">
                                      <i class="fa fa-th-list"></i> HISTORY Gizi
                                    </button> --}}
                                  </th>
                                </tr>
                                @foreach( $all_resume as $key_a => $val_a )
                                  @php
                                      $id_ss = @json_decode(@$val_a->id_observation_ss);
                                      $background = "transparent";

                                      $background = "transparent";

                                      if (@$val_a->unit == 'farmasi') {
                                        $background = "#e4dd7b";
                                      } elseif (@$val_a->unit == 'gizi') {
                                        $background = "#D8BFD8";
                                      } else {
                                        if (@$val_a->user->Pegawai->kategori_pegawai == 1) {
                                          $background = "#ABF7B1";
                                        } else {
                                          $background = "#F8C9C9";
                                        }
                                      }
                                  @endphp
                                <tr style="background-color:#9ad0ef">
                                  <th>{{@$val_a->registrasi->reg_id}} - {{ date('d-m-Y H:i', strtotime(@$val_a->registrasi->created_at)) }}</th>
                                  <th>
                                    @if ($val_a->unit == 'inap')
                                      Rawat Inap
                                      {{ @$val_a->registrasi->rawat_inap->kamar->nama }}
                                    @elseif ($val_a->unit == 'farmasi')
                                      Apotik / Farmasi
                                    @elseif (@$val_a->unit == 'gizi')
                                      Gizi
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
                                @if (@$val_a->unit == 'gizi')
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>A:</b><br>
                                        {!! nl2br($val_a->assesment) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>D:</b><br>
                                        {!! nl2br($val_a->diagnosis) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>I:</b><br>
                                        {!! nl2br($val_a->intervensi) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>M:</b><br>
                                        {!! nl2br($val_a->monitoring) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>E:</b><br>
                                        {!! nl2br($val_a->evaluasi) !!}
                                      </td>
                                  </tr>
                                @elseif (@$val_a->unit == 'farmasi')
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>S:</b><br>
                                      {!! nl2br($val_a->subjective) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>O:</b><br>
                                      {!! nl2br($val_a->objective) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>A:</b><br>
                                      {!! nl2br($val_a->asesmen) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>P:</b><br>
                                      {!! nl2br($val_a->planning) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>E:</b><br>
                                      {!! nl2br($val_a->edukasi) !!}
                                    </td>
                                  </tr>
                                @elseif (@$val_a->user->Pegawai->kategori_pegawai == 1)
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>S:</b><br>
                                      {!! nl2br($val_a->subject) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>O:</b><br>
                                      {!! nl2br($val_a->object) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>A - Diagnosa Utama:</b><br>
                                      {!! nl2br($val_a->assesment) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>A - Diagnosa Tambahan:</b><br>
                                      {!! nl2br($val_a->diagnosistambahan) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>P:</b><br>
                                      {!! nl2br($val_a->planning) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
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
                                  <tr style="background-color: {{$background}}">
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
                                  <tr style="background-color: {{$background}}">
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
                                  <tr style="background-color: {{$background}}">
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
                                  <tr style="background-color: {{$background}}">
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
                                @else
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>S:</b><br>
                                      {!! nl2br($val_a->subject) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>O:</b><br>
                                      {!! nl2br($val_a->object) !!}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2" data-idss="{{@$id_ss->nadi}}">
                                        <b>Nadi:</b> {!! @$val_a->nadi !!} 
                                        {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->nadi}}">
                                            @if(@$id_ss->nadi) 
                                                <i class="fa fa-check" ></i>
                                            @else
                                                <i class="fa fa-times" ></i>
                                            @endif
                                            SS
                                        </span>  --}}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2" data-idss_sistol="{{@$id_ss->sistol}}" data-idss_distol="{{@$id_ss->distol}}" >
                                        <b>Tekanan Darah:</b> {!! @$val_a->tekanan_darah !!} 
                                        {{-- <span style="font-weight: bold; float: right" data-idss_sistol="{{@$id_ss->sistol}}" data-idss_distol="{{@$id_ss->distol}}" >
                                            @if(@$id_ss->sistol && @$id_ss->distol) 
                                                <i class="fa fa-check" ></i>
                                            @else
                                                <i class="fa fa-times" ></i>
                                            @endif
                                            SS
                                        </span> --}}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2" data-idss="{{@$id_ss->pernafasan}}">
                                        <b>Frekuensi Nafas:</b> {!! @$val_a->frekuensi_nafas !!}
                                        {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->pernafasan}}">
                                            @if(@$id_ss->pernafasan) 
                                                <i class="fa fa-check" ></i>
                                            @else
                                                <i class="fa fa-times" ></i>
                                            @endif
                                            SS
                                        </span> --}}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2" data-idss="{{@$id_ss->suhu}}">
                                        <b>Suhu:</b> {!! @$val_a->suhu !!}
                                        {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->suhu}}">
                                            @if(@$id_ss->suhu) 
                                                <i class="fa fa-check" ></i>
                                            @else
                                                <i class="fa fa-times" ></i>
                                            @endif
                                            SS
                                        </span> --}}
                                    </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>Saturasi:</b> {!! @$val_a->saturasi !!}</td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>Berat Badan:</b> {!! @$val_a->berat_badan !!}</td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>A:</b><br>
                                         {!! nl2br($val_a->assesment) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>P:</b><br> 
                                        {!! nl2br($val_a->planning) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>Implementasi:</b> {!! @$val_a->implementasi !!}</td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                      <td colspan="2"><b>Keterangan:</b><br> 
                                        {!! nl2br($val_a->keterangan) !!}
                                      </td>
                                  </tr>
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2" ata-idss="{{@$id_ss->kesadaran}}">
                                      <b>Kesadaran:</b>
                                      {{@App\Kesadaran::where('code',  @$val_a->kesadaran)->first()->display}}
                                      {{-- <span style="font-weight: bold; float: right" data-idss="{{@$id_ss->kesadaran}}">
                                          @if(@$id_ss->kesadaran) 
                                              <i class="fa fa-check" ></i>
                                          @else
                                              <i class="fa fa-times" ></i>
                                          @endif
                                          SS
                                      </span> --}}
                                    </td>
                                  </tr>
                                
                                  <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>Nyeri:</b> {!! @$val_a->skala_nyeri !!}</td>
                                  </tr>
                                  {{-- <tr style="background-color: {{$background}}">
                                    <td colspan="2"><b>Diganosa:</b> {!! @$val_a->diagnosis !!}</td>
                                  </tr> --}}
                                  <tr style="background-color: {{$background}}">
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
                                        @elseif(@$assesment['dischargePlanning']['meninggal']['dipilih'])
                                          {{@$assesment['dischargePlanning']['meninggal']['dipilih']}} - {{@$assesment['dischargePlanning']['meninggal']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['alihigd']['dipilih'])
                                          {{@$assesment['dischargePlanning']['alihigd']['dipilih']}} - {{@$assesment['dischargePlanning']['alihigd']['waktu']}}
                                        @elseif(@$assesment['dischargePlanning']['alihponek']['dipilih'])
                                          {{@$assesment['dischargePlanning']['alihponek']['dipilih']}} - {{@$assesment['dischargePlanning']['alihponek']['waktu']}}
                                        @else
                                          {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                                        @endif
                                      @endif
                                    </td>
                                  </tr>
                                @endif
                               
                               {{-- <tr>
                                <td colspan="2"><b>Status Lokalis :</b> 
                                  
                                   @if (@$gambar->image != null)
                                    
                                   <a id="myImg"><i class="fa fa-eye text-primary"></i></a>
                                    <input type="hidden" src="/images/{{ @$gambar['image'] }}" id="dataImage">
                                  
                                   <div id="myModal" class="modal">
                                    <span style="color: red" class="close">&times;</span>
                                    <img class="modal-content" id="img01">
                                    <div id="caption">twat</div>
                                  </div>
                                  @else

                                    -

                                   @endif
                                
                                </td>
                               </tr> --}}
                                <tr style="background-color: {{$background}}">
                                  <td colspan="2" class="" style="font-size:15px;">
                                    {{-- <a href="" data-toggle="tooltip" title="Cetak"><i class="fa fa-print text-danger"></i></a>&nbsp;&nbsp; --}}
                                    <p>
                                      @if (Auth::user()->id == $val_a->user_id)
                                      <span class="pull-right">
                                        {{-- /emr-soap/penilaian/gigi/" + unit + "/" + regId --}}
                                      {{-- @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4')
                                      <a href="{{url('/emr-soap/penilaian/gigi/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                                      @elseif(@$reg->poli_id == '15')
                                      <a href="{{url('/emr-soap/penilaian/obgyn/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;   
                                      @else
                                      <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                                      @endif --}}


                                      <a href="{{url('/emr/move-cppt/'.$val_a->id.'/'. @$reg->id)}}" onclick="return confirm('Yakin akan memindahkan CPPT ini ke pendaftaran tanggal {{date('d-m-Y H:i', strtotime($reg->created_at))}}?')" data-toggle="tooltip" title="Pindah Ke Registrasi Ini"><i class="fa fa-arrow-right"></i></a>&nbsp;&nbsp;
                                      <a href="{{url('/emr/duplicate-soap-perawat/'.$val_a->id.'/'.$dpjp.'/'.$poli.'/'.@$reg->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                      <a href="{{url('/emr/soap_perawat/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'/edit?poli='.$poli.'&dpjp='.$dpjp)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                      <a href="{{url('/emr/soap-delete/'.$unit.'/'.@$reg->id.'/'.$val_a->id)}}" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');">
                                        <i class="fa fa-trash text-danger"></i>
                                      </a>&nbsp;&nbsp;
                                      </span>
                                      @endif
                                    
                                    </p>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                    
                    {{-- Soap Input --}}
                      <div class="col-md-6">  
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
                                  <textarea class="form-control"  style="resize: vertical;" name="subject" required>{{$emr ? $emr->subject : ''}}</textarea>
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Objective(O)</b></td>
                              <td style="padding: 5px;">
                                  <textarea class="form-control"  style="resize: vertical;" name="object" required>{{$emr ? $emr->object : ''}}</textarea>
                              </td> 
                          </tr>

                          <tr>
                            <td style="width:200px;"><b>Nadi </b><i style="color:green">(x/menit)</i></td>
                            <td style="padding: 5px;">
                              @if (substr(@$reg->status_reg, 0, 1) == 'G' && @$aswalPerawat)
                                <input type="text" name="nadi" class="form-control" value="{{ @$aswalPerawat['tanda_vital']['nadi'] }} {{$emr ? $emr->nadi : ''}}">
                              @elseif (@$asesmen_igd)
                                <input type="text" name="nadi" class="form-control" value="@if ($emr){{$emr->nadi}}@else {{@$asesmen_igd['frekuensiNadi'] ?? @$asesmen_igd['nadi']}} @endif">
                              @else
                                <input type="text" name="nadi" class="form-control" value="{{$emr ? $emr->nadi : ''}}">
                              @endif
                            </td> 
                          </tr>
                          <tr>
                              <td><b>Tekanan Darah </b><i style="color:blue">(mmHG)</i></td>
                              <td style="padding: 5px;">
                                @if (substr(@$reg->status_reg, 0, 1) == 'G' && @$aswalPerawat)
                                  <input type="text" name="tekanan_darah" class="form-control" value="{{ @$aswalPerawat['tanda_vital']['tekanan_darah'] }} {{$emr ? $emr->tekanan_darah : ''}}">
                                @elseif (@$asesmen_igd)
                                  <input type="text" name="tekanan_darah" class="form-control" value="@if ($emr){{$emr->tekanan_darah}}@else {{@$asesmen_igd['tekananDarah'] ?? @$asesmen_igd['tekanan_darah']}} @endif">
                                @else
                                  <input type="text" name="tekanan_darah" value="{{$emr ? $emr->tekanan_darah : ''}}" class="form-control" placeholder="Sistol/Diastol">
                                @endif  
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Frekuensi Nafas </b><i style="color:rebeccapurple">(x/menit)</i></td>
                              <td style="padding: 5px;">
                                @if (substr(@$reg->status_reg, 0, 1) == 'G' && @$aswalPerawat)
                                  <input type="text" name="frekuensi_nafas" class="form-control" value="{{ @$aswalPerawat['tanda_vital']['frekuensi_nafas'] }} {{$emr ? $emr->frekuensi_nafas : ''}}">
                                @elseif (@$asesmen_igd)
                                  <input type="text" name="frekuensi_nafas" class="form-control" value="@if ($emr){{$emr->frekuensi_nafas}}@else {{@$asesmen_igd['RR'] ?? @$asesmen_igd['frekuensi_nafas']}} @endif">
                                @else
                                  <input type="text" name="frekuensi_nafas" value="{{$emr ? $emr->frekuensi_nafas : ''}}" class="form-control" >
                                @endif
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Suhu </b><i style="color:rebeccapurple">(°C)</i></td>
                              <td style="padding: 5px;">
                                @if (substr(@$reg->status_reg, 0, 1) == 'G' && @$aswalPerawat)
                                  <input type="text" name="suhu" class="form-control" value="{{ @$aswalPerawat['tanda_vital']['suhu'] }} {{$emr ? $emr->suhu : ''}}">
                                @elseif (@$asesmen_igd)
                                  <input type="text" name="suhu" class="form-control" value="@if ($emr){{$emr->suhu}}@else {{@$asesmen_igd['suhu'] ?? @$asesmen_igd['suhu']}} @endif">
                                @else
                                  <input type="text" name="suhu" value="{{$emr ? $emr->suhu : ''}}" class="form-control" placeholder="Gunakan Titik Untuk Bilangan Berkoma">
                                @endif
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Saturasi </b><i style="color:rebeccapurple"></i></td>
                              <td style="padding: 5px;">
                                  <input type="text" name="saturasi" value="{{$emr ? $emr->saturasi : ''}}" class="form-control">
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Berat Badan </b><i style="color:rebeccapurple"></i></td>
                              <td style="padding: 5px;">
                                @if (substr(@$reg->status_reg, 0, 1) == 'G' && @$aswalPerawat)
                                  <input type="text" name="berat_badan" class="form-control" value="{{ @$aswalPerawat['tanda_vital']['BB'] }} {{$emr ? $emr->berat_badan : ''}}">
                                @elseif (@$asesmen_igd)
                                  <input type="text" name="berat_badan" class="form-control" value="@if ($emr){{$emr->berat_badan}}@else {{@$asesmen_igd['BB'] ?? @$asesmen_igd['BB']}} @endif">
                                @else
                                  <input type="text" name="berat_badan" value="{{$emr ? $emr->berat_badan : ''}}" class="form-control" placeholder="Tulis satuan secara manual. Ex: Kg/Gram" >
                                @endif
                              </td> 
                          </tr>

                          <tr>
                            <td><b>Assesment/Diagnosis(A)</b></td>
                            <td style="padding: 5px;">
                              <select name="assesment[]" id="select-diagnosis" class="form-control select2" style="width: 350px;" onchange="getAskep()">
                                <option value="">-- Pilih Diagnosa</option>
                                @foreach ($diagnosaKeperawatan as $data)
                                  <option value="{{ $data->nama }}">{{ $data->nama. ' ('.$data->kode.')' }}</option>
                                @endforeach
                              </select>
                                <button type="button" class="btn btn-success btn-flat btn-sm" onclick="cloneDiagnosis()">Tambah</button>
                            </td>
                          </tr>
                            <tr id="template-diagnosis" style="display: none;">
                              <td><b>&nbsp;</b></td>
                              <td style="padding: 5px;">
                                <select name="assesment[]" class="form-control new-diagnosa" style="width: 350px;" disabled onchange="getAskep()">
                                  <option value="">-- Pilih Diagnosa</option>
                                  @foreach ($diagnosaKeperawatan as $data)
                                    <option value="{{ $data->nama }}">{{ $data->nama. ' ('.$data->kode.')' }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                          <tr>
                            <td></td>
                            <td>
                              <label for="checkAlternate" style="font-weight: normal; font-style: italic;">
                                <input type="checkbox" name="use-alternate" id="checkAlternate" onclick="showInput(this)">
                                Ceklis Jika Ingin Menggunakan TextBox
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td style="padding: 5px;">
                                <textarea id="diagnosis-alternate" class="form-control"  style="resize: vertical;" name="assesment" disabled></textarea>
                            </td> 
                          </tr>
                          <tr>
                            <td><b>Planning(P)</b></td>
                            <td style="padding: 5px;">
                              <select class="form-control select2" id="select-planning" name="planning[]" multiple style="width: 350px;">
                              </select>
                            </td> 
                          </tr>
                          <tr>
                            <td></td>
                            <td style="padding: 5px;">
                                <textarea id="planning-alternate" class="form-control"  style="resize: vertical;" name="planning" disabled></textarea>
                            </td> 
                          </tr>
                          <tr>
                            <td><b>Implementasi</b></td>
                            <td style="padding: 5px;">
                              <select class="form-control select2" id="select-implementasi" name="implementasi[]" multiple style="width: 350px;">
                              </select>
                            </td> 
                          </tr> 
                          <tr>
                            <td></td>
                            <td style="padding: 5px;">
                                <textarea id="implementasi-alternate" class="form-control"  style="resize: vertical;" name="implementasi" disabled></textarea>
                            </td> 
                          </tr>
                          @if($unit == 'igd')
                            <tr>
                                <td style="width:50px;"><b>Keterangan</b></td>
                                <td style="padding: 5px;">
                                    <textarea class="form-control"  style="resize: vertical;" name="keterangan">{{$emr ? $emr->keterangan : @$dataAsesmenDokter['igdAwal']['tindakan_pengobatan'] }}</textarea>
                                </td> 
                            </tr>
                          @else
                            <tr>
                                <td style="width:50px;"><b>Keterangan</b></td>
                                <td style="padding: 5px;">
                                  @php
                                  
                                  @endphp
                                    <textarea class="form-control"  style="resize: vertical;" name="keterangan">{{$emr ? $emr->keterangan : ''}}</textarea>
                                </td> 
                            </tr>
                          @endif
                          <tr>
                            <td><b>State</b><br/><small><i>Pilih state jika pasien anak/bayi</i></small></td>
                              <td style="padding: 5px;">
                                <input class="" type="radio" id="" name="state" value="1">
                                <label for="persepsi_sensori_1" style="font-weight: normal;"><b>1</b></label> &nbsp;&nbsp;

                                <input class="" type="radio" id="" name="state" value="2">
                                <label for="persepsi_sensori_1" style="font-weight: normal;"><b>2</b></label>&nbsp;&nbsp;
                                
                                <input class="" type="radio" id="" name="state" value="3">
                                <label for="persepsi_sensori_1" style="font-weight: normal;"><b>3</b></label>&nbsp;&nbsp;
                                
                                <input class="" type="radio" id="" name="state" value="4">
                                <label for="persepsi_sensori_1" style="font-weight: normal;"><b>4</b></label>&nbsp;&nbsp;
                                
                                <input class="" type="radio" id="" name="state" value="5">
                                <label for="persepsi_sensori_1" style="font-weight: normal;"><b>5</b></label>&nbsp;&nbsp;<br/>
                                
                              </td>
                          </tr>
                          <tr>
                            <td><b>Kesadaran </b></td>
                              <td style="padding: 5px;">
                                <select name="kesadaran" class="select2" style="width: 100%">
                                    <option value="" disabled selected>-- Pilih Kesadaran -- </option>
                                    @foreach (@App\Kesadaran::all() as $kesadaran)
                                        <option value="{{$kesadaran->code}}">{{$kesadaran->display}}/{{$kesadaran->translate}}</option>
                                    @endforeach
                                </select>
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Skala Nyeri </b></td>
                              <td style="padding: 5px;">
                                <hr style="padding-top:0;margin-top:0"/>
                                <select name="skala_nyeri" id="skalanyeri-alternate" class="select2" style="width: 100%">
                                  <option value="" disabled selected>-- Pilih Skala Nyeri -- </option>
                                  <option {{@$emr->skala_nyeri == '0' ? 'selected' : ''}} value="0">0 : tidak nyeri</option>
                                  <option {{@$emr->skala_nyeri == '1-2' ? 'selected' : ''}} value="1-2">1 -2 : nyeri ringan</option>
                                  <option {{@$emr->skala_nyeri == '3-4' ? 'selected' : ''}} value="3-4">3-4 : nyeri sedang</option>
                                  <option {{@$emr->skala_nyeri == '4' ? 'selected' : ''}} value="4">4 : nyeri berat</option>
                                  
                              </select>
                              <label for="checkAlternate" style="font-weight: normal; font-style: italic;">
                                <input type="checkbox" name="use-alternate" id="checkAlternate" onclick="showInputSkalaNyeri(this)">
                                <small>Ceklis Jika Ingin Menggunakan TextBox Skala Nyeri</small>
                              </label>
                                <input type="text" placeholder="Textbox skala nyeri" name="skala_nyeri" value="{{$emr ? $emr->skala_nyeri : ''}}" class="form-control skala-nyeri" disabled>
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Tanggal</b></td>
                              <td style="padding: 5px;">
                                <input type="datetime-local" name="created_at" class="form-control" value="{{@$emr ? date('Y-m-d\TH:i', strtotime($emr->created_at)) : date('Y-m-d\TH:i')}}">
                              </td> 
                          </tr>
                          @php
                            @$assesments = @json_decode(@$emr->discharge, true);
                          @endphp
                          <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:8pt;"> 
                            <tr>
                              <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS" {{@$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang RS</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][kontrol][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['kontrol']['waktu']}}">
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
                                <input type="checkbox" id="dischargePlanning_dirujuk" name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk" {{@$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : ''}}>
                                <label for="dischargePlanning_dirujuk" style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br/>
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
                                        <option value="RS KOTA CIMAHI" {{@$assesments['dischargePlanning']['dirujuk']['diRujukKe'] == 'RS KOTA CIMAHI' ? 'selected' : ''}}>RS KOTA CIMAHI</option>
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
                                <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][alihgigd][dipilih]" value="Alih IGD" {{@$assesment['dischargePlanning']['alihgigd']['dipilih'] == 'Alih IGD' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Alih IGD</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][alihgigd][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['alihgigd']['waktu']}}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][alihponek][dipilih]" value="Alih Ponek" {{@$assesment['dischargePlanning']['alihponek']['dipilih'] == 'Alih Ponek' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Alih Ponek</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][alihponek][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['alihponek']['waktu']}}">
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
                              @if ($unit == 'igd')  
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_1" class="discargePlanningCheckbox" name="fisik[dischargePlanning][observasi][dipilih]" value="Observasi" {{@$assesment['dischargePlanning']['observasi']['dipilih'] == 'Observasi' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Observasi</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][observasi][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['observasi']['waktu']}}">
                              </td>
                            @else
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_1" class="discargePlanningCheckbox" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                              </td>
                            @endif
                            </tr>
                            <tr>
                              <td style="width:25%; font-weight:500;">
                                <input type="checkbox" id="dischargePlanning_1" class="discargePlanningCheckbox" name="fisik[dischargePlanning][kontrol][dipilih]" value="APS" {{@$assesments['dischargePlanning']['kontrol']['dipilih'] == 'APS' ? 'checked' : ''}}>
                                <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">APS</label><br/>
                              </td>
                              <td>
                                <input type="text" name="fisik[dischargePlanning][aps][waktu]" class="form-control" value="{{@$assesments['dischargePlanning']['aps']['waktu']}}">
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
                        



                          {{-- @php
                          $kondisi = App\KondisiAkhirPasien::all();
                         @endphp


                          <tr>
                            <td><b>Kondisi Akhir Pasien</b></td>
                            <td>
                              <select name="keterangan" id="" class="form-control"> 
                              <option value="" selected></option>
                              @foreach ($kondisi as $item)
                              <option value="{{ $item->namakondisi  }}">
                                  {{ $item->namakondisi }}
                              </option>
                          
                              @endforeach
                              </select>
                            </td>
                          </tr>  --}}
                          <tr>
                            <td>
                              {{-- <div class="form-group text-center"> --}}
                                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                              {{-- </div> --}}
                            </td>
                          </tr>
                        </table>
                      </div>
                      
                      
                    <br/><br/> 
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', @$reg->id) !!}
                  {!! Form::hidden('pasien_id', @@$reg->pasien->id) !!}
                  {!! Form::hidden('cara_bayar', @$reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form> 
            </div>
        </div>
    </div>
  </div>  

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
                                <select name="tarif_id[]" id="select2Multiple" class="form-control" required
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
                                            <option value="{{ $key }}" selected>{{ $item }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $item }}</option>
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
                                        {{-- <tr>
                                            <th>Hak Kelas JKN </th>
                                            <td>{{ $reg->hak_kelas_inap }}</td>
                                        </tr> --}}
                                    @endif
                                    <tr>
                                        {{-- <th>Kelas Perawatan </th> <td>{{ baca_kelas($reg->kelas_id) }}</td> --}}
                                        <th>Kelas Perawatan </th>
                                        <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                        @php
                                            session(['kelas_id' => @$reg->kelas_id]);
                                        @endphp
                                    </tr>
                                    {{-- <tr>
                                        <th>DPJP IGD</th>
                                        <td>{{ baca_dokter($reg->dokter_id) }}</td>
                                    </tr> --}}
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

    {{-- Modal History EWS ======================================================================== --}}
    <div class="modal fade" id="showEws" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">HISTORY EWS</h4>
          </div>
          <div class="modal-body">
            <div id="dataEws"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

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

@section('script')

<script>
  var reg_id = '{{$reg->id}}';
  let instance = 'cppt_perawat_'+reg_id;
  let draftCppt = localStorage.getItem(instance);
  let element = [
    $('textarea[name=subject]'),
    $('textarea[name=object]'),
    $('input[name=nadi]'),
    $('input[name=tekanan_darah]'),
    $('input[name=frekuensi_nafas]'),
    $('input[name=suhu]'),
    $('input[name=berat_badan]'),
    $('input[name=skala_nyeri]'),
    $('input[name=created_at]'),,
    $('select[name=kesadaran]'),
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
    destroyDraft(instance)
    $('.cppt-form')[0].submit();
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
    function cloneDiagnosis() {
        let templateElement = $('#template-diagnosis');
        let clonedElement = templateElement.clone(); // Clone the template element
        clonedElement.removeAttr('id'); // Remove id attribute to avoid duplicate ids
        clonedElement.show(); // Ensure the cloned element is visible (if it was hidden)

        clonedElement.find('.new-diagnosa').select2();
        clonedElement.find('.new-diagnosa').attr('disabled', false);

        clonedElement.insertBefore(templateElement);
    }
    
    let unit = "{{$unit}}";
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
  
  
  function showInputSkalaNyeri(input){
    var checkBox = input;
    var skalaNyeriAlternate = $('#skalanyeri-alternate');
    var skalaNyeri = $('.skala-nyeri');
    

    if(checkBox.checked == true){
      // alert('C');
      skalaNyeriAlternate.attr('disabled', true);
      skalaNyeri.attr('disabled', false);
    }else{
      skalaNyeriAlternate.attr('disabled', false);
      skalaNyeri.attr('disabled', true);
    }
  }
  function showInput(input){
    var checkBox = input;
    var diagnosis = $('#diagnosis-alternate');
    var planning = $('#planning-alternate');
    var implementasi = $('#implementasi-alternate');
    var selectDiagnosis = $('#select-diagnosis');
    var selectPlanning = $('#select-planning');
    var selectImplementasi = $('#select-implementasi');
    var newDiagnosis = $('.new-diagnosa');

    if(checkBox.checked == true){
      // alert('C');
      diagnosis.attr('disabled', false);
      planning.attr('disabled', false);
      implementasi.attr('disabled', false);

      selectDiagnosis.attr('disabled', true);
      selectPlanning.attr('disabled', true);
      selectImplementasi.attr('disabled', true);
      newDiagnosis.attr('disabled', true);
    }else{
      // alert('Gagal');
      diagnosis.attr('disabled', true);
      planning.attr('disabled', true);
      implementasi.attr('disabled', true);

      selectDiagnosis.attr('disabled', false);
      selectPlanning.attr('disabled', false);
      selectImplementasi.attr('disabled', false);
      newDiagnosis.attr('disabled', false);
    }
  }

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
  $(document).on('click', '#historiEWS', function (e) {
    var id = $(this).attr('data-reg');
    $('#showEws').modal('show');
    $('#dataEws').load("/get-ews/"+id);
  });  
  $(document).on('click', '#historiGizi', function(e) {
    var id = $(this).attr('data-giziID');
    $('#showHistoriGizi').modal('show');
    $('#dataHistoriGizi').load("/soap/history-gizi/" + id);
  });
  $(document).on('change', '#registrasi_select', function(){
    var regId = $(this).val();
    var unit = $('input[name=unit]').val();
    // console.log(unit);
    $('#showHistoriSoap').modal('show');
    $('#dataHistoriSoap').load("/soap/history-filter/"+unit+"/" + regId);
  });
  
  function getAskep() {
    let diagnosis = [];
    $('select[name="assesment[]"]:not([disabled]').each(function (i) {
      if ($(this).val() != '') {
        diagnosis.push($(this).val());
      }
    })

    var planning = $('#select-planning');
    var implementasi = $('#select-implementasi');
    let diagnosa = diagnosis.join("|");

    planning.empty();
    implementasi.empty();

    $.ajax({
      url: '/emr-get-askep?multiple=true&namaDiagnosa='+diagnosa,
      type: 'get',
      dataType: 'json',
    })
    .done(function(res) {
      if(res[0].metadata.code == 200){
        $.each(res[1], function(index, val){
          planning.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
        })
        $.each(res[2], function(index, val){
          implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
        })
      }
    })
  };

  var modal = document.getElementById("myModal");
  
 
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

    $('#select2Multiple').select2({
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
        $('#select2Multiple').select2({
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
    })
    $('select[name="bayar"]').on('change', function() {
        $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
            location.reload();
        });
    })
  </script>
@endif

<script>
$(document).ready(function() {
  //Dirujuk
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

});
</script>
@endsection
