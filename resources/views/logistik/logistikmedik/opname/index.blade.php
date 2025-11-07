@extends('master')
@section('header')
  <h1>Logistik Medik - Opname<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('logistikmedik/stok-opname') }}" ><img src="{{ asset('menu/fixed/stokopname.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/></a>
        <h5>Stok Opname</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan-opname') }}" ><img src="{{ asset('menu/fixed/laporanstokopname.png') }}" width="50px" heigth="50px"   class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Stok Opname</h5>
      </div>
    </div>
  </div>
@endsection
