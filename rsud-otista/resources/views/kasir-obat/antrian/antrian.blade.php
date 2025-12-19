@extends('master')
@section('header')
  <h1>Antrian <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('antrian/layarlcd') }}" target="_blank"><img src="{{ asset('menu/levels.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>LCD Antrian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('antrian') }}" target="_blank"><img src="{{ asset('menu/queue.png') }}" width="75px" heigth="75px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Daftar Nomor Antrian</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
