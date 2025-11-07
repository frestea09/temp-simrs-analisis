@extends('master')
@section('header')
  <h1>Echocardiogram - Perawat <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('echocardiogram/tindakan-irj') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('echocardiogram/tindakan-ird') }}" ><img src="{{ asset('menu/fixed/igd.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('echocardiogram/tindakan-irna') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('echocardiogram/pasien-sudah-pulang') }}" ><img src="{{ asset('menu/waktu.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pasien Sudah Pulang</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('echocardiogram/pencarian-pasien') }}" ><img src="{{ asset('menu/worker.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pencarian Pasien</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('echocardiogram/transaksi-langsung') }}" ><img src="{{ asset('menu/rep.png') }}"  width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pasien Langsung</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
