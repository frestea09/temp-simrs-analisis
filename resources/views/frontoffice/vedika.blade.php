@extends('master')
@section('header')
  <h1>Kontrol Panel - Konfigurasi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('frontoffice/laporan/rekammedis-pasien/irj-igd') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Vedika Rawat Jalan/IGD</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/frontoffice/laporan/rekammedis-pasien/irna') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"   class="img-responsive" alt=""/>
        </a>
        <h5>Vedika Rawat Inap</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
