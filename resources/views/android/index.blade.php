@extends('master')
@section('header')
<h1>Android - Pages<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body text-center">
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/type') }}"><img src="{{ asset('menu/fixed/tambahhalaman.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt="" />
            </a>
            <h5>Tambah Halaman Baru</h5>
        </div>
        @foreach( $data as $item )
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
            <a href="{{ url('/android/pages/'.$item->type_slug) }}"><img src="{{ asset('menu/loading.png') }}" width="50px" heigth="50px"
                    class="img-responsive" alt=""/>
            </a>
            <h5>{{ $item->type_nama }}</h5>
        </div>
        @endforeach
    </div>
    <div class="box-footer">
    </div>
</div>

@endsection