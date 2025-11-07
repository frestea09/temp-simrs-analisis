@extends('master')
@section('header')
  <h1>Master Batch </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Batch &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'masterobat-batches.store', 'class' => 'form-horizontal']) !!}

          @include('masterbatch._form')

        {!! Form::close() !!}

      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Import Master Batch &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => url('/masterobat-batches/import'), 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
          @include('masterbatch._form_import')
        {!! Form::close() !!}
      </div>
    </div>
@stop
