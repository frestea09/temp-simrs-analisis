@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Data Pasien &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'pasien.store', 'class' => 'form-horizontal', 'files'=>true]) !!}

            @include('pasien::_form')
            <hr>
            @include('registrasi::_form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
