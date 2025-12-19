@extends('master')
@section('header')
  <h1>Echocardiogram - Hasil Echocardiogram <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{--  <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('radiologi/template') }}" ><img src="{{ asset('menu/school-material2.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Template</h5>
      </div>  --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('echocardiogram/hasil-echocardiogram') }}" ><img src="{{ asset('menu/fixed/hasil.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Hasil</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
