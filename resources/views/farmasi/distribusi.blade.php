@extends('master')
@section('header')
  <h1>Distribusi - Master <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/logistikmedik/permintaan') }}" ><img src="{{ asset('menu/sidebar/mappingrl.svg') }}" width="50px" heigth="50px"  class="img-responsive" alt="" style="50%"/>
        </a>
        <h5>Permintaan Barang</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('logistikmedik/transfer-permintaan') }}" ><img src="{{ asset('menu/sidebar/Delivery3.svg') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kirim Stok</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
