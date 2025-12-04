<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
    {!! Form::label('display_name', 'Nama Tampilan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('display_name') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('description') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ route('role') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
