@extends('master')
@section('header')
  <h1>Form Pembuatan SEP<small></small></h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- CEK SEP --}}

      {{--  --}}
    <hr>
      {!! Form::open(['method' => 'POST', 'url' => 'simpan-no-sep', 'class' => 'form-horizontal']) !!}
          {{-- <input type="hidden" name="no_rm" value="{{ !empty(@$no_rm) ? @$no_rm : @$reg->pasien->no_rm }}"> --}}
          <input type="hidden" name="nama_ppk_perujuk" value="">
          <input type="hidden" name="registrasi_id">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ @$errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty(@$no_rm) ? @$no_rm : @$reg->pasien->no_rm }}" readonly="true" class="form-control">
                      <small class="text-danger">{{ @$errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('nama', 'Nama', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="nama" readonly="true" class="form-control">
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('no_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_bpjs', NULL, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('no_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty(@$reg->pasien->nohp) ? @$reg->pasien->nohp : '', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('no_tlp') }}</small>
                  </div>
              </div>
              <input type="hidden" name="nik" value="{{ !empty(@$reg->pasien->nik) ? @$reg->pasien->nik : NULL }}">
              <div class="form-group{{ @$errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', null, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ @$errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('no_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-3">
                      {!! Form::text('ppk_rujukan', !empty(@$kd_ppk) ? @$kd_ppk : null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('ppk_rujukan') }}</small>
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="nama_perujuk" value="" class="form-control">
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('catatan_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('catatan_bpjs', '-', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('catatan_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                  {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('diagnosa_awal', null, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                      <small class="text-danger">{{ @$errors->first('diagnosa_awal') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan','1'=>'Rawat Inap'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ @$errors->first('jenis_layanan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ @$errors->first('asalRujukan') }}</small>
                  </div>
              </div>

              <div class="form-group{{ @$errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('hak_kelas_inap', !empty(@$hak_kelas) ? @$hak_kelas : null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ @$errors->first('hak_kelas_inap') }}</small>
                  </div> 
              </div>
              <div class="form-group{{ @$errors->has('hak_kelas_inap_naik') ? ' has-error' : '' }}">
                {!! Form::label('hak_kelas_inap_naik', 'Hak Kelas Naik', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('hak_kelas_inap_naik', !empty(@$hak_kelas_inap_naik) ? @$hak_kelas_inap_naik : '', ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ @$errors->first('hak_kelas_inap_naik') }}</small>
                </div>
            </div>
            <div class="form-group{{ @$errors->has('pembiayaan') ? ' has-error' : '' }}">
              {!! Form::label('pembiayaan', 'Pembiayaan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::select('pembiayaan', [''=>'','1'=>'Pribadi', '2'=>'Pemberi Kerja','3'=>'Asuransi Kesehatan Tambahan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                  <small class="text-danger">{{ @$errors->first('pembiayaan') }}</small>
              </div>
            </div>

              <div class="form-group{{ @$errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ @$errors->first('cob') }}</small>
                  </div>
              </div>
              <div class="form-group{{ @$errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('katarak', ['1'=>'Tidak', '0'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ @$errors->first('katarak') }}</small>
                  </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                <div class="col-sm-8">
                  <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                </div>
              </div>
              {{-- <div class="form-group{{ @$errors->has('jenis_layanan') ? ' has-error' : '' }}">
                {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('jenis_layanan', ['1'=>'Rawat Inap'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('jenis_layanan') }}</small>
                </div>
            </div> --}}
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ !empty(@$reg->tipe_jkn) ? @$reg->tipe_jkn : NULL }}" readonly="true" class="form-control">
                </div>
              </div>
              <div class="form-group{{ @$errors->has('jenisKunjungan') ? ' has-error' : '' }}">
                {!! Form::label('jenisKunjungan', 'Jenis Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
                <div class="col-sm-8">
                    {!! Form::select('jenisKunjungan', ['1'=>'Rujukan FKTP','2'=>'Rujukan Internal', '3'=>'Kontrol','4'=>'Rujukan Antar RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('jenisKunjungan') }}</small>
                </div>
              </div>
              <div class="form-group{{ @$errors->has('tujuanKunj') ? ' has-error' : '' }}">
                {!! Form::label('tujuanKunj', 'Tujuan Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
                <div class="col-sm-8">
                    {!! Form::select('tujuanKunj', ['0'=>'Konsul Dokter','1'=>'Prosedur', '2'=>'Normal'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group{{ @$errors->has('flagProcedure') ? ' has-error' : '' }}">
                {!! Form::label('flagProcedure', 'Flag Procedure', ['class' => 'col-sm-4 control-label']) !!}
                {{-- <label class="col-sm-4 control-label"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Diisi jika tujuan Kunjungan = Normal"></i>  Flag Procedure</label> --}}
                
                <div class="col-sm-8">
                    {!! Form::select('flagProcedure', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','0'=>'Prosedur Tidak Berkelanjutan','1'=>'Prosedur dan Terapi Berkelanjutan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('flagProcedure') }}</small>
                </div>
              </div>
              <div class="form-group{{ @$errors->has('kdPenunjang') ? ' has-error' : '' }}">
                {!! Form::label('kdPenunjang', 'Penunjang', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('kdPenunjang', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','1'=>'Radioterapi','2'=>'Kemoterapi','3'=>'Rehabilitasi Medik','4'=>'Rehabilitasi Psikososial','5'=>'Transfusi Darah','6'=>'Pelayanan Gigi'
                    ,'7'=>'Laboratorium','8'=>'USG','9'=>'Farmasi','10'=>'Lain-Lain','11'=>'MRI','12'=>'Hemodialisa' ], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('kdPenunjang') }}</small>
                </div>
              </div>
              <div class="form-group{{ @$errors->has('assesmentPel') ? ' has-error' : '' }}">
                {!! Form::label('assesmentPel', 'Assesment Pel.', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('assesmentPel', ['0'=>'Tujuan Kontrol ','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Normal'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ @$errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    {{-- @foreach ($poli as $d)
                      @if ($d->bpjs == $poli_bpjs)
                         <option value="{{ @$d->bpjs }}" selected="true">{{ @$d->nama }}</option>
                      @else
                        <option value="{{ @$d->bpjs }}">{{ @$d->nama }}</option>
                      @endif
                    @endforeach --}}
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
                    {{-- @foreach (@$dokter as $d)
                      @if (@$d->kode_bpjs == @$dokter_bpjs)
                        <option value="{{ @$d->kode_bpjs }}" selected="true">{{ @$d->nama }}</option>
                      @else
                        <option value="{{ @$d->kode_bpjs }}">{{ @$d->nama }}</option>
                      @endif

                    @endforeach --}}
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    {{-- @foreach (@$dokter as $d)
                      @if (@$d->kode_bpjs == @$dokter_bpjs)
                        <option value="{{ @$d->kode_bpjs }}" selected="true">{{ @$d->nama }}</option>
                      @else
                        <option value="{{ @$d->kode_bpjs }}">{{ @$d->nama }}</option>
                      @endif

                    @endforeach --}}
                  </select>
                </div>
              </div>
              <div class="form-group">
                {{-- @php
                    @$url = '"'.url('/bridgingsep/jadwal-dokter-hfis').'"';
                @endphp --}}
                <label for="poliTujuan" class="col-sm-4 control-label">Jam Praktek<br><a style="cursor: pointer" width=790,height=400,scrollbars=2)'><i>Lihat jam praktek</i></a></label>
                <div class="col-sm-3">
                  {!! Form::text('jam_start', null, ['class' => 'form-control timepicker']) !!}
                </div>
                <label for="jam" class="col-sm-1 control-label">S/D</label>
                <div class="col-sm-3">
                  {!! Form::text('jam_end', null, ['class' => 'form-control timepicker']) !!}
                </div>
              </div>
              <div class="form-group{{ @$errors->has('laka_lantas') ? ' has-error' : '' }}">
                  {!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ @$errors->first('laka_lantas') }}</small>
                  </div>
              </div>
              <div class="laka hidden">
                  <div class="form-group{{ @$errors->has('penjamin') ? ' has-error' : '' }}">
                      {!! Form::label('penjamin', 'Penjamin', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('penjamin', ['1'=>'Jasa Raharja', '2'=>'BPJS Ketenagakerjaan', '3'=>'TASPEN', '4'=>'ASABRI'], null, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ @$errors->first('penjamin') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('tglKejadian') ? ' has-error' : '' }}">
                      {!! Form::label('tglKejadian', 'Tanggal Kejadian Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('tglKejadian', null, ['class' => 'form-control datepicker', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ @$errors->first('tglKejadian') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('kll') ? ' has-error' : '' }}">
                      {!! Form::label('kll', 'Ket Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('kll', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ @$errors->first('kll') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('suplesi') ? ' has-error' : '' }}">
                      {!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], 0, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ @$errors->first('suplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('noSepSuplesi') ? ' has-error' : '' }}">
                      {!! Form::label('noSepSuplesi', 'No. SEP Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('noSepSuplesi', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ @$errors->first('noSepSuplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('kdPropinsi') ? ' has-error' : '' }}">
                      {!! Form::label('kdPropinsi', 'Propinsi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdPropinsi" id="regency_id" style="width:100%">
                            <option value=""></option>
                            {{-- @foreach (@$bpjsprov as $i)
                            <option value="{{ @$i->kode }}"> {{ @$i->propinsi }}</option>
                                
                            @endforeach --}}
                        </select>
                          <small class="text-danger">{{ @$errors->first('kdPropinsi') }}</small>
                      </div>
                  </div>
                  
                  <div class="form-group{{ @$errors->has('kdKabupaten') ? ' has-error' : '' }}">
                      {!! Form::label('kdKabupaten', 'Kabupaten', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKabupaten" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ @$errors->first('kdKabupaten') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ @$errors->has('kdKecamatan') ? ' has-error' : '' }}">
                      {!! Form::label('kdKecamatan', 'Kecamatan', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKecamatan" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ @$errors->first('kdKecamatan') }}</small>
                      </div>
                  </div>
              </div>
             
              <div class="form-group{{ @$errors->has('no_sep') ? ' has-error' : '' }}">
                  <div class="col-sm-4 control-label">
                    <button type="button" id="createSEP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SEP</button>
                  </div>
                  <div class="col-sm-8" id="fieldSEP">
                      {!! Form::text('no_sep', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                      <small class="text-danger">{{ @$errors->first('no_sep') }}</small>
                  </div>
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
                  <th>Kartu</th>
                  <th>JK</th>
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
@endsection

@section('script')
  {{-- <script language="javascript" src="/lz-string.js"></script> --}}
 

@endsection
