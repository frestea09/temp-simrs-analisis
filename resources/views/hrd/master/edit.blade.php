@extends('master')
@section('header')
  <h1>Master Pendidikan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Ubah Pendidikan &nbsp;
      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'hrd/master/pendidikan/'.$data['pendidikan']->id, 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
        @include('hrd.master._form')
        {!! Form::close() !!}
    </div>
  </div>
@endsection
