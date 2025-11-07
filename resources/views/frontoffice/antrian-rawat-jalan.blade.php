@extends('master')
@section('header')
  <h1>Pendaftaran Rawat Jalan - Antrian Rawat Jalan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('antrian/daftarantrian') }}" ><img src="{{ asset('menu/1.png') }}" width="75px" heigth="75px" class="img-responsive img-circle" alt=""/>
        </a>
        <h5>Loket 1</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/2.png') }}" width="75px" heigth="75px" class="img-responsive img-circle" alt="" style="50%"/>
        </a>
        <h5>Loket 2</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/3.png') }}" width="75px" heigth="75px" class="img-responsive img-circle" alt="" style="50%"/>
        </a>
        <h5>Loket 3</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('#') }}" ><img src="{{ asset('menu/4.png') }}" width="75px" heigth="75px" class="img-responsive img-circle" alt="" style="50%"/>
        </a>
        <h5>Loket 4</h5>
      </div>
      <div class="box-body">
        <div class="col-md-2 col-sm-3 col-xs-6">
          <a href="{{ url('daftar-perjanjian') }}" ><img src="{{ asset('menu/queue.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
          </a>
          <h5>Antrian Per Poli</h5>
        </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
