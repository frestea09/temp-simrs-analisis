@extends('master')
@section('header')
    <h1>Frontoffice - Laporan </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Pengunjung dan Nomor Rekam Medis</h3>
        </div>
        <div class="box-body">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/pengunjung-irj') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_rajal.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Pengunjung Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/pengunjung-igd') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Pengunjung IGD</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/pengunjung-irna') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Pengunjung Rawat Inap</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/pengunjung-tagihan-irj') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_rajal.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Tagihan Rajal</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/rujukan') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_igd.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Rujukan</h5>
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
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/kunjungan') }}"><img
                        src="{{ asset('menu/fixed/laporan_kunjungan.png') }}" width="50px" heigth="50px" width="50px"
                        heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kunjungan Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/response-time-irj') }}"><img
                        src="{{ asset('menu/fixed/laporanexpired.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Response Time Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('igd/laporan-kunjungan') }}"><img src="{{ asset('menu/fixed/laporan_kunjungan.png') }}"
                        width="50px" heigth="50px" width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kunjungan IGD</h5>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/laporan-kunjungan-irj') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kunjungan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/kunjungan-irna') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kunjungan Rawat Inap</h5>
            </div>
            
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Diagnosa</h3>
        </div>
        <div class="box-body">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/diagnosa-irj') }}"><img
                        src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>10 Besar</h5>
                <h5>Diagnosa Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/diagnosa-igd') }}"><img
                        src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>10 Besar</h5>
                <h5>Diagnosa IGD</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/diagnosa-irna') }}"><img
                        src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>10 Besar</h5>
                <h5>Diagnosa Rawat Inap</h5>
            </div>
        </div>
    </div>
    {{-- <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Penghancuran Berkas</h3>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('frontoffice/laporan/pasien-reg-lama') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Data Pasien Registrasi Lama</h5>
      </div>
    </div>
  </div> --}}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Distribusi</h3>
        </div>
        <div class="box-body">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/distribusi-ranap') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Distribusi Rawat Inap</h5>

            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/distribusi-rajal') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Distribusi Rawat Jalan</h5>

            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/distribusi-radar') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Distribusi Rawat Darurat</h5>

            </div>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan USG & EKG</h3>
        </div>
        <div class="box-body">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/usg') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>USG</h5>

            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/ekg') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>EKG</h5>

            </div>
        </div>
    </div>
@endsection
