@extends('master')

@section('header')
  <h1>Master Poli Type </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Update Master Politype &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($politype, ['route' => ['politype.update', $politype->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('politype::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
