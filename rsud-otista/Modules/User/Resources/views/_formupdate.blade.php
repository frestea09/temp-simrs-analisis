<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
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
<div class="form-group{{ $errors->has('Gudang') ? ' has-error' : '' }}">
    {!! Form::label('Gudang', 'Gudang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="gudang_id" class="form-control chosen-select">
            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;</option>
            @foreach ($gudang as $d)
                @if($d->id == $user->gudang_id))
                 <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                @else
                 <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endif
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('gudang_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
    {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="poli_id[]" class="form-control select2 multiple" multiple>
            <option value="" {{empty($user->poli_id) ? 'selected' : ''}}>[ Semua ]</option>
            @foreach ($poli as $d)
                @if(in_array($d->id, explode(',', $user->poli_id)))
                 <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                @else
                 <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endif
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <select name="kelompokkelas_id[]" class="form-control select2 multiple" multiple>
            <option value="">[Semua]</option>
            @foreach (App\Kelompokkelas::all() as $d)
                {{-- <option value="{{ $d->id }}">{{ $d->kelompok }}</option> --}}
                @if(in_array($d->id, explode(',', $user->coder_nik)))
                 <option value="{{ $d->id }}" selected>{{ $d->kelompok }}</option>
                @else
                 <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
                @endif
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


<div class="form-group{{ $errors->has('roleaksi') ? ' has-error' : '' }}">
    {!! Form::label('roleaksi', 'Role Aksi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-7">
        <div class="row">
            <div class="col-dm-6">
                <input type="hidden" value="0" name="roleaksi[edit]" class="form-radio">
                @if(@json_decode($user->is_edit,true)['edit'] == 1 )
                <input type="checkbox" value="1" name="roleaksi[edit]" class="form-radio" checked>Edit
                @else
                <input type="checkbox" value="1" name="roleaksi[edit]" class="form-radio">Edit
                @endif
            </div>

            <div class="col-dm-6">
                <input type="hidden" name="roleaksi[hapus]" class="form-radio" value="0">
                @if(@json_decode($user->is_edit,true)['hapus'] == 1 )
                <input type="checkbox" value="1" name="roleaksi[hapus]" class="form-radio" checked>Hapus
                @else
                <input type="checkbox" value="1" name="roleaksi[hapus]" class="form-radio">Hapus
                @endif
            </div>
        </div>
        <small class="text-danger">{{ $errors->first('roleaksi') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('user') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
