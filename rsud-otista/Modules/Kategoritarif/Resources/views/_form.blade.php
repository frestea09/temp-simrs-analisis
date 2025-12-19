<div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoriheader_id', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoriheader_id', $header, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('namatarif') ? ' has-error' : '' }}">
    {!! Form::label('namatarif', 'Kategori Tarif Instalasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('namatarif', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('namatarif') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('kategoritarif') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
