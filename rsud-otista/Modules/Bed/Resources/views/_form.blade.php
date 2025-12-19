<div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
    {!! Form::label('kamar_id', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kamar_id', $kamar, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('reserved') ? ' has-error' : '' }}">
    {!! Form::label('reserved', 'Reserved', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('reserved', ['N'=>'Kosong', 'Y'=>'Isi'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('reserved') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('bed') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
