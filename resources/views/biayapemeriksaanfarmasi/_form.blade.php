<div class="form-group{{ $errors->has('nama_biaya') ? ' has-error' : '' }}">
    {!! Form::label('nama_biaya', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_biaya', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_biaya') }}</small>
    </div>
</div>
