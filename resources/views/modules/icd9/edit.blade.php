@extends('master')

@section('header')
  <h1>Master ICD9 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterICD9 &nbsp;
          <a href="{{ route('icd9.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($icd9, ['route' => ['icd9.update', $icd9->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('icd9::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
