@extends('master')
@section('header')
  <h1>Kontrol Panel - Pengguna <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/cetakRj') }}" ><img src="{{ asset('menu/fixed/printer1.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Cetak Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
       <a href="{{ url('kasir/cetakIGD') }}" ><img src="{{ asset('menu/fixed/printer2.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Cetak Gawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/cetakIRNA') }}" ><img src="{{ asset('menu/fixed/printer3.png') }}" width="50px" heigth="75px" class="img-responsive" alt=""/>
        </a>
        <h5>Cetak Rawat Inap</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
