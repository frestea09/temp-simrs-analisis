<div class="row">
  {{-- kolom kiri  --}}

  <div class="col-md-6">
    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nama') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
        {!! Form::label('nik', 'NIK', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nik', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nik') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
        {!! Form::label('tmplahir', 'Tmp, tgl lahir', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <div class="row">
              <div class="col-md-4">
                {!! Form::text('tmplahir', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
              </div>
              <div class="col-md-8">
                {!! Form::text('tgllahir', (! null) ? tgl_indo($pasien->tgllahir) : null, ['class' => 'form-control', 'id'=>'tgllahir']) !!}
                <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
              </div>
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
        {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], null, ['class' => 'select2 form-control']) !!}
            <small class="text-danger">{{ $errors->first('kelamin') }}</small>
        </div>
    </div>

		<div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
		    {!! Form::label('province_id', 'Propinsi', ['class' => 'col-sm-3 control-label']) !!}
		    <div class="col-sm-9">
		        {!! Form::select('province_id', $provinsi, null,['class' => 'chosen-select', 'placeholder'=>' ']) !!}
		        <small class="text-danger">{{ $errors->first('province_id') }}</small>
		    </div>
		</div>
    <div class="form-group{{ $errors->has('regency_id') ? ' has-error' : '' }}">
        {!! Form::label('regency_id', 'Kabupaten', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('regency_id', [], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('regency_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('district_id') ? ' has-error' : '' }}">
        {!! Form::label('district_id', 'Kecamatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('district_id', [], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('district_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('village_id') ? ' has-error' : '' }}">
        {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('village_id', [], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('village_id') }}</small>
        </div>
    </div>

  </div>
  {{-- kolom kanan =================================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Desa, Rt/Rw, Jl.', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('alamat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nohp') ? ' has-error' : '' }}">
      {!! Form::label('nohp', 'No. HP / Tlp', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nohp') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('pekerjaan_id') ? ' has-error' : '' }}">
        {!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('pekerjaan_id', $pekerjaan, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">
        {!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('agama_id', $agama, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('agama_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('pendidikan_id') ? ' has-error' : '' }}">
        {!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('pendidikan_id', $pendidikan, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('suami_istri') ? ' has-error' : '' }}">
        {!! Form::label('suami_istri', 'Suami/Istri', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('suami_istri', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('suami_istri') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('pj') ? ' has-error' : '' }}">
        {!! Form::label('pj', 'Penanggung Jawab', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pj', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('pj') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('pj_status') ? ' has-error' : '' }}">
        {!! Form::label('pj_status', 'Status Keluarga', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pj_status', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('pj_status') }}</small>
        </div>
    </div>
    </div>
</div>

{{-- <div class="btn-group pull-right">
    <a href="{{ route('pasien') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div> --}}
