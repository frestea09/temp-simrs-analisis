@extends('master')

@section('header')
  <h1>Konfigurasi Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Setting Konfigurasi Rumah Sakit</h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'config.store', 'class' => 'form-horizontal', 'files'=>true]) !!}

            @include('config::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
