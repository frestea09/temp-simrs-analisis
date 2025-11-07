@extends('master')

@section('header')
  <h1>Master Icd10 </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data MasterIcd10 &nbsp;
          <a href="{{ route('icd10.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($icd10, ['route' => ['icd10.update', $icd10->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}

            @include('icd10::_form')

        {!! Form::close() !!}
      </div>
    </div>
@stop
