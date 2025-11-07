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
    <h1>Perencanaan Pulang Pasien</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/pulang-pasien/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('id', @$perencanaan->id) !!}
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-6">
                            <h5 class="text-center"><b>Perencanaan Pulang Pasien</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Rencana Pulang</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[rencana_pulang]" value="{{@$form['rencana_pulang']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%" colspan="2"><b>BILA SALAH SATU KATEGORINYA TERISI MAKA PASIEN MEMBUTUHKAN PERENCANAAN PULANG KHUSUS</b></td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pasien Usia Lanjut (60 Tahun atau lebih)</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pasien_usia_lanjut][pilihan]"
                                                {{ @$form['pasien_usia_lanjut']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                                type="radio" value="Ya">
                                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pasien_usia_lanjut][pilihan]"
                                                {{ @$form['pasien_usia_lanjut']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                                type="radio" value="Tidak">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Hambatan mobilisasi</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[hambatan_mobilisasi][pilihan]"
                                                {{ @$form['hambatan_mobilisasi']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                                type="radio" value="Ya">
                                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[hambatan_mobilisasi][pilihan]"
                                                {{ @$form['hambatan_mobilisasi']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                                type="radio" value="Tidak">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Membutuhkan pelayanan medis dan perawatan berkelanjutan</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pelayanan_berkelanjutan][pilihan]"
                                                {{ @$form['pelayanan_berkelanjutan']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                                type="radio" value="Ya">
                                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pelayanan_berkelanjutan][pilihan]"
                                                {{ @$form['pelayanan_berkelanjutan']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                                type="radio" value="Tidak">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tergantung dengan orang lain dalam aktifitas harian</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[tergantung_orang_lain][pilihan]"
                                                {{ @$form['tergantung_orang_lain']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                                type="radio" value="Ya">
                                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[tergantung_orang_lain][pilihan]"
                                                {{ @$form['tergantung_orang_lain']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                                type="radio" value="Tidak">
                                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Transportasi Pulang</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[transportasi_pulang]" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Orang yang mendampingi dan merawat pasien dirumah</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[orang_yang_mendampingi]" value="" class="form-control" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Riwayat Perencanaan Pasien Pulang</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%"
                                        class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                        style="font-size:12px;">
                                        @if (count($riwayat) == 0)
                                            <tr>
                                                <td><i>Belum ada riwayat</i></td>
                                            </tr>
                                        @endif
                                        @foreach ($riwayat as $item)
                                            <tr style="{{ $item->id == @$perencanaan->id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                                <td>
                                                    {{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }} (Pembuat : {{ @$item->user->name }})
                                                    <span class="pull-right" style="font-size: 20px">
                                                        <a target="_blank"
                                                            href="{{ url('emr-soap-print-surat-perencanaan-pasien-pulang/' . $unit . '/' . $reg->id . '/' . $item->id) }}"
                                                            data-toggle="tooltip" title="Cetak Surat"><i
                                                                class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;</a>
                                                        <a  onclick="return confirm('Apakah anda yakin ingin menghapus?')"
                                                            href="{{ url('emr-soap-delete/' . $unit . '/' . $reg->id . '/' . $item->id) }}"
                                                            data-toggle="tooltip" title="Hapus Perencanaan"><i
                                                                class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;</a>
                                                        <a href="{{ url()->current() . '?poli=' . @$poli . '&dpjp=' . @$dpjp . '&id=' . $item->id }}"
                                                            data-toggle="tooltip" title="Lihat Perencanaan"><i
                                                                class="fa fa-eye text-info"></i></a>&nbsp;&nbsp;</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h5><b>PENGOBATAN YANG DILAKUKAN DIRUMAH</b></h5>
                            <div style="display: flex; justify-content:end; margin-bottom: 1rem;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" id="tambah_obat"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                            <table class="border" style="width: 100%;" id="table_pengobatan">
                                {{-- Template Row Table --}}
                                <tr class="border" id="daftar_obat_template" style="display: none;">
                                    <td class="border bold p-1 text-center">1</td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[pengobatan_yang_diberikan][1][nama_obat]" value="" class="form-control" disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[pengobatan_yang_diberikan][1][jumlah_dosis]" value="" class="form-control" disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="time" name="form[pengobatan_yang_diberikan][1][jam_pemberian]" value="" class="form-control" disabled/>
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[pengobatan_yang_diberikan][1][instruksi_khusus]" value="" class="form-control" disabled/>
                                    </td>
                                </tr>
                                {{-- End Template Row Table --}}
                                <tr class="border">
                                    <td class="border bold p-1 text-center">NO</td>
                                    <td class="border bold p-1 text-center">NAMA OBAT</td>
                                    <td class="border bold p-1 text-center">JUMLAH DOSIS</td>
                                    <td class="border bold p-1 text-center">JAM PEMBERIAN</td>
                                    <td class="border bold p-1 text-center">INSTRUKSI KHUSUS</td>
                                </tr>
                                @if (isset($form['pengobatan_yang_diberikan']))
                                  @foreach ($form['pengobatan_yang_diberikan'] as $key => $obat)
                                    <tr class="border">
                                        <td class="border bold p-1 text-center">{{$key}}</td>
                                        <td class="border bold p-1">{{$obat['nama_obat']}}</td>
                                        <td class="border bold p-1">{{$obat['jumlah_dosis']}}</td>
                                        <td class="border bold p-1">{{$obat['jam_pemberian']}}</td>
                                        <td class="border bold p-1">{{$obat['instruksi_khusus']}}</td>
                                    </tr>
                                  @endforeach
                                @endif
                            </table>
                        </div>

                        <div class="col-md-12" style="margin-top: 1rem;">
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Diet Khusus</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[diet_khusus]" value="{{@$form['diet_khusus']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%" colspan="2"><b>PERAWATAN/PERALATAN MEDIS YANG DILANJUTKAN DIRUMAH</b></td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Nama alat medis</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][oxygen_portable]"
                                                {{ @$form['nama_alat_medis']['oxygen_portable'] == 'Oxygen Portable' ? 'checked' : '' }}
                                                type="checkbox" value="Oxygen Portable">
                                            <label class="form-check-label" style="font-weight: 400;">Oxygen Portable</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][tracheostomi]"
                                                {{ @$form['nama_alat_medis']['tracheostomi'] == 'Tracheostomi' ? 'checked' : '' }}
                                                type="checkbox" value="Tracheostomi">
                                            <label class="form-check-label" style="font-weight: 400;">Tracheostomi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][d_kateter]"
                                                {{ @$form['nama_alat_medis']['d_kateter'] == 'D-Kateter' ? 'checked' : '' }}
                                                type="checkbox" value="D-Kateter">
                                            <label class="form-check-label" style="font-weight: 400;">D-Kateter</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][ngt]"
                                                {{ @$form['nama_alat_medis']['ngt'] == 'NGT' ? 'checked' : '' }}
                                                type="checkbox" value="NGT">
                                            <label class="form-check-label" style="font-weight: 400;">NGT</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][kursi_roda]"
                                                {{ @$form['nama_alat_medis']['kursi_roda'] == 'Kursi Roda' ? 'checked' : '' }}
                                                type="checkbox" value="Kursi Roda">
                                            <label class="form-check-label" style="font-weight: 400;">Kursi Roda</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][tongkat]"
                                                {{ @$form['nama_alat_medis']['tongkat'] == 'Tongkat' ? 'checked' : '' }}
                                                type="checkbox" value="Tongkat">
                                            <label class="form-check-label" style="font-weight: 400;">Tongkat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[nama_alat_medis][lain]"
                                                {{ @$form['nama_alat_medis']['lain'] == 'Lain-lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain-lain">
                                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                                            <input type="text" name="form[nama_alat_medis][lain_detail]" value="" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pendidikan kesehatan untuk dirumah</td>
                                    <td style="padding: 5px;">
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][1]"
                                                {{ @$form['pendidikan_kesehatan']['1'] == 'Balutan jangan basah atau kotor' ? 'checked' : '' }}
                                                type="checkbox" value="Balutan jangan basah atau kotor">
                                            <label class="form-check-label" style="font-weight: 400;">Balutan jangan basah atau kotor</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][2]"
                                                {{ @$form['pendidikan_kesehatan']['2'] == 'Hindari mengangkat beban' ? 'checked' : '' }}
                                                type="checkbox" value="Hindari mengangkat beban">
                                            <label class="form-check-label" style="font-weight: 400;">Hindari mengangkat beban</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][3]"
                                                {{ @$form['pendidikan_kesehatan']['3'] == 'Jangan menyetir sendiri' ? 'checked' : '' }}
                                                type="checkbox" value="Jangan menyetir sendiri">
                                            <label class="form-check-label" style="font-weight: 400;">Jangan menyetir sendiri</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][4]"
                                                {{ @$form['pendidikan_kesehatan']['4'] == 'Cek lab sebelum kontrol' ? 'checked' : '' }}
                                                type="checkbox" value="Cek lab sebelum kontrol">
                                            <label class="form-check-label" style="font-weight: 400;">Cek lab sebelum kontrol</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][5]"
                                                {{ @$form['pendidikan_kesehatan']['5'] == 'Jangan menaiki tangga lebih dari 3x' ? 'checked' : '' }}
                                                type="checkbox" value="Jangan menaiki tangga lebih dari 3x">
                                            <label class="form-check-label" style="font-weight: 400;">Jangan menaiki tangga lebih dari 3x</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][6]"
                                                {{ @$form['pendidikan_kesehatan']['6'] == 'Dirujuk ke komunitas tertentu' ? 'checked' : '' }}
                                                type="checkbox" value="Dirujuk ke komunitas tertentu">
                                            <label class="form-check-label" style="font-weight: 400;">Dirujuk ke komunitas tertentu</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][7]"
                                                {{ @$form['pendidikan_kesehatan']['7'] == 'Batasi pekerjaan rumah dan kegiatan' ? 'checked' : '' }}
                                                type="checkbox" value="Batasi pekerjaan rumah dan kegiatan">
                                            <label class="form-check-label" style="font-weight: 400;">Batasi pekerjaan rumah dan kegiatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][8]"
                                                {{ @$form['pendidikan_kesehatan']['8'] == 'Melakukan aktivitas secara bertahap' ? 'checked' : '' }}
                                                type="checkbox" value="Melakukan aktivitas secara bertahap">
                                            <label class="form-check-label" style="font-weight: 400;">Melakukan aktivitas secara bertahap</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[pendidikan_kesehatan][9]"
                                                {{ @$form['pendidikan_kesehatan']['9'] == 'Jika muncul keluhan nyeri / rasa sakit' ? 'checked' : '' }}
                                                type="checkbox" value="Jika muncul keluhan nyeri / rasa sakit">
                                            <label class="form-check-label" style="font-weight: 400;">Jika muncul keluhan nyeri / rasa sakit</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Diberikan kepada pasien dan keluarga</td>
                                    <td>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[diberikan_kepasien_keluarga][1]"
                                                {{ @$form['diberikan_kepasien_keluarga']['1'] == 'Obat-obatan' ? 'checked' : '' }}
                                                type="checkbox" value="Obat-obatan">
                                            <label class="form-check-label" style="font-weight: 400;">Obat-obatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[diberikan_kepasien_keluarga][2]"
                                                {{ @$form['diberikan_kepasien_keluarga']['2'] == 'Peralatan/Barang Pribadi' ? 'checked' : '' }}
                                                type="checkbox" value="Peralatan/Barang Pribadi">
                                            <label class="form-check-label" style="font-weight: 400;">Peralatan/Barang Pribadi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[diberikan_kepasien_keluarga][3]"
                                                {{ @$form['diberikan_kepasien_keluarga']['3'] == 'Resep Obat' ? 'checked' : '' }}
                                                type="checkbox" value="Resep Obat">
                                            <label class="form-check-label" style="font-weight: 400;">Resep Obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[diberikan_kepasien_keluarga][4]"
                                                {{ @$form['diberikan_kepasien_keluarga']['4'] == 'Hasil pemeriksaan penunjang' ? 'checked' : '' }}
                                                type="checkbox" value="Hasil pemeriksaan penunjang">
                                            <label class="form-check-label" style="font-weight: 400;">Hasil pemeriksaan penunjang</label>
                                            <input type="text" name="form[diberikan_kepasien_keluarga]['4_detail']" value="" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Instruksi diberikan kepada</td>
                                    <td>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[instruksi_diberikan_kepada][pasien]"
                                                {{ @$form['instruksi_diberikan_kepada']['pasien'] == 'Pasien' ? 'checked' : '' }}
                                                type="checkbox" value="Pasien">
                                            <label class="form-check-label" style="font-weight: 400;">Pasien</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[instruksi_diberikan_kepada][keluarga]"
                                                {{ @$form['instruksi_diberikan_kepada']['keluarga'] == 'Keluarga' ? 'checked' : '' }}
                                                type="checkbox" value="Keluarga">
                                            <label class="form-check-label" style="font-weight: 400;">Keluarga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[instruksi_diberikan_kepada][orang_terdekat]"
                                                {{ @$form['instruksi_diberikan_kepada']['orang_terdekat'] == 'Orang terdekat' ? 'checked' : '' }}
                                                type="checkbox" value="Orang terdekat">
                                            <label class="form-check-label" style="font-weight: 400;">Orang terdekat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="form[instruksi_diberikan_kepada][lain]"
                                                {{ @$form['instruksi_diberikan_kepada']['lain'] == 'Lain-lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain-lain">
                                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                                            <input type="text" name="form[instruksi_diberikan_kepada]['lain_detail']" value="" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <br /><br />
                    </div>


                </div>

                @if (!isset($perencanaan))
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                @else
                    <div class="col-md-12 text-right">
                        <a href="{{url()->current()}}" class="btn btn-primary">Kembali</a>
                    </div>
                @endif
            </form>
            <br />
            <br />
            {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key => $item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}

        </div>

        {{-- Modal Upload Surat Rujukan FKTP --}}
        <div class="modal fade" id="modalUploadPAPS" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" >Upload PAPS</h4>
                    </div>
                    <div class="modal-body" > 
                        <form action="/emr-soap-upload-surat-paps" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id">
                            <div class="form-group" style="padding: 0;">
                                <div class="col-sm-12" style="padding: 0;">
                                    <label for="file">Pilih file</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="margin-top: 2rem;">Simpan</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    </div>
                </div>
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
            let key= 1;
            $('#tambah_obat').click(function (e) {
                let row = $('#daftar_obat_template').clone();
                row.removeAttr('id').removeAttr('style');
                row.find('td:first').text(key);

                row.find('input[name^="form[pengobatan_yang_diberikan]"]').each(function() {
                    let newName = $(this).attr('name').replace(/\d+/, key);
                    $(this).attr('name', newName);
                    $(this).prop('disabled', false);
                });

                key++;
                $('#table_pengobatan').append(row);
            });
        </script>
    @endsection
