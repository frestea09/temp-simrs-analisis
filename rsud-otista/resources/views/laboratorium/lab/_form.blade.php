<div class="form-group{{ $errors->has('labkategori_id') ? ' has-error' : '' }}">
    {!! Form::label('labkategori_id', 'Lab Kategori', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('labkategori_id', $kategori, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('labkategori_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('rujukan') ? ' has-error' : '' }}">
    {!! Form::label('rujukan', 'Nilai Rujukan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('rujukan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('rujukan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanbawah') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanbawah', 'Nilai Rujukan Bawah', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanbawah', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanbawah') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanatas') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanatas', 'Nilai Rujukan Atas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanatas', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanatas') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuan') ? ' has-error' : '' }}">
    {!! Form::label('satuan', 'Satuan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('satuan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('satuan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('lab') }}" class="btn btn-flat btn-warning">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
