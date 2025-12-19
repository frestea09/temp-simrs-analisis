@extends('master')

@section('header')
  <h1>Master Tarif </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Tarif &nbsp;
          <a href="{{ route('tarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'tarif.store', 'class' => 'form-horizontal']) !!}

            @include('tarif::_form')
            
        {!! Form::close() !!}
      </div>
    </div>
@stop
