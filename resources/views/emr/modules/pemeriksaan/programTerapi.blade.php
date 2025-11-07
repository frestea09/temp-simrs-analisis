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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/programTerapi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('asessment_id', @$assesment->id) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          
          <div class="col-md-6">

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td><b>Permintaan Terapi</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="permintaan_terapi" name="fisik[permintaanTerapi]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['permintaanTerapi'] ?? '' }}</textarea>
                </td>
              </tr>
            </table>
            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <thead>
                <tr>
                  <th style="text-align: center;">PROGRAM</th>
                  <th style="text-align: center;">TANGGAL</th>
                  <th style="text-align: center;">PERTEMUAN</th>
                </tr>
              </thead> 
              <tbody>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][1]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['1'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][1]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['1'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][1]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['1'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][2]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['2'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][2]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['2'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][2]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['2'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][3]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['3'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][3]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['3'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][3]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['3'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][4]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['4'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][4]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['4'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][4]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['4'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][5]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['5'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][5]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['5'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][5]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['5'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][6]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['6'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][6]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['6'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][6]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['6'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][7]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['7'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][7]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['7'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][7]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['7'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="fisik[program][8]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['program']['8'] ?? '' }}">
                  </td>
                  <td>
                    <input type="date" name="fisik[tgl][8]" id="" class="form-control" style="display: inline-block;" value="{{ @$assesment['tgl']['8'] }}">
                  </td>
                  <td>
                    <select name="fisik[pertemuan][8]" class="form-control" style="display: inline-block;">
                      <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ (@$assesment['pertemuan']['8'] == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
            
            <button class="btn btn-success pull-right">Simpan</button>
          </div>

          <div class="col-md-6" style="margin-top: 10px;">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">
                      <a href="{{ url('cetak-all-program-terapi/pdf/' . $reg->id . '/' . $reg->pasien_id) }}" target="_blank" class="btn btn-flat btn-sm btn-success">
                          <i class="fa fa-print"></i> RIWAYAT BULAN {{strtoupper(bulan(date('m', strtotime($reg->created_at))))}} {{date('Y', strtotime($reg->created_at))}}
                      </a>
                  </th>
                </tr>              
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  <th class="text-center" style="vertical-align: middle;">TTE Program Terapi</th>
                </tr>
              </thead>
              <tbody>
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Tidak Ada Riwayat Program Terapi</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                    <tr>
                        
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <input type="checkbox" name="riwayat_id[]" value="{{$riwayat->id}}" id="">&nbsp;&nbsp;&nbsp;
                            {{Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ URL::current() . '?asessment_id='. $riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <a target="_blank" href="{{ url('/signaturepad/program-terapi/'.@$riwayat->registrasi_id) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" 
                              title="ttd pasien">
                              <i class=""></i>TTD
                            </a>
                            <a href="{{ url("cetak-program-terapi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                              <i class="fa fa-print"></i>
                            </a>
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                              <i class="fa fa-trash"></i>
                            </a>
                        </td>

                        <td style="text-align: center;">
                          <button type="button" class="btn btn-danger btn-sm btn-flat proses-tte-program-terapi" data-registrasi-id="{{@$riwayat->registrasi->id}}" data-id="{{@$riwayat->id}}">
                            <i class="fa fa-pencil"></i>
                          </button>
                          @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                              <a href="{{ url('/cetak-tte-program-terapi/pdf/'. $riwayat->registrasi->id . '/' . @$riwayat->id) }}"
                                  target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                      class="fa fa-download"></i> </a>
                          @elseif (!empty($riwayat->tte))
                              <a href="{{ url('/dokumen_tte/'. @$riwayat->tte) . "?source=cppt" }}"
                                  target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                      class="fa fa-download"></i> </a>
                          @endif
                        </td>
                    </tr>
                    <tr>
                      <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                      </td>
                    </tr>
                @endforeach
              
              </tbody>
              <tfoot>
                
                <tr>
                  <td><input type="submit" name="cetak_terpilih" value="CETAK_TERPILIH" class="btn btn-success pull-right"></td>
                  <td><input type="submit" name="cetak_terpilih_sign" value="CETAK_TERPILIH_SIGN" class="btn btn-success pull-right"></td>
                </tr>
              </tfoot>
            </table>
          </div>

          <br /><br />

        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal TTE Program Terapi-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-program-terapi" action="{{ url('tte-pdf-program-terapi') }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Program Terapi</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden" disabled>
          <input type="hidden" class="form-control" name="id" id="id" disabled>
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
        <button type="submit" class="btn btn-primary" id="button-proses-tte-program-terapi">Proses TTE</button>
      </div>
    </div>
    </form>

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
        $("#date_dengan_tanggal").attr('', true);  
         

        // TTE Program Terapi

        $('.proses-tte-program-terapi').click(function () {
            $('#registrasi_id_hidden').val($(this).data("registrasi-id"));
            $('#id').val($(this).data("id"));
            $('#myModal').modal('show');
        })

        $('#form-tte-program-terapi').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-program-terapi')[0].submit();
        })
  </script>
  {{-- <script>
    function loadFromLocalStorage() {
      const hasilPlanning = localStorage.getItem('dataPlanning');
      if (hasilPlanning) {
        document.getElementById('permintaan_terapi').value = hasilPlanning;
      }
    }
  
    document.addEventListener('DOMContentLoaded', loadFromLocalStorage);
  </script>  
  <script>
    function loadFromLocalStorage() {
      const hasilPlanning2 = localStorage.getItem('dataPlanning2');
      if (hasilPlanning2) {
        document.getElementById('permintaan_terapi').value = hasilPlanning2;
      }
    }
  
    document.addEventListener('DOMContentLoaded', loadFromLocalStorage);
  </script> --}}
@endsection