@extends('master')
@section('header')
  <h1>Rawat Jalan - E-Medical Record <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/doctor.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>E-Medical Record</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
