@extends('master')
@section('header')
  <h1>Front Office/Rawat Jalan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/customer-service.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pendaftaran Umum</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/doctor-2.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Antrian Per Poli</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/jkn.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pendaftaran JKN</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/loupe.png') }}"width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Cek Posisi Pasien</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
