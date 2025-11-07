@extends('master')
@section('header')
  <h1>PEMULASARAN JENAZAH - Perawat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{--  <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('pemulasaran-jenazah/tindakan-rajal') }}" ><img src="{{ asset('menu/customer-service.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Rawat Jalan</h5>
      </div>  --}}
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('pemulasaran-jenazah/tindakan-ranap') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('pemulasaran-jenazah/tindakan-darurat') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('pemulasaran-jenazah/pasien-langsung') }}" ><img src="{{ asset('menu/fixed/pasienlangsung.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Pasien Langsung</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
