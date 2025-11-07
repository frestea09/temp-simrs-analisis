@extends('master')
@section('header')
  <h1>Pendaftaran RANAP JKN</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pasien Baru &nbsp;

      </h3>
    </div>
    <div class="box-body">
      <form method="POST" id="Register" class="form-horizontal">
        {{ csrf_field() }} {{ method_field('POST') }}
        {!! Form::hidden('registrasi_id', $reg->id) !!}
        {!! Form::hidden('rawatinap_id', @$rawatinap->id) !!}
        {!! Form::hidden('carabayar_id', $reg->bayar) !!}
      <div class="row">
        <div class="col-md-6">
          <div class='form-group'>
            <label for='pasien' class="col-md-3 control-label">Pasien</label>
            <div class="col-md-9">
              <input type="text" name="namaPasien" value="{{$reg->nama}}" class="form-control" value="" readonly="true" >
            </div>
          </div>
          <div class='form-group'>
            <label for='pasien' class="col-md-3 control-label">No. RM</label>
            <div class="col-md-9">
              <input type="text" name="no_rm" value="{{$reg->no_rm}}" class="form-control" value="" readonly="true">
            </div>
          </div>
          <div class='form-group'>
            <label for='pasien' class="col-md-3 control-label">Cara Bayar</label>
            <div class="col-md-9">
              <input type="text" name="caraBayar" class="form-control" value="{{$reg->pembayaran}}" disabled>
            </div>
          </div>
          <div class="form-group" id="dokter_konsul">
            {!! Form::label('poli_id', 'SMF', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                <select name="poli_id" class="form-control select2" style="width:100%">
                  <option value=""></option>
                  @foreach ($poli as $d)
                    <option {{$reg->poli_id == $d->id ? 'selected' :''}} value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger" id="dokter_idError"></small>
      
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
          <div class="form-group" id="pagu_idGroup">
              {!! Form::label('pagu_perawatan_id', 'Biaya Diagnosa Awal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  <select name="pagu_perawatan_id" class="form-control select2" style="width:100%">
                    <option value=""></option>
                    @foreach ($pagu as $p)
                    <option value="{{ $p->id }}">{{ $p->diagnosa_awal }} (Rp. {{ number_format($p->biaya) }})</option>
                    @endforeach
                  </select>
                  <small class="text-danger" id="pagu_perawatan_idError"></small>
      
              </div>
          </div>
      
        </div>
        <div class="col-md-6">
          @if (!@$rawatinap)
              
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
          @else
              Ubah bed silahkan masuk ke perawat, menu <b><a href="{{url('/rawat-inap/mutasi/'.$reg->id)}}">Mutasi</a></b><br/>
          @endif
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
                    {!! Form::text('tgl_masuk', date('Y-m-d'), ['class' => 'form-control tanggalSEP']) !!}
                  <small class="text-danger"><p id="tgl_masuk-error"></p></small>
                    
                </div>
            </div>
      
        </div>
      </div>
      
        {{-- Tampilkan Jika Pasien JKN --}}
        @if ($reg->bayar ==1 || $reg->bayar ==7)
        <div class="" id="pasienJKN">
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
                      {!! Form::text('nik', @$reg->nik, ['class' => 'form-control nik']) !!}
                      <small class="text-danger">{{ $errors->first('nik') }}</small>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-primary btn-flat" id="cekNik"><i class="fa fa-search"></i> CARI</button>
                  </div>
              </div>
               <div class="form-group " id="statusNoJKN">
                  {!! Form::label('no_bpjs', 'Nomor JKN', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-5">
                      {!! Form::text('no_bpjs', @$reg->no_jkn, ['class' => 'form-control']) !!}
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
                    {!! Form::select(
                        'hak_kelas_inap_naik',
                        [
                            '' => '',
                            '3' => 'Kelas I',
                            '4' => 'Kelas II',
                            '5' => 'Kelas III',
                            '6' => 'ICCU',
                            '7' => 'ICU',
                            '8' => 'Di atas Kelas I',
                        ],
                        null,
                        ['class' => 'form-control select2', 'style' => 'width:100%'],
                    ) !!}
                    <small class="text-danger">{{ $errors->first('hak_kelas_inap_naik') }}</small>
                </div>
            </div>
              {{-- <div class="form-group{{ $errors->has('hak_kelas_inap_naik') ? ' has-error' : '' }}">
                {!! Form::label('hak_kelas_inap_naik', 'Hak Kelas Naik', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('hak_kelas_inap_naik', !empty($hak_kelas_inap_naik) ? $hak_kelas_inap_naik : null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('hak_kelas_inap_naik') }}</small>
                </div>
              </div> --}}
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
        {{-- MODAL DIAGNOSA --}}
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
        @endif

         <div class="btn-group pull-right" >
          {{-- <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button> --}}
          @if ($rawatinap)
            <button type="button" id="submitFormSusulan" class="btn btn-success btn-flat" >Simpan</button>
          @else
            <button type="button" id="submitForm" class="btn btn-success btn-flat">Simpan</button>
          @endif
        </div>
        <div class="clearfix">
      
        </div>
      
      {!! Form::close() !!}
      
      
    </div>
  </div>
@endsection

@push('js')
<script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
<script>
   $('.select2').select2();
   // Form Submit
  $('#submitForm').on('click', function () {
      $('#submitForm').prop('disabled', true);
      var registerForm = $("#Register");
      var formData = registerForm.serialize();
      $.ajax({
        url: '/rawatinap/save',
        type: 'POST',
        data: formData,
        success: function (data) {
          // console.log(data);
          if(data.errors) {
            if (data.errors.dokter_id) {
              $( '#dokter_idGroup' ).addClass('has-error')
              $( '#dokter_idError' ).html( data.errors.dokter_id[0] );
            }

            if (data.errors.kelompokkelas_id) {
              $( '#kelompokkelas_idGroup' ).addClass('has-error')
              $( '#kelompokkelas_idError' ).html( data.errors.kelompokkelas_id[0] );
            }
            if(data.errors.kelas_id){
              $( '#kelas_idGroup' ).addClass('has-error')
              $( '#kelas_idError' ).html( data.errors.kelas_id[0] );
            }
            if(data.errors.kamarid){
              $('#kamaridGroup').addClass('has-error');
              $('#kamaridError').html( data.errors.kamarid[0] );
            }
            if(data.errors.bed_id){
              $('#bedID').addClass('has-error');
              $( '#bed_id-error' ).html( data.errors.bed_id[0] );
            }

            if(data.errors.tgl_masuk){
              $('#tgl_masukID').addClass('has-error');
              $( '#tgl_masuk-error' ).html( data.errors.tgl_masuk[0] );
            }
          };

          if (data.success == 1) {
            location.href='/rawat-inap/admission';
            $('#antrianIRNA').modal('hide');
          }

          if(data.error == true){
            $('#error').html(data.pesan)
            $('#submitForm').prop('disabled', false);
          }

        }
      });
  });
  $('#submitFormSusulan').on('click', function () {
      $('#submitForm').prop('disabled', true);
      var registerForm = $("#Register");
      var formData = registerForm.serialize();
      $.ajax({
        url: '/admission/save-sep/irna',
        type: 'POST',
        data: formData,
        success: function (data) {
          if (data.success == 1) {
            alert('Berhasil simpan sep susulan Rawat Inap')
            location.href='/admission/sep-susulan/rawat-inap';
          }

          if(data.error == true){
            $('#error').html(data.pesan)
          }
          if(data.error == 'sep_kosong'){
            alert('Pastikan Nomor SEP tidak kosong!');
          }

        }
      });
  });
   $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });
    $( ".tanggalinap" ).datepicker({
    format: "yyyy-mm-dd hh:mm:ss ",
    todayHighlight: true,
    autoclose: true
  });
   $('select[name="kelompokkelas_id"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $(this).val();
    $.ajax({
      url: '/kamar/getkelas/'+kelompokkelas_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('select[name="kamarid"]').empty()
        $('select[name="kelas_id"]').empty()
        $('select[name="bed_id"]').empty()
        $('select[name="kelas_id"]').append('<option value=""></option>');
        $.each(data, function(key, value) {
            $('select[name="kelas_id"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
        });
      }
    })
  })

  $('select[name="kelas_id"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $(this).val();
    $.ajax({
      url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        $('select[name="bed_id"]').empty()
        $('select[name="kamarid"]').empty()
        $('select[name="kamarid"]').append('<option value=""></option>');
        $.each(data, function(key, value) {
            $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
        });
      }
    })
  })

  $('select[name="kamarid"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $('select[name="kelas_id"]').val()
    var kamar_id = $(this).val()
    $.ajax({
      url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('select[name="bed_id"]').empty()
        $.each(data, function(key, value) {
          $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
        });
      }
    })
  });
  function compressData(string){
      data = LZString.compressToEncodedURIComponent(string)
      return data
    }
    //CEK STATUS JKN
  $('input[name="no_bpjs"]').keyup(function() {
    $('#statusNoJKN').removeClass('has-error');
    $('#statusNoJKN').removeClass('has-success');
    $('input[name="nik"]').val('')
  });

  $('input[name="nik"]').keyup(function() {
    $('input[name="no_bpjs"]').val('')
  });
  //CEK NIK IRNA =================================================================================================
$('#cekNik').on('click',  function(e) {
  e.preventDefault();
  var nik = compressData($('input[name="nik"]').val())
  $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/cari-sep-irna/nik/'+nik,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        
        data = JSON.parse(res);
        
        if (data[0].metaData.code == 200) {
          $('#modalStatusJKN').modal('show')
          $('.statusJKNtitle').text('Status Kartu JKN')
          $('.nama').text(data[1].peserta.nama)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.nik').text(data[1].peserta.nik)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.dinsos').text(data[1].peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].peserta.informasi.prolanisPRB)
          $('#statusNoJKN').addClass('has-success')
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].peserta.noKartu)
        }

        if (data[0].metaData.code == 201) {
          alert(data[0].metaData.message)
        }

      });
});

//CEK NO KARTU JKN ===============================================================================================
  $('#cekStatus').on('click',  function(e) {
    e.preventDefault();
    var no_kartu = compressData($('input[name="no_bpjs"]').val())
    $.ajax({
      url: '/cari-sep-irna/noka/'+no_kartu,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('.progress').removeClass('hidden')
      },
      complete: function () {
        $('.progress').addClass('hidden')
      },
      success: function (res) {
        data = JSON.parse(res);
        console.log(data)
        if (data[0].metaData.code == 200) {
          $('#modalStatusJKN').modal('show')
          $('.statusJKNtitle').text('Status Kartu JKN')
          $('.nama').text(data[1].peserta.nama)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.nik').text(data[1].peserta.nik)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.dinsos').text(data[1].peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].peserta.informasi.prolanisPRB)
          $('#statusNoJKN').addClass('has-success')
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
        }

        if (data[0].metaData.code == 201) {
          alert(data[0].metaData.message)
        }

      }
    });

  });

  // ADD DIAGNOSA
  $('input[name="diagnosa_awal"]').focus(function(event) {
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

  //CREATE SEP
  $('#createSEP').on('click', function () {
        $.ajax({
          url : '{{ url('/buat-sep-inap') }}',
          type: 'POST',
          // data: $("#Register").serialize(),
          data:{
            data : LZString.compressToBase64($('#Register').serialize()),
            _token : $('input[name="_token"]').val(),
            _method : 'POST'
          },
          processing: true,
          beforeSend: function () {
            $('.progress').removeClass('hidden')
          },
          complete: function () {
            $('.progress').addClass('hidden')
          },
          success:function(data){
            // console.log(data);
            if(data.sukses){
              $('#fieldSEP').removeClass('has-error');
              $("input[name='no_sep']").val( data.sukses );
            } else if (data.msg) {
              alert(data.msg)
              // $('#fieldSEP').addClass('has-error');
              // $("input[name='no_sep']").val( data.msg );
            }
          }
        });
      });

</script>
@endpush