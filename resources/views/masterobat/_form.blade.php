
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
    {!! Form::label('alias', 'Alias', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('alias', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('alias') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kodekfa') ? ' has-error' : '' }}">
    {!! Form::label('kodekfa', 'Kode DTO KFA', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kodekfa', null, ['class' => 'form-control', 'required' => 'required' , 'placeholder' => 'Contoh : 91000243']) !!}
        <small class="text-danger">{{ $errors->first('kodekfa') }}</small>
        <small class="text-danger"><a target="_blank" href="https://dto.kemkes.go.id/kfa-browser">Cari kode DTO KFA</a></small>
    </div>
</div>
<div class="form-group{{ $errors->has('saldo') ? ' has-error' : '' }}">
    {!! Form::label('saldo', 'Saldo Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('saldo', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('saldo') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuanjual_id') ? ' has-error' : '' }}">
    {!! Form::label('satuanjual_id', 'Satuan Jual', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {{-- {!! Form::select('satuanjual_id', $satuanjual, null, ['class' => 'form-control', 'required' => 'required' ]) !!} --}}
        <select name="satuanjual_id"  class="form-control satuans selec2" style="width: 100%;" required>
            <option value="">[ -- ]</option>
            @foreach ($satuanjual as $id => $nama)
              <option value="{{ $id }}" {{@$masterobat->satuanjual_id == $id ? 'selected' : ''}}>{{ $nama }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('satuanjual_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuanbeli_id') ? ' has-error' : '' }}">
    {!! Form::label('satuanbeli_id', 'Satuan Beli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {{-- {!! Form::select('satuanbeli_id', $satuanbeli, null, ['class' => 'form-control', 'required' => 'required' ]) !!} --}}
        <select name="satuanbeli_id"  class="form-control satuans select2" style="width: 100%;" required>
            <option value="">[ -- ]</option>
            @foreach ($satuanbeli as $id => $nama)
              <option value="{{ $id }}" {{@$masterobat->satuanbeli_id == $id ? 'selected' : ''}}>{{ $nama }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('satuanbeli_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('isi_satuan_obat') ? ' has-error' : '' }}">
    {!! Form::label('isi_satuan_obat', 'Isi Berat Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('isi_satuan_obat', null, ['class' => 'form-control', 'placeholder' => '1.5 (gunakan . untuk desimal)' ]) !!}
        <small class="text-danger">{{ $errors->first('isi_satuan_obat') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuan_obat') ? ' has-error' : '' }}">
    {!! Form::label('satuan_obat', 'Satuan Berat Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('satuan_obat', null, ['class' => 'form-control', 'placeholder' => 'mg atau ml' ]) !!}
        <small class="text-danger">{{ $errors->first('satuan_obat') }}</small>
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
<div class="form-group{{ $errors->has('akutansi_akun_coa_id') ? ' has-error' : '' }}">
    {!! Form::label('akutansi_akun_coa_id', 'Akutansi Akun COA', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('akutansi_akun_coa_id', $akun_coa, null, ['class' => 'select2', 'style' => 'width: 100%']) !!}
        <small class="text-danger">{{ $errors->first('akutansi_akun_coa_id') }}</small>
    </div>
</div>
{{-- @if (!isset($masterobat->id)) --}}
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
{{-- @endif --}}
<div class="btn-group pull-right">
    <a href="{{ url('masterobat') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
