@extends('master')
@section('header')
  <h1>Supliyer </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Supliyer &nbsp;
          <a href="{{ route('supliyer.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($supliyer, ['route' => ['supliyer.update', $supliyer->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}
          @include('supliyer._form')
        {!! Form::close() !!}
      </div>
    </div>
@stop
