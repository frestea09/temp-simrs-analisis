@extends('master')

@section('header')
  <h1>Kofigurasi - Tahun Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Biaya Registrasi &nbsp;
        </h3>
      </div>
      <div class="box-body">
      {!! Form::model($biayaregistrasi, ['route' => ['biayaregistrasi.update', $biayaregistrasi->id], 'method' => 'PUT','class'=>'form-horizontal']) !!}

          @include('biayaregistrasi._form')

          <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
              {!! Form::submit("Simpan", ['class' => 'btn btn-success']) !!}
          </div>

      {!! Form::close() !!}
      </div>
    </div>
@stop
