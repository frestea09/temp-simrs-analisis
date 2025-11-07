@extends('master')
@section('header')
  <h1>Rehabilitasi - Billing System <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rehabmedik/tindakan-irj') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rehabmedik/tindakan-ird') }}" ><img src="{{ asset('menu/fixed/igd.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rehabmedik/tindakan-irna') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rehabmedik/transaksi-langsung') }}" ><img src="{{ asset('menu/fixed/transaksilangsung.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Transaksi Langsung</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
