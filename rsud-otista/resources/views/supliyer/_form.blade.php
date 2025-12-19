<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('alamat', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tlp') ? ' has-error' : '' }}">
    {!! Form::label('tlp', 'Telepon', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('tlp', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('tlp') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('pimpinan') ? ' has-error' : '' }}">
    {!! Form::label('pimpinan', 'Pimpinan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('pimpinan', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('pimpinan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('aktif') ? ' has-error' : '' }}">
    {!! Form::label('aktif', 'Aktif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('aktif', ['y'=>'Y','n'=>'N'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('aktif') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('supliyer') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
