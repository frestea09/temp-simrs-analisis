@extends('master')
@section('header')
  <h1>ANTRIAN FARMASI <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian-farmasi/layarlcd') }}" target="_blank"><img src="{{ asset('menu/fixed/lcdantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>LCD Antrian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian-farmasi/touch') }}" target="_blank"><img src="{{ asset('menu/fixed/touchantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Touch Nomor Antrian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian-farmasi/suara') }}" target="_blank"><img src="{{ asset('menu/fixed/suaraantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Suara Antrian</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
