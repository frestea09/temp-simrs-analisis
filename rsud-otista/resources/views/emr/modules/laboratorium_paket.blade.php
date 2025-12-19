@extends('master')
@section('header')
  <h1>{{baca_unit($unit)}} - Laboratorium<small></small></h1>
@endsection
@section('content')
@include('emr.modules.addons.profile')
@php
  $route = Route::current()->getName();
@endphp
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
    <h3 class="box-title">Input Hasil Lab</h3>
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
    <br/>
    @php

      $poli = request()->get('poli');
      $dpjp = request()->get('dpjp');
    @endphp
      {{-- @if (! session('pj')) --}}
    {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab/store-lis', 'class' => 'form-horizontal']) !!}
      <div class="col-md-6">
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('poli_id', $poli) !!}
        {!! Form::hidden('ruangan_inap', $ruangan_inap) !!}
        {!! Form::hidden('kelompok', $kelompok) !!}
        {!! Form::hidden('cara_bayar_id', $reg->bayar) !!}
        {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
        {!! Form::hidden('reg_id', $reg->id) !!}
        <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
            {!! Form::label('penanggungjawab', 'Dokter Pengirim', ['class' => 'col-sm-4 control-label']) !!}
            {{-- session('pj') --}}
            <div class="col-sm-8">
                {!! Form::select('penanggungjawab', $dokter, $reg->dokter_id, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jam', 'Jam Pengambilan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
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
      </div>

    {{-- @endif --}}
    <div id="exTab1" class="container">	
      <br/>
    <ul  class="nav nav-pills">
          <li class="{{$route == 'lab' ? 'active' :''}}">
            <a href="{{url('emr/lab/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Satuan</a>
          </li>
          <li class="{{$route == 'lab-paket' ? 'active' :''}}">
            <a href="{{url('emr/lab-paket/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Paket</a>
          </li>
        </ul> 
      </div>
    
    
    <hr></hr>
      <div class="col-md-12">
        {{-- <ul class="nav nav-tabs">
          <li><a href="#">Satuan</a></li>
          <li><a href="#">Paket</a></li>
        </ul> --}}
        {{-- <div class="box-group" id="accordion">
          
        </div> --}}
        
        <h4 class="text-center">Input Test Paket</h4>
        <table class="table table-striped table-bordered table-hover table-condensed dataTable no-footer" id="tableLabPaket">
          {{-- <tr><th colspan="6">{{ $lab_kat->nama }}</th></tr> --}}
          <thead>
            <tr>
              <th width="40px" class="text-center">No</th>
              <th class="text-center">Pilih</th>
              <th class="text-center">Cito</th>
              <th class="text-center">Nama (General Code)</th>
              {{-- <th class="text-center">Hasil Text</th> --}}
              {{-- <th class="text-center">Standart</th> --}}
              {{-- <th class="text-center">Satuan</th> --}}
            </tr>
          </thead>
          @php $no = 1; @endphp
          <tbody>

            @foreach ($labsection as $lab)
            <tr>
              <td class="text-center">{{ $no++ }}</td>
              <td width="5%" class="text-center">
                {{-- <span style="position:absolute;color:#8080803b">Pilih</span> --}}
                <input type="checkbox" name="hasil[{{ $lab->id }}_{{ $lab->name }}_{{ $lab->general_code}}]" id="">
              </td>
              <td width="5%" class="text-center">
                {{-- <input type="number" value="Ya" class="form-control" style="text-align:center;padding:0px;height:25px" name="cito[{{ $lab->id }}]" id=""> --}}
                <input type="hidden" name="cito[{{ $lab->id }}]" value="0">
                <input type="checkbox" name="cito[{{ $lab->id }}]" id="" value="1">
              </td>
              <td>{{ $lab->name }} ({{$lab->general_code}})</td>
              {{-- <td>
                <input name="hasiltext[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" class="form-control" />
              </td>
              <td width="100px" class="text-center">{{ $lab->nilairujukanbawah }} - {{ $lab->nilairujukanatas}}</td>
              <td width="150px" class="text-center">{{ $lab->satuan }}</td> --}}
            </tr>
            @endforeach
          </tbody>
      </table>
        
          {{-- <div class="col-md-6">
            <div class="form-group{{ $errors->has('pesan') ? ' has-error' : '' }}">
              {!! Form::label('pesan', 'Pesan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::textarea('pesan', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('pesan') }}</small>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group{{ $errors->has('kesan') ? ' has-error' : '' }}">
              {!! Form::label('kesan', 'Kesan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::textarea('kesan', null,['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('kesan') }}</small>
              </div>
            </div>
          </div> --}}
          
        
        <button style="margin-top: 10px;" class="btn btn-success btn-flat pull-right btnSave" id="btnSave" type="submit">Simpan</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

<div class="box box-primary">
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
            {{-- <td class="text-left">{!!$labs->lis ? '<a href="'.url('emr/cetak-lis/'.$labs->no_lab.'/'.$reg->id).'" target="_blank" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> CETAK</a>' : '<i><small>Belum ada hasil dari LIS</small></i>'!!}</td> --}}
            <td class="text-left"><a href="{{url('cetak-lis-pdf/'.$labs->no_lab.'/'.$reg->id)}}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> CETAK</a></td>
          </tr>
        @endforeach
      @endif
      {{-- @if(count($hasillabs) > 0) --}}
        {{-- @php $no = 1; @endphp --}}
        {{-- @foreach($hasillabs as $key=>$labs) --}}

          {{-- <tr>
            <td class="text-center">1</td>
            <td>LAB23032900138</td>
            <td class="text-center">{{date('d-m-Y, H:i')}}</td>
            <td class="text-left"><a href="{{url('/cetak-lis-pdf/LAB23032900138/'.$reg->id)}}" target="_blank" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> CETAK</a></td>
          </tr> --}}
        {{-- @endforeach --}}
      {{-- @endif --}}
        </tbody>
      </table>
    </div>
    {{-- @if(count($hasillabs) > 0)
      <a href="{{ url('pemeriksaanlab/cetakAll/'.$reg->id) }}" target="_blank" class="btn btn-warning btn-flat pull-right">CETAK</a>
    @endif --}}
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
      $('form').submit(function() {
          $(this).find('#btnSave').prop('disabled',true);
      });
      $(document).ready(function() {
          
        var max_fields      = 25;
          var wrapper         = $(".input_fields_wrap"); 
          var add_button      = $(".add_field_button");
          var remove_button   = $(".remove_field_button");
          var i = 2;


           // row 3
           $(".add_daftar_2").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $('.daftar_obat_2').append( '<tr>'+
                  '<td class="text-center">'+(i+1)+'</td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][dosis]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][frekuensi]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                  '<td class="text-left"><input type="text" class="form-control input-cito" name="admisi[transfer]['+i+'][cara]"> <a href="#" class="remove_field_obat_2 btn btn-xs btn-danger">X</a></td>'+
                '</tr>');
                  // $(wrapper).find(".datepicker").datepicker({autoclose: true,format: "dd-mm-yyyy"})
              }
          });
          $(".daftar_obat_2").on("click",".remove_field_obat_2", function(e){ //user click on remove text
              console.log($(this));
              e.preventDefault(); $(this).closest("tr").remove(); i--;
            })

      });
</script>
<script>
  $('#tableLabPaket').dataTable({
    "bPaginate": false
  });
</script>
@endsection