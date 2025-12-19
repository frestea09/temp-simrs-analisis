@extends('master')
@section('header')
  <h1>Farmasi - Reture Penjualan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('retur/rajal') }}" ><img src="{{ asset('menu/fixed/retur1.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('retur/ranap') }}" ><img src="{{ asset('menu/fixed/retur2.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('retur/bebas') }}" ><img src="{{ asset('menu/fixed/retur3.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Penjualan Bebas</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="#" ><img src="{{ asset('menu/ecologism.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Darurat</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
