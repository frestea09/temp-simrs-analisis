@extends('master')
@section('header')
  <h1>Satuan Jual </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Satuan Jual &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'satuanjual.store', 'class' => 'form-horizontal']) !!}

          @include('satuanjual._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
