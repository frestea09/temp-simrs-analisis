@extends('master')

@section('header')
  <h1>Dokter</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Dokter &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'dokter.store', 'class' => 'form-horizontal']) !!}

            @include('dokter._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
