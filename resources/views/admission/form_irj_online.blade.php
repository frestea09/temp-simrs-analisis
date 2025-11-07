@extends('master')

{{-- @section('css')
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
@endsection --}}


@section('header')
  <h1>Form SEP Susulan - Rawat Jalan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- CEK SEP --}}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label text-right">Cari Rujukan:</label>
            <div class="col-sm-10 btn-group">
              <button type="button" onclick="nomorKartu()" class="btn btn-primary btn-flat">NOMOR KARTU </button>
              {{-- <button type="button" onclick="nomorNik()" class="btn btn-danger btn-flat">NOMOR NIK</button> --}}
              <button type="button" onclick="nomorRujukan()" class="btn btn-success btn-flat">RUJUKAN PPK 1</button>
              <button type="button" onclick="rujukanRS()" class="btn btn-warning btn-flat">PPK2 NOKA</button>
              <button type="button" onclick="rujukanRSbyRujukan()" class="btn btn-danger btn-flat">PPK2 RUJUKAN</button>
              <button type="button" onclick="postRawat()" class="btn btn-primary btn-flat">POST RAWAT</button>
              {{-- <button type="button" onclick="postHD()" class="btn btn-danger btn-flat">POST HD</button> --}}
            </div>
          </div>
        </div>
      </div>

      {{--  --}}
    <hr>
      {!! Form::open(['method' => 'POST', 'url' => 'admission/save-sep/irj-igd', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
          {{-- <input type="hidden" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}"> --}}
          <input type="hidden" name="nama_ppk_perujuk" value="">
          <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}" readonly="true" class="form-control">
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('namapasien') ? ' has-error' : '' }}">
                  {!! Form::label('namapasien', 'Nama Pasien', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="namapasien" value="{{ !empty($nama) ? $nama : $reg->pasien->nama }}" readonly="true" class="form-control">
                      <small class="text-danger">Nama Sesuai Data Rekam Medis</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                  {!! Form::label('nama', 'Nama (sesuai Kartu)', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="nama" value="{{@$rujukan['peserta']['nama']}}" readonly="true" class="form-control">
                      <small class="text-success">Nama Sesuai Nomor Kartu BPJS</small>
                      <small class="text-danger">{{ $errors->first('nama') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_bpjs', @$reg->pasien->no_jkn, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : @$rujukan['peserta']['mr']['noTelepon'], ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
              </div>
              <input type="hidden" name="nik" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
              <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', @$rujukan['tglKunjungan'], ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', @$rujukan['noKunjungan'], ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-3">
                      {{-- <select name="ppk_rujukan" class="form-control select2" style="width: 100%">
                        @foreach ($kd_ppk as $d)
                            <option value="{{ $d->kode_ppk }}" selected="true">{{ $d->nama_ppk }}</option>
                        @endforeach
                      </select> --}}
                      {!! Form::text('ppk_rujukan', @$rujukan['provPerujuk']['kode'], ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="nama_perujuk" value="{{@$rujukan['provPerujuk']['nama']}}" class="form-control">
                  
                  </div>
              </div>
              <div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('catatan_bpjs', '-', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                  {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('diagnosa_awal', @$rujukan['diagnosa']['kode'], ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                      <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan', '1'=>'Rawat Inap'], @$rujukan['pelayanan']['kode'], ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas : @$rujukan['peserta']['hakKelas']['kode'], ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('hak_kelas_inap_naik') ? ' has-error' : '' }}">
                {!! Form::label('hak_kelas_inap_naik', 'Hak Kelas Naik', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('hak_kelas_inap_naik', !empty($hak_kelas_inap_naik) ? $hak_kelas_inap_naik : '', ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('hak_kelas_inap_naik') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('pembiayaan') ? ' has-error' : '' }}">
              {!! Form::label('pembiayaan', 'Pembiayaan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::select('pembiayaan', [''=>'','1'=>'Pribadi', '2'=>'Pemberi Kerja','3'=>'Asuransi Kesehatan Tambahan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                  <small class="text-danger">{{ $errors->first('pembiayaan') }}</small>
              </div>
            </div>
              <div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('cob') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('katarak', ['1'=>'Tidak', '0'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('katarak') }}</small>
                  </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                <div class="col-sm-8">
                  <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                </div>
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ !empty($reg->tipe_jkn) ? $reg->tipe_jkn : NULL }}" readonly="true" class="form-control">
                </div>
              </div>
              <div class="form-group{{ $errors->has('tujuanKunj') ? ' has-error' : '' }}">
                {!! Form::label('tujuanKunj', 'Tujuan Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
                <div class="col-sm-8">
                    {!! Form::select('tujuanKunj', ['0'=>'Konsul Dokter','1'=>'Prosedur', '2'=>'Normal'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('flagProcedure') ? ' has-error' : '' }}">
                {!! Form::label('flagProcedure', 'Flag Procedure', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Diisi jika tujuan Kunjungan = Normal"></i>  Flag Procedure</label> --}}
                
                <div class="col-sm-8">
                    {!! Form::select('flagProcedure', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','0'=>'Prosedur Tidak Berkelanjutan','1'=>'Prosedur dan Terapi Berkelanjutan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('flagProcedure') }}</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('kdPenunjang') ? ' has-error' : '' }}">
                {!! Form::label('kdPenunjang', 'Penunjang', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('kdPenunjang', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','1'=>'Radioterapi','2'=>'Kemoterapi','3'=>'Rehabilitasi Medik','4'=>'Rehabilitasi Psikososial','5'=>'Transfusi Darah','6'=>'Pelayanan Gigi'
                    ,'7'=>'Laboratorium','8'=>'USG','9'=>'Farmasi','10'=>'Lain-Lain','11'=>'MRI','12'=>'Hemodialisa' ], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('kdPenunjang') }}</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('assesmentPel') ? ' has-error' : '' }}">
                {!! Form::label('assesmentPel', 'Assesment Pel.', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('assesmentPel', ['0'=>'Tujuan Kontrol','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Normal'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                        <option value="{{ $d->bpjs }}" {{$d->bpjs ==  @$rujukan['poliRujukan']['kode'] ? 'selected' :'' }}>{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="dpjpLayanan" class="col-sm-4 control-label">Dokter Konsul</label>
                <div class="col-sm-8">
                  <select name="dpjpLayan" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                      <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                @php
                    $url = '"'.url('/bridgingsep/jadwal-dokter-hfis').'"';
                @endphp
                <label for="poliTujuan" class="col-sm-4 control-label">Jam Praktek<br><a style="cursor: pointer" onclick='javascript:wincal=window.open({{$url}}, width=790,height=400,scrollbars=2)'><i>Lihat jam praktek</i></a></label>
                <div class="col-sm-3">
                  {!! Form::text('jam_start', null, ['class' => 'form-control timepicker']) !!}
                </div>
                <label for="jam" class="col-sm-1 control-label">S/D</label>
                <div class="col-sm-3">
                  {!! Form::text('jam_end', null, ['class' => 'form-control timepicker']) !!}
                </div>
              </div>
              <div class="form-group{{ $errors->has('laka_lantas') ? ' has-error' : '' }}">
                  {!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('laka_lantas') }}</small>
                  </div>
              </div>
              <div class="laka hidden">
                  <div class="form-group{{ $errors->has('penjamin') ? ' has-error' : '' }}">
                      {!! Form::label('penjamin', 'Penjamin', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('penjamin', ['1'=>'Jasa Raharja', '2'=>'BPJS Ketenagakerjaan', '3'=>'TASPEN', '4'=>'ASABRI'], null, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('penjamin') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('no_lp') ? ' has-error' : '' }}">
                      {!! Form::label('no_lp', 'No. LP', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('no_lp', null, ['class' => 'form-control']) !!}
                          <small class="text-danger">{{ $errors->first('no_lp') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('tglKejadian') ? ' has-error' : '' }}">
                      {!! Form::label('tglKejadian', 'Tanggal Kejadian Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('tglKejadian', null, ['class' => 'form-control datepicker', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('tglKejadian') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kll') ? ' has-error' : '' }}">
                      {!! Form::label('kll', 'Ket Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('kll', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('kll') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('suplesi') ? ' has-error' : '' }}">
                      {!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], 0, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('suplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('noSepSuplesi') ? ' has-error' : '' }}">
                      {!! Form::label('noSepSuplesi', 'No. SEP Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('noSepSuplesi', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('noSepSuplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdPropinsi') ? ' has-error' : '' }}">
                      {!! Form::label('kdPropinsi', 'Propinsi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdPropinsi" id="regency_id" style="width:100%">
                            <option value=""></option>
                            @foreach ($bpjsprov as $i)
                            <option value="{{ $i->kode }}"> {{ $i->propinsi }}</option>
                                
                            @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('kdPropinsi') }}</small>
                      </div>
                  </div>
                  
                  <div class="form-group{{ $errors->has('kdKabupaten') ? ' has-error' : '' }}">
                      {!! Form::label('kdKabupaten', 'Kabupaten', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKabupaten" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKabupaten') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdKecamatan') ? ' has-error' : '' }}">
                      {!! Form::label('kdKecamatan', 'Kecamatan', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKecamatan" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKecamatan') }}</small>
                      </div>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                  <div class="col-sm-4 control-label">
                    <button type="button" id="createSEP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SEP</button>
                  </div>
                  <div class="col-sm-8" id="fieldSEP">
                      {!! Form::text('no_sep', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                      <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('nomorantrian') ? ' has-error' : '' }}">
                {{-- <div class="col-sm-4 control-label">
                  <button type="button" id="createAntrian" class="btn btn-info btn-flat"><i class="fa fa-recycle"></i> ANTRIAN BPJS</button>
                </div>
                <div class="col-sm-8" id="fieldAntrian">
                    {!! Form::text('nomorantrian',  !empty($reg->nomorantrian) ? $reg->nomorantrian : '', ['class' => 'form-control readonly','id'=>'noAntrian','placeholder'=>'Wajib diisi, dengan klik tombol antrian']) !!}
                    <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                </div> --}}
            </div>
              <div class="btn-group pull-right">
                  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
              </div>

            </div>
          </div>


      {!! Form::close() !!}
            {{-- State loading --}}
            <div class="overlay hidden">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL PENGECEKAN NOMOR KARTU --}}
  <div class="modal fade" id="modalPencarian">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formPencarian">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="judul" class="col-sm-3 control-label judul"></label>
              <div class="col-sm-6 formInput">

              </div>
            </div>
          </form>
            {{-- progress bar --}}
          <div class="progress progress-sm active hidden">
            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              <span class="sr-only">97% Complete</span>
            </div>
          </div>
          <table class="table table-bordered table-condensed tableStatus hidden">
            <tbody>
              <tr>
                <th>Nama Pasien</th><td class="nama"></td>
              </tr>
              <tr>
                <th>Tgl Lahir</th><td class="tglLahir"></td>
              </tr>
              <tr>
                <th>NIK</th><td class="nik"></td>
              </tr>
              <tr>
                <th>No. Kartu</th><td class="noka"></td>
              </tr>
              <tr>
                <th>No. Telepon</th><td class="noTelepon"></td>
              </tr>
              <tr>
                <th>Status</th><td class="status"></td>
              </tr>
              <tr class="rujukan hidden">
                <th>PPK Perujuk</th><td class="ppkPerujuk"></td>
              </tr>
              <tr>
                <th>Dinsos</th><td class="dinsos"></td>
              </tr>
              <tr>
                <th>No. SKTM</th><td class="noSKTM"></td>
              </tr>
              <tr>
                <th>Prolanis</th><td class="prolanisPRB"></td>
              </tr>
            </tbody>
          </table>
          {{-- SHOW Multiple Rujukan --}}
          <div class="table-responsive">
            <table class="table table-bordered table-condensed tableMultipleRujukan hidden">
              <thead>
                <tr>
                  <th>No. RM</th>
                  <th>No. Kartu</th>
                  <th>No. Rujukan</th>
                  <th>Jenis Pelayanan</th>
                  <th>Poli Tujuan</th>
                  <th>Tgl Rujukan</th>
                </tr>
              </thead>
              <tbody id="dataMultipleRujukan">
              </tbody>
            </table>
          </div>
          <p class="text-center text-danger statusError" style="font-weight: bold"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">TUTUP</button>
          <button type="button" class="btn btn-primary btn-flat save" onclick="">CARI</button>
          <button type="button" class="btn btn-success btn-flat lanjut hidden" data-dismiss="modal">LANJUT</button>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="confirmModal">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="text-center">
              <a href="#" class="btn btn-sq text-center">
                 <i class="fa fa-hand-o-up fa-5x"></i>
             </a>
           </div>

          <div class="modal-body">
            
            <h4 class="modal-title" style="text-align:center;" id="modalTitle"></h4>

          </div>
          </div>
          <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
            <a href="#" class="btn btn-success" id="createSEP" data-dismiss="modal">Sudah</a>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Belum</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
  {{-- <script language="javascript" src="/lz-string.js"></script> --}}
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('.datepicker').datepicker({ endDate: new Date(), autoclose: true, format: "yyyy-mm-dd" });
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
    $( function() {
      $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });

    });


    function nomorKartu() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').addClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.rujukan').addClass('hidden');
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor Kartu')
      $('.judul').text('Nomor Kartu')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_kartu" class="form-control id="noKartu">')
      $('.save').attr('onclick', 'cariNoKartu()');
    }

    function rujukanRS() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').addClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Rujukan PPK2 Berdasar Nomor Kartu')
      $('.judul').text('Nomor Kartu')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
      $('.save').attr('onclick', 'cariNoRujukanPPK2()');
    }

    function rujukanRSbyRujukan() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor Rujukan PPK 2')
      $('.judul').text('Nomor Rujukan')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_rujukan" class="form-control">')
      $('.save').attr('onclick', 'cariNoRujukanPPK2byRujukan()');
    }

    function nomorNik() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor NIK')
      $('.judul').text('Nomor NIK')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_nik" class="form-control">')
      $('.save').attr('onclick', 'cariNIK()');
    }

    function nomorRujukan() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor Rujukan')
      $('.judul').text('Nomor Rujukan')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_rujukan" class="form-control" id="noRujukan">')
      $('.save').attr('onclick', 'cariNoRujukan()');
    }

    function postRawat() {
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pos Rawat Inap')
      $('.judul').text('Nomor Kartu')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
      $('.save').attr('onclick', 'savePosRawatInap()');
    }

    function postHD() {
      $('#modalPencarian').modal('show')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Post HD')
      $('.judul').text('Nomor Kartu')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
      $('.save').attr('onclick', 'savePosHD()');
    }

    function compressData(string){
      data = LZString.compressToEncodedURIComponent(string)
      return data
    }
// ================================== AJAX =============================================
    function cariNoKartu() {
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden');
      $('.tableMultipleRujukan').addClass('hidden')
      $('.statusError').text('') 
      $.ajax({
        url: '/cari-sep/noka',
        type: 'POST',
        dataType: 'json',
        data: {
          no_kartu : compressData($('input[name="no_kartu"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        
        data = JSON.parse(res); 
        console.log(data);
        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {
          $('.tableMultipleRujukan').removeClass('hidden')
          $('#dataMultipleRujukan').empty()
          $.each(data[1].rujukan, function(index, val) {
             $('#dataMultipleRujukan').append('<tr> <td>'+val.peserta.mr.noMR+'</td> <td>'+val.peserta.noKartu+'</td> <td><button class="btn btn-default btn-flat btn-xs" onclick="getDataRujukan(\''+val.noKunjungan+'\')">'+val.noKunjungan+'</button></td> <td>'+val.pelayanan.nama+'</td> <td>'+val.poliRujukan.nama+'</td> <td>'+val.tglKunjungan+'</td> <td>'+val.peserta.statusPeserta.keterangan+'</td> <td>'+val.peserta.sex+'</td> </tr>')
          });
        }
      });
    }

    //GET RUJUKAN FROM MULTIPLE
    function getDataRujukan(noKunjungan) {
      // console.log(noKunjungan)
      var token = $('input[name="_token"]').val()
      if (confirm('Yakin Nomor Rujukan '+ noKunjungan +' akan di buat SEP?')) {
        $.ajax({
          url: '/get-data-by-rujukan',
          type: 'POST',
          dataType: 'json',
          data: { '_token' : token, 'no_rujukan' : noKunjungan},
        })
        .done(function(res) {
          
          data = JSON.parse(res)
          $('.tableMultipleRujukan').removeClass('hidden')
          $('.statusError').text('')
          $('#modalPencarian').modal('hide')
          //FORM
          $('input[name="nama"]').val(data[1].rujukan.peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].rujukan.peserta.noKartu)
          $('input[name="no_tlp"]').val(data[1].rujukan.peserta.mr.noTelepon)
          $('input[name="ppk_rujukan"]').val(data[1].rujukan.peserta.provUmum.kdProvider)
          $('input[name="nik"]').val(data[1].rujukan.peserta.nik)
          $('input[name="nama_perujuk"]').val(data[1].rujukan.provPerujuk.nama)
          $('input[name="hak_kelas_inap"]').val(data[1].rujukan.peserta.hakKelas.kode)
          $('input[name="no_rujukan"]').val(data[1].rujukan.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data[1].rujukan.tglKunjungan)
          $('input[name="diagnosa_awal"]').val(data[1].rujukan.diagnosa.kode)
        });
      }


    }

    function cariNoRujukan() {
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden');
      $('.tableMultipleRujukan').addClass('hidden')
      $('.statusError').text('') 
      $.ajax({
        url: '/get-data-by-rujukan',
        type: 'POST',
        dataType: 'json',
        data: {
          data : LZString.compressToBase64($('#formPencarian').serialize()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        // var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(res)
        console.log(data)
        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {
          $('.statusError').text('')
          $('.tableStatus').removeClass('hidden')
          $('.lanjut').removeClass('hidden')
          $('.statusError').text('')
          $('.nama').text(data[1].rujukan.peserta.nama)
          $('.noka').text(data[1].rujukan.peserta.noKartu)
          $('.status').text(data[1].rujukan.peserta.statusPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data[1].rujukan.provPerujuk.nama)
          $('.dinsos').text(data[1].rujukan.peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].rujukan.peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].rujukan.peserta.informasi.prolanisPRB)
          //FORM
          $('input[name="nama"]').val(data[1].rujukan.peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].rujukan.peserta.noKartu)
          $('input[name="no_tlp"]').val(data[1].rujukan.peserta.mr.noTelepon)
          $('input[name="no_rujukan"]').val(data[1].rujukan.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data[1].rujukan.tglKunjungan)
          $('input[name="ppk_rujukan"]').val(data[1].rujukan.provPerujuk.kode)
          $('input[name="nik"]').val(data[1].rujukan.peserta.nik)
          $('input[name="nama_perujuk"]').val(data[1].rujukan.provPerujuk.nama)
          $('input[name="diagnosa_awal"]').val(data[1].rujukan.diagnosa.kode)
          $('input[name="hak_kelas_inap"]').val(data[1].rujukan.peserta.hakKelas.kode)
          $('select[name="poli_bpjs"]').val(data[1].rujukan.poliRujukan.kode).trigger('change')
        }

      });

    }

    function cariNIK() {
      $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/cari-nik',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          nik : compressData($('input[name="no_nik"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        
        data = JSON.parse(res); 

        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {
          $('.statusError').text('')
          $('.tableStatus').removeClass('hidden')
          $('.lanjut').removeClass('hidden')
          $('.statusError').text('')
          $('.nama').text(data[1].peserta.nama)
          $('.nik').text(data[1].peserta.nik)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data[1].peserta.provUmum.kode)
          //FORM
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].peserta.noKartu)
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="ppk_rujukan"]').val(data[1].peserta.provUmum.kdProvider)

        }

      });

    }

    //CARI RUJUKAN PPK2
    function cariNoRujukanPPK2() {
      $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/bridgingsep/insert-rujukan-rs',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_kartu"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        // console.log(res)
        data = JSON.parse(res)
        console.log(data)
        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {
          $('.tableMultipleRujukan').removeClass('hidden')
          $('#dataMultipleRujukan').empty()
          $.each(data[1].rujukan, function(index, val) {
             $('#dataMultipleRujukan').append('<tr> <td>'+val.peserta.mr.noMR+'</td> <td>'+val.peserta.noKartu+'</td> <td><button class="btn btn-default btn-flat btn-xs" onclick="getDataRujukanPPK2(\''+val.noKunjungan+'\')">'+val.noKunjungan+'</button></td> <td>'+val.pelayanan.nama+'</td> <td>'+val.poliRujukan.nama+'</td> <td>'+val.tglKunjungan+'</td> </tr>')
          });
        }
      });
    }

    function getDataRujukanPPK2(noKunjungan) {
      if (confirm('Yakin Nomor Rujukan '+noKunjungan+' akan di buat SEP?')) {
        $.ajax({
          url: '/bridgingsep/insert-rujukan-rs-byrujukan',
          type: 'POST',
          dataType: 'json',
          data: {'_token': $('input[name="_token"]').val(), 'no_rujukan' : compressData(noKunjungan)},
        })
        .done(function(res) {
          data = JSON.parse(res)
          // console.log(data)
          $('.tableMultipleRujukan').removeClass('hidden')
          $('.statusError').text('')
          $('#modalPencarian').modal('hide')
          // //FORM
          $('input[name="nama"]').val(data[1].rujukan.peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].rujukan.peserta.noKartu)
          $('input[name="no_tlp"]').val(data[1].rujukan.peserta.mr.noTelepon)
          $('input[name="no_rujukan"]').val(data[1].rujukan.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data[1].rujukan.tglKunjungan)
          $('input[name="ppk_rujukan"]').val(data[1].rujukan.provPerujuk.kode)
          $('input[name="nik"]').val(data[1].rujukan.peserta.nik)
          $('input[name="nama_perujuk"]').val(data[1].rujukan.provPerujuk.nama)
          $('input[name="diagnosa_awal"]').val(data[1].rujukan.diagnosa.kode)
          $('input[name="hak_kelas_inap"]').val(data[1].rujukan.peserta.hakKelas.kode)
          $('select[name="poli_bpjs"]').val(data[1].rujukan.poliRujukan.kode).trigger('change')
          $('select[name="asalRujukan"]').val('2').trigger('change')
        });
      }
    }

    //Rujukan PPK2 By Nomor Rujukan
    function cariNoRujukanPPK2byRujukan() {
      $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/bridgingsep/insert-rujukan-rs-byrujukan',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data: {
          data : LZString.compressToBase64($('#formPencarian').serialize()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        
        data = JSON.parse(res)

        if (data[0].metaData.code !== "200") {
          $('.statusError').text(data[0].metaData.message)
          alert(data[0].metaData.message)
        }
        if (data[0].metaData.code == "200") {
          $('.tableStatus').removeClass('hidden')
          $('.lanjut').removeClass('hidden')
          $('.nama').text(data[1].rujukan.peserta.nama)
          $('.tglLahir').text(data[1].rujukan.peserta.tglLahir)
          $('.nik').text(data[1].rujukan.peserta.nik)
          $('.noTelepon').text(data[1].rujukan.peserta.mr.noTelepon)
          $('.noka').text(data[1].rujukan.peserta.noKartu)
          $('.status').text(data[1].rujukan.peserta.statusPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data[1].rujukan.provPerujuk.nama)
          $('.dinsos').text(data[1].rujukan.peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].rujukan.peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].rujukan.peserta.informasi.prolanisPRB)
          //FORM
          $('input[name="nama"]').val(data[1].rujukan.peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].rujukan.peserta.noKartu)
          $('input[name="no_tlp"]').val(data[1].rujukan.peserta.mr.noTelepon)
          $('input[name="no_rujukan"]').val(data[1].rujukan.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data[1].rujukan.tglKunjungan)
          $('input[name="ppk_rujukan"]').val(data[1].rujukan.provPerujuk.kode)
          $('input[name="nik"]').val(data[1].rujukan.peserta.nik)
          $('input[name="nama_perujuk"]').val(data[1].rujukan.provPerujuk.nama)
          $('input[name="diagnosa_awal"]').val(data[1].rujukan.diagnosa.kode)
          $('input[name="hak_kelas_inap"]').val(data[1].rujukan.peserta.hakKelas.kode)
          $('select[name="poli_bpjs"]').val(data[1].rujukan.poliRujukan.kode).trigger('change')
          $('select[name="asalRujukan"]').val('2').trigger('change')
        }
      });
    }

    function savePosRawatInap() {
      $('.progress').removeClass('hidden')
      $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/cari-sep/noka-igd',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_kartu"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        data = JSON.parse(res)
        
        $('.progress').addClass('hidden')
        $('.tableStatus').removeClass('hidden')
        $('.lanjut').removeClass('hidden')
        $('.nama').text(data[1].peserta.nama)
        $('.tglLahir').text(data[1].peserta.tglLahir)
        $('.nik').text(data[1].peserta.nik)
        $('.noTelepon').text(data[1].peserta.mr.noTelepon)
        $('.noka').text(data[1].peserta.noKartu)
        $('.status').text(data[1].peserta.statusPeserta.keterangan)
        $('.rujukan').removeClass('hidden');
        $('.dinsos').text(data[1].peserta.informasi.dinsos)
        $('.noSKTM').text(data[1].peserta.informasi.noSKTM)
        $('.prolanisPRB').text(data[1].peserta.informasi.prolanisPRB)
        $('input[name="nama"]').val(data[1].peserta.nama)
        $('input[name="no_bpjs"]').val(data[1].peserta.noKartu)
        $('select[name="asalRujukan"]').val('2').trigger('change')
        $('input[name="ppk_rujukan"]').val('{{ config('app.sep_ppkLayanan') }}')
        $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)

      });

    }

    function savePosHD() {
      $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/bridgingsep/pos-hd',
        type: 'POST',
        dataType: 'json',
        data: $('#formPencarian').serialize(),
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(data) {
        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {

        }
      });

    }

// ======================================================================================================================

    //Laka lantas
    $('select[name="laka_lantas"]').change(function(e) {
      if($(this).val() == 1){
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }
    });

    $('.select2').select2()


    $(document).ready(function() {
      //SET LAKA LANTAS
      if ($('select[name="laka_lantas"]').val() == 1) {
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }

      //ICD 10
      $("input[name='diagnosa_awal']").on('focus', function () {
        $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd10',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });


      $('#createSEP').on('click', function () {
        $("input[name='no_sep']").val( ' ' );
        $.ajax({
          url : '{{ url('/buat-sep') }}',
          type: 'POST',
          // data: $("#formSEP").serialize(),
          data:{
            data : LZString.compressToBase64($('#formSEP').serialize()),
            _token : $('input[name="_token"]').val(),
            _method : 'POST'
          },
          processing: true,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
          success:function(data){
            if(data.error){
              if(data.error.tglKejadian){
                alert(data.error.tglKejadian);
                return false;
              }
              if(data.error.kll){
                alert(data.error.kll);
                return false;
              }
              if(data.error.suplesi){
                alert(data.error.suplesi);
                return false;
              }
              if(data.error.noSepSuplesi){
                alert(data.error.noSepSuplesi);
                return false;
              }
              if(data.error.kdPropinsi){
                alert(data.error.kdPropinsi);
                return false;
              }
              if(data.error.kdKabupaten){
                alert(data.error.kdKabupaten);
                return false;
              }
              if(data.error.kdKecamatan){
                alert(data.error.kdKecamatan);
                return false;
              }
            }else if(data.sukses){
              $('#fieldSEP').removeClass('has-error');
              $("input[name='no_sep']").val( data.sukses );
            } else if (data.msg) {
              // $('#fieldSEP').addClass('has-error');
              // $("input[name='no_sep']").val( data.msg );
              $('.overlay').addClass('hidden')
              alert(data.msg)
            }
          }
        });
      });

       // ANTRIAN
       $('#createAntrian').on('click', function () {
        // $("input[name='nomorantrian']").val('');
        $.ajax({
          url : '{{ url('/buat-antrian') }}',
          type: 'POST',
          // data: $("#formSEP").serialize(),
          data:{
            data : LZString.compressToBase64($('#formSEP').serialize()),
            _token : $('input[name="_token"]').val(),
            _method : 'POST'
          },
          processing: true,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
          success:function(data){
            
            if(data.duplicate == true){
              swal("Info", 'Kode booking sudah pernah diinput', "success");
            }
            if(data.code == 201){
              $('.overlay').addClass('hidden')
              // alert(data.msg)
              swal("Gagal", data.msg, "error");
            }else if(data.code == 208){
              $('.overlay').addClass('hidden')
              $("input[name='nomorantrian']").val( data.msg );
              // swal("Gagal", data.msg, "error");
              console.log(data)
            }else{
              $('#fieldAntrian').removeClass('has-error');
              $("input[name='nomorantrian']").val( data.msg );
            }
              
            // }else if(data.sukses){
            //   $('#fieldAntrian').removeClass('has-error');
            //   $("input[name='nomorantrian']").val( data.sukses );
            // } else if (data.msg) { 
            //   $('.overlay').addClass('hidden')
            //   alert(data.msg)
            // }
          }
        });
      });

    });


  </script>
@endsection
