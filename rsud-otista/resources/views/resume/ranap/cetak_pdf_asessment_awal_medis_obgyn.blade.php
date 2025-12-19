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
                <b>ASESMEN AWAL MEDIS OBGYN</b>
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
                <b>Riwayat Penyakit Lain lain</b>
            </td>
            <td colspan="5">
              {{@$asessment['riwayatPenyakitLain']}}
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
                <b>RIWAYAT GINEKOLOGI</b>
            </td>
            <td colspan="5">
                  {{@$asessment['riwayat_ginekologi']}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PEMERIKSAAN OBSTETRI</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Kepala</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Kelopak mata</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['kepala']['kelopak_mata']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Konjungtiva</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['kepala']['konjungtiva']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Sclera</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['kepala']['sclera']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Lain-lain</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['kepala']['lain_lain']}}
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                    <td style="padding: 5px;">
                      {{@$asessment['diagnosa']}}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Diagnosa Tambahan</td>
                    <td style="padding: 5px;">
                      {{@$asessment['diagnosa_tambahan']}}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Buah Dada</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Puting</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['buah_dada']['puting']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">ASI</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['buah_dada']['asi']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Kebersihan</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['buah_dada']['kebersihan']}}
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: 500;">Lain-lain</td>
                    <td>
                      {{@$asessment['pemeriksaan_obstetri']['buah_dada']['lain_lain']}}
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PEMERIKSAAN OBSTETRI</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Posterior</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Luka</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_posterior']['luka']}}
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Perut</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">TFU</td>
                      <td>
                          {{@$asessment['pemeriksaan_obstetri']['perut']['tfu']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Leopold I</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['perut']['leopold_1']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Leopold II</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['perut']['leopold_2']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Leopold III</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['perut']['leopold_3']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Leopold IV</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['perut']['leopold_4']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Leopold DJJ</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['perut']['leopold_djj']}}
                      </td>
                  </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PEMERIKSAAN OBSTETRI</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Periksa Dalam</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Pembukaan</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['periksa_dalam']['pembukaan']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Portio</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['periksa_dalam']['portio']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Ketuban</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['periksa_dalam']['ketuban']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Presentasi</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['periksa_dalam']['presentasi']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Hodge</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['periksa_dalam']['hodge']}}
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Ginekologi</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Inspekulo</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['inspekulo']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">inspeksi</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['inspeksi']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Hymen</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['hymen']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Liang vagina</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['liang_vagina']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Mukoso portio</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['mukoso_portio']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Fluksus</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['pemeriksaan_ginekologi']['fluksus']}}
                      </td>
                  </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>PEMERIKSAAN OBSTETRI</b>
            </td>
            <td colspan="5">
                <table style="font-size:12px; width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td style="width: 50%; font-weight: bold;" colspan="2">Palpasi</td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">QUE</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['que']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Adnexa</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['admexa']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">Parametrium</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['parametrium']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">CU</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['cu']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">VU</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['vu']}}
                      </td>
                  </tr>
                  <tr>
                      <td style="width: 50%; font-weight: 500;">CD</td>
                      <td>
                        {{@$asessment['pemeriksaan_obstetri']['palpasi']['cd']}}
                      </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                    <td style="padding: 5px;">
                      {{@$asessment['diagnossa']}}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight: bold;">Tindakan</td>
                    <td style="padding: 5px;">
                      {{@$asessment['tindakan']}}
                    </td>
                  </tr>
                </table>
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
        <tr>
            <td style="vertical-align: top;">
                <b>RIWAYAT OBSTETRI</b>
            </td>
            <td colspan="5">
              <table class="border" style="width: 100%; font-size: 8px" id="table_riwayat_obstetri">
                <tr class="border">
                    <td class="border bold p-1 text-center">NO</td>
                    <td class="border bold p-1 text-center">TANGGAL LAHIR</td>
                    <td class="border bold p-1 text-center">JENIS KELAMIN</td>
                    <td class="border bold p-1 text-center">USIA</td>
                    <td class="border bold p-1 text-center">JENIS PERSALINAN</td>
                    <td class="border bold p-1 text-center">TEMPAT &amp; PENOLONG</td>
                    <td class="border bold p-1 text-center">BB &amp; PB</td>
                    <td class="border bold p-1 text-center">ASI EKSKLUSIF</td>
                    <td class="border bold p-1 text-center">KETERANGAN</td>
                </tr>
                @if (isset($asessment['riwayat_obstetri']))
                  @foreach ($asessment['riwayat_obstetri'] as $key => $obat)
                    <tr class="border riwayat_obstetri">
                        <td class="border bold p-1 text-center">{{$key}}</td>
                        <td class="border bold p-1 text-center">
                          {{$obat['tanggal_lahir']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['jenis_kelamin']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['usia']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['jenis_persalinan']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['tempat_dan_penolong']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['bb_pb']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['asi_eksklusif']}}
                        </td>
                        <td class="border bold p-1 text-center">
                          {{$obat['keterangan']}}
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
