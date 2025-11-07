@extends('master')
@section('header')
  <h1>Import File Tindakan LIS <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <br>
      <div class="row">
        <div class="col-md-8">
          {!! Form::open(['method' => 'POST', 'route' => 'import-lis', 'class' => 'form-horizontal','files'=>true]) !!}
            {{-- <div class="form-group">
                {!! Form::label('inputname', 'Download Template', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <a href="{{ route('template-province') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cloud-download"></i> DOWNLOAD </a>
                </div>
            </div> --}}
            <div class="form-group{{ $errors->has('excel') ? ' has-error' : '' }}">
                {!! Form::label('excel', 'File Excel', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::file('excel', ['class' => 'form-control']) !!}
                        <p class="help-block">File Excel: xls, xlsx</p>
                        <small class="text-danger">{{ $errors->first('excel') }}</small>
                    </div>
            </div>
            <div class="btn-group pull-right">
                <a href="{{ URL::previous() }}" class="btn btn-warning btn-flat">Batal</a>
                {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
            </div>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
