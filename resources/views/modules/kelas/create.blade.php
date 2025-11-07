@extends('master')

@section('header')
  <h1>Master Kelas Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Kelas &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'kelas.store', 'class' => 'form-horizontal']) !!}

            @include('kelas::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
