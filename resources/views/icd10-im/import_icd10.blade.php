@extends('master')
@section('header')
  <h1>Import File ICD10 <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <br>
      <div class="row">
        <div class="col-md-8">
          {!! Form::open(['method' => 'POST', 'route' => 'icd10-im.proses-import', 'class' => 'form-horizontal','files'=>true]) !!}

            <div class="form-group">
                {!! Form::label('inputname', 'Type', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <select name="type" id="" class="form-control">
                    <option value="icdo">ICD O</option>
                    <option value="icd9">ICD 9</option>
                    <option value="icd10">ICD 10 IDRG</option>
                    <option value="icd10_inacbg">ICD 10 INACBG</option>
                    <option value="icd9_inacbg">ICD 9 INACBG</option>
                  </select>
                </div>
            </div>
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
