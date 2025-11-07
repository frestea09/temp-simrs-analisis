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
        {!! Form::model($kelas, ['route' => ['kelas.update', $kelas->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('kelas::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
