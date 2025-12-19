@extends('master')
@section('header')
  <h1>{{baca_unit($unit)}} - Radiologi<small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
<style>
  .input-cito{
    width: 100px !important;
    display: inline-block;
  }
  div.panel.box.box-primary{
    padding:0px !important;
  }
</style>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Order RIS</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        @include('emr.modules.addons.tabs')
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <br/>
          {{-- <a href="{{ url('cetak-emr/'.$reg->id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a> --}}
          {{-- <a href="{{ url('cetak-emr/pdf/'.$reg->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a> --}}
          {{-- <a href="{{ url('ris/getexam/'.$reg->pasien->no_rm) }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> EXAM RIS</a> --}}
          {{-- <button type="button" class="btn btn-warning btn-flat btn-history-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button> --}}
          {{-- <button type="button" id="exam"  data-rm="018451" class="btn btn-warning btn-sm btn-flat pull-right"> --}}
          <button type="button" id="exam"  data-reg="{{ $reg->id }}" class="btn btn-warning btn-sm btn-flat pull-right">
            <i class="fa fa-th-list"></i> EXAM RIS
          </button>
          {{-- <button type="button" class="btn btn-primary btn-flat btn-add-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i> TAMBAH E-RESEP</button><br/> --}}
          
      {{-- </div> --}}
    </div>
    </div>
    <br/>
    @php

      $poli = request()->get('poli');
      $dpjp = request()->get('dpjp');
    @endphp
      {{-- @if (! session('pj')) --}}
    {!! Form::open(['method' => 'POST', 'url' => 'ris/store', 'class' => 'form-horizontal']) !!}
      <div class="col-md-6">
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('poli_id', $poli) !!}
        {!! Form::hidden('cara_bayar_id', $reg->bayar) !!}
        {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
        {!! Form::hidden('unit', $unit) !!}
        {!! Form::hidden('reg_id', $reg->id) !!}
        {{-- <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
            {!! Form::label('penanggungjawab', 'Dokter Pengirim', ['class' => 'col-sm-4 control-label']) !!}
            
            <div class="col-sm-8">
                {!! Form::select('penanggungjawab', $dokter, $reg->dokter_id, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
            </div>
        </div> --}}
        @php
  
        $data['dokters_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('dokter_id');
        $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('perawat_id');
        $dokter_pengirim =   Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
        $dokter =  (explode(",", $data['dokters_poli'][0]));

        @endphp

        <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
            {!! Form::label('dokter_id', 'Dokter Radiologi', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              <select name="dokter_radiologi" id="" class="form-control select2" style="width:100%">
                @foreach ($dokter as $d)
                <option value="{{ $d }}">{{ baca_dokter($d) }}</option>
                @endforeach
              </select>
                {{-- {!! Form::select('dokter_radiologi', $radiografer, '', ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'']) !!} --}}
                <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
          {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::select('radiografer', $perawat, session('radiografer'), ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'','required'=>true]) !!}
              <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
          </div>
      </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jam', 'Jam Pengambilan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('pemeriksaan', 'Diagnosis', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              <textarea name="pemeriksaan" class="form-control" id="" cols="30" rows="7"></textarea>
              {{-- {!! Form::text('pemeriksaan', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small> --}}
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
          {!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('tgl_pemeriksaan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jamkeluar', 'Jam Keluar', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jamkeluar', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
          {!! Form::label('cyto', 'Cyto', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
            <select class="chosen-select" name="cyto">
              <option value="" selected>Tidak</option>
              <option value="1">Ya</option>
            </select>
              <small class="text-danger">{{ $errors->first('cyto') }}</small>
          </div>
      </div>
      </div>

      <div class="col-md-12">
        <h4>Input Test</h4>
        <table style="width: 100%" class="daftar_obat_2 table table-striped table-bordered table-hover table-condensed form-box"
          style="font-size:12px;">
          <tr>
            <th  class="text-center" style="width:50px;"><b>No</b></th>
            {{-- <th class="text-center" style="width:250px;"><b>Modality</b></th> --}}
            <th class="text-center" style="width:250px;"><b>Tindakan</b></th>
            <th class="text-center" style="width:250px;"><b>Jumlah</b></th>
            {{-- <th class="text-center" style="width:120px;"><b>Tanggal</b></th> --}}
            {{-- <th class="text-center" style="width:150px;"><b>Ruangan</b></th> --}}
            
          </tr>
          @for ($i=0;$i <= 2; $i++) 
            <tr>
              <td class="text-center">{{$i+1}}</td>
              {{-- <td>
                <select name="exam[{{$i}}][modality]" id="" class="form-control modality"></select>
              </td> --}}
              <td>
                <select name="exam[{{$i}}][examlist]" id="" class="form-control examlist"></select>
                <input type="hidden" value="{{date('d-m-Y')}}" name="exam[{{$i}}][tgl]">
              </td>
              <td class="text-center"><input type="number" value="1" class="form-control" name="exam[{{$i}}][jumlah]"></td>
              {{-- <td class="text-center"><input type="text" class="form-control" name="admisi[transfer][{{$i}}][cara]"></td> --}}
            </tr>
          @endfor
          <tfoot>
            <tr>
              <td colspan="7" class="text-right">
                <button type="button" class="add_daftar_2">Tambah Kolom</button>
                {{-- <button type="button" class="remove_field_button">Kurangi Kolom</button> --}}
              </td>
            </tr>
          </tfoot>
        </table>
      </div> 

    {{-- @endif --}}
    
      <div class="col-md-12">
        
        <button class="btn btn-success btn-flat pull-right" type="submit">Simpan</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

{{-- <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">History Order Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th width="40px" class="text-center">No</th>
            <th>No. Lab</th>
            <th width="200px" class="text-center">Tanggal</th>
            <th>Cetak</th>
          </tr>
        </thead>
        <tbody>
      @if(count($hasillabs) > 0)
        @php $no = 1; @endphp
        @foreach($hasillabs as $key=>$labs)

          <tr>
            <td class="text-center">{{$key+1}}</td>
            <td>{{$labs->no_lab}}</td>
            <td class="text-center">{{date('d-m-Y, H:i',strtotime($labs->created_at))}}</td>
            <td class="text-left">{!!$labs->lis ? '<a href="'.url('emr/cetak-lis/'.$labs->no_lab.'/'.$reg->id).'" target="_blank" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> CETAK</a>' : '<i><small>Belum ada hasil dari LIS</small></i>'!!}</td>
          </tr>
        @endforeach
      @endif
        </tbody>
      </table>
    </div>
  </div>
</div> --}}
  </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showExam" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">EXAM RIS</h4>
        </div>
        <div class="modal-body">
          <div id="dataExam"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
</style>

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
  </script>
    <script>
      $(document).ready(function() {
          obat()
          modality()
          var max_fields      = 25;
          var wrapper         = $(".daftar_obat_2"); 
          var add_button      = $(".add_field_button");
          var remove_button   = $(".remove_field_button");
          var dateToday = "{{date('d-m-Y')}}" 
          console.log(dateToday)
          var i = 2;
           // row 3
           $(".add_daftar_2").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $('.daftar_obat_2').append( '<tr>'+
                  '<td class="text-center">'+(i+1)+'</td>'+
                  '<td><select name="exam['+i+'][examlist]" id="" class="form-control examlist"></select><input type="hidden" value="'+dateToday+'" name="exam['+i+'][tgl]"></td>'+
                  '<td class="text-center"><input type="number" value="1" class="form-control" name="exam['+i+'][jumlah]"></td>'+
                  // '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                  '<td style="width:20px" class="text-center"><a href="#" class="remove_field_obat_2 btn btn-xs btn-danger">X</a></td>'+
                '</tr>');

                  $(wrapper).find(".datepicker").datepicker({autoclose: true,format: "dd-mm-yyyy"})
                  obat()
                  modality()
              }
          });
          $(".daftar_obat_2").on("click",".remove_field_obat_2", function(e){ //user click on remove text
              // console.log($(this));
              e.preventDefault(); $(this).closest("tr").remove(); i--;
            })

        // MASTER TINDAKAN
        function obat(){
            $('.examlist').select2({
              placeholder: "Klik untuk mencari tindakan",
              width: '100%',
              ajax: {
                  url: '/ris/get-tarif-ris/',
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
        }
        
        function modality(){
            $('.modality').select2({
              placeholder: "Klik untuk mencari modality",
              width: '100%',
              ajax: {
                  url: '/ris/get-modality',
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
        }
        
          
       // HISTORY EXAM
       $(document).on('click', '#exam', function (e) {
          var id = $(this).attr('data-reg');
          // alert(id)
          $('#showExam').modal('show');
          $('#dataExam').load("/ris/getexam/"+id);
        });  

      });
</script>
@endsection