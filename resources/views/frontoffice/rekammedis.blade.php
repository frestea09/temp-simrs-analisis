@extends('master')
@section('header')
  <h1>Casemix - Integrasi SIMRS - INCBGs E-Klaim </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- <div class="col-sm-3 col-xs-6 text-center">
        <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" ><img src="{{ asset('menu/report.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Input Diagnosa IRJ</h5>
      </div>
      --}}
      <div class="col-sm-3 col-xs-6 text-center iconModule bpjs">
        <a href="{{ url('frontoffice/e-claim/dataRawatJalan') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Bridging E-Klaim Rawat Jalan</h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule bpjs">
        <a href="{{ url('frontoffice/e-claim/dataRawatInap') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Bridging E-Klaim Rawat Inap</h5>
        <h5></h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule bpjs">
        <a href="{{ url('inacbg/lihat-eklaim-irj-igd') }}" ><img src="{{ asset('menu/fixed/eklaimrajal.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Lihat E-Klaim Rawat Jalan</h5>
        <h5></h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule bpjs">
        <a href="{{ url('inacbg/lihat-eklaim-irna') }}" ><img src="{{ asset('menu/fixed/eklaimranap.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Lihat E-Klaim Rawat Inap</h5>
        <h5></h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/fixed/kirimdc.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Kirim DC</h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" ><img src="{{ asset('menu/fixed/diagnosa.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Diagnosa IRJ</h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}" ><img src="{{ asset('menu/fixed/diagnosa.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Diagnosa IRNA</h5>
      </div>
      <div class="col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('masterpagu') }}" ><img src="{{ asset('menu/fixed/tarifrajal.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Master Pagu</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
