@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .border {
        border: 1px solid black;
    }

    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem;
    }
</style>

@section('header')
    <h1>E-Resume Rawat Inap</h1>
@endsection

@section('content')
@php
  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/resume/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-12">
                            <h5 class="text-center"><b>E-Resume Rawat Inap</b></h5>
                            @php
                                $aswal = @json_decode(@$aswal_ranap->fisik, true);
                                $aswal_igd = @json_decode(@$aswal_igd->fisik, true);
                                $aswal_ponek = @json_decode(@$aswal_ponek->fisik, true);
                                $icd10p = baca_icd10(@$icd10Primary_jkn->icd10);

                                $icd10s = [];
                                if(!empty($icd10Secondary_jkn)) {
                                    foreach($icd10Secondary_jkn as $row) {
                                        $icd = baca_icd10($row->icd10);
                                        if(is_array($icd)) {
                                            $icd10s[] = ($icd['kode'] ?? '').' '.($icd['nama'] ?? '');
                                        } else {
                                            $icd10s[] = $icd;
                                        }
                                    }
                                }

                                $icd9 = baca_icd9(@$icd9_jkn->icd9);
                            @endphp
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Tanggal Kontrol</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tanggal_kontrol]" value="{{@$form['tanggal_kontrol']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tujuan Poliklinik</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[tujuan_poliklinik]" value="{{@$form['tujuan_poliklinik']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Indikasi Rawat Inap</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[indikasi_rawat_inap]" value="{{@$form['indikasi_rawat_inap'] ?? @$aswal['keluhanUtama']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Ringkasan riwayat penyakit</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="10" name="form[ringkasan_riwayat_penyakit]" class="form-control">{{ @$form['ringkasan_riwayat_penyakit'] ?? ('Riwayat Penyakit Sekarang : ' . (@$aswal['riwayat_penyakit_sekarang'] ?? '') . 
'Riwayat Penyakit Dahulu : ' . (@$aswal['riwayatPenyakitDahulu'] ?? '')) }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pemeriksaan fisik</td>
                                    <td style="padding: 5px;">
<textarea rows="10" name="form[pemeriksaan_fisik]" class="form-control">
{{ @$form['pemeriksaan_fisik'] ?? ('Tanda Vital : &#13;&#13;
Tekanan Darah :' . (@$aswal_igd['igdAwal']['tandaVital']['tekananDarah'] ?? @$aswal_ponek['tanda_vital']['tekanan_darah'] ?? @$aswal['tanda_vital']['tekanan_darah']) . '&#13;' . 
'Nadi :' . (@$aswal_igd['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$aswal_ponek['tanda_vital']['nadi'] ?? @$aswal['tanda_vital']['nadi']) . '&#13;' . 
'RR :' . (@$aswal_igd['igdAwal']['tandaVital']['RR'] ?? @$aswal_ponek['tanda_vital']['frekuensi_nafas'] ?? @$aswal['tanda_vital']['RR']) . '&#13;' . 
'Suhu :' . (@$aswal_igd['igdAwal']['tandaVital']['suhu'] ?? @$aswal_ponek['tanda_vital']['suhu'] ?? @$aswal['tanda_vital']['temp']) . '&#13;' . 
'Berat Badan :' . (@$aswal_igd['igdAwal']['tandaVital']['BB'] ?? @$aswal_ponek['tanda_vital']['BB'] ?? @$aswal['tanda_vital']['BB']) . '&#13;' . 
'Tinggi Badan :' . (@$aswal_ponek['tanda_vital']['TB'] ?? @$aswal['tanda_vital']['TB']) .
( !empty($aswal_igd['igdAwal']['glasgow']['GCS']) ? '&#13;GCS :' . $aswal_igd['igdAwal']['glasgow']['GCS'] : '' ) .
( !empty($aswal_igd['igdAwal']['skalaNyeri']) ? '&#13;Skala Nyeri :' . $aswal_igd['igdAwal']['skalaNyeri'] : '' )
) }}
@if(strpos(@$form['pemeriksaan_fisik'],'Status Generalis:') === false) @if(@$aswal['statusGeneralis'])&#13;&#13;Status Generalis: {{@$aswal['statusGeneralis']}}@endif @if(@$aswal['status_generalis'] && !is_array(@$aswal['status_generalis']))&#13;&#13;Status Generalis: {{@$aswal['status_generalis']}}@endif @endif</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pemeriksaan penunjang</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <a href="{{ url('emr/pemeriksaan-lab/' . $unit . '/' . $reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" class="btn btn-danger btn-sm" target="_blank">Hasil Laboratorium</a>
                                            <a href="{{ url('emr/pemeriksaan-rad/' . $unit . '/' . $reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" class="btn btn-info btn-sm" target="_blank">Hasil Radiologi</a>
                                          </div>
                                        @if (!empty(@$form['pemeriksaan_penunjang']))
                                            <textarea rows="10" type="text" name="form[pemeriksaan_penunjang]" class="form-control" >{{@$form['pemeriksaan_penunjang']}}</textarea>
                                        @else
                                            <textarea rows="10" type="text" name="form[pemeriksaan_penunjang]" class="form-control" >Laboratorium: @foreach(@$laboratorium as $lab) {{@$lab->namatarif}}, @endforeach &#13;&#13;Radiologi: @foreach(@$radiologi as $rad) {{@$rad->namatarif}}, @endforeach</textarea>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Terapi atau pengobatan selama di rumah_sakit</td>
                                    <td style="padding: 5px;">
                                        {{-- <input type="text" name="form[terapi_di_rumah_sakit]" value="{{@$form['terapi_di_rumah_sakit'] ?? @$aswal['Tindakan']}}" class="form-control" /> --}}
                                        <textarea name="form[terapi_di_rumah_sakit]" class="form-control" rows="5">{{@$form['terapi_di_rumah_sakit'] ?? @$aswal['Tindakan'] ?? @$aswal['planning'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    @php
                                        $soap = App\Emr::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
                                    @endphp
                                    <td style="width:40%;">Catatan</td>
                                    <td style="padding: 5px;">
                                        <textarea name="form[catatan]" class="form-control">{{@$form['catatan'] ?? @$soap->keterangan}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Reaksi Obat</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pasien_usia_lanjut][pilihan]"
                                                id="reaksi_tidak"
                                                {{ @$form['pasien_usia_lanjut']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                                type="radio" value="Tidak">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pasien_usia_lanjut][pilihan]"
                                                id="reaksi_ya"
                                                {{ @$form['pasien_usia_lanjut']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                                type="radio" value="Ya">
                                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                        </div>
                                        <input type="text" id="reaksi_input" name="form[pasien_usia_lanjut][pilihan_ya]" value="{{@$form['pasien_usia_lanjut']['pilihan_ya']}}" class="form-control" />
                                    </td>
                                </tr>
                                @php
                                    $userEdit = (in_array(auth()->user()->id, [1, 567]));
                                @endphp
                                <tr>
                                    <td style="width:40%;">Diagnosa Utama</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                            <input type="text" name="form[diagnosa_utama]" value="{{ @$form['diagnosa_utama'] ?? (is_array(@$aswal['diagnosa']) ? '' : @$aswal['diagnosa']) }}" class="form-control" placeholder="Diagnosa Utama"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                            <input type="text" name="form[icdx_diagnosa_utama]" id="icdx_diagnosa_utama" value="{{@$form['icdx_diagnosa_utama'] ? @$form['icdx_diagnosa_utama'] : @$icd10p }}" class="form-control" placeholder="ICD X" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdxBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdxBtn">Simpan</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Diagnosa Tambahan</td>
                                    <td style="padding: 5px;" id="diagnosa_tambahan">
                                        <button class="btn btn-flat btn-primary btn-sm" type="button" onclick="cloneDiagnosaTambahan()">
                                            <i class="fa fa-plus"></i> Tambah diagnosa tambahan
                                        </button>

                                        {{-- Diagnosa tambahan utama --}}
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                            <input type="text" name="form[diagnosa_tambahan]" 
                                                value="{{ @$form['diagnosa_tambahan'] ?? @$aswal['diagnosa_tambahan'] }}" 
                                                class="form-control" placeholder="Diagnosa Tambahan"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                            <input type="text" name="form[icdx_diagnosa_tambahan]" id="icdx_diagnosa_tambahan" 
                                                value="{{ @$form['icdx_diagnosa_tambahan'] ? @$form['icdx_diagnosa_tambahan'] : ($icd10s[0] ?? '') }}" 
                                                class="form-control" placeholder="ICD X" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdxTambahanBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdxTambahanBtn">Simpan</button>
                                            @endif
                                        </div>

                                        {{-- Diagnosa tambahan lainnya --}}
                                        @if (is_array(@$form['tambahan_icdx_diagnosa_tambahan']) && is_array(@$form['tambahan_diagnosa_tambahan']))
                                            {{-- kalau user sudah pernah isi form --}}
                                            @foreach (@$form['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                                                <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                                    <input type="text" name="form[tambahan_diagnosa_tambahan][{{$key}}]" 
                                                        value="{{ @$form['tambahan_diagnosa_tambahan'][$key] }}" 
                                                        class="form-control" placeholder="Diagnosa Tambahan"/>
                                                    <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                    <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][{{$key}}]" 
                                                        value="{{ @$form['tambahan_icdx_diagnosa_tambahan'][$key] ?? ($icd10s[$key+1] ?? '') }}" 
                                                        class="form-control" placeholder="ICD X"/>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- kalau form kosong, tampilkan semua data dari $icd10s (selain yg pertama karena sudah dipakai di atas) --}}
                                            @foreach ($icd10s as $key => $icd)
                                                @if ($key > 0)
                                                    <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                                        <input type="text" name="form[tambahan_diagnosa_tambahan][{{$key}}]" 
                                                            value="" class="form-control" placeholder="Diagnosa Tambahan"/>
                                                        <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                        <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][{{$key}}]" 
                                                            value="{{ $icd }}" 
                                                            class="form-control" placeholder="ICD X"/>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tindakan / Prosedur / Operasi</td>
                                    <td style="padding: 5px;" id="tindakan_prosedur_operasi">
                                        <button class="btn btn-flat btn-primary btn-sm" type="button" onclick="cloneTindakanProsedurOperasi()"><i class="fa fa-plus"> Tambah Tindakan / Prosedur / Operasi</i></button>
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                            <input type="text" name="form[tindakan]" value="{{@$form['tindakan']}}" class="form-control" placeholder="Tindakan"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD IX</button>
                                            <input type="text" name="form[icdix_tindakan]" id="icdix_tindakan" value="{{@$form['icdix_tindakan'] ? @$form['icdix_tindakan'] : @$icd9 }}" class="form-control" placeholder="ICD IX" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdixBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdixBtn">Simpan</button>
                                            @endif
                                        </div>
                                        @if (is_array(@$form['tambahan_icdix_tindakan']) && is_array(@$form['tambahan_tindakan']))
                                            @foreach (@$form['tambahan_tindakan'] as $key => $tindakan)
                                                <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                                    <input type="text" name="form[tambahan_tindakan][{{$key}}]" value="{{@$form['tambahan_tindakan'][$key]}}" class="form-control" placeholder="Tindakan / Prosedur / Operasi"/>
                                                    <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                    <input type="text" name="form[tambahan_icdix_tindakan][{{$key}}]" value="{{@$form['tambahan_icdix_tindakan'][$key]}}" class="form-control" placeholder="ICD IX"/>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Instruksi perawatan lanjutan / Edukasi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[edukasi]" value="{{@$form['edukasi']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Cara Pulang</td>
                                    <td style="padding: 5px;">
                                        <select name="form[cara_pulang]" class="select2" style="width: 100%;" required>
                                            <option value="" selected disabled>-- Pilih salah satu --</option>
                                            <option {{@$form['cara_pulang'] == "Izin dokter" ? 'selected' : ''}} value="Izin dokter">Izin dokter</option>
                                            <option {{@$form['cara_pulang'] == "Pindah RS" ? 'selected' : ''}} value="Pindah RS">Pindah RS</option>
                                            <option {{@$form['cara_pulang'] == "APS" ? 'selected' : ''}} value="APS">APS</option>
                                            <option {{@$form['cara_pulang'] == "Melariksan Diri" ? 'selected' : ''}} value="Melariksan Diri">Melarikan Diri</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Kondisi saat pulang</td>
                                    <td style="padding: 5px;">
                                        <select name="form[kondisi_pulang]" class="select2" style="width: 100%;">
                                            <option value="" selected disabled>-- Pilih salah satu --</option>
                                            <option {{@$form['kondisi_pulang'] == "Sembuh" ? 'selected' : ''}} value="Sembuh">Sembuh</option>
                                            <option {{@$form['kondisi_pulang'] == "Perbaikan" ? 'selected' : ''}} value="Perbaikan">Perbaikan</option>
                                            <option {{@$form['kondisi_pulang'] == "Tidak sembuh" ? 'selected' : ''}} value="Tidak sembuh">Tidak sembuh</option>
                                            <option {{@$form['kondisi_pulang'] == "Meninggal" ? 'selected' : ''}} value="Meninggal">Meninggal</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Terapi Pulang</td>
                                    <td style="padding: 5px;">
                                        <textarea name="form[terapi_pulang_detail]" class="form-control" rows="5">{{@$form['terapi_pulang_detail']}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tanggal Pulang</td>
                                    <td style="padding: 5px;">
                                        <input type="text"
                                        {{-- name="tgl_keluar" --}}
                                            value="{{ @$rawatInap->tgl_keluar }}" 
                                            class="form-control" readonly/>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- <div class="col-md-12">
                            <h5><b>TERAPI PULANG</b></h5>
                            <div style="display: flex; justify-content:end; margin-bottom: 1rem;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" id="tambah_terapi"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                            <table class="border" style="width: 100%;" id="table_terapi"> --}}
                                {{-- Template Row Table --}}
                                {{-- <tr class="border" id="daftar_terapi_template" style="display: none;">
                                    <td class="border bold p-1 text-center">1</td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[terapi_pulang][1][nama_obat]" value="" class="form-control"  disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[terapi_pulang][1][jumlah_obat]" value="" class="form-control"  disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[terapi_pulang][1][dosis]" value="" class="form-control"  disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[terapi_pulang][1][frekuensi]" value="" class="form-control"  disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[terapi_pulang][1][cara_pemberian]" value="" class="form-control"  disabled/>
                                    </td>
                                </tr> --}}
                                {{-- End Template Row Table --}}
                                {{-- <tr class="border">
                                    <td class="border bold p-1 text-center">NO</td>
                                    <td class="border bold p-1 text-center">NAMA OBAT</td>
                                    <td class="border bold p-1 text-center">JUMLAH</td>
                                    <td class="border bold p-1 text-center">DOSIS</td>
                                    <td class="border bold p-1 text-center">FREKUENSI</td>
                                    <td class="border bold p-1 text-center">CARA PEMBERIAN</td>
                                </tr>
                                @if (isset($form['terapi_pulang']))
                                  @foreach ($form['terapi_pulang'] as $key => $obat)
                                    <tr class="border daftar_terapi">
                                        <td class="border bold p-1 text-center">{{$key}}</td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[terapi_pulang][{{$key}}][nama_obat]" value="{{$obat['nama_obat']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[terapi_pulang][{{$key}}][jumlah_obat]" value="{{$obat['jumlah_obat']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[terapi_pulang][{{$key}}][dosis]" value="{{$obat['dosis']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[terapi_pulang][{{$key}}][frekuensi]" value="{{$obat['frekuensi']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[terapi_pulang][{{$key}}][cara_pemberian]" value="{{$obat['cara_pemberian']}}" class="form-control" />
                                        </td>
                                    </tr>
                                  @endforeach
                                @endif
                            </table>
                        </div>

                        <br /><br />
                    </div> --}}


                </div>

                @if (!isset($form))
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <input type="checkbox" name="is_draft" {{@$riwayat->is_draft ? 'checked' : ''}} data-toggle="toggle" data-on="Draft" data-off="Public" data-onstyle="danger" data-offstyle="success">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                @else
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <input type="checkbox" name="is_draft" {{$riwayat->is_draft ? 'checked' : ''}} data-toggle="toggle" data-on="Draft" data-off="Public" data-onstyle="danger" data-offstyle="success">
                        @if (!empty(json_decode($riwayat->tte)->base64_signed_file))
                            <a href="{{url('cetak-tte-eresume-pasien-inap/pdf/' . $riwayat->id)}}" class="btn btn-warning">Cetak</a>
                        @else
                            <a href="{{url('cetak-eresume-pasien-inap/pdf/' . $riwayat->id)}}" class="btn btn-warning">Cetak</a>
                        @endif
                        <button class="btn btn-danger">Perbarui</button>
                    </div>
                @endif
            </form>
            <br />
            <br />

        </div>
    
        </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            //ICD 10
            $('.select2').select2();
            $("input[name='diagnosa_awal']").on('focus', function() {
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
                    ajax: '/sep/geticd9',
                    columns: [
                        // {data: 'rownum', orderable: false, searchable: false},
                        {
                            data: 'id'
                        },
                        {
                            data: 'nomor'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'add',
                            searchable: false
                        }
                    ]
                });
            });

            $(document).on('click', '.addICD', function(e) {
                document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
                $('#ICD10').modal('hide');
            });
            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('required', true);
        </script>
        <script>
            let key= $('.daftar_terapi').length + 1;
            $('#tambah_terapi').click(function (e) {
                let row = $('#daftar_terapi_template').clone();
                row.removeAttr('id').removeAttr('style');
                row.find('td:first').text(key);

                row.find('input[name^="form[terapi_pulang]"]').each(function() {
                    let newName = $(this).attr('name').replace(/\d+/, key);
                    $(this).attr('name', newName);
                    $(this).prop('disabled', false);
                });

                key++;
                $('#table_terapi').append(row);
            });

            function cloneDiagnosaTambahan() {
                let html = `<div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                <input type="text" name="form[tambahan_diagnosa_tambahan][]" class="form-control" placeholder="Diagnosa Tambahan"/>
                                <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][]" class="form-control" placeholder="ICD X"/>
                            </div>`
                $('#diagnosa_tambahan').append(html);
            }

            function cloneTindakanProsedurOperasi() {
                let html = `<div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                <input type="text" name="form[tambahan_tindakan][]" class="form-control" placeholder="Tindakan / Prosedur / Operasi Tambahan"/>
                                <button type="button" class="btn btn-default" style="font-size: 12px;">ICD IX</button>
                                <input type="text" name="form[tambahan_icdix_tindakan][]" class="form-control" placeholder="ICD IX"/>
                            </div>`
                $('#tindakan_prosedur_operasi').append(html);
            }
        </script>
        <script>
            $(document).ready(function () {
            $('#editIcdxBtn').on('click', function () {
                $('#icdx_diagnosa_utama').prop('readonly', false).focus();
                $('#editIcdxBtn').addClass('d-none');
                $('#saveIcdxBtn').removeClass('d-none');
            });
            $('#editIcdxTambahanBtn').on('click', function () {
                $('#icdx_diagnosa_tambahan').prop('readonly', false).focus();
                $('#editIcdxTambahanBtn').addClass('d-none');
                $('#saveIcdxTambahanBtn').removeClass('d-none');
            });
            $('#editIcdixBtn').on('click', function () {
                $('#icdix_tindakan').prop('readonly', false).focus();
                $('#editIcdixBtn').addClass('d-none');
                $('#saveIcdixBtn').removeClass('d-none');
            });

            $('#saveIcdxBtn').on('click', function () {
                updateIcdField('icdx_diagnosa_utama', $('#icdx_diagnosa_utama').val(), '#saveIcdxBtn', '#editIcdxBtn', '#icdx_diagnosa_utama');
            });
            $('#saveIcdxTambahanBtn').on('click', function () {
                updateIcdField('icdx_diagnosa_tambahan', $('#icdx_diagnosa_tambahan').val(), '#saveIcdxTambahanBtn', '#editIcdxTambahanBtn', '#icdx_diagnosa_tambahan');
            });
            $('#saveIcdixBtn').on('click', function () {
                updateIcdField('icdix_tindakan', $('#icdix_tindakan').val(), '#saveIcdixBtn', '#editIcdixBtn', '#icdix_tindakan');
            });

            function updateIcdField(key, value, saveBtn, editBtn, inputField) {
                const emrId = '{{ $riwayat->id ?? '' }}';
                $.ajax({
                    url: '{{ route('emr_inap_perencanaan.update_icd') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: emrId,
                        key: key,
                        value: value,
                    },
                    success: function (res) {
                        alert('ICD berhasil disimpan!');
                        $(inputField).prop('readonly', true);
                        $(editBtn).removeClass('d-none');
                        $(saveBtn).addClass('d-none');
                    },
                    error: function () {
                        alert('Gagal menyimpan!');
                    }
                });
            }
        });
        </script>
        <script>
            $(function () {
                const $radios = $("input[name='form[pasien_usia_lanjut][pilihan]']");
                const $input  = $("#reaksi_input");

                function toggleReaksi() {
                const isYa = $radios.filter(":checked").val() === "Ya";
                $input.toggle(isYa);
                $input.prop("required", isYa);
                if (!isYa) { $input.val(''); }
                }
                toggleReaksi();
                $radios.on("change", toggleReaksi);
            });
        </script>
    
        
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @endsection
