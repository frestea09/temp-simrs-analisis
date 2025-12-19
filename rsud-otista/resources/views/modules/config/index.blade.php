@extends('master')

@section('header')
  <h1>Konfigurasi Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Konfigurasi Rumah Sakit</h3>
      </div>
      <div class="box-body">
        @if ($config < 1)
          <a href="{{ route('config.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Setting Konfigurasi </a>
        @endif
      </div>
    </div>
@stop
