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
        {!! Form::model($labkategori, ['route' => ['labkategori.update', $labkategori->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('laboratorium.labkategori._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
