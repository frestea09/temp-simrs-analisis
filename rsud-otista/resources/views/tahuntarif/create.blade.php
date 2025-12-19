@extends('master')

@section('header')
  <h1>Kofigurasi - Tahun Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Tahun Tarif &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'tahuntarif.store', 'class' => 'form-horizontal']) !!}

            @include('tahuntarif._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
