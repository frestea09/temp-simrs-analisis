<div class="form-group{{ $errors->has('tahuntarif_id') ? ' has-error' : '' }}">
  {!! Form::label('tahuntarif_id', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
    {!! Form::select('tahuntarif_id', $tahuntarif, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tahuntarif_id') }}</small>
  </div>
</div>
<div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoriheader_id', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoriheader_id', $kategoriheader, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
    {!! Form::label('jenis', 'Jenis', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('jenis', ['TA'=>'TA | Rawat Jalan','TI'=>'TI | Rawat Inap','TG'=>'TG | Rawat Darurat'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode_jenpel') ? ' has-error' : '' }}" id="kode_jenpel" style="display:none;">
    {!! Form::label('kode_jenpel', 'kode_jenpel', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_jenpel') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas perawatan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoritarif_id', $kategoritarif, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Tindakan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('total') ? ' has-error' : '' }}">
    {!! Form::label('total', 'Tarif Total', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('total', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('total') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('tarif') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
