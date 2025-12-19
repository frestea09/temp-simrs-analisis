<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asesmen Gawat Darurat</title>
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
                <b>ASESMEN GAWAT DARURAT</b>
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
                <b>ASSESMEN AWAL MEDIS</b>
            </td>
            <td colspan="5">
                <ul>
                    <li><strong>Skala Nyeri :</strong> {{ @$asessment['igdAwal']['skalaNyeri'] }}</li>
                    <li><strong>Keluhan Utama :</strong> {{ @$asessment['igdAwal']['keluhanUtama'] }}</li>
                    <li><strong>Riwayat Penyakit Sekarang :</strong> {{ @$asessment['igdAwal']['riwayatPenyakit'] }}
                    </li>
                </ul>
                <table style="width: 100%;font-size:12px;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Airway
                        </td>
                        <td>
                            <div>
        
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Bersih]"
                                        {{ @$asessment['igdAwal']['airway']['Bersih'] == 'Bersih' ? 'checked' : '' }}
                                        type="checkbox" value="Bersih">
                                    <label class="form-check-label">Bersih</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Spontan]"
                                        {{ @$asessment['igdAwal']['airway']['Spontan'] == 'Spontan' ? 'checked' : '' }}
                                        type="checkbox" value="Spontan">
                                    <label class="form-check-label">Spontan</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Dispnoe]"
                                        {{ @$asessment['igdAwal']['airway']['Dispnoe'] == 'Dispnoe' ? 'checked' : '' }}
                                        type="checkbox" value="Dispnoe">
                                    <label class="form-check-label">Dispnoe</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Techipnoe]"
                                        {{ @$asessment['igdAwal']['airway']['Techipnoe'] == 'Techipnoe' ? 'checked' : '' }}
                                        type="checkbox" value="Techipnoe">
                                    <label class="form-check-label">Techipnoe</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Apnoe]"
                                        {{ @$asessment['igdAwal']['airway']['Apnoe'] == 'Apnoe' ? 'checked' : '' }}
                                        type="checkbox" value="Apnoe">
                                    <label class="form-check-label">Apnoe</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Slem]"
                                        {{ @$asessment['igdAwal']['airway']['Slem'] == 'Slem' ? 'checked' : '' }}
                                        type="checkbox" value="Slem">
                                    <label class="form-check-label">Slem</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][airway][Obstruksi]"
                                        {{ @$asessment['igdAwal']['airway']['Obstruksi'] == 'Obstruksi' ? 'checked' : '' }}
                                        type="checkbox" value="Obstruksi">
                                    <label class="form-check-label">Obstruksi</label>
                                </div>
                                <div>
                                    <input type="text" class="form-control" name="asessment[igdAwal][airway][dll]"
                                        style="width: 100%;" value="{{ @$asessment['igdAwal']['airway']['dll'] }}"
                                        placeholder="Lainnya">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Breathing
                        </td>
                        <td>
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][breathing][Ronchi]"
                                    {{ @$asessment['igdAwal']['breathing']['Ronchi'] == 'Ronchi' ? 'checked' : '' }}
                                    type="checkbox" value="Ronchi">
                                <label class="form-check-label">Ronchi</label>
                            </div>
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][breathing][ronchiKering]"
                                    {{ @$asessment['igdAwal']['breathing']['ronchiKering'] == 'ronchiKering' ? 'checked' : '' }}
                                    type="checkbox" value="ronchiKering">
                                <label class="form-check-label">Ronchi Kering</label>
                            </div>
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][breathing][Wheezing]"
                                    {{ @$asessment['igdAwal']['breathing']['Wheezing'] == 'Wheezing' ? 'checked' : '' }}
                                    type="checkbox" value="Wheezing">
                                <label class="form-check-label">Wheezing</label>
                            </div>
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][breathing][Stridor]"
                                    {{ @$asessment['igdAwal']['breathing']['Stridor'] == 'Stridor' ? 'checked' : '' }}
                                    type="checkbox" value="Stridor">
                                <label class="form-check-label">Stridor</label>
                            </div>
                            <div>
                                <input type="text" class="form-control" name="asessment[igdAwal][breathing][dll]"
                                    style="width: 100%;" value="{{ @$asessment['igdAwal']['breathing']['dll'] }}"
                                    placeholder="Lainnya">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Circulation
                        </td>
                        <td>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input"
                                        name="asessment[igdAwal][circulation][tidakAdaPendarahan]"
                                        {{ @$asessment['igdAwal']['circulation']['tidakAdaPendarahan'] == 'tidakAdaPendarahan' ? 'checked' : '' }}
                                        type="checkbox" value="tidakAdaPendarahan">
                                    <label class="form-check-label">Tidak Ada Pendarahan</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input"
                                        name="asessment[igdAwal][circulation][pendarahanRingan]"
                                        {{ @$asessment['igdAwal']['circulation']['pendarahanRingan'] == 'pendarahanRingan' ? 'checked' : '' }}
                                        type="checkbox" value="pendarahanRingan">
                                    <label class="form-check-label">Pendarahan Ringan</label>
                                </div>
                            </div>
                            <div>
        
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input"
                                        name="asessment[igdAwal][circulation][pendarahanSedang]"
                                        {{ @$asessment['igdAwal']['circulation']['pendarahanSedang'] == 'pendarahanSedang' ? 'checked' : '' }}
                                        type="checkbox" value="pendarahanSedang">
                                    <label class="form-check-label">Pendarahan Sedang</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input"
                                        name="asessment[igdAwal][circulation][pendarahanBerat]"
                                        {{ @$asessment['igdAwal']['circulation']['pendarahanBerat'] == 'pendarahanBerat' ? 'checked' : '' }}
                                        type="checkbox" value="pendarahanBerat">
                                    <label class="form-check-label">Pendarahan Berat</label>
                                </div>
                                <div>
                                    <input type="text" class="form-control"
                                        name="asessment[igdAwal][circulation][dll]" style="width: 100%;"
                                        value="{{ @$asessment['igdAwal']['circulation']['dll'] }}" placeholder="Lainnya">
                                </div>
                            </div>
                        </td>
                    </tr>
        
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Kesadaran
                        </td>
                        <td>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][composMentis]"
                                        {{ @$asessment['igdAwal']['kesadaran']['composMentis'] == 'composMentis' ? 'checked' : '' }} type="checkbox"
                                        value="composMentis">
                                    <label class="form-check-label">Compos Mentis</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][apatis]"
                                        {{ @$asessment['igdAwal']['kesadaran']['apatis'] == 'apatis' ? 'checked' : '' }} type="checkbox"
                                        value="apatis">
                                    <label class="form-check-label">Apatis</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][delirium]"
                                        {{ @$asessment['igdAwal']['kesadaran']['delirium'] == 'delirium' ? 'checked' : '' }} type="checkbox"
                                        value="delirium">
                                    <label class="form-check-label">Delirium</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][somnolen]"
                                        {{ @$asessment['igdAwal']['kesadaran']['somnolen'] == 'somnolen' ? 'checked' : '' }} type="checkbox"
                                        value="somnolen">
                                    <label class="form-check-label">Somnolen</label>
                                </div>
                            </div>
        
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][soporoKoma]"
                                        {{ @$asessment['igdAwal']['kesadaran']['soporoKoma'] == 'soporoKoma' ? 'checked' : '' }} type="checkbox"
                                        value="soporoKoma">
                                    <label class="form-check-label">Soporo Koma</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][kesadaran][koma]"
                                        {{ @$asessment['igdAwal']['kesadaran']['koma'] == 'koma' ? 'checked' : '' }} type="checkbox"
                                        value="koma">
                                    <label class="form-check-label">Koma</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Glasgow Coma Scale</td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Mata
                        </td>
                        <td>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                        {{ @$asessment['igdAwal']['glasgow']['mata'] == '4 Spontan' ? 'checked' : '' }} type="radio"
                                        value="4 Spontan">
                                    <label class="form-check-label">4 Spontan</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                        {{ @$asessment['igdAwal']['glasgow']['mata'] == '3 Respon Suara' ? 'checked' : '' }} type="radio"
                                        value="3 Respon Suara">
                                    <label class="form-check-label">3 Respon Suara</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                        {{ @$asessment['igdAwal']['glasgow']['mata'] == '2 Respon Nyeri' ? 'checked' : '' }} type="radio"
                                        value="2 Respon Nyeri">
                                    <label class="form-check-label">2 Respon Nyeri</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][mata]"
                                        {{ @$asessment['igdAwal']['glasgow']['mata'] == '1 Tidak Merepson' ? 'checked' : '' }} type="radio"
                                        value="1 Tidak Merepson">
                                    <label class="form-check-label">1 Tidak Merepson</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL MEDIS</b>
            </td>
            <td colspan="5">       
                <table style="width: 100%;font-size:12px;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Verbal
                        </td>
                        <td>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                        {{ @$asessment['igdAwal']['glasgow']['verbal'] == '5 Sadar Penuh' ? 'checked' : '' }} type="radio"
                                        value="5 Sadar Penuh">
                                    <label class="form-check-label">5 Sadar Penuh</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                        {{ @$asessment['igdAwal']['glasgow']['verbal'] == '4 Bingung' ? 'checked' : '' }} type="radio"
                                        value="4 Bingung">
                                    <label class="form-check-label">4 Bingung</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                        {{ @$asessment['igdAwal']['glasgow']['verbal'] == '3 Kata Kata Tidak Jelas' ? 'checked' : '' }} type="radio"
                                        value="3 Kata Kata Tidak Jelas">
                                    <label class="form-check-label">3 Kata Kata Tidak Jelas</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                        {{ @$asessment['igdAwal']['glasgow']['verbal'] == '2 Hanya Suara' ? 'checked' : '' }} type="radio"
                                        value="2 Hanya Suara">
                                    <label class="form-check-label">2 Hanya Suara</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][verbal]"
                                        {{ @$asessment['igdAwal']['glasgow']['verbal'] == '1 Tidak Merespon' ? 'checked' : '' }} type="radio"
                                        value="1 Tidak Merespon">
                                    <label class="form-check-label">1 Tidak Merespon</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Motorik
                        </td>
                        <td>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '6 Mengikuti Perintah' ? 'checked' : '' }} type="radio"
                                        value="6 Mengikuti Perintah">
                                    <label class="form-check-label">6 Mengikuti Perintah</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '5 Lokalisir Nyeri' ? 'checked' : '' }} type="radio"
                                        value="5 Lokalisir Nyeri">
                                    <label class="form-check-label">5 Lokalisir Nyeri</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '4 Menolak Nyeri' ? 'checked' : '' }} type="radio"
                                        value="4 Menolak Nyeri">
                                    <label class="form-check-label">4 Menolak Nyeri</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '3 Fleksi Abnormal' ? 'checked' : '' }} type="radio"
                                        value="3 Fleksi Abnormal">
                                    <label class="form-check-label">3 Fleksi Abnormal</label>
                                </div>          
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '2 Eksternal Abnormal' ? 'checked' : '' }} type="radio"
                                        value="2 Eksternal Abnormal">
                                    <label class="form-check-label">2 Eksternal Abnormal</label>
                                </div>
                                <div style="display: inline-block; padding: 5px">
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][motorik]"
                                        {{ @$asessment['igdAwal']['glasgow']['motorik'] == '1 Tidak Merespon' ? 'checked' : '' }} type="radio"
                                        value="1 Tidak Merespon">
                                    <label class="form-check-label">Tidak Merespon</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                     <tr>
                        <td style="width:20%; font-weight:bold;">
                            GCS SCORE
                        </td>
                        <td>
                            <span style="width: 20%" >{{@$asessment['igdAwal']['glasgow']['GCS']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">
                            Pupil
                        </td>
                        <td>
                            <div style=" padding-top: 10px; ">
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Normal</label>
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ka][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ka</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][normal][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['normal']['ka']['ket']}}">
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][normal][ki][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['normal']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ki</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][normal][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['normal']['ki']['ket']}}">
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                            <div style="padding-top: 10px;">
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Midriasis</label>
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ka][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ka</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ka']['ket']}}">
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][midriasis][ki][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ki</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['ki']['ket']}}">
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                            <div style="padding-top: 10px;">
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Miosis</label>
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ka][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ka']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ka</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][miosis][ka][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['miosis']['ka']['ket']}}">
                                </div>
                                <div>
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][miosis][ki][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['miosis']['ki']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ki</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][miosis][ki][ket]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['miosis']['ki']['ket']}}">
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                            <div style="padding-top: 10px;">
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][glasgow][pupil][lainnya][ada]"
                                    {{ @$asessment['igdAwal']['glasgow']['pupil']['lainnya']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lainnya</label>
                                    <input type="text" class="form-control"  name="asessment[igdAwal][glasgow][pupil][midriasis][dll]" value="{{@$asessment['igdAwal']['glasgow']['pupil']['midriasis']['dll']}}">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Tanda Vital</td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">TD</td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['tandaVital']['tekananDarah'] }}</span>
                            <span style="width: 20%" >mmHg</span>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;"> Frekuensi Nadi </td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['tandaVital']['frekuensiNadi'] }}</span>
                            <span style="width: 20%" >x/Menit</span>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;"> Suhu </td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['tandaVital']['suhu'] }}</span>
                            <span style="width: 20%" >&deg;C</span>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;"> RR </td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['tandaVital']['RR'] }}</span>
                            <span style="width: 20%" >x/Menit</span>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">BB </td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['tandaVital']['BB'] }}</span>
                            <span style="width: 20%" >Kg</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
       
 
        <tr>
            <td >
                <b>ASSESMEN AWAL MEDIS</b>
            </td>
            <td colspan="5">
                <table style="width: 100%;font-size:12px;k"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td colspan="2" style="width:20%; font-weight:bold; text-align: center">Pemeriksaan Fisik</td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Kulit</td>
                        <td> 
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Pucat]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Pucat'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Pucat</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Cyanosis]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Cyanosis'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Cyanosis</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Ikterik]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Ikterik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ikterik</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][DinginKering]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['DinginKering'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Dingin Kering</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][DinginLembab]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['DinginLembab'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Dingin Lembab</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Berkeringat]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Berkeringat'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Berkeringat</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][normal]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['normal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Hangat/Normal</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][panas]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['panas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Panas</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Eritema]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Eritema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Eritema</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Urtikaria]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Urtikaria'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Urtikaria</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Petichiae]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Petichiae'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Petichiae</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][turgorBaik]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['turgorBaik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Turgor Baik</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Sedang]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Sedang'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Sedang</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kulit][Buruk]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kulit']['Buruk'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Buruk</label>
                                </div>
                            </div>
                            <div >
                                <input type="text" class="form-control" placeholder="Keterangan Lain" name="asessment[igdAwal][pemeriksaanFisik][kulit][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kulit']['ket']}}" style="width: 100%">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Kepala dan Leher</td>
                        <td> 
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Simetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Simetris</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Asimetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Asimetris</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Nyeri]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Nyeri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Nyeri</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][luka]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Luka</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][jejas]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Jejas</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Hematome]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Hematome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Hematome</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][normal]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['normal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Hangat/Normal</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][pembedaranKGB]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['pembedaranKGB'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Pembedaran KGB</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][peningkatanJVP]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['peningkatanJVP'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Peningkatan JVP</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][Massa]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Massa</label>
                                </div>
                                <div style="display: inline-block">
                                    <input type="text" class="form-control"  name="asessment[igdAwal][pemeriksaanFisik][kepala][massaKet]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kepala']['massaKet']}}">
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][fontanelCekung]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['fontanelCekung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Funtanel Cekung</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][mataCekung]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['mataCekung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Mata Cekung</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][kongjungtivaAnemis]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['kongjungtivaAnemis'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Konjungtiva Anemis</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][kepala][skleraIkterik]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['kepala']['skleraIkterik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Sklera Ikterik</label>
                                </div>
                                <div style="display: inline-block">
                                    <input type="text" class="form-control"  name="asessment[igdAwal][pemeriksaanFisik][kepala][lainnya]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['kepala']['lainnya']}}" placeholder="Lainnya">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Dada</td>
                        <td> 
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Simetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Simetris</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Asimetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Asimetris</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Nyeri]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Nyeri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Nyeri</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][Lecet]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lecet</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][luka]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Luka</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][jejas]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Jejas</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][sesak]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['sesak'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Sesak</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiSuprasternal]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiSuprasternal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Retraksi Suprasternal</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiInterkostal]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiInterkostal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Retraksi Interkostal</label>
                                </div>
                            </div>
                            <div style="display: inline-block">
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][dada][retraksiSubsternal]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['dada']['retraksiSubsternal'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Retraksi Substernal</label>
                            </div>
                          
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Suara Paru</td>
                        <td> 
                            <div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Vesikuler]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Vesikuler'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Vesikuler</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Ronchi]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Ronchi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Ronchi</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][Wheezing]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['Wheezing'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Wheezing</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][PerkusiSonor]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['PerkusiSonor'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Perkusi Sonor</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][PerkusiDull]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['PerkusiDull'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Perkusi Dull</label>
                                </div>
                                <div style="display: inline-block">
                                    <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][suaraParu][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['suaraParu']['ket']}}" style="width: 100%">
                                </div>
                            </div>
                          
                        </td>
                    </tr>
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Bunyi Jantung</td>
                        <td> 
                            <div>
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][batasJantung][ada]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['batasJantung']['ada'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Batas Jantung</label>
                                    <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][batasJantung][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['batasJantung']['ket']}}" >
                                </div>
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][s1-s2]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['s1-s2'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">S1-S2 Murni reg/ireg</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][murmur]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['murmur'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Murmur</label>
                                </div>
                                <div >
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][bunyiJantung][gallop]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['bunyiJantung']['gallop'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Gallop</label>
                                </div>
                            </div>
                          
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td >
                <b>ASSESMEN AWAL MEDIS</b>
            </td>
            <td colspan="5">
                <table style="width: 100%;font-size:12px;"class="table-striped table-bordered table-hover table-condensed form-box table"> 
                    <tr>
                        <td  style="width:20%; font-weight:bold;">Abdomen</td>
                        <td> 
                            <div >
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Simetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Simetris</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Asimetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Asimetris</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Soefel]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Soefel'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Soefel</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Kembung]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Kembung'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Kembung</label>
                                </div>
                            </div>
                            <div  style="display: inline-block">
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Distensi]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Distensi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Distensi</label>
                            </div>
                            <div  style="display: inline-block">
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Ascities]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Ascities'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">Ascities</label>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][lukaTerbuka]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['lukaTerbuka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Luka Terbuka</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Lecet]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lecet</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][jejas]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['jejas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Jejas</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Hamatome]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Hamatome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Hamatome</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][pembesaranLimpa]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['pembesaranLimpa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Pembesaran Limpa</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][pembesaran Hepar]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['pembesaran Hepar'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Pembesaran Hepar</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][Massa]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Massal</label>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][nyeriEpigastrik]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['nyeriEpigastrik'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Nyeri Tekan Epigastrik</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][nyeriPubic]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['nyeriPubic'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Nyeri tekan supra pubic</label>
                                </div>
                            </div>
                            <div  style="display: inline-block">
                                <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][mcBurney]"
                                {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['mcBurney'] == 'true' ? 'checked' : '' }} type="checkbox"
                                value="true">
                                <label class="form-check-label">MC Burney Sign</label>
                            </div>
                            <div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][CVAPain]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['CVAPain'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">CVA Pain</label>
                                </div>
                                <div  style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][perkusiThympani]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['perkusiThympani'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Perkusi Tyhmani</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][abdomen][perkusiDull]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['perkusiDull'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">PerkusiDull</label>
                                </div>
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Lainnya" name="asessment[igdAwal][pemeriksaanFisik][abdomen][ket]" value="{{@$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['ket']}}" style="width: 100%">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td  style="width:20%; font-weight:bold;">BU</td>
                        <td> 
                            <span style="width: 20%" >{{@$asessment['igdAwal']['pemeriksaanFisik']['abdomen']['BU'] }}</span>
                            <span style="width: 20%" >x/Menit</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold" colspan="2">Saluran Kemih / Genetalia</td>
                    </tr>
    
                    <tr>
                        <td style="width:20%; font-weight:bold;">Penilian</td>
                        <td >
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Luka]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Luka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Luka</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Lecet]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Lecet'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Lecet</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][NyeriTekan]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['NyeriTekan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Nyeri Tekan</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Oedema]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Oedema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Oedema</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Massa]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Massa'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Massa</label>
                                </div>
                            </div >            
                            <div>
                                    <div style="display: inline-block">
                                        <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Sekresi]"
                                        {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Sekresi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                        value="true">
                                        <label class="form-check-label">Sekresi</label>
                                    </div>
                                    <div style="display: inline-block">
                                        <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][nyeriBAK]"
                                        {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['nyeriBAK'] == 'true' ? 'checked' : '' }} type="checkbox"
                                        value="true">
                                        <label class="form-check-label">Nyeri Saat BAK</label>
                                    </div>
                                    <div style="display: inline-block">
                                        <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Kesulitan]"
                                        {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Kesulitan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                        value="true">
                                        <label class="form-check-label">Kesulitan</label>
                                    </div>
                                </div>
                            
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][RetensiUrine]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['RetensiUrine'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Retensi Urine</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][genetalia][Poliuri]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['Poliuri'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Poliuri</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">Frekuensi BAK</td>
                        <td >
                            <span>{{@$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['frekuensiBak']}}</span>
                        </td>
                    </tr>
                     <tr>
                        <td style="width:20%; font-weight:bold;">Warna</td>
                        <td >
                            <span>{{@$asessment['igdAwal']['pemeriksaanFisik']['genetalia']['warna']}}</span>
                        </td>
                    </tr>   
                    <tr>
                        <td style="text-align: center; font-weight: bold" colspan="2">Ekstremitas (Atas/Bawah)</td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-weight:bold;">Penilian</td>
                        <td >
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Simetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Simetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Simetris</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Asimetris]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Asimetris'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Asimetris</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][keterbatasanGerak]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['keterbatasanGerak'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Keterbaasan Gerak</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Deformitas]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Deformitas'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Deformitas</label>
                                </div>
                               <div>
                                   <div style="display: inline-block">
                                       <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Kontosio]"
                                       {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Kontosio'] == 'true' ? 'checked' : '' }} type="checkbox"
                                       value="true">
                                       <label class="form-check-label">Kontosio</label>
                                   </div>
                                   <div style="display: inline-block">
                                       <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Hematome]"
                                       {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Hematome'] == 'true' ? 'checked' : '' }} type="checkbox"
                                       value="true">
                                       <label class="form-check-label">Hematome</label>
                                   </div>
                               </div>
                               <div>
                                   <div style="display: inline-block">
                                       <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Oedema]"
                                       {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Oedema'] == 'true' ? 'checked' : '' }} type="checkbox"
                                       value="true">
                                       <label class="form-check-label">Oedema</label>
                                   </div>
                                   <div style="display: inline-block">
                                       <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Refleks]"
                                       {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Refleks'] == 'true' ? 'checked' : '' }} type="checkbox"
                                       value="true">
                                       <label class="form-check-label">Refleks</label>
                                   </div>
                               </div>
    
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div >
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Gigitan]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Gigitan'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Gigitan</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][VulnusPunctum]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['VulnusPunctum'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Vulnus Punctum</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Abrasi]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Abrasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Abrasi</label>
                                </div>
                            </div>
                            <div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Laserasi]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Laserasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Laserasi</label>
                                </div>
                            
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Tertutup]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Tertutup'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Tertutup</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][Terbuka]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['Terbuka'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Terbuka</label>
                                </div>
                                <div style="display: inline-block">
                                    <input class="form-check-input" name="asessment[igdAwal][pemeriksaanFisik][ekstremitas][AutoAmputasi]"
                                    {{ @$asessment['igdAwal']['pemeriksaanFisik']['ekstremitas']['AutoAmputasi'] == 'true' ? 'checked' : '' }} type="checkbox"
                                    value="true">
                                    <label class="form-check-label">Auto Amputasi</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold" colspan="2">Diagnosa</td>
                    </tr>
                    <tr>
                        <td colspan="2"> {{@$asessment['igdAwal']['diagnosa']}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold" colspan="2">Tindakan dan Pengobatan</td>
                    </tr>
                    <tr>
                        <td colspan="2"> {{@$asessment['igdAwal']['tindakan_pengobatan']}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL MEDIS</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td style="text-align: center; font-weight: bold" colspan="2">Tindakan Selanjutnya</td>
                    </tr>
                    <tr>
                        <td style="width:40%; font-weight:bold;">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Dirawat' ? 'checked' : '' }} type="radio"
                                    value="Dirawat">
                                <label class="form-check-label">Dirawat Diruang</label>
                            </div>
                        </td>
                        <td>
                            {{@$asessment['igdAwal']['tindakanSelanjutnya']['ruangRawat']}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Dirujuk' ? 'checked' : '' }} type="radio"
                                    value="Dirujuk">
                                <label class="form-check-label">Dirujuk</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'APS' ? 'checked' : '' }} type="radio"
                                    value="APS">
                                <label class="form-check-label">Pulang Atas Permintaan Sendiri / Pulang Paksa</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Observasi' ? 'checked' : '' }} type="radio"
                                    value="Observasi">
                                <label class="form-check-label">Observasi</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Meninggal' ? 'checked' : '' }} type="radio"
                                    value="Meninggal">
                                <label class="form-check-label">Meninggal</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Pulang atas ijin dokter' ? 'checked' : '' }} type="radio"
                                    value="Pulang atas ijin dokter">
                                <label class="form-check-label">Pulang atas ijin dokter</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'DOA' ? 'checked' : '' }} type="radio"
                                    value="DOA">
                                <label class="form-check-label">DOA</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="display: inline-block; padding: 5px">
                                <input class="form-check-input" name="asessment[igdAwal][tindakanSelanjutnya][Pilihan]"
                                    {{ @$asessment['igdAwal']['tindakanSelanjutnya']['Pilihan'] == 'Pindah Ke IGD Umum / Alih IGD' ? 'checked' : '' }} type="radio"
                                    value="Pindah Ke IGD Umum / Alih IGD">
                                <label class="form-check-label">Pindah Ke IGD Umum / Alih IGD</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASUHAN KEPERAWATAN</b>
            </td>
            <td colspan="5">
                @foreach (@$askep as $item)
                  @php
                    $diagnosa     = json_decode($item->diagnosis, true);
                    $implementasi = json_decode($item->fungsional, true);
                    $siki         = json_decode($item->pemeriksaandalam, true);
                  @endphp
                  @if (!empty($diagnosa))
                  - Diagnosa <br>
                    <ul>
                      @foreach ($diagnosa as $d)
                        <li>{{$d}}</li>
                      @endforeach
                    </ul>
                  @endif
                  @if (!empty($siki))
                  - Intervensi <br>
                    <ul>
                      @foreach ($siki as $s)
                        <li>{{$s}}</li>
                      @endforeach
                    </ul>
                  @endif
                  @if (!empty($implementasi))
                  - Implementasi <br>
                    <ul>
                        @foreach ($implementasi as $i)
                          <li>{{$i}}</li>
                        @endforeach
                    </ul>
                  @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td >
                <b>STATUS LOKALIS</b>
            </td>
            <td colspan="5">
                @if (@$gambar->image)
                <img src="{{public_path('images/' . @$gambar->image)}}" alt="Gambar lokalis" style="width: 400px; margin-top:50px">
                @endif
               <br>
               <span>{{@$asessment['igdAwal']['ketLokalis']}}</span>
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
                @php
                    @$irna = \App\Rawatinap::where('registrasi_id', $reg->id)->first();
                    @$dokter_inap = Modules\Pegawai\Entities\Pegawai::find($irna->dokter_id);
                @endphp
            
                {{-- @if ($dokter_inap && $reg->status_reg == "I2")
                    {{ @$dokter_inap->nama }}
                @else --}}
                    {{ @baca_dokter($reg->dokter_id) }}
                {{-- @endif --}}
            </td>            
        </tr>
    </table>

</body>

</html>
