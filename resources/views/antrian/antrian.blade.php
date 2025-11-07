@extends('master')
@section('header')
  <h1>Antrian <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian-new/antrian') }}" target="_blank"><img src="{{ asset('menu/fixed/lcdantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>LCD Antrian</h5>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian-new/antrian-atas') }}" target="_blank"><img src="{{ asset('menu/fixed/lcdantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>LCD Antrian Atas</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian') }}" target="_blank"><img src="{{ asset('menu/fixed/daftarnoantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Daftar Nomor Antrian</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('antrian/suara') }}" target="_blank"><img src="{{ asset('menu/fixed/suaraantrian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Suara Antrian</h5>
      </div>
    </div>

    <div class="box-footer">
    </div>
  </div>
@endsection
