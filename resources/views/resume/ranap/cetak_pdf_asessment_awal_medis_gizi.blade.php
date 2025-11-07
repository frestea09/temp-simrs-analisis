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
                <b>ASESMEN AWAL MEDIS GIZI</b>
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
          <td >
              <b>Status Lokalis</b>
          </td>
          <td colspan="5">
                <div>
                    Perubahan BB Selama 6 bulan terakhir :<br>
                    <label for="penurunanBB_1" style="margin-right: 10px;">
                      <input type="radio" name="fisik[statusLokalis][penurunanBB][jawaban]" value="Tidak Ada" id="penurunanBB_1" {{ @$asessment['statusLokalis']['penurunanBB']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                      Tidak Ada (A)
                    </label> <br>
                    <label for="penurunanBB_2" style="margin-right: 10px;">
                      <input type="radio" name="fisik[statusLokalis][penurunanBB][jawaban]" value="Ada Perubahan, Penurunan / Peningkatan < 5 %" id="penurunanBB_2" {{ @$asessment['statusLokalis']['penurunanBB']['jawaban'] == 'Ada Perubahan, Penurunan / Peningkatan < 5 %' ? 'checked' : '' }}>
                      Ada Perubahan, Penurunan / Peningkatan &lt; 5 % (A)
                    </label> <br>
                    <label for="penurunanBB_3" style="margin-right: 10px;">
                      <input type="radio" name="fisik[statusLokalis][penurunanBB][jawaban]" value="Ada Perubahan, Penurunan / Peningkatan 5-10 %" id="penurunanBB_3" {{ @$asessment['statusLokalis']['penurunanBB']['jawaban'] == 'Ada Perubahan, Penurunan / Peningkatan 5-10 %' ? 'checked' : '' }}>
                      Ada Perubahan, Penurunan / Peningkatan 5-10 % (B)
                    </label> <br>
                    <label for="penurunanBB_4" style="margin-right: 10px;">
                      <input type="radio" name="fisik[statusLokalis][penurunanBB][jawaban]" value="Ada Perubahan, Penurunan / Peningkatan > 10 %" id="penurunanBB_4" {{ @$asessment['statusLokalis']['penurunanBB']['jawaban'] == 'Ada Perubahan, Penurunan / Peningkatan > 10 %' ? 'checked' : '' }}>
                      Ada Perubahan, Penurunan / Peningkatan > 10 % (B)
                    </label> <br>
                    <label for="penurunanBB_5" style="margin-right: 10px;">
                      <input type="radio" name="fisik[statusLokalis][penurunanBB][jawaban]" value="Tidak Tahu" id="penurunanBB_5" {{ @$asessment['statusLokalis']['penurunanBB']['jawaban'] == 'Tidak Tahu' ? 'checked' : '' }}>
                      Tidak Tahu (Tidak Dinilai)
                    </label> <br>
                    Skor :
                    {{@$asessment['statusLokalis']['penurunanBB']['skor']}}
                </div>
                <br>
                <div>
                    Perubahan Intake Makan, Perubahan dalam jumlah asupan akhir-akhir ini dibanding dengan kebiasaan :<br>
                    <label for="perubahanIntake_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanIntake][jawaban]" value="Asupan cukup dan tida ada perubahan, kalaupun adanya sedikit dan tidak dalam waktu singkat" id="perubahanIntake_1" {{ @$asessment['statusLokalis']['perubahanIntake']['jawaban'] == 'Asupan cukup dan tida ada perubahan, kalaupun adanya sedikit dan tidak dalam waktu singkat' ? 'checked' : '' }}>
                    Asupan cukup dan tida ada perubahan, kalaupun adanya sedikit dan tidak dalam waktu singkat (A)
                    </label> <br>
                    <label for="perubahanIntake_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanIntake][jawaban]" value="Asupan menurun daripada sebelum sakit namun dalam tahap ringan" id="perubahanIntake_2" {{ @$asessment['statusLokalis']['perubahanIntake']['jawaban'] == 'Asupan menurun daripada sebelum sakit namun dalam tahap ringan' ? 'checked' : '' }}>
                    Asupan menurun daripada sebelum sakit namun dalam tahap ringan (B)
                    </label> <br>
                    <label for="perubahanIntake_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanIntake][jawaban]" value="Asupan rendah tapi ada peningkatan" id="perubahanIntake_3" {{ @$asessment['statusLokalis']['perubahanIntake']['jawaban'] == 'Asupan rendah tapi ada peningkatan' ? 'checked' : '' }}>
                    Asupan rendah tapi ada peningkatan (B)
                    </label> <br>
                    <label for="perubahanIntake_4" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanIntake][jawaban]" value="Asupan sangat tidak cukup dan menurun tahap berat daripada sebelumnya" id="perubahanIntake_4" {{ @$asessment['statusLokalis']['perubahanIntake']['jawaban'] == 'Asupan sangat tidak cukup dan menurun tahap berat daripada sebelumnya' ? 'checked' : '' }}>
                    Asupan sangat tidak cukup dan menurun tahap berat daripada sebelumnya (C)
                    </label> <br>
                    Skor :
                    {{@$asessment['statusLokalis']['perubahanIntake']['skor']}}
                </div>
                <br>
                <div>
                    Perubahan Gastrointestinal :<br>
                    <label for="perubahanGastro_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanGastro][jawaban]" value="Jika ada beberapa gejala atau tidak ada gejala, sebentar-sebentar" id="perubahanGastro_1" {{ @$asessment['statusLokalis']['perubahanGastro']['jawaban'] == 'Jika ada beberapa gejala atau tidak ada gejala, sebentar-sebentar' ? 'checked' : '' }}>
                    Jika ada beberapa gejala atau tidak ada gejala, sebentar-sebentar (A)
                    </label> <br>
                    <label for="perubahanGastro_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanGastro][jawaban]" value="Jika ada beberapa gejala > 2 Minggu" id="perubahanGastro_2" {{ @$asessment['statusLokalis']['perubahanGastro']['jawaban'] == 'Jika ada beberapa gejala > 2 Minggu' ? 'checked' : '' }}>
                    Jika ada beberapa gejala > 2 Minggu (B)
                    </label> <br>
                    <label for="perubahanGastro_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[statusLokalis][perubahanGastro][jawaban]" value="Jika > 1 / Semua Gejala / Teratur > 2 Minggu" id="perubahanGastro_3" {{ @$asessment['statusLokalis']['perubahanGastro']['jawaban'] == 'Jika > 1 / Semua Gejala / Teratur > 2 Minggu' ? 'checked' : '' }}>
                    Jika > 1 / Semua Gejala / Teratur > 2 Minggu (C)
                    </label> <br>
                    Skor :
                    {{@$asessment['statusLokalis']['perubahanGastro']['skor']}}
                </div>
          </td>
        </tr>
        <tr>
          <td >
              <b>Status Lokalis</b>
          </td>
          <td colspan="5">
                
            <br>
            <div>
                Perubahan Kapasitas Fungsional :<br>
                <label for="perubahanKapasitas_1" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][perubahanKapasitas][jawaban]" value="Aktifitas normal, tidak ada kelainan, stamina tetap" id="perubahanKapasitas_1" {{ @$asessment['statusLokalis']['perubahanKapasitas']['jawaban'] == 'Aktifitas normal, tidak ada kelainan, stamina tetap' ? 'checked' : '' }}>
                Aktifitas normal, tidak ada kelainan, stamina tetap (A)
                </label> <br>
                <label for="perubahanKapasitas_2" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][perubahanKapasitas][jawaban]" value="Aktifitas ringan, mengalami sedikit penurunan" id="perubahanKapasitas_2" {{ @$asessment['statusLokalis']['perubahanKapasitas']['jawaban'] == 'Aktifitas ringan, mengalami sedikit penurunan' ? 'checked' : '' }}>
                Aktifitas ringan, mengalami sedikit penurunan (B)
                </label> <br>
                <label for="perubahanKapasitas_3" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][perubahanKapasitas][jawaban]" value="Tanpa aktifitas, di tempat tidur, penurunan stamina" id="perubahanKapasitas_3" {{ @$asessment['statusLokalis']['perubahanKapasitas']['jawaban'] == 'Tanpa aktifitas, di tempat tidur, penurunan stamina' ? 'checked' : '' }}>
                Tanpa aktifitas, di tempat tidur, penurunan stamina (C)
                </label> <br>
                Skor :
                {{@$asessment['statusLokalis']['perubahanKapasitas']['skor']}}
            </div>
            <br>
            <div>
                Penyakit dan hubungan dengan kebutuhan gizi :<br>
                <label for="kebutuhanGizi_1" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][kebutuhanGizi][jawaban]" value="Tidak Ada" id="kebutuhanGizi_1" {{ @$asessment['statusLokalis']['kebutuhanGizi']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada (A)
                </label> <br>
                <label for="kebutuhanGizi_2" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][kebutuhanGizi][jawaban]" value="Ada, Rendah" id="kebutuhanGizi_2" {{ @$asessment['statusLokalis']['kebutuhanGizi']['jawaban'] == 'Ada, Rendah' ? 'checked' : '' }}>
                Ada, Rendah (B)
                </label> <br>
                <label for="kebutuhanGizi_3" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][kebutuhanGizi][jawaban]" value="Ada, Sedang" id="kebutuhanGizi_3" {{ @$asessment['statusLokalis']['kebutuhanGizi']['jawaban'] == 'Ada, Sedang' ? 'checked' : '' }}>
                Ada, Sedang (B)
                </label> <br>
                <label for="kebutuhanGizi_4" style="margin-right: 10px;">
                <input type="radio" name="fisik[statusLokalis][kebutuhanGizi][jawaban]" value="Tinggi" id="kebutuhanGizi_4" {{ @$asessment['statusLokalis']['kebutuhanGizi']['jawaban'] == 'Tinggi' ? 'checked' : '' }}>
                Tinggi (C)
                </label> <br>
                Skor :
                {{@$asessment['statusLokalis']['kebutuhanGizi']['skor']}}
            </div>
            <br>
          </td>
        </tr>
        <tr>
          <td >
              <b>Pemeriksaan Fisik</b>
          </td>
          <td colspan="5">
            <div>
                Kehilangan Lemak Subkutan (Trisep, Bisep) :<br>
                <label for="kehilanganLemakSubkutan_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganLemakSubkutan][jawaban]" value="Tidak Ada" id="kehilanganLemakSubkutan_1" {{ @$asessment['pemeriksaanFisik']['kehilanganLemakSubkutan']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada (A)
                  </label><br>
                  <label for="kehilanganLemakSubkutan_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganLemakSubkutan][jawaban]" value="Salah satu tempat" id="kehilanganLemakSubkutan_2" {{ @$asessment['pemeriksaanFisik']['kehilanganLemakSubkutan']['jawaban'] == 'Salah satu tempat' ? 'checked' : '' }}>
                    Salah satu tempat (B)
                  </label><br>
                  <label for="kehilanganLemakSubkutan_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganLemakSubkutan][jawaban]" value="Kedua Tempat" id="kehilanganLemakSubkutan_3" {{ @$asessment['pemeriksaanFisik']['kehilanganLemakSubkutan']['jawaban'] == 'Kedua Tempat' ? 'checked' : '' }}>
                    Kedua Tempat (C)
                  </label><br>
                Skor :
                {{@$asessment['pemeriksaanFisik']['kehilanganLemakSubkutan']['skor']}}
            </div>
            <br>
            <div>
                Kehilangan masa otot (Tulang selangka, scapula, belikat, tulang rusuk, betis) :<br>
                <label for="kehilanganMasaOtot_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganMasaOtot][jawaban]" value="Tidak Ada" id="kehilanganMasaOtot_1" {{ @$asessment['pemeriksaanFisik']['kehilanganMasaOtot']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada (A)
                  </label><br>
                  <label for="kehilanganMasaOtot_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganMasaOtot][jawaban]" value="Beberapa Tempat" id="kehilanganMasaOtot_2" {{ @$asessment['pemeriksaanFisik']['kehilanganMasaOtot']['jawaban'] == 'Beberapa Tempat' ? 'checked' : '' }}>
                    Beberapa Tempat (B)
                  </label><br>
                  <label for="kehilanganMasaOtot_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][kehilanganMasaOtot][jawaban]" value="Semua Tempat" id="kehilanganMasaOtot_3" {{ @$asessment['pemeriksaanFisik']['kehilanganMasaOtot']['jawaban'] == 'Semua Tempat' ? 'checked' : '' }}>
                    Semua Tempat (C)
                  </label><br>
                Skor :
                {{@$asessment['pemeriksaanFisik']['kehilanganMasaOtot']['skor']}}
            </div>
            <br>
          </td>
        </tr>
        <tr>
          <td >
              <b>Pemeriksaan Fisik</b>
          </td>
          <td colspan="5">
            <div>
                Edema :<br>
                <label for="edema_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][edema][jawaban]" value="Tidak Ada" id="edema_1" {{ @$asessment['pemeriksaanFisik']['edema']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada (A)
                  </label><br>
                  <label for="edema_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][edema][jawaban]" value="Sedang / tungkai" id="edema_2" {{ @$asessment['pemeriksaanFisik']['edema']['jawaban'] == 'Sedang / tungkai' ? 'checked' : '' }}>
                    Sedang / tungkai (B)
                  </label><br>
                  <label for="edema_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][edema][jawaban]" value="Berat / anaraksa" id="edema_3" {{ @$asessment['pemeriksaanFisik']['edema']['jawaban'] == 'Berat / anaraksa' ? 'checked' : '' }}>
                    Berat / anaraksa (C)
                  </label><br>
                Skor :
                {{@$asessment['pemeriksaanFisik']['edema']['skor']}}
            </div>
            <br>
            <div>
                Asites :<br>
                <label for="asites_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][asites][jawaban]" value="Tidak Ada" id="asites_1" {{ @$asessment['pemeriksaanFisik']['asites']['jawaban'] == 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada (A)
                  </label><br>
                  <label for="asites_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][asites][jawaban]" value="Sedang" id="asites_2" {{ @$asessment['pemeriksaanFisik']['asites']['jawaban'] == 'Sedang' ? 'checked' : '' }}>
                    Sedang (B)
                  </label><br>
                  <label for="asites_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[pemeriksaanFisik][asites][jawaban]" value="Berat" id="asites_3" {{ @$asessment['pemeriksaanFisik']['asites']['jawaban'] == 'Berat' ? 'checked' : '' }}>
                    Berat (C)
                  </label><br>
                Skor :
                {{@$asessment['pemeriksaanFisik']['asites']['skor']}}
            </div>
            <br>
            <div>
                Keseluruhan Skor SGA :<br>
                {{@$asessment['totalSkorSGA']}}
            </div>
            <br>
            <div>
                Hasil Skrining :<br>
                <label for="hasilSkrining_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[hasilSkrining]" value="Gizi Baik" id="hasilSkrining_1" {{ @$asessment['hasilSkrining'] == 'Gizi Baik' ? 'checked' : '' }}>
                    Gizi Baik
                  </label><br>
                  <label for="hasilSkrining_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[hasilSkrining]" value="Beresiko Malnutrisi / Malnutrisi Sedang" id="hasilSkrining_2" {{ @$asessment['hasilSkrining'] == 'Beresiko Malnutrisi / Malnutrisi Sedang' ? 'checked' : '' }}>
                    Beresiko Malnutrisi / Malnutrisi Sedang
                  </label><br>
                  <label for="hasilSkrining_3" style="margin-right: 10px;">
                    <input type="radio" name="fisik[hasilSkrining]" value="Malnutrisi Berat" id="hasilSkrining_3" {{ @$asessment['hasilSkrining'] == 'Malnutrisi Berat' ? 'checked' : '' }}>
                    Malnutrisi Berat
                  </label><br>
            </div>
            <br>
            <div>
                Tindak lanjut Skrining :<br>
                <label for="tindakLanjutSkrining_1" style="margin-right: 10px;">
                    <input type="radio" name="fisik[tindakLanjutSkrining]" value="Monitoring Umum" id="tindakLanjutSkrining_1" {{ @$asessment['tindakLanjutSkrining'] == 'Monitoring Umum' ? 'checked' : '' }}>
                    Monitoring Umum
                  </label>
                  <label for="tindakLanjutSkrining_2" style="margin-right: 10px;">
                    <input type="radio" name="fisik[tindakLanjutSkrining]" value="Konseling" id="tindakLanjutSkrining_2" {{ @$asessment['tindakLanjutSkrining'] == 'Konseling' ? 'checked' : '' }}>
                    Konseling
                  </label>
            </div>
            <br>
          </td>
        </tr>
        <tr>
          <td >
              <b>Konseling dan Edukasi Gizi</b>
          </td>
          <td colspan="5">
            <div>
                Materi :<br>
                {{@$assesment['konselingEdukasiGizi']['materi']}} <br><br>
                
                Leaflet yang diberikan : <br>
                {{@$assesment['konselingEdukasiGizi']['leaflet']}} <br><br>

                Data Penting Terkait : <br>
                {{@$assesment['konselingEdukasiGizi']['dataPenting']}} <br><br>
            </div>
          </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Diagnosa</b>
            </td>
            <td colspan="5">
                  {{@$asessment['diagnosa']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Diagnosa Tambahan</b>
            </td>
            <td colspan="5">
                  {{@$asessment['diagnosa_tambahan']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Terapi</b>
            </td>
            <td colspan="5">
              {{@$asessment['Tindakan']}}
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
