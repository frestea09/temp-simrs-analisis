@extends('master')
@section('header')
  <h1>AMBULANS - Perawat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/customer-service.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Jasa Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/customer-service.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Jasa Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/customer-service.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Jasa Rawat Inap</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
