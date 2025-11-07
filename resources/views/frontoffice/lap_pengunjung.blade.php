@extends('master')
@section('header')
  <h1>Front Office - Laporan Pengunjung</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/pengunjung', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}" type="button">Cara Bayar</button>
              </span>
              {!! Form::select('cara_bayar_id', $cara_bayar, NULL, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
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
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
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
  <script>
    $('.select2').select2()
  </script>
@endsection
