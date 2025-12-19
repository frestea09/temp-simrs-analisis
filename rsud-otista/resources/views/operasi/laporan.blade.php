@extends('master')
@section('header')
  <h1>Operasi - Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('operasi/laporan/laporan-operasi') }}" ><img src="{{ asset('menu/fixed/laporanoperasi.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Operasi</h5>
      </div>
      {{--  <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Rekam Medis</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan TMO</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="#" ><img src="{{ asset('menu/school-material-1.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Laporan Anestesi</h5>
      </div>  --}}
    </div>
  </div>
@endsection
