@extends('master')
@section('header')
  <h1>Satuan Beli </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Data Satuan Beli &nbsp;

        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'satuanbeli.store', 'class' => 'form-horizontal']) !!}

          @include('satuanbeli._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
