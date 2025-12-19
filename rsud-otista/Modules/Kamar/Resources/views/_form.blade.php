<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('kamar') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
