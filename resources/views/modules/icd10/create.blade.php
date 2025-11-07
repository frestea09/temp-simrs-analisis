@extends('master')

@section('header')
  <h1>Master Icd10 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterIcd10 &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'icd10.store', 'class' => 'form-horizontal']) !!}

          @include('icd10::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
