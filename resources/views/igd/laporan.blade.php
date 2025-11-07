@extends('master')
@section('header')
  <h1>IGD - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('igd/laporan-pengunjung') }}" ><img src="{{ asset('menu/fixed/laporanpengunjung.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengunjung</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/frontoffice/laporan/rekammedis-pasien') }}" ><img src="{{ asset('menu/fixed/rekammedis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/indikator-pelayanan-igd') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Indikator Pelayanan IGD</h5>
      </div>
     {{--  <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Rekam Medis</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Laporan Pengunjung dan Nomor Rekam Medis</h3>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/pengunjung-irj') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_rajal.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengunjung Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/pengunjung-igd') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengunjung IGD</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/registrasi-igd') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Registrasi IGD</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/pengunjung-irna') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengunjung Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/jaga-igd') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Jaga IGD</h5>
      </div>

      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('frontoffice/laporan/no-rm-terbit') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan No RM Terbit</h5>
      </div> --}}
    </div>
  </div>
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Laporan Kunjungan</h3>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/kunjungan') }}" ><img src="{{ asset('menu/fixed/laporan_kunjungan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kunjungan Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('igd/laporan-kunjungan') }}" ><img src="{{ asset('menu/fixed/laporan_kunjungan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kunjungan IGD</h5>
      </div>
     
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/laporan-kunjungan-irj') }}" ><img src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kunjungan</h5>
      </div>
    </div>
  </div>
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Laporan Diagnosa</h3>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/diagnosa-irj') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar</h5>
        <h5>Diagnosa Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/diagnosa-irna') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar</h5>
        <h5>Diagnosa Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/laporan/diagnosa-igd') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar</h5>
        <h5>Diagnosa Rawat Darurat</h5>
      </div>
    </div>
  </div>
@endsection
