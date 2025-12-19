@extends('master')
@section('header')
  <h1>Operasi - Perawat <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="#" ><img src="{{ asset('menu/circfixed/.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rencana Operasi</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/lab-15.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Proses Operasi</h5>
      </div> --}}
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('operasi/antrian') }}" ><img src="{{ asset('menu/fixed/pembedahan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>EMR Operasi Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('operasi/odc') }}" ><img src="{{ asset('menu/fixed/onedaycare.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>EMR Operasi Rawat Jalan</h5>
      </div>
    </div>

  </div>
@endsection
