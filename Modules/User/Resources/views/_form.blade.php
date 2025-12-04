<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
    {!! Form::label('role_id', 'Role User', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('role_id', $role, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('role_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('password') }}</small>
        </div>
</div>
<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    {!! Form::label('password_confirmation', 'Password Konfirmasi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
        </div>
</div>
<div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
    {!! Form::label('foto', 'Foto', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::file('foto', ['class' => 'form-control']) !!}
            <p class="help-block">Help block text</p>
            <small class="text-danger">{{ $errors->first('foto') }}</small>
        </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('user') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
