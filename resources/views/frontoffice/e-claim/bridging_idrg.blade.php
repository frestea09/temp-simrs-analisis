@extends('master')

@section('header')
    <h1>Bridging IDRG E-Klaim Rawat Jalan <small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Data Pasien </h4>
        </div>
        <div class="box-body">
            @php
                $coder = !empty(Auth::user()->coder_nik) ? Auth::user()->coder_nik : config('app.coder_nik');
                $edit = isset($_GET['edit']) ? $_GET['edit'] : null;
            @endphp
            @if ($edit == 1)
                {!! Form::open(['method' => 'POST', 'url' => 'editclaim', 'class' => 'form-horizontal', 'id' => 'formINACBG']) !!}
            @else
                {!! Form::open([
                    'method' => 'POST',
                    'url' => 'newclaim-idrg',
                    'class' => 'form-horizontal',
                    'id' => 'formINACBG',
                ]) !!}
            @endif

            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('gender', $reg->pasien->kelamin == 'L' ? 1 : 2) !!}
            {!! Form::hidden('jenis_rawat', 2) !!}
            {!! Form::hidden('adl_sub_acute', '-') !!}
            {!! Form::hidden('adl_chronic', '-') !!}
            {!! Form::hidden('icu_indikator', '-') !!}
            {!! Form::hidden('icu_los', 0) !!}
            {!! Form::hidden('ventilator_hour', 0) !!}
            {!! Form::hidden('upgrade_class_ind', 0) !!}
            {!! Form::hidden('upgrade_class_class', 0) !!}
            {!! Form::hidden('upgrade_class_los', 0) !!}
            {!! Form::hidden('add_payment_pct', 0) !!}
            {!! Form::hidden('tarif_poli_eks', 0) !!}
            {!! Form::hidden('payor_id', 3) !!}
            {!! Form::hidden('payor_cd', 'JKN') !!}
            {!! Form::hidden('cob_cd', '-') !!}
            {!! Form::hidden('coder_nik', $coder) !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                        {!! Form::label('nama', 'Nama Pasien ', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('nama', $reg->pasien->nama, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                        {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('no_rm', $reg->pasien->no_rm, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
                        {!! Form::label('tgllahir', 'Tgl Lahir', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('tgllahir', $reg->pasien->tgllahir, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
                        {!! Form::label('umur', 'Umur', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('umur', hitung_umur($reg->pasien->tgllahir), ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('umur') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birth_weight') ? ' has-error' : '' }}">
                        {!! Form::label('beratlahir', 'Berat Lahir', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('birth_weight', '0', ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('birth_weight') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('nama_dokter') ? ' has-error' : '' }}">
                        {!! Form::label('nama_dokter', 'Dokter DPJP', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select(
                                'nama_dokter',
                                Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'nama'),
                                baca_dokter($reg->dokter_id),
                                ['class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                            <small class="text-danger">{{ $errors->first('nama_dokter') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('discharge_status') ? ' has-error' : '' }}">
                        {!! Form::label('discharge_status', 'Cara Pulang', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('discharge_status', App\KondisiAkhirPasien::pluck('namakondisi', 'id'), 1, [
                                'class' => 'form-control select2',
                                'style' => 'width: 100%']) !!}
                            <small class="text-danger">{{ $errors->first('discharge_status') }}</small>
                        </div>
                    </div>

                    <input type="hidden" name="diagnosa" id="diagnosaInput" value="{{ $diagnosa ?? '' }}"
                        {{ @$klaim->idrg_grouper == 4 ? 'readonly' : '' }}>
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
                    <d iv class="form-group" id="groupSITB">
                        {!! Form::label('sitb', 'SITB', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('sitb', null, ['class' => 'form-control', 'placeholder' => 'Masukkan No.SITB']) !!}
                            <small class="text-danger" id="diagnosa-error"></small>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="cekSitb" class="btn btn-primary btn-flat">CEK SITB</button>
                        </div>
                    </d>


                </div>
                {{-- =============================================================================================================== --}}
                <div class="col-md-6">

                    <div class="form-group" id="groupNoKartu">
                        {!! Form::label('no_kartu', 'No. Kartu', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('no_kartu', $reg->pasien->no_jkn, ['class' => 'form-control']) !!}
                            <small id="no_kartu-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group" id="groupSEP">
                        {!! Form::label('no_sep', 'No. SEP', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('no_sep', @$data['klaim'] ? @$data['klaim']->no_sep : $reg->no_sep, ['class' => 'form-control']) !!}
                            <small id="no_sep-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group" id="groupKelas">
                        {!! Form::label('no_sep', 'Reguler / Eksekutif', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('kelas_rawat', [1 => 'Eksekutif', 3 => 'Reguler'], 3, [
                                'class' => 'form-control select2',
                                'style' => 'width: 100%']) !!}
                            <small id="hakkelas-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group" id="groupKelas">
                        {!! Form::label('cara_masuk', 'Cara Masuk', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select(
                                'cara_masuk',
                                [
                                    'gp' => 'Rujukan FKTP',
                                    'hosp-trans' => 'Rujukan FKRTL',
                                    'mp' => 'Rujukan Spesialis',
                                    'outp' => 'Dari Rawat Jalan',
                                    'inp' => 'Dari Rawat Inap',
                                    'emd' => 'Dari Rawat Darurat',
                                    'born' => 'Lahir di RS',
                                    'nursing' => 'Rujukan Panti Jompo',
                                    'psych' => 'Rujukan dari RS Jiwa',
                                    'rehab' => 'Rujukan Fasilitas Rehab',
                                    'other' => 'Lain-lain',
                                ],
                                null,
                                ['class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                            <small id="hakkelas-error" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
                        {!! Form::label('tgl_masuk', 'Tgl Masuk', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('tgl_masuk', $reg->created_at, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tgl_keluar') ? ' has-error' : '' }}">
                        {!! Form::label('tgl_keluar', 'Tgl Pulang', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('tgl_keluar', $reg->created_at, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('tgl_keluar') }}</small>
                        </div>
                    </div>

                    @php
                        $tarif = Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->id)->sum('total');
                    @endphp
                    <div class="form-group{{ $errors->has('tarif_rs') ? ' has-error' : '' }}">
                        {!! Form::label('tarif_rs', 'Tarif RS', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('tarif_rs', $tarif, ['class' => 'form-control', 'readonly' => true]) !!}
                            <small class="text-danger">{{ $errors->first('tarif_rs') }}</small>
                        </div>
                    </div>
                     <div class="form-group{{ $errors->has('kode_tarif') ? ' has-error' : '' }}">
                        {!! Form::label('kode_tarif', 'Tipe RS', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <select name="kode_tarif" class="form-control select2" id="">
                                <option value="BP">TARIF RS KELAS B PEMERINTAH</option>
                                <option value="CP">TARIF RS KELAS C PEMERINTAH</option>
                                <option value="DP">TARIF RS KELAS D PEMERINTAH</option>
                            </select>
                            {{-- {!! Form::select('kode_tarif', ['CP','BP'], 'BP', ['class' => 'form-control select2', 'style' => 'width: 100%']) !!} --}}
                            <small id="hakkelas-error" class="text-danger"></small>
                            {{-- {!! Form::text('kode_tarif', config('app.tipe_RS'), ['class' => 'form-control', 'readonly'=>true]) !!} --}}
                            <small class="text-danger">{{ $errors->first('kode_tarif') }}</small>
                        </div>
                    </div>

                      <input type="hidden" name="procedure" id="procedureInput" value="{{ $prosedur ?? '' }}">
                    @if (@$klaim->status_step == null || empty(@$klaim))
                        <div class="form-group" id="groupProcedure">
                            {!! Form::label('procedure', 'Procedure ICD9 IDRG', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                <button type="button" id="openICD9" class="btn btn-default btn-flat">ICD9</button>

                                {{-- Hidden input tetap seperti semula --}}


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

                </div>
            </div>

            <div class="btn-group pull-left">
                <button type="button" class="btn btn-warning btn-flat"
                    style="border-color:purple;background: purple !important"
                    onclick="viewResume({{ $reg->id }})">RESUME</button>
                <button type="button" class="btn btn-danger btn-flat"
                    onclick="viewSpri({{ $reg->id }})">SPRI</button>
                <button type="button" class="btn btn-info btn-flat" onclick="viewLab({{ $reg->id }})">LAB</button>
                <button type="button" class="btn btn-success btn-flat"
                    onclick="viewRad({{ $reg->id }})">RAD</button>

            </div>

            <div class="btn-group pull-right">
                {{-- <a href="{{ url('frontoffice/e-claim/dataRawatJalan') }}" class="btn btn-default btn-flat">Batal</a>
                <button type="button" class="btn btn-warning btn-flat"
                    onclick="viewTindakan({{ $reg->id }})">TINDAKAN</button>
                <a href="{{ url('frontoffice/uploadDokument/' . $reg->id) }}" class="btn btn-success btn-flat">UPLOAD</a>
                 --}}


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
                    <a href="{{ url('/cetak-e-claim-idrg/' . @$klaim->no_sep) }}" target="_blank"
                        class="btn btn-primary btn-flat">CETAK KLAIM</a>
                    <a class="btn btn-success btn-flat"
                        href="{{ url('/inacbg/save-final-klaim-idrg/' . $klaim->no_sep) }}">FINAL CLAIM</a>
                @endif
                @if (@$klaim->status_step == 'done')
                    <a href="{{ url('/cetak-e-claim-idrg/' . @$klaim->no_sep) }}" target="_blank"
                        class="btn btn-primary btn-flat">CETAK KLAIM</a>
                    <button type="button" id="edit_klaim_final" class="btn btn-danger btn-flat">
                        EDIT ULANG CLAIM
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
                          @php
                                $obat_kronis = \Modules\Registrasi\Entities\Folio::where('folios.registrasi_id', $reg->id)->where('user_id', 610)->sum('total');
                                if($obat_kronis > 0){
                                  echo number_format(Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', 5)->sum('folios.total')-$obat_kronis);
                                }else{
                                  echo  @number_format(Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', 5)->sum('folios.total'));
                                }
                                
                            @endphp
                            {{-- {{ number_format( \App\Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
                                  ->join('folios', 'folios.namatarif', '=', 'penjualans.no_resep')
                                  ->join('masterobats', 'penjualandetails.masterobat_id', '=', 'masterobats.id')
                                  ->whereNotIn('masterobats.kategoriobat_id', [6, 8])
                                  ->where('penjualans.registrasi_id', $reg->id)
                                  ->sum('penjualandetails.hargajual') ) }} --}}
                            
                          @else
                            {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}
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
                                                ->where('registrasi_id', $reg->id)
                                                ->sum('penjualandetails.hargajual');
                              $alkes_tarif = \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total');
                              $total_alkes = $alkes_obat + $alkes_tarif;
                            @endphp
                            {{ number_format($total_alkes) }}
                          @else
                            {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}
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
                                                  ->where('registrasi_id', $reg->id)
                                                  ->sum('penjualandetails.hargajual');
                                $bmhp_tarif = \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total');
                                $total_bmhp = $bmhp_obat + $bmhp_tarif;
                              @endphp
                              {{ number_format($total_bmhp) }}
                          @elseif ($d->id == 17)
                            @php
                                $obat_kronis = \Modules\Registrasi\Entities\Folio::where('folios.registrasi_id', $reg->id)->where('user_id', 610)->sum('total');
                                // dd($obat_kronis);
                            @endphp
                            {{ number_format($obat_kronis) }}
                          @else
                            {{ number_format( \Modules\Registrasi\Entities\Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $reg->id)->where('tarifs.mastermapping_id', $d->id)->sum('folios.total') ) }}
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
                    <div class="pull-left">
                        <a href="{{ url('eklaim-detail-bridging/' . $reg->id) }}" target="_blank"
                            class="btn btn-danger btn-flat"><i class="fa fa-print"></i> CETAK</a>
                        <button class="btn btn-success btn flat" onclick="kirimDC({{ $reg->id }})"><i
                                class="fa fa-paper-plane-o"></i> KIRIM DC</button>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default btn-flat" id="closeModal"
                            data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL TINDAKAN --}}
    <div class="modal fade" id="modalTindakan">
        <div class="modal-dialog">
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
                        <table class="table table-hover table-bordered table-condensed" style="font-size: 12px;">
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

    {{-- MODAL DETAIL LAB --}}
    <div class="modal fade" id="modalLab">
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
                                    <th>Pemeriksaan</th>
                                    <th>Oleh</th>
                                    <th>Tgl Order</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody id="viewDetailLab">
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

    {{-- MODAL DETAIL RAD --}}
    <div class="modal fade" id="modalRad">
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
                                    <th>UUID</th>
                                    <th>Oleh</th>
                                    <th>Tgl Order</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody id="viewDetailRad">
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

    {{-- MOdal Final Claim --}}
    <div class="modal fade" id="finalKlaimModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed table-bordered">
                            <tbody>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td id="namaPasien"></td>
                                </tr>
                                <tr>
                                    <td>No. RM</td>
                                    <td id="noMR"></td>
                                </tr>
                                <tr>
                                    <td>No. JKN</td>
                                    <td id="noJkn"></td>
                                </tr>
                                <tr>
                                    <td>No. SEP</td>
                                    <td id="noSep"></td>
                                </tr>
                                <tr>
                                    <td>Dokter</td>
                                    <td id="dokter"></td>
                                </tr>
                                <tr>
                                    <td>Diagnosa</td>
                                    <td id="diagnosa"></td>
                                </tr>
                                <tr>
                                    <td>Prosedur</td>
                                    <td id="prosedur"></td>
                                </tr>
                                <tr>
                                    <td>Biaya Rumah Sakit</td>
                                    <td id="totalRS"></td>
                                </tr>
                                <tr>
                                    <td>Dijamin</td>
                                    <td id="dijamin"></td>
                                </tr>
                                <tr>
                                    <td>Kode Grouper</td>
                                    <td id="kodeGrouper"></td>
                                </tr>
                                <tr>
                                    <td>Grouper</td>
                                    <td id="grouper"></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td id="description"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="tbFinal" onclick="">Final dan
                        Kirim DC</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="box-footer">
    </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()

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
                        if (val.tarif !== null) {
                            if (!val.tarif.mastermapping) {
                                mapping =
                                    '<small style="color:orange"><i><a style="color:orange" target="_blank" href="/mastermapping/edit-tarif?nama=' +
                                    val.namatarif + '">Belum dimapping</a></i></small>'
                            } else {
                                mapping = val.tarif.mastermapping.mapping
                            }
                        } else {
                            mapping = '<small style="color:orange"><i>Tarif Belum dimapping</i></small>'
                        }
                        $('#viewDetailTindakan').append('<tr> <td>' + (index + 1) + '</td> <td>' + val
                            .namatarif + '</td> <td class="text-right">' + ribuan(val.total) +
                            '</td> <td>' + mapping + '</td> </tr>')
                    });
                    $('.totalTagihan').text(ribuan(json.total))
                });

        }

        // VIEW RESUME
        function viewResume(registrasi_id) {
            $('#viewDetailResume').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
            $('#modalResume').modal('show')
            $('.modal-title').text('Detail Resume')
            $.ajax({
                    url: '/frontoffice/e-claim/detailResume/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(json) {
                    $('#viewDetailResume').empty()
                    if (json.total == 0) {
                        return $('#viewDetailResume').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada Resume</td></tr>')
                    }
                    // console.log(json)
                    $.each(json.data, function(index, val) {
                        $('#viewDetailResume').append('<tr> <td>' + (index + 1) +
                            '</td> <td class="text-center">' + val.tekanandarah +
                            '</td> <td class="text-center">' + val.bb + '</td> <td>' + val.diagnosa +
                            '</td><td>' + val.tindakan + '</td><td>' + val.keterangan + '</td><td>' + val
                            .created_at + '</td> </tr>')
                    });
                });

        }

        // VIEW SPRI
        function viewSpri(registrasi_id) {
            $('#viewDetailSpri').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
            $('#modalSpri').modal('show')
            $('.modal-title').text('SPRI')
            $.ajax({
                    url: '/frontoffice/e-claim/detailSpri/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(json) {
                    // console.log(json)
                    $('#viewDetailSpri').empty()
                    if (json.data == 0) {
                        return $('#viewDetailSpri').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada SPRI</td></tr>')
                    }
                    $.each(json.data, function(index, val) {
                        var nospri = '-'
                        if (val.no_spri !== null) {
                            var nospri = val.no_spri
                        }
                        $('#viewDetailSpri').append('<tr> <td>' + (index + 1) +
                            '</td> <td class="text-center">' + nospri + '</td> <td class="text-center">' +
                            val.tgl_rencana_kontrol + '</td> <td>' + val.diagnosa + '</td><td>' + val
                            .dokter_rawat + '</td><td>' + val.dokter_pengirim + '</td><td>' + val.kamar +
                            '</td><td>' + val.cara_bayar + '</td> </tr>')
                    });
                });

        }

        // VIEW LAB
        function viewLab(registrasi_id) {
            $('#viewDetailLab').empty()
            $('#viewDetailLab').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
            $('#modalLab').modal('show')
            $('.modal-title').text('Hasil Lab')
            $.ajax({
                    url: '/frontoffice/e-claim/detailLab/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(json) {
                    // console.log(json)
                    $('#viewDetailLab').empty()
                    if (json.data == 0) {
                        return $('#viewDetailLab').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada Hasil Lab</td></tr>')
                    }
                    $.each(json.data, function(index, val) {
                        $('#viewDetailLab').append('<tr> <td>' + (index + 1) + '</td> <td class="">' + val
                            .pemeriksaan + '</td><td class="">' + val.user + '</td> <td>' + val.tgl +
                            '</td><td><a target="_blank" href="/pemeriksaanlabCommon/cetak/' + val.url +
                            '">Lihat</a></td></tr>')
                    });
                });

        }
        // VIEW RAD
        function viewRad(registrasi_id) {
            $('#viewDetailRad').empty()
            $('#viewDetailRad').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>')
            $('#modalRad').modal('show')
            $('.modal-title').text('Hasil Radiologi')
            $.ajax({
                    url: '/frontoffice/e-claim/detailRad/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(json) {
                    // console.log(json)
                    $('#viewDetailRad').empty()
                    if (json.data == 0) {
                        return $('#viewDetailRad').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada Hasil Radiologi</td></tr>')
                    }
                    $.each(json.data, function(index, val) {
                        $('#viewDetailRad').append('<tr> <td>' + (index + 1) + '</td> <td class="">' + val
                            .pemeriksaan + '</td> <td class="">' + val.user + '</td> <td>' + val.tgl +
                            '</td><td><a target="_blank" href="/radiologi/cetak-ekpertise-eklaim/' + val
                            .id + '/' + val.registrasi_id + '">Lihat</a></td></tr>')
                    });
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
        // Tambah diagnosa dari modal ICD10
        $(document).on('click', '.insert-diagnosa', function() {
            var kode = $(this).data('nomor');
            var nama = $(this).data('nama');
            var input = $('#diagnosaInput');
            var list = $('#diagnosaList');

            // Ambil data lama
            var current = input.val() ? input.val().split('#').filter(v => v.trim() !== '') : [];

            if (!current.includes(kode)) {
                current.push(kode);
                input.val(current.join('#'));

                list.append(`
                  <li class="list-group-item d-flex justify-content-between align-items-center">
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
            var kode = $(this).data('code');
            var input = $('#diagnosaInput');
            var list = $('#diagnosaList');

            // Filter ulang semua kode dari list UL, bukan hanya dari value hidden
            $(this).closest('li').remove();

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
    <script>
        var urlEklaim = "{{ env('URL_EKLAIM') }}";
    </script>
    <script type="text/javascript">
        $('#cekSitb').on('click', function() {
            sitb = $('input[name="sitb"]').val();
            sep = $('input[name="no_sep"]').val();
            if (sitb == '' || sep == '') {
                return alert('Kolom SITB dan SEP harus diisi')
            }
            // return
            $.ajax({
                type: 'GET',
                url: '/cek-sitb/' + sitb + '/' + sep,
                // data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    // console.log(data)
                    // return
                    $('.overlay').addClass('hidden')
                    if (data.errors) {
                        return alert('No register tidak valid')
                    };

                    if (data.sukses == 1) {
                        return alert('No register VALID')
                    }
                }
            });
        })

        $('#startBRIDGING').on('click', function() {
            let ajaxUrl = "/newclaim-idrg";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
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
                    };

                    if (data.sukses == 1) {

                        console.log(data);
                        log_a = data.no_sep?.response_idrg?.mdc_description;
                        log_b = data.no_sep?.msg?.response_idrg?.mdc_description;
                        console.log('log_a:' + log_a)
                        console.log('log_b:' + log_b)
                        alert(JSON.stringify(data, null, 2));
                        // tampilkan tombol FINAL IDRG
                        if (
                            (
                                data.no_sep?.metadata?.code == 200 ||
                                data.no_sep?.metadata?.code == "200" ||
                                data.no_sep?.msg?.metadata?.code == 200 ||
                                data.no_sep?.msg?.metadata?.code == "200"
                            ) &&
                            (
                                (data.no_sep?.response_idrg?.mdc_description ?? data.no_sep?.msg
                                    ?.response_idrg?.mdc_description) !== "Ungroupable or Unrelated"
                            )
                        ) {

                            console.log("OK")
                            $('#finalIDRG').show(); //FINAL BRIDGING
                            $('#finalisasi_idrg').show(); //FINAL BRIDGING
                            $('#startBRIDGING').hide(); //START BRIDGING 

                        }
                    }
                }
            });
        });

        // IMPORT ONLY IDRG
        $('#import_only_idrg').on('click', function() {
            console.log("import")
            let ajaxUrl = "/import-idrg-only";
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
                    // alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                    return;
                }
            });
        });

        // GROUPING ONLY INACBG
        $('#grouping_only_inacbg').on('click', function() {
            console.log("import")
            let ajaxUrl = "/grouping-inacbg-only";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    console.log(data);

                    // JIKA BERHASIL
                    if (data.last_bridging) {
                        // $('#suksesReturn').modal({
                        //     backdrop: 'static',
                        //     keyboard: false
                        // });
                        // $('.modal-title').text('Bridging Sukses');
                        $.ajax({
                            url: '/eklaim-get-response/' + data.no_sep,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                alert(JSON.stringify(data, null, 2));
                                window.location.reload();
                                return;
                                // $('#no_sep').html(data.no_sep)
                                // $('#total_rs').html('Rp. ' + ribuan(data.total_rs))
                                // $('#dijamin').html(
                                //     'Rp. ' + (data.dijamin ? ribuan(data.dijamin) : '0')
                                // );
                                // $('#kode').html(data.kode)
                                // $('#deskripsi_grouper').html(data.deskripsi_grouper)
                                // $('#final_klaim').html(data.final_klaim)
                                // $('#kirim_dc').text('N')
                                // $('#who_update').html(data.who_update)
                                // $('#tombolCetak').attr('href', '/eklaim-detail-bridging/' +
                                //     data.registrasi_id);
                            }
                        });
                    } else {
                        if (data.no_sep.msg.metadata.code == 400) {
                            $('#grouping_only_idrg').show(); //FINAL BRIDGING
                            $('#finalisasi_idrg').hide(); //FINAL BRIDGING
                            return alert(JSON.stringify(data, null, 2));
                        } else {
                            alert(JSON.stringify(data, null, 2));
                            window.location.reload();
                            return;
                        }

                    }









                }
            });
        });

        // EDIT KLAIM FINAL
        $('#grouping_stage_2').on('click', function() {
            console.log("import")
            let ajaxUrl = "/grouping-stage-2";
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
        // EDIT KLAIM FINAL
        $('#edit_klaim_final').on('click', function() {
            console.log("import")
            let ajaxUrl = "/edit-ulang-klaim";
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
        // edit_idrg
        $('#edit_idrg').on('click', function() {
            console.log("import")
            let ajaxUrl = "/edit-idrg";
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
        // EDIT KLAIM
        $('#edit_klaim_inacb').on('click', function() {
            console.log("import")
            let ajaxUrl = "/inacbg-edit-klaim-belum-dc";
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: $('#formINACBG').serialize(),
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                success: function(data) {
                    console.log(data);
                    if (data.no_sep.msg.metadata.code == 400) {
                        return alert(JSON.stringify(data, null, 2));
                    }
                    $('.overlay').addClass('hidden');
                    alert(JSON.stringify(data, null, 2));
                    window.location.reload();
                    return;
                }
            });
        });
        // IMPORT IDRG
        $('#finalisasi_idrg').on('click', function() {
            console.log("import")
            let ajaxUrl = "/final-idrg-only";
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

                    if (data.no_sep.msg.metadata.code == 400) {
                        $('#grouping_only_idrg').show(); //FINAL BRIDGING
                        $('#finalisasi_idrg').hide(); //FINAL BRIDGING
                        if(data.no_sep.msg.metadata.message == 'Klaim sudah final'){
                            alert(JSON.stringify(data, null, 2));
                            $('input[name="diagnosa"], input[name="procedure"]').prop('readonly', true);
                            window.location.reload();
                            return;
                        }
                        return alert(JSON.stringify(data, null, 2));
                        
                    } else {
                        $('#import_idrg_only').show(); //OPEN IMPORT IDRG ONLY
                        $('#finalisasi_idrg').hide(); //HIDE FINALISASI IDRG ONLY
                        $('#grouping_only_idrg').hide(); //HIDE GROUPING ONLY IDRG
                    }

                    alert(JSON.stringify(data, null, 2));
                    $('input[name="diagnosa"], input[name="procedure"]').prop('readonly', true);
                    window.location.reload();
                    return;
                }
            });
        });

        // FINAL IDRG
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
                                    'Rp. ' + (data.dijamin ? ribuan(data.dijamin) :
                                        '0')
                                );
                                $('#kode').html(data.kode)
                                $('#deskripsi_grouper').html(data.deskripsi_grouper)
                                $('#final_klaim').html(data.final_klaim)
                                $('#kirim_dc').text('N')
                                $('#who_update').html(data.who_update)
                                $('#tombolCetak').attr('href',
                                    '/eklaim-detail-bridging/' +
                                    data.registrasi_id);
                            }
                        });
                    }
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

        function kirimDC(registrasi_id) {
            $('#finalKlaimModal').modal('show')
            $('.modal-title').text('Kirim DC')
            $.ajax({
                    url: '/inacbg/get-dataklaim/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(resp) {
                    $('#namaPasien').text(resp.pasien_nama)
                    $('#noMR').text(resp.no_rm)
                    $('#noJkn').text(resp.no_kartu)
                    $('#noSep').text(resp.no_sep)
                    $('#dokter').text(resp.dokter)
                    $('#diagnosa').text(resp.icd1)
                    $('#prosedur').text(resp.prosedur1)
                    $('#totalRS').text(resp.total_rs)
                    $('#dijamin').text(resp.dijamin)
                    $('#kodeGrouper').text(resp.kode)
                    $('#grouper').text(resp.who_update)
                    $('#description').text(resp.deskripsi_grouper)
                    $('#tbFinal').attr('onclick', 'saveKirimDC("' + resp.no_sep + '", "{{ $coder }}")');
                });
        }

        function saveKirimDC(no_sep, coder_nik) {
            $.ajax({
                    url: '/inacbg/save-final-klaim-idrg/' + no_sep + '/' + coder_nik,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(resp) {
                    if (resp.sukses == true) {
                        $('#finalKlaimModal').modal('hide')
                        alert('No. SEP ' + resp.no_sep + ' sdh di Kirim DC')
                    }
                });
        }
    </script>
@endsection
