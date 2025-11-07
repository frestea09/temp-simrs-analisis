@extends('master')

@section('header')
  <h1>Kofigurasi - Biaya MCU</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Biaya MCU &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'biayapemeriksaanmcu.store', 'class' => 'form-horizontal']) !!}

            @include('biayapemeriksaanmcu._form')

            <div class="btn-group pull-right">
                {!! Form::reset("Reset", ['class' => 'btn btn-warning btn-flat']) !!}
                {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
            </div>
        {!! Form::close() !!}
      </div>
    </div>
@stop
