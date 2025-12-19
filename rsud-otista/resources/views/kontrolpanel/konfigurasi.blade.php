@extends('master')
@section('header')
  <h1>Kontrol Panel - Konfigurasi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('config') }}" ><img src="{{ asset('menu/fixed/konfigurasi.png') }}" width="50px" class="img-responsive" alt="" />
        </a>
        <h5>Konfigurasi Setting</h5>
      </div>

      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/konfig.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle" alt="" />
        </a>
        <h5>Konfigurasi Antrian</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('/fasilitas') }}" ><img src="{{ asset('menu/fixed/fasilitas.png') }}" width="50px" heigth="50px" class="img-responsive" alt="" />
        </a>
        <h5>Fasilitas</h5>
      </div>
      @if (Auth::user()->id == 566)
        <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('/consid') }}" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px"   class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>Taskid</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('/satu_sehat') }}" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px"   class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>Satu Sehat</h5>
        </div>
      @endif
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('jam_laporan') }}" ><img src="{{ asset('menu/fixed/konfigurasi.png') }}" width="50px" class="img-responsive" alt="" />
        </a>
        <h5>Jam Laporan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('lock_apm') }}" ><img src="{{ asset('menu/fixed/konfigurasi.png') }}" width="50px" class="img-responsive" alt="" />
        </a>
        <h5>Kunci APM</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
