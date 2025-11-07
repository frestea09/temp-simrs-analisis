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
    padding-left: 0px !important;
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/rehabBaru/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
            <h5><b>SIMPLIFIKASI FORMAT FORMULIR RAWAT JALAN KFR/ASESMEN/RE-ASESMEN/PROTOKOL TERAPI</b></h5>
            
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td style="width: 30%;"><b>Subjective</b></td>
                <td style="padding: 5px;">
                  {{-- <textarea rows="3" name="fisik[subjective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >
@if (@$current_asessment['subjective'])
{{ @$current_asessment['subjective'] }}
@elseif (@$aswal['anamnesa'])
Keluhan Utama : {{@$aswal['anamnesa']}}
Riwayat Penyakit Sekarang : {{@$aswal['riwayatPenyakitSekarang']}}
@endif</textarea> --}}
                  <textarea rows="3" name="fisik[subjective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{@$current_asessment['subjective'] ?? @$soap->subject}}</textarea>
                </td>
              </tr>

              <tr>
                <td><b>Objective</b></td>
                <td style="padding: 5px;">
                  {{-- <textarea rows="3" id="objective" name="fisik[objective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control">
@php
$texts = [];             
if (!empty(@$current_asessment['objective'])) {
$texts[] = @$current_asessment['objective'];
} elseif (!empty(@$aswal['pemeriksaan_fisik'])) {
$texts[] = @$aswal['pemeriksaan_fisik'];
} elseif (!empty(@$ujiFungsi['hasilDidapat'])) {
$texts[] = @$ujiFungsi['hasilDidapat'];
} elseif (!empty(@$soap)) {
$hasil = [
'Echo' => @$soap->hasil_echo,
'EKG' => @$soap->hasil_ekg,
'EEG' => @$soap->hasil_eeg,
'USG Kandungan' => @$soap->hasil_usg,
'CTG' => @$soap->hasil_ctg,
'Spirometri' => @$soap->hasil_spirometri,
'Lainnya' => @$soap->hasil_lainnya
];
foreach (array_filter($hasil) as $key => $value) {
$texts[] = "$key : $value";
}
}
echo implode("\n", $texts);
@endphp</textarea> --}}
                  <textarea rows="3" id="objective" name="fisik[objective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{@$current_asessment['objective'] ?? @$soap->object}}</textarea>
                </td>
              </tr>

              <tr>
                <td><b>Assessment</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="assessment" name="fisik[assessment]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$current_asessment['assessment'] ?: 
                       trim((@$soap->assesment ? 'Diagnosa Utama : '.@$soap->assesment : '') . "\n" . 
                            (@$soap->diagnosistambahan ? 'Diagnosa Tambahan : '.@$soap->diagnosistambahan : '')) }}
                  </textarea>
                </td>
              </tr>

              <tr>
                <td colspan="2"><b>Planning</b></td>
              </tr>
              <tr>
                <td style="padding-left: 20px;"><b>a.	Goal of Treatment:</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="planning" name="fisik[planning][goal_treatment]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['planning']['goal_treatment'] ? @$current_asessment['planning']['goal_treatment'] : '' }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 20px;"><b>b.	Tindakan/Program Rehabilitasi Medik:</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="planning" name="fisik[planning][tindakan_rehab]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['planning']['tindakan_rehab'] ?? @$soap->planning }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 20px;"><b>c.	Edukasi:</b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="planning" name="fisik[planning][edukasi]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['planning']['edukasi'] ? @$current_asessment['planning']['edukasi'] : '' }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 20px;"><b>d.	Frekuensi Kunjungan: </b></td>
                <td style="padding: 5px;">
                  <textarea rows="3" id="planning" name="fisik[planning][frekuensi_kunjungan]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['planning']['frekuensi_kunjungan'] ? @$current_asessment['planning']['frekuensi_kunjungan'] : '' }}</textarea>
                </td>
              </tr>

              <input type="hidden" name="fisik[tgl_pelayanan]" value="{{ now() }}">
              
              <tr>
                <td colspan="2"><b>Rencana Tindak Lanjut (Evaluasi/Rujuk/Selesai)*</b></td>
              </tr>
              <tr>
                @php
                    $discharge = json_decode($soap->discharge);
                    $rencana_tindak_lanjut = '';

                    foreach ($discharge->dischargePlanning as $key => $value) {
                        if (!empty($value->dipilih)) {
                            $rencana_tindak_lanjut = $value->dipilih;
                            if (!empty($value->waktu)) {
                                $rencana_tindak_lanjut .= ', ' . $value->waktu;
                            }
                            break;
                        }
                    }
                @endphp
                <td colspan="2" style="padding: 5px;">
                  <textarea rows="3" id="rencana_tindak_lanjut" name="fisik[rencana_tindak_lanjut]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control">{{ @$current_asessment['rencana_tindak_lanjut'] ?? @$rencana_tindak_lanjut }}</textarea>
                </td>
              </tr>
            </table>

              <h5><b>SIMPLIFIKASI FORMAT LEMBAR PROGRAM TERAPI/PENDAMPINGAN/SEBELUM DAN SESUDAH SESI REHABILITASI</b></h5>
              <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
                <tr>
                  <td style="width: 30%;"><b>Subjective</b></td>
                  <td style="padding: 5px;">
                    <textarea rows="3" name="fisik[fisioterapis][subjective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['fisioterapis']['subjective'] ?? @$soap_terapis->subject }}</textarea>
                  </td>
                </tr>
  
                <tr>
                  <td><b>Objective</b></td>
                  <td style="padding: 5px;">
                    <textarea rows="3" id="objective" name="fisik[fisioterapis][objective]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['fisioterapis']['objective'] ?? @$soap_terapis->object }}</textarea>
                  </td>
                </tr>
  
                <tr>
                  <td><b>Assessment</b></td>
                  <td style="padding: 5px;">
                    <textarea rows="3" id="assessment" name="fisik[fisioterapis][assessment]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['fisioterapis']['assessment'] ?: 
                      trim((@$soap_terapis->assesment ? 'Diagnosa Utama : '.@$soap_terapis->assesment : '') . "\n" . 
                           (@$soap_terapis->diagnosistambahan ? 'Diagnosa Tambahan : '.@$soap_terapis->diagnosistambahan : '')) }}</textarea>
                  </td>
                </tr>
  
                <tr>
                  <td><b>Procedure</b></td>
                  <td style="padding: 5px;">
                    <textarea rows="3" id="procedure" name="fisik[fisioterapis][procedure]" style="display:inline-block; resize: vertical;" placeholder="" class="form-control" >{{ @$current_asessment['fisioterapis']['procedure'] ?? @$soap_terapis->planning }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td><b>Tim Rehabilitasi Medik</b></td>
                  <td style="padding: 5px;">
                    <select class="form-control select2" name="fisik[pegawai_rehab]" style="width:100%;">
                      @foreach($pegawai as $d)
                          <option value="{{ $d->id }}" 
                              {{ (isset($current_asessment) && $current_asessment['pegawai_rehab'] == $d->id) ? 'selected' : '' }}>
                              {{ baca_pegawai($d->nama) }}
                          </option>
                      @endforeach             
                    </select>                
                  </td>
                </tr>

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
                    <a href="{{ url('cetak-all-rehab-baru/pdf/' . $reg->id . '/' . $reg->pasien_id) }}" target="_blank" class="btn btn-flat btn-sm btn-success">
                      <i class="fa fa-print"></i> RIWAYAT BULAN {{strtoupper(bulan(date('m', strtotime($reg->created_at))))}} {{date('Y', strtotime($reg->created_at))}}
                    </a>
                  </th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                  <th class="text-center" style="vertical-align: middle;">Poli</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  <th class="text-center" style="vertical-align: middle;">TTE Rehab Baru</th>
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
                            {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{ baca_poli($riwayat->registrasi->poli_id) }}
                        </td>
                      
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ URL::current() . '?asessment_id='. $riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="{{ url("cetak-rehab-baru/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                              <i class="fa fa-print"></i>
                            </a>
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                              <i class="fa fa-trash"></i>
                            </a>
                        </td>

                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          <button type="button" class="btn btn-danger btn-sm btn-flat proses-tte-rehab-baru" data-registrasi-id="{{@$riwayat->registrasi->id}}" data-id="{{@$riwayat->id}}">
                            <i class="fa fa-pencil"></i>
                          </button>
                          @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                              <a href="{{ url('/cetak-tte-rehab-baru/pdf/'. $riwayat->registrasi->id . '/' . @$riwayat->id) }}"
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
                      <td colspan="4" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
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
    </form>
  </div>
</div>

<!-- Modal TTE Rehab Baru-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="form-tte-rehab-baru" action="{{ url('tte-pdf-rehab-baru') }}" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE Rehab Baru</h4>
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
        <button type="submit" class="btn btn-primary" id="button-proses-tte-rehab-baru">Proses TTE</button>
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
         
        // TTE Rehab Baru

        $('.proses-tte-rehab-baru').click(function () {
            $('#registrasi_id_hidden').val($(this).data("registrasi-id"));
            $('#id').val($(this).data("id"));
            $('#myModal').modal('show');
        })

        $('#form-tte-rehab-baru').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-rehab-baru')[0].submit();
        })
  </script>
  {{-- <script>
    function loadFromLocalStorage() {
      const hasilDiagnosa3 = localStorage.getItem('dataDiagnosa');
      const hasilPlanning3 = localStorage.getItem('dataPlanning');
      const hasilObjective3 = localStorage.getItem('dataObjective');
  
      if (hasilDiagnosa3) {
        document.getElementById('diagnosis_medis').value = hasilDiagnosa3;
        document.getElementById('kesimpulan').value = hasilDiagnosa3;
      }
      if (hasilPlanning3) {
        document.getElementById('rekomendasi').value = hasilPlanning3;
      }
      if (hasilObjective3) {
        document.getElementById('hasil_yang_didapat').value = hasilObjective3;
      }
    }
  
    document.addEventListener('DOMContentLoaded', loadFromLocalStorage);
  </script>  --}}
@endsection