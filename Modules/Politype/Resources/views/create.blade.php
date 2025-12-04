@extends('master')

@section('header')
  <h1>Master Poli Type </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Politype &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'politype.store', 'class' => 'form-horizontal']) !!}

            @include('politype::_form')
            
        {!! Form::close() !!}
      </div>
    </div>
@stop
