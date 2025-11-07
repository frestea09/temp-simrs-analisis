@extends('master')
@section('header')
  <h1>Mutasi Pegawai</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'hrd/mutasi', 'class' => 'form-horizontal']) !!}

        <div class="form-group{{ $errors->has('pegawai') ? ' has-error' : '' }}">
            {!! Form::label('pegawai', 'Pegawai', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::hidden('pegawai_id',isset($data['biodata']->pegawai_id) ? $data['biodata']->pegawai_id : null, ['class' => 'form-control']) !!}
                {!! Form::hidden('biodata_id',isset($data['biodata']->id) ? $data['biodata']->id : null, ['class' => 'form-control']) !!}
                {!! Form::text('pegawai',isset($data['biodata']->namalengkap) ? $data['biodata']->namalengkap : null, ['class' => 'form-control','readonly']) !!}
                <small class="text-danger">{{ $errors->first('pegawai') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('pegawai') ? ' has-error' : '' }}">
            {!! Form::label('pegawai', 'TTL', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('pegawai',isset($data['biodata']->kelamin) ? $data['biodata']->tmplahir.', '.$data['biodata']->tgllahir : null, ['class' => 'form-control','disabled']) !!}
                <small class="text-danger">{{ $errors->first('pegawai') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('pegawai') ? ' has-error' : '' }}">
            {!! Form::label('pegawai', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('pegawai',isset($data['biodata']->kelamin) ? $data['biodata']->kelamin : null, ['class' => 'form-control','disabled']) !!}
                <small class="text-danger">{{ $errors->first('pegawai') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('pegawai') ? ' has-error' : '' }}">
            {!! Form::label('pegawai', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('pegawai',isset($data['biodata']->alamat) ? $data['biodata']->alamat : null, ['class' => 'form-control','disabled']) !!}
                <small class="text-danger">{{ $errors->first('pegawai') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
            {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('keterangan',isset($data['biodata']->keterangan) ? $data['biodata']->keterangan : null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('keterangan') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('tgl_mutasi') ? ' has-error' : '' }}">
            {!! Form::label('tgl_mutasi', 'Tanggal Mutasi', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('tgl_mutasi',isset($data['biodata']->tgl_mutasi) ? $data['biodata']->tgl_mutasi : null, ['class' => 'form-control datepicker']) !!}
                <small class="text-danger">{{ $errors->first('tgl_mutasi') }}</small>
            </div>
        </div>

        <div class="btn-group pull-right">
            <a href="{{ url('hrd/mutasi') }}" class="btn btn-warning btn-flat">Batal</a>
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
        </div>

        {!! Form::close() !!}
    </div>
  </div>
@endsection
