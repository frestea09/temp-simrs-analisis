@extends('master')
@section('header')
  <h1>Laboratorium - Hasil Lab <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('labsection') }}" ><img src="{{ asset('menu/fixed/masterlab.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Master Lab</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('labkategori') }}" ><img src="{{ asset('menu/fixed/laboratorium.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Kategori Lab</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('lab') }}" ><img src="{{ asset('menu/fixed/nilairujukan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Nilai Rujukan</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
