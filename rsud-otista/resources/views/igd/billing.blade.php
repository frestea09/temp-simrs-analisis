@extends('master')
@section('header')
  <h1>Sistem Rawat Darurat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('tindakan/igd') }}" ><img src="{{ asset('menu/fixed/penatajasa.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Perawat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('kasir/uangmuka-rawatdarurat') }}"><img src="{{ asset('menu/fixed/deposito.png') }}" width="50px" heigth="50px"
            class="img-responsive" alt="" />
        </a>
        <h5>Deposit</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="transit" target="_blank"><img src="{{ asset('menu/fixed/transit.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Transit</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="/frontoffice/input_diagnosa_igd" target="_blank"><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>CODING</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
