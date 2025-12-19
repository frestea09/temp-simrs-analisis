@extends('master')

@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Update Data Pegawai &nbsp;
          <a href="{{ URL::previous() }}" class="btn btn-default btn-sm"><i class="fa fa-backward"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($pegawai, ['route' => ['pegawai.update', $pegawai->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('pegawai::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
