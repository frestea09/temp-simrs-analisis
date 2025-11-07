@extends('master')
@section('header')
    <h1>Farmasi - Laporan <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('logistikmedik/stok-opname') }}" ><img src="{{ asset('menu/fixed/stokopname.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/></a>
        <h5>Stok Opname</h5>
      </div> --}}
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('logistikmedik/laporan-opname') }}"><img src="{{ asset('menu/fixed/laporanstokopname.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Stok Opname</h5>
            </div>
            @role(['laporanapotik'])
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('/logistikmedik/persediaan-stok') }}"><img src="{{ asset('menu/sidebar/Stock.svg') }}"
                            width="50px" heigth="50px" class="img-responsive" alt="" /></a>
                    <h5>Laporan Persediaan</h5>
                </div>
            @endrole
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('penjualan/laporan') }}"><img src="{{ asset('menu/fixed/lappenjualan.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penjualan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan-kinerja') }}"><img src="{{ asset('menu/fixed/laporankinerja.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Kinerja</h5>
            </div>

            {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('farmasi/laporan-kronis') }}" ><img src="{{ asset('menu/fixed/laporankronis.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Kronis</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('farmasi/laporan-non-kronis') }}" ><img src="{{ asset('menu/fixed/laporannonkronis.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Laporan Non Kronis</h5>
      </div> --}}
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan-expired-date') }}"><img src="{{ asset('menu/fixed/laporanexpired.png') }}"
                        width="50px" heigth="50px" class="img-responsive" alt="" /></a>
                <h5>Laporan Expired Date</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat') }}"><img
                        src="{{ asset('menu/fixed/laporanpemakaianobat.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Obat</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat-harian-narkotika') }}"><img
                        src="{{ asset('menu/fixed/obatnarkotik.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Obat Narkotika</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat-harian-highalert') }}"><img
                        src="{{ asset('menu/fixed/obathighalert.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Obat High Alert</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat-harian') }}"><img
                        src="{{ asset('menu/fixed/laporanpemakaianobat.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Harian</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('logistikmedik/kartustok') }}"><img
                        src="{{ asset('menu/fixed/laporanpemakaianobat.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Kartu Stok</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('frontoffice/laporan/laporan-retur-obat') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Retur Obat</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/laporan-penggunaan-obat-irna') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penggunaan obat Rawat Inap</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat-harian-generik') }}"><img
                        src="{{ asset('menu/fixed/obatgenerik.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Obat Generik</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/pemakaian-obat-harian-psikotropika') }}"><img
                        src="{{ asset('menu/fixed/obatbebas.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" /></a>
                <h5>Laporan Pemakaian Obat Psikotropika</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/laporan-penggunaan-obat-irj') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penggunaan Obat Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan/laporan-penggunaan-obat-radar') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penggunaan Obat Gawat Darurat</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('penjualan/laporan-penjualan-user') }}"><img
                        src="{{ asset('menu/fixed/laporan_pengunjung_ranap.png') }}" width="50px" heigth="50px"
                        width="50px" heigth="50px" class="img-responsive" alt="" />
                </a>
                <h5>Laporan Penjualan User</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                <a href="{{ url('farmasi/laporan-kronis') }}"><img
                        src="{{ asset('menu/fixed/laporanpemakaianobat.png') }}" width="50px" heigth="50px"
                        class="img-responsive" alt="" />
                </a>
                <h5>Laporan Obat Kronis</h5>
            </div>
            <div class="col-md-12">
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('/logistikmedik/kartustok/batch') }}"><img src="{{ asset('menu/sidebar/Stock.svg') }}"
                            width="50px" heigth="50px" class="img-responsive" alt="" /></a>
                    <h5>Kartu Stok Batch</h5>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('farmasi/laporan-resep') }}"><img src="{{ asset('menu/fixed/laporankinerja.png') }}"
                            width="50px" heigth="50px" class="img-responsive" alt="" />
                    </a>
                    <h5>Laporan Lembar Resep</h5>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('farmasi/laporan-response-time') }}"><img src="{{ asset('menu/fixed/laporanexpired.png') }}"
                            width="50px" heigth="50px" class="img-responsive" alt="" />
                    </a>
                    <h5>Laporan Response Time</h5>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('farmasi/laporan-eresep') }}"><img src="{{ asset('menu/fixed/laporanpemakaianobat.png') }}"
                            width="50px" heigth="50px" class="img-responsive" alt="" />
                    </a>
                    <h5>Laporan E-Resep</h5>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 iconModule text-center">
                    <a href="{{ url('farmasi/laporan/pemakaian-obat-harian-antibiotik') }}"><img
                            src="{{ asset('menu/fixed/obatbebas.png') }}" width="50px" heigth="50px"
                            class="img-responsive" alt="" /></a>
                    <h5>Laporan Pemakaian Obat Antibiotik</h5>
                </div>
            </div>

            {{-- </div> --}}
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('logistikmedik/stok-opname') }}" ><img src="{{ asset('menu/fixed/stokopname.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/></a>
        <h5>Stok Opname</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('logistikmedik/laporan-opname') }}" ><img src="{{ asset('menu/fixed/laporanstokopname.png') }}" width="50px" heigth="50px"   class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Stok Opname</h5>
      </div> --}}
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
