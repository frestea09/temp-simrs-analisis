@extends('master')
@section('header')
  <h1>Pendaftaran IGD - Pasien Umum / Corporate</h1>
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
        {!! Form::model($pasien, ['route' => ['registrasi.update', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'route' => 'registrasi.store', 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_form')
          <hr>
          {{-- @include('igd.reg.umum._formumum') --}}
          @include('igd.reg.umum._formumum_ranap')

      {!! Form::close() !!}
    </div>
  </div>

  @include('igd.reg.umum.modal')

@endsection

@push('js')
<script src="{{ url('/') }}/js/registrasi.js"></script>
@endpush