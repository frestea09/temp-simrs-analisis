<div class="form-group{{ $errors->has('tahuntarif_id') ? ' has-error' : '' }}">
  {!! Form::label('tahuntarif_id', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
    {!! Form::select('tahuntarif_id', $tahuntarif, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tahuntarif_id') }}</small>
  </div>
</div>

<div class="form-group{{ $errors->has('carabayar') ? ' has-error' : '' }}">
    {!! Form::label('carabayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label','style'=>'color:green;']) !!}
    <div class="col-sm-9">
        {!! Form::select('carabayar',$carabayar, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('carabayar') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kode_jenpel') ? ' has-error' : '' }}" id="kode_jenpel" style="display:none;">
    {!! Form::label('kode_jenpel', 'Kode Jenpel Inhealth', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode_jenpel', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_jenpel') }}</small>
    </div>
</div>


<div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
    {!! Form::label('jenis', 'Jenis', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('jenis', ['TA'=>'TA | Rawat Jalan','TI'=>'TI | Rawat Inap','TG'=>'TG | Rawat Darurat'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis') }}</small>
    </div>
</div>
    
{{-- <div class="form-group{{ $errors->has('jenis_akreditasi') ? ' has-error' : '' }}">
    {!! Form::label('jenis_akreditasi', 'Jenis Akreditasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('jenis_akreditasi', [''=>'','A'=>'Akreditasi A','B'=>'Akreditasi B','C'=>'Akreditasi C'], '', ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis_akreditasi') }}</small>
    </div>
</div> --}}

<div class="form-group{{ $errors->has('kelompoktarif_id') ? ' has-error' : '' }}">
  {!! Form::label('kelompoktarif_id', 'Kelompok Tarif', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
    {!! Form::select('kelompoktarif_id', $kelompoktarif, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('kelompoktarif_id') }}</small>
  </div>
</div>

@if ($jenis == 'TI')
  <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
      {!! Form::label('kelas_id', 'Kelas perawatan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
          <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
      </div>
  </div>
@else
  {!! Form::hidden('kelas_id', NULL) !!}
@endif


<div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoriheader_id', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoriheader_id', $kategoriheader, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
    {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategoritarif_id', $kategoritarif, null, ['class' => 'form-control select2']) !!}
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

<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', @$tarif->kode, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>

@if (isset($split))
    @php
        $no = 1;
        $ms = 1;
    @endphp
  @foreach ($split as $key => $d)
      <input type="hidden" name="idsplit{{ $no }}" value="{{ $d->id }}">
    <div class="form-group text-danger">
        {!! Form::label('split'.$d->nama, $d->nama, ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('master-split'.$ms, $d->nominal, ['class' => 'form-control']) !!}
        </div>
    </div>
    @php
        $no++;
        $ms++;
    @endphp
  @endforeach
  <input type="hidden" name="jmlsplit" value="{{ count($split) }}">
@endif

<div id="count_split">

</div>

<div class="form-group{{ $errors->has('akutansi_akun_coa_id') ? ' has-error' : '' }}">
    {!! Form::label('akutansi_akun_coa_id', 'Akutansi Akun COA', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('akutansi_akun_coa_id', $akun_coa, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('akutansi_akun_coa_id') }}</small>
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
        {!! Form::text('keterangan', '-', ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('lica') ? ' has-error' : '' }}">
    {!! Form::label('lica', 'Lica ID', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('lica_id', @$tarif->lica_id, ['class' => 'form-control']) !!}
        <small class="text-danger">Abaikan jika yg diinput bukan tindakan LAB, isi <b>"0"</b>input tindakan LAB</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kodeloinc') ? ' has-error' : '' }}">
    {!! Form::label('kodeloinc', 'Kode LOINC', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kodeloinc', null, ['class' => 'form-control' , 'placeholder' => 'Contoh : 12114-5']) !!}
        <small class="text-danger">{{ $errors->first('kodeloinc') }}</small>
        <small class="text-danger"><a target="_blank" href="https://loinc.org/search">Cari kode LOINC</a></small>
    </div>
</div>
<div class="form-group{{ $errors->has('is_aktif') ? ' has-error' : '' }}">
    {!! Form::label('is_aktif', 'Aktif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <label for="is_aktif_1" style="margin-right: 10px;">
            <input type="radio" name="is_aktif" id="is_aktif_1" value="Y" {{ @$tarif->is_aktif == 'Y' ? 'checked' : '' }}>
            Ya
        </label>
        <label for="is_aktif_2">
            <input type="radio" name="is_aktif" id="is_aktif_2" value="N" {{ @$tarif->is_aktif == 'N' ? 'checked' : '' }}>
            Tidak
        </label>
    </div>
</div>

<div class="btn-group pull-right">
    @if (Request::segment(4) == 'TA')
        <a href="{{ url('/tarif/rawatjalan') }}" class="btn btn-warning btn-flat">Batal</a>
    @elseif (Request::segment(4) == 'TG')
        <a href="{{ url('/tarif/rawatdarurat') }}" class="btn btn-warning btn-flat">Batal</a>
    @else
        <a href="{{ url('/tarif') }}" class="btn btn-warning btn-flat">Batal</a>
    @endif
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>



<script type="text/javascript">
    // $('.select2').select2();
  function hitung_split() {
    var split1 = document.getElementById('split1').value;
    var split2 = document.getElementById('split2').value;
    var split3 = document.getElementById('split3').value;
    var total = parseInt(split1) + parseInt(split2) + parseInt(split3);
    document.getElementById('total').value = total;
  }
</script>
