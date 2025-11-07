@extends('master')
@section('header')
  <h1>Kategori Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Data Kategori Obat &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'kategoriobat.store', 'class' => 'form-horizontal']) !!}

          @include('kategoriobat._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
