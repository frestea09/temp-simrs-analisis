@extends('master')

@section('header')
  <h1>Kofigurasi - Tahun Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya Registrasi &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($dokter, ['route' => ['dokter.update', $dokter->id], 'method' => 'PUT','class'=>'form-horizontal']) !!}

          @include('dokter._form')

      {!! Form::close() !!}
      </div>
    </div>
@stop
