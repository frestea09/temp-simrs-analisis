@extends('master')
@section('header')
  <h1>Pendaftaran Rawat Jalan - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/frontoffice/lap-rekammedis') }}" ><img src="{{ asset('menu/fixed/rekammedis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/inacbg/laporan-eklaim') }}" ><img src="{{ asset('menu/fixed/laporaneklaim.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Bridging Eklaim</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('frontoffice/laporan/laporan-ranap') }}"><img src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" height="50px" class="img-responsive" alt="">
          </a>
          <h5>Laporan Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('frontoffice/laporan/registrasi-igd') }}"><img src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" height="50px" class="img-responsive" alt="">
          </a>
          <h5>Laporan IGD</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
