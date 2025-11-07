@extends('master')
@section('header')
  <h1>Logistik Non Medik - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/laporan-po') }}" ><img src="{{ asset('menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Purchase Order</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/laporan-penerimaan') }}" ><img src="{{ asset('menu/warehouse.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Penerimaan barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Distribusi Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Permintaan Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Distribusi Barang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan kartu Stok</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Stok Gudang</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Semua Stok</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#laporan-penerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Pemakaian Barang</h5>
        </div>
    </div>
    <div>
  </div>
@endsection
