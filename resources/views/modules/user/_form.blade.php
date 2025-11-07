
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Nama Pegawai', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::select('name', $pegawai, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Nama Akun', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::password('password', ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('password') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    {!! Form::label('password_confirmation', 'Password Konfirmasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('gudang_id') ? ' has-error' : '' }}">
    {!! Form::label('gudang_id', 'gudang_id', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="gudang_id" class="form-control chosen-select">
            <option value="" selected>Pilih Gudang</option>
            @foreach ($gudang as $d)
            <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('gudang_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
    {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="poli_id" class="form-control chosen-select">
            <option value="" selected>[ Semua ]</option>
            @foreach ($poli as $d)
            <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }} hidden" id="kelompokKelas">
    {!! Form::label('kelompokkelas_id', 'Kelompok Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="kelompokkelas_id" class="form-control">
            <option value="10">[Semua]</option>
            @foreach (App\Kelompokkelas::all() as $d)
                <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
    {!! Form::label('foto', 'Foto', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::file('foto', ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('foto') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
    {!! Form::label('role', 'Role User', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <div class="row">
            @foreach (\App\Role::orderby('display_name')->get() as $d)
                <div class="col-sm-6">
                    <input type="checkbox" name="role[]" class="form-radio" value="{{ $d->name }}"> {{ $d->display_name }}
                </div>
            @endforeach
        </div>
        <small class="text-danger">{{ $errors->first('role') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ route('user') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
