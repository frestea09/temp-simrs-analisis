<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asesmen Rawat Inap</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
            /* text-align: left; */
        }
        input, label {
            vertical-align: middle !important;
        }
        @page {
            padding-bottom: .3cm;
        }

        .footer {
          position: fixed; 
          bottom: 0cm; 
          left: 0cm; 
          right: 0cm;
          height: 1cm;
          text-align: justify;
        }
    </style>
</head>

<body>
    @if (isset($cetak_tte))
        <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif
    <table>
        <tr>
            <th colspan="1">
                <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
            </th>
            <th colspan="5" style="font-size: 18pt;">
                <b>ASESMEN AWAL MEDIS NEONATUS</b>
            </th>
        </tr>
        <tr>
            <td colspan="6">
                Tanggal Pemeriksaan : {{ date('d-m-Y', strtotime(@$pemeriksaan->created_at)) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : null }}
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
            <td >
                <b>Dikirim Ke</b>
            </td>
            <td colspan="5">
                <div>
                    <input class="form-check-input"
                        name="fisik[dikirm_oleh][kamar_bersalin]"
                        {{ @$asessment['dikirm_oleh']['kamar_bersalin'] == 'Kamar bersalin RS Otista' ? 'checked' : '' }}
                        type="checkbox" value="Kamar bersalin RS Otista">
                    <label class="form-check-label" style="font-weight: 400;">Kamar bersalin RS Otista</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[dikirm_oleh][dokter]"
                        {{ @$asessment['dikirm_oleh']['dokter'] == 'Dokter' ? 'checked' : '' }}
                        type="checkbox" value="Dokter">
                    <label class="form-check-label" style="font-weight: 400;">Dokter</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[dikirm_oleh][bidan]"
                        {{ @$asessment['dikirm_oleh']['bidan'] == 'Bidan' ? 'checked' : '' }}
                        type="checkbox" value="Bidan">
                    <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[dikirm_oleh][paraji]"
                        {{ @$asessment['dikirm_oleh']['paraji'] == 'Paraji' ? 'checked' : '' }}
                        type="checkbox" value="Paraji">
                    <label class="form-check-label" style="font-weight: 400;">Paraji</label>
                  </div>
                  <div>
                    <input class="form-check-input"
                        name="fisik[dikirm_oleh][lain_lain]"
                        {{ @$asessment['dikirm_oleh']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                        type="checkbox" value="Lain-lain">
                    <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                    {{@$asessment['dikirim_oleh']['lain_detail']}}
                  </div>
            </td>
        </tr>
        <tr>
            <td >
                <b>Indikasi</b>
            </td>
            <td colspan="5">
                {{@$asessment['dikirim_oleh']['atas_indikasi']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>RIWAYAT KEHAMILAN</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="font-weight: bold;">Kehamilan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['kehamilan']}}
                      </td>
                      <td style="font-weight: bold;">Minggu</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['minggu']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Obat-obatan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['obat']}}
                      </td>
                      <td style="font-weight: bold;">Lamanya</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['lamanya']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Jamu-jamu</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['jamu_jamu']}}
                      </td>
                      <td style="font-weight: bold;">Lamanya</td>
                      <td style="padding: 5px;">
                        {{@$asessment['riwayat_kehamilan']['lamanya_jamu']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Usia Kehamilan</td>
                      <td style="padding: 5px;" colspan="3">
                        {{@$asessment['riwayat_kehamilan']['usia_kehamilan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Komplikasi</td>
                      <td style="padding: 5px;" colspan="3">
                        <div style="">
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][eklampsia]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['eklampsia'] == 'Eklampsia' ? 'checked' : '' }}
                                type="checkbox" value="Eklampsia">
                            <label class="form-check-label" style="font-weight: 400;">Eklampsia</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][febris]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['febris'] == 'Febris' ? 'checked' : '' }}
                                type="checkbox" value="Febris">
                            <label class="form-check-label" style="font-weight: 400;">Febris</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][perdarahan]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['perdarahan'] == 'Perdarahan' ? 'checked' : '' }}
                                type="checkbox" value="Perdarahan">
                            <label class="form-check-label" style="font-weight: 400;">Perdarahan</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][hipertensi]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['hipertensi'] == 'Hipertensi' ? 'checked' : '' }}
                                type="checkbox" value="Hipertensi">
                            <label class="form-check-label" style="font-weight: 400;">Hipertensi</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][anemia]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['anemia'] == 'Anemia' ? 'checked' : '' }}
                                type="checkbox" value="Anemia">
                            <label class="form-check-label" style="font-weight: 400;">Anemia</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][komplikasi][lain_lain]"
                                {{ @$asessment['riwayat_kehamilan']['komplikasi']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                                type="checkbox" value="Lain-lain">
                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label> <br>
                            {{@$asessment['riwayat_kehamilan']['komplikasi']['lain_detail']}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Gizi</td>
                      <td style="padding: 5px;" colspan="3">
                        <div style="">
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][baik]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['baik'] == 'Baik' ? 'checked' : '' }}
                                type="checkbox" value="Baik">
                            <label class="form-check-label" style="font-weight: 400;">Baik</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][kurang_baik]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['kurang_baik'] == 'Kurang baik' ? 'checked' : '' }}
                                type="checkbox" value="Kurang baik">
                            <label class="form-check-label" style="font-weight: 400;">Kurang baik</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][buruk]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['buruk'] == 'Buruk' ? 'checked' : '' }}
                                type="checkbox" value="Buruk">
                            <label class="form-check-label" style="font-weight: 400;">Buruk</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Pemeriksaan antenatal</td>
                      <td style="padding: 5px;" colspan="3">
                        <div style="">
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][tidak_pernah]"
                                {{ @$asessment['riwayat_kehamilan']['pemeriksaan_antanetal']['tidak_pernah'] == 'Tidak pernah' ? 'checked' : '' }}
                                type="checkbox" value="Tidak pernah">
                            <label class="form-check-label" style="font-weight: 400;">Tidak pernah</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][tidak_teratur]"
                                {{ @$asessment['riwayat_kehamilan']['pemeriksaan_antanetal']['tidak_teratur'] == 'Tidak teratur' ? 'checked' : '' }}
                                type="checkbox" value="Tidak teratur">
                            <label class="form-check-label" style="font-weight: 400;">Tidak teratur</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][pemeriksaan_antanetal][teratur]"
                                {{ @$asessment['riwayat_kehamilan']['pemeriksaan_antanetal']['teratur'] == 'Teratur' ? 'checked' : '' }}
                                type="checkbox" value="Teratur">
                            <label class="form-check-label" style="font-weight: 400;">Teratur</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Gizi</td>
                      <td style="padding: 5px;" colspan="3">
                        <div style="">
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][baik]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['baik'] == 'Baik' ? 'checked' : '' }}
                                type="checkbox" value="Baik">
                            <label class="form-check-label" style="font-weight: 400;">Baik</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][kurang_baik]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['kurang_baik'] == 'Kurang baik' ? 'checked' : '' }}
                                type="checkbox" value="Kurang baik">
                            <label class="form-check-label" style="font-weight: 400;">Kurang baik</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[riwayat_kehamilan][gizi][buruk]"
                                {{ @$asessment['riwayat_kehamilan']['gizi']['buruk'] == 'Buruk' ? 'checked' : '' }}
                                type="checkbox" value="Buruk">
                            <label class="form-check-label" style="font-weight: 400;">Buruk</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>KELAHIRAN SEKARANG</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Tempat</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['tempat']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Tgl.Lahir/tahun</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['tgl_lahir']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Pukul</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['pukul']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">BB</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['bb']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Panjang</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['panjang']}}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][lahir_mati]"
                              {{ @$asessment['kelahiran_sekarang']['lahir_mati'] == 'Lahir mati' ? 'checked' : '' }}
                              type="checkbox" value="Lahir mati">
                          <label class="form-check-label" style="font-weight: 400;">Lahir mati</label>
                        </div>
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][lahir_hidup]"
                              {{ @$asessment['kelahiran_sekarang']['lahir_hidup'] == 'Lahir hidup' ? 'checked' : '' }}
                              type="checkbox" value="Lahir hidup">
                          <label class="form-check-label" style="font-weight: 400;">Lahir hidup</label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][dirumah_bersalin]"
                              {{ @$asessment['kelahiran_sekarang']['dirumah_bersalin'] == 'Dirumah bersalin' ? 'checked' : '' }}
                              type="checkbox" value="Dirumah bersalin">
                          <label class="form-check-label" style="font-weight: 400;">Dirumah bersalin</label>
                        </div>
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][dokter]"
                              {{ @$asessment['kelahiran_sekarang']['dokter'] == 'Dokter' ? 'checked' : '' }}
                              type="checkbox" value="Dokter">
                          <label class="form-check-label" style="font-weight: 400;">Dokter</label>
                          {{@$asessment['kelahiran_sekarang']['dokter_detail']}}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][dirumah_sakit]"
                              {{ @$asessment['kelahiran_sekarang']['dirumah_sakit'] == 'Dirumah sakit' ? 'checked' : '' }}
                              type="checkbox" value="Dirumah sakit">
                          <label class="form-check-label" style="font-weight: 400;">Dirumah sakit</label>
                        </div>
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][bidan]"
                              {{ @$asessment['kelahiran_sekarang']['bidan'] == 'Bidan' ? 'checked' : '' }}
                              type="checkbox" value="Bidan">
                          <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                          {{@$asessment['kelahiran_sekarang']['bidan_detail']}}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][dirumah]"
                              {{ @$asessment['kelahiran_sekarang']['dirumah'] == 'Dirumah' ? 'checked' : '' }}
                              type="checkbox" value="Dirumah">
                          <label class="form-check-label" style="font-weight: 400;">Dirumah</label>
                        </div>
                        <div>
                          <input class="form-check-input"
                              name="fisik[kelahiran_sekarang][paraji]"
                              {{ @$asessment['kelahiran_sekarang']['paraji'] == 'Paraji' ? 'checked' : '' }}
                              type="checkbox" value="Paraji">
                          <label class="form-check-label" style="font-weight: 400;">Paraji</label>
                          {{@$asessment['kelahiran_sekarang']['paraji_detail']}}
                        </div>
                      </td>
                    </tr>
                  </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>RIWAYAT PERKAWINAN - IBU</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Ibu</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['text']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Perkawinan ke</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['perkawinan_ke']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Usia Pernikahan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['usia_pernikahan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Umur</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['umur']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Penghasilan/bulan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['penghasilan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Pendidikan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['pendidikan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Penyakit</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['penyakit']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Golongan darah</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ibu']['golongan_darah']}}
                      </td>
                    </tr>
                  </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>RIWAYAT PERKAWINAN - AYAH</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Ayah</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['text']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Perkawinan ke</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['perkawinan_ke']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Usia Pernikahan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['usia_pernikahan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Umur</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['umur']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Penghasilan/bulan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['penghasilan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Pendidikan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['pendidikan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Penyakit</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['penyakit']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Golongan darah</td>
                      <td style="padding: 5px;">
                        {{@$asessment['kelahiran_sekarang']['ayah']['golongan_darah']}}
                      </td>
                    </tr>
                  </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PERSALINAN</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Jenis persalinan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['persalinan']['jenis_persalinan']}}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <input class="form-check-input"
                              name="fisik[persalinan][spontan]"
                              {{ @$asessment['persalinan']['spontan'] == 'Spontan' ? 'checked' : '' }}
                              type="checkbox" value="Spontan">
                          <label class="form-check-label" style="font-weight: 400;">Spontan</label>
                        </div>
                        <div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][buatan]"
                                {{ @$asessment['persalinan']['buatan'] == 'Buatan' ? 'checked' : '' }}
                                type="checkbox" value="Buatan">
                            <label class="form-check-label" style="font-weight: 400;">Buatan</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][sc]"
                                {{ @$asessment['persalinan']['sc'] == 'SC' ? 'checked' : '' }}
                                type="checkbox" value="SC">
                            <label class="form-check-label" style="font-weight: 400;">SC</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][ektr_kaki_bokong]"
                                {{ @$asessment['persalinan']['ektr_kaki_bokong'] == 'Ektr. Kaki/Bokong' ? 'checked' : '' }}
                                type="checkbox" value="Ektr. Kaki/Bokong">
                            <label class="form-check-label" style="font-weight: 400;">Ektr. Kaki/Bokong</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][ektr_vac]"
                                {{ @$asessment['persalinan']['ektr_vac'] == 'Ektr. Vac' ? 'checked' : '' }}
                                type="checkbox" value="Ektr. Vac">
                            <label class="form-check-label" style="font-weight: 400;">Ektr. Vac</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][ektr_forc]"
                                {{ @$asessment['persalinan']['ektr_forc'] == 'Ektr. Forc' ? 'checked' : '' }}
                                type="checkbox" value="Ektr. Forc">
                            <label class="form-check-label" style="font-weight: 400;">Ektr. Forc</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][versixtr]"
                                {{ @$asessment['persalinan']['versixtr'] == 'Versixtr' ? 'checked' : '' }}
                                type="checkbox" value="Versixtr">
                            <label class="form-check-label" style="font-weight: 400;">Versixtr</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][lain]"
                                {{ @$asessment['persalinan']['lain'] == 'Lain' ? 'checked' : '' }}
                                type="checkbox" value="Lain">
                            <label class="form-check-label" style="font-weight: 400;">Lain</label>
                            {{@$asessment['persalinan']['lain_detail']}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Indikasi</td>
                      <td style="padding: 5px;">
                        {{@$asessment['persalinan']['indikasi']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Obat-obatan selama persalinan</td>
                      <td style="padding: 5px;">
                        <div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][obat_obatan][anestesi]"
                                {{ @$asessment['persalinan']['obat_obatan']['anestesi'] == 'Anestesi' ? 'checked' : '' }}
                                type="checkbox" value="Anestesi">
                            <label class="form-check-label" style="font-weight: 400;">Anestesi</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][obat_obatan][analgetik]"
                                {{ @$asessment['persalinan']['obat_obatan']['analgetik'] == 'Analgetik' ? 'checked' : '' }}
                                type="checkbox" value="Analgetik">
                            <label class="form-check-label" style="font-weight: 400;">Analgetik</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[persalinan][obat_obatan][lain_lain]"
                                {{ @$asessment['persalinan']['obat_obatan']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                                type="checkbox" value="Lain-lain">
                            <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                            {{@$asessment['persalinan']['obat_obatan']['lain_detail']}}
                          </div>
                        </div>
                      </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>TANDA VITAL</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Distress</td>
                      <td>
                        <div>
                          <input class="form-check-input"
                              name="fisik[tanda_vital][distress][tidak_ada]"
                              {{ @$asessment['tanda_vital']['distress']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                              type="checkbox" value="Tidak ada">
                          <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                        </div>
                        <div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][distress][ada]"
                                {{ @$asessment['tanda_vital']['distress']['ada'] == 'Ada' ? 'checked' : '' }}
                                type="checkbox" value="Ada">
                            <label class="form-check-label" style="font-weight: 400;">Ada : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][distress][dj160]"
                                {{ @$asessment['tanda_vital']['distress']['dj160'] == '> Dj. 160' ? 'checked' : '' }}
                                type="checkbox" value="> Dj. 160">
                            <label class="form-check-label" style="font-weight: 400;">> Dj. 160 : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][distress][dj_irreguler]"
                                {{ @$asessment['tanda_vital']['distress']['dj_irreguler'] == 'Dj. Irreguler' ? 'checked' : '' }}
                                type="checkbox" value="Dj. Irreguler">
                            <label class="form-check-label" style="font-weight: 400;">Dj. Irreguler : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][distress][dj_100]"
                                {{ @$asessment['tanda_vital']['distress']['dj_100'] == '< Dj. 100' ? 'checked' : '' }}
                                type="checkbox" value="< Dj. 100">
                            <label class="form-check-label" style="font-weight: 400;">&lt; Dj. 100 : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][distress][meconium]"
                                {{ @$asessment['tanda_vital']['distress']['meconium'] == 'Meconium' ? 'checked' : '' }}
                                type="checkbox" value="Meconium">
                            <label class="form-check-label" style="font-weight: 400;">Meconium : </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Distress</td>
                      <td>
                        <div>
                          <input class="form-check-input"
                              name="fisik[tanda_vital][air_ketuban][biasa]"
                              {{ @$asessment['tanda_vital']['air_ketuban']['biasa'] == 'Biasa' ? 'checked' : '' }}
                              type="checkbox" value="Biasa">
                          <label class="form-check-label" style="font-weight: 400;">Biasa</label>
                        </div>
                        <div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][luar_biasa]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['luar_biasa'] == 'Luar biasa' ? 'checked' : '' }}
                                type="checkbox" value="Luar biasa">
                            <label class="form-check-label" style="font-weight: 400;">Luar biasa : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][keruh]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['keruh'] == 'Keruh' ? 'checked' : '' }}
                                type="checkbox" value="Keruh">
                            <label class="form-check-label" style="font-weight: 400;">Keruh : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][berbau]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['berbau'] == 'Berbau' ? 'checked' : '' }}
                                type="checkbox" value="Berbau">
                            <label class="form-check-label" style="font-weight: 400;">Berbau : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][kurang]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['kurang'] == 'Kurang' ? 'checked' : '' }}
                                type="checkbox" value="Kurang">
                            <label class="form-check-label" style="font-weight: 400;">Kurang : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][berwarna]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['berwarna'] == 'Berwarna' ? 'checked' : '' }}
                                type="checkbox" value="Berwarna">
                            <label class="form-check-label" style="font-weight: 400;">Berwarna : </label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[tanda_vital][air_ketuban][2liter]"
                                {{ @$asessment['tanda_vital']['air_ketuban']['2liter'] == '> 2 Liter' ? 'checked' : '' }}
                                type="checkbox" value="> 2 Liter">
                            <label class="form-check-label" style="font-weight: 400;">> 2 Liter : </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Lamanya persalinan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['lamanya_persalinan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Letak anak</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['letak_anak']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Kehamilan tunggal / kembar</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['kehamilan_tunggal_kembar']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Talipusat : Panjang</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['talipusat_panjang']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Kelainan</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['kelainan']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Plasenta berat</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['plasenta_berat']}}
                        <span>Ukuran</span>
                        <div class="btn-group" style="display: flex">
                            {{@$asessment['tanda_vital']['ukuran']['1']}} x
                            <br>
                            {{@$asessment['tanda_vital']['ukuran']['2']}} cm
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: bold;">Jumlah</td>
                      <td style="padding: 5px;">
                        {{@$asessment['tanda_vital']['jumlah']}}
                        <span>Chorion :</span>
                        {{@$asessment['tanda_vital']['chorion']}}
                        <span>Amnoin :</span>
                        {{@$asessment['tanda_vital']['amnion']}}
                      </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>TANDA VITAL</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%; font-weight: bold;">Lingkar kepala</td>
                        <td style="padding: 5px;">
                          {{@$asessment['tanda_vital']['lingkar_kepala']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Lingkar dada</td>
                        <td style="padding: 5px;">
                          {{@$asessment['tanda_vital']['lingkar_dada']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">IMD</td>
                        <td style="padding: 5px;">
                          <div class="btn-group" style="display: flex">
                              {{@$asessment['tanda_vital']['imd']['1']}} / {{@$asessment['tanda_vital']['imd']['2']}}
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Keluarga lain-lain</td>
                        <td style="padding: 5px;">
                          {{@$asessment['keluarga_lain_lain']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>RIWAYAT KEHAMILAN SEBELUMNYA</b>
            </td>
            <td colspan="5">
                <table class="border" style="width: 100%; font-size: 10px;" id="table_riwayat_kehamilan_sebelumnya">
                    <tr class="border">
                        <td class="border bold p-1 text-center">No</td>
                        <td class="border bold p-1 text-center">Kondisi (Lahir/Mati)</td>
                        <td class="border bold p-1 text-center">Lahir Hidup (Usia)</td>
                        <td class="border bold p-1 text-center">Lahir Mati</td>
                        <td class="border bold p-1 text-center">Penyebab Kematian</td>
                    </tr>
                    @if (isset($asessment['riwayat_kehamilan_sebelumnya']))
                      @foreach ($asessment['riwayat_kehamilan_sebelumnya'] as $key => $obat)
                        <tr class="border riwayat_kehamilan_sebelumnya">
                            <td class="border bold p-1 text-center">{{$key}}</td>
                            <td class="border bold p-1 text-center">
                                {{$obat['kondisi']}}
                            </td>
                            <td class="border bold p-1 text-center">
                                {{$obat['usia']}}
                            </td>
                            <td class="border bold p-1 text-center">
                                {{$obat['lahir_mati']}}
                            </td>
                            <td class="border bold p-1 text-center">
                                {{$obat['penyebab_kematian']}}
                            </td>
                        </tr>
                      @endforeach
                    @endif
                </table>
            </td>
        </tr>
    </table>
    <table style="border: 0px;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">
    
            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                  Dokter
            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                @if (isset($cetak_tte))
                <span style="margin-left: 1rem;">
                    #
                </span>
                    <br>
                    <br>
                @elseif (isset($tte_nonaktif))
                    @php
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                    {{ baca_user($pemeriksaan->user_id) }}
            </td>
        </tr>
    </table>

</body>

</html>
