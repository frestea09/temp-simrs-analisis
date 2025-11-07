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
                $status_covid = ['Negatif', 'ODP', 'PDP', 'Positif', 'suspek', 'probabel'];
                $nomor_kartu_t = [
                    'nik',
                    'kitas',
                    'paspor',
                    'kartu_jkn',
                    'kk',
                    'unhcr',
                    'kelurahan',
                    'dinsos',
                    'dinkes',
                    'sjp',
                    'klaim_ibu',
                    'lainnya',
                ];
            @endphp
            {!! Form::open([
                'method' => 'POST',
                'url' => 'newclaim-irna',
                'class' => 'form-horizontal',
                'id' => 'formINACBG',
            ]) !!}
            {!! Form::hidden('registrasi_id', $reg->registrasi_id) !!}
            {!! Form::hidden('gender', $reg->pasien->kelamin == 'L' ? 1 : 2) !!}
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
                            {!! Form::text('nama', $reg->pasien->nama, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
                        {!! Form::label('tgllahir', 'Tgl Lahir', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('tgllahir', $reg->pasien->tgllahir, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
                        {!! Form::label('umur', 'Umur', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('umur', hitung_umur($reg->pasien->tgllahir), ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('umur') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birth_weight') ? ' has-error' : '' }}">
                        {!! Form::label('beratlahir', 'Berat Lahir', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('birth_weight', '0', [
                                'class' => 'form-control',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('birth_weight') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('nama_dokter') ? ' has-error' : '' }}">
                        {!! Form::label('nama_dokter', 'Dokter DPJP', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select(
                                'nama_dokter',
                                Modules\Pegawai\Entities\Pegawai::pluck('nama', 'nama'),
                                baca_dokter($reg->dokter_id),
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%;',
                                    'disabled' => @$klaim->status_step != null ? 'disabled' : null,
                                ]) !!}
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="nama_dokter" value="{{ @$klaim->dokter }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('nama_dokter') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('discharge_status') ? ' has-error' : '' }}">
                        {!! Form::label('discharge_status', 'Cara Pulang', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('discharge_status', App\KondisiAkhirPasien::pluck('namakondisi', 'id'), 1, [
                                'class' => 'form-control select2',
                                'style' => 'width: 100%;',
                                'disabled' => @$klaim->status_step != null ? 'disabled' : null,
                            ]) !!}
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="discharge_status" value="{{ @$klaim->cara_keluar }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('discharge_status') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('adl_sub_acute') ? ' has-error' : '' }}">
                        {!! Form::label('adl_sub_acute', 'ADL Sub Acute', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="adl_sub_acute" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                class="form-control select2" style="width: 100%">
                                <option value="-">-</option>
                                @for ($i = 12; $i <= 60; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="adl_sub_acute" value="{{ @$klaim->adl_sub_acute }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('adl_sub_acute') }}</small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('adl_chronic') ? ' has-error' : '' }}">
                        {!! Form::label('adl_chronic', 'ADL Chronic', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="adl_chronic" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                class="form-control select2" style="width: 100%">
                                <option value="-">-</option>
                                @for ($i = 12; $i <= 60; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="adl_chronic" value="{{ @$klaim->adl_chronic }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('adl_chronic') }}</small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('icu_indikator') ? ' has-error' : '' }}">
                        {!! Form::label('icu_indikator', 'Ada Rawat Intensif', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="icu_indikator" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                class="form-control select2" style="width: 100%">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="icu_indikator" value="{{ @$klaim->icu_indikator }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('icu_indikator') }}</small>
                        </div>
                    </div>
                    <div class="icu hidden">
                        <div class="form-group{{ $errors->has('icu_los') ? ' has-error' : '' }}">
                            {!! Form::label('icu_los', 'Lama Perawatan ICU', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                <select name="icu_los" {{ @$klaim->status_step != null ? 'readonly' : '' }}
                                    class="form-control select2" style="width: 100%">
                                    <option value="-">-</option>
                                    @for ($i = 0; $i <= 100; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger">{{ $errors->first('icu_los') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ventilator_hour') ? ' has-error' : '' }}">
                            {!! Form::label('ventilator_hour', 'Ventilator (jam)', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                <select name="ventilator_hour" {{ @$klaim->status_step != null ? 'readonly' : '' }}
                                    class="form-control select2" style="width: 100%">
                                    @for ($i = 0; $i <= 1000; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger">{{ $errors->first('ventilator_hour') }}</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="diagnosa" id="diagnosaInput" value="{{ $diagnosa ?? '' }}">
                    @if (@$klaim->status_step == null || empty(@$klaim))
                        <div class="form-group" id="groupDiagnosa">
                            {!! Form::label('diagnosa', 'Diagnosa ICD10 IDRG', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                <button type="button" id="openICD10" class="btn btn-default btn-flat">ICD10</button><br />
                                
                                <ul id="diagnosaList" class="list-group mb-2">
                                    @if (!empty($diagnosa))
                                        @foreach (explode('#', $diagnosa) as $kode)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <button {{ @$klaim->idrg_grouper == 4 ? 'disabled' : '' }} type="button"
                                                    class="btn btn-danger btn-sm remove-diagnosa"
                                                    data-code="{{ $kode }}">×</button>
                                                <span><strong>{{ $kode }}</strong> –
                                                    {{ baca_diagnosa($kode) }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif


                </div>
                {{-- =============================================================================================================== --}}
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                        {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('no_rm', $reg->pasien->no_rm, [
                                'class' => 'form-control',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
                        {!! Form::label('tgl_masuk', 'Tgl Masuk', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('tgl_masuk', $reg->tgl_masuk, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tgl_pulang') ? ' has-error' : '' }}">
                        {!! Form::label('tgl_pulang', 'Tgl Pulang', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('tgl_pulang', $reg->tgl_keluar, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tgl_pulang') }}</small>
                        </div>
                    </div>

                    @php
                        $tarif = Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->registrasi_id)->sum('total');
                    @endphp
                    <div class="form-group{{ $errors->has('tarif_rs') ? ' has-error' : '' }}">
                        {!! Form::label('tarif_rs', 'Tarif RS', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('tarif_rs', $tarif, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('tarif_rs') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('kode_tarif') ? ' has-error' : '' }}">
                          {!! Form::label('kode_tarif', 'Tipe RS', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                            <select name="kode_tarif" class="form-control select2" id="">
                              <option value="BP">TARIF RS KELAS B PEMERINTAH</option>
                              <option value="CP">TARIF RS KELAS C PEMERINTAH</option>
                              <option value="DP">TARIF RS KELAS D PEMERINTAH</option>
                              {{-- <option value="BP">BP</option> --}}
                            </select>
                            <small id="hakkelas-error" class="text-danger"></small>
                              <small class="text-danger">{{ $errors->first('kode_tarif') }}</small>
                          </div>
                      </div>
                    {{-- <input type="hidden" name="kode_tarif" value="{{ config('app.tipe_RS') }}"> --}}

                    <div class="form-group{{ $errors->has('upgrade_class_ind') ? ' has-error' : '' }}">
                        {!! Form::label('upgrade_class_ind', 'Naik/Turun Kelas', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="upgrade_class_ind" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                class="form-control select2" style="width: 100%">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="upgrade_class_ind" value="{{ @$klaim->upgrade_class_ind }}">
                            @endif
                            <small class="text-danger">{{ $errors->first('upgrade_class_ind') }}</small>
                        </div>
                    </div>
                    <div class="kelasTujuan hidden">
                        <div class="form-group{{ $errors->has('upgrade_class_class') ? ' has-error' : '' }}">
                            {!! Form::label('upgrade_class_class', 'Naik ke Kelas', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                <select name="upgrade_class_class" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                    class="form-control select2" style="width: 100%">
                                    <option value="kelas_1">Kelas 1</option>
                                    <option value="kelas_2">Kelas 2</option>
                                    <option value="vip">Kelas VIP</option>
                                    <option value="vvip">Kelas VVIP</option>
                                </select>
                                @if (@$klaim->status_step != null)
                                    <input type="hidden" name="upgrade_class_class"
                                        value="{{ @$klaim->upgrade_class_class }}">
                                @endif
                                <small class="text-danger">{{ $errors->first('upgrade_class_class') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('upgrade_class_los') ? ' has-error' : '' }}">
                        {!! Form::label('upgrade_class_los', 'Lama Hari Naik Kelas', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <select name="upgrade_class_los" {{ @$klaim->status_step != null ? 'disabled' : '' }}
                                class="form-control select2">
                                <option value="-">-</option>
                                @for ($i = 0; $i <= 25; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if (@$klaim->status_step != null)
                                <input type="hidden" name="upgrade_class_los" value="{{ @$klaim->upgrade_class_los }}">
                            @endif
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
                                <input type="text" {{ @$klaim->status_step != null ? 'readonly' : '' }}
                                    name="urun_bayar_rupiah" class="form-control">
                            </div>
                            <input type="hidden" name="add_payment_pct" value="">
                            <small class="text-danger">{{ $errors->first('add_payment_pct') }}</small>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" {{ @$klaim->status_step != null ? 'readonly' : '' }}
                                    name="urun_bayar_persen" class="form-control">
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
                            {!! Form::text('no_kartu', $pasien->no_jkn, [
                                'class' => 'form-control',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small id="no_kartu-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group" id="groupSEP">
                        {!! Form::label('no_sep', 'No. SEP', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('no_sep', $reg->no_sep, [
                                'class' => 'form-control',
                                'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                            ]) !!}
                            <small id="no_sep-error" class="text-danger"></small>
                        </div>
                    </div>

                    @if ($reg->hak_kelas_inap == null)
                        <div class="form-group" id="groupKelas">
                            {!! Form::label('no_sep', 'Kelas Rawat', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::select('kelas_rawat', [1 => 1, 2 => 2, 3 => 3], $reg->hakkelas, [
                                    'class' => 'form-control select2',
                                    'disabled' => @$klaim->status_step != null ? 'disabled' : null,
                                ]) !!}
                                @if (@$klaim->status_step != null)
                                    <input type="hidden" name="upgrade_class_ind" value="{{ @$klaim->kelas_rawat }}">
                                @endif
                                <small id="hakkelas-error" class="text-danger"></small>
                            </div>
                        </div>
                    @else
                        <div class="form-group" id="groupKelas">
                            {!! Form::label('no_sep', 'Kelas Rawat', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {{-- {!! Form::select('kelas_rawat', [1=>1, 2=>2, 3=>3], $reg->hakkelas, ['class' => 'form-control select2']) !!} --}}
                                {!! Form::text('kelas_rawat', $reg->hak_kelas_inap, [
                                    'class' => 'form-control',
                                    'readonly' => @$klaim->status_step != null ? 'readonly' : null,
                                ]) !!}
                                <small id="hakkelas-error" class="text-danger"></small>
                            </div>
                        </div>
                    @endif

                    {{-- Hidden input tetap seperti semula --}}
                    <input type="hidden" name="procedure" id="procedureInput"
                        value="{{ $prosedur ?? '' }}">
                    @if (@$klaim->status_step == null || empty(@$klaim))
                        <div class="form-group" id="groupProcedure">
                            {!! Form::label('procedure', 'Procedure ICD9 IDRG', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                <button type="button" id="openICD9" class="btn btn-default btn-flat">ICD9</button>



                                <ul id="procedureList" class="list-group mb-2">
                                    @if (!empty($prosedur))
                                        @foreach (explode('#', $prosedur) as $kode)
                                            @php
                                                // Jika ada +qty di kode
                                                $parts = explode('+', $kode);
                                                $kode_icd = $parts[0];
                                                $qty = $parts[1] ?? 1;
                                            @endphp
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-procedure"
                                                            data-code="{{ $kode_icd }}">×</button>
                                                        <span><strong>{{ $kode_icd }}</strong> -
                                                            {{ baca_prosedur($kode_icd) }}</span>
                                                    </div>
                                                </div>
                                                <input type="number" min="1"
                                                    class="form-control form-control-sm qty-input" style="width:80px;"
                                                    data-code="{{ $kode_icd }}" value="{{ $qty }}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                    {{-- <div class="form-group" id="groupProcedure">
                  {!! Form::label('procedure_inagrouper', 'Procedure ICD9 Inagrouper', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-6">
                      {!! Form::text('procedure_inagrouper', $prosedur, ['class' => 'form-control', 'placeholder'=>'contoh: 86.22+2#86.22']) !!}
                      <small class="text-danger" id="procedure-error"></small>
                  </div>
                  
              </div> --}}

                </div>
            </div>

            <div class="btn-group pull-right">



                @if (@$klaim->status_step == null)
                    <button type="button" id="startBRIDGING" class="btn btn-primary btn-flat">
                        GROUPING IDRG
                    </button>
                @endif

            </div>

            {{-- MUNCUL KETIKA FINAL IDRG --}}
            @if (in_array(@$klaim->status_step, ['import_idrg', 'final_idrg', 'grouping_inacbg', 'final_claim', 'done']))
                @include('frontoffice.e-claim._partial.grouping_idrg')
            @endif

            {{-- MUNCUL KETIKA SETELAH DIIMPORT --}}
            @if (in_array(@$klaim->status_step, ['grouping_inacbg', 'final_claim']))
                @include('frontoffice.e-claim._partial.icd_inacbg')
            @endif


            <div class="btn-group pull-right">

                @if (@$klaim->status_step == 'final_idrg')
                    <button type="button" id="finalisasi_idrg" class="btn btn-primary btn-flat">
                        FINAL IDRG
                    </button>
                @elseif(in_array(@$klaim->status_step, ['grouping_inacbg', 'final_claim']))
                    <button type="button" id="grouping_only_inacbg" class="btn btn-primary btn-flat">
                        GROUPING INACBG
                    </button>
                @endif
            </div>
            @if (in_array(@$klaim->status_step, ['final_claim', 'done']))
                @include('frontoffice.e-claim._partial.grouping_inacbg')
            @endif
            <div class="btn-group pull-right">

                @if (@$klaim->status_step == 'final_claim')
                    <a class="btn btn-success btn-flat"
                        href="{{ url('/inacbg/save-final-klaim-idrg/' . $klaim->no_sep) }}">FINAL</a>
                @endif
                @if (@$klaim->status_step == 'done')
                    <a href="{{ url('/cetak-e-claim-idrg/' . @$klaim->no_sep) }}" target="_blank"
                        class="btn btn-primary btn-flat">CETAK KLAIM</a>
                    <button type="button" id="edit_klaim_final" class="btn btn-danger btn-flat">
                        EDIT ULANG KLAIM
                    </button>
                @endif
            </div>


            <div class="btn-group pull-right">
                <a href="{{ url('frontoffice/e-claim/dataRawatInap') }}" class="btn btn-default">KEMBALI</a>
                {{-- <button type="button" class="btn btn-warning btn-flat" onclick="viewTindakan({{ $reg->registrasi_id }})">TINDAKAN</button> --}}
                {{-- <a href="{{ url('frontoffice/uploadDokument/'.$reg->registrasi_id) }}" class="btn btn-success btn-flat">UPLOAD</a> --}}

                {{-- START DARI AWAL --}}

                {{-- ARTINYA GROUPING ULANG GROUPING --}}
                @if (@$klaim->idrg_grouper == 2)
                    {{-- <button type="button" id="grouping_only_idrg" class="btn btn-primary btn-flat"
                        style="display: none;">
                        GROUPING ONLY IDRG
                    </button> --}}
                @endif

                {{-- ARTINYA SUDAH GROUPING --}}
                @if (@$klaim->idrg_grouper == 3)
                    <button type="button" id="finalisasi_idrg" class="btn btn-primary btn-flat">
                        FINALL IDRG
                    </button>
                @endif

                {{-- ARTINYA IMPORT IDRG --}}
                @if (@$klaim->idrg_grouper == 4 || in_array(@$klaim->status_step, ['grouping_inacbg']))
                    <button type="button" id="import_only_idrg" class="btn btn-warning btn-flat">
                        IMPORT IDRG TO INACBG
                    </button>
                @endif

                {{-- GROUPING INACBG --}}

                <button type="button" id="finalisasi_idrg" class="btn btn-primary btn-flat" style="display: none;">
                    FINALL IDRG
                </button>
                {{-- <button type="button" id="grouping_only_idrg" class="btn btn-primary btn-flat" style="display: none;">
                    GROUPING ONLY IDRG
                </button> --}}

            </div>
            {!! Form::close() !!}
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tutorial Pengisian Procedure Inagrouper</h4>
                        </div>
                        <div class="modal-body">
                            <h4><b>Diagnosa Inagrouper</b></h4>
                            <p>Prosedur pada INA Grouper dapat dicatat berulang
                                dengan menambahkan kode ekstensi dan/atau ditulis
                                beberapa kali (multiplicity dan setting).<br /><br />
                                {{-- <hr/> --}}
                                Setting untuk menandakan tindakan tersebut
                                dilakukan pada operasi yang berbeda dalam satu
                                episode. Setting ditulis dengan mencantumkan kode
                                tindakan beberapa kali, misal: "86.22#86.22".<br /> <br />
                                Multiplicity digunakan untuk mencatat tindakan
                                tersebut dilakukan beberapa kali didalam satu kali
                                operasi. Multiplicity dituliskan dengan notasi "+"
                                diikuti jumlahnya, misal: "86.22+2". <br /> <br />
                                Demikian pula
                                dimungkinkan untuk mencatat jika tindakan tersebut
                                dilakukan dalam beberapa kali operasi dalam satu
                                episode dan dilakukan lebih dari satu kali dalam
                                salah satu operasinya dengan contoh notasi sebagai
                                berikut: "86.22+2#86.22".</p>

                            {{-- <h4><b>Episodes</b></h4>
              <p>
                Untuk tambahan khusus pasien Jaminan COVID-19 yang rawat inap,
                paramter ini berisi lama rawat masing-masing episode ruangan
                perawatan yang dijalani oleh pasien selama rawat inap. Format
                pengisiannya dapat melihat contoh diatas sebagai berikut:
                "episodes": "1;12#2;3#6;5"<br/>
                Penjelasannya adalah setiap episode dibatasi (delimited by)
                tanda hash (#), kemudian masing-masing episode dinotasikan
                dengan jenis ruangan + titik koma + lama rawat.<br/>
                Jenis ruangan didefinisikan sebagai berikut:<br/>
                <br/>1 = ICU dengan ventilator
                <br/>2 = ICU tanpa ventilator
                <br/>3 = Isolasi tekanan negatif dengan ventilator
                <br/>4 = Isolasi tekanan negatif tanpa ventilator
                <br/>5 = Isolasi non tekanan negatif dengan ventilator
                <br/>6 = Isolasi non tekanan negatif tanpa ventilator
                Terhitung mulai tanggal masuk pasien 20 April 2021, maka
                definisi jenis ruangan sebagai berikut:
                <br/>7 = ICU tekanan negatif dengan ventilator
                <br/>8 = ICU tekanan negatif tanpa ventilator
                <br/>9 = ICU tanpa tekanan negatif dengan ventilator
                <br/>10 = ICU tanpa tekanan negatif tanpa ventilator
                <br/>11 = Isolasi tekanan negatif
                <br/>12 = Isolasi tanpa tekanan negatif
                Sebagai contoh tersebut diatas, artinya adalah:
                - episode pertama: ICU dengan ventilator selama 12 hari
                - episode kedua : ICU tanpa ventilator selama 3 hari
                - episode ketiga : Isolasi non tekanan negatif tanpa
                ventilator 5 hari
              </p> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
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
                            {{ number_format( \App\Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
                                  ->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                                  ->whereNotIn('masterobats.kategoriobat_id', [6, 8])
                                  ->where('registrasi_id', $reg->registrasi_id)
                                  ->sum('penjualandetails.hargajual') ) }}
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
                                    <th>Code</th>
                                    <th>Code2</th>
                                    <th>Nama</th>
                                    <th>Valid Code</th>
                                    <th>Asterisk</th>
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
                                    <th>Code</th>
                                    <th>Code2</th>
                                    <th>Nama</th>
                                    <th>Valid Code</th>
                                    <th>Asterisk</th>
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
                                    <th>Total Biaya Perawatan</th>
                                    <td id="total_rs"></td>
                                </tr>
                                <tr>
                                    <th>Total di Jamin INACBG</th>
                                    <td id="dijamin"></td>
                                </tr>
                                <tr>
                                    <th>Kode Grouper</th>
                                    <td id="kode"></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td id="deskripsi_grouper"></td>
                                </tr>
                                <tr>
                                    <th>Final Klaim</th>
                                    <td id="final_klaim"></td>
                                </tr>
                                <tr>
                                    <th>Kirim DC Kemenkes</th>
                                    <td id="kirim_dc"></td>
                                </tr>
                                <tr>
                                    <th>Petugas Grouper</th>
                                    <td id="who_update"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-sm">
                        {{-- <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">FINAL CLAIM</button> --}}
                        <a href="" id="tombolFinal"
                            onclick="return confirm('Pastikan data sudah benar, final claim akan mengirimkan data langsung ke kemenkes')"
                            class="btn btn-primary btn-flat">FINAL CLAIM</a>
                        {{-- <a href="" id="tombolCetak" class="btn btn-success btn-flat">CETAK BERKAS</a> --}}
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
@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()

        //Laka lantas
        $('select[name="pemulasaraan_jenazah"]').change(function(e) {
            if ($(this).val() == 1) {
                $('.pemulasaraan_jenazah').removeClass('hidden')
            } else {
                $('.pemulasaraan_jenazah').addClass('hidden')
            }
        });

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
                    url: '/frontoffice/e-claim/detailTindakan/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(json) {
                    $('#viewDetailTindakan').empty()
                    $.each(json.data, function(index, val) {
                        $('#viewDetailTindakan').append('<tr> <td>' + (index + 1) + '</td> <td>' + val
                            .namatarif + '</td> <td class="text-right">' + ribuan(val.total) +
                            '</td> <td>' + val.mapping + '</td> </tr>')
                    });
                    $('.totalTagihan').text(ribuan(json.total))
                });

        }

        $('#openICD9').on('click', function() {
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
                ajax: '/frontoffice/e-claim/get-icd9-data',
                columns: [{
                        data: 'code'
                    },
                    {
                        data: 'code2'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'validcode'
                    },
                    {
                        data: 'asterisk'
                    },
                    {
                        data: 'input',
                        searchable: false
                    }
                ]
            });
        });
        $('#openICD9Inacbg').on('click', function() {
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
                ajax: '/frontoffice/e-claim/get-icd9-data-inacbg',
                columns: [{
                        data: 'code'
                    },
                    {
                        data: 'code2'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'validcode'
                    },
                    {
                        data: 'asterisk'
                    },
                    {
                        data: 'input',
                        searchable: false
                    }
                ]
            });
        });

        $('#openICD10').on('click', function() {
            $('#icd10DATA').modal('show');
            $('.modal-title').text('Data Diagnosa');

            if (!$.fn.DataTable.isDataTable('#icd10VIEW')) {
                icd10Table = $('#icd10VIEW').DataTable({
                    language: {
                        url: "/json/pasien.datatable-language.json",
                    },
                    pageLength: 10,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: '/frontoffice/e-claim/get-icd10-data',
                        dataSrc: function(json) {
                            icd10Loaded = true; // flag: sudah pernah load
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'code'
                        },
                        {
                            data: 'code2'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: 'validcode'
                        },
                        {
                            data: 'asterisk'
                        },
                        {
                            data: 'input',
                            searchable: false
                        }
                    ]
                });
            } else {
                // Jika sudah pernah load, jangan fetch ulang
                if (!icd10Loaded) {
                    icd10Table.ajax.reload(null, false);
                }
            }
        });
        // ICD10 INACBG
        $('#openICD10Inacbg').on('click', function() {
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
                ajax: '/frontoffice/e-claim/get-icd10-data-inacbg',
                columns: [{
                        data: 'code'
                    },
                    {
                        data: 'code2'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'validcode'
                    },
                    {
                        data: 'asterisk'
                    },
                    {
                        data: 'input',
                        searchable: false
                    }
                ]
            });
        });
        // === UPDATE QTY SETIAP DIGANTI ===
        $(document).on('input', '.qty-input', function() {
            updateQtyHidden();
        });

        function updateQtyHidden() {
            let qtyData = {};
            $('#procedureList .qty-input').each(function() {
                const code = $(this).data('code');
                const qty = $(this).val();
                qtyData[code] = qty;
            });
            $('#procedureQtyInput').val(JSON.stringify(qtyData));
        }


        // === UPDATE QTY ===
        $(document).on('input', '.qty-input', function() {
            updateProcedureInput();
        });

        // === HAPUS PROCEDURE ===
        $(document).on('click', '.remove-procedure', function() {
            $(this).closest('li').remove();
            updateProcedureInput();
        });

        // === TAMBAH PROCEDURE ===
        $(document).on('click', '.insert-prosedure', function() {
            var kode = $(this).data('nomor');
            var nama = $(this).data('nama');
            var list = $('#procedureList');

            // Tambahkan item baru ke list
            list.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-danger btn-sm remove-procedure" data-code="${kode}">×</button>
                    <span><strong>${kode}</strong> - ${nama}</span>
                </div>
                <input type="number" min="1" class="form-control form-control-sm qty-input"
                    style="width:80px;" data-code="${kode}" value="1">
            </li>
        `);

            updateProcedureInput();
            $('#icd9DATA').modal('hide');
        });
        // === UPDATE HIDDEN INPUT ===
        function updateProcedureInput() {
            var codes = [];

            $('#procedureList li').each(function() {
                var code = $(this).find('.remove-procedure').data('code');
                var qty = $(this).find('.qty-input').val();

                // Jika qty > 1 tambahkan +qty di belakang kode
                if (qty && qty > 1) {
                    codes.push(code + '+' + qty);
                } else {
                    codes.push(code);
                }
            });

            $('#procedureInput').val(codes.join('#'));
        }
        $(document).on('click', '.insert-prosedure-inacbg', function() {
            var kode = $(this).data('nomor');
            var nama = $(this).data('nama');
            var im = $(this).data('im'); // ← ambil data-im
            var input = $('#procedureInputInacbg');
            var list = $('#procedureListInacbg');

            var current = input.val() ? input.val().split('#').filter(v => v.trim() !== '') : [];

            if (!current.includes(kode)) {
                current.push(kode);
                input.val(current.join('#'));

                // buat teks IM Tidak Berlaku jika im == 1
                var imText = im == 1 ?
                    '<span style="color:red; margin-left:5px;">(IM Tidak Berlaku)</span>' :
                    '';

                list.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-procedure-inacbg" data-code="${kode}">×</button>
                        <div>
                            <strong>${kode}</strong> - ${nama} ${imText}
                        </div>
                    </li>
                `);
            }

            $('#icd9DATA').modal('hide');
        });



        // === HAPUS PROCEDURE ===
        $(document).on('click', '.remove-procedure', function() {
            var kode = $(this).data('code');
            var input = $('#procedureInput');
            var list = $('#procedureList');

            // hapus dari tampilan
            $(this).closest('li').remove();

            // update daftar kode
            var updatedCodes = [];
            list.find('.remove-procedure').each(function() {
                updatedCodes.push($(this).data('code'));
            });
            input.val(updatedCodes.join('#'));

            // update hidden qty
            updateQtyHidden();
        });
        $(document).on('click', '.remove-procedure-inacbg', function() {
            var kode = $(this).data('code');
            var input = $('#procedureInputInacbg');
            var list = $('#procedureListInacbg');

            $(this).closest('li').remove();

            var updatedCodes = [];
            list.find('.remove-procedure-inacbg').each(function() {
                updatedCodes.push($(this).data('code'));
            });

            input.val(updatedCodes.join('#'));
        });

        //END ADD PROCEDURE


        // INSERT DIAGNOSA 
        $(document).on('click', '.insert-diagnosa', function() {
            var kode = $(this).data('nomor');
            var nama = $(this).data('nama');
            var accpdx = $(this).data('accpdx'); // ambil status utama (Y/N)
            var input = $('#diagnosaInput');
            var list = $('#diagnosaList');

            // Ambil data lama
            var current = input.val() ? input.val().split('#').filter(v => v.trim() !== '') : [];

            // 🚫 Cegah jika diagnosa pertama dan accpdx == 'N'
            if (current.length === 0 && accpdx === 'N') {
                alert('Tidak bisa dijadikan diagnosis primary');
                return; // hentikan proses
            }

            // Jika kode belum ada di daftar
            if (!current.includes(kode)) {
                current.push(kode);
                input.val(current.join('#'));

                list.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        data-code="${kode}"
                        data-accpdx="${accpdx}">
                        <button type="button" class="btn btn-danger btn-sm remove-diagnosa" data-code="${kode}">×</button>
                        <strong>${kode}</strong> - ${nama}
                    </li>
                `);
            }

            $('#icd10DATA').modal('hide');
        });
        // Tambah diagnosa dari modal ICD10
        $(document).on('click', '.insert-diagnosa-inacbg', function() {
            var kode = $(this).data('nomor');
            var nama = $(this).data('nama');
            var im = $(this).data('im'); // ← ambil data-im
            var input = $('#diagnosaInputInacbg');
            var list = $('#diagnosaListInacbg');

            // Ambil data lama
            var current = input.val() ? input.val().split('#').filter(v => v.trim() !== '') : [];

            if (!current.includes(kode)) {
                current.push(kode);
                input.val(current.join('#'));

                var imText = im == 1 ?
                    '<span style="color:red; margin-left:5px;">(IM Tidak Berlaku)</span>' :
                    '';
                list.append(`
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                      <button type="button" class="btn btn-danger btn-sm remove-diagnosa-inacbg" data-code="${kode}">×</button>
                      <strong>${kode}</strong> - ${nama} ${imText}
                  </li>
              `);
            }

            $('#icd10DATA').modal('hide');
        });

         // Hapus diagnosa dari list
        $(document).on('click', '.remove-diagnosa', function() {
            var li = $(this).closest('li');
            var kode = $(this).data('code');
            var accpdx = li.data('accpdx');
            var list = $('#diagnosaList');
            var input = $('#diagnosaInput');

            // Cek apakah ini diagnosa pertama (primary)
            var isPrimary = li.is(list.find('li').first());

            // Jika diagnosa pertama dan masih ada diagnosa secondary (accpdx = N)
            if (isPrimary && list.find('li[data-accpdx="N"]').length > 0) {
                alert('Diagnosa utama tidak bisa dihapus karena masih ada diagnosa secondary (ACCPDX = N)');
                return;
            }

            // Kalau bukan kondisi di atas, lanjut hapus
            li.remove();

            // Update input hidden setelah penghapusan
            var updatedCodes = [];
            list.find('.remove-diagnosa').each(function() {
                updatedCodes.push($(this).data('code'));
            });

            input.val(updatedCodes.join('#'));
        });
        $(document).on('click', '.remove-diagnosa-inacbg', function() {
            var kode = $(this).data('code');
            var input = $('#diagnosaInputInacbg');
            var list = $('#diagnosaListInacbg');

            // Filter ulang semua kode dari list UL, bukan hanya dari value hidden
            $(this).closest('li').remove();

            var updatedCodes = [];
            list.find('.remove-diagnosa-inacbg').each(function() {
                updatedCodes.push($(this).data('code'));
            });

            input.val(updatedCodes.join('#'));
        });


        // END INSERT DIAGNOSA
    </script>

    <script type="text/javascript">
        // Start New Bridging
        $('#startBRIDGING').on('click', function () {
        let $btn = $(this);
        let originalText = $btn.html(); // simpan teks asli tombol

        $.ajax({
            type: 'POST',
            url: '/newclaim-irna-idrg',
            data: $('#formINACBG').serialize(),
            beforeSend: function () {
                $('.overlay').removeClass('hidden');
                // ubah tombol jadi spinner dan disable
                $btn.prop('disabled', true).html(`
                    <i class="fa fa-spinner fa-spin"></i> Memproses Bridging...
                `);
            },
            success: function (data) {
                $('.overlay').addClass('hidden');

                // Bersihkan error sebelumnya
                $('#groupNoKartu, #groupSEP, #groupDiagnosa, #groupProcedure').removeClass('has-error');
                $('#no_kartu-error, #no_sep-error, #diagnosa-error, #procedure-error').html('');

                // --- Jika ada error validasi ---
                if (data.errors) {
                    if (data.errors.no_kartu) {
                        $('#no_kartu-error').html(data.errors.no_kartu[0]);
                        $('#groupNoKartu').addClass('has-error');
                    }
                    if (data.errors.no_sep) {
                        $('#no_sep-error').html(data.errors.no_sep[0]);
                        $('#groupSEP').addClass('has-error');
                    }
                    if (data.errors.diagnosa) {
                        $('#diagnosa-error').html(data.errors.diagnosa[0]);
                        $('#groupDiagnosa').addClass('has-error');
                    }
                    if (data.errors.procedure) {
                        $('#procedure-error').html(data.errors.procedure[0]);
                        $('#groupProcedure').addClass('has-error');
                    }
                    return; // stop di sini kalau ada error
                }

                // --- Jika sukses ---
                if (data.sukses == 1) {
                    console.log(data);
                    alert(JSON.stringify(data, null, 2));

                    // Tampilkan tombol FINAL IDRG jika memenuhi kondisi
                    let mdcDesc = data.no_sep.response_idrg?.mdc_description || 
                                data.no_sep.msg?.response_idrg?.mdc_description;

                    if (
                        (data.no_sep.metadata.code == 200 || data.no_sep.metadata.code == "200") &&
                        mdcDesc !== "Ungroupable or Unrelated"
                    ) {
                        console.log("OK");
                        $('#finalIDRG').show();
                        $('#finalisasi_idrg').show();
                        $('#startBRIDGING').hide();
                    }
                }
            },
            error: function (xhr) {
                $('.overlay').addClass('hidden');
                alert('Terjadi kesalahan: ' + xhr.statusText);
            },
            complete: function () {
                // kembalikan tombol ke kondisi semula
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

        $('#finalIDRG').on('click', function() {
            console.log("final")
            let ajaxUrl = "/final-idrg";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    $('.overlay').addClass('hidden')
                    if (data.sukses == 1) {
                        $('#suksesReturn').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('.modal-title').text('Bridging Sukses');
                        $.ajax({
                            url: '/eklaim-get-response/' + data.no_sep,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                $('#no_sep').html(data.no_sep)
                                $('#total_rs').html('Rp. ' + ribuan(data.total_rs))
                                $('#dijamin').html(
                                    'Rp. ' + (data.dijamin ? ribuan(data.dijamin) : '0')
                                );
                                $('#kode').html(data.kode)
                                $('#deskripsi_grouper').html(data.deskripsi_grouper)
                                $('#final_klaim').html(data.final_klaim)
                                $('#kirim_dc').text('N')
                                $('#who_update').html(data.who_update)
                                // $('#tombolCetak').attr('href', '/eklaim-detail-bridging/'+data.registrasi_id);
                                $('#tombolFinal').attr('href',
                                    '/inacbg/save-final-klaim-idrg/' + data.no_sep);
                            }
                        });
                    }
                }
            });
        });

        // IMPORT ONLY IDRG
        $('#import_only_idrg').on('click', function() {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks tombol

            $.ajax({
                type: 'POST',
                url: '/import-idrg-only',
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden');
                    // ubah tombol jadi spinner dan disable
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Mengimpor Data...
                    `);
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');
                    // alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                },
                error: function(xhr) {
                    $('.overlay').addClass('hidden');
                    alert('Terjadi kesalahan: ' + xhr.statusText);
                },
                complete: function() {
                    // kembalikan tombol ke kondisi semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });

       // GROUPING ONLY INACBG
        $('#grouping_only_inacbg').on('click', function () {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks asli tombol

            $.ajax({
                type: 'POST',
                url: "/grouping-inacbg-only",
                data: $('#formINACBG').serialize(),
                beforeSend: function () {
                    // tambahkan spinner di tombol
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Processing...
                    `);
                },
                success: function (data) {
                    console.log(data);

                    if (data.last_bridging) {
                        $.ajax({
                            url: '/eklaim-get-response/' + data.no_sep,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                alert(JSON.stringify(data, null, 2));
                                window.location.reload();
                            },
                            error: function () {
                                alert('Gagal mengambil response eKlaim.');
                            },
                            complete: function () {
                                // kembalikan tombol seperti semula
                                $btn.prop('disabled', false).html(originalText);
                            }
                        });
                    } else {
                        if (data.no_sep?.msg?.metadata?.code == 400) {
                            $('#grouping_only_idrg').show();
                            $('#finalisasi_idrg').hide();
                            alert(JSON.stringify(data, null, 2));
                        } else {
                            alert(JSON.stringify(data, null, 2));
                            window.location.reload();
                        }
                    }
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan: ' + xhr.statusText);
                },
                complete: function () {
                    // pastikan tombol dikembalikan kalau error
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // EDIT KLAIM FINAL - GROUPING STAGE 2
        $('#grouping_stage_2').on('click', function () {
            let $btn = $(this);
            let originalText = $btn.html(); // Simpan teks asli tombol

            $.ajax({
                type: 'POST',
                url: "/grouping-stage-2",
                data: $('#formINACBG').serialize(),
                beforeSend: function () {
                    // Munculkan overlay dan spinner di tombol
                    $('.overlay').removeClass('hidden');
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Processing...
                    `);
                },
                success: function (data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');
                    alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                },
                error: function (xhr) {
                    $('.overlay').addClass('hidden');
                    alert('Terjadi kesalahan: ' + xhr.statusText);
                },
                complete: function () {
                    // Kembalikan tombol ke keadaan semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
       // EDIT KLAIM FINAL
        $('#edit_klaim_final').on('click', function() {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks asli tombol

            $.ajax({
                type: 'POST',
                url: '/edit-ulang-klaim',
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden');
                    // ubah tombol jadi spinner & disable
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Mengedit Klaim Final...
                    `);
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');
                    alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                },
                error: function(xhr) {
                    $('.overlay').addClass('hidden');
                    alert("Terjadi kesalahan server: " + xhr.status);
                },
                complete: function() {
                    // kembalikan tombol ke kondisi semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
        // EDIT KLAIM INACB
        $('#edit_klaim').on('click', function() {
            console.log("import")
            let ajaxUrl = "/inacbg-edit-klaim";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');
                    alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                    return;
                }
            });
        });
        // EDIT ULANG IDRG
        $('#edit_idrg').on('click', function () {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks asli tombol

            $.ajax({
                type: 'POST',
                url: '/edit-idrg',
                data: $('#formINACBG').serialize(),
                beforeSend: function () {
                    // tampilkan overlay dan ubah tombol jadi loading
                    $('.overlay').removeClass('hidden');
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Mengedit IDRG...
                    `);
                },
                success: function (data) {
                    // console.log(data);
                    $('.overlay').addClass('hidden');
                    swal("Berhasil","Berhasil Edit Ulang IDRG","success");
                    window.location.reload();
                },
                error: function (xhr) {
                    $('.overlay').addClass('hidden');
                    alert('Terjadi kesalahan: ' + xhr.statusText);
                },
                complete: function () {
                    // kembalikan tombol ke teks dan status semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
        // EDIT KLAIM
        $('#edit_klaim_inacb').on('click', function() {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks asli tombol

            $.ajax({
                type: 'POST',
                url: '/inacbg-edit-klaim-belum-dc',
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden');
                    // ubah tombol jadi spinner dan disable
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Mengedit Klaim...
                    `);
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');

                    if (data.no_sep?.msg?.metadata?.code == 400) {
                        alert(JSON.stringify(data, null, 2));
                    } else {
                        alert(JSON.stringify(data, null, 2));
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan server: " + xhr.status);
                },
                complete: function() {
                    // kembalikan tombol ke kondisi semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
        // IMPORT IDRG
        $('#finalisasi_idrg').on('click', function() {
            let $btn = $(this);
            let originalText = $btn.html(); // simpan teks tombol

            $.ajax({
                type: 'POST',
                url: '/final-idrg-only',
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden');
                    // ubah tombol jadi spinner dan disable
                    $btn.prop('disabled', true).html(`
                        <i class="fa fa-spinner fa-spin"></i> Memproses Finalisasi...
                    `);
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');

                    // Cek status code dan kontrol tombol lain
                    if (data.no_sep?.msg?.metadata?.code == 400) {
                        $('#grouping_only_idrg').show();  // FINAL BRIDGING
                        $('#finalisasi_idrg').hide();      // FINAL BRIDGING
                        alert(JSON.stringify(data, null, 2));
                        return;
                    } else {
                        $('#import_idrg_only').show();     // OPEN IMPORT IDRG ONLY
                        $('#finalisasi_idrg').hide();      // HIDE FINALISASI IDRG ONLY
                        $('#grouping_only_idrg').hide();   // HIDE GROUPING ONLY IDRG
                    }

                    alert(JSON.stringify(data, null, 2));

                    // buat field readonly
                    $('input[name="diagnosa"], input[name="procedure"]').prop('readonly', true);

                    window.location.reload();
                },
                error: function(xhr) {
                    $('.overlay').addClass('hidden');
                    alert('Terjadi kesalahan: ' + xhr.statusText);
                },
                complete: function() {
                    // kembalikan tombol ke kondisi semula
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
        // Start Update Bridging
        $('#editBRIDGING').on('click', function() {
            $('.overlay').removeClass('hidden')
            $.ajax({
                    url: '/editclaimirna',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#formINACBG').serialize(),
                })
                .done(function(data) {
                    $('.overlay').addClass('hidden')
                    if (data.errors) {
                        if (data.errors.no_kartu) {
                            $('#no_kartu-error').html(data.errors.no_kartu[0]);
                            $('#groupNoKartu').addClass('has-error');
                        }

                        if (data.errors.no_sep) {
                            $('#no_sep-error').html(data.errors.no_sep[0]);
                            $('#groupSEP').addClass('has-error');
                        }

                        if (data.errors.diagnosa) {
                            $('#diagnosa-error').html(data.errors.diagnosa[0]);
                            $('#groupDiagnosa').addClass('has-error');
                        }

                        if (data.errors.procedure) {
                            $('#procedure-error').html(data.errors.procedure[0]);
                            $('#groupProcedure').addClass('has-error');
                        }
                        alert(JSON.stringify(data.errors));
                    };

                    if (data.sukses == true) {
                        $('#suksesReturn').modal('show');
                        $('.modal-title').text('Bridging Sukses');
                        $.ajax({
                            url: '/eklaim-get-response/' + data.no_sep,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#no_sep').html(data.no_sep)
                                $('#total_rs').html('Rp. ' + ribuan(data.total_rs))
                                $('#dijamin').html('Rp. ' + ribuan(data.dijamin))
                                $('#kode').html(data.kode)
                                $('#deskripsi_grouper').html(data.deskripsi_grouper)
                                $('#final_klaim').html(data.final_klaim)
                                $('#kirim_dc').text('Y')
                                $('#who_update').html(data.who_update)
                                // $('#tombolCetak').attr('href', '/eklaim-detail-bridging/'+data.registrasi_id);
                                $('#tombolFinal').attr('href', '/inacbg/save-final-klaim-idrg/' +
                                    data.no_sep);
                            }
                        });
                    }


                });

        })

        $('#grouping_only_idrg').on('click', function() {
            console.log("import")
            let ajaxUrl = "/grouping-idrg-only";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').addClass('hidden');

                    if (data.no_sep.metadata.code == 200 || data.no_sep.msg.metadata.code == 200) {
                        $('#grouping_only_idrg').hide(); //FINAL BRIDGING
                        $('#finalisasi_idrg').show(); //FINAL BRIDGING
                        alert(JSON.stringify(data, null, 2));
                        window.location.reload();
                        return;
                    } else {
                        return alert(JSON.stringify(data, null, 2));
                    }
                    // $('input[name="diagnosa"], input[name="procedure"]').prop('readonly', true);

                }
            });
        });


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
