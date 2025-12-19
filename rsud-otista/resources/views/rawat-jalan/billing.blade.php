@extends('master')
@section('header')
  <h1>Sistem Rawat Jalan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('tindakan') }}" ><img src="{{ asset('menu/fixed/penatajasa.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Perawat</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/dollar-symbol-2.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Entry Pemeriksaan</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
