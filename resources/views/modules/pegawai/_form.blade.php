<div class="col-sm-6">
    <div class="form-group{{ $errors->has('kategori_pegawai') ? ' has-error' : '' }}">
        {!! Form::label('kategori_pegawai', 'Kategori Pegawai', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('kategori_pegawai', [NULL => ' ', '1'=>'Dokter','2'=>'Non Dokter'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('kategori_pegawai') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kategori_pegawai') ? ' has-error' : '' }}">
        {!! Form::label('kelompok_pegawai', 'Kelompok Pegawai', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('kelompok_pegawai', [NULL => ' ', '1'=>'Pegawai Tetap','2'=>'Fungsional', '3'=>'Dokter', '4'=>'Perawat', '5'=>'BHL', '6'=>'Nutrisionis'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('kelompok_pegawai') }}</small>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('nama', 'Nama Lengkap', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
            {{-- <small class="text-danger">{{ $errors->first('nama') }}</small> --}}
        </div>
    </div>
    <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
        {!! Form::label('nik', 'NIK', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('nik', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nik') }}</small>
        </div>
    </div>
    {{-- <div class="form-group{{ $errors->has('kategoripegawai_id') ? ' has-error' : '' }}">
        {!! Form::label('kategoripegawai_id', 'Kategori Pegawai', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('kategoripegawai_id', $kat, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('kategoripegawai_id') }}</small>
        </div>
    </div> --}}
    <div class="form-group">
        {!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('tgllahir', null, ['class' => 'form-control']) !!}
            {{-- <small class="text-danger">{{ $errors->first('tgllahir') }}</small> --}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('tmplahir', 'Tempat Lahir', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('tmplahir', null, ['class' => 'form-control']) !!}
         
        </div>
    </div>
    <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
        {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('kelamin', ['L'=>'Laki-laki','P'=>'Perempuan'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('kelamin') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
        {!! Form::label('agama', 'Agama', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('agama', ['islam'=>'Islam', 'kristen'=>'Kristen', 'katolik'=>'Katolik', 'hindu'=>'Hindu', 'budha'=>'Budha'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('agama') }}</small>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
            
        </div>
    </div>
    <div class="form-group{{ $errors->has('ttd') ? ' has-error' : '' }}">
        {!! Form::label('ttd', 'Tanda Tangan', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::file('ttd', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('ttd') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('status_tte') ? ' has-error' : '' }}">
        {!! Form::label('status_tte', 'Status TTE', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            <select name="status_tte" class="form-control select2">
                <option value="0" {{@$pegawai->status_tte == '0' ? 'selected' : ''}}>NON AKTIF</option>
                <option value="1" {{@$pegawai->status_tte == '1' ? 'selected' : ''}}>AKTIF</option>
            </select>
            <small class="text-danger">{{ $errors->first('status_tte') }}</small>
        </div>
    </div>
   {{-- <div class="form-group{{ $errors->has('ttd') ? ' has-error' : '' }}">
        {!! Form::label('ttd', 'Tanda Tangan', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::file('ttd', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('ttd') }}</small>
            </div>
    </div>--}}
</div>

<div class="col-sm-6">
    {{-- @if($pegawai->kategori_pegawai == 1)
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('sip', 'Kategori Dokter', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                <select name="status" class="form-control select2">
                    <option value="" {{ ($pegawai->status == '') ? 'selected' : '' }}></option>
                    <option value="umum" {{ ($pegawai->status == 'umum') ? 'selected' : '' }}>Dokter Umum</option>
                    <option value="ahli" {{ ($pegawai->status == 'ahli') ? 'selected' : '' }}>Dokter Ahli</option>
                </select>
            </div>
        </div>  
    @else
    @endif --}}
    <div class="form-group">
        {!! Form::label('sip', 'SIP', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('sip', null, ['class' => 'form-control']) !!}
    
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('sip_awal', 'SIP Awal', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('sip_awal', null, ['class' => 'form-control datepicker']) !!}

        </div>
    </div>
    <div class="form-group">
        {!! Form::label('sip_akhir', 'SIP Akhir', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('sip_akhir', null, ['class' => 'form-control datepicker']) !!}
            
        </div>
    </div>
    <div class="form-group{{ $errors->has('kode_bpjs') ? ' has-error' : '' }} kodeBpjs hidden">
        {!! Form::label('kode_bpjs', 'Kode BPJS', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('kode_bpjs', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kode_bpjs') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kode_dokter_inhealth') ? ' has-error' : '' }} kode_inhealth hidden">
        {!! Form::label('kode_dokter_inhealth', 'Kode Inhealth', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('kode_dokter_inhealth', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kode_dokter_inhealth') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('str') ? ' has-error' : '' }}">
        {!! Form::label('str', 'STR', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('str', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('str') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kompetensi') ? ' has-error' : '' }}">
        {!! Form::label('kompetensi', 'Kompetensi', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('kompetensi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kompetensi') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tupoksi') ? ' has-error' : '' }}">
        {!! Form::label('tupoksi', 'Tupoksi', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('tupoksi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('tupoksi') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('general_code') ? ' has-error' : '' }}">
        {!! Form::label('general_code', 'General Code', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('general_code', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('tupoksi') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('poli_type') ? ' has-error' : '' }}">
        {!! Form::label('poli_type', 'Poli Type', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('poli_type', ['J'=>'Rawat Jalan','L'=>'Laboratorium','R'=>'Radiologi'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('poli_type') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('smf') ? ' has-error' : '' }}">
        {!! Form::label('smf', 'SMF', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('smf', smf(), @$pegawai->smf, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('smf') }}</small>
        </div>
    </div>
    {{-- user ID --}}
    {{-- {!! Form::hidden('user_id', Auth::user()->id) !!} --}}
</div>
<div class="form-group text-center">
    <a href="{{ route('pegawai') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>