<div class="row">
  {{-- Kolom kiri --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nama') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('alamat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
        {!! Form::label('website', 'Website', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('website', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('website') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email', 'Email ', ['class' =>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'contoh: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('npwp') ? ' has-error' : '' }}">
        {!! Form::label('npwp', 'No. NPWP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('npwp', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('npwp') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
        {!! Form::label('kota', 'Kota', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('kota', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kota') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
        {!! Form::label('logo', 'Logo', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::file('logo', ['class' => 'form-control']) !!}
                <p class="help-block">Help block text</p>
                <small class="text-danger">{{ $errors->first('logo') }}</small>
            </div>
    </div>
    <div class="form-group{{ $errors->has('bayardepan') ? ' has-error' : '' }}">
        {!! Form::label('bayardepan', 'Bayar Depan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('bayardepan', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('bayardepan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kasirtindakan') ? ' has-error' : '' }}">
        {!! Form::label('kasirtindakan', 'Kasir Tindakan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('kasirtindakan', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kasirtindakan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('dinaskesehatan') ? ' has-error' : '' }}">
        {!! Form::label('dinas', 'Dinas Kesehatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('dinas', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('dinaskesehatan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('logoparipurna') ? ' has-error' : '' }}">
        {!! Form::label('logoparipurna', 'Logo Paripurna', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::file('logoparipurna', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('logoparipurna') }}</small>
            </div>
    </div>

    <div class="form-group{{ $errors->has('province_id2') ? ' has-error' : '' }}">
        {!! Form::label('province_id2', 'Propinsi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('province_id2', $provinsi, $config->province_id,['class' => 'form-control select2', 'style'=>'width:100%', 'placeholder'=>' ']) !!}
            <small class="text-danger">{{ $errors->first('province_id2') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('regency_id2') ? ' has-error' : '' }}">
        {!! Form::label('regency_id2', 'Kabupaten', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" name="regency_id2" id="regency_id2">
            @if (!empty ($config->regency_id))
                <option value="{{ $config->regency_id}}">{{ baca_kabupaten2($config->regency_id) }}</option>
            @endif
            </select>
            <small class="text-danger">{{ $errors->first('regency_id2') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('district_id2') ? ' has-error' : '' }}">
        {!! Form::label('district_id2', 'Kecamatan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
        <select class="form-control select2" name="district_id2" id="district_id2">
            @if (!empty ($config->district_id))
            <option value="{{ $config->district_id }}">{{ baca_kecamatan2($config->district_id) }}</option>
            @endif
        </select>
            <small class="text-danger">{{ $errors->first('district_id2') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('village_id2') ? ' has-error' : '' }}">
        {!! Form::label('village_id2', 'Kelurahan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
        <select class="form-control select2" name="village_id2" id="village_id2">
            @if (!empty ($config->village_id))
            <option value="{{ $config->village_id }}">{{ baca_kelurahan2($config->village_id) }}</option>
            @endif
        </select>
            <small class="text-danger">{{ $errors->first('village_id2') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('rt') ? ' has-error' : '' }}">
        {!! Form::label('rt', 'RT', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <input type="text" name="rt" class="form-control" value="{{ @$config->rt }}">
            <small class="text-danger">{{ $errors->first('rt') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('rw') ? ' has-error' : '' }}">
        {!! Form::label('rw', 'RW', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <input type="text" name="rw" class="form-control" value="{{ @$config->rw }}">
            <small class="text-danger">{{ $errors->first('rw') }}</small>
        </div>
    </div>
  </div>












  {{-- Kolom Kanan --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('visi_misi') ? ' has-error' : '' }}">
        {!! Form::label('visi_misi', 'Visi Misi Perusahaan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('visi_misi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('visi_misi') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('antrianfooter') ? ' has-error' : '' }}">
        {!! Form::label('antrianfooter', 'Antrian Footer', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('antrianfooter', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('antrianfooter') }}</small>
        </div>
    </div>
  <div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
      {!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('tahuntarif', $tahun, null, ['class' => 'chosen-select']) !!}
          <small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
      </div>
  </div>
  <div class="form-group{{ $errors->has('pegawai_id') ? ' has-error' : '' }}">
      {!! Form::label('pegawai_id', 'Direktur', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('pegawai_id', $direktur, null, ['class' => 'chosen-select']) !!}
          <small class="text-danger">{{ $errors->first('pegawai_id') }}</small>
      </div>
  </div>
    <div class="form-group{{ $errors->has('panjangkodepasien') ? ' has-error' : '' }}">
        {!! Form::label('panjangkodepasien', 'Panjang Kode Pasien', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('panjangkodepasien', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('panjangkodepasien') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('ipsep') ? ' has-error' : '' }}">
        {!! Form::label('ipsep', 'IP SEP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('ipsep', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('ipsep') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('usersep') ? ' has-error' : '' }}">
        {!! Form::label('usersep', 'User SEP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('usersep', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('usersep') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('ipinacbg') ? ' has-error' : '' }}">
        {!! Form::label('ipinacbg', 'IP INACBG', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('ipinacbg', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('ipinacbg') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('pt') ? ' has-error' : '' }}">
        {!! Form::label('pt', 'Nama PT / Yayasan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pt', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('pt') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('tlp') ? ' has-error' : '' }}">
        {!! Form::label('tlp', 'No. Tlp', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('tlp', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('tlp') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kode_pos') ? ' has-error' : '' }}">
        {!! Form::label('kode_pos', 'Kode Post', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('kode_pos', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kode_pos') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
        {!! Form::label('longitude', 'Longitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('longitude') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
        {!! Form::label('latitude', 'Latitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('latitude') }}</small>
        </div>
    </div>
    {{-- <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
        {!! Form::label('longitude', 'Longitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('longitude') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
        {!! Form::label('latitude', 'Latitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('latitude') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('altitude') ? ' has-error' : '' }}">
        {!! Form::label('altitude', 'Altitude', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('altitude', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('altitude') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('rt') ? ' has-error' : '' }}">
        {!! Form::label('rt', 'rt', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rt', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('rt') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('rw') ? ' has-error' : '' }}">
        {!! Form::label('rw', 'rw', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rw', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('rw') }}</small>
        </div>
    </div> --}}
    
    {{-- <div class="form-group{{ $errors->has('id_organization	') ? ' has-error' : '' }}">
        {!! Form::label('id_organization', 'Organization Satu Sehat	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('id_organization', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('id_organization') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('create_org	') ? ' has-error' : '' }}">
        {!! Form::label('create_org', 'Create Org	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('create_org', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('create_org') }}</small>
        </div>
    </div>
     --}}
     <div class="form-group{{ $errors->has('create_org	') ? ' has-error' : '' }}">
        {!! Form::label('status_satusehat', 'Integrasi Satu Sehat	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            </br>
            <input type="radio" name="status_satusehat" value="1" {{@$config->status_satusehat =='1' ? 'checked' :''}}>Aktif
            <input type="radio" name="status_satusehat" value="0" {{@$config->status_satusehat =='0' ? 'checked' :''}}>Nonaktif
            <small class="text-danger">{{ $errors->first('create_org') }}</small>
        </div>
    </div>
     <div class="form-group{{ $errors->has('create_org	') ? ' has-error' : '' }}">
        {!! Form::label('status_tte', 'Status TTE	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            </br>
            <input type="radio" name="status_tte" value="1" {{@$config->status_tte =='1' ? 'checked' :''}}>Aktif
            <input type="radio" name="status_tte" value="0" {{@$config->status_tte =='0' ? 'checked' :''}}>Nonaktif
            <small class="text-danger">{{ $errors->first('create_org') }}</small>
        </div>
    </div>
     <div class="form-group{{ $errors->has('create_org	') ? ' has-error' : '' }}">
        {!! Form::label('status_finger', 'Cek Finger KIOSK	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            </br>
            <input type="radio" name="status_finger_kiosk" value="1" {{@$config->status_finger_kiosk =='1' ? 'checked' :''}}>Aktif
            <input type="radio" name="status_finger_kiosk" value="0" {{@$config->status_finger_kiosk =='0' ? 'checked' :''}}>Nonaktif
            <small class="text-danger">{{ $errors->first('create_org') }}</small>
        </div>
    </div>
     <div class="form-group{{ $errors->has('create_org	') ? ' has-error' : '' }}">
        {!! Form::label('status_finger', 'Validasi SEP Panggil Poli	', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            </br>
            <input type="radio" name="status_validasi_sep" value="1" {{@$config->status_validasi_sep =='1' ? 'checked' :''}}>Aktif
            <input type="radio" name="status_validasi_sep" value="0" {{@$config->status_validasi_sep =='0' ? 'checked' :''}}>Nonaktif
            <small class="text-danger">{{ $errors->first('create_org') }}</small>
        </div>
    </div>

    <div class="btn-group pull-right">
        <a href="{{ route('config') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
    </div>

  </div>
</div>
@section('script')
<script src="{{ asset('js/demografi2.js') }}" charset="utf-8"></script>
<script type="text/javascript">
      $('.select2').select2();
</script>
@endsection