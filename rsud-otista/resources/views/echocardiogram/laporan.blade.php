@extends('master')
@section('header')
  <h1>Radiologi - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('/radiologi/laporan-kunjungan') }}" ><img src="{{ asset('menu/network.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Kunjungan </h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('frontoffice/laporan/rekammedis-pasien') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/laporan-kinerja') }}" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Kinerja</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
