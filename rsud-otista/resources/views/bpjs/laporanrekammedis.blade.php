@extends('master')
@section('header')
  <h1>Vedika BPJS Kesehatan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
        <a href="{{ url('/frontoffice/lap-rekammedis') }}" ><img src="{{ asset('menu/fixed/rekammedis.png') }}" width="75px" heigth="75px" class="img-responsive" alt=""/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
