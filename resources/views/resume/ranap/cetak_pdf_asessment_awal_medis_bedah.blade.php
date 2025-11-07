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
                <b>ASESMEN AWAL MEDIS BEDAH</b>
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
                <b>Riwayat Kesehatan</b>
            </td>
            <td colspan="5">
              {{@$asessment['riwayatKesehatan']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Pemeriksaan Fisik</b>
            </td>
            <td colspan="5">
              {{@$asessment['pemeriksaan_fisik']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Pemeriksaan Diagnostik - Laboratorium</b>
            </td>
            <td colspan="5">
              {{@$asessment['pemeriksaan_diagnostik']['laboratorium']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Pemeriksaan Diagnostik - Rontgen</b>
            </td>
            <td colspan="5">
              {{@$asessment['pemeriksaan_diagnostik']['rontgen']}} <br><br>

                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][ct_scan][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['ct_scan']['pilihan'] == 'CT Scan' ? 'checked' : '' }}
                    value="CT Scan">
                <label for="" style="font-weight: normal; margin-right: 10px;">CT Scan</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][mrcp][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['mrcp']['pilihan'] == 'MRCP' ? 'checked' : '' }}
                    value="MRCP">
                <label for="" style="font-weight: normal; margin-right: 10px;">MRCP</label><br />
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][MRI][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['MRI']['pilihan'] == 'MRI' ? 'checked' : '' }}
                    value="MRI">
                <label for="" style="font-weight: normal; margin-right: 10px;">MRI</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][MRA][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['MRA']['pilihan'] == 'MRA' ? 'checked' : '' }}
                    value="MRA">
                <label for="" style="font-weight: normal; margin-right: 10px;">MRA</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][USG][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['USG']['pilihan'] == 'USG' ? 'checked' : '' }}
                    value="USG">
                <label for="" style="font-weight: normal; margin-right: 10px;">USG</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][EKG][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['EKG']['pilihan'] == 'EKG' ? 'checked' : '' }}
                    value="EKG">
                <label for="" style="font-weight: normal; margin-right: 10px;">EKG</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][CTG][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['CTG']['pilihan'] == 'CTG' ? 'checked' : '' }}
                    value="CTG">
                <label for="" style="font-weight: normal; margin-right: 10px;">Echocardiography</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][Echocardiography][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['Echocardiography']['pilihan'] == 'Echocardiography' ? 'checked' : '' }}
                    value="Echocardiography">
                <label for="" style="font-weight: normal; margin-right: 10px;">Echocardiography</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][Treadmill][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['Treadmill']['pilihan'] == 'Treadmill' ? 'checked' : '' }}
                    value="Treadmill">
                <label for="" style="font-weight: normal; margin-right: 10px;">Treadmill</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][Gastroscopy][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['Gastroscopy']['pilihan'] == 'Gastroscopy' ? 'checked' : '' }}
                    value="Gastroscopy">
                <label for="" style="font-weight: normal; margin-right: 10px;">Gastroscopy</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][Colonoscopy][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['Colonoscopy']['pilihan'] == 'Colonoscopy' ? 'checked' : '' }}
                    value="Colonoscopy">
                <label for="" style="font-weight: normal; margin-right: 10px;">Colonoscopy</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][EMG][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['EMG']['pilihan'] == 'EMG' ? 'checked' : '' }}
                    value="EMG">
                <label for="" style="font-weight: normal; margin-right: 10px;">EMG</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][OAE][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['OAE']['pilihan'] == 'OAE' ? 'checked' : '' }}
                    value="OAE">
                <label for="" style="font-weight: normal; margin-right: 10px;">OAE</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][EEG][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['EEG']['pilihan'] == 'EEG' ? 'checked' : '' }}
                    value="EEG">
                <label for="" style="font-weight: normal; margin-right: 10px;">EEG</label>
                <input type="checkbox" name="fisik[pemeriksaan_diagnostik][lain_lain][pilihan]"
                    {{ @$asessment['pemeriksaan_diagnostik']['lain_lain']['pilihan'] == 'Lain-lain' ? 'checked' : '' }}
                    value="Lain-lain">
                <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
            </td>
        </tr>
        <tr>
            <td >
                <b>Indikasi Pasien Di Rawat inap</b>
            </td>
            <td colspan="5">
              {{@$asessment['indikasi_pasien_rawat_inap']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Diagnosis Primer</b>
            </td>
            <td colspan="5">
              {{@$asessment['diagnosis_primer']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Diagnosis Sekunder</b>
            </td>
            <td colspan="5">
              {{@$asessment['diagnosis_sekunder']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Prosedur Terapi dan Tindakan yang telah dikerjakan</b>
            </td>
            <td colspan="5">
              {{@$asessment['prosedur_terapi']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>komorbiditas_pasien</b>
            </td>
            <td colspan="5">
              {{@$asessment['komorbiditas_pasien']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Obat Yang Telah Diberikan saat di rawat</b>
            </td>
            <td colspan="5">
              {{@$asessment['obat_yang_diberikan_saat_dirawat']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Obat Yang Telah Diberikan setelah pasien keluar</b>
            </td>
            <td colspan="5">
              {{@$asessment['obat_yang_diberikan_setelah_pasien_keluar']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>Kondisi Pasien</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Pulang atas indikasi medis' ? 'checked' : '' }}
                        value="Pulang atas indikasi medis">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pulang atas indikasi medis</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Pulang atas permintaan sendiri' ? 'checked' : '' }}
                        value="Pulang atas permintaan sendiri">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pulang atas permintaan sendiri</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Pulang kondisi khusus' ? 'checked' : '' }}
                        value="Pulang kondisi khusus">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pulang kondisi khusus</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Pindah/Rujuk RS lain' ? 'checked' : '' }}
                        value="Pindah/Rujuk RS lain">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pindah/Rujuk RS lain</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Meninggal' ? 'checked' : '' }}
                        value="Meninggal">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Meninggal</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Lain-lain' ? 'checked' : '' }}
                        value="Lain-lain">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[kondisi_pasien][pilihan]"
                        {{ @$asessment['kondisi_pasien']['pilihan'] == 'Pulang tanpa izin' ? 'checked' : '' }}
                        value="Pulang tanpa izin">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pulang tanpa izin</label>
                 </div>
            </td>
        </tr>
        <tr>
            <td >
                <b>Keadaan saat pulang</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width: 50%;">KU</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['ku'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Kesadaran</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['kesadaran'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">TD</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['td']}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Nadi</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['nadi']}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Suhu</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['suhu']}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Pernapasan</td>
                        <td style="padding: 5px;">
                            {{ @$asessment['kondisi_pasien']['keadaan_saat_pulang']['pernapasan']}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>Mobilisasi saat pulang</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Mandiri' ? 'checked' : '' }}
                        value="Mandiri">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Mandiri</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Dibantu sebagian' ? 'checked' : '' }}
                        value="Dibantu sebagian">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Dibantu sebagian</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Dibantu penuh' ? 'checked' : '' }}
                        value="Dibantu penuh">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Dibantu penuh</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Alat bantu' ? 'checked' : '' }}
                        value="Alat bantu">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Alat bantu</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Tongkat' ? 'checked' : '' }}
                        value="Tongkat">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Tongkat</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Kursi Roda' ? 'checked' : '' }}
                        value="Kursi Roda">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Kursi Roda</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Branchard' ? 'checked' : '' }}
                        value="Branchard">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Branchard</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                        {{ @$asessment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Walker' ? 'checked' : '' }}
                        value="Walker">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Walker</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>Alat kesehatan yang terpasang</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][tidak_ada]"
                        {{ @$asessment['kondisi_pasien']['alkes']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                        value="Tidak ada">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][iv_catheter]"
                        {{ @$asessment['kondisi_pasien']['alkes']['iv_catheter'] == 'IV catheter' ? 'checked' : '' }}
                        value="IV catheter">
                    <label for="" style="font-weight: normal; margin-right: 10px;">IV catheter</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][dobel_lumen]"
                        {{ @$asessment['kondisi_pasien']['alkes']['dobel_lumen'] == 'Dobel lumen' ? 'checked' : '' }}
                        value="Dobel lumen">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Dobel lumen</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][ngt]"
                        {{ @$asessment['kondisi_pasien']['alkes']['ngt'] == 'NGT' ? 'checked' : '' }}
                        value="NGT">
                    <label for="" style="font-weight: normal; margin-right: 10px;">NGT</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][oksigen]"
                        {{ @$asessment['kondisi_pasien']['alkes']['oksigen'] == 'Oksigen' ? 'checked' : '' }}
                        value="Oksigen">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Oksigen</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[kondisi_pasien][alkes][catheter_urine]"
                        {{ @$asessment['kondisi_pasien']['alkes']['catheter_urine'] == 'Catheter urine' ? 'checked' : '' }}
                        value="Catheter urine">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Catheter urine</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <b>Perawatan dirumah</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                        {{ @$asessment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                        value="Tidak ada">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                        {{ @$asessment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Home Visite' ? 'checked' : '' }}
                        value="Home Visite">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Home Visite</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                        {{ @$asessment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Perawatan lanjutan' ? 'checked' : '' }}
                        value="Perawatan lanjutan">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan lanjutan</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                        {{ @$asessment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Perawatan luka' ? 'checked' : '' }}
                        value="Perawatan luka">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan luka</label>
                  </div>
                  <div>
                    <input type="radio" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                        {{ @$asessment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Pengobatan lanjutan' ? 'checked' : '' }}
                        value="Pengobatan lanjutan">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pengobatan lanjutan</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Rencana pemeriksaan penunjang</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][laboratorim]"
                        {{ @$asessment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['laboratorim'] == 'Laboratorium' ? 'checked' : '' }}
                        value="Laboratorium">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Laboratorium</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][radiologi]"
                        {{ @$asessment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['radiologi'] == 'Radiologi' ? 'checked' : '' }}
                        value="Radiologi">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Radiologi</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][lain_lain]"
                        {{ @$asessment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                        value="Lain-lain">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Kebutuhan edukasi</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][penyakit]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['penyakit'] == 'Penyakit' ? 'checked' : '' }}
                        value="Penyakit">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Penyakit</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][obat]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['obat'] == 'Obat dan efek samping' ? 'checked' : '' }}
                        value="Obat dan efek samping">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Obat dan efek samping</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][diet]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['diet'] == 'Diet' ? 'checked' : '' }}
                        value="Diet">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Diet</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][aktifitas]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['aktifitas'] == 'Aktifitas dan istirahat dirumah' ? 'checked' : '' }}
                        value="Aktifitas dan istirahat dirumah">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Aktifitas dan istirahat dirumah</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][hygiene]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['hygiene'] == 'Hygiene' ? 'checked' : '' }}
                        value="Hygiene">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Hygiene</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][perawatan_dirumah]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['perawatan_dirumah'] == 'Perawatan luka dirumah' ? 'checked' : '' }}
                        value="Perawatan luka dirumah">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan luka dirumah</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][perawatan_ibu_dan_bayi]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['perawatan_ibu_dan_bayi'] == 'Perawatan ibu dan bayi' ? 'checked' : '' }}
                        value="Perawatan ibu dan bayi">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan ibu dan bayi</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][nyeri]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['nyeri'] == 'Nyeri' ? 'checked' : '' }}
                        value="Nyeri">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Nyeri</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][pertolongan_mendesak]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['pertolongan_mendesak'] == 'Pertolongan mendesak' ? 'checked' : '' }}
                        value="Pertolongan mendesak">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Pertolongan mendesak</label>
                  </div>
                  <div>
                    <input type="checkbox" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][lain_lain]"
                        {{ @$asessment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                        value="Lain-lain">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                  </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
              <b>Penyakit berhubungan dengan</b>
            </td>
            <td colspan="5">
                <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Kelainan Bawaan / Kongenital' ? 'checked' : '' }}
                        value="Kelainan Bawaan / Kongenital">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Kelainan Bawaan / Kongenital</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Kesuburan' ? 'checked' : '' }}
                        value="Kesuburan">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Kesuburan</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Gangguan hormonal' ? 'checked' : '' }}
                        value="Gangguan hormonal">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Gangguan hormonal</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Gangguan Mental' ? 'checked' : '' }}
                        value="Gangguan Mental">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Gangguan Mental</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Kecelakaan' ? 'checked' : '' }}
                        value="Kecelakaan">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Kecelakaan</label>
                 </div>
                 <div>
                    <input type="radio" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                        {{ @$asessment['penyakit_berhubungan_dengan']['pilihan'] == 'Kosmetik' ? 'checked' : '' }}
                        value="Kosmetik">
                    <label for="" style="font-weight: normal; margin-right: 10px;">Kosmetik</label>
                 </div>
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
