@extends('master')

@section('header')
  <h1>Master Mapping CONF.RL.31</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data CONF.RL31 &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($conf31, ['route' => ['confrl31.update', $conf31->id_conf_rl31], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

        @include('sirs.mapping.conf31._form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
