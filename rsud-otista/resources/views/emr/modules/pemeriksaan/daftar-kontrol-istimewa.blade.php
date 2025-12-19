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
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr.modules.addons.profile')
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/inap/daftar-kontrol-istimewa/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('poli_id', $poli) !!}
          {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          {!! Form::hidden('daftar_kontrol_istimewa_id', @$daftar_kontrol_istimewa_id) !!}
          <br>
            
          <h5 class="text-center"><b>Daftar Kontrol Istimewa</b></h5><hr>
            <div class="col-md-4">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 30%; font-weight: bold;">Tanggal</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][tanggal]" placeholder="Tanggal" class="form-control datepicker" value="{{ @$assesment['daftar_kontrol_istimewa']['tanggal'] }}" required >
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">SPO2</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][spo2]" placeholder="SPO2" class="form-control" value="{{ @$assesment['daftar_kontrol_istimewa']['spo2'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Tensi</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][tensi]" placeholder="Tensi" class="form-control" value="{{ @$assesment['daftar_kontrol_istimewa']['tensi'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Nadi</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][nadi]" placeholder="nadi" class="form-control" value="{{ @$assesment['daftar_kontrol_istimewa']['nadi'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Respirasi (x/menit)</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][respirasi]" placeholder="respirasi" class="form-control" value="{{ @$assesment['daftar_kontrol_istimewa']['respirasi'] }}">
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Suhu (c)</td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[daftar_kontrol_istimewa][suhu]" placeholder="suhu" class="form-control" value="{{ @$assesment['daftar_kontrol_istimewa']['suhu'] }}">
                  </td>
                </tr>
              </table>
            </div>
              
            <div class="col-md-8">
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                  <td style="width: 20%; font-weight: bold;">Tindakan therapi</td>
                  <td style="padding: 5px;">
                    <textarea name="fisik[daftar_kontrol_istimewa][tindakan_therapi]" placeholder="tindakan_therapi" class="form-control" cols="100">{{@$assesment['daftar_kontrol_istimewa']['tindakan_therapi']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Intake (cc)</td>
                  <td style="padding: 5px;">
                    <textarea name="fisik[daftar_kontrol_istimewa][intake]" placeholder="intake" class="form-control" cols="100">{{@$assesment['daftar_kontrol_istimewa']['intake']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Output (cc)</td>
                  <td style="padding: 5px;">
                    <textarea name="fisik[daftar_kontrol_istimewa][output]" placeholder="output" class="form-control" cols="100">{{@$assesment['daftar_kontrol_istimewa']['output']}}</textarea>
                  </td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">Keterangan</td>
                  <td style="padding: 5px;">
                    <textarea name="fisik[daftar_kontrol_istimewa][keterangan]" placeholder="keterangan" class="form-control" cols="100">{{@$assesment['daftar_kontrol_istimewa']['keterangan']}}</textarea>
                  </td>
                </tr>
              </table>
              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  @if (@$assesment)
                      <button class="btn btn-danger pull-right">Perbarui</button>
                      <a href="{{url()->current()}}" class="btn btn-warning pull-right">Batal Edit</a>
                  @else
                      <input type="hidden" name="simpan" value="true">
                      {!! Form::submit("Simpan Daftar Kontrol Istimewa", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                  @endif
                  
                </div>
              </div> 
            </div>
            
            <div class="col-md-12" style="margin-top:20px;">
              <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th colspan="11" class="text-center" style="vertical-align: middle;">History</th>
                  </tr>
                  <tr>
                    <th class="text-left" style="vertical-align: middle; width:8%;">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle; width:7%;">SPO2</th>
                    <th class="text-center" style="vertical-align: middle; width:7%;">Tensi</th>
                    <th class="text-center" style="vertical-align: middle; width:7%;">Nadi</th>
                    <th class="text-center" style="vertical-align: middle; width:7%; ">Respirasi<br>(x/menit)</th>
                    <th class="text-center" style="vertical-align: middle; width:7%;">Suhu<br>(c)</th>
                    <th class="text-center" style="vertical-align: middle;">Tindakan <br>therapi</th>
                    <th class="text-center" style="vertical-align: middle;">Intake <br>(cc)</th>
                    <th class="text-center" style="vertical-align: middle;">Output <br>(cc)</th>
                    <th class="text-center" style="vertical-align: middle;">Ket</th>
                    <th class="text-center" style="vertical-align: middle; width:7%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($riwayats_kontrol_istimewa) == 0)
                      <tr>
                          <td colspan="11" class="text-center">Tidak Ada Riwayat Kontrol Istimewa</td>
                      </tr>
                  @endif
                  @foreach ($riwayats_kontrol_istimewa as $riwayat)
                  @php
                    @$daftar_kontrol_istimewa = @json_decode(@$riwayat->fisik)->daftar_kontrol_istimewa;
                  @endphp
                      <tr>
                          <td style="text-align: left; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              {{@Carbon\Carbon::parse(@$daftar_kontrol_istimewa->tanggal)->format('d-m-Y')}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->spo2}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->tensi}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->nadi}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->respirasi}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->suhu}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->tindakan_therapi}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->intake}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->output}}
                          </td>
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@$daftar_kontrol_istimewa->keterangan}}
                          </td>
                        
                          <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                              <a href="{{ URL::current() . '?daftar_kontrol_istimewa_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>

                              <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                <i class="fa fa-trash"></i>
                              </a>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                        </td>
                      </tr>
                  @endforeach
                
                </tbody>
              </table>

              <div style="text-align:right;width:100%;">
                @if (count($riwayats_kontrol_istimewa) > 0)
                  <a href="{{ url("emr-soap/pemeriksaan/inap/daftar-kontrol-istimewa-cetak/".$unit."/".@$riwayat->registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Cetak </a>
                @else
                  <button disabled class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Cetak </button>
                @endif
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
        