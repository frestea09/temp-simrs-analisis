@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Lab Section &nbsp;
          <a href="{{ route('labsection.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($labsection, ['route' => ['labsection.update', $labsection->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('laboratorium.labsection._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
