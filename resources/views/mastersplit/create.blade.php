@extends('master')
@section('header')
  <h1>Daftar Master </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Split &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'mastersplit.store', 'class' => 'form-horizontal']) !!}

            @include('mastersplit._form')
            
        {!! Form::close() !!}
      </div>
    </div>
@stop
