<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dokumen Pemberian Informasi</title>
    <style>
        * {
            font-size: 11px;
        }

        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 4px 8px;
            /* text-align: left; */
        }

        @page {
            padding-bottom: 2cm;
        }

        .footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            text-align: justify;
        }

        .page_break_after {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @if (isset($proses_tte))
        <div class="footer">
            Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan
            RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen
            Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
        <tr>
            <th colspan="1" style="text-align: center;">
                <img src="{{ public_path('images/' . configrs()->logo) }}" style="width: 60px;"><br>
                <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br />
                <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            </th>
            <th colspan="2" style="font-size: 19px !important; text-align: center;">
                PERSETUJUAN <br>
                PASIEN/KELUARGA <br>
                TERHADAP TINDAKAN
            </th>
            <th colspan="3"
                style="vertical-align: middle; text-align: left; padding: 5px; font-size: 12px !important;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 70px; padding: 2px 0; border: none;">No RM</td>
                        <td style="padding: 5px 0; border: none;">: {{ $reg->pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; border: none;">Nama</td>
                        <td style="padding: 5px 0; border: none;">: {{ $reg->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; border: none;">Tgl. Lahir</td>
                        <td style="padding: 5px 0; border: none;">:
                            {{ date('d-m-Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; border: none;">Tgl. Masuk</td>
                        <td style="padding: 5px 0; border: none;">:
                            {{ \Carbon\Carbon::parse($reg->created_at)->format('d-m-Y') }}</td>
                    </tr>
                </table>
    </table>

    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
        <tr style="border: 1px solid black; text-align:center; font-size: 20px !important;">
            <td colspan="4"><b>DOKUMEN PEMBERIAN INFORMASI</b></td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; text-align: center;" class="text-center">
                <b>NO</b>
            </td>
            <td style="border: 1px solid black; width: 25%; text-align: center;" class="text-center">
                <b>TGL/JAM</b>
            </td>
            <td style="border: 1px solid black; width: 30%; text-align: center;" class="text-center">
                <b>JENIS INFORMASI</b>
            </td>
            <td style="border: 1px solid black; width: 30%; text-align: center;" class="text-center">
                <b>ISI INFORMASI</b>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                1
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemasangan Infus
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_infus']['rehidrasi_cairan'] == 'Rehidrasi Cairan' ? 'checked' : '' }}
                        type="checkbox" value="Rehidrasi Cairan">
                    <label class="form-check-label" style="font-weight: 400;">Rehidrasi Cairan</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_infus']['memasukkan_obat'] == 'Memasukkan Obat' ? 'checked' : '' }}
                        type="checkbox" value="Memasukkan Obat">
                    <label class="form-check-label" style="font-weight: 400;">Memasukkan Obat</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_infus']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemasangan_infus']['lainnya'] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                2
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemasangan_dower']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemasangan_dower']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemasangan Dower Cathether
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_dower']['mengeluarkan_urine'] == 'Mengeluarkan Urine' ? 'checked' : '' }}
                        type="checkbox" value="Mengeluarkan Urine">
                    <label class="form-check-label" style="font-weight: 400;">Mengeluarkan Urine</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_dower']['menghitung_kebutuhan'] == 'Menghitung Kebutuhan Cairan' ? 'checked' : '' }}
                        type="checkbox" value="Menghitung Kebutuhan Cairan">
                    <label class="form-check-label" style="font-weight: 400;">Menghitung Kebutuhan Cairan</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_dower']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemasangan_dower'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                3
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['tindakan_restrain']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['tindakan_restrain']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Tindakan Restrain (Pengikatan)
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['tindakan_restrain']['mengurangi_resiko_jatuh'] == 'Mengurangi Resiko Jatuh' ? 'checked' : '' }}
                        type="checkbox" value="Mengurangi Resiko Jatuh">
                    <label class="form-check-label" style="font-weight: 400;">Mengurangi Resiko Jatuh</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['tindakan_restrain']['memudahkan_pemberian_terapi'] == 'Memudahkan Pemberian Terapi' ? 'checked' : '' }}
                        type="checkbox" value="Memudahkan Pemberian Terapi">
                    <label class="form-check-label" style="font-weight: 400;">Memudahkan Pemberian Terapi</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['tindakan_restrain']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['tindakan_restrain'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                4
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['tes_antibiotik']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['tes_antibiotik']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Tes Untuk Antibiotik
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['tes_antibiotik']['mengetahui_alergi_obat'] == 'Mengetahui Alergi Obat' ? 'checked' : '' }}
                        type="checkbox" value="Mengetahui Alergi Obat">
                    <label class="form-check-label" style="font-weight: 400;">Mengetahui Alergi Obat</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['tes_antibiotik']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    name="fisik[dokumen_pemberian_terapi][tes_antibiotik][lainnya]"
                    value="{{ @$data['dokumen_pemberian_terapi']['tes_antibiotik'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                5
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemberian Suntikan / Injeksi
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan']['penahan_sakit'] == 'Penahan Sakit' ? 'checked' : '' }}
                        type="checkbox" value="Penahan Sakit">
                    <label class="form-check-label" style="font-weight: 400;">Penahan Sakit</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan']['antibiotik'] == 'Antibiotik' ? 'checked' : '' }}
                        type="checkbox" value="Antibiotik">
                    <label class="form-check-label" style="font-weight: 400;">Antibiotik</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan']['obat_mual_muntah'] == 'Obat Mual dan Muntah' ? 'checked' : '' }}
                        type="checkbox" value="Obat Mual dan Muntah">
                    <label class="form-check-label" style="font-weight: 400;">Obat Mual dan Muntah</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                6
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemasangan_ngt']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemasangan_ngt']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemasangan NGT
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ngt']['bilas_lambung'] == 'Bilas Lambung' ? 'checked' : '' }}
                        type="checkbox" value="Bilas Lambung">
                    <label class="form-check-label" style="font-weight: 400;">Bilas Lambung</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ngt']['memberikan_obat_makan_minum'] == 'Memberikan obat/makan/minum' ? 'checked' : '' }}
                        type="checkbox" value="Memberikan obat/makan/minum">
                    <label class="form-check-label" style="font-weight: 400;">Memberikan obat/makan/minum</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ngt']['mengurangi_perut_kembung'] == 'Mengurangi perut kembung' ? 'checked' : '' }}
                        type="checkbox" value="Mengurangi perut kembung">
                    <label class="form-check-label" style="font-weight: 400;">Mengurangi perut kembung</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ngt']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemasangan_ngt'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                7
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemasangan OGT
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ogt']['memberikan_obat_makan_minum'] == 'Memberikan obat/makan/minum' ? 'checked' : '' }}
                        type="checkbox" value="Memberikan obat/makan/minum">
                    <label class="form-check-label" style="font-weight: 400;">Memberikan obat/makan/minum</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ogt']['mengurangi_perut_kembung'] == 'Mengurangi perut kembung' ? 'checked' : '' }}
                        type="checkbox" value="Mengurangi perut kembung">
                    <label class="form-check-label" style="font-weight: 400;">Mengurangi perut kembung</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_ogt']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemasangan_ogt'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                8
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['pemasangan_bidai']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['pemasangan_bidai']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Pemasangan Bidai
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_bidai']['mengurangi_nyeri'] == 'Mengurangi Nyeri Akibat Trauma' ? 'checked' : '' }}
                        type="checkbox" value="Mengurangi Nyeri Akibat Trauma">
                    <label class="form-check-label" style="font-weight: 400;">Mengurangi Nyeri Akibat Trauma</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_bidai']['mengurangi_perdarahan'] == 'Mengurangi perdarahan' ? 'checked' : '' }}
                        type="checkbox" value="Mengurangi perdarahan">
                    <label class="form-check-label" style="font-weight: 400;">Mengurangi perdarahan</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['pemasangan_bidai']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['pemasangan_bidai'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                9
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Suction Nasofaring
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['suction_nasofaring']['membersihkan_jalannafas'] == 'Membersihkan Jalan Nafas' ? 'checked' : '' }}
                        type="checkbox" value="Membersihkan Jalan Nafas">
                    <label class="form-check-label" style="font-weight: 400;">Membersihkan Jalan Nafas</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['suction_nasofaring']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['suction_nasofaring'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                10
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['penjahitan_luka']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['penjahitan_luka']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                Penjahitan Luka Derajat Ringan
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['penjahitan_luka']['menghentikan_perdarahan'] == 'Menghentikan Perdarahan' ? 'checked' : '' }}
                        type="checkbox" value="Menghentikan Perdarahan">
                    <label class="form-check-label" style="font-weight: 400;">Menghentikan Perdarahan</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['penjahitan_luka']['menyatukan_jaringan'] == 'Menyatukan Jaringan' ? 'checked' : '' }}
                        type="checkbox" value="Menyatukan Jaringan">
                    <label class="form-check-label" style="font-weight: 400;">Menyatukan Jaringan</label>
                </div>
                <div style="width: 100%;">
                    <input class="form-check-input"
                        {{ @$data['dokumen_pemberian_terapi']['penjahitan_luka']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                        type="checkbox" value="Lainnya">
                    <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                </div>
                <input type="text" placeholder="Isi informasi"
                    value="{{ @$data['dokumen_pemberian_terapi']['penjahitan_luka'][lainnya] }}"
                    class="form-control" />
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                11
            </td>
            <td style="border: 1px solid black; width: 15%; vertical-align: top; padding: 0;" class="text-center">
              <input>{{ @$data['igd']['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['igd']['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu'])) : '' }}
            </td>
            <td style="border: 1px solid black; width: 30%; vertical-align: top; padding: 0;">
                <textarea style="width: 100%;" cols="30"
                    rows="10">{{ @$data['dokumen_pemberian_terapi']['tambahan']['jenis_informasi'] }}</textarea>
            </td>
            <td style="border: 1px solid black; width: 50%; vertical-align: top; padding: 0;">
                <textarea style="width: 100%;" cols="30"
                    rows="10">{{ @$data['dokumen_pemberian_terapi']['tambahan']['isi_informasi'] }}</textarea>
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan
                jujur dan memberikan kesempatan untuk bertanya dan / atau berdiskusi (Petugas)</td>
            <td style="text-align: center;">
                Petugas <br><br><br>
                (..........................................)
            </td>
        </tr>
        <tr style="border: 1px solid black;">
            <td colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya
                tanda tangani di kolom kanannya, dan telah memahaminya dan diberikan waktu / kesempatan untuk berdiskusi
                (pasien dan keluarga)</td>
            <td style="text-align: center;">
                Pasien/Keluarga <br><br><br>
                (..........................................)
            </td>
        </tr>
    </table>
</body>

</html>
