@extends('master')

@section('header')
  <h1>Kofigurasi - Kelompok Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Kelompok Tarif &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'kelompoktarif.store', 'class' => 'form-horizontal']) !!}

            @include('kelompoktarif._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
