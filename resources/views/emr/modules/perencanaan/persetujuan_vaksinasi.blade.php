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
<h1>Persetujuan Vaksinasi</h1>
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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/perencanaan/persetujuan-vaksinasi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('asessment_id', @$riwayat->id) !!}
          <br>

          <h5 class="text-center"><b>FORMULIR PERSETUJUAN/IZIN TINDAKAN VAKSINASI</b></h5>
          <div class="col-md-6">
            <input type="hidden" name="assesment_type" value="hasil">
            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width: 40%;">Nomor Pemberi Consent</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[pemberi_consent]" value="{{@$assesment['pemberi_consent']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Alamat</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[alamat_pemberi_consent]" value="{{@$assesment['alamat_pemberi_consent']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Nomor HP</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[no_pemberi_consent]" value="{{@$assesment['no_pemberi_consent']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Nama Saksi</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[nama_saksi]" value="{{@$assesment['nama_saksi']}}">
                </td>
              </tr>
            </table>
            <br>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width: 40%;">Jenis Vaksinasi</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[jenis_vaksinasi]" value="{{@$permohonan['jenis_vaksinasi'] ?? @$assesment['jenis_vaksinasi']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Nomor Passport</td>
                <td style="width: 60%;">
                  <input type="text" style="padding: 5px;" class="form-control" name="keterangan[nomor_passport]" value="{{@$permohonan['nomor_passport'] ?? @$assesment['nomor_passport']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Tanggal</td>
                <td style="width: 60%;">
                  <input type="date" style="padding: 5px;" class="form-control" name="keterangan[tanggal]" value="{{@$assesment['tanggal']}}">
                </td>
              </tr>
              <tr>
                <td style="width: 40%;">Perawat</td>
                <td style="width: 60%;">
                  <select name="keterangan[perawat]" class="form-control select2" style="width: 100%;">
                    <option value="">-- Pilih Perawat --</option>
                    @foreach ($perawat as $p)
                      <option value="{{ $p->id }}" {{ (isset($assesment['perawat']) && $assesment['perawat'] == $p->id) ? 'selected' : '' }}>
                        {{ $p->nama }}
                      </option>
                    @endforeach
                  </select>
                </td>
              </tr>
            </table>
            <div style="text-align: right;">
              <button class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
          <div class="col-md-6">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  <th class="text-center" style="vertical-align: middle;">ttd</th>
                </tr>
              </thead>
            <tbody>
              {{-- {{ dd($riwayats) }} --}}
              @if (count($riwayats) == 0)
                  <tr>
                      <td colspan="3" class="text-center">Tidak Ada Riwayat Perencanaan</td>
                  </tr>
              @endif
              @foreach ($riwayats as $riwayat)
                  <tr>
                      <td style="text-align: center; {{ @$riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                      </td>
                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                      </td>
                     
                      <td style="text-align: center; {{ @$riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="{{ url('emr-soap-print-persetujuan-vaksinasi/'.$unit.'/'.$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                          <a href="{{ url("emr-soap-delete/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                            <i class="fa fa-trash"></i>
                          </a>
                      </td>
                      <td style="text-align: center; {{ @$riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <a target="_blank" href="{{ url('/signaturepad/vaksinasi-saksi/'.@$reg->id) }}" class="btn btn-info btn-sm" title="ttd saksi"><i class=""></i>Saksi</a>
                          <a target="_blank" href="{{ url('/signaturepad/vaksinasi-pemberi-keterangan/'.@$reg->id) }}" class="btn btn-info btn-sm" title="ttd pembuat keterangan"><i class=""></i>pembuat keterangan</a>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                      <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                    </td>
                  </tr>
              @endforeach
             
            </tbody>
          </table>
          </div>
          

          <br /><br />
        </div>
      </div>
      
    {{-- </form> --}}

  </div>

  @endsection

  @section('script')


  <script type="text/javascript">
  $('.dates').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  status_reg = "<?= substr($reg->status_reg,0,1) ?>"
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd/mm/yyyy",
            autoclose: true
            // viewMode: "months", 
            // minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
  </script>
  @endsection