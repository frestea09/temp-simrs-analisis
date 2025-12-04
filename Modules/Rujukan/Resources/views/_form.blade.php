<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Rujukan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
      <a href="{{ url('rujukan') }}" class="btn btn-sm btn-warning">Kembali</a>
      {!! Form::submit("Simpan", ['class' => 'btn btn-sm btn-flat btn-success']) !!}
</div>
