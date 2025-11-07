@extends('master')
@section('header')
  <h1>Antrian - LCD <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" target="_blank"><img src="{{ asset('menu/epat.png') }}" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>LCD</h5>
      </div>
    </div>
    <div class="box-footer">
      <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-rotate-left"></i> Kembali</a>
    </div>
  </div>
@endsection
