@extends('master')

@section('header')
  <h1>Master Kategori Tarif Instalasi</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Kategori Tarif Instalasi &nbsp;
          <a href="{{ route('kategoritarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'kategoritarif.store', 'class' => 'form-horizontal']) !!}

            @include('kategoritarif::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
