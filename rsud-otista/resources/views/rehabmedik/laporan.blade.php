@extends('master')
@section('header')
  <h1>REHAB MEDIK - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{--  <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rehabmedik/laporan/kunjungan/rajal') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Kunjungan Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rehabmedik/laporan/kunjungan/ranap') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/></a>
        <h5>Kunjungan Rawat Inap</h5>
      </div>  --}}
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('rehabmedik/laporan') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" style="50%"/></a>
          <h5>Laporan Rehabilitasi Medik</h5>
        </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/></a>
        <h5>Kinerja Rehabilitasi Medik</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  {{--<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('/radiologi/laporan-kunjungan') }}" ><img src="{{ asset('menu/network.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Kunjungan </h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('frontoffice/laporan/rekammedis-pasien') }}" ><img src="{{ asset('menu/report-1.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Rekam Medis</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div> --}}
@endsection
