@extends('master')

@section('header')
  <h1>Master Poli </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Poli &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($poli_u, ['route' => ['poli.update', $poli_u->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('poli::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
