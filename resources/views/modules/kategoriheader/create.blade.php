@extends('master')

@section('header')
  <h1>Master Kategori Header</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Kategori Header &nbsp;
          <a href="{{ route('kategoriheader.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'kategoriheader.store', 'class' => 'form-horizontal']) !!}

            @include('kategoriheader::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
