@extends('master')
@section('header')
  <h1>Pendaftaran - Pasien Umum / Corporate</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Pasien &nbsp;

      </h3>
    </div>
    <div class="box-body">
      @if ($pasien)
        {!! Form::model($pasien, ['route' => ['registrasi_ranap.update', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'route' => 'registrasi_ranap.store', 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_form')
          <hr>
          @include('registrasi::_formumum')

      {!! Form::close() !!}
    </div>
  </div>
@endsection
