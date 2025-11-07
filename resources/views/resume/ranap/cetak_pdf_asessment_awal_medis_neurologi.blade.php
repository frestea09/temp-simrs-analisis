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
                <b>ASESMEN AWAL MEDIS NEUROLOGI</b>
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
              <b>Resiko Cidera Jatuh</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[resiko_cidera_jatuh][pilihan]" {{@$asessment['resiko_cidera_jatuh']['pilihan'] == "Tidak" ? "checked" : ''}} value="Tidak">
                    <label style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[resiko_cidera_jatuh][pilihan]" {{@$asessment['resiko_cidera_jatuh']['pilihan'] == "Ya" ? "checked" : ''}} value="Ya">
                    <label style="font-weight: normal; margin-right: 10px;">Ya, bila ya isi form monitoring pencegah jatuh</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Fungsional</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[status_fungsional][pilihan]" {{@$asessment['status_fungsional']['pilihan'] == "Aktifitas dan mobilitasi" ? "checked" : ''}} value="Aktifitas dan mobilitasi">
                    <label style="font-weight: normal; margin-right: 10px;">Aktifitas dan mobilitasi</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[status_fungsional][pilihan]" {{@$asessment['status_fungsional']['pilihan'] == "Mandiri" ? "checked" : ''}} value="Mandiri">
                    <label style="font-weight: normal; margin-right: 10px;">Mandiri</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[status_fungsional][pilihan]" {{@$asessment['status_fungsional']['pilihan'] == "Perlu bantuan" ? "checked" : ''}} value="Perlu bantuan">
                    <label style="font-weight: normal; margin-right: 10px;">Perlu bantuan</label>
                    <div>
                        {{@$asessment['status_fungsional']['pilihan_perlu_bantuan']}}
                    </div>
                  </div>
                  <div>
                    <input type="radio" name="fisik[status_fungsional][pilihan]" {{@$asessment['status_fungsional']['pilihan'] == "Alat bantu jalan" ? "checked" : ''}} value="Alat bantu jalan">
                    <label style="font-weight: normal; margin-right: 10px;">Alat bantu jalan</label>
                    <div>
                        {{@$asessment['status_fungsional']['pilihan_alat_bantu_jalan']}}
                    </div>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Reflek Fisiologis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">Anggota badan atas</td>
                        <td>
                          <label class="form-check-label">Biceps :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_atas']['biceps']}}
                          <label class="form-check-label">Triceps :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_atas']['triceps']}}
                          <label class="form-check-label">Radial :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_atas']['radial']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Dinding perut</td>
                        <td>
                          <label class="form-check-label">Epigastrik :</label>
                          {{@$asessment['refleks_fisiologis']['dinding_perut']['epigastrik']}}
                          <label class="form-check-label">Hipogastrik :</label>
                          {{@$asessment['refleks_fisiologis']['dinding_perut']['hipogastrik']}}
                          <label class="form-check-label">Mesogastrik :</label>
                          {{@$asessment['refleks_fisiologis']['dinding_perut']['mesogastrik']}}
                          <label class="form-check-label">Kremaster :</label>
                          {{@$asessment['refleks_fisiologis']['dinding_perut']['kremaster']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Anggota badan bawah</td>
                        <td>
                          <label class="form-check-label">Patella :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_bawah']['patella']}}
                          <label class="form-check-label">Achiles :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_bawah']['achiles']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Klonus</b>
            </td>
            <td colspan="5">
                <label class="form-check-label">Patella :</label>
                {{@$asessment['klonus']['patella']}}
                <label class="form-check-label">Achiles :</label>
                {{@$asessment['klonus']['achiles']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Refleks Patologi</b>
            </td>
            <td colspan="5">
                <label class="form-check-label">Hoffman tromner :</label>
                {{@$asessment['refleks_patologi']['hoffman_tromner']}}
                  <label class="form-check-label">Babinski :</label>
                  {{@$asessment['refleks_patologi']['babinski']}}
                  <label class="form-check-label">Chaddock :</label>
                  {{@$asessment['refleks_patologi']['chaddock']}}
                  <label class="form-check-label">Oppenheim :</label>
                  {{@$asessment['refleks_patologi']['oppenheim']}}
                  <label class="form-check-label">Gordon :</label>
                  {{@$asessment['refleks_patologi']['gordon']}}
                  <label class="form-check-label">Schaeffer :</label>
                  {{@$asessment['refleks_patologi']['schaeffer']}}
                  <label class="form-check-label">Rossolimo :</label>
                  {{@$asessment['refleks_patologi']['rossolimo']}}
                  <label class="form-check-label">Mendel betherew :</label>
                  {{@$asessment['refleks_patologi']['mendel_betherew']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Refleks Primitif</b>
            </td>
            <td colspan="5">
                <label class="form-check-label">Glabella :</label>
                {{@$asessment['refleks_primitif']['glabella']}}
                  <label class="form-check-label">Mencucut mulut :</label>
                  {{@$asessment['refleks_primitif']['mencucut_mulut']}}
                  <label class="form-check-label">Palmo mental :</label>
                  {{@$asessment['refleks_primitif']['palmo_mental']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Fungsi Otonom</b>
            </td>
            <td colspan="5">
                {{@$asessment['fungsi_otonom']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Pemeriksaan Fungsi Luhur</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">Hubungan psikis</td>
                        <td>
                          <label class="form-check-label">Motorik :</label>
                          {{@$asessment['pemeriksaan_fungsi_luhur']['hubungan_psikis']['motorik']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Afasia</td>
                        <td>
                          <label class="form-check-label">Sensorik :</label>
                          {{@$asessment['pemeriksaan_fungsi_luhur']['afasia']['sensorik']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Ingatan</td>
                        <td>
                          <label class="form-check-label">Jangka pendek :</label>
                          {{@$asessment['pemeriksaan_fungsi_luhur']['ingatan']['jangka_pendek']}}
                          <label class="form-check-label">Jangka panjang :</label>
                          {{@$asessment['pemeriksaan_fungsi_luhur']['ingatan']['jangka_panjang']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Anggota badan bawah</td>
                        <td>
                          <label class="form-check-label">Patella :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_bawah']['patella']}}
                          <label class="form-check-label">Achiles :</label>
                          {{@$asessment['refleks_fisiologis']['anggota_badan_bawah']['achiles']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;"><h5><b>Kemampuan berhitung</b></h5></td>
                        <td style="padding: 5px;">
                            {{@$asessment['kemampuan_berhitung']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Lokalis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;"><b>A. inspeksi</b></td>
                        <td>
                          <label class="form-check-label">Kepala :</label>
                          {{@$asessment['status_lokalis']['inspeksi']['kepala']}}
                          <label class="form-check-label">Triceps :</label>
                          {{@$asessment['status_lokalis']['inspeksi']['triceps']}}
                          <label class="form-check-label">Radial :</label>
                          {{@$asessment['status_lokalis']['inspeksi']['radial']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;"><b>B. Rangsangan meningen / iritasi radiks</b></td>
                        <td>
                          <label class="form-check-label">Kaku kuduk</label>
                          {{@$asessment['status_lokalis']['rangsangan_meningen']['kaku_kuduk']}}
                          <label class="form-check-label">Test Brudzinky I</label>
                          {{@$asessment['status_lokalis']['rangsangan_meningen']['test_brudzinky1']}}
                          <label class="form-check-label">Test Brudzinky II</label>
                          {{@$asessment['status_lokalis']['rangsangan_meningen']['test_brudzinky2']}}
                          <label class="form-check-label">Test Brudzinky III</label>
                          {{@$asessment['status_lokalis']['rangsangan_meningen']['test_brudzinky3']}}
                          <label class="form-check-label">Test Laseque</label>
                          <div style="display: flex;">
                            Kanan : {{@$asessment['status_lokalis']['rangsangan_meningen']['test_laseque_kanan']}} <br>
                            Kiri : {{@$asessment['status_lokalis']['rangsangan_meningen']['test_laseque_kiri']}}
                          </div>
                          <label class="form-check-label">Test Kernig</label>
                          <div style="display: flex;">
                            Kanan : {{@$asessment['status_lokalis']['rangsangan_meningen']['test_kernig_kanan']}} <br>
                            Kiri : {{@$asessment['status_lokalis']['rangsangan_meningen']['test_kernig_kiri']}}
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="width: 50%;"><b>C. Saraf Otak</b></td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.I</td>
                        <td>
                          <label class="form-check-label">Penciuman</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n1']['penciuman']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.II</td>
                        <td>
                          <label class="form-check-label">Ketajaman</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n2']['ketajaman']}}
                          <label class="form-check-label">Campus</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n2']['campus']}}
                          <label class="form-check-label">Fondus Oculi</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n2']['fondus_oculi']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.III/IV/VI</td>
                        <td>
                          <label class="form-check-label">Ptosis</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n345']['ptosis']}}
                          <label class="form-check-label">Pupil</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n345']['pupil']}}
                          <label class="form-check-label">Refleks Cahaya(D/I)</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n345']['refleks_cahaya']}}
                          <label class="form-check-label">Refleks Konvergensi</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n345']['refleks_konvergensi']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.V</td>
                        <td>
                          <label class="form-check-label">Sensorik</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n5']['sensorik']}}
                          <label class="form-check-label">Oftalmikus</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n5']['oftalmikus']}}
                          <label class="form-check-label">Maksilaris</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n5']['maksilaris']}}
                          <label class="form-check-label">Mandibularis</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n5']['mandibularis']}}
                          <label class="form-check-label">Motorik</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n5']['motorik']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Lokalis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                      <tr>
                        <td style="width: 50%;">N.VII</td>
                        <td>
                          <label class="form-check-label">Gerakan Wajah</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n7']['gerakan_wajah']}}
                          <label class="form-check-label">Plicanosolabialis</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n7']['plicanosolabialis']}}
                          <label class="form-check-label">Angkat Alis Mata</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n7']['angkat_alis_mata']}}
                          <label class="form-check-label">Memejamkan Mata</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n7']['memejamkan_mata']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.VIII</td>
                        <td>
                          <label class="form-check-label">Rasa kecap 2/3 bagian muka lidah</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n8']['rasa_kecap']}}
                          <label class="form-check-label">Pendengaran</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n8']['pendengaran']}}
                          <label class="form-check-label">Keseimbangan</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n8']['keseimbangan']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.IX/X</td>
                        <td>
                          <label class="form-check-label">Suara</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n910']['suara']}}
                          <label class="form-check-label">Menelan</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n910']['menelan']}}
                          <label class="form-check-label">Gerakan Palatum &amp; Uvula</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n910']['gerakan_palatum']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.XI</td>
                        <td>
                          <label class="form-check-label">Angkat Bahu</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n11']['angkat_bahu']}}
                          <label class="form-check-label">Menengok ke kanan - kiri</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n11']['menengok_kekanan_kiri']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">N.XII</td>
                        <td>
                          <label class="form-check-label">Gerakan Lidah</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n12']['gerakan_lidah']}}
                          <label class="form-check-label">Atrofi</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n12']['atrofi']}}
                          <label class="form-check-label">Tremor / Fasikulasi</label>
                          {{@$asessment['status_lokalis']['saraf_otak']['n12']['tremor_fasikulasi']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Lokalis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="2" style="width: 50%;"><b>D. Motorik</b></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <table style="width: 100%; border: 1px solid black;  font-size: 8px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                            <tr>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Pemeriksaan</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Kekuatan</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Tonus</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Atrofi</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Fasikulasi</td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid black;">Anggota badan atas</td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_atas']['kekuatan']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_atas']['tonus']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_atas']['atrofi']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_atas']['fasikulasi']}}
                              </td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid black;">Anggota badan bawah</td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_bawah']['kekuatan']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_bawah']['tonus']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_bawah']['atrofi']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['motorik']['anggota_badan_bawah']['fasikulasi']}}
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Batang tubuh</td>
                        <td>
                            {{@$asessment['status_lokalis']['motorik']['batang_tubuh']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Gerakan involunter</td>
                        <td>
                            {{@$asessment['status_lokalis']['motorik']['gerakan_involunter']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Cara berjalan / giat</td>
                        <td>
                            {{@$asessment['status_lokalis']['motorik']['cara_berjalan']}}
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Lokalis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="2" style="width: 50%;"><b>E. Sensorik</b></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <table style="width: 100%; border: 1px solid black; font-size: 8px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                            <tr>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Pemeriksaan</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Permukaan</td>
                              <td style="border: 1px solid black; text-align: center; font-size: 1.3rem !important; font-weight: bold;">Dalam</td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid black;">Anggota badan atas</td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['anggota_badan_atas']['permukaan']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['anggota_badan_atas']['dalam']}}
                              </td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid black;">Batang tubuh</td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['batang_tubuh']['permukaan']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['batang_tubuh']['dalam']}}
                              </td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid black;">Anggota badan bawah</td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['anggota_badan_bawah']['permukaan']}}
                              </td>
                              <td style="border: 1px solid black;">
                                {{@$asessment['status_lokalis']['sensorik']['anggota_badan_bawah']['dalam']}}
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Status Lokalis</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="2" style="width: 50%;"><b>F. Koordinasi</b></td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Cara Bicara</td>
                        <td>
                            {{@$asessment['status_lokalis']['koordinasi']['cara_bicara']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Test telunjuk hidung</td>
                        <td>
                            {{@$asessment['status_lokalis']['koordinasi']['test_telunjuk_hidung']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Test romberg</td>
                        <td>
                            {{@$asessment['status_lokalis']['koordinasi']['test_romberg']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Tremor</td>
                        <td>
                            {{@$asessment['status_lokalis']['koordinasi']['tremor']}}
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">Test tumit lutut</td>
                        <td>
                            {{@$asessment['status_lokalis']['koordinasi']['test_tumit_lutut']}}
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
