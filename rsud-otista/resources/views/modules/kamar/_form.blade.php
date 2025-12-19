<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelompokkelas_id', $kelompok, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode_kamar') ? ' has-error' : '' }}">
    {!! Form::label('kode_kamar', 'Kode Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode_kamar', @$kamar->kode, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_kamar') }}</small>
    </div>
</div>
{{-- <div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <input type="checkbox" name="hidden" id="hidden" value="Y" {{@$kamar->hidden == 'Y' ? 'checked' : ''}}>
        {!! Form::label('hidden', 'Sembunyikan Kamar di tampilan display') !!}
    </div>
</div> --}}
{{-- <div class="form-group{{ $errors->has('nama_kamar') ? ' has-error' : '' }}">
    {!! Form::label('nama_kamar', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_kamar', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_kamar') }}</small>
    </div>
</div> --}}
{{-- <div class="form-group{{ $errors->has('id_ss_kamar') ? ' has-error' : '' }}">
    {!! Form::label('id_ss_kamar', 'ID Satu Sehat Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('id_ss_kamar', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('id_ss_kamar') }}</small>
    </div>
</div> --}}
<div class="btn-group pull-right">
    <a href="{{ route('kamar') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
