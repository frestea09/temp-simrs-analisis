@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Lab Section &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'labsection.store', 'class' => 'form-horizontal']) !!}

          @include('laboratorium.labsection._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
