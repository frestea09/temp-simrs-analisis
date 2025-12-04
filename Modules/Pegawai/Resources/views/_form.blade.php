<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Lengkap', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
    {!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::date('tgllahir', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
    {!! Form::label('tmplahir', 'Tempat Lahir', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('tmplahir', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
    {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelamin', ['L'=>'Laki-laki','P'=>'Perempuan'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelamin') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
    {!! Form::label('agama', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('agama', ['islam'=>'Islam', 'kristen'=>'Kristen', 'katolik'=>'Katolik', 'hindu'=>'Hindu', 'budha'=>'Budha'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('agama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
    </div>
</div>

{{-- user ID --}}
{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="btn-group pull-right">
    <a href="{{ route('pegawai') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
