<form method="POST" id="Register" class="form-horizontal">
  {{ csrf_field() }} {{ method_field('POST') }}
  {!! Form::hidden('registrasi_id', null) !!}
  {!! Form::hidden('carabayar_id', null) !!}
<div class="row">
  <div class="col-md-6">
    <div class='form-group'>
      <label for='pasien' class="col-md-3 control-label">Pasien</label>
      <div class="col-md-9">
        <input type="text" name="namaPasien" class="form-control" value="" readonly="true" >
      </div>
    </div>
    <div class='form-group'>
      <label for='pasien' class="col-md-3 control-label">No. RM</label>
      <div class="col-md-9">
        <input type="text" name="no_rm" class="form-control" value="" readonly="true">
      </div>
    </div>
    <div class='form-group'>
      <label for='pasien' class="col-md-3 control-label">Cara Bayar</label>
      <div class="col-md-9">
        <input type="text" name="caraBayar" class="form-control" value="" disabled>
      </div>
    </div>
    <div class="form-group" id="dokter_konsul">
      {!! Form::label('dokter_id', 'Dokter Konsul', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          <select name="dpjpLayan" class="form-control select2" style="width:100%">
            <option value=""></option>
            @foreach ($dokter as $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="dokter_idError"></small>

      </div>
  </div>
    <div class="form-group" id="dokter_idGroup">
        {!! Form::label('dokter_id', 'DPJP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select name="dokter_id" class="form-control select2" style="width:100%">
              <option value=""></option>
              @foreach ($dokter as $d)
                <option value="{{ $d->id }}">{{ $d->nama }}</option>
              @endforeach
            </select>
            <small class="text-danger" id="dokter_idError"></small>

        </div>
    </div>

  </div>
  <div class="col-md-6">
    <div class="form-group" id="kelompokkelas_idGroup">
        {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" style="width:100%;" name="kelompokkelas_id">
              <option value=""></option>
              @foreach (App\Kelompokkelas::all() as $d)
                <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
              @endforeach
            </select>
            <small class="text-danger" id="kelompokkelas_idError"></small>
        </div>
    </div>
    <div class="form-group" id="kelas_idGroup">
        {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" style="width:100%" name="kelas_id">
            </select>
            <small class="text-danger" id="kelas_idError"></small>
        </div>
    </div>
    <div class="form-group" id="kamaridGroup">
        {!! Form::label('kamarid', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" style="width:100%" name="kamarid">
            </select>
            <small class="text-danger" id="kamaridError"></small>
        </div>
    </div>
    <div class="form-group " id="bedID">
        {!! Form::label('bed_id', 'Bed', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" style="width:100%" name="bed_id">
            </select>
            <small class="text-danger"><p id="bed_id-error"></p></small>
        </div>
    </div>
    <div class="form-group " id="keterangan">
      {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          <input type="text" name="keterangan" class="form-control">
          <small class="text-danger"><p id="keterangan-error"></p></small>
      </div>
     </div>
    <div class="form-group " id="tgl_masukID">
          {!! Form::label('tgl_masuk', 'Tanggal Inap', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::text('tgl_masuk', NULL, ['class' => 'form-control tanggalSEP']) !!}
            <small class="text-danger"><p id="tgl_masuk-error"></p></small>
              
          </div>
      </div>

  </div>
</div>

  {{-- Tampilkan Jika Pasien JKN --}}
  <div class="hidden" id="pasienJKN">
    {{-- progress bar --}}
     <div class="progress progress-sm active hidden">
        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          <span class="sr-only">97% Complete</span>
        </div>
      </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group " id="statusNik">
            {!! Form::label('nik', 'NIK', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('nik', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('nik') }}</small>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-primary btn-flat" id="cekNik"><i class="fa fa-search"></i> CARI</button>
            </div>
        </div>
         <div class="form-group " id="statusNoJKN">
            {!! Form::label('no_bpjs', 'Nomor JKN', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('no_bpjs', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-success btn-flat" id="cekStatus"><i class="fa fa-search"></i> CARI</button>
            </div>
        </div>

         <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            {!! Form::label('nama', 'Nama di Kartu', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('nama', NULL, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-success"> Nama sesuai BPJS</small>
            </div>
        </div>
       
        <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
            {!! Form::label('no_tlp', 'Nomor HP', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('no_tlp', NULL, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('noSurat') ? ' has-error' : '' }}">
            {!! Form::label('noSurat', 'Nomor SPRI', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('noSurat', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('noSurat') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
            {!! Form::label('no_rujukan', 'Nomor Rujukan', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('no_rujukan', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
            {!! Form::label('tgl_rujukan', 'Tanggal Rujukan', ['class' => 'col-sm-4 control-label ']) !!}
            <div class="col-sm-8">
                {!! Form::text('tgl_rujukan', date('Y-m-d'), ['class' => 'form-control tanggalSEP']) !!}
                <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
            </div>
        </div>

   {{--      <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
            {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('ppk_rujukan', config('app.sep_ppkLayanan'), ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
            </div>
        </div> --}}

        <input type="hidden" name="ppk_rujukan" value="{{ config('app.sep_ppkLayanan') }}">

        <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
            {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('diagnosa_awal', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
            {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::select('katarak', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                <small class="text-danger">{{ $errors->first('katarak') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
          {!! Form::label('catatan', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('catatan_bpjs', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('kelas_hak') ? ' has-error' : '' }}">
            {!! Form::label('hak_kelas_inap', 'Kelas Hak', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas : null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
            </div>
        </div>


      </div>
      <div class="col-md-6">
        <input type="hidden" name="jenis_layanan" value="1">
        <input type="hidden" name="poli_bpjs" value="">
        <input type="hidden" name="penjamin" value="">
        <input type="hidden" name="tglKejadian" value="">
        <input type="hidden" name="kll" value="">
        <input type="hidden" name="noSepSuplesi" value="">
        <input type="hidden" name="kdPropinsi" value="">
        <input type="hidden" name="kdKabupaten" value="">
        <input type="hidden" name="kdKecamatan" value="">
        <input type="hidden" name="kodeDPJP" value="">


       {{--  <div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], 2, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                    <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                </div>
            </div> --}}
        <input type="hidden" name="asalRujukan" value="2">

        
        <div class="form-group{{ $errors->has('hak_kelas_inap_naik') ? ' has-error' : '' }}">
          {!! Form::label('hak_kelas_inap_naik', 'Hak Kelas Naik', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('hak_kelas_inap_naik', !empty($hak_kelas_inap_naik) ? $hak_kelas_inap_naik : null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('hak_kelas_inap_naik') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('pembiayaan') ? ' has-error' : '' }}">
          {!! Form::label('pembiayaan', 'Pembiayaan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::select('pembiayaan', ['','1'=>'Pribadi', '2'=>'Pemberi Kerja','3'=>'Asuransi Kesehatan Tambahan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('pembiayaan') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('jenisKunjungan') ? ' has-error' : '' }}">
          {!! Form::label('jenisKunjungan', 'Jenis Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
          {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
          <div class="col-sm-8">
              {!! Form::select('jenisKunjungan', ['1'=>'Rujukan FKTP','2'=>'Rujukan Internal', '3'=>'Kontrol','4'=>'Rujukan Antar RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('jenisKunjungan') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('tgl_sep') ? ' has-error' : '' }}">
            {!! Form::label('tglSep', 'Tgl SEP', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                <input type="text" name="tglSep" value="{{ date('Y-m-d') }}" class="form-control tanggalSEP">
                <small class="text-danger">{{ $errors->first('tglSep') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('suplesi') ? ' has-error' : '' }}">
            {!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                <small class="text-danger">{{ $errors->first('suplesi') }}</small>
            </div>
        </div>

        <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
            {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                <small class="text-danger">{{ $errors->first('cob') }}</small>
            </div>
        </div>
        <div class="form-group{{ $errors->has('tujuanKunj') ? ' has-error' : '' }}">
          {!! Form::label('tujuanKunj', 'Tujuan Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::select('tujuanKunj', ['0'=>'Normal','1'=>'Prosedur', '2'=>'Konsul Dokter'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('flagProcedure') ? ' has-error' : '' }}">
          {!! Form::label('flagProcedure', 'Flag Procedure', ['class' => 'col-sm-4 control-label']) !!}
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
              {!! Form::select('assesmentPel', [""=>'-- Pilih --','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('assesmentPel') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('laka_lantas') ? ' has-error' : '' }}">
                {!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                    <small class="text-danger">{{ $errors->first('laka_lantas') }}</small>
                </div>
            </div>
        <div class="form-group " id="fieldSEP">
            <div class="col-sm-4 control-label">
              <button type="button" id="createSEP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SEP </button>
            </div>
            <div class="col-sm-8">
                {!! Form::text('no_sep', null, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('no_sep') }}</small>
            </div>
        </div>

      </div>
    </div>

  </div>
   <div class="btn-group pull-right" >
    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
    <button type="button" id="submitForm" class="btn btn-success btn-flat">Simpan</button>
  </div>
  <div class="clearfix">

  </div>

{!! Form::close() !!}

