@extends('master')
@section('header')
  <h1>Pegawai </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/biodata') }}" ><img src="{{ asset('menu/fixed/biodata.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Biodata Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/keluarga') }}" ><img src="{{ asset('menu/fixed/keluargapegawai.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Keluarga Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/pendidikan') }}" ><img src="{{ asset('menu/fixed/pendidikan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Pendidikan Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/kepangkatan') }}" ><img src="{{ asset('menu/fixed/kepangkatan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Kepangkatan Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/jabatan') }}" ><img src="{{ asset('menu/fixed/jabatan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Jabatan Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/gaji') }}" ><img src="{{ asset('menu/fixed/gajiberkala.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Gaji Berkala Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/penghargaan') }}" ><img src="{{ asset('menu/fixed/penghargaan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Penghargaan Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/gapok') }}" ><img src="{{ asset('menu/fixed/gajipokok.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Gaji Pokok Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/cuti') }}" ><img src="{{ asset('menu/fixed/cuti.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Cuti Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/ijin') }}" ><img src="{{ asset('menu/fixed/ijinbelajar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Ijin Belajar Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/disiplin') }}" ><img src="{{ asset('menu/fixed/disiplin.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Disiplin Pegawai</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('/hrd/mutasi') }}" ><img src="{{ asset('menu/fixed/mutasi.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Mutasi Pegawai</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/penugasan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Penugasan Pegawai</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
