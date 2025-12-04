@extends('master')

@section('header')
  <h1>Perusahaan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Perusahaan &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($perusahaan, ['route' => ['perusahaan.update', $perusahaan->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

          @include('perusahaan::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
