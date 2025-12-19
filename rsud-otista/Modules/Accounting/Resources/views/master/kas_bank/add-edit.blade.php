@extends('master')

@section('header')
  <h1>Master Kas dan Bank</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if (isset($is_edit) && $is_edit == 1) Ubah Kas dan Bank {{$data['code']}} @else Tambah Kas dan Bank @endif  &nbsp;

        </h3>
      </div>
      <div class="box-body">
          @if (isset($is_edit) && $is_edit == 1)
            {!! Form::model($data, ['route' => ['master.kas_bank.update', $data['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
          @else
            {!! Form::open(['method' => 'POST', 'route' => 'master.kas_bank.store', 'class' => 'form-horizontal']) !!}
          @endif
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    {!! Form::label('code', 'Kode', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        @if (isset($is_edit) && $is_edit == 1)
                        {!! Form::text('code', null, ['class' => 'form-control', 'readonly']) !!}
                        @else
                        {!! Form::text('code', null, ['class' => 'form-control']) !!}
                        @endif
                        <small class="text-danger">{{ $errors->first('code') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('nama') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('akun_coa_id') ? ' has-error' : '' }}">
                    {!! Form::label('akun_coa_id', 'Akun COA', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('akun_coa_id', $akun_coa, null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('akun_coa_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('no_rek') ? ' has-error' : '' }}">
                    {!! Form::label('no_rek', 'No Rekening', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('no_rek', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('no_rek') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Status', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8" style="padding-top: 5px;">
                        {!! Form::radio('status', 1) !!} Active &nbsp;
                        {!! Form::radio('status', 0) !!} Inactive
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <a href="{{ route('master.kas_bank.index') }}" class="btn btn-warning btn-flat">Batal</a>
                    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
                </div>
            </div>
            {!! Form::close() !!}
      </div>
    </div>
@stop
