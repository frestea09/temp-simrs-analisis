@extends('master')
@section('header')
  <h1>Master Penerimaan </h1>
@endsection

@section('content')
    
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Import Penerimaan Barang &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => url('/logistikmedik/penerimaan/import'), 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
          @include('logistik.logistikmedik.penerimaan._form_import')
        {!! Form::close() !!}
      </div>
    </div>
@stop
