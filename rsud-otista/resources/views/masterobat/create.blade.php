@extends('master')
@section('header')
  <h1>Master Obat </h1>
@endsection

@section('content')
    
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Obat &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'masterobat.store', 'class' => 'form-horizontal']) !!}

          @include('masterobat._form')

        {!! Form::close() !!} 
      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Import Obat &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => url('/masterobat/import'), 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
          @include('masterobat._form_import')
        {!! Form::close() !!}
      </div>
    </div>
@stop
