@extends('master')
@section('header')
  <h1>Tamabah Aturan Pakai Obat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'farmasi/etiket/store', 'class' => 'form-horizontal']) !!}

          <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
              {!! Form::label('nama', 'Nama Aturan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('nama') }}</small>
              </div>
          </div>

          <div class="btn-group pull-right">
              {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
          </div>
      {!! Form::close() !!}

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
