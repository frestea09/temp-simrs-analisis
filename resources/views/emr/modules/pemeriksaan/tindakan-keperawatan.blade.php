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
</style>
@section('header')
<h1>Ballard Score</h1>
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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/pemeriksaan/tindakan_keperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('asessment_id', @$tindakanKeperawatan->id) !!}
            
            <div class="col-md-6">
              <h5 class="text-center"><b>TINDAKAN KEPERAWATAN / KEBIDANAN</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                <tr>
                  <td style="width:20%;">Tanggal & Jam</td>
                  <td style="padding: 5px;">
                    <input type="datetime-local" name="fisik[tanggal_jam]" value="{{@$asessmen['tanggal_jam'] ?? date('Y-m-d H:i:s')}}" class="form-control"/>
                    <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">No DP </td>
                  <td style="padding: 5px;">
                    <input type="text" name="fisik[no_dp]" class="form-control" value="{{@$asessmen['no_dp']}}"/>
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Implementasi </td>
                  <td style="padding: 5px;">
                    <textarea rows="15" name="fisik[implementasi]" style="display:inline-block" placeholder="[Implementasi]" class="form-control">{{@$asessmen['implementasi']}}</textarea></td>
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">Evaluasi </td>
                  <td style="padding: 5px;">
                    <textarea rows="15" name="fisik[evaluasi]" style="display:inline-block" placeholder="[Evaluasi]" class="form-control">{{@$asessmen['evaluasi']}}</textarea></td>
                  </td>
                </tr>
                <tr>
                  <td style="width:20%;">TTD & Nama Jelas</td>
                  <td style="padding: 5px;">
                    <select name="fisik[ttd_pegawai]" class="select2">
                      <option value="">-- Pilih Salah Satu --</option>
                      @foreach ($pegawai as $p)
                        <option value="{{$p->id}}" {{@$asessmen['ttd_pegawai'] == $p->id ? 'selected' : ''}}>{{$p->nama}}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              </table>

              <div class="form-group" style="margin-top: 10px;">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-12">
                    {!! Form::submit(empty(@$tindakanKeperawatan) ? "Simpan" : "Perbarui", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                </div>
                <br>
              </div> 
            </div>

            <div class="col-md-6">
              <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                  </tr>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Dibuat</th>
                    <th class="text-center" style="vertical-align: middle;">User</th>
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
                            {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ @$riwayat->user->name }}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
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
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
  <script>
    $('.select2').select2({
      width: '100%'
    });
  </script>
@endsection
        