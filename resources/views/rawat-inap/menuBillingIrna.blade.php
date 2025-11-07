@extends('master')
@section('header')
  <h1>Sistem Rawat Inap <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h4>Data Pasien Rawat Inap</h4> --}}
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rawat-inap/billing') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawat-inap/ambulance') }}"><img src="{{ asset('menu/ambulance.png') }}" width="50px"
            heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
        </a>
        <h5>Ambulance</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawat-inap/jenazah') }}"><img src="{{ asset('menu/pasien2.png') }}" width="50px" heigth="50px"
            class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
        </a>
        <h5>Pemulasaran Jenazah</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('kasir/uangmuka-rawatinap') }}"><img src="{{ asset('menu/dollar-symbol-1.png') }}" width="50px" heigth="50px"
            class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
        </a>
        <h5>Deposit</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawat-inap/billing-filter') }}" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        <h5>Cetak Ulang Billing</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('rawat-inap/edit-inacbgs') }}" ><img src="{{ asset('menu/rep.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Edit INACBGS</h5>
      </div> --}}
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#"><img src="{{ asset('menu/tempel.png') }}" width="50px"
            heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%" />
        </a>
        <h5>Jamkesda</h5>
      </div> --}}
    </div>
  </div>
@endsection
