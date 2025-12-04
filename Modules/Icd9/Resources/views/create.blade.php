@extends('master')

@section('header')
  <h1>Master ICD9 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterICD9 &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'icd9.store', 'class' => 'form-horizontal']) !!}

          @include('icd9::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
