@extends('master')
@section('header')
    <h1>Rawat Jalan - Laporan <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/antrian') }}"><img src="{{ asset('menu/report.png') }}" width="50px"
                        heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
                </a>
                <h5>Laporan Antrian</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/pengunjung-irj') }}"><img
                        src="{{ asset('menu/fixed/laporanpengunjung.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Pengunjung</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/kunjungan') }}"><img
                        src="{{ asset('menu/fixed/laporankunjungan.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kunjungan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/rekammedis-pasien') }}"><img
                        src="{{ asset('menu/fixed/rekammedis.png') }}" width="50px" heigth="50px" class="img-responsive"
                        alt="" />
                </a>
                <h5>Rekam Medis Pasien</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/laporan-resume-pasien') }}"><img
                        src="{{ asset('menu/fixed/laporanresume.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Resume Medis</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/laporan-harian') }}"><img src="{{ asset('menu/report.png') }}" width="50px"
                        heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
                </a>
                <h5>Laporan Harian</h5>
            </div>
            
        </div>
    </div>
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/response-time-irj') }}"><img
                        src="{{ asset('menu/fixed/laporanexpired.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Response Time</h5>
            </div>
            
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('/frontoffice/rekap-pengunjung') }}"><img
                        src="{{ asset('menu/fixed/laporanexpired.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Rekap Pengunjung</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('/frontoffice/log-user') }}"><img
                        src="{{ asset('menu/fixed/laporanexpired.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Log User</h5>
            </div>
            
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('/frontoffice/time') }}"><img
                        src="{{ asset('menu/fixed/laporanexpired.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Response Time</h5>
            </div>
            
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/perawat') }}"><img
                        src="{{ asset('menu/fixed/laporanpengunjung.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Perawat</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/lap-penunjang') }}"><img
                        src="{{ asset('menu/fixed/laporanpengunjung.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penunjang</h5>
            </div>

        </div>
        <div class="box-footer">
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
                <h5>Laporan Kunjungan Irna</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/rujukan') }}"><img
                        src="{{ asset('menu/fixed/laporankunjungan.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Rujukan</h5>
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
                <a href="{{ url('frontoffice/laporan/diagnosa-irna') }}"><img
                        src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>10 Besar</h5>
                <h5>Diagnosa Rawat Inap</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/diagnosa-igd') }}"><img
                        src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>10 Besar</h5>
                <h5>Diagnosa Rawat Darurat</h5>
            </div>
        </div>
    </div>
@endsection
