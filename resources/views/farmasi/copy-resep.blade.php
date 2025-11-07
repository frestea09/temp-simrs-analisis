@extends('master')
@section('header')
  <h1>Farmasi - Copy Resep <small></small></h1>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">

        <div class="box-title">
            <h4> COPY RESEP </h4>
        </div>
        </div>
        <div class="box-body">
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
                <a href="{{ url('copy-resep/jalan') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
                </a>
                <h5>Rawat Jalan</h5>
            </div> --}}
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
                <a href="{{ url('copy-resep/irna') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
                </a>
                <h5>Rawat Inap</h5>
            </div> --}}
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
                <a href="{{ url('copy-resep/darurat') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
                </a>
                <h5>Rawat Darurat</h5>
            </div> --}}
            {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ url('copy-resep/penjualanbebas') }}" ><img src="{{ asset('menu/fixed/penjualanbebas.png') }}" width="50px" heigth="50px"  class="img-responsive" alt="" />
              </a>
              <h5>Penjualan Bebas</h5>
            </div> --}}
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ url('copy-resep/rujukan') }}" ><img src="{{ asset('menu/fixed/saranarujukan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt="" />
              </a>
              <h5>Rujukan</h5>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>


  @endsection
