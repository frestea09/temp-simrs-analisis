@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Bed &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'bed.store', 'class' => 'form-horizontal']) !!}

          @include('bed::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
