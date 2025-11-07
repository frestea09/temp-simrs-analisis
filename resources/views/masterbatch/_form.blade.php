<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('saldo') ? ' has-error' : '' }}">
    {!! Form::label('saldo', 'Saldo Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('saldo', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('saldo') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuanjual_id') ? ' has-error' : '' }}">
    {!! Form::label('satuanjual_id', 'Satuan Jual', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('satuanjual_id', $satuanjual, null, ['class' => 'form-control', 'required' => 'required' ]) !!}
        <small class="text-danger">{{ $errors->first('satuanjual_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuanbeli_id') ? ' has-error' : '' }}">
    {!! Form::label('satuanbeli_id', 'Satuan Beli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('satuanbeli_id', $satuanbeli, null, ['class' => 'form-control', 'required' => 'required' ]) !!}
        <small class="text-danger">{{ $errors->first('satuanbeli_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kategoriobat_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoriobat_id', 'Kategori Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoriobat_id',$kategoriobat , null, ['class' => 'form-control', 'required' => 'required' ]) !!}
        <small class="text-danger">{{ $errors->first('kategoriobat_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('aktif') ? ' has-error' : '' }}">
    {!! Form::label('aktif', 'Aktif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('aktif', ['Y'=>'Y','N'=>'N'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('aktif') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hargabeli') ? ' has-error' : '' }}">
  {!! Form::label('hargabeli', 'Harga beli', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
    {!! Form::text('hargabeli', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('hargabeli') }}</small>
  </div>
</div>
<div class="form-group{{ $errors->has('hargajual') ? ' has-error' : '' }}">
    {!! Form::label('hargajual', 'Hargajual', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('hargajual', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('hargajual') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hargajual_jkn') ? ' has-error' : '' }}">
    {!! Form::label('hargajual_jkn', 'Harga Jual JKN', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('hargajual_jkn', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('hargajual_jkn') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hargajual_kesda') ? ' has-error' : '' }}">
    {!! Form::label('hargajual_kesda', 'Harga Jual Kesda', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('hargajual_kesda', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('hargajual_kesda') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('masterobat') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
