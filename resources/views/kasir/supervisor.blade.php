@extends('master')
@section('header')
  <h1>Kasir/Supervisor <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/edit-transaksi') }}" ><img src="{{ asset('menu/edit.ico') }}" width="50px" heigth="50px" class="img-responsive imgt="" sty      </a>
        <h5>Edit Transaksi</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/batal-bayar') }}" ><img src="{{ asset('menu/fixed/batalbayar.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Batal Bayar</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/batal-piutang') }}" ><img src="{{ asset('menu/fixed/batalpiutang.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Batal Piutang</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
