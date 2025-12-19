@extends('master')
@section('header')
  <h1>Logistik Non Medik - Penerimaan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/logistiknonmedikpo') }}" ><img src="{{ asset('menu/pegawai.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>PO</h5>
        </div>
        <div class="col-sm-3 text-center">
            <a href="{{ url('/logistiknonmedik/logistiknonmedikPenerimaan') }}" ><img src="{{ asset('menu/waktu.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
            </a>
            <h5>Penerimaan</h5>
        </div>
    </div>
    <div>
  </div>
@endsection
