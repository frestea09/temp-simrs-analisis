@extends('master')
@section('header')
  <h1>Satuan Beli </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Data Satuan Beli &nbsp;
          <a href="{{ route('kategoriobat.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($satuanbeli, ['route' => ['satuanbeli.update', $satuanbeli->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('satuanbeli._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
