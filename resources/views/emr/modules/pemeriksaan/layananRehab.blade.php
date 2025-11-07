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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/layananRehab/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          
          <div class="col-md-6">
            <h5><b>Diisi oleh Dokter SpKFR</b></h5>

            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td><b>Anamnesa</b></td>
                <td style="padding: 5px;">
                  {{-- <textarea rows="3" name="fisik[anamnesa]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['anamnesa'] ? @$assesment['anamnesa'] : @$soap->subject  }}</textarea> --}}
                  <textarea rows="3" id="anamnesa" name="fisik[anamnesa]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['anamnesa'] ? @$assesment['anamnesa'] : ''  }}</textarea>
                </td>
              </tr>

              <tr>
                <td><b>Pemeriksaan Fisik</b></td>
                <td style="padding: 5px;">
                  {{-- <textarea rows="3" name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaan_fisik'] ?@$assesment['pemeriksaan_fisik'] : @$soap->object }}</textarea> --}}
                  <textarea rows="3" id="pemeriksaan_fisik" name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['pemeriksaan_fisik'] ?@$assesment['pemeriksaan_fisik'] : '' }}</textarea>
                </td>
              </tr>

              <input type="hidden" name="fisik[tgl_pelayanan]" value="{{ now() }}">
              
              <tr>
                <td><b>Pemeriksaan Penunjang</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[pemeriksaan_penunjang]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control"></textarea>
                </td>
              </tr>

              <tr>
                <td><b>Anjuran</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[anjuran]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control"></textarea>
                </td>
              </tr>

              <tr>
                <td><b>Evaluasi</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" name="fisik[evaluasi]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control"></textarea>
                </td>
              </tr>

              <tr>
                <td><b>Suspek Penyakit Akibat Kerja</b></td>
                <td style="padding: 5px;">
                  <input type="radio" id="penyakitAkibatKerja1" name="fisik[penyakitAkibatkerja][pilihan]" value="Tidak" checked>
                    <label for="penyakitAkibatKerja1" style="font-weight: normal;">Tidak</label>
                    <input type="radio" id="penyakitAkibatKerja2" name="fisik[penyakitAkibatkerja][pilihan]" value="Ya">
                    <label for="penyakitAkibatKerja2" style="font-weight: normal;">Ya</label><br>
                    <input type="text" name="fisik[penyakitAkibatkerja][keterangan]" style="display:inline-block;" class="form-control" value="{{ @$assesment['penyakitAkibatkerja']['keterangan'] }}">
                </td>
              </tr>

              <tr>
                <td><b>ICD 10</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="icd_10" name="fisik[icd10]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['icd10'] ?@$assesment['icd10'] :@$soap->assesment }}</textarea>
                </td>
              </tr>
              <tr>
                <td><b>ICD 9</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="icd_9" name="fisik[icd9]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$assesment['icd9'] }}</textarea>
                </td>
              </tr>

            </table>

            <button class="btn btn-success pull-right">Simpan</button>
          </form>

          </div>

          <div class="col-md-6" style="margin-top: 10px;">
            {{-- <form method="POST" action="{{ url('emr-soap-icd/icd10/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
              {{ csrf_field() }}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
              {!! Form::hidden('cara_bayar', $reg->bayar) !!}
              {!! Form::hidden('unit', $unit) !!}

              <table class='table table-striped table-bordered table-hover table-condensed'>
                <tr>
                  <td style="width:20%;"><b>ICD 10</b></td>
                  <td style="padding: 5px;">
                    <select name="diagnosa_awal[]" id="select2Multiple" class="form-control" multiple="multiple">    
                  </td>
                </tr>

                <tr>
                  <td colspan="2">
                    <button class="btn btn-success pull-right">Simpan ICD 10</button>
                  </td>
                </tr>
              </table>
            </form> --}}

            {{-- <form method="POST" action="{{ url('emr-soap-icd/icd9/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
              {{ csrf_field() }}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
              {!! Form::hidden('cara_bayar', $reg->bayar) !!}
              {!! Form::hidden('unit', $unit) !!}

              <table class='table table-striped table-bordered table-hover table-condensed'>
                <tr>
                  <td style="width:20%;"><b>ICD 9</b></td>
                  <td style="padding: 5px;">
                    <select name="diagnosa_awal[]" id="icd9" class="form-control" multiple="multiple">    
                  </td>
                </tr>

                <tr>
                  <td colspan="2">
                    <button class="btn btn-success pull-right">Simpan ICD 9</button>
                  </td>
                </tr>
              </table>
            </form> --}}

            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">
                    <a href="{{url('cetak-all-layanan-rehab/pdf/' . $reg->id . '/' . $reg->pasien_id)}}" target="_blank" class="btn btn-flat btn-sm btn-success">
                      <i class="fa fa-print"></i> RIWAYAT BULAN {{strtoupper(bulan(date('m', strtotime($reg->created_at))))}} {{date('Y', strtotime($reg->created_at))}}
                    </a>
                  </th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  <th class="text-center" style="vertical-align: middle;">TTE Layanan Rehab</th>
                </tr>
              </thead>
              <tbody>
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Tidak Ada Riwayat Layanan Rehab</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli(@$riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <a target="_blank" href="{{ url('/signaturepad/layanan-rehab/'.@$riwayat->registrasi_id) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" 
                              title="ttd pasien">
                              <i class=""></i>TTD
                            </a>
                            <a href="{{ url("cetak-layanan-rehab/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                              <i class="fa fa-print"></i>
                            </a>
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                              <i class="fa fa-trash"></i>
                            </a>
                        </td>

                        <td style="text-align: center;">
                          <button type="button" class="btn btn-danger btn-sm btn-flat proses-tte-layanan-rehab" data-registrasi-id="{{@$riwayat->registrasi->id}}" data-layanan-id="{{@$riwayat->id}}">
                            <i class="fa fa-pencil"></i>
                          </button>
                          @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                              <a href="{{ url('cetak-tte-layanan-rehab/pdf/'. $riwayat->registrasi->id . '/' . @$riwayat->id) }}"
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
            </table>
          </div>

          <br /><br />

        </div>
      </div>
    
  </div>
</div>

<!-- Modal TTE Hasil layanan rehab medik-->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-layanan-rehab-medik" action="{{ url('tte-pdf-layanan-rehab') }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Hasil Layanan Rehab Medik</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
          <input type="hidden" class="form-control" name="layanan_id" id="layanan_id" disabled>
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
        <button type="submit" class="btn btn-primary" id="button-proses-tte-layanan-rehab">Proses TTE</button>
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
    
  //ICD 10
  $('#select2Multiple').select2({
      placeholder: "Klik untuk isi nama kode",
      width: '100%',
      ajax: {
          url: '/penjualan/kode/',
          // url: '/tindakan/ajax-tindakan/'+status_reg,
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

  //ICD9
  $('#icd9').select2({
      placeholder: "Klik untuk isi nama kode",
      width: '100%',
      ajax: {
          url: '/penjualan/kode/icd-9',
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

        
    // TTE Layanan rehab

    $('.proses-tte-layanan-rehab').click(function () {
        $('#registrasi_id_hidden3').val($(this).data("registrasi-id"));
        $('#layanan_id').val($(this).data("layanan-id"));
        $('#myModal3').modal('show');
    })

    $('#form-tte-layanan-rehab-medik').submit(function (e) {
        e.preventDefault();
        $('input').prop('disabled', false);
        $('#form-tte-layanan-rehab-medik')[0].submit();
    })
  </script>
  <script>
    function loadFromLocalStorage() {
      const hasilDiagnosa = localStorage.getItem('dataDiagnosa');
      const hasilPlanning = localStorage.getItem('dataPlanning');
      const hasilObjective = localStorage.getItem('dataObjective');
      const hasilSubjective = localStorage.getItem('dataSubjective');
  
      if (hasilDiagnosa) {
        document.getElementById('icd_10').value = hasilDiagnosa;
      }
      if (hasilPlanning) {
        document.getElementById('icd_9').value = hasilPlanning;
      }
      if (hasilObjective) {
        document.getElementById('pemeriksaan_fisik').value = hasilObjective;
      }
      if (hasilSubjective) {
        document.getElementById('anamnesa').value = hasilSubjective;
      }
    }
  
    document.addEventListener('DOMContentLoaded', loadFromLocalStorage);
  </script>  
  <script>
    function loadFromLocalStorage() {
      const hasilDiagnosa2 = localStorage.getItem('dataDiagnosa2');
      const hasilPlanning2 = localStorage.getItem('dataPlanning2');
      const hasilObjective2 = localStorage.getItem('dataObjective2');
      const hasilSubjective2 = localStorage.getItem('dataSubjective2');
  
      if (hasilDiagnosa2) {
        document.getElementById('icd_10').value = hasilDiagnosa2;
      }
      if (hasilPlanning2) {
        document.getElementById('icd_9').value = hasilPlanning2;
      }
      if (hasilObjective2) {
        document.getElementById('pemeriksaan_fisik').value = hasilObjective2;
      }
      if (hasilSubjective2) {
        document.getElementById('anamnesa').value = hasilSubjective2;
      }
    }
  
    document.addEventListener('DOMContentLoaded', loadFromLocalStorage);
  </script> 
@endsection