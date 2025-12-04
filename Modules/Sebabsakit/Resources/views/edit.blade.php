@extends('master')
@section('header')
  <h1>Sebab Sakit</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Sebab Sakit &nbsp;

      </h3>
    </div>
    <div class="box-body">
        {!! Form::model($sebabsakit, ['route' => ['sebabsakit.update', $sebabsakit->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
          @include('sebabsakit::_form')
        {!! Form::close() !!}
    </div>
  </div>
@endsection
