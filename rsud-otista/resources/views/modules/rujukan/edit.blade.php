@extends('master')
@section('header')
  <h1>Rujukan</h1>
@endsection
@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Rujukan &nbsp;

      </h3>
    </div>
    <div class="box-body">
      {!! Form::model($rujukan, ['route' => ['rujukan.update', $rujukan->id],'class'=>'form-horizontal', 'method' => 'PUT']) !!}

        @include('rujukan::_form')
      {!! Form::close() !!}
    </div>
  </div>
@stop
