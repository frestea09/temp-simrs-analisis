@extends('master')
@section('header')
  <h1>INACBGS </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Tambah INACBGS</h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/inacbgsSave', 'class' => 'form-horizontal']) !!}
          <input type="hidden" name="registrasi_id" value="{{ $reg_id }}">
          <div class="col-sm-6">
            <div class="form-group{{ $errors->has('inacbgs') ? ' has-error' : '' }}">
              {!! Form::label('total', 'Tarif INACBGS 1/2', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7">
                  {!! Form::number('inacbgs2', ($inacbgs != null) ? $inacbgs->inacbgs2 : 0, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('inacbgs2') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('inacbgs') ? ' has-error' : '' }}">
              {!! Form::label('total', 'Tarif INACBGS 2/3', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7">
                  {!! Form::number('inacbgs1', ($inacbgs != null) ? $inacbgs->inacbgs1 : 0, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('inacbgs1') }}</small>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group{{ $errors->has('inacbgs') ? ' has-error' : '' }}">
              <div class="col-sm-6">
                  <div class="form-group pull-right">
                      <a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">Batal</a>
                      {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
                  </div>
              </div>
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
@stop
