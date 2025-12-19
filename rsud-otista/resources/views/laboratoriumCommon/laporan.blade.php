@extends('master')
@section('header')
  <h1>Laboratorium - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/laboratoriumCommon/laporan-kunjungan') }}" ><img src="{{ asset('menu/fixed/laporankunjungan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kunjungan </h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('frontoffice/laporan/rekammedis-pasien') }}" ><img src="{{ asset('menu/fixed/rekammedis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('laboratoriumCommon/laporan-kinerja') }}" ><img src="{{ asset('menu/fixed/laporankinerja.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kinerja Laboratorium</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('laboratoriumCommon/laporan-kinerja-bank-darah') }}" ><img src="{{ asset('menu/fixed/laporankinerjabankdarah.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kinerja Bank Darah</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
