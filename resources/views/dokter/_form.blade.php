{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
    {!! Form::label('poli_id', 'Nama Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('poli_id', $poli, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('dokter') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
