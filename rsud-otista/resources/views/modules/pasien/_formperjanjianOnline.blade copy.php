<div class="row">
  {{-- kolom kiri  --}}
  @php
      $pasienBaru = \App\RegistrasiDummy::where('nik',$pasien->nik)->first();
      // dd($pasienBaru);
      $pasienLama = \Modules\Pasien\Entities\Pasien::where('no_rm',$pasien->no_rm)->first();
      // dd(['pasien_lama'=>$pasienLama,'pasien_baru'=>$pasienBaru]);
  @endphp
   <input type="hidden" name="reg_online" value="1"/>
  <div class="col-md-6">
    <div class="hidden" id="blmTerdata">
        <div class="form-group has-success">
        {!! Form::label('no_rm', 'Nomor RM', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('no_rm', @$pasienLama ? @$pasienLama->no_rm : null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
        </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nama', @$pasienLama ? @$pasienLama->nama : @$pasienBaru->nama, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
            <small class="text-danger">{{ $errors->first('nama') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
        {!! Form::label('nik', 'NIK', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nik',  $pasienLama ? $pasienLama->nik : $pasienBaru->nik, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nik') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
        {!! Form::label('tmplahir', 'Tmp, tgl lahir', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <div class="row">
              <div class="col-md-5">
                {!! Form::text('tmplahir', @$pasienLama ? @$pasienLama->tmplahir : '-', ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
                <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
              </div>
              <div class="col-md-7">
                {!! Form::text('tgllahir', (!empty($pasienLama)) ? tgl_indo($pasienLama->tgllahir) : @tgl_indo(@$pasienBaru->tgllahir), ['class' => 'form-control', 'id'=>'tgllahir']) !!}
                <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
              </div>
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Dsn, RT, RW', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('alamat', $pasienLama ? $pasienLama->alamat : $pasienBaru->alamat, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
            <small class="text-danger">{{ $errors->first('alamat') }}</small>
        </div>
        <div class="col-sm-2">
            {!! Form::text('rt', $pasienLama ? $pasienLama->rt : $pasienBaru->rt, ['class' => 'form-control', 'placeholder'=>'RT']) !!}
            <small class="text-danger">{{ $errors->first('rt') }}</small>
        </div>
        <div class="col-sm-2">
            {!! Form::text('rw', $pasienLama ? $pasienLama->rw : $pasienBaru->rw, ['class' => 'form-control', 'placeholder'=>'RW']) !!}
            <small class="text-danger">{{ $errors->first('rw') }}</small>
        </div>
    </div>

		<div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
		    {!! Form::label('province_id', 'Propinsi', ['class' => 'col-sm-3 control-label']) !!}
		    <div class="col-sm-9">
		        {!! Form::select('province_id', $provinsi, $pasienLama ? $pasienLama->province_id :'' ,['class' => 'form-control select2', 'style'=>'width:100%', 'placeholder'=>' ']) !!}
		        <small class="text-danger">{{ $errors->first('province_id') }}</small>
		    </div>
		</div>
    <div class="form-group{{ $errors->has('regency_id') ? ' has-error' : '' }}">
        {!! Form::label('regency_id', 'Kabupaten', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" name="regency_id" id="regency_id">
              @if (!empty ($pasienLama))
                <option value="{{ $pasienLama->regency_id }}">{{ baca_kabupaten($pasienLama->regency_id) }}</option>
              @endif
            </select>
            <small class="text-danger">{{ $errors->first('regency_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('district_id') ? ' has-error' : '' }}">
        {!! Form::label('district_id', 'Kecamatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" name="district_id" id="district_id">
            @if (!empty ($pasienLama->district_id))
              <option value="{{ $pasienLama->district_id }}">{{ baca_kecamatan($pasienLama->district_id) }}</option>
            @endif
          </select>
            <small class="text-danger">{{ $errors->first('district_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('village_id') ? ' has-error' : '' }}">
        {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" name="village_id" id="village_id">
            @if (!empty ($pasienLama))
              <option value="{{ $pasienLama->village_id }}">{{ baca_kelurahan($pasienLama->village_id) }}</option>
            @endif
          </select>
            <small class="text-danger">{{ $errors->first('village_id') }}</small>
        </div>
    </div>

  </div>
  {{-- kolom kanan =================================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
        {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], $pasienLama ? $pasien->kelamin : $pasienBaru->kelamin, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('kelamin') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('nohp') ? ' has-error' : '' }}">
      {!! Form::label('nohp', 'No. HP / Tlp', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('nohp', $pasienLama ? $pasienLama->nohp : $pasienBaru->no_hp, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nohp') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('pekerjaan_id') ? ' has-error' : '' }}">
        {!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('pekerjaan_id', $pekerjaan, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">
        {!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('agama_id', $agama, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('agama_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('pendidikan_id') ? ' has-error' : '' }}">
        {!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('pendidikan_id', $pendidikan, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('ibu_kandung') ? ' has-error' : '' }}">
        {!! Form::label('ibu_kandung', 'Ibu Kandung', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('ibu_kandung', '-', ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
            <small class="text-danger">{{ $errors->first('ibu_kandung') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('status_marital') ? ' has-error' : '' }}">
        {!! Form::label('status_marital', 'Status Marital', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            @if (!empty($pasien->status_marital))
                <select class="form-control select2" style="width:100%" name="status_marital">
              @if ($pasien->status_marital == 'Blm Menikah')
                  <option value="Blm Menikah" selected="true">Blm Menikah</option>
                  <option value="Menikah">Menikah</option>
                  <option value="Janda">Janda</option>
                  <option value="Duda">Duda</option>
              @elseif ($pasien->status_marital == 'Menikah')
                 <option value="Blm Menikah">Blm Menikah</option>
                 <option value="Menikah" selected="true">Menikah</option>
                 <option value="Janda">Janda</option>
                 <option value="Duda">Duda</option>
              @elseif ($pasien->status_marital == 'Janda')
                 <option value="Blm Menikah">Blm Menikah</option>
                 <option value="Menikah">Menikah</option>
                 <option value="Janda" selected="true">Janda</option>
                 <option value="Duda">Duda</option>
              @elseif ($pasien->status_marital == 'Duda')
                 <option value="Blm Menikah">Blm Menikah</option>
                 <option value="Menikah">Menikah</option>
                 <option value="Janda">Janda</option>
                 <option value="Duda" selected="true">Duda</option>
              @else
                 <option value="Blm Menikah">Blm Menikah</option>
                 <option value="Menikah">Menikah</option>
                 <option value="Janda">Janda</option>
                 <option value="Duda">Duda</option>
              @endif
            </select>
            @else
                <select class="form-control select2" style="width:100%" name="status_marital">
                    <option value="Blm Meninkah">Blm Menikah</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Janda">Janda</option>
                    <option value="Duda">Duda</option>
                </select>
            @endif

            <small class="text-danger">{{ $errors->first('status_marital') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
        {!! Form::label('no_jkn', 'Nomor JKN', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('no_jkn', $pasienLama ? $pasienLama->no_jkn : $pasienBaru->nomorkartu, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}
            <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
        </div>
    </div>
    </div>
</div>

{{-- <div class="btn-group pull-right">
    <a href="{{ route('pasien') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div> --}}
@section('script')
  <script type="text/javascript">
    $('.select2').select2();

    function viewFormRM(){
      $('#blmTerdata').removeClass('hidden')
    }
  </script>
@endsection
