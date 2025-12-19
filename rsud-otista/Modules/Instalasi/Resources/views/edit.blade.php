@extends('master')
@section('header')
  <h1>Master Instalasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Tambah Data Instalasi Rumah Sakit
      </h3>
    </div>
    <div class="box-body">
      {!! Form::model($instalasi, ['route' => ['instalasi.update', $instalasi->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

          @include('instalasi::_form')

      {!! Form::close() !!}
    </div>
  </div>
@endsection
