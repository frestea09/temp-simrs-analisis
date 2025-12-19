@extends('master')
@section('header')
  <h1>Pendaftaran IGD - Pasien Umum / Corporate</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Pasien &nbsp;

      </h3>
    </div>
    <div class="box-body">
      @if ($pasien)
        {!! Form::model($pasien, ['route' => ['registrasi.update', $pasien->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
      @else
        {!! Form::open(['method' => 'POST', 'route' => 'registrasi.store', 'class' => 'form-horizontal']) !!}
      @endif
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                </div>
            </div>
          </div>
        </div>

          @include('pasien::_form')
          <hr>
          @include('igd.reg.umum._formumum_blmterdata')

      {!! Form::close() !!}
    </div>
  </div>
@endsection
