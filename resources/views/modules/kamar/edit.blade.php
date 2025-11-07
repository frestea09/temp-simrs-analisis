@extends('master')

@section('header')
  <h1>Master Kamar Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Kamar &nbsp;

      </div>
      <div class="box-body">
        {!! Form::model($kamar, ['route' => ['kamar.update', $kamar->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('kamar::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
