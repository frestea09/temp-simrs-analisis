@extends('master')
@section('header')
  <h1>Administrasi </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/administrasi/surat-masuk') }}" ><img src="{{ asset('menu/konfig.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Surat Masuk</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/administrasi/surat-keluar') }}" ><img src="{{ asset('menu/email.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Surat Keluar</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/administrasi/produk-hukum') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Produk Hukum</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/administrasi/lain') }}" ><img src="{{ asset('menu/giftbox.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Lain-Lain</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
