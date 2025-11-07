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
            <div class="form-group">
              {!! Form::label('total', 'INACBGS VIP', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7 input-group">
                  <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                  {!! Form::number('inacbgs_vip', ($inacbgs != null) ? $inacbgs['inacbgs_vip'] : '', ['class' => 'form-control text-center']) !!}
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('total', 'INACBGS KLS 1', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7 input-group">
                  <div class="input-group-addon">Rp</div>
                  {!! Form::number('inacbgs_kls1', ($inacbgs != null) ? $inacbgs['inacbgs_kls1'] : '', ['class' => 'form-control text-center']) !!}
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('total', 'INACBGS KLS 2', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7 input-group">
                  <div class="input-group-addon">Rp</div>
                  {!! Form::number('inacbgs_kls2', ($inacbgs != null) ? $inacbgs['inacbgs_kls2'] : '', ['class' => 'form-control text-center']) !!}
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('total', 'INACBGS KLS 3', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7 input-group">
                  <div class="input-group-addon">Rp</div>
                  {!! Form::number('inacbgs_kls3', ($inacbgs != null) ? $inacbgs['inacbgs_kls3'] : '', ['class' => 'form-control text-center']) !!}
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
