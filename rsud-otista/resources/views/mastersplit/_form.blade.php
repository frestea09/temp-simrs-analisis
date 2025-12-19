<div class="form-group{{ $errors->has('tahuntarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tahuntarif_id', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tahuntarif_id', $tahuntarif, configrs()->tahuntarif, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('tahuntarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoriheader_id', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoriheader_id', $kategoriheader, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Split', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('mastersplit') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
