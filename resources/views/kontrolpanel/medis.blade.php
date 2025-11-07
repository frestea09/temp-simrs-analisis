@extends('master')
@section('header')
  <h1>Control Panel - Medis <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('politype') }}" ><img src="{{ asset('menu/fixed/mastertipepoli.png') }}" width="50px" heigth="50px" class="img-responsive alt=""/>
          </a>
          <h5>Master Tipe Poli</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('poli') }}" ><img src="{{ asset('menu/fixed/masterpoli.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Master Poli</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('instalasi') }}" ><img src="{{ asset('menu/fixed/masterinstalasi.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Master Instalasi</h5>
        </div>

        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('kelas') }}" ><img src="{{ asset('menu/fixed/masterkelaskamar.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Master Kelas Kamar</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('/kelompokkelas') }}" ><img src="{{ asset('menu/fixed/kelompokkamar.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Kelompok Kamar</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('kamar') }}" ><img src="{{ asset('menu/fixed/masterkamar.png') }}" width="50px" heigth="50px"  circle l" alt="" style="50%"/>
          </a>
          <h5>Master Kamar</h5>
        </div>
      </div>



      <div class="row">
        
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('bed') }}" ><img src="{{ asset('menu/fixed/masterbed.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Master Bed</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
          <a href="{{ url('aplicare-bpjs') }}" ><img src="{{ asset('menu/fixed/masterbed.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Aplicares</h5>
        </div>
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('#') }}" ><img src="{{ asset('menu/technological.png') }}" width="50px" heigth="50px"  class="img-responsive alt=""/>
          </a>
          <h5>Display Tempat Tidur</h5>
        </div> --}}
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('icd9') }}" ><img src="{{ asset('menu/fixed/icd9.png') }}"  width="50px" heigth="50px" class="img-responsive alt=""/>
          </a>
          <h5>Master ICD 9 INACBG</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('icd10') }}" ><img src="{{ asset('menu/fixed/icd10.png') }}" width="50px" heigth="50px" class="img-responsive alt=""/>
          </a>
          <h5>Master ICD 10 INACBG</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('diagnosa-keperawatan') }}" ><img src="{{ asset('menu/fixed/kategoriheader.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master Diagnosa Keperawatan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('master-intervensi') }}" ><img src="{{ asset('menu/fixed/kategoriheader.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master Intervensi Keperawatan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('master-implementasi') }}" ><img src="{{ asset('menu/fixed/kategoriheader.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master Implementasi Keperawatan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('icd9-im') }}" ><img src="{{ asset('menu/fixed/icd9.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master ICD 9 IDRG</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('icd10-im') }}" ><img src="{{ asset('menu/fixed/icd10.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master ICD 10 IDRG</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ route('icdo-im') }}" ><img src="{{ asset('menu/fixed/icd10.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Master ICD O IDRG</h5>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
