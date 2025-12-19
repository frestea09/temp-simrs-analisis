@extends('layouts.landingpage')
@section('style')
    <style>
        .select2-results__option,
        .select2-search__field,
        .select2-selection__rendered,
        .form-control,
        .col-form-label {
            font-size: 12px;
        }

        .table-pasien tr td {
            padding: 5px !important;
            font-size: 12px;
        }

        th {
            font-weight: 700 !important;
        }

        #dataPasien td,
        #dataPasien th {
            padding: 0.25rem !important;
        }

        select[readonly] {
            background: #eee;
            /*Simular campo inativo - Sugestão @GabrielRodrigues*/
            pointer-events: none;
            touch-action: none;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        {{-- <h4 class="text-dark text-center">Pendaftaran Online Pasien Baru</h4> --}}
        {{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Library</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data</li>
    </ol>
  </nav> --}}
        {{--
  <hr /> --}}
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ url('/reservasi/cek-kontrol') }}" class="btn btn-danger btn-sm col-md-2 col-lg-2 float-right"><i
                        class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
                <b style="font-weight:700;">CETAK SEP PASIEN </b>

            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-12">
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('error') }}.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- <div class="card border-info">
        <div class="card-header bg-info">
          <span style="color:white">Form Scan No. Rujukan </span>
        </div>
        <div class="card-body">
          <form class="form-horizontal" id="form">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group row">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">No. Rujukan
              </label>
              <div class="col-sm-4">
                <input id="keyword" autocomplete="off" type="text" name="keyword" value="" class="form-control"
                  style="width: 100%" onkeyup="this.value =
                            this.value.toUpperCase()" placeholder="Masukkan nomor rujukan">
              </div>
              <input type="hidden" name="tglperiksa" value="{{date('d-m-Y')}}" class="form-control" style="width: 100%">

              <div class="col-sm-4">
                <button class="btn btn-info col-md-8 col-lg-8 btnCari btn-sm float-left" type="button"
                  onclick="tampil()">
                  <i class="fa fa-search"></i> CARI
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>&nbsp;
                </button>
              </div>
            </div>
          </form>

        </div>
      </div> --}}
            </div>
        </div>

        <div class="row dataKunjungan mt-1">
            <div class="col-lg-12">
                <div class="card border-success">
                    <div class="card-header bg-warning text-light">
                        Hasil Pencarian
                    </div>
                    <form id="formCekin" class="rowAntrian">
                        {{ csrf_field() }}
                        <input type="hidden" name="no_rm" value="{{ $regdum->no_rm }}">
                        <input type="hidden" name="kode_poli"
                            value="{{ @$data[1]['rujukan']['poliRujukan']['kode'] ?? @$dataSkdp['poliTujuan'] }}">
                        <input type="hidden" name="nik"
                            value="{{ @$data[1]['rujukan']['peserta']['nik'] ?? @$regdum->nik }}">
                        {{-- <input type="hidden" name="nohp" value="{{@$data[1]['rujukan']['peserta']['mr']['noTelepon']}}"> --}}
                        <input type="hidden" name="nomorkartu"
                            value="{{ @$data[1]['rujukan']['peserta']['noKartu'] ?? @$regdum->nomorkartu }}">
                        <input type="hidden" name="id_reg_dum" value="{{ $regdum->id }}">
                        {{-- <input type="hidden" name="diagnosa_awal" value="{{@$data[1]['rujukan']['diagnosa']['kode']}}"> --}}
                        <input type="hidden" id="no_rujukan" name="no_rujukan"
                            value="{{ (old('jenisKunjungan', '') == '3' && old('tipeKunjungan', '') == 'postrawat')
                                        ? ($surkon['no_sep'] ?? '')
                                        : ($data[1]['rujukan']['noKunjungan'] ?? ($dataSkdp['sep']['provPerujuk']['noRujukan'] ?? '')) }}">
                            {{-- value="{{ @$data[1]['rujukan']['noKunjungan'] ?? $dataSkdp['sep']['provPerujuk']['noRujukan'] }}"> --}}
                        <input type="hidden" name="tgl_rujukan"
                            value="{{ @$data[1]['rujukan']['tglKunjungan'] ?? @$dataSkdp['tglRencanaKontrol'] }}">
                        <input type="hidden" name="ppk_rujukan"
                            value="{{ @$data[1]['rujukan']['provPerujuk']['kode'] ?? @$dataSkdp['sep']['provPerujuk']['kdProviderPerujuk'] }}">
                        <input type="hidden" name="nama_ppk_rujukan"
                            value="{{ @$data[1]['rujukan']['provPerujuk']['nama'] ?? @$dataSkdp['sep']['provPerujuk']['nmProviderPerujuk'] }}">
                        <input type="hidden" name="poli_bpjs"
                            value="{{ @$data[1]['rujukan']['poliRujukan']['kode'] ?? @$dataSkdp['poliTujuan'] }}">
                        <input type="hidden" name="asalRujukan"
                            value="{{ @$data[1]['asalFaskes'] ?? @$dataSkdp['sep']['provPerujuk']['asalRujukan'] }}">
                        <input type="hidden" name="hak_kelas_inap"
                            value="{{ @$data[1]['rujukan']['peserta']['hakKelas']['kode'] }}">
                        <input type="hidden" name="hak_kelas_inap_naik" value="">
                        <input type="hidden" name="nama" value="{{ @$regdum->nama }}">
                        <input type="hidden" name="jeniskelamin" value="{{ @$regdum->kelamin }}">
                        <input type="hidden" name="tanggallahir" value="{{ @$regdum->tgllahir }}">
                        <input type="hidden" value="0" name="katarak">
                        {{-- <input type="hidden" value="" name="flagProcedure">
          <input type="hidden" value="" name="kdPenunjang"> --}}
                        {{-- TUJUAN NORMAL --}}
                        {{-- <input type="hidden" value="2" name="tujuanKunj"> --}}
                        {{-- RUJUKAN FKTP --}}
                        {{-- <input type="hidden" value="1" name="jenisKunjungan"> --}}
                        {{-- <input type="hidden" value="5" name="assesmentPel"> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" style="float: none;margin: 0 auto;">
                                    <table class="table table-hover table-bordered text-sm"
                                        style="font-size: 12px !important;margin: auto !important;">
                                        <thead>
                                            <tr style="display:none;">
                                                <th>No. Rujukan</th>
                                                <td id="noRujukanField">
                                                    {{-- nilai awal --}}
                                                    @php
                                                        $jenis = old('jenisKunjungan', '');
                                                        $tipe = old('tipeKunjungan', '');
                                                    @endphp
                                                    @if($jenis == '3' && $tipe == 'postrawat')
                                                        {{ @$surkon['no_sep'] }}
                                                    @else
                                                        {{ @$data[1]['rujukan']['noKunjungan'] ?? @$regdum->no_rujukan }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:150px;vertical-align: middle;">Jenis Kunjungan</th>
                                                <td>

                                                    {{-- <b>KONTROL</b> --}}
                                                    {{-- <input type="hidden" id="jenisKunjungan" name="jenisKunjungan" class="form-control" value="1" readonly/> --}}
                                                    <select name="jenisKunjungan" class="form-control select2" id="jenisKunjungan"
                                                        style="width:100%">
                                                        <option value="3" data-tipe="kontrol"
                                                            {{ old('jenisKunjungan', '') == '3' ? 'selected' : '' }}>
                                                            Kontrol</option>
                                                        <option value="3" data-tipe="postrawat"
                                                            {{ old('jenisKunjungan', '') == '3' ? 'selected' : '' }}>
                                                            POST RAWAT</option>
                                                        <option value="2"
                                                            {{ old('jenisKunjungan', '') == '2' ? 'selected' : '' }}>
                                                            Rujukan Internal</option>
                                                        <option value="4"
                                                            {{ old('jenisKunjungan', '') == '4' ? 'selected' : '' }}>
                                                            Rujukan Antar RS</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('jenisKunjungan') }}</small>

                                                    {{-- <label>0: Konsul Dokter, 1: Prosedur, 2: Normal</label> --}}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                        <th>No. SKDP</th>
                        <td><b style="color:red">{{$regdum->no_rujukan}}</b></td>
                      </tr> --}}
                                            <tr>
                                                <th style="width:150px;">Nama (RM)</th>
                                                <td> <span class="nama"></span> <b
                                                        style="font-weight:700">{{ @$regdum->nama }}<span class="norm">
                                                            ({{ $regdum->no_rm }})</span></b>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                        <th style="width:150px;">Kelamin</th>
                        <td> <span class="kelamin"></span> </td>
                      </tr> --}}
                                            {{-- <tr>
                        <th style="width:150px;">Tgl. Lahir</th>
                        <td> <span class="tgllahir"></span> </td>
                      </tr> --}}
                                            <tr>
                                                <th style="width:150px;">No. Kartu</th>
                                                <td> <span class="noka">{{ @$regdum->nomorkartu }}</span> </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <th style="width:150px;">Perujuk / Poli Tujuan</th>
                                                <td> <span
                                                        class="perujuk">{{ @$data[1]['rujukan']['provPerujuk']['nama'] ?? @$dataSkdp['sep']['provPerujuk']['nmProviderPerujuk'] }}</span>
                                                    <b>/</b>
                                                    {{ @$data[1]['rujukan']['poliRujukan']['nama'] ?? @$dataSkdp['poliTujuan'] }}
                                                </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <th style="width:150px;">Diagnosa</th>
                                                <td>
                                                    {{-- <span class="perujuk">{{@@$data[1]['rujukan']['provPerujuk']['nama']}}</span> <b>/</b> {{@$data[1]['rujukan']['diagnosa']['kode']}} --}}
                                                    <input type="text" id="diagnosa_awal" name="diagnosa_awal"
                                                        class="form-control"
                                                        value="{{ @$data[1]['rujukan']['diagnosa']['kode'] ?? @explode(' - ', @$dataSkdp['sep']['diagnosa'])[0] }}" />
                                                </td>

                                            </tr>
                                            <tr id="row_ppk_rujukan" style="display:none;">
                                                <th style="width:150px;">PPK RUJUKAN</th>
                                                <td>
                                                    <input type="text" readonly name="ppk_rujukan" id="ppk_text"
                                                        value="1002R006" disabled>
                                                    <input type="text" readonly name="nama_ppk_rujukan"
                                                        id="nama_ppk_text" value="RSUD OTISTA" disabled>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                        <th style="width:150px;">Poli Tujuan</th>
                        <td> 
                          <span class="poli">{{@$data[1]['rujukan']['poliRujukan']['nama']}}</span>
                        </td> 
                      </tr> --}}
                                            <tr>
                                                <th style="width:150px;">No. Telp</th>
                                                <td>
                                                    <input type="text" id="noHp" name="nohp"
                                                        class="form-control"
                                                        value="{{ @$data[1]['rujukan']['peserta']['mr']['noTelepon'] ?? @$regdum->no_hp }}" />
                                                </td>
                                                </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <th style="width:150px;">No. Surat Kontrol</th>
                                                <td>
                                                    {{-- @if ($no_surkon[1])
                            <select name="noSurat" id="noSurat" class="form-control nosurkonnew">
                              @foreach ($no_surkon[1]['list'] as $item)
                                <option value="{{$item['noSuratKontrol']}}">{{$item['noSuratKontrol']}} ({{date('d-m-Y',strtotime($item['tglRencanaKontrol']))}})</option>  
                              @endforeach
                            </select>
                          @else --}}
                                                    <input type="text" id="noSurat" name="noSurat"
                                                        class="form-control" value="{{ $no_surkon }}" />
                                                    {{-- @endif  --}}
                                                </td>
                                            </tr>
                                            <tr style="display:none;">
                                            <th style="width:150px;vertical-align: middle;">Tujuan Kunjungan</th>
                                            <td>
                                                {{-- @if (@$surkon['tujuanKunj'])
                            <b>{{strtoupper(@baca_tujuankunj($surkon['tujuanKunj']))}}</b>
                            <input type="hidden" id="tujuanKunj" name="tujuanKunj" class="form-control" value="{{$surkon['tujuanKunj']}}" readonly/>
                          @else --}}
                                                {{-- <b>Konsul Dokter</b>
                            <input type="hidden" id="tujuanKunj" name="tujuanKunj" class="form-control" value="2" readonly/> --}}
                                                <select name="tujuanKunj" id="tujuanKunj" class="form-control select2">
                                                    <option value="0" selected>NORMAL</option>
                                                    <option value="1">PROSEDUR</option>
                                                    <option value="2">KONSUL DOKTER</option>
                                                </select>
                                                {{-- @endif --}}
                                                {{-- <label>0: Konsul Dokter, 1: Prosedur, 2: Normal</label> --}}
                                            </td>
                                            </tr>
                                            {{-- @if (@$surkon['flagProcedure']) --}}
                                            <tr style="display:none;">
                                                <th style="width:150px;vertical-align: middle;">Flag Procedure</th>
                                                <td>

                                                    {{-- <b>{{strtoupper(@baca_flag_procedure($surkon['flagProcedure']))}}</b>
                            <input type="hidden" id="flagProcedure" name="flagProcedure" class="form-control" value="{{$surkon['flagProcedure']}}" readonly/> --}}
                                                    <select name="flagProcedure" class="form-control" style="width:100%">
                                                        <option value="">--Lewati Jika Tujuan Kunjungan "Normal"--
                                                        </option>
                                                        <option value="0"
                                                            {{ old('flagProcedure') == '0' ? 'selected' : '' }}>Prosedur
                                                            Tidak Berkelanjutan</option>
                                                        <option value="1"
                                                            {{ old('flagProcedure') == '1' ? 'selected' : '' }}>Prosedur
                                                            dan Terapi Berkelanjutan</option>
                                                    </select>
                                                    {{-- <label>0 = Prosedur Tidak Berkelanjutan, 1 = Prosedur dan Terapi Berkelanjutan</label> --}}
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                            {{-- @if (@$surkon['kdPenunjang']) --}}
                                            <tr style="display:none;">
                                                <th style="width:150px;vertical-align: middle;">Kd. Penunjang</th>
                                                <td>
                                                    {{-- <b>{{strtoupper(@baca_layanan($surkon['kdPenunjang']))}}</b>
                            <input type="hidden" id="kdPenunjang" name="kdPenunjang" value="{{$surkon['kdPenunjang']}}" readonly/> --}}
                                                    {{-- <label>
                              1: Radioterapi, 2: Kemoterapi, 3: Rehabilitasi Medik, 4: Rehabilitasi Psikososial, 5: Transfusi Darah, 6: Pelayanan Gigi,  
                              7: Laboratorium, 8: USG, 9: Farmasi, 10: Lain-Lain, 11: MRI, 12: Hemodialisa
                            </label> --}}
                                                    <select name="kdPenunjang" class="form-control" style="width:100%">
                                                        <option value="">--Lewati Jika Tujuan Kunjungan "Normal"--
                                                        </option>
                                                        <option value="1"
                                                            {{ old('kdPenunjang') == '1' ? 'selected' : '' }}>Radioterapi
                                                        </option>
                                                        <option value="2"
                                                            {{ old('kdPenunjang') == '2' ? 'selected' : '' }}>Kemoterapi
                                                        </option>
                                                        <option value="3"
                                                            {{ old('kdPenunjang') == '3' ? 'selected' : '' }}>Rehabilitasi
                                                            Medik</option>
                                                        <option value="4"
                                                            {{ old('kdPenunjang') == '4' ? 'selected' : '' }}>Rehabilitasi
                                                            Psikososial</option>
                                                        <option value="5"
                                                            {{ old('kdPenunjang') == '5' ? 'selected' : '' }}>Transfusi
                                                            Darah</option>
                                                        <option value="6"
                                                            {{ old('kdPenunjang') == '6' ? 'selected' : '' }}>Pelayanan
                                                            Gigi</option>
                                                        <option value="7"
                                                            {{ old('kdPenunjang') == '7' ? 'selected' : '' }}>Laboratorium
                                                        </option>
                                                        <option value="8"
                                                            {{ old('kdPenunjang') == '8' ? 'selected' : '' }}>USG</option>
                                                        <option value="9"
                                                            {{ old('kdPenunjang') == '9' ? 'selected' : '' }}>Farmasi
                                                        </option>
                                                        <option value="10"
                                                            {{ old('kdPenunjang') == '10' ? 'selected' : '' }}>Lain-Lain
                                                        </option>
                                                        <option value="11"
                                                            {{ old('kdPenunjang') == '11' ? 'selected' : '' }}>MRI</option>
                                                        <option value="12"
                                                            {{ old('kdPenunjang') == '12' ? 'selected' : '' }}>Hemodialisa
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            {{-- @endif  --}}
                                            <tr style="display:none;">
                                                {{-- <th style="width:150px;vertical-align: middle;">Assesment Pelayanan</th> --}}
                                                <th style="width:150px;vertical-align: middle;">Assesment Pelayanan</th>
                                                <td>
                                                    {{-- @if (@$surkon['assesmentPel'])
                              <b>{{strtoupper(@baca_alasan_kontrol($surkon['assesmentPel']))}}</b>
                              <input type="hidden" id="assesmentPel" name="assesmentPel" class="form-control" value="{{$surkon['assesmentPel']}}" readonly/>
                              @else
                              <b>Tujuan Kontrol</b>
                              <input type="hidden" id="assesmentPel" name="assesmentPel" class="form-control" value="5" readonly/>
                            @endif --}}
                                                    {{-- <label>
                            1: Poli spesialis tidak tersedia pada hari sebelumnya,  
                            2: Jam Poli telah berakhir pada hari sebelumnya,  
                            3: Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya,  
                            4: Atas Instruksi RS,  
                            5: Tujuan Kontrol
                            </label> --}}
                                                    <select name="assesmentPel" class="form-control" style="width:100%">
                                                        <option value="">--Lewati Jika Tujuan Kunjungan "Normal"--
                                                        </option>
                                                        <option value="1"
                                                            {{ old('assesmentPel') == '1' ? 'selected' : '' }}>Poli
                                                            spesialis tidak tersedia pada hari sebelumnya</option>
                                                        <option value="2"
                                                            {{ old('assesmentPel') == '2' ? 'selected' : '' }}>Jam Poli
                                                            telah berakhir pada hari sebelumnya</option>
                                                        <option value="3"
                                                            {{ old('assesmentPel') == '3' ? 'selected' : '' }}>Dokter
                                                            Spesialis yang dimaksud tidak praktek pada hari sebelumnya
                                                        </option>
                                                        <option value="4"
                                                            {{ old('assesmentPel') == '4' ? 'selected' : '' }}>Atas
                                                            Instruksi RS</option>
                                                        <option value="5"
                                                            {{ old('assesmentPel') == '5' ? 'selected' : '' }}>Tujuan
                                                            Kontrol</option>
                                                    </select>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Dokter</th>
                                                <td>
                                                    <input type="hidden" name="dokter_id"
                                                        value="{{ @$dataSkdp['kodeDokter'] }}_{{ baca_dokter_bpjs(@$dataSkdp['kodeDokter']) }}_{{ @$regdum->jampraktek }}_{{ @$regdum->kode_poli }}_{{ @baca_kode_poli($regdum->kode_poli) }}"
                                                        class="form-control">
                                                    @php
                                                        @$dokter = \App\Models\Pegawai::where(
                                                            'kode_bpjs',
                                                            @$dataSkdp['kodeDokter'],
                                                        )->first();
                                                    @endphp
                                                    {{ $dokter->nama }}
                                                    {{-- @if ($kode_hfis == 201) --}}

                                                    {{-- <input type="hidden" name="dokter_id" value="{{@$regdum->kode_dokter}}_{{baca_dokter_bpjs($regdum->kode_dokter)}}_{{@$regdum->jampraktek}}_{{@$regdum->kode_poli}}_{{@baca_kode_poli($regdum->kode_poli)}}"> --}}
                                                    {{-- <i><b style="color:red;font-size:14px;font-weight:900">Maaf, tidak ada jadwal dokter poli untuk hari ini </b></i>     --}}
                                                    {{-- @else --}}
                                                    {{-- <select name="dokter_id" id="dokter_id" class="form-control select2">
                              @foreach ($dokter_hfis[1] as $item)
                                  <option {{@$dataSkdp['kodeDokter'] == $item['kodedokter'] ? 'selected' :'' }} value="{{$item['kodedokter']}}_{{$item['namadokter']}}_{{$item['jadwal']}}_{{$item['kodepoli']}}_{{$item['namapoli']}}">{{$item['namadokter']}}</option>
                              @endforeach
                            </select> --}}
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                        <th style="width:150px;">Tgl. Kunjungan</th>
                        <td> <span class="tglkunj"></span> </td>
                      </tr> --}}
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        {{-- <tfoot>
                      <tfoot>
                        <tr>
                          <td class="text-center" colspan="6"><span class="status_finger"></span></td>
                        </tr>
                      </tfoot>
                    </tfoot> --}}
                                    </table>

                                    <table style="width:100%;">
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <br />
                                                <button style="background-color:green;border:1px solid green;"
                                                    class="btn btn-success btn-cekin btn-md">CETAK SEP <span
                                                        class="fa fa-print"></span>&nbsp;<span
                                                        class="spinner-border spin-cekin spinner-border-sm d-none"
                                                        role="status" aria-hidden="true"></span>&nbsp;</button>

                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- <div class="col-md-12">
                 
                </div> --}}

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function handleJenisKunjungan() {
                var selected = $('select[name="jenisKunjungan"] option:selected');
                var jenis = selected.val();
                var tipe = selected.data('tipe');

                var assesmentPel = $('select[name="assesmentPel"]');
                var tujuanKunj = $('select[name="tujuanKunj"]');
                var rowRujukan = $('#row_ppk_rujukan');
                var textInputs = $('#ppk_text, #nama_ppk_text');

                // --- Atur assesment otomatis ---
                if (jenis == '3' && tipe == 'kontrol') {
                    assesmentPel.val('5').trigger('change'); // Kontrol
                } else if (jenis == '2') {
                    assesmentPel.val('2').trigger('change'); // Rujukan Internal
                } else {
                    assesmentPel.val('').trigger('change');
                }

                // --- Atur tujuan kunjungan otomatis ---
                if (jenis == '3' && tipe == 'kontrol') {
                    tujuanKunj.val('2').trigger('change'); // Konsul Dokter
                } else {
                    tujuanKunj.val('0').trigger('change'); // Normal/default
                }

                // --- Tampilkan/sembunyikan input text ---
                if (jenis == '1') {
                    // Jika Rujukan FKTP → tampilkan input text, aktifkan agar dikirim
                    rowRujukan.show();
                    textInputs.prop('disabled', false);
                } else {
                    // Jika bukan Rujukan FKTP → sembunyikan input text, nonaktifkan agar tidak dikirim
                    rowRujukan.hide();
                    textInputs.prop('disabled', true);
                }
            }

            // Jalankan saat load dan saat berubah
            handleJenisKunjungan();
            $('select[name="jenisKunjungan"]').on('change', handleJenisKunjungan);
        });
    </script>
    <script type="text/javascript">
        // submit form reservasi
        $(document).ready(function() {
            // $('#keyword').focus();
            $(".nosurkonnew").select2({
                tags: true,
                allowClear: true
            });
            $('#keyword').keyboard()
            $('#noHp').keyboard()
            $('#noSurat').keyboard()
        })
        $('#formCekin').submit(function(event) {
            event.preventDefault();
            if (!$("#noHp").val()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf...',
                    text: 'No HP wajib diisi'
                })

                return true;
            }
            if (!$("#noSurat").val()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf...',
                    text: 'No. Surat Kontrol wajib diisi'
                })

                return true;
            }
            //  console.log($('#formCekin').serialize())
            //  return
            $.ajax({
                    url: '/reservasi/store-cekin-sep',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#formCekin').serialize(),
                    beforeSend: function() {
                        $('.btn-cekin').addClass('disabled')
                        $('.spin-cekin').removeClass('d-none')
                    },
                    complete: function() {
                        $('.btn-cekin').removeClass('disabled')
                        $('.spin-cekin').addClass('d-none')
                    }
                })
                .done(function(res) {
                    if (res.metadata.code == 201) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Maaf...',
                            text: res.metadata.message
                        })

                    }
                    // console.log(res);
                    // return
                    if (res.metadata.code == 200) {
                        // $('input[name="id_reservasi"]').val(res.response.id);
                        // cetak(res.response.id)
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Berhasil...',
                        //     text: 'Berhasil Cetak SEP, Klik OK Untuk cetak tiket'
                        // }).then(() => {
                        /* Read more about isConfirmed, isDenied below */
                        // return window.location.href = "/reservasi/cetak-sep/"+res.metadata.message
                        return window.location.href = "/reservasi/cetak-baru/" + res.metadata.id + "/" + res
                            .metadata.norm
                        // })

                    }
                    // if(res.metadata.code == '200'){
                    //   Swal.fire({
                    //       icon: 'success',
                    //       title: 'Berhasil...',
                    //       text: 'Berhasil Cekin'
                    //   }).then(() => {
                    //     return window.location.href = "/reservasi/cetak-baru/"+res.metadata.id+"/"+res.metadata.rm
                    //   })

                    // }else{
                    //   Swal.fire({
                    //     icon: 'error',
                    //     title: 'Maaf...',
                    //     text: res.metadata.message
                    //   })
                    // }

                });
        });

        $("#form").submit(function(e) {
            e.preventDefault();
            tampil()
        });

        function tampil() {
            $('.cetak').empty()
            $('dataKunjungan').empty()
            $('.dataKunjungan').addClass('d-none')
            $('.respon').html('');
            $.ajax({
                    url: '/reservasi/cek-baru',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#form').serialize(),
                    beforeSend: function() {
                        $('.btnCari').addClass('disabled')
                        $('.spinner-border').removeClass('d-none')
                    },
                    complete: function() {
                        $('.btnCari').removeClass('disabled')
                        $('.spinner-border').addClass('d-none')
                    }
                })
                .done(function(data) {
                    // console.log(data)
                    // var decompressData = LZString.decompressFromBase64(res);  
                    // data = JSON.parse(data) 
                    // console.log(data)
                    if (data.result[0].metaData.code == 200) {
                        noRujukans = data.result[1].rujukan.noKunjungan
                        url = '/reservasi/cekin-pasien-baru/' + noRujukans
                        return window.location.href = url
                        $('.dataKunjungan').removeClass('d-none')
                        $('dataKunjungan').empty()
                        // console.log(data)
                        // if(data.result.status == 'pending' && data.result.fingerprint.kode == '1'){
                        // if(data.result.status == 'pending'){
                        cetak =
                            '<a style="background-color:green;border:1px solid green;" class="btn btn-success float-right btn-sm" href="/reservasi/checkin/' +
                            data.result.id + '/' + data.result.no_rm +
                            '">CHECK IN <span class="fa fa-print"></span></a>';
                        // }else if(data.result.status == 'checkin'){
                        // cetak = '<a class="btn btn-primary btn-sm" href="/reservasi/cetak/'+data.result.id+'"><span class="fa fa-print"></span>&nbsp;CETAK TIKET</a>';
                        // }
                        // else{
                        //   cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm disabled" href=""><span class="fa fa-print"></span>&nbsp;Lanjutkan</a>';
                        // }
                        // $.each(data.result, function(index, val) {

                        $('.nama').text(data.result[1].rujukan.peserta.nama)
                        $('.noka').text(data.result[1].rujukan.peserta.noKartu)
                        $('.kelamin').text(data.result[1].rujukan.peserta.sex)
                        $('.tgllahir').text(data.result[1].rujukan.peserta.tglLahir)
                        $('.norm').text(data.result[1].rujukan.peserta.mr.noMR)
                        $('.notelp').text(data.result[1].rujukan.peserta.mr.noTelepon)
                        $('.poli').text(data.result[1].rujukan.poliRujukan.nama)
                        $('.keluhan').text(data.result[1].rujukan.keluhan)
                        $('.tglkunj').text(data.result[1].rujukan.tglKunjungan)
                        $('.tglkunj').text(data.result[1].rujukan.tglKunjungan)
                        $('.cetak').append(cetak)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Maaf...',
                            text: data.result[0].metaData.message
                        })
                    }
                });
        }
        // })
    </script>
    <script>
    $(document).ready(function() {
        let noSepPostRawat = `{{ @$surkon['no_sep'] }}`;
        let noRujukanNormal = `{{ @$data[1]['rujukan']['noKunjungan'] ?? @$regdum->no_rujukan }}`;

        $('#jenisKunjungan').on('change', function() {
            let val = $(this).val();
            let tipe = $(this).find(':selected').data('tipe');

            if (val == '3' && tipe == 'postrawat') {
                $('#noRujukanField').text(noSepPostRawat);
                $('#no_rujukan').val(noSepPostRawat);
            } else {
                $('#noRujukanField').text(noRujukanNormal);
                $('#no_rujukan').val(noRujukanNormal);
            }
        });
    });
    </script>
@endsection
