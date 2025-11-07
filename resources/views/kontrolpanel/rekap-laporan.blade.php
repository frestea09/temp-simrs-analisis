@extends('master')
@section('header')
  <h1>Kontrol Panel - Rekap Laporan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        {{-- <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('rekap-laporan/rawat-darurat') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>RL 3.2</h5>
        </div> --}}
        <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('rekap-laporan/gigi-mulut') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>RL 3.3</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('rekap-laporan/pembedahan') }}" ><img src="{{ asset('menu/gedung.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>RL 3.6</h5>
        </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
