<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
    {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="dokter_id" class="form-control chosen-select">
            <option value="" selected>[ Semua ]</option>
            @foreach ($dokter as $d)
            <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('politype_id') ? ' has-error' : '' }}">
    {!! Form::label('politype_id', 'Jenis Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('politype_id', $poli, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('politype_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('bpjs') ? ' has-error' : '' }}">
    {!! Form::label('bpjs', 'BPJS', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('bpjs', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('bpjs') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('instalasi_id') ? ' has-error' : '' }}">
    {!! Form::label('instalasi_id', 'Instalasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('instalasi_id', $instalasi, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('instalasi_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
    {!! Form::label('kamar_id', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kamar_id', $kamar, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    {!! Form::reset("Reset", ['class' => 'btn btn-warning btn-flat']) !!}
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
