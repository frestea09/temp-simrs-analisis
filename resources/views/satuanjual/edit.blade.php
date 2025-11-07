@extends('master')
@section('header')
  <h1>Satuan Jual </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Data Satuan Jual &nbsp;
          <a href="{{ route('satuanjual.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($satuanjual, ['route' => ['satuanjual.update', $satuanjual->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('satuanjual._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
