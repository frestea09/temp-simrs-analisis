<div class="form-group{{ $errors->has('labsection_id') ? ' has-error' : '' }}">
    {!! Form::label('labsection_id', 'Lab Kategori', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('labsection_id', $section, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('labsection_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Lab Section', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('labkategori') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
