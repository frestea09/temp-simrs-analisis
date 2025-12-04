@extends('master')
@section('header')
  <h1>Profile User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
        Profile User &nbsp;
      </h3> --}}
    </div>
    <div class="box-body">
      {!! Form::model($user, ['url' => ['user/updateuser'], 'files'=>true,  'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
          {{-- {!! Form::label('email', 'Role', ['class' =>'col-sm-3 control-label']) !!} --}}
          <div class="col-sm-5">
            <input type="hidden" class="form-control" value="{{ Auth::user()->role()->first()->display_name }}" readonly>
          </div>
        </div>

        <div class="form-group">
          {{-- {!! Form::label('email', 'Email address', ['class' =>'col-sm-3 control-label']) !!} --}}
          <div class="col-sm-5">
              {!! Form::hidden('email', null, ['class' => 'form-control', 'required' => 'required', 'readonly' => true]) !!}
              <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
        </div>
          <div class="form-group">
              {!! Form::label('name', 'Nama Lengkap', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>
          </div>

          <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
            {!! Form::label('nik', 'NIK', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('nik', $pegawai->nik , ['class' => 'form-control']) !!}
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
        <div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
            {!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('tgllahir', !empty($pegawai->tgllahir) ? tgl_indo($pegawai->tgllahir) : null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
            {!! Form::label('tmplahir', 'Tempat Lahir', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('tmplahir', $pegawai->tmplahir, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
            {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::select('kelamin', ['L'=>'Laki-laki','P'=>'Perempuan'], $pegawai->kelamin , ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('kelamin') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
            {!! Form::label('agama', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::select('agama', ['islam'=>'Islam', 'kristen'=>'Kristen', 'katolik'=>'Katolik', 'hindu'=>'Hindu', 'budha'=>'Budha'], $pegawai->agama , ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('agama') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
            {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('alamat', $pegawai->alamat, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('alamat') }}</small>
            </div>
        </div>
            @php
                $datasip = Modules\Pegawai\Entities\Pegawai::where('user_id', Auth::user()->id)->first();
            @endphp
        @if($datasip->kategori_pegawai == 1)
            <div class="form-group{{ $errors->has('sip') ? ' has-error' : '' }}">
              {!! Form::label('sip', 'SIP', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::text('sip', $pegawai->sip, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('sip') }}</small>
              </div>
            </div>

          <div class="form-group{{ $errors->has('sip_awal') ? ' has-error' : '' }}">
              {!! Form::label('sip_awal', 'SIP Awal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::text('sip_awal', !empty($pegawai->sip_awal) ? tgl_indo($pegawai->sip_awal) : null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('sip_awal') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('sip_akhir') ? ' has-error' : '' }}">
              {!! Form::label('sip_akhir', 'SIP Akhir', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::text('sip_akhir', !empty($pegawai->sip_akhir) ? tgl_indo($pegawai->sip_akhir) : null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('sip_akhir') }}</small>
              </div>
          </div>
      @endif
      {{-- <div class="form-group{{ $errors->has('kode_bpjs') ? ' has-error' : '' }} kodeBpjs hidden">
          {!! Form::label('kode_bpjs', 'Kode BPJS', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('kode_bpjs', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('kode_bpjs') }}</small>
          </div>
      </div> --}}
      {{-- <div class="form-group{{ $errors->has('kode_dokter_inhealth') ? ' has-error' : '' }} kode_inhealth hidden">
          {!! Form::label('kode_dokter_inhealth', 'Kode Inhealth', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('kode_dokter_inhealth', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('kode_dokter_inhealth') }}</small>
          </div>
      </div> --}}
      @if($datasip->kategori_pegawai != 1)
        <div class="form-group{{ $errors->has('str') ? ' has-error' : '' }}">
            {!! Form::label('str', 'STR', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('str', $pegawai->str, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('str') }}</small>
            </div>
        </div>
      @endif

          <div class="form-group{{ $errors->has('ttd') ? ' has-error' : '' }}">
            {!! Form::label('ttd', 'Tanda Tangan', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::file('ttd', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('ttd') }}</small>
            </div>
          </div>
       
          <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
            {!! Form::label('foto', 'Foto Profile', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                 {!! Form::file('foto', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('foto') }}</small>
            </div>
          </div>

          <div class="form-group{{ $errors->has('status_tte') ? ' has-error' : '' }}">
                {!! Form::label('status_tte', 'Status TTE', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-5">
                    <select name="status_tte" class="form-control select2">
                        <option value="0" {{@$pegawai->status_tte == '0' ? 'selected' : ''}}>NON AKTIF</option>
                        <option value="1" {{@$pegawai->status_tte == '1' ? 'selected' : ''}}>AKTIF</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('status_tte') }}</small>
                </div>
          </div>

         <hr>
      
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', 'New Password', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::password('password', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
          </div>

          <div class="form-group">
              {!! Form::label('email', ' ', ['class' =>'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::submit("Update Data", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
          </div>

        {!! Form::close() !!}
    </div>
   
  </div>
@endsection
