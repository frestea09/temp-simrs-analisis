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
</style>
@section('header')
<h1>Perencanaan - Rujukan Rumah Sakit</h1>
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

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/perencanaan/rujukanRS/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('poli', $poli) !!}
          {!! Form::hidden('dpjp', $dpjp) !!}
          @if (isset($surat))
            {!! Form::hidden('surat_id', $surat->id) !!}
          @endif
          <br>
          
          @php
            $content = json_decode(@$surat->rujukan_rs);
          @endphp
          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Rujukan Rumah Sakit</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="padding: 5px;" colspan="2">
                  <textarea rows="15" name="rujukan_rs[alasan]" style="display:inline-block" placeholder="kami mengirimkan pasien, dengan alasan :" class="form-control">{{@$content->alasan}}</textarea></td>
                </td>
             </tr>
              <tr>
                <td style="width:20%;">Ruangan</td>
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[ruangan]" placeholder="Ruangan :" value="{{@$content->ruangan}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal Masuk</td>
                <td style="padding: 5px;">
                  <input type="date" name="rujukan_rs[tanggal_masuk]" placeholder="Tanggal Masuk :" value="{{@$content->ruangan}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Jam Masuk</td>
                <td style="padding: 5px;">
                  <input type="time" name="rujukan_rs[jam_masuk]" placeholder="Jam Masuk :" value="{{@$content->jam_masuk}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Rumah Sakit Rujukan / Tujuan</td>
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[rumah_sakit_tujuan]" placeholder="RS Tujuan :" value="{{@$content->rumah_sakit_tujuan}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Dokter Penerima</td>
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[dokter_penerima]" placeholder="Dokter Penerima :" value="{{@$content->dokter_penerima}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Dokter Perawat / Pendamping</td>
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[dokter_perawat]" placeholder="Dokter Perawat / Pendamping :" value="{{@$content->dokter_perawat}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Diagnosis</td>
                <td style="padding: 5px;">
                    <textarea rows="15" name="rujukan_rs[diagnosis]" style="display:inline-block" placeholder="Diagnosis :" class="form-control">{{@$content->diagnosis}}</textarea>
              </tr>
              <tr>
                <td style="width:20%;">Pengobatan/Tindakan</td>
                <td style="padding: 5px;">
                    <textarea rows="15" name="rujukan_rs[pengobatan]" style="display:inline-block" placeholder="Pengobatan / Tindakan yang telah diberikan :" class="form-control">{{@$content->pengobatan}}</textarea>
              </tr>
              <tr>
                <td style="width:20%;">Rencana Tindak Lanjut
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[rencana_tindak_lanjut]" placeholder="Rencana Tindak Lanjut :" value="{{@$content->rencana_tindak_lanjut}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width:20%;"><b>Keterangan Alat Medis Yang Digunakan</b>
              </tr>
              <tr>
                <td style="width:20%;">IV Catch No :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[iv_catch]" placeholder="IV Catch No :" value="{{@$content->iv_catch}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">DC No :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[dc]" placeholder="DC No :" value="{{@$content->dc}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">NGT :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[ngt]" placeholder="NGT :" value="{{@$content->ngt}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Keterangan Penunjang :
                <td style="padding: 5px;">
                  <textarea rows="15" name="rujukan_rs[keterangan_penunjang]" style="display:inline-block" placeholder="Keterangan Penunjang :" class="form-control">{{@$content->keterangan_penunjang}}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width:20%;"><b>Kondisi Pasien Saat Keluar Dari Rumah Sakit</b>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal Keluar :
                <td style="padding: 5px;">
                  <input type="date" name="rujukan_rs[tanggal_keluar]" placeholder="Tanggal Keluar :" value="{{@$content->tanggal_keluar}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Riwayat Alergi :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[riwayat_alergi]" placeholder="Riwayat Alergi :" value="{{@$content->riwayat_alergi}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Kesadaran :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[kesadaran]" placeholder="Kesadaran :" value="{{@$content->kesadaran}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">GCS :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[gcs]" placeholder="GCS :" value="{{@$content->gcs}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">E :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[e]" placeholder="E :" value="{{@$content->e}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">M :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[m]" placeholder="M :" value="{{@$content->m}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">V :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[v]" placeholder="V :" value="{{@$content->v}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">BB :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[bb]" placeholder="BB :" value="{{@$content->bb}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">KG :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[kg]" placeholder="KG :" value="{{@$content->kg}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">TD :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[td]" placeholder="TD :" value="{{@$content->td}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">HR :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[hr]" placeholder="HR :" value="{{@$content->hr}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">RR :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[rr]" placeholder="RR :" value="{{@$content->rr}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Suhu :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[suhu]" placeholder="Suhu :" value="{{@$content->suhu}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">SpO2 :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[spo2]" placeholder="SpO2 :" value="{{@$content->spo2}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width:20%;"><b>Catatan Observasi Selama Dirujuk</b>
              </tr>
              <tr>
                <td style="width:20%;">Jam :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[jam]" placeholder="Jam :" value="{{@$content->jam}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Catatan :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[catatan]" placeholder="Catatan :" value="{{@$content->catatan}}" class="form-control"/>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:20%;"><b>Petugas</b>
              </tr>

              <tr>
                <td style="width:20%;">Petugas yang menyerahkan :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[petugas_yang_menyerahkan]" placeholder="Petugas yang menyerahkan :" value="{{@$content->petugas_yang_menyerahkan}}" class="form-control"/>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Petugas yang menerima :
                <td style="padding: 5px;">
                  <input type="text" name="rujukan_rs[petugas_yang_menerima]" placeholder="Petugas yang menerima :" value="{{@$content->petugas_yang_menerima}}" class="form-control"/>
                </td>
              </tr>
            </table>
          </div>
          {{-- Alergi --}}
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
                @foreach ($riwayat as $item)
                  @php
                    $r = json_decode(@$item->rujukan_rs);
                  @endphp
                  <tr>
                    <td> 
                      <b>Dokter Penerima	:</b> {{$r->dokter_penerima}}<br/>
                      <b>Rumah Sakit Tujuan	:</b> {{$r->rumah_sakit_tujuan}}<br/>
                      <b>Diagnosis	:</b> {{$r->diagnosis}}<br/>
                      <b>Alasan	:</b> {{$r->alasan}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('delete-emr-soap-surat-rujukan-rumahsakit/'.$item->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                        <a href="{{ url('emr-soap/perencanaan/rujukanRS/'.$unit.'/'.$reg->id . '?surat_id=' . $item->id) . '&dpjp=' . $dpjp . '&poli=' . $poli }}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil text-warning"></i></a>&nbsp;&nbsp;
                        <a target="_blank" href="{{url('emr-soap-print-surat-rujukan-rumahsakit/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                      </span>
                    </td>
                  </tr>
                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>

        
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <br/>
    {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  
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
         
  </script>
  @endsection