@extends('master')
@section('header')
  <h1>Master Batch </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Master Batch &nbsp;
          <a href="{{ route('masterobat-batches.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($masterobat, ['route' => ['masterobat-batches.update', $masterobat->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('masterbatch._form')

        {!! Form::close() !!}

      </div>
    </div>
@stop
