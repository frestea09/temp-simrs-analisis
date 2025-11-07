<div class="row">
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('status', $status, 2, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
        {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('keterangan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('rujukan') ? ' has-error' : '' }}">
        {!! Form::label('rujukan', 'Cara Kunjungan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('rujukan', $rujukan, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('rujukan') }}</small>
        </div>
    </div>

    {{-- {!! Form::hidden('antrian_id', session('antrian_id')) !!} --}}
    {!! Form::hidden('status_reg', 'I1') !!}

    <div class="form-group{{ $errors->has('rjtl') ? ' has-error' : '' }}">
        {!! Form::label('rjtl', 'Jenis Layanan BPJS', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('rjtl', ['2'=>'RJTL'], null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('rjtl') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kepesertaan') ? ' has-error' : '' }}">
        {!! Form::label('kepesertaan', 'Kepesertaan JKN', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('kepesertaan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kepesertaan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('hakkelas') ? ' has-error' : '' }}">
        {!! Form::label('hakkelas', 'Hak Kelas', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('hakkelas', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('hakkelas') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nomorrujukan') ? ' has-error' : '' }}">
        {!! Form::label('nomorrujukan', 'Nomor Rujukan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nomorrujukan', null, ['class' => 'form-control' ]) !!}
            <small class="text-danger">{{ $errors->first('nomorrujukan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tglrujukan') ? ' has-error' : '' }}">
        {!! Form::label('tglrujukan', 'Tanggal Rujukan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('tglrujukan', null, ['class' => 'form-control' ]) !!}
            <small class="text-danger">{{ $errors->first('tglrujukan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kodeasal') ? ' has-error' : '' }}">
        {!! Form::label('kodeasal', 'Kode Asal Rujukan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('kodeasal', null, ['class' => 'form-control' ]) !!}
            <small class="text-danger">{{ $errors->first('kodeasal') }}</small>
        </div>
    </div>


  </div>
  {{-- =========================================================== --}}
  <div class="col-md-6">
    {!! Form::hidden('tipe_layanan', '1') !!}
    <div class="form-group{{ $errors->has('catatan') ? ' has-error' : '' }}">
        {!! Form::label('catatan', 'Catatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('catatan', null, ['class' => 'form-control' ]) !!}
            <small class="text-danger">{{ $errors->first('catatan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
      {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="chosen-select" name="poli_id">
          <option value=""></option>
          @foreach ($poli as $key => $d)
            <option value="{{ $d->id }}">{{ $d->nama }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group{{ $errors->has('icd') ? ' has-error' : '' }}">
        {!! Form::label('icd', 'Diagnosa Awal', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="chosen-select" name="icd">
            @foreach ($icd10 as $key => $d)
              <option value="{{ $d->id }}">{{ $d->nomor }} | {{ $d->nama }}</option>
            @endforeach
          </select>
            <small class="text-danger">{{ $errors->first('icd') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kecelakaan') ? ' has-error' : '' }}">
        {!! Form::label('kecelakaan', 'Kecelakaan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('kecelakaan', ['2'=>'TIDAK','1'=>'YA'],null, ['class' => 'chosen-select' ]) !!}
            <small class="text-danger">{{ $errors->first('kecelakaan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('jkn') ? ' has-error' : '' }}">
        {!! Form::label('jkn', 'JKN', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('jkn') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
      {!! Form::label('no_sep', 'Nomor SEP', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('no_sep', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('no_sep') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>

    {!! Form::hidden('bayar', '1') !!}
    <div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
        {!! Form::label('no_jkn', 'Nomor JKN', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('no_jkn', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('status_ugd') ? ' has-error' : '' }}">
        {!! Form::label('status_ugd', 'Tingkat Kegawatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('status_ugd', ['P1'=>'P1','P2'=>'P2','P3'=>'P3','P4'=>'P4'], null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('status_ugd') }}</small>
        </div>
    </div>

    <div class="btn-group pull-right">
        <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>



  </div>
</div>
