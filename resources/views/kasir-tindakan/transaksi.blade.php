@extends('master')
@section('header')
  <h1>Kasir - Transaksi <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir-obat/rawatjalan') }}" ><img src="{{ asset('menu/fixed/kasir1.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan - Obat</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir-tindakan/rawatjalan') }}" ><img src="{{ asset('menu/fixed/kasir1.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan - Tindakan</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/rawatinap') }}" ><img src="{{ asset('menu/fixed/kasir2.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/igd') }}" ><img src="{{ asset('menu/fixed/kasir3.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/data-piutang/') }}" ><img src="{{ asset('menu/fixed/piutang.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Piutang</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/uangmuka-rawatinap') }}" ><img src="{{ asset('menu/fixed/uangmuka.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Uang Muka Rawat Inap</h5>
      </div>

      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/tutup-kasir') }}" ><img src="{{ asset('menu/fixed/tutuptransaksi.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Tutup Transaksi Kasir</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/lain-lain') }}" ><img src="{{ asset('menu/fixed/lainlain.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Lain-lain</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/diklat') }}"><img src="{{ asset('menu/fixed/pendapatanlainlain.png') }}" width="50px" heigth="50px"
            class="img-responsive" alt="" />
        </a>
        <h5>Pendapatan Lain Lain</h5>
      </div>
      <div class="col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/transaksi-keluar/') }}" ><img src="{{ asset('menu/fixed/transaksikeluar.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Transaksi Keluar</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
