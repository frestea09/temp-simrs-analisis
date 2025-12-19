@extends('master')

@section('header')
  <h1>Konfigurasi Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Update Konfigurasi Rumah Sakit</h3>
      </div>
      <div class="box-body">
        {!! Form::model($config, ['route' => ['config.update', $config->id], 'files'=>true, 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('config::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
