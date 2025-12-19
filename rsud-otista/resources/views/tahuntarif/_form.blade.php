<div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
    {!! Form::label('tahun', 'Tahun', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('tahun', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tahun') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('tahuntarif') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
