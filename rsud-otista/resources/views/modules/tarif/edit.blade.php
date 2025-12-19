@extends('master')

@section('header')
  <h1>Master Tarif </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          <a href="{{ route('tarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($tarif, ['route' => ['tarif.update', $tarif->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
            @if ($jenis == '' || $jenis == 'TI')
              {!! Form::hidden('jenis', 'TI') !!}
            @elseif ($jenis == 'TA')
              {!! Form::hidden('jenis', 'TA') !!}
            @elseif ($jenis == 'TG')
              {!! Form::hidden('jenis', 'TG') !!}
            @endif
            @include('tarif::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
