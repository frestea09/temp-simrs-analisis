@extends('master')
@section('header')
  <h1>HRD - Diklat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/diklatteknis.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Diklat Teknis</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/diklatfungsional.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Diklat Fungsional</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
