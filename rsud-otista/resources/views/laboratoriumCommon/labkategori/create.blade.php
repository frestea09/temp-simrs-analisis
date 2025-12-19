@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Lab Kategori &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'labkategori.store', 'class' => 'form-horizontal']) !!}

          @include('laboratorium.labkategori._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
