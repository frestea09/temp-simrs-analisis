@extends('master')
@section('header')
  <h1>Admisi - SEP Susulan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-sm-3 col-xs-6">
        <a href="{{ url('admission/sep-susulan/rawat-inap') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>SEP Susulan Rawat Inap</h5>
      </div>
      <div class="col-sm-3 col-xs-6">
       <a href="{{ url('admission/sep-susulan/rawat-jalan') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>SEP Susulan Rawat Jalan</h5>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a href="{{ url('admission/sep-susulan/rawat-darurat') }}" ><img src="{{ asset('menu/akun.png') }}" width="50px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>SEP Susulan Rawat Darurat</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
