<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Perusahaan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('alamat', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('id_prk') ? ' has-error' : '' }}">
    {!! Form::label('id_prk', 'ID PRK', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('id_prk', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('id_prk') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('diskon') ? ' has-error' : '' }}">
    {!! Form::label('diskon', 'Diskon', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('diskon', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('diskon') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('plafon') ? ' has-error' : '' }}">
    {!! Form::label('plafon', 'Plafon', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('plafon', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('plafon') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control' ]) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
    <div class="btn-group pull-right">
      <a href="{{ url('perusahaan') }}" class="btn btn-warning btn-sm btn-flat">Kembali</a>
        {!! Form::submit("Add", ['class' => 'btn btn-success btn-sm btn-flat']) !!}
    </div>
