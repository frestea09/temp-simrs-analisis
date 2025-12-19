@extends('master')
@section('header')
<h1>Android - Konfigurasi<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body text-center">
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/manajemen') }}"><img src="{{ asset('menu/fixed/kepangkatan.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt="" />
            </a>
            <h5>Manajemen</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/jabatan') }}"><img src="{{ asset('menu/fixed/jabatan.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt="" />
            </a>
            <h5>Jabatan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/direksi') }}"><img src="{{ asset('menu/fixed/masterpejabat.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt="" />
            </a>
            <h5>Direksi</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/slider') }}"><img src="{{ asset('menu/fixed/slider.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt="" />
            </a>
            <h5>Slider</h5>
        </div>
    </div>
    <div class="box-footer">
    </div>
</div>

@endsection