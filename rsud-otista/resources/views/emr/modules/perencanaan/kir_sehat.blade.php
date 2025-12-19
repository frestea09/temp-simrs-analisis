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
    <form method="POST" enctype="multipart/form-data" action="{{ url('emr-soap/perencanaan/kir-sehat/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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

          <h5 class="text-center"><b>SURAT KETERANGAN SEHAT JASMANI</b></h5>
          <div class="col-md-6">
            <input type="hidden" name="assesment_type" value="hasil">
            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 

              {{-- <tr>
                <td style="width: 40%;">Nomor Surat</td>
                <td>
                  <input type="text" name="keterangan[no_surat]" value="{{ @$assesment['no_surat'] }}" class="form-control"></input>
                </td>
              </tr> --}}
              <tr>
                <td colspan="2" style="width: 40%;">Telah dilakukan pemeriksaan kesehatan secara fisik dengan hasil :</td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea type="text" name="keterangan[hasil]" class="form-control" rows="6">{{ @$assesment['hasil'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40%;">Keterangan ini diberikan untuk :</td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea type="text" name="keterangan[untuk]" class="form-control" rows="6">{{ @$assesment['untuk'] }}</textarea>
                </td>
              </tr>
            </table>
            @foreach (@$mcu_perawat as $d)
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td colspan="2" style="width: 40%;">Data Pendukung :</td>
              </tr>
              <tr>
                <td style="width: 5%;">TB :</td>
                <td>
                  <input type="text" name="keterangan[tb]" value="{{ @json_decode(@$d->fisik, true)['tanda_vital']['TB'] }}" class="form-control"></input>
                </td>
              </tr>
              <tr>
                <td style="width: 5%;">BB :</td>
                <td>
                  <input type="text" name="keterangan[bb]" value="{{ @json_decode(@$d->fisik, true)['tanda_vital']['BB'] }}" class="form-control"></input>
                </td>
              </tr>
              <tr>
                <td style="width: 5%;">TD :</td>
                <td>
                  <input type="text" name="keterangan[td]" value="{{ @json_decode(@$d->fisik, true)['tanda_vital']['tekanan_darah'] }}" class="form-control"></input>
                </td>
              </tr>
              <tr>
                <td style="width: 5%;">N :</td>
                <td>
                  <input type="text" name="keterangan[n]" value="{{ @json_decode(@$d->fisik, true)['tanda_vital']['nadi'] }}" class="form-control"></input>
                </td>
              </tr>
            </table>                        
            @endforeach
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
                  <th class="text-center" style="vertical-align: middle;">TTE</th>
                </tr>
              </thead>
            <tbody>
              {{-- {{ dd($riwayats) }} --}}
              @if (count($riwayats) == 0)
                  <tr>
                      <td colspan="4" class="text-center">Tidak Ada Riwayat Perencanaan</td>
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
                          <a href="{{ url('emr-soap-print-kir-sehat/'.$unit.'/'.$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                          <a href="{{ url("emr-soap-delete/perencanaan/kir-sehat/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                            <i class="fa fa-trash"></i>
                          </a>
                      </td>
                      <td style="text-align: center;">
                          <button type="button" class="btn btn-danger btn-sm btn-flat proses-tte-kir-sehat" data-registrasi-id="{{@$riwayat->registrasi->id}}" data-kir-id="{{@$riwayat->id}}">
                            <i class="fa fa-pencil"></i>
                          </button>
                          @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                              <a href="{{ url('cetak-tte-kir-sehat/pdf/'. $riwayat->registrasi->id . '/' . @$riwayat->id) }}"
                                  target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                      class="fa fa-download"></i> </a>
                          @elseif (!empty($riwayat->tte))
                            <a href="{{ url('/dokumen_tte/'. @$riwayat->tte) }}"
                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                    class="fa fa-download"></i> </a>
                          @endif
                      </td>
                  </tr>
                  <tr>
                    <td colspan="4" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
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

  <!-- Modal TTE KIR Sehat-->
  <div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <form id="form-tte-kir-sehat" action="{{ url('tte-pdf-kir-sehat') }}" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE KIR Sehat</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
            <input type="hidden" class="form-control" name="kir_id" id="kir_id" disabled>
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-kir-sehat">Proses TTE</button>
        </div>
      </div>
      </form>

    </div>
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

  // TTE KIR Sehat
  $('.proses-tte-kir-sehat').click(function () {
      $('#registrasi_id_hidden3').val($(this).data("registrasi-id"));
      $('#kir_id').val($(this).data("kir-id"));
      $('#myModal3').modal('show');
  })

  $('#form-tte-kir-sehat').submit(function (e) {
      e.preventDefault();
      $('input').prop('disabled', false);
      $('#form-tte-kir-sehat')[0].submit();
  })
  </script>
  @endsection