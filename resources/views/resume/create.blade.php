@extends('master')

@section('header')
  <h1>Pembuatan Rencana Kontrol</h1>
  <style>
    /* Warna merah untuk tanggal merah yang di-disable */
.libur-merah.disabled,
.libur-merah span,
.libur-merah {
    color: red !important;
    font-weight: bold;
    opacity: 1 !important; /* supaya tidak pudar */
}

/* Jika ingin background juga agak beda */
.libur-merah.disabled.active,
.libur-merah:hover {
    background-color: #ffe6e6 !important;
}
  </style>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: 175px;">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="widget-user-username">Nama</h4>
                                <h5 class="widget-user-desc">No. RM</h5>
                                <h5 class="widget-user-desc">Alamat</h5>
                                <h5 class="widget-user-desc">Cara Bayar</h5>
                                <h5 class="widget-user-desc">DPJP</h5>
                                <h5 class="widget-user-desc">Kunjungan</h5>
                                <h5 class="widget-user-desc">NO SEP</h5>
                            </div>
                            <div class="col-md-7">
                                <h3 class="widget-user-username">:{{ @$reg->pasien->nama}}</h3>
                                <h5 class="widget-user-desc">: {{ @$reg->pasien->no_rm }}</h5>
                                <h5 class="widget-user-desc">: {{ @$reg->pasien->alamat}}</h5>
                                <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                                <h5 class="widget-user-desc">: {{ baca_dokter($reg->dokter_id)}}</h5>
                                <h5 class="widget-user-desc">: {{ ($reg->jenis_pasien == 1) ? 'Baru' : 'Lama' }}</h5>
                            </div>
                            <div class="col-md-3 text-center"> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-user-image">

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ url('save-resume-medis') }}" id="formSK" class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('diagnosa_awal', null) !!}
                    <div class="form-group">
                        <label for="no_sep" class="col-md-2 control-label">NO.SEP</label>
                        <div class="col-md-3">
                            <input type="text" name="no_sep" value="{{$reg->no_sep}}" class="form-control" autocomplete="off" required>
                            <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                        </div> 
                    </div> 
                    <div class="form-group">
                        <label for="no_sep" class="col-md-2 control-label">NO.RUJUKAN</label>
                        <div class="col-md-3">
                            <input type="text" name="no_rujukan" value="{{@$histori_sep->no_rujukan}}" class="form-control" autocomplete="off" required>
                            <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                        </div> 
                    </div> 
                    <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">  
                        {!! Form::label('rencana_kontrol', 'Tgl.Rencana Kontrol', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::text('rencana_kontrol', @$tgl, ['class' => 'form-control date_tanpa_tanggal', 'id' => "rencana_kontrol",'autocomplete'=>"off"]) !!}
                            <small class="text-danger">{{ $errors->first('rencana_kontrol') }}</small>
                            
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">  
                        {!! Form::label('rencana_kontrol', 'Poli', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <select name="poli_id" class="form-control select2" style="width: 100%">
                            <option value=""></option> 
                            @foreach ($poli as $d) 
                                <option value="{{ $d->bpjs }}" {{$d->id == $reg->poli_id ? 'selected' :''}}>{{ $d->nama }}</option> 
                            @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="form-group{{ $errors->has('tujuanKunj') ? ' has-error' : '' }}">
                      {!! Form::label('tujuanKunj', 'Tujuan Kunjungan', ['class' => 'col-sm-2 control-label']) !!}
                      {{-- <label class="col-sm-4 control-label">Tujuan Kunjungan</label> --}}
                      <div class="col-sm-3">
                          {!! Form::select('tujuanKunj', ['0'=>'Normal','1'=>'Prosedur', '2'=>'Konsul Dokter'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                          <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('flagProcedure') ? ' has-error' : '' }}">
                      {!! Form::label('flagProcedure', 'Flag Procedure', ['class' => 'col-sm-2 control-label']) !!}
                      {{-- <label class="col-sm-4 control-label"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Diisi jika tujuan Kunjungan = Normal"></i>  Flag Procedure</label> --}}
                      
                      <div class="col-sm-3">
                          {!! Form::select('flagProcedure', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','0'=>'Prosedur Tidak Berkelanjutan','1'=>'Prosedur dan Terapi Berkelanjutan'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                          <small class="text-danger">{{ $errors->first('flagProcedure') }}</small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('kdPenunjang') ? ' has-error' : '' }}">
                      {!! Form::label('kdPenunjang', 'Penunjang', ['class' => 'col-sm-2 control-label']) !!}
                      <div class="col-sm-3">
                          {!! Form::select('kdPenunjang', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"--','1'=>'Radioterapi','2'=>'Kemoterapi','3'=>'Rehabilitasi Medik','4'=>'Rehabilitasi Psikososial','5'=>'Transfusi Darah','6'=>'Pelayanan Gigi'
                          ,'7'=>'Laboratorium','8'=>'USG','9'=>'Farmasi','10'=>'Lain-Lain','11'=>'MRI','12'=>'Hemodialisa' ], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                          <small class="text-danger">{{ $errors->first('kdPenunjang') }}</small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('assesmentPel') ? ' has-error' : '' }}">
                      {!! Form::label('assesmentPel', 'Assesment Pel.', ['class' => 'col-sm-2 control-label']) !!}
                      <div class="col-sm-3">
                          {!! Form::select('assesmentPel', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"-- ','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Tujuan Kontrol'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                          {{-- {!! Form::select('assesmentPel', [''=>'Tujuan Kontrol ','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Normal'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!} --}}
                          <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">  
                        {!! Form::label('kode_dokter', 'DPJP', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <select name="kode_dokter" class="form-control select2" style="width: 100%">
                            <option value=""></option> 
                            @foreach ($dokter as $d) 
                                <option value="{{ $d->kode_bpjs }}" {{$d->id == $reg->dokter_id ? 'selected' :''}}>{{ $d->nama }}</option> 
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">  
                        <div class="col-sm-2 control-label">
                            <button type="button" id="createSK" class="btn btn-primary btn-flat">BUAT NO.KNTRL</button>
                          </div>
                          <div class="col-sm-3" id="fieldSEP">
                              {!! Form::text('no_surat_kontrol', null, ['readonly'=>true,'class' => 'form-control', 'id'=>'noSk']) !!}
                              <small class="text-danger">{{ $errors->first('no_surat_kontrol') }}</small>
                          </div>
                    </div>
                    
                    <br>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                    </div>
                </form>
                <hr/> 
            </div>
        </div>

        <br />
        <div class="col-md-12 text-right">
            <table class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;" id="data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Kontrol</th>
                        <th>No. SEP</th>
                        <th>Poli</th>
                        <th>DPJP</th>
                        <th>Catatan</th>
                        <th>Tgl.Rencana Kontrol</th>
                        <th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rencana_kontrol as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->no_surat_kontrol }}</td>
                            <td>{{ $item->no_sep }}</td>
                            <td>{{ @baca_poli($item->poli_id) }}</td>
                            <td>{{ @baca_dokter($item->dokter_id) }}</td>
                            <td>-</td>
                            <td>{{ date('d-m-Y', strtotime($item->tgl_rencana_kontrol)) }}</td>
                            <td>
                                <a href="{{url('cetak-rencana-kontrol/' . $item->id)}}" class="btn btn-sm btn-warning">Cetak</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- CEK SEP --}}
      {{-- <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label text-right">Cari Rujukan:</label>
            <div class="col-sm-10 btn-group"> --}}
              {{-- <button type="button" onclick="nomorKartu()" class="btn btn-primary btn-flat">NOMOR KARTU </button> --}}
              {{-- <button type="button" onclick="nomorNik()" class="btn btn-danger btn-flat">NOMOR NIK</button> --}}
              {{-- <button type="button" onclick="nomorRujukan()" class="btn btn-success btn-flat">RUJUKAN PPK 1</button> --}}
              {{-- <button type="button" onclick="rujukanRS()" class="btn btn-warning btn-flat">PPK2 NOKA</button> --}}
              {{-- <button type="button" onclick="rujukanRSbyRujukan()" class="btn btn-danger btn-flat">PPK2 RUJUKAN</button> --}}
              {{-- <button type="button" onclick="postRawat()" class="btn btn-primary btn-flat">POST RAWAT</button> --}}
              {{-- <button type="button" onclick="postHD()" class="btn btn-danger btn-flat">POST HD</button> --}}
            {{-- </div>
          </div>
        </div>
      </div>
    <hr> --}}
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'save-data-sep', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
          <input type="hidden" name="nama_ppk_perujuk" value="">
          <input type="hidden" name="url" value="{{url()->full()}}">
          <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty(@$no_rm) ? @$no_rm : @$reg->pasien->no_rm }}" readonly="true" class="form-control">
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
                      <input type="text" name="nama" value="" readonly="true" class="form-control">
                      <small class="text-success">Nama Sesuai Nomor Kartu BPJS</small>
                      <small class="text-danger">{{ $errors->first('nama') }}</small>
                  </div>
              </div>
              @php
                  $nojkn = @$reg->pasien->no_jkn;
                  if($nojkn ==0 || $nojkn == ''){
                    $nojkn = @$reg->no_jkn;
                  }else{
                    $nojkn = @$reg->pasien->no_jkn;
                  }
              @endphp
              <div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
                {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                  <div class="input-group">
                    {!! Form::text('no_bpjs', @$reg->pasien->no_jkn, ['class' => 'form-control', 'placeholder' => 'Masukkan No. Kartu']) !!}
                    <span class="input-group-btn">
                      <button onclick="nomorKartu()" type="button" class="btn btn-success btn-flat">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : '', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
              </div>
              <input type="hidden" name="nik" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
              <input type="hidden" name="niks" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
              <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', null, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', null, ['class' => 'form-control','placeholder'=>'No.Rujukan']) !!}
                      <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-3">
                      {!! Form::text('ppk_rujukan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="nama_perujuk" value="" class="form-control">
                  
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
                      {!! Form::text('diagnosa_awal', null, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                      <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan', '1'=>'Rawat Inap'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
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
                      {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas : null, ['class' => 'form-control']) !!}
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
                      {!! Form::select('katarak', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
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
                  <small class="text-danger">Jenis Kunjungan Pilih <b>Kontrol</b>, jika pasien Kontrol</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('jenisKunjungan') ? ' has-error' : '' }}">
                {!! Form::label('jenisKunjungan', 'Jenis Kunjungan', ['class' => 'col-sm-4 control-label']) !!}
                @php
                    $jeniss = null;
                    if(@$no_surkon){
                      $jeniss = 3;
                    }
                @endphp
                <div class="col-sm-8">
                    {!! Form::select('jenisKunjungan', ['1'=>'Rujukan FKTP','2'=>'Rujukan Internal', '3'=>'Kontrol','4'=>'Rujukan Antar RS'], @$jeniss, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('jenisKunjungan') }}</small>
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
                  {!! Form::select('assesmentPel', [''=>'--Lewati Jika Tujuan Kunjungan "Normal"-- ','1'=>'Poli spesialis tidak tersedia pada hari sebelumnya','2'=>'Jam Poli telah berakhir pada hari sebelumnya', '3'=>'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya','4'=>'Atas Instruksi RS','5'=>'Tujuan Kontrol'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('tujuanKunj') }}</small>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                      @if ($d->bpjs == $poli_bpjs)
                         <option value="{{ $d->bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->bpjs }}">{{ $d->nama }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" value="{{@$no_surkon}}" class="form-control">
                  <small class="text-danger">Pastikan nomor sudah sesuai</small>
                </div>
              </div>
              <div class="form-group">
                <label for="dpjpLayanan" class="col-sm-4 control-label">Dokter Konsul</label>
                <div class="col-sm-8">
                  <select name="dpjpLayan" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ @$d->kode_bpjs }}" {{@$d->kode_bpjs == @$dokter_bpjs ? 'selected' :''}}>{{ @$d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                        <option value="{{ @$d->kode_bpjs }}" {{@$d->kode_bpjs == @$dokter_bpjs ? 'selected' :''}}>{{ @$d->nama }}</option>
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
            </div>
              <input style="margin-left:100px;" type="checkbox" name="billing" value="1" checked> Dengan Billing Retribusi
              <div class="btn-group pull-right">
                  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
            </div>
          </div><br/>
      {!! Form::close() !!} --}}
  </div>
  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD9</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
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
  
  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD10</h4>
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
          {{-- <form method="POST" id="formPencarian"> --}}
            {{ csrf_field() }}
            <div class="form-group">
              <label for="judul" class="col-sm-3 control-label judul"></label>
              <div class="col-sm-9 formInput">

              </div>
            </div>
          {{-- </form> --}}
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
                <th>Status</th><td class="status" style="font-weight:900;"></td>
              </tr>
              <tr>
                <th>Peserta</th><td class="jenisPeserta"></td>
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
          <p class="text-center text-danger statusError" style="font-weight: bold"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">TUTUP</button>
          <button type="button" class="btn btn-primary btn-flat save">CARI</button>
          <button type="button" class="btn btn-success btn-flat lanjut hidden" data-dismiss="modal">LANJUT</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2();
        $.getJSON("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json", function (data) {
          const tanggalMerah = Object.keys(data)
              .filter(key => data[key].holiday === true)
              .map(key => {
                  const [y, m, d] = key.split("-");
                  return `${d}-${m}-${y}`;
              });

          $(".date_tanpa_tanggal").datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              todayHighlight: true,
              beforeShowDay: function (date) {
                  const d = ("0" + date.getDate()).slice(-2);
                  const m = ("0" + (date.getMonth() + 1)).slice(-2);
                  const y = date.getFullYear();
                  const dateStr = `${d}-${m}-${y}`;
                  const day = date.getDay(); // 0 = Minggu

                  // Hari Minggu
                  if (day === 0) {
                      return {
                          enabled: false,
                          classes: "libur-merah",
                          tooltip: "Hari Minggu"
                      };
                  }

                  // Tanggal merah nasional
                  if (tanggalMerah.includes(dateStr)) {
                      return {
                          enabled: false,
                          classes: "libur-merah",
                          tooltip: data[`${y}-${m}-${d}`]?.description || "Tanggal Merah"
                      };
                  }

                  return true;
              }
          });
      });
        $("#date_dengan_tanggal").attr('required', true);
        
        $('#createSK').on('click', function () {
        $("input[name='no_surat_kontrol']").val( ' ' );
        $.ajax({
          url : '{{ url('/bridgingsep/buat-surat-kontrol') }}',
          type: 'POST',
          data: $("#formSK").serialize(), 
          processing: true,
        })
        .done(function(res) {
            data = JSON.parse(res) 
            if (data[0].metaData.code !== "200") {
                return alert(data[0].metaData.message)
            } 
            $("input[name='no_surat_kontrol']").val( data[1].noSuratKontrol ); 
            $("input[name='diagnosa_awal']").val( data[1].namaDiagnosa ); 
        });
      }); 

      $( function() {
        $( ".tanggalSEP" ).datepicker({
          format: "yyyy-mm-dd",
          todayHighlight: true,
          autoclose: true
        });

      });

      function nomorKartu() {

      if($('input[name="no_bpjs"]').val() == '' ){
        return swal("Gagal", 'NO. JKN Wajib diisi untuk cek PREMI', "error");
      }
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Cek Premi Peserta berdasarkan Nomor Kartu')
      // $('.judul').text('Nomor NIK')
      $('.formInput').empty()
      // $('.formInput').append('<input type="text" name="no_nik" class="form-control" value="'+niks+'">')
      $('.tableStatus').addClass('hidden')
      // alert($('input[name="no_jkn"]').val());
      // return
      $.ajax({
        url: '/cari-sep/noka-igd',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_bpjs"]').val()),
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
        console.log(data)
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
          $('.jenisPeserta').text(data[1].peserta.jenisPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data[1].peserta.provUmum.kode)
          //FORM
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_bpjs"]').val(data[1].peserta.noKartu)
          $('input[name="nik"]').val(data[1].peserta.nik)
          $('input[name="nohp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="umr"]').val(data[1].peserta.umur.umurSekarang)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="ppk_rujukan"]').val(data[1].peserta.provUmum.kdProvider)
          $('select[name="kelamin"]').val(data[1].peserta.sex).trigger('change')
          $('select[name="jkn"]').val(data[1].peserta.jenisPeserta.keterangan).trigger('change')
          $('input[name="tgllahir"]').val($.datepicker.formatDate('dd-mm-yy', new Date(data[1].peserta.tglLahir)))
          
        }

      });
      $('.save').attr('onclick', 'cariNIK()');
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

    });
    </script>
@endsection
