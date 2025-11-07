<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asesmen Awal Kebidanan IGD Ponek</title>
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
    </style>
</head>

<body>
    <table>
        <tr>
            <th colspan="1">
                <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
            </th>
            <th colspan="5" style="font-size: 18pt;">
                <b>ASESMEN AWAL KEBIDANAN PONEK</b>
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
            <td>
                Keluhan Utama
            </td>
            <td colspan="5">
              {{ @$asessment['riwayat']['keluhanUtama'] }}
            </td>
        </tr>
        <tr>
          <td>Tanda Vital</td>
          <td colspan="5" style="">
            <ul>

              <li>TD : {{@$asessment['tanda_vital']['tekanan_darah'] }} mmHg</li>
              <li>Nadi : {{@$asessment['tanda_vital']['nadi'] }} x/menit</li>
              <li>Frekuensi Nafas : {{@$asessment['tanda_vital']['frekuensi_nafas'] }} x/menit</li>
              <li>Suhu : {{@$asessment['tanda_vital']['suhu'] }} &deg;C</li>
              <li>BB : {{@$asessment['tanda_vital']['BB'] }} Kg</li>
              <li>TB : {{@$asessment['tanda_vital']['TB'] }} cm</li>
              <li>SPO2 : {{@$asessment['tanda_vital']['SPO2'] }}</li>
              <li>IMT : {{@$asessment['tanda_vital']['IMT'] }}</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td style="">
              Kesadaran
          </td>
          <td colspan="5">
              <div style="display: inline-block; padding: 5px">
                  <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                      {{ @$asessment['kesadaran']['compos_mentis'] == 'Ya' ? 'checked' : '' }} type="checkbox"
                      value="Ya">
                  <label class="form-check-label">Compos Mentis</label>
              </div>
              <div style="display: inline-block; padding: 5px">
                  <input class="form-check-input" name="asessment[kesadaran][apatis]"
                      {{ @$asessment['kesadaran']['apatis'] == 'Ya' ? 'checked' : '' }} type="checkbox"
                      value="Ya">
                  <label class="form-check-label">Apatis</label>
              </div>
              <div style="display: inline-block; padding: 5px">
                  <input class="form-check-input" name="asessment[kesadaran][sopor]"
                      {{ @$asessment['kesadaran']['sopor'] == 'Ya' ? 'checked' : '' }} type="checkbox"
                      value="Ya">
                  <label class="form-check-label">Sopor</label>
              </div>
              <div style="display: inline-block; padding: 5px">
                  <input class="form-check-input" name="asessment[kesadaran][somnolen]"
                      {{ @$asessment['kesadaran']['somnolen'] == 'Ya' ? 'checked' : '' }} type="checkbox"
                      value="Ya">
                  <label class="form-check-label">Somnolen</label>
              </div>
              <div style="display: inline-block; padding: 5px">
                  <input class="form-check-input" name="asessment[kesadaran][coma]"
                      {{ @$asessment['kesadaran']['coma'] == 'Ya' ? 'checked' : '' }} type="checkbox"
                      value="Ya">
                  <label class="form-check-label">Coma</label>
              </div>
          </td>
        </tr>
        <tr>
          <td>Asesmen Nyeri</td>
          <td colspan="5">
            {{ @$asessment['asesmen_nyeri']['pilihan'] }}
            @if(@$asessment['asesmen_nyeri']['pilihan'] == 'Ya')
            <ul>
              <li>
                Provokatif : {{ @$asessment['asesmen_nyeri']['provokatif']['pilihan'] }} {{ @$asessment['asesmen_nyeri']['provokatif']['sebutkan'] }}
              </li>
              <li>
                Quality : {{ @$asessment['asesmen_nyeri']['quality']['pilihan'] }}
              </li>
              <li>
                Region : {{ @$asessment['asesmen_nyeri']['region']['lokasi'] ?? '-' }}, Menyebar : {{ @$asessment['asesmen_nyeri']['region']['pilihan'] ?? '-' }}
              </li>
              <li>
                Severity : {{ @$asessment['asesmen_nyeri']['severity']['pilihan'] ?? '-' }}, Skor : {{ @$asessment['asesmen_nyeri']['severity']['skor'] ?? '-' }}
              </li>
              <li>
                Time : {{ @$asessment['asesmen_nyeri']['time'] }}
              </li>
              <li>
                Nyeri Hilang Jika : {{ @$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] }} {{ @$asessment['asesmen_nyeri']['nyeriHilang']['lainya'] }}
              </li>
              <li>
                Resiko Cidera / Jatuh : {{ @$asessment['asesmen_nyeri']['cidera']}}
              </li>
            </ul>
            @endif
          </td>
        </tr>
        <tr>
          <td>Menstruasi</td>
          <td colspan="5">
            <ul>
              <li>HPHT : {{ @$asessment['riwayat']['hpht'] }}</li>
              <li>TP : {{ @$asessment['riwayat']['tp'] }}</li>
              <li>Usia Kehamilan : {{ @$asessment['riwayat']['usia_kehamilan'] }}</li>
              <li>Lainnya : {{ @$asessment['riwayat']['lainnya'] }}</li>
            </ul>
          </td>
        </tr>
        <tr>
            <td>Riwayat Kesehatan</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Riwayat Alergi :
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][obat]"
                        {{ @$asessment['riwayat']['obat'] == 'Obat' ? 'checked' : '' }} type="checkbox"
                        value="Obat">
                    <label class="form-check-label">Obat</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][makanan]"
                        {{ @$asessment['riwayat']['makanan'] == 'Makanan' ? 'checked' : '' }} type="checkbox"
                        value="Makanan">
                    <label class="form-check-label">Makanan</label>
                </div>
                <br>
                {{ @$asessment['riwayat']['lainnya1'] }}
            </td>
        </tr>
        <tr>
            <td>Riwayat Perkawinan</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Status :
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][bkawin]"
                        {{ @$asessment['riwayat']['bkawin'] == 'BKawin' ? 'checked' : '' }} type="checkbox"
                        value="BKawin">
                    <label class="form-check-label">Belum Kawin</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][kawin]"
                        {{ @$asessment['riwayat']['kawin'] == 'Kawin' ? 'checked' : '' }} type="checkbox"
                        value="Kawin">
                    <label class="form-check-label">Kawin</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][cerai]"
                        {{ @$asessment['riwayat']['cerai'] == 'Cerai' ? 'checked' : '' }} type="checkbox"
                        value="Cerai">
                    <label class="form-check-label">Cerai</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Menikah (x) : {{ @$asessment['riwayat']['menikah'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Lama Menikah : {{ @$asessment['riwayat']['lama'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="">
                Riwayat Penyakit Dahulu
            </td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][pil_dhl]"
                        {{ @$asessment['riwayat']['pil_dhl'] == 'Pil' ? 'checked' : '' }} type="checkbox"
                        value="Pil">
                    <label class="form-check-label">Pil</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][jantung_dhl]"
                        {{ @$asessment['riwayat']['jantung_dhl'] == 'jantung' ? 'checked' : '' }} type="checkbox"
                        value="jantung">
                    <label class="form-check-label">Jantung</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][asma_dhl]"
                        {{ @$asessment['riwayat']['asma_dhl'] == 'asma' ? 'checked' : '' }} type="checkbox"
                        value="asma">
                    <label class="form-check-label">Asma</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][hipertensi_dhl]"
                        {{ @$asessment['riwayat']['hipertensi_dhl'] == 'hipertensi' ? 'checked' : '' }} type="checkbox"
                        value="hipertensi">
                    <label class="form-check-label">Hipertensi</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][DM_dhl]"
                        {{ @$asessment['riwayat']['DM_dhl'] == 'DM' ? 'checked' : '' }} type="checkbox"
                        value="DM">
                    <label class="form-check-label">DM</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][hepatitis_dhl]"
                        {{ @$asessment['riwayat']['hepatitis_dhl'] == 'Hepatitis' ? 'checked' : '' }} type="checkbox"
                        value="Hepatitis">
                    <label class="form-check-label">Hepatitis</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][alergi_dhl]"
                        {{ @$asessment['riwayat']['alergi_dhl'] == 'Alergi' ? 'checked' : '' }} type="checkbox"
                        value="Alergi">
                    <label class="form-check-label">Alergi</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][ginjal_dhl]"
                        {{ @$asessment['riwayat']['ginjal_dhl'] == 'Ginjal' ? 'checked' : '' }} type="checkbox"
                        value="Ginjal">
                    <label class="form-check-label">Ginjal</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][tidak_ada_dhl]"
                        {{ @$asessment['riwayat']['tidak_ada_dhl'] == 'Tidak Ada' ? 'checked' : '' }} type="checkbox"
                        value="Tidak Ada">
                    <label class="form-check-label">Tidak Ada</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="">
                Riwayat Penyakit Keluarga
            </td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][pil_klg]"
                        {{ @$asessment['riwayat']['pil_klg'] == 'Pil' ? 'checked' : '' }} type="checkbox"
                        value="Pil">
                    <label class="form-check-label">Pil</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][jantung_klg]"
                        {{ @$asessment['riwayat']['jantung_klg'] == 'jantung' ? 'checked' : '' }} type="checkbox"
                        value="jantung">
                    <label class="form-check-label">Jantung</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][asma_klg]"
                        {{ @$asessment['riwayat']['asma_klg'] == 'asma' ? 'checked' : '' }} type="checkbox"
                        value="asma">
                    <label class="form-check-label">Asma</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][hipertensi_klg]"
                        {{ @$asessment['riwayat']['hipertensi_klg'] == 'hipertensi' ? 'checked' : '' }} type="checkbox"
                        value="hipertensi">
                    <label class="form-check-label">Hipertensi</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][DM_klg]"
                        {{ @$asessment['riwayat']['DM_klg'] == 'DM' ? 'checked' : '' }} type="checkbox"
                        value="DM">
                    <label class="form-check-label">DM</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][hepatitis_klg]"
                        {{ @$asessment['riwayat']['hepatitis_klg'] == 'Hepatitis' ? 'checked' : '' }} type="checkbox"
                        value="Hepatitis">
                    <label class="form-check-label">Hepatitis</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][alergi_klg]"
                        {{ @$asessment['riwayat']['alergi_klg'] == 'Alergi' ? 'checked' : '' }} type="checkbox"
                        value="Alergi">
                    <label class="form-check-label">Alergi</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][ginjal_klg]"
                        {{ @$asessment['riwayat']['ginjal_klg'] == 'Ginjal' ? 'checked' : '' }} type="checkbox"
                        value="Ginjal">
                    <label class="form-check-label">Ginjal</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][tidak_ada_klg]"
                        {{ @$asessment['riwayat']['tidak_ada_klg'] == 'Tidak Ada' ? 'checked' : '' }} type="checkbox"
                        value="Tidak Ada">
                    <label class="form-check-label">Tidak Ada</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="">
                Riwayat Gynecolog
            </td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][infertilitas]"
                        {{ @$asessment['riwayat']['infertilitas'] == 'Infertilitas' ? 'checked' : '' }} type="checkbox"
                        value="Infertilitas">
                    <label class="form-check-label">Infertilitas</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][infeksi_virus]"
                        {{ @$asessment['riwayat']['infeksi_virus'] == 'Infeksi Virus' ? 'checked' : '' }} type="checkbox"
                        value="Infeksi Virus">
                    <label class="form-check-label">Infeksi Virus</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][PMS]"
                        {{ @$asessment['riwayat']['PMS'] == 'PMS' ? 'checked' : '' }} type="checkbox"
                        value="PMS">
                    <label class="form-check-label">PMS</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][cervitis_akut]"
                        {{ @$asessment['riwayat']['cervitis_akut'] == 'Cervitis Akut' ? 'checked' : '' }} type="checkbox"
                        value="Cervitis Akut">
                    <label class="form-check-label">Cervitis Akut</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][endometriosis]"
                        {{ @$asessment['riwayat']['endometriosis'] == 'Endometriosis' ? 'checked' : '' }} type="checkbox"
                        value="Endometriosis">
                    <label class="form-check-label">Endometriosis</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][polyp_cervix]"
                        {{ @$asessment['riwayat']['polyp_cervix'] == 'Polyp Cervix' ? 'checked' : '' }} type="checkbox"
                        value="Polyp Cervix">
                    <label class="form-check-label">Polyp Cervix</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][myoma]"
                        {{ @$asessment['riwayat']['myoma'] == 'Myoma' ? 'checked' : '' }} type="checkbox"
                        value="Myoma">
                    <label class="form-check-label">Myoma</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][ca_cervix]"
                        {{ @$asessment['riwayat']['ca_cervix'] == 'CA Cervix' ? 'checked' : '' }} type="checkbox"
                        value="CA Cervix">
                    <label class="form-check-label">CA Cervix</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][operasi_kandungan]"
                        {{ @$asessment['riwayat']['operasi_kandungan'] == 'Operasi Kandungan' ? 'checked' : '' }} type="checkbox"
                        value="Operasi Kandungan">
                    <label class="form-check-label">Operasi Kandungan</label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="">
                Riwayat Kehamilan dan Persalinan
            </td>
            <td colspan="5">
                <table style="width: 100%; text-align:center;font-size:12px;"
                    class="table-striped table-bordered table-hover table-condensed form-box table"
                    border="2">
                    <tr>
                        <td style="padding: 5px;" rowspan="2">No</td>
                        <td style="padding: 5px;" rowspan="2">Tempat Persalinan</td>
                        <td style="padding: 5px;" rowspan="2">Jenis Persalinan</td>
                        <td style="padding: 5px;" rowspan="2">Penolong</td>
                        <td style="padding: 5px;" rowspan="2">Penyulit Kehamilan</td>
                        <td style="padding: 5px;" colspan="3">Anak</td>
                    </tr>
                    <tr>
                        <td>L/P</td>
                        <td>BB</td>
                        <td>Hidup/Mati</td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat1']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat1']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat2']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat2']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat3']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat3']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat4']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat4']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat5']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat5']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat6']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat6']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat7']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat7']['h/p']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{@$asessment['riwayat8']['no']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['tempat']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['jenis']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['penolong']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['penyulit']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['jkelamin']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['bb']}}
                        </td>
                        <td>
                            {{@$asessment['riwayat8']['h/p']}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Riwayat KB</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    KB : 
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][ya]"
                        {{ @$asessment['riwayat']['ya'] == 'Iya' ? 'checked' : '' }} type="checkbox"
                        value="Iya">
                    <label class="form-check-label">Ya</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][tidak]"
                        {{ @$asessment['riwayat']['tidak'] == 'tidak' ? 'checked' : '' }} type="checkbox"
                        value="tidak">
                    <label class="form-check-label">Tidak</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    KB Yang Pernah Dipakai: 
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][pil]"
                        {{ @$asessment['riwayat']['pil'] == 'pil' ? 'checked' : '' }} type="checkbox"
                        value="pil">
                    <label class="form-check-label">Pil</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][iud]"
                        {{ @$asessment['riwayat']['iud'] == 'iud' ? 'checked' : '' }} type="checkbox"
                        value="iud">
                    <label class="form-check-label">IUD</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][suntik]"
                        {{ @$asessment['riwayat']['suntik'] == 'suntik' ? 'checked' : '' }} type="checkbox"
                        value="suntik">
                    <label class="form-check-label">Suntik</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][susuk]"
                        {{ @$asessment['riwayat']['susuk'] == 'susuk' ? 'checked' : '' }} type="checkbox"
                        value="susuk">
                    <label class="form-check-label">Susuk / Norplant</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    {{ @$asessment['riwayat']['lainnya4'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td>Riwayat ANC</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][ya2]"
                        {{ @$asessment['riwayat']['ya2'] == 'Iya' ? 'checked' : '' }} type="checkbox"
                        value="Iya">
                    <label class="form-check-label">Ya</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][tidak2]"
                        {{ @$asessment['riwayat']['tidak2'] == 'tidak' ? 'checked' : '' }} type="checkbox"
                        value="tidak">
                    <label class="form-check-label">Tidak</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][kandungan]"
                        {{ @$asessment['riwayat']['kandungan'] == 'kandungan' ? 'checked' : '' }} type="checkbox"
                        value="kandungan">
                    <label class="form-check-label">Kandungan</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][bidan]"
                        {{ @$asessment['riwayat']['bidan'] == 'bidan' ? 'checked' : '' }} type="checkbox"
                        value="bidan">
                    <label class="form-check-label">Bidan</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    {{ @$asessment['riwayat']['lainnya5'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td>Keluhan Saat Hamil</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Hamil Muda :
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][mual1]"
                        {{ @$asessment['riwayat']['mual1'] == 'mual' ? 'checked' : '' }} type="checkbox"
                        value="mual">
                    <label class="form-check-label">Mual</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][perdarahan1]"
                        {{ @$asessment['riwayat']['perdarahan1'] == 'perdarahan' ? 'checked' : '' }} type="checkbox"
                        value="perdarahan">
                    <label class="form-check-label">Perdarahan</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    {{ @$asessment['riwayat']['lainnya6'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Hamil Tua :
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][mual2]"
                        {{ @$asessment['riwayat']['mual2'] == 'mual' ? 'checked' : '' }} type="checkbox"
                        value="mual">
                    <label class="form-check-label">Mual</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][perdarahan2]"
                        {{ @$asessment['riwayat']['perdarahan2'] == 'perdarahan' ? 'checked' : '' }} type="checkbox"
                        value="perdarahan">
                    <label class="form-check-label">Perdarahan</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    {{ @$asessment['riwayat']['lainnya7'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td>Keadaan Bio Psikososial</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Pola Makan : {{ @$asessment['riwayat']['polamakan'] }} x/hari
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Pola Minum : {{ @$asessment['riwayat']['polaminum'] }} cc/hari
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][sulitmenelan]"
                        {{ @$asessment['riwayat']['sulitmenelan'] == 'sulitmenelan' ? 'checked' : '' }} type="checkbox"
                        value="sulitmenelan">
                    <label class="form-check-label">Sulit Menelan</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][sulitmengunyah]"
                        {{ @$asessment['riwayat']['sulitmengunyah'] == 'sulitmengunyah' ? 'checked' : '' }} type="checkbox"
                        value="sulitmengunyah">
                    <label class="form-check-label">Sulit Mengunyah</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][muntah]"
                        {{ @$asessment['riwayat']['muntah'] == 'muntah' ? 'checked' : '' }} type="checkbox"
                        value="muntah">
                    <label class="form-check-label">Muntah</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[riwayat][nafsumakan]"
                        {{ @$asessment['riwayat']['nafsumakan'] == 'nafsumakan' ? 'checked' : '' }} type="checkbox"
                        value="nafsumakan">
                    <label class="form-check-label">Kehilangan Nafsu Makan</label>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Pola Eliminasi : 
                    <br>
                    BAK = {{ @$asessment['riwayat']['BAK'] ?? '-' }} cc/hari, Warna = {{ @$asessment['riwayat']['warna'] }}
                    <br>
                    BAB = {{ @$asessment['riwayat']['banyak'] ?? '-' }} x/hari
                </div>
            </td>
        </tr>
        <tr>
            <td>Pemeriksaan Fisik</td>
            <td colspan="3" style="vertical-align: top;">
                <ol>
                    <li>
                        Kepala
                    </li>
                    <li>
                        Mata
                        <ul>
                            <li>Anemis : {{ @$asessment['pemeriksaanFisik']['mata']['anemis'] }}</li>
                            <li>Ikterik : {{ @$asessment['pemeriksaanFisik']['mata']['ikterik'] }}</li>
                            <li>Lainnya : {{ @$asessment['pemeriksaanFisik']['mata']['lainnya'] }}</li>
                        </ul>
                    </li>
                    <li>
                        Leher
                        <ul>
                            <li>KGB Membesar : {{ @$asessment['pemeriksaanFisik']['leher']['kgb'] }}</li>
                            <li>JVP Meningkat : {{ @$asessment['pemeriksaanFisik']['leher']['jvp'] }}</li>
                        </ul>
                    </li>
                    <li>
                        Payudara
                        <ul>
                            <li>Bentuk : {{ @$asessment['pemeriksaanFisik']['payudara']['bentuk'] }}</li>
                            <li>ASI : {{ @$asessment['pemeriksaanFisik']['payudara']['asi'] }}</li>
                            <li>Kolostrum : {{ @$asessment['pemeriksaanFisik']['payudara']['kolostrum'] }}</li>
                        </ul>
                    </li>
                </ol>
            </td>
            <td colspan="2" style="vertical-align: top;">
                <ol start="5">
                    <li>
                        Abdomen
                        <ul>
                            <li>Linea Nigra : {{ @$asessment['pemeriksaanFisik']['abdomen']['linea'] }}</li>
                            <li>Striae : {{ @$asessment['pemeriksaanFisik']['abdomen']['striae'] }}</li>
                            <li>Luka Bekas Operasi : {{ @$asessment['pemeriksaanFisik']['abdomen']['lukaBekasOperasi'] }}</li>
                            <li>TFU : {{ @$asessment['pemeriksaanFisik']['payudara']['tfu'] }} cm</li>
                            <li>Kontraksi Uterus : {{ @$asessment['pemeriksaanFisik']['abdomen']['kontraksiUterus']['pilihan'] }}</li>
                            <li>Massa : {{ @$asessment['pemeriksaanFisik']['abdomen']['massa'] }}</li>
                            <li>Nyeri Tekan : {{ @$asessment['pemeriksaanFisik']['abdomen']['nyeriTekan'] }}</li>
                            <li>BJA : {{ @$asessment['pemeriksaanFisik']['abdomen']['BJA'] }} x/menit </li>
                            <li>Bising Usus : {{ @$asessment['pemeriksaanFisik']['abdomen']['bisingUsus'] }}</li>
                            <li>L I : {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold1']['pilihan'] }} {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold1']['sebutkan'] }}</li>
                            <li>L II : {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold2']['pilihan'] }} {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold2']['sebutkan'] }}</li>
                            <li>L III : {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold3']['pilihan'] }} {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold3']['sebutkan'] }}</li>
                            <li>L IV : {{ @$asessment['pemeriksaanFisik']['abdomen']['leopold4']['pilihan'] }}</li>
                        </ul>
                    </li>
                    <li>
                        Genitalia
                        <ul>
                            <li>Pengeluaran : {{ @$asessment['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] }} {{ @$asessment['pemeriksaanFisik']['genitalia']['pengeluaran']['jelaskan'] }}</li>
                            <li>Kelainan : {{ @$asessment['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] }}</li>
                            <li>Lochea : {{ @$asessment['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] }}</li>
                            <li>Perineum : {{ @$asessment['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] }}</li>
                            <li>Jahitan : {{ @$asessment['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] }}</li>
                            <li>Robekan : {{ @$asessment['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] }}</li>
                            <li>Anus : {{ @$asessment['pemeriksaanFisik']['genitalia']['anus']['pilihan'] }}</li>
                        </ul>
                    </li>
                </ol>
            </td>
        </tr>
        <tr>
            <td>Pemeriksaan Dalam</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Vulva Vagina : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVagina'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan1'] == 'T.A.K' ? 'checked' : '' }} type="checkbox"
                            value="T.A.K">
                        <label class="form-check-label">T.A.K</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan2'] == 'T.A.K' ? 'checked' : '' }} type="checkbox"
                            value="T.A.K">
                        <label class="form-check-label">T.A.K</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan3'] == 'Tampak Tali Pusat' ? 'checked' : '' }} type="checkbox"
                            value="Tampak Tali Pusat">
                        <label class="form-check-label">Tampak Tali Pusat</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan4'] == 'Ruptur' ? 'checked' : '' }} type="checkbox"
                            value="Ruptur">
                        <label class="form-check-label">Ruptur</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVaginaPilihan5'] == 'Kista bartholini' ? 'checked' : '' }} type="checkbox"
                            value="Kista bartholini">
                        <label class="form-check-label">Kista bartholini</label>
                    </div>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Portio :
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="asessment[pemeriksaanPenunjang][tebal]"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['tebal'] == 'Tebal' ? 'checked' : '' }} type="checkbox"
                            value="Tebal">
                        <label class="form-check-label">Tebal</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="asessment[pemeriksaanPenunjang][lunak]"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['lunak'] == 'Lunak' ? 'checked' : '' }} type="checkbox"
                            value="Lunak">
                        <label class="form-check-label">Lunak</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="asessment[pemeriksaanPenunjang][tipis]"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['tipis'] == 'Tipis' ? 'checked' : '' }} type="checkbox"
                            value="Tipis">
                        <label class="form-check-label">Tipis</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="asessment[pemeriksaanPenunjang][kaku]"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['kaku'] == 'Kaku' ? 'checked' : '' }} type="checkbox"
                            value="Kaku">
                        <label class="form-check-label">Kaku</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ruptur]"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portioPilihan']['ruptur'] == 'Ruptur' ? 'checked' : '' }} type="checkbox"
                            value="Ruptur">
                        <label class="form-check-label">Ruptur</label>
                    </div>
                    <br>
                    {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['portio'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Ketuban :  {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['ketuban'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['ketubanPilihan1'] == 'Positif' ? 'checked' : '' }} type="checkbox"
                            value="Positif">
                        <label class="form-check-label">Positif</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['ketubanPilihan2'] == 'Negatif' ? 'checked' : '' }} type="checkbox"
                            value="Negatif">
                        <label class="form-check-label">Negatif</label>
                    </div>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Sisa : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['sisa'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan1'] == 'Jernih' ? 'checked' : '' }} type="checkbox"
                            value="Jernih">
                        <label class="form-check-label">Jernih</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan2'] == 'Keruh' ? 'checked' : '' }} type="checkbox"
                            value="Keruh">
                        <label class="form-check-label">Keruh</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan3'] == 'Hijau' ? 'checked' : '' }} type="checkbox"
                            value="Hijau">
                        <label class="form-check-label">Hijau</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['sisaPilihan4'] == 'Mekonium' ? 'checked' : '' }} type="checkbox"
                            value="Mekonium">
                        <label class="form-check-label">Mekonium</label>
                    </div>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Lakmus : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['lakmus'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['lakmusPilihan1'] == 'Positif' ? 'checked' : '' }} type="checkbox"
                            value="Positif">
                        <label class="form-check-label">Positif</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['lakmusPilihan2'] == 'Negatif' ? 'checked' : '' }} type="checkbox"
                            value="Negatif">
                        <label class="form-check-label">Negatif</label>
                    </div>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Presentasi : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentasi'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan1'] == 'Kepala' ? 'checked' : '' }} type="checkbox"
                            value="Kepala">
                        <label class="form-check-label">Kepala</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan2'] == 'Bokong' ? 'checked' : '' }} type="checkbox"
                            value="Bokong">
                        <label class="form-check-label">Bokong</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan3'] == 'Kaki' ? 'checked' : '' }} type="checkbox"
                            value="Kaki">
                        <label class="form-check-label">Kaki</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentasiPilihan4'] == 'Lintang' ? 'checked' : '' }} type="checkbox"
                            value="Lintang">
                        <label class="form-check-label">Lintang</label>
                    </div>
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Penurunan Kepala : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepala'] }}
                    <br>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan1'] == 'Hodge 1' ? 'checked' : '' }} type="checkbox"
                            value="Hodge 1">
                        <label class="form-check-label">Hodge 1</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan2'] == 'Hodge 2' ? 'checked' : '' }} type="checkbox"
                            value="Hodge 2">
                        <label class="form-check-label">Hodge 2</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan3'] == 'Hodge 3' ? 'checked' : '' }} type="checkbox"
                            value="Hodge 3">
                        <label class="form-check-label">Hodge 3</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input"
                            {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['penurunanKepalaPilihan4'] == 'Hodge 4' ? 'checked' : '' }} type="checkbox"
                            value="Hodge 4">
                        <label class="form-check-label">Hodge 4</label>
                    </div>
                </div>
                <br>
                {{-- <div style="display: inline-block; padding: 5px">
                    Pemeriksaan Dalam : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['presentaseFetus'] }}
                </div> --}}
                <div style="display: inline-block; padding: 5px">
                    Pembukaan : {{ @$asessment['pemeriksaanFisik']['pemeriksaanDalam']['pembukaan'] }}
                </div>
                <br>
            </td>
        </tr>
        <tr>
            <td>Gyonecologi</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    Kelenjar Bartholini : {{ @$asessment['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Inspekulo : {{ @$asessment['pemeriksaanFisik']['gyonecologi']['inspekulo'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Ekstremitas Atas dan Bawah : {{ @$asessment['pemeriksaanFisik']['ekstremitasAtasBawah'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Oedem : {{ @$asessment['pemeriksaanFisik']['oedem']['pilihan'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Varises : {{ @$asessment['pemeriksaanFisik']['varises']['pilihan'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Kekuatan Otot dan Sendi : {{ @$asessment['pemeriksaanFisik']['kekuatanOtot']['pilihan'] }}
                </div>
                <br>
                <div style="display: inline-block; padding: 5px">
                    Reflex : {{ @$asessment['pemeriksaanFisik']['reflex']['pilihan'] }}
                </div>
            </td>
        </tr>
        <tr>
            <td>Pemeriksaan Penunjang</td>
            <td colspan="5">
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][laboratorium]"
                        {{ @$asessment['pemeriksaanPenunjang']['laboratorium'] == 'Laboratorium' ? 'checked' : '' }} type="checkbox"
                        value="Laboratorium">
                    <label class="form-check-label">Laboratorium</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ekg]"
                        {{ @$asessment['pemeriksaanPenunjang']['ekg'] == 'EKG' ? 'checked' : '' }} type="checkbox"
                        value="EKG">
                    <label class="form-check-label">EKG</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][radiologi]"
                        {{ @$asessment['pemeriksaanPenunjang']['radiologi'] == 'Radiologi' ? 'checked' : '' }} type="checkbox"
                        value="Radiologi">
                    <label class="form-check-label">Radiologi</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][ctg]"
                        {{ @$asessment['pemeriksaanPenunjang']['ctg'] == 'CTG/NST' ? 'checked' : '' }} type="checkbox"
                        value="CTG/NST">
                    <label class="form-check-label">CTG/NST</label>
                </div>
                <div style="display: inline-block; padding: 5px">
                    <input class="form-check-input" name="asessment[pemeriksaanPenunjang][usg]"
                        {{ @$asessment['pemeriksaanPenunjang']['usg'] == 'USG' ? 'checked' : '' }} type="checkbox"
                        value="USG">
                    <label class="form-check-label">USG</label>
                </div>
                <br>
                {{ @$asessment['pemeriksaanPenunjang']['lainnya'] }}
            </td>
        </tr>
        <tr>
            <td>Discharge Planning</td>
            <td colspan="5">
                {{-- JIKA PULANG --}}
                @if (@$asessment['rencanaPemulangan']['kontrol']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['kontrol']['dipilih']}} - {{@$asessment['rencanaPemulangan']['kontrol']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['dirawat']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['dirawat']['dipilih']}} - {{@$asessment['rencanaPemulangan']['dirawat']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['kontrolPRB']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['kontrolPRB']['dipilih']}} - {{@$asessment['rencanaPemulangan']['kontrolPRB']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['Konsultasi']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['Konsultasi']['dipilih']}} - {{@$asessment['rencanaPemulangan']['Konsultasi']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['pulpak']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['pulpak']['dipilih']}} - {{@$asessment['rencanaPemulangan']['pulpak']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['observasi']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['observasi']['dipilih']}} - {{@$asessment['rencanaPemulangan']['observasi']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['meninggal']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['meninggal']['dipilih']}} - {{@$asessment['rencanaPemulangan']['meninggal']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['alihigd']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['alihigd']['dipilih']}} - {{@$asessment['rencanaPemulangan']['alihigd']['waktu']}}
                @elseif(@$asessment['rencanaPemulangan']['alihponek']['dipilih'])
                    {{@$asessment['rencanaPemulangan']['alihponek']['dipilih']}} - {{@$asessment['rencanaPemulangan']['alihponek']['waktu']}}
                @else
                    {{@$asessment['rencanaPemulangan']['dirujuk']['dipilih']}} - {{@$asessment['rencanaPemulangan']['dirujuk']['waktu']}}
                @endif
                <br>Ketika Pulang Masih Memerlukan Perawatan Lanjutan (Kontrol) : {{ @$asessment['rencanaPemulangan']['kontrol']['pilihan'] }}
            </td>
        </tr>

        {{-- <tr>
            <td >
                <b>ASUHAN KEPERAWATAN</b>
            </td>
            <td colspan="5">
                @if (@$diagnosis)    
                    <b>Diagnosa</b>
                    <br>
                    @foreach (@$diagnosis as $diagnosa)
                    - {{ $diagnosa }} <br>
                    @endforeach
                    <br>
                @endif
                @if (@$siki)    
                    <b>Intervensi</b>
                    <br>
                    @foreach (@$siki as $siki)
                    * {{ $siki }} <br>
                    @endforeach
                    <br>
                @endif
                @if (@$implementasi)   
                    <b>Implementasi</b>
                    <br>
                    @foreach (@$implementasi as $i)
                    * {{ $i }} <br>
                    @endforeach
                @endif
            </td>
        </tr> --}}

    </table>
    <table style="border: 0px;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                Bidan
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
                {{ @$pemeriksaan->user->name }}
            </td>
        </tr>
    </table>

</body>

</html>
