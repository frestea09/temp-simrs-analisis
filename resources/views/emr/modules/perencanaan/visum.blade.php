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
<h1>Visum</h1>
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
    <form method="POST" action="{{ url('emr-soap/perencanaan/visum/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
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
          <br>
          <br>
          <br>

          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>VISUM ET REPERTUM</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="width:20%;">Nomor Visum</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[nomorVisum]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['nomorVisum'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Asal Surat</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[asalSurat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['asalSurat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Nomor Surat</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[nomorSurat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['nomorSurat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal Surat</td>
                <td style="padding: 5px;">
                  <input type="date" name="keterangan[tglSurat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['tglSurat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Perihal Surat</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[perihalSurat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['perihalSurat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Yang Ditandatangani Oleh</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[penandaTanganSurat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['penandaTanganSurat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Pangkat</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[pangkat]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['pangkat'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">NRP</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[nrp]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['nrp'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Atas Nama</td>
                <td style="padding: 5px;">
                  <input type="text" name="keterangan[atasNama]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['atasNama'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Tanggal Pemeriksaan</td>
                <td style="padding: 5px;">
                  <input type="date" name="keterangan[tglPemeriksaan]" id="" class="form-control" style="display: inline-block;" value="{{ @$visum['tglPemeriksaan'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Hasil Pemeriksaan</td>
                <td style="padding: 5px;">
                  <textarea name="keterangan[pemeriksaanPetugas]" id="" class="form-control" style="resize: vertical; dispay: inline-block;" rows="10">{{ @$visum['pemeriksaanPetugas'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Kesimpulan</td>
                <td style="padding: 5px;">
                  <textarea name="keterangan[kesimpulan]" id="" class="form-control" style="resize: vertical; dispay: inline-block;" rows="10">{{ @$visum['kesimpulan'] }}</textarea>
                </td>
              </tr>
               
            </table>
          </div>
          {{-- Alergi --}}
          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Riwayat</b></h5>
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
                  <tr>
                    <td> 
                      {{-- <b>Nomor Surat Visum    :</b> {{@$item->nomor}}<br/> --}}
                      <b>Asal Surat	:</b> {{ @json_decode($item->keterangan, true)['asalSurat'] }}<br/>
                      <b>Tanggal Pemeriksaan :</b> {{ isset(json_decode($item->keterangan, true)['tglPemeriksaan']) ? date('d-m-Y', strtotime(json_decode($item->keterangan, true)['tglPemeriksaan'])) : '' }}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                      <span class="pull-right">
                        <a target="_blank" href="{{url('emr-soap-print-surat-visum/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                        <a href="{{url('emr-soap-delete/'.$unit.'/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
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