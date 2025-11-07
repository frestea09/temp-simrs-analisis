@extends('master')
@section('header')
  <h1>Kontrol Panel - Pengguna <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('role') }}" ><img src="{{ asset('menu/fixed/hakakses.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Hak Akses</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
       <a href="{{ url('user') }}" ><img src="{{ asset('menu/fixed/pengguna.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Pengguna</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('histori-user') }}" ><img src="{{ asset('menu/fixed/historilogin.png') }}" width="50px" heigth="75px" class="img-responsive" alt=""/>
        </a>
        <h5>Histori Login User</h5>
      </div> --}}
    <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/pegawai') }}" ><img src="{{ asset('menu/fixed/datapegawai.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Data Pegawai</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
