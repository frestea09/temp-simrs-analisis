@extends('master')
@section('header')
  <h1>Master Pekerjaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Tambah Pekerjaan &nbsp;

      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'route' => 'pekerjaan.store', 'class' => 'form-horizontal']) !!}

          @include('pekerjaan::_form')
        {!! Form::close() !!}
    </div>
  </div>
@endsection
