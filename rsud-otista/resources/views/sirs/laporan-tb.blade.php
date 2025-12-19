@extends('master')
@section('header')
  <h1>Laporan TB</h1>
@endsection

@section('content')
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Laporan Diagnosa</h3>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-tb-irj') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar</br>TB Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-tb-igd') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar</br>TB IGD</h5> 
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-tb-irna') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar<br>TB Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-db') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>10 Besar<br>Laporan DB</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-pengisian-emr-dokter') }}" ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengisian EMR Dokter</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-pengisian-emr-perawat') }}" ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Pengisian EMR Perawat</h5>
      </div>
   
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-restriksi-obat') }}" ><img src="{{ asset('menu/fixed/lappenjualan.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Restriksi Obat dan Kendali Biaya</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('sirs/rl/laporan-evaluasi-emr-dokter') }}" ><img src="{{ asset('menu/fixed/lappenjualan.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Evaluasi EMR Dokter</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rawatinap/sensus-masuk') }}" ><img src="{{ asset('menu/fixed/laporansensus.png') }}"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Sensus Masuk</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule">
        <a href="{{ url('rawatinap/sensus-keluar') }}" ><img src="{{ asset('menu/fixed/laporansensus.png') }}"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Laporan Sensus Keluar</h5>
      </div>
    </div>
  </div>
@endsection