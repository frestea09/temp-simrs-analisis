<div class="form-group{{ $errors->has('kelompok') ? ' has-error' : '' }}">
    {!! Form::label('kelompok', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kelompok', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelompok') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('kelompoktarif') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
