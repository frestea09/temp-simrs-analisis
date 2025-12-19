@extends('master')
@section('header')
  <h1>Logistik Non Medik - Distribusi <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/nonmedikpermintaan') }}" ><img src="{{ asset('menu/trucking.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Permintaan</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/nonmediktransfer') }}" ><img src="{{ asset('menu/packing-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Transfer Keluar</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('#') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Laporan Permintaan</h5>
        </div>
    </div>
    <div>
  </div>
@endsection
