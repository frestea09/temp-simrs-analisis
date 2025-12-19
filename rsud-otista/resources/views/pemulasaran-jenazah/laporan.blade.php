@extends('master')
@section('header')
  <h1>PEMULASARAN JENAZAH - Laporan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
          <a href="{{ url('pemulasaran-jenazah/laporan-pengunjung') }}" ><img src="{{ asset('menu/fixed/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>Laporan</h5>
        </div>
      {{--  <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        <h5>Kunjungan Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Kunjungan Rawat darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/laporan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Kunjungan Rawat Inap</h5>
      </div>  --}}
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="#" ><img src="{{ asset('menu/fixed/laporankinerja.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/></a>
        <h5>Kinerja Pemulasaran Jenazah</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
