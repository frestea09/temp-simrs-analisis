
<div class="form-group{{ $errors->has('pendidikan') ? ' has-error' : '' }}">
    {!! Form::label('pendidikan', 'Nama Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('pendidikan', null, ['class' => 'form-control',]) !!}
        <small class="text-danger">{{ $errors->first('pendidikan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('pendidikan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
