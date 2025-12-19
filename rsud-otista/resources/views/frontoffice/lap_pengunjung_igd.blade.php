@extends('master')
@section('header')
<h1>Gawat Darurat - Laporan Pengunjung </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan-igd', 'class'=>'form-horizontal']) !!}
    <div class="row">
      {{--  <div class="col-md-3">
          <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
      <span class="input-group-btn">
        <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}" type="button">Klinik</button>
      </span>
      {!! Form::select('poli_id', $klinik, NULL, ['class' => 'chosen-select datepicker']) !!}
      <small class="text-danger">{{ $errors->first('politipe') }}</small>
    </div>
  </div> --}}
  <div class="col-md-3">
    <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Cara Bayar</label>
      <div class="col-md-8">
        <select name="cara_bayar" class="form-control select2">
          <option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
          @foreach ($carabayar as $c)
          <option value="{{ $c->id }}" {{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}
            @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
      <span class="input-group-btn">
        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
      </span>
      {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
      <small class="text-danger">{{ $errors->first('tga') }}</small>
    </div>
  </div>

  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">s/d Tanggal</button>
      </span>
      {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
    </div>
  </div>
  <div class="col-md-3">
    <div class="input-group">
      <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
      <input type="submit" name="pdf" class="btn btn-danger btn-flat" value="CETAK" formtarget="_blank">
    </div>
  </div>
</div>
{!! Form::close() !!}
<hr>
<h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $reg->count() }}</h4>
@include('frontoffice.ajax_lap_pengunjung')

</div>
<div class="box-footer">
</div>
</div>


@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
      $('.datepicker').datepicker();
      $('.select2').select2();
    });
</script>
@endsection