@extends('master')
@section('header')
  <h1>Rekap Laporan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl31') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.1 Pelayanan Rawat Inap</h5>
        </div>      
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl33') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.3 Gigi Mulut</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl34') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.4 Kebidanan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl36') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.6 Pembedahan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl37') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.7 Radiologi</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl38') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.8 Laboratorium</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl39') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.9 Rehab Medik</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl310') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.10 Pelayanan Khusus</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl311') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.11 Kesehatan Jiwa</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl35') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.5 Perinatologi</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center">
          <a href="{{ url('mastermapping_confrl312') }}" ><img src="{{ asset('menu/kemenkes.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          <h5>RL 3.12 Keluarga Berencana</h5>
        </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
