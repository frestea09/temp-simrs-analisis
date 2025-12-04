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
        {!! Form::model($pasien, ['url' => url('/registrasi/update-with-antrol/'.$pasien->id), 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'url' => url('/registrasi/store-with-antrol'), 'class' => 'form-horizontal']) !!}
      @endif

          @include('pasien::_form')
          <hr>
          @include('registrasi::_formumum')

      {!! Form::close() !!}
    </div>
  </div>

  @include('igd.reg.umum.modal')

@endsection

@push('js')
<script src="{{ url('/') }}/js/registrasi.js"></script>
@endpush