<div class="row">
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status ', ['class' => 'col-sm-3 control-label']) !!}
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

    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
      {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="chosen-select" name="poli_id">
          @foreach ($poli as $key => $d)
            <option value="{{ $d->id }}">{{ $d->nama }}</option>
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
      </div>
    </div>

    <input name="status_reg" type="hidden" value="G1">



  </div>
  {{-- =========================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="chosen-select" name="bayar">
            @foreach ($carabayar as $key => $d)
              <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
            @endforeach
          </select>
            <small class="text-danger">{{ $errors->first('bayar') }}</small>
        </div>
    </div>
    <div id="perusahaan" class="hide">
      <div class="form-group{{ $errors->has('perusahaan_id') ? ' has-error' : '' }}">
          {!! Form::label('perusahaan_id', 'Perusahaan', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('perusahaan_id', $perusahaan, null, ['class' => 'chosen-select']) !!}
              <small class="text-danger">{{ $errors->first('perusahaan_id') }}</small>
          </div>
      </div>
    </div>

    <div class="btn-group pull-right">
        <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>



  </div>
</div>
