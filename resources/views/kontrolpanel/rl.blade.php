@extends('master')
@section('header')
  <h1>Kontrol Panel - RL <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6">
                <a href="{{ url('politype') }}" ><img src="{{ asset('menu/tipe.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
                </a>
                <h5>Master Mapping</h5>
            </div>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
