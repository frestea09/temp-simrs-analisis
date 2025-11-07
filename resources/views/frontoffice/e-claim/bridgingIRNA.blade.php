@extends('master')

@section('header')
  <h1>Bridging INACBG E-Klaim Rawat Inap <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Data Pasien</h4>
    </div>
    <div class="box-body">
      @php
        $coder = !empty(Auth::user()->coder_nik) ? Auth::user()->coder_nik : config('app.coder_nik');
      @endphp
      {!! Form::open(['method' => 'POST', 'url' => 'newclaim-irna', 'class' => 'form-horizontal', 'id'=>'formINACBG']) !!}
          {!! Form::hidden('registrasi_id', $reg->registrasi_id) !!}
          {!! Form::hidden('gender', ($reg->pasien->kelamin == 'L') ? 1 : 2) !!}
          {!! Form::hidden('jenis_rawat', 1) !!}
          {!! Form::hidden('payor_id', 3) !!}
          {!! Form::hidden('payor_cd', 'JKN') !!}
          {!! Form::hidden('cob_cd', '-') !!}
          {!! Form::hidden('coder_nik', $coder) !!}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                  {!! Form::label('nama', 'Nama Pasien', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('nama', $reg->pasien->nama, ['class' => 'form-control', 'readonly'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('nama') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
                  {!! Form::label('tgllahir', 'Tgl Lahir', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgllahir', $reg->pasien->tgllahir, ['class' => 'form-control', 'readonly'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
                  {!! Form::label('umur', 'Umur', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('umur', hitung_umur($reg->pasien->tgllahir), ['class' => 'form-control', 'readonly'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('umur') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('birth_weight') ? ' has-error' : '' }}">
                  {!! Form::label('beratlahir', 'Berat Lahir', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('birth_weight', '0', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('birth_weight') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('nama_dokter') ? ' has-error' : '' }}">
                  {!! Form::label('nama_dokter', 'Dokter DPJP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('nama_dokter', Modules\Pegawai\Entities\Pegawai::pluck('nama','nama'), baca_dokter($reg->dokter_id), ['class' => 'form-control select2', 'style'=>'width: 100%;']) !!}
                      <small class="text-danger">{{ $errors->first('nama_dokter') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('discharge_status') ? ' has-error' : '' }}">
                  {!! Form::label('discharge_status', 'Cara Pulang', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('discharge_status', App\KondisiAkhirPasien::pluck('namakondisi', 'id'), 1, ['class' => 'form-control select2', 'style'=>'width: 100%;']) !!}
                      <small class="text-danger">{{ $errors->first('discharge_status') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('adl_sub_acute') ? ' has-error' : '' }}">
                  {!! Form::label('adl_sub_acute', 'ADL Sub Acute', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="adl_sub_acute" class="form-control select2" style="width: 100%">
                        <option value="-">-</option>
                        @for ($i = 12; $i <= 60 ; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                      <small class="text-danger">{{ $errors->first('adl_sub_acute') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('adl_chronic') ? ' has-error' : '' }}">
                  {!! Form::label('adl_chronic', 'ADL Chronic', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="adl_chronic" class="form-control select2" style="width: 100%">
                        <option value="-">-</option>
                        @for ($i = 12; $i <= 60 ; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                      <small class="text-danger">{{ $errors->first('adl_chronic') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('icu_indikator') ? ' has-error' : '' }}">
                  {!! Form::label('icu_indikator', 'Ada Rawat Intensif', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="icu_indikator" class="form-control select2" style="width: 100%">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                      </select>
                      <small class="text-danger">{{ $errors->first('icu_indikator') }}</small>
                  </div>
              </div>
              <div class="icu hidden">
                <div class="form-group{{ $errors->has('icu_los') ? ' has-error' : '' }}">
                    {!! Form::label('icu_los', 'Lama Perawatan ICU', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        <select name="icu_los" class="form-control select2" style="width: 100%">
                          <option value="-">-</option>
                          @for ($i = 0; $i <= 100 ; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                        <small class="text-danger">{{ $errors->first('icu_los') }}</small>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('ventilator_hour') ? ' has-error' : '' }}">
                    {!! Form::label('ventilator_hour', 'Ventilator (jam)', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        <select name="ventilator_hour" class="form-control select2" style="width: 100%">
                          @for ($i = 0; $i <= 1000 ; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                        <small class="text-danger">{{ $errors->first('ventilator_hour') }}</small>
                    </div>
                </div>
              </div>
              <div class="form-group" id="groupDiagnosa">
                  {!! Form::label('diagnosa', 'Diagnosa ICD10', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-6">
                      {!! Form::text('diagnosa', $diagnosa, ['class' => 'form-control']) !!}
                      <small class="text-danger" id="diagnosa-error"></small>
                  </div>
                  <div class="col-sm-2">
                      <button type="button" id="openICD10" class="btn btn-default">ICD10</button>
                  </div>
              </div>
              <div class="form-group" id="groupDiagnosa">
                {!! Form::label('sitb', 'SITB', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('sitb', NULL, ['class' => 'form-control','placeholder'=>"Masukkan No.SITB"]) !!}
                    <small class="text-danger" id="diagnosa-error"></small>
                </div>
                <div class="col-sm-2">
                    <button type="button" id="cekSitb" class="btn btn-primary btn-flat">CEK SITB</button>
                </div>
            </div>


            </div>
            {{-- =============================================================================================================== --}}
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rm', $reg->pasien->no_rm, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_masuk', 'Tgl Masuk', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_masuk', $reg->tgl_masuk, ['class' => 'form-control', 'required' => 'required']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tgl_pulang') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_pulang', 'Tgl Pulang', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_pulang', $reg->tgl_keluar, ['class' => 'form-control', 'required' => 'required']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_pulang') }}</small>
                  </div>
              </div>

              @php
                $tarif = Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->registrasi_id)->sum('total');
              @endphp
              <div class="form-group{{ $errors->has('tarif_rs') ? ' has-error' : '' }}">
                  {!! Form::label('tarif_rs', 'Tarif RS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tarif_rs', $tarif, ['class' => 'form-control', 'readonly'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('tarif_rs') }}</small>
                  </div>
              </div>
              <input type="hidden" name="kode_tarif" value="{{ config('app.tipe_RS') }}">
              
              <div class="form-group{{ $errors->has('upgrade_class_ind') ? ' has-error' : '' }}">
                  {!! Form::label('upgrade_class_ind', 'Naik/Turun Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="upgrade_class_ind" class="form-control select2" style="width: 100%">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                      </select>
                      <small class="text-danger">{{ $errors->first('upgrade_class_ind') }}</small>
                  </div>
              </div>
              <div class="kelasTujuan hidden">
                <div class="form-group{{ $errors->has('upgrade_class_class') ? ' has-error' : '' }}">
                    {!! Form::label('upgrade_class_class', 'Naik ke Kelas', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        <select name="upgrade_class_class" class="form-control select2" style="width: 100%">
                          <option value="kelas_1">Kelas 1</option>
                          <option value="kelas_2">Kelas 2</option>
                          <option value="vip">Kelas VIP</option>
                          <option value="vvip">Kelas VVIP</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('upgrade_class_class') }}</small>
                    </div>
                </div>
              </div>

              <div class="form-group{{ $errors->has('upgrade_class_los') ? ' has-error' : '' }}">
                  {!! Form::label('upgrade_class_los', 'Lama Hari Naik Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="upgrade_class_los" class="form-control select2" >
                        <option value="-">-</option>
                        @for ($i = 0; $i <= 25 ; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                      <small class="text-danger">{{ $errors->first('upgrade_class_los') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('add_payment_pct') ? ' has-error' : '' }}">
                  {!! Form::label('add_payment_pct', 'Urun Bayar (Rp.)', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-5">
                    <div class="input-group">
                      <div class="input-group-addon">
                      Rp.
                      </div>
                      <input type="text" name="urun_bayar_rupiah" class="form-control">
                    </div>
                      <input type="hidden" name="add_payment_pct" value="">
                      <small class="text-danger">{{ $errors->first('add_payment_pct') }}</small>
                  </div>
                  <div class="col-sm-3">
                    <div class="input-group">
                      <input type="text" name="urun_bayar_persen" class="form-control" >
                      <div class="input-group-addon">
                      %
                      </div>
                    </div>
                  </div>
              </div>
              @php
                  $pasien = Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
              @endphp
              <div class="form-group" id="groupNoKartu">
                  {!! Form::label('no_kartu', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_kartu', $pasien->no_jkn, ['class' => 'form-control']) !!}
                      <small id="no_kartu-error" class="text-danger"></small>
                  </div>
              </div>
              <div class="form-group" id="groupSEP">
                  {!! Form::label('no_sep', 'No. SEP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_sep', $reg->no_sep, ['class' => 'form-control']) !!}
                      <small id="no_sep-error" class="text-danger"></small>
                  </div>
              </div>

              @if ($reg->hak_kelas_inap == NULL)
                <div class="form-group" id="groupKelas">
                  {!! Form::label('no_sep', 'Kelas Rawat', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('kelas_rawat', [1=>1, 2=>2, 3=>3], $reg->hakkelas, ['class' => 'form-control select2']) !!}
                      <small id="hakkelas-error" class="text-danger"></small>
                  </div>
              </div>
              @else
              <div class="form-group" id="groupKelas">
                {!! Form::label('no_sep', 'Kelas Rawat', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {{-- {!! Form::select('kelas_rawat', [1=>1, 2=>2, 3=>3], $reg->hakkelas, ['class' => 'form-control select2']) !!} --}}
                    {!! Form::text('kelas_rawat', $reg->hak_kelas_inap, ['class' => 'form-control']) !!}
                    <small id="hakkelas-error" class="text-danger"></small>
                </div>
            </div>
              @endif
              

              <div class="form-group" id="groupProcedure">
                  {!! Form::label('procedure', 'Procedure ICD9', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-6">
                      {!! Form::text('procedure', $prosedur, ['class' => 'form-control']) !!}
                      <small class="text-danger" id="procedure-error"></small>
                  </div>
                  <div class="col-sm-2">
                      <button type="button" id="openICD9" class="btn btn-default">ICD9</button>
                  </div>
              </div>

            </div>
          </div>

          <div class="btn-group pull-left">
              <button type="button" class="btn btn-warning btn-flat" style="border-color:purple;background: purple !important" onclick="viewResume({{ $reg->id }})">RESUME</button>
              <button type="button" class="btn btn-danger btn-flat" onclick="viewSpri({{ $reg->id }})">SPRI</button>
          </div>
          <div class="btn-group pull-right">
              <a href="{{ url('frontoffice/e-claim/dataRawatInap') }}" class="btn btn-default">Batal</a>
              <button type="button" class="btn btn-warning btn-flat" onclick="viewTindakan({{ $reg->registrasi_id }})">TINDAKAN</button>
              <a href="{{ url('frontoffice/uploadDokument/'.$reg->registrasi_id) }}" class="btn btn-success btn-flat">UPLOAD</a>
              <button type="button" id="startBRIDGING" class="btn btn-primary">
                BRIDGING
              </button>
          </div>
      {!! Form::close() !!}

       <div class="clearfix"></div><hr>
      {{-- 1 -> 6 --}}
      <div class="col-sm-4">
        <div class="table-responsive bg-success">
          <table class="table table-hover table-condensed table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Tindakan</th>
                <th class="text-center">Harga</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mapping as $d)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $d->mapping}}</td>
                  <td class="text-right">
                    @if ($d->id == 5)
                      {{-- {{ number_format( \App\Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
                            ->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                            ->whereNotIn('masterobats.kategoriobat_id', [6, 8])
                            ->where('registrasi_id', $reg->registrasi_id)
                            ->sum('penjualandetails.hargajual') ) }} --}}
                      {{ number_format(Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total'))}}
                    @else

                      {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- 6 -> 12 --}}
      <div class="col-sm-4">
        <div class="table-responsive bg-warning">
          <table class="table table-hover table-condensed table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Tindakan</th>
                <th class="text-center">Harga</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mapping1 as $d)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $d->mapping}}</td>
                  <td class="text-right">
                    @if ($d->id == 11)
                      @php
                        $alkes_obat = \App\Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
                                          ->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                                          ->where('masterobats.kategoriobat_id', 6)
                                          ->where('registrasi_id', $reg->registrasi_id)
                                          ->sum('penjualandetails.hargajual');
                        $alkes_tarif = \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total');
                        $total_alkes = $alkes_obat + $alkes_tarif;
                      @endphp
                      {{ number_format($total_alkes) }}
                    @else
                      {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}

                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{-- 12 -> 18 --}}
      <div class="col-sm-4">
        <div class="table-responsive bg-danger">
          <table class="table table-hover table-condensed table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Tindakan</th>
                <th class="text-center">Harga</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mapping2 as $d)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $d->mapping}}</td>
                  <td class="text-right">
                    @if ($d->id == 16)
                        @php
                          $bmhp_obat = \App\Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
                                            ->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                                            ->where('masterobats.kategoriobat_id', 8)
                                            ->where('registrasi_id', $reg->registrasi_id)
                                            ->sum('penjualandetails.hargajual');
                          $bmhp_tarif = \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total');
                          $total_bmhp = $bmhp_obat + $bmhp_tarif;
                        @endphp
                        {{ number_format($total_bmhp) }}

                    @else
                      {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->registrasi_id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="overlay hidden">
          <i class="fa fa-refresh fa-spin"></i>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

{{-- Modal ICD9 --}}
  <div class="modal fade" id="icd9DATA" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id="icd9VIEW" class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Nama</th>
                  <th>Input</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- modal icd10 --}}
<div class="modal fade" id="icd10DATA" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <div class='table-responsive'>
          <table id="icd10VIEW" class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Input</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Sukses --}}
<div class="modal fade" id="suksesReturn" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered table-hover">
            <tbody>
              {{-- <tr>
                <th>Nomor SEP</th><td id="no_sep"></td>
              </tr> --}}
              <tr>
                <th>Total Biaya Perawatan</th><td id="total_rs"></td>
              </tr>
              <tr>
                <th>Total di Jamin INACBG</th><td id="dijamin"></td>
              </tr>
              <tr>
                <th>Kode Grouper</th><td id="kode"></td>
              </tr>
              <tr>
                <th>Deskripsi</th><td id="deskripsi_grouper"></td>
              </tr>
              <tr>
                <th>Final Klaim</th><td id="final_klaim"></td>
              </tr>
              <tr>
                <th>Kirim DC Kemenkes</th><td id="kirim_dc"></td>
              </tr>
              <tr>
                <th>Petugas Grouper</th><td id="who_update"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
          <div class="btn-group btn-group-sm">
            {{-- <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button> --}}
            <a href="" id="tombolCetak" class="btn btn-success btn-flat">CETAK BERKAS</a>
          </div>
      </div>
    </div>
  </div>
</div>

{{-- MODAL DETAIL TINDAKAN --}}
<div class="modal fade" id="modalTindakan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Tindakan</th>
                <th>Total</th>
                <th>Mapping</th>
              </tr>
            </thead>
            <tbody id="viewDetailTindakan">
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right totalTagihan"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

{{-- MODAL DETAIL RESUME --}}
<div class="modal fade" id="modalResume">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>No</th>
                <th style="text-align: center">Tekanan Darah</th>
                <th style="text-align: center">BB</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody id="viewDetailResume">
            </tbody> 
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

{{-- MODAL DETAIL SPRI --}}
<div class="modal fade" id="modalSpri">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed" style="font-size:12px;">
            <thead>
              <tr>
                <th>No</th>
                <th style="text-align: center">No.SPRI</th>
                <th style="text-align: center">Tgl. Rencana Kontrol</th>
                <th>Diagnosa</th>
                <th>Dr.Rawat</th>
                <th>Dr.Pengirim</th>
                <th>Jns.Kamar</th>
                <th>Bayar</th>
              </tr>
            </thead>
            <tbody id="viewDetailSpri">
            </tbody> 
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
  <script type="text/javascript">
    $('#cekSitb').on('click', function(){
      sitb = $('input[name="sitb"]').val();
      sep = $('input[name="no_sep"]').val();
      if(sitb == '' || sep == ''){
        return alert('Kolom SITB dan SEP harus diisi')
      }
      $.ajax({
            type: 'GET',
            url: '/cek-sitb/'+sitb+'/'+sep,
            // data: $('#formINACBG').serialize(),
            beforeSend: function (){
              $('.overlay').removeClass('hidden')
            },
            success: function (data) {
                // console.log(data)
                // return
                $('.overlay').addClass('hidden')
                if (data.errors) {
                    return alert('No register tidak valid')
                };

                if(data.sukses == 1) {
                  return alert('No register VALID')
                }
            }
        });
    })
    $('.select2').select2()

    $('select[name="icu_indikator"]').change(function(event) {
      event.preventDefault();
      var icu = $(this).val();
      if (icu == 0) {
        $('.icu').addClass('hidden')
      } else if (icu == 1) {
        $('.icu').removeClass('hidden')
      }
    });

    $('select[name="upgrade_class_ind"]').change(function(event) {
      event.preventDefault();
      var klsTujuan = $(this).val();
      if (klsTujuan == 0) {
        $('.kelasTujuan').addClass('hidden')
      } else if (klsTujuan == 1) {
        $('.kelasTujuan').removeClass('hidden')
      }
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

     function viewTindakan(registrasi_id) {
      $('#modalTindakan').modal('show')
      $('.modal-title').text('Detail Tindakan')
      $.ajax({
        url: '/frontoffice/e-claim/detailTindakan/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        // // return
        $('#viewDetailTindakan').empty()
        mapping = ''
        $.each(json.data, function(index, val) {
          
          if(val.tarif !== null){
            if(!val.tarif.mastermapping){
              mapping = '<small style="color:orange"><i><a style="color:orange" target="_blank" href="/mastermapping/edit-tarif?nama='+val.namatarif+'">Belum dimapping</a></i></small>'
            }else{
              mapping = val.tarif.mastermapping.mapping
            }
          }else{
            mapping = '<small style="color:orange"><i>Tarif Belum dimapping</i></small>'
          }
          
          $('#viewDetailTindakan').append('<tr> <td>'+(index+1)+'</td> <td>'+val.namatarif+'</td> <td class="text-right">'+ribuan(val.total)+'</td> <td>'+mapping+'</td> </tr>')
        });
        $('.totalTagihan').text(ribuan(json.total))
      });

    }

    $('#openICD9').on('click', function () {
      $("#icd9VIEW").DataTable().destroy();
      $('#icd9DATA').modal('show');
      $('.modal-title').text('Data Prosedure');
      $('#icd9VIEW').DataTable({
          "language": {
              "url": "/json/pasien.datatable-language.json",
          },

          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
          ordering: false,
          ajax: '/frontoffice/e-claim/get-icd9-data/inacbg',
          columns: [
              {data: 'nomor'},
              {data: 'nama'},
              {data: 'input', searchable: false}
          ]
      });
    });

    $(document).on('click', '.insert-prosedure', function (e) {
      var procedure = $('input[name="procedure"]').val();
      var input = $(this).attr('data-nomor');

      if( procedure != '' ) {
        $('input[name="procedure"]').val(procedure+'#'+input);
      } else {
        $('input[name="procedure"]').val(input);
      }
      $('#icd9DATA').modal('hide');
    });



  // ICD10
  $('#openICD10').on('click', function () {
    $("#icd10VIEW").DataTable().destroy();
    $('#icd10DATA').modal('show');
    $('.modal-title').text('Data Diagnosa');
    $('#icd10VIEW').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/frontoffice/e-claim/get-icd10-data/inacbg',
        columns: [
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'input', searchable: false}
        ]
    });
  });

  $(document).on('click', '.insert-diagnosa', function (e) {
    var diagnosa = $('input[name="diagnosa"]').val();
    var input = $(this).attr('data-nomor');

    if( diagnosa != '' ) {
      $('input[name="diagnosa"]').val(diagnosa+'#'+input);
    } else {
      $('input[name="diagnosa"]').val(input);
    }
    $('#icd10DATA').modal('hide');
  });

  </script>

<script type="text/javascript">

  $('#startBRIDGING').on('click', function () {
    $('.overlay').removeClass('hidden')
    $.ajax({
      url: '/newclaim-irna',
      type: 'POST',
      dataType: 'json',
      data: $('#formINACBG').serialize(),
    })
    .done(function(data) {
      $('.overlay').addClass('hidden')
      if (data.errors) {
          if(data.errors.no_kartu) {
              $('#no_kartu-error').html( data.errors.no_kartu[0] );
              $('#groupNoKartu').addClass('has-error');
          }

          if(data.errors.no_sep) {
              $('#no_sep-error').html( data.errors.no_sep[0] );
              $('#groupSEP').addClass('has-error');
          }

          if(data.errors.diagnosa) {
              $('#diagnosa-error').html( data.errors.diagnosa[0] );
              $('#groupDiagnosa').addClass('has-error');
          }

          if(data.errors.procedure) {
              $('#procedure-error').html( data.errors.procedure[0] );
              $('#groupProcedure').addClass('has-error');
          }
      };

       if(data.sukses == true) {
        $('#suksesReturn').modal('show');
        $('.modal-title').text('Bridging Sukses');
        $.ajax({
          url: '/eklaim-get-response/'+data.no_sep,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('#no_sep').html(data.no_sep)
            $('#total_rs').html('Rp. '+ ribuan(data.total_rs))
            $('#dijamin').html('Rp. '+ ribuan(data.dijamin))
            $('#kode').html(data.kode)
            $('#deskripsi_grouper').html(data.deskripsi_grouper)
            $('#final_klaim').html(data.final_klaim)
            $('#kirim_dc').text('Y')
            $('#who_update').html(data.who_update)
            $('#tombolCetak').attr('href', '/eklaim-detail-bridging/'+data.registrasi_id);
          }
        });
    }


    });

  })
   // VIEW RESUME
   function viewResume(registrasi_id) {
      $('#viewDetailResume').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
      $('#modalResume').modal('show')
      $('.modal-title').text('Detail Resume')
      $.ajax({
        url: '/frontoffice/e-claim/detailResume/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        $('#viewDetailResume').empty()
        if(json.total == 0){
          return $('#viewDetailResume').append('<tr><td colspan="7" class="text-center">Tidak ada Resume</td></tr>')
        }
        // console.log(json)
        $.each(json.data, function(index, val) {
          $('#viewDetailResume').append('<tr> <td>'+(index+1)+'</td> <td class="text-center">'+val.tekanandarah+'</td> <td class="text-center">'+val.bb+'</td> <td>'+val.diagnosa+'</td><td>'+val.tindakan+'</td><td>'+val.keterangan+'</td><td>'+val.created_at+'</td> </tr>')
        }); 
      });

    }
    
    // VIEW SPRI
    function viewSpri(registrasi_id) {
      $('#viewDetailSpri').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
      $('#modalSpri').modal('show')
      $('.modal-title').text('SPRI')
      $.ajax({
        url: '/frontoffice/e-claim/detailSpri/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        // console.log(json)
        $('#viewDetailSpri').empty()
        if(json.data == 0){
          return $('#viewDetailSpri').append('<tr><td colspan="7" class="text-center">Tidak ada SPRI</td></tr>')
        }
        $.each(json.data, function(index, val) {
          $('#viewDetailSpri').append('<tr> <td>'+(index+1)+'</td> <td class="text-center">'+val.no_spri+'</td> <td class="text-center">'+val.tgl_rencana_kontrol+'</td> <td>'+val.diagnosa+'</td><td>'+val.dokter_rawat+'</td><td>'+val.dokter_pengirim+'</td><td>'+val.kamar+'</td><td>'+val.cara_bayar+'</td> </tr>')
        }); 
      });

    }


    $('#closeModal').on('click', function() {
        $('input[name="diagnosa"]').val() = "";
        $('input[name="procedure"]').val() = "";
        $('input[name="no_kartu"]').val() = "";
        $('input[name="no_sep"]').val() = "";

        $('#no_kartu-error').html("");
        $('#groupNoKartu').removeClass('has-error');
        $('#no_sep-error').html("");
        $('#groupSEP').removeClass('has-error');
        $('#diagnosa-error').html("");
        $('#groupDiagnosa').removeClass('has-error');
        $('#procedure-error').html("");
        $('#groupProcedure').removeClass('has-error');

        $('#suksesReturn').modal('hide');
    })
</script>

@endsection
