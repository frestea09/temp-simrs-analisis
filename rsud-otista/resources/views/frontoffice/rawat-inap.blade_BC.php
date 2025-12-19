@extends('master')
@section('header')
  <h1>Front Office/Rawat Inap </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/bed.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pendaftaran Umum IKS</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/jkn.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Pendaftaran JKN</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="#" ><img src="{{ asset('menu/businessman-1.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Proses Inap</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
