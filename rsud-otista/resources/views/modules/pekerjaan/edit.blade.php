@extends('master')
@section('header')
  <h1>Master Pekerjaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Ubah Pekerjaan &nbsp;
      </h3>
    </div>
    <div class="box-body">
        {!! Form::model($pekerjaan, ['route' => ['pekerjaan.update', $pekerjaan->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
          @include('pekerjaan::_form')
        {!! Form::close() !!}
    </div>
  </div>
@endsection
