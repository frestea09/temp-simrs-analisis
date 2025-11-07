
<div class="form-group{{ $errors->has('pendidikan') ? ' has-error' : '' }}">
    {!! Form::label('kualifikasi', 'Kualifikasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::hidden('kualifikasi_id', $data['kualifikasi']->id, ['class' => 'form-control',]) !!}
        {!! Form::text('kualifikasi_nama', ucWords($data['kualifikasi']->nama), ['class' => 'form-control','disabled']) !!}
        <small class="text-danger">{{ $errors->first('kualifikasi_nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('pendidikan') ? ' has-error' : '' }}">
    {!! Form::label('pendidikan', 'Nama Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('pendidikan',isset($data['pendidikan']->pendidikan) ? $data['pendidikan']->pendidikan : null, ['class' => 'form-control',]) !!}
        <small class="text-danger">{{ $errors->first('pendidikan') }}</small>
    </div>
</div>
<hr>
<h5>KEBUTUHAN</h5>
<div class="form-group{{ $errors->has('kebutuhan_laki') ? ' has-error' : '' }}">
    {!! Form::label('kebutuhan_laki', 'Laki Laki', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('kebutuhan_laki',isset($data['pendidikan']->kebutuhan_laki) ? $data['pendidikan']->kebutuhan_laki : null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kebutuhan_laki') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kebutuhan_perempuan') ? ' has-error' : '' }}">
    {!! Form::label('kebutuhan_perempuan', 'Perempuan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('kebutuhan_perempuan',isset($data['pendidikan']->kebutuhan_perempuan) ? $data['pendidikan']->kebutuhan_perempuan : null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kebutuhan_perempuan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('hrd/master/pendidikan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
