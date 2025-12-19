@extends('master')
@section('header')
  <h1>HRD - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/daftarkepangkatan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Daftar Urutan Laporan Kepangkatan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Daftar Pejabat Aktif</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/daftarpns.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Daftar PNS Fungsional Tertentu</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/rekappensiun.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Rekap Pegawai Pensiun</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
