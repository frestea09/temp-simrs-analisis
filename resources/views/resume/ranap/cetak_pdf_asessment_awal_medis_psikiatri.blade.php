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
                <b>ASESMEN AWAL MEDIS PSIKIATRI</b>
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
                <b>Keluhan Utama</b>
            </td>
            <td colspan="5">
              {{@$asessment['keluhanUtama']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Riwayat Penyakit Sekarang</b>
            </td>
            <td colspan="5">
              {{@$asessment['riwayat_penyakit_sekarang']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Riwayat Penyakit Dahulu</b>
            </td>
            <td colspan="5">
              {{@$asessment['riwayatPenyakitDahulu']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Pernah Dirawat</b>
            </td>
            <td colspan="5">
              <div>
                  <input class="form-check-input"
                      name="fisik[rencanaRanap][pernah_dirawat]"
                      {{ @$asessment['rencanaRanap']['pernah_dirawat'] == 'Tidak' ? 'checked' : '' }}
                      type="radio" value="Tidak">
                  <label class="form-check-label">Tidak</label>
              </div>
              <div>
                  <input class="form-check-input"
                      name="fisik[rencanaRanap][pernah_dirawat]"
                      {{ @$asessment['rencanaRanap']['pernah_dirawat'] == 'Ya' ? 'checked' : '' }}
                      type="radio" value="Ya">
                  <label class="form-check-label">Ya, </label>
                  <label class="form-check-label">Kapan :</label>
                  {{@$asessment['rencanaRanap']['pernah_dirawat_kapan']}}
                  <label class="form-check-label">Dimana :</label>
                  {{@$asessment['rencanaRanap']['pernah_dirawat_dimana']}}
                  <label class="form-check-label">Diagnosa :</label>
                  {{@$asessment['rencanaRanap']['pernah_dirawat_diagnosa']}}
              </div>
            </td>
        </tr>
        <tr>
            <td >
                <b>Riwayat Penyakit Keluarga</b>
            </td>
            <td colspan="5">
              {{@$asessment['riwayatPenyakitKeluarga']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PEMERIKSAAN FISIK</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                      <td style="width: 50%; font-weight: 500;">a. Keadaan Umum</td>
                      <td colspan="2">
                        <input type="checkbox" id="keadaanUmum_1" name="fisik[nyeri][keadaanUmum][pilihan][tampak_tidak_sakit]" value="Tampak Tidak Sakit" {{ @$asessment['nyeri']['keadaanUmum']['pilihan']['tampak_tidak_sakit'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                        <label for="keadaanUmum_1" style="font-weight: normal;margin-right: 15px;">Tampak Tidak Sakit</label> 
                        <input type="checkbox" id="keadaanUmum_2" name="fisik[nyeri][keadaanUmum][pilihan][sakit_ringan]" value="Sakit Ringan" {{ @$asessment['nyeri']['keadaanUmum']['pilihan']['sakit_ringan'] == 'Sakit Ringan' ? 'checked' : '' }}>
                        <label for="keadaanUmum_2" style="font-weight: normal;margin-right: 10px;">Sakit Ringan</label> <br/>
                        <input type="checkbox" id="keadaanUmum_3" name="fisik[nyeri][keadaanUmum][pilihan][sakit_sedang]" value="Sakit Sedang" {{ @$asessment['nyeri']['keadaanUmum']['pilihan']['sakit_sedang'] == 'Sakit Sedang' ? 'checked' : '' }}>
                        <label for="keadaanUmum_3" style="font-weight: normal;margin-right: 50px;">Sakit Sedang</label> 
                        <input type="checkbox" id="keadaanUmum_4" name="fisik[nyeri][keadaanUmum][pilihan][sakit_berat]" value="Sakit Berat" {{ @$asessment['nyeri']['keadaanUmum']['pilihan']['sakit_berat'] == 'Sakit Berat' ? 'checked' : '' }}>
                        <label for="keadaanUmum_4" style="font-weight: normal;margin-right: 10px;">Sakit Berat</label>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 50%; font-weight: 500;">b. Kesadaran</td>
                      <td colspan="2">
                        <input type="checkbox" id="kesadaran_1" name="fisik[nyeri][kesadaran][pilihan][compos_mentis]" value="Compos Mentis" {{ @$asessment['nyeri']['kesadaran']['pilihan']['compos_mentis'] == 'Compos Mentis' ? 'checked' : '' }}>
                        <label for="kesadaran_1" style="font-weight: normal;margin-right: 15px;">Compos Mentis</label> 
                        <input type="checkbox" id="kesadaran_2" name="fisik[nyeri][kesadaran][pilihan][apatis]" value="Apatis" {{ @$asessment['nyeri']['kesadaran']['pilihan']['apatis'] == 'Apatis' ? 'checked' : '' }}>
                        <label for="kesadaran_2" style="font-weight: normal;margin-right: 10px;">Apatis</label> <br/>
                        <input type="checkbox" id="kesadaran_3" name="fisik[nyeri][kesadaran][pilihan][somnolen]" value="Somnolen" {{ @$asessment['nyeri']['kesadaran']['pilihan']['somnolen'] == 'Somnolen' ? 'checked' : '' }}>
                        <label for="kesadaran_3" style="font-weight: normal;margin-right: 43px;">Somnolen</label> 
                        <input type="checkbox" id="kesadaran_4" name="fisik[nyeri][kesadaran][pilihan][sopor]" value="Sopor" {{ @$asessment['nyeri']['kesadaran']['pilihan']['sopor'] == 'Sopor' ? 'checked' : '' }}>
                        <label for="kesadaran_4" style="font-weight: normal;margin-right: 25px;">Sopor</label>
                        <input type="checkbox" id="kesadaran_5" name="fisik[nyeri][kesadaran][pilihan][coma]" value="Coma" {{ @$asessment['nyeri']['kesadaran']['pilihan']['coma'] == 'Coma' ? 'checked' : '' }}>
                        <label for="kesadaran_5" style="font-weight: normal;margin-right: 10px;">Coma</label>
                      </td>
                    </tr>
                    <tr>
                      <td rowspan="3" style="width:25%; font-weight:500;">c. GCS</td>
                      <td style="padding: 5px;" colspan="2">
                        <label class="form-check-label " style="margin-right: 20px;">E :</label>
                        {{@$asessment['GCS']['E']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;" colspan="2">
                        <label class="form-check-label " style="margin-right: 20px;">M :</label>
                        {{@$asessment['GCS']['M']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;" colspan="2">
                        <label class="form-check-label " style="margin-right: 20px;">V :</label>
                        {{@$asessment['GCS']['V']}}
                      </td>
                    </tr>
      
                    <tr>
                      <td rowspan="3" style="width:50%; font-weight:500;">d. Tanda Vital</td>
                      <td style="padding: 5px;">
                        Tekanan darah :
                        {{@$asessment['tanda_vital']['tekanan_darah']}}
                      </td>
                      <td style="padding: 5px;">
                        Nadi :
                        {{@$asessment['tanda_vital']['nadi']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                        RR :
                        {{@$asessment['tanda_vital']['RR']}}
                      </td>
                      <td style="padding: 5px;">
                        Suhu :
                        {{@$asessment['tanda_vital']['temp']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 5px;">
                        Berat badan :
                        {{@$asessment['tanda_vital']['BB']}}
                      </td>
                      <td style="padding: 5px;">
                        Tinggi badan :
                        {{@$asessment['tanda_vital']['TB']}}
                      </td>
                    </tr>
      
                    <tr>
                      <td style="width:50%; font-weight:500;">e. Tambahan</td>
                      <td colspan="2">
                        {{@$asessment['tambahanPemeriksaanFisik']}}
                      </td>
                    </tr>
                  </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Psikologis</b>
            </td>
            <td colspan="5">
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Cemas' ? 'checked' : '' }}
                        type="radio" value="Cemas">
                    <label class="form-check-label">Cemas</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Takut' ? 'checked' : '' }}
                        type="radio" value="Takut">
                    <label class="form-check-label">Takut</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Marah' ? 'checked' : '' }}
                        type="radio" value="Marah">
                    <label class="form-check-label">Marah</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Sedih' ? 'checked' : '' }}
                        type="radio" value="Sedih">
                    <label class="form-check-label">Sedih</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Kecenderungan bunuh diri' ? 'checked' : '' }}
                        type="radio" value="Kecenderungan bunuh diri">
                    <label class="form-check-label">Kecenderungan bunuh diri</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_psikologis]"
                        {{ @$asessment['status_psikologis'] == 'Lain-lain' ? 'checked' : '' }}
                        type="radio" value="Lain-lain">
                    <label class="form-check-label">Lain-lain</label>
                    {{@$asessment['status_psikologis_lain']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Mental</b>
            </td>
            <td colspan="5">
                <div>
                    <input class="form-check-input"
                        name="fisik[status_mental]"
                        {{ @$asessment['status_mental'] == 'Sadar & Orientasi Baik' ? 'checked' : '' }}
                        type="radio" value="Sadar &amp; Orientasi Baik">
                    <label class="form-check-label">Sadar &amp; Orientasi Baik</label>
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_mental]"
                        {{ @$asessment['status_mental'] == 'Ada masalah perilaku' ? 'checked' : '' }}
                        type="radio" value="Ada masalah perilaku">
                    <label class="form-check-label">Ada masalah perilaku</label>
                    {{@$asessment['status_mental_masalah_perilaku']}}
                </div>
                <div>
                    <input class="form-check-input"
                        name="fisik[status_mental]"
                        {{ @$asessment['status_mental'] == 'Perilaku kekerasan yang dialami pasien sebelumnya' ? 'checked' : '' }}
                        type="radio" value="Perilaku kekerasan yang dialami pasien sebelumnya">
                    <label class="form-check-label">Perilaku kekerasan yang dialami pasien sebelumnya</label>
                    {{@$asessment['status_mental_perilaku_kekerasan']}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Hubungan pasien dengan status keluarga</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">Tempat tinggal</td>
                        <td style="padding: 5px;">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][tempat_tinggal]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['tempat_tinggal'] == 'Rumah' ? 'checked' : '' }}
                                  type="radio" value="Rumah">
                              <label class="form-check-label">Rumah</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][tempat_tinggal]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['tempat_tinggal'] == 'Apartment' ? 'checked' : '' }}
                                  type="radio" value="Apartment">
                              <label class="form-check-label">Apartment</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][tempat_tinggal]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['tempat_tinggal'] == 'Panti' ? 'checked' : '' }}
                                  type="radio" value="Panti">
                              <label class="form-check-label">Panti</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][tempat_tinggal]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['tempat_tinggal'] == 'Lainnya' ? 'checked' : '' }}
                                  type="radio" value="Lainnya">
                              <label class="form-check-label">Lainnya</label>
                              {{@$asessment['hubungan_pasien_keluarga']['tempat_tinggal_lain']}}
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Kerabat dekat yang dapat dihubungi</td>
                        <td style="padding: 5px;">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][kerabat_terdekat]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['kerabat_terdekat'] == 'Baik' ? 'checked' : '' }}
                                  type="radio" value="Baik">
                              <label class="form-check-label">Baik</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[hubungan_pasien_keluarga][kerabat_terdekat]"
                                  {{ @$asessment['hubungan_pasien_keluarga']['kerabat_terdekat'] == 'Tidak Baik' ? 'checked' : '' }}
                                  type="radio" value="Tidak Baik">
                              <label class="form-check-label">Tidak Baik</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Nama</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['hubungan_pasien_keluarga']['nama'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Hubungan</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['hubungan_pasien_keluarga']['hubungan'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Telepon</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['hubungan_pasien_keluarga']['telepon'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status spiritual</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">Kegiatan keagamaan yang biasa dilakukan</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['status_spiritual']['kegiatan_keagamaan'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Kegiatan spiritual yang dibutuhkan selama perawatan</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['status_spiritual']['kegiatan_spiritual'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Resiko cidera / jatuh</td>
                        <td style="padding: 5px;">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[resiko_cidera_jatuh]"
                                  {{ @$asessment['resiko_cidera_jatuh'] == 'Tidak' ? 'checked' : '' }}
                                  type="radio" value="Tidak">
                              <label class="form-check-label">Tidak</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[resiko_cidera_jatuh]"
                                  {{ @$asessment['resiko_cidera_jatuh'] == 'Ya' ? 'checked' : '' }}
                                  type="radio" value="Ya">
                              <label class="form-check-label">Ya, bila ya isi form monitoring pencegah jatuh, jika ya gelang resiko jatuh warna kuning terpasang</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Kebutuhan privasi pasien</td>
                        <td style="padding: 5px;">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[kebutuhan_privasi_pasien]"
                                  {{ @$asessment['kebutuhan_privasi_pasien'] == 'Ya' ? 'checked' : '' }}
                                  type="radio" value="Ya">
                              <label class="form-check-label">Ya</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[kebutuhan_privasi_pasien]"
                                  {{ @$asessment['kebutuhan_privasi_pasien'] == 'Keinginan waktu' ? 'checked' : '' }}
                                  type="radio" value="Keinginan waktu">
                              <label class="form-check-label">Keinginan waktu / tempat khusus saat wawancara dan tindakan</label>
                              <input type="text" name="fisik[kebutuhan_privasi_pasien_detail]" placeholder="Keinginan waktu / tempat khusus..." class="form-control" value="{{@$asessment['kebutuhan_privasi_pasien_detail']}}">
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_privasi_pasien]"
                                {{ @$asessment['kebutuhan_privasi_pasien'] == 'Pengobatan' ? 'checked' : '' }}
                                type="radio" value="Pengobatan">
                            <label class="form-check-label">Pengobatan</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_privasi_pasien]"
                                {{ @$asessment['kebutuhan_privasi_pasien'] == 'Kondisi penyakit' ? 'checked' : '' }}
                                type="radio" value="Kondisi penyakit">
                            <label class="form-check-label">Kondisi penyakit</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_privasi_pasien]"
                                {{ @$asessment['kebutuhan_privasi_pasien'] == 'Transportasi' ? 'checked' : '' }}
                                type="radio" value="Transportasi">
                            <label class="form-check-label">Transportasi</label>
                          </div>
                          <div>
                            <input class="form-check-input"
                                name="fisik[kebutuhan_privasi_pasien]"
                                {{ @$asessment['kebutuhan_privasi_pasien'] == 'Lain-lain' ? 'checked' : '' }}
                                type="radio" value="Lain-lain">
                            <label class="form-check-label">Lain-lain</label>
                            {{@$asessment['kebutuhan_privasi_pasien_lain']}}
                          </div>
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status fungsional</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">Aktivitas dan mobilisasi</td>
                        <td style="padding: 5px;">
                          <div>
                              <input class="form-check-input"
                                  name="fisik[status_fungsional][aktivitas_dan_mobilisasi]"
                                  {{ @$asessment['status_fungsional']['aktivitas_dan_mobilisasi'] == 'Mandiri' ? 'checked' : '' }}
                                  type="radio" value="Mandiri">
                              <label class="form-check-label">Mandiri</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[status_fungsional][aktivitas_dan_mobilisasi]"
                                  {{ @$asessment['status_fungsional']['aktivitas_dan_mobilisasi'] == 'Perlu bantuan, sebutkan' ? 'checked' : '' }}
                                  type="radio" value="Perlu bantuan, sebutkan">
                              <label class="form-check-label">Perlu bantuan, sebutkan</label>
                              {{@$asessment['status_fungsional']['aktivitas_dan_mobilisasi_perlu_bantuan']}}
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[status_fungsional][aktivitas_dan_mobilisasi]"
                                  {{ @$asessment['status_fungsional']['aktivitas_dan_mobilisasi'] == 'Alat bantu jalan, sebutkan' ? 'checked' : '' }}
                                  type="radio" value="Alat bantu jalan, sebutkan">
                              <label class="form-check-label">Alat bantu jalan, sebutkan</label>
                              {{@$asessment['status_fungsional']['aktivitas_dan_mobilisasi_alat_bantu']}}
                          </div>
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Riwayat medis dan psikiatris yang lain</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">1) Gangguan mental atau emosi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_medis_psikiatri']['1'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Gangguan psikosomatis</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_medis_psikiatri']['2'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Kondisi medik</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_medis_psikiatri']['3'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">4) Gangguan neurologi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_medis_psikiatri']['4'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Riwayat Keluarga</b>
            </td>
            <td colspan="5">
                  {{@$asessment['riwayat_keluarga']}} <br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Riwayat Kehidupan</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">1) Riwayat prenatal dan perinatal</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_kehidupan']['1'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Masa kanak-kanak awal (kelahiran sampai usia 3 tahun)</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_kehidupan']['2'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Masa kanak-kanak menengah (usia 3-11 tahun)</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_kehidupan']['3'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">4) Masa kanak-kanak akhir (pubertas hingga remaja)</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_kehidupan']['4'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">5) Masa dewasa</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['riwayat_kehidupan']['5'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Riwayat Seksual</b>
            </td>
            <td colspan="5">
                  {{@$asessment['riwayat_seksual']}} <br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Pemeriksaan Status Psikiatrikus</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">A. Gambaran umum</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">1) Penampilan</td>
                        <td style="padding: 5px;">
                              {{ @$asessment['pemeriksaan_status_psikiatrikus']['gambaran_umum']['penampilan'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Perilaku terhadap pemeriksa</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['gambaran_umum']['perilaku'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Karakteristik bicara</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['gambaran_umum']['karakteristik_bicara'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">4) Tingah laku dan aktifitas psikomotor</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['gambaran_umum']['tingkah_laku_dan_aktifitas'] }}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">B. Mood dan afek</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">1) Mood</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['mood_afek']['mood'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Afek</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['mood_afek']['afek'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Kesesuaian Afek</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['mood_afek']['kesesuaian_afek'] }}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">C. Persepsi</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">1) Ilusi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['persepsi']['ilusi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Halusinasi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['persepsi']['halusinasi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Depersonalisasi dan Derealisasi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['persepsi']['depersonalisasi'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Pemeriksaan Status Psikiatrikus</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    
                    <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">D. Pikiran</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">1) Bentuk Pikiran</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['pikiran']['Bentuk'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Jalan Pikiran</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['pikiran']['Jalan'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Isi Pikiran</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['pikiran']['isi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">E. Sensori dan kognisi</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">1) Kesadaran</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['kesadaran'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">2) Orientasi tempat-waktu-orang</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['orientasi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">3) Memori immediate, recent, dan past</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['memori'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">4) Konsentrasi dan perhatian</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['konsentrasi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">5) Membaca dan menulis</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['membaca_dan_tulis'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">6) Berpikir abstrak</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['berpikir_abstrak'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">7) Informasi dan intelegensi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['pemeriksaan_status_psikiatrikus']['sensori']['informasi_intelegensi'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">F. Penilaian</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['penilaian'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;font-weight: bold;">G. Wawasan terhadap penyakit</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['wawasan_penyakit'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Diagnosa Multiaksial</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">A. Aksis I</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['diagnosis_multiaksial']['aksis1'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">B. Aksis II</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['diagnosis_multiaksial']['aksis2'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">C. Aksis III</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['diagnosis_multiaksial']['aksis3'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">D. Aksis IV</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['diagnosis_multiaksial']['aksis4'] }}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">E. Aksis V</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['diagnosis_multiaksial']['aksis5'] }}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Diagnosa</b>
            </td>
            <td colspan="5">
                  {{@$asessment['diagnosa']}} <br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Diagnosa Tambahan</b>
            </td>
            <td colspan="5">
                  {{@$asessment['diagnosa_tambahan']}} <br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Terapi</b>
            </td>
            <td colspan="5">
                  {{@$asessment['Tindakan']}} <br>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>DISCHARGE PLANNING</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">Discharge Planning</td>
                  </tr>
                  <tr>
                      <td  style="width:40%; font-weight:500;">
                          Rencana Lama Rawat Inap
                      </td>
                      <td style="padding: 5px;">
                          <div>
                              <p style="font-weight: bold;">Dapat Ditetapkan</p>
                              {{@$asessment['rencanaRanap']['dapatDitetapkan']['hari']}}
                                  <span>Hari, </span>
                                  <span>Tanggal Pulang :</span>
                              {{@$asessment['rencanaRanap']['dapatDitetapkan']['tanggal']}}
                          </div>
                          <div>
                              <p style="font-weight: bold;">Tidak Dapat Ditetapkan, alasan :</p>
                              {{@$asessment['rencanaRanap']['tidakDapatDitetapkan']['alasan']}}
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td>Ketika pulang masih memerlukan perawatan lanjutan</td>
                      <td>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[rencanaRanap][perawatan_lanjutan]"
                                  {{ @$asessment['rencanaRanap']['perawatan_lanjutan'] == 'Tidak' ? 'checked' : '' }}
                                  type="radio" value="Tidak">
                              <label class="form-check-label">Tidak</label>
                          </div>
                          <div>
                              <input class="form-check-input"
                                  name="fisik[rencanaRanap][perawatan_lanjutan]"
                                  {{ @$asessment['rencanaRanap']['perawatan_lanjutan'] == 'Ya' ? 'checked' : '' }}
                                  type="radio" value="Ya">
                              <label class="form-check-label">Ya</label>
                              {{@$asessment['rencanaRanap']['perawatan_lanjutan_ya']}}
                          </div>
                      </td>
                  </tr>
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
