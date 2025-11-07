@extends('master')
@section('header')
  <h1>Master - Penjabat <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('/logistikmedik/pejabat') }}" ><img src="{{ asset('menu/network.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Penjabat Pengadaan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('/logistikmedik/pejabat-pengecekan') }}" ><img src="{{ asset('menu/report-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Penjabat Pemeriksa</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('logistikmedik/pejabat-bendahara') }}" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Penjabat Bendahara</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
