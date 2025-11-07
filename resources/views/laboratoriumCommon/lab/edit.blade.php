@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Edit Laboratorium &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($lab, ['route' => ['lab.update', $lab->id], 'method' => 'PUT','class' =>'form-horizontal']) !!}

            @include('laboratorium.lab._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
