@extends('master')
@section('header')
  <h1>Kasir - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('kasir/tutup-kasir') }}" ><img src="{{ asset('menu/book.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Tutup Kasir</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/direksi/laporan-pendapatan') }}" ><img src="{{ asset('menu/fixed/laporanpendapatan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pendapatan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/direksi/laporan-penerimaan') }}" ><img src="{{ asset('menu/fixed/laporanpenerimaan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Penerimaan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/direksi/laporan-transaksi-keluar') }}" ><img src="{{ asset('menu/fixed/laporantransaksikeluar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Transaksi Keluar</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
