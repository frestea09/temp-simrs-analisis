<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pra Anestesi</title>
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
            padding: 5px;
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
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD OTTO ISKANDAR DINATA. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif
    <table>
        <tr>
            <th colspan="1" style="width: 20%;">
                <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
            </th>
            <th colspan="5" style="font-size: 18pt; width:80%;">
                <b>FORMULIR PEMERIKSAAN PRA ANESTESI</b>
            </th>
        </tr>
        <tr>
            <td colspan="6" style="width:100%;">
                Tanggal Pemeriksaan : {{ !empty($riwayat->created_at) ? date('d-m-Y', strtotime($riwayat->created_at)) : '' }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:35%;">
                <b>Nama Pasien</b><br>
                {{ $pasien->nama }}
            </td>
            <td colspan="2" style="width:30%;">
                <b>Tgl. Lahir</b><br>
                {{ !empty($pasien->tgllahir) ? hitung_umur($pasien->tgllahir) : null }}
            </td>
            <td style="width: 20%;">
                <b>Jenis Kelamin</b><br>
                {{ $pasien->kelamin }}
            </td>
            <td style="width: 15%;">
                <b>No MR.</b><br>
                {{ $pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width:60%;">
                <b>Alamat Lengkap</b><br>
                {{ $pasien->alamat }}
            </td>
            <td colspan="2" style="width:40%;">
                <b>No Telp</b><br>
                {{ $pasien->nohp }}
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            {{-- <td style="vertical-align: middle; width:20%;">
                <b>Subjective</b>
            </td> --}}
            {{-- <td colspan="5" style="width: 80%;"> --}}
                {{-- <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box"> --}}
                    {{-- <tr>
                      <td style="font-weight: bold; width:20%;">BB</td>
                      <td colspan="3" style="padding: 10px; width:70%;">
                        {{@$cetak['praAnestesi']['anamnesa']['BB']}}
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold; width:30%;">TB</td>
                      <td colspan="3" style="padding: 10px; width:70%;">
                        {{@$cetak['praAnestesi']['anamnesa']['TB']}}
                      </td>
                    </tr> --}}
                    {{-- <tr> --}}
          <td style="font-weight: bold; width:30%;">Diagnosa</td>
          <td colspan="3" style="padding: 10px; width:70%;">
            {{@$cetak['praAnestesi']['anamnesa']['diagnosa']}}
          </td>
        </tr>
        <tr>
          <td style="font-weight: bold; width:30%;">Rencana Tindakan</td>
          <td colspan="3" style="padding: 10px; width:70%;">
            {{@$cetak['praAnestesi']['anamnesa']['rencanaTindakan']}}
          </td>
                    {{-- </tr> --}}
                    {{-- <tr>
                      <td style="font-weight: bold; width:30%;">Anamnesis</td>
                      <td colspan="3" style="padding: 10px; width:70%;">
                        <div style="">
                          <b>Riwayat Asma :</b>
                          <div style="margin-left: 10px;">
                              <input class="form-check-input"
                                  name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                  value="false" {{ @$cetak['praAnestesi']['subjective']['asma']['ada'] == 'false' ? 'checked' : '' }}>
                              <label for="">Tidak</label>
                              <input class="form-check-input"
                                  name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                  value="true" {{ @$cetak['praAnestesi']['subjective']['asma']['ada'] == 'true' ? 'checked' : '' }}>
                              <label for="">Ada</label>
                          </div>
                        </div>
                        <div style="">
                            <b>Alergi :</b>
                            <div style="margin-left: 10px;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                    value="false" {{ @$cetak['praAnestesi']['subjective']['alergi']['ada'] == 'false' ? 'checked' : '' }}>
                                <label for="">Tidak</label>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                    value="true" {{ @$cetak['praAnestesi']['subjective']['alergi']['ada'] == 'true' ? 'checked' : '' }}>
                                <label for="">Ada</label>
                            </div>
                        </div>
                        <div style="">
                            <b>DM :</b>
                            <div style="margin-left: 10px;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][DM][ada]" type="radio"
                                    value="false" {{ @$cetak['praAnestesi']['subjective']['DM']['ada'] == 'false' ? 'checked' : '' }}>
                                <label for="">Tidak</label>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][DM][ada]" type="radio"
                                    value="true" {{ @$cetak['praAnestesi']['subjective']['DM']['ada'] == 'true' ? 'checked' : '' }}>
                                <label for="">Ada</label>
                            </div>
                        </div>
                        <div style="">
                            <b>Hypertensi :</b>
                            <div style="margin-left: 10px;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][hypertensi][ada]" type="radio"
                                    value="false" {{ @$cetak['praAnestesi']['subjective']['hypertensi']['ada'] == 'false' ? 'checked' : '' }}>
                                <label for="">Tidak</label>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][subjective][hypertensi][ada]" type="radio"
                                    value="true" {{ @$cetak['praAnestesi']['subjective']['hypertensi']['ada'] == 'true' ? 'checked' : '' }}>
                                <label for="">Ada</label>
                            </div>
                        </div>
                      </td>
                    </tr> --}}
                {{-- </table> --}}
            {{-- </td> --}}
        </tr>
    </table>
    <table style="margin-top: -1;">
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Subjective</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    
                    <tr>
                        <td style="width:50%; font-weight:bold;">Riwayat Operasi</td>
                        <td>
                            <div style="">
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][riwayatOperasi][ada]"
                                        type="radio" value="false" {{ @$cetak['praAnestesi']['subjective']['riwayatOperasi']['ada'] == 'false' ? 'checked' : '' }}>
                                    <label for="">Tidak</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][riwayatOperasi][ada]"
                                        type="radio" value="true"  {{ @$cetak['praAnestesi']['subjective']['riwayatOperasi']['ada'] == 'true' ? 'checked' : '' }} >
                                    <label for="">YA</label>
                                    <input type="text" class="form-control" placeholder="Penyakit yang pernah diderita"
                                        style=""
                                        name="fisik[praAnestesi][subjective][riwayatOperasi][penyakit]"
                                        value="{{ @$cetak['praAnestesi']['subjective']['riwayatOperasi']['penyakit']  }}">
                                </div>
                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                            <td style="width:50%; font-weight:bold;">Asma</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                            value="false" {{ @$cetak['praAnestesi']['subjective']['asma']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                            value="true" {{ @$cetak['praAnestesi']['subjective']['asma']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][asma][pengobatan]" value="{{ @$cetak['praAnestesi']['subjective']['asma']['pengobatan']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Alergi</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                            value="false" {{ @$cetak['praAnestesi']['subjective']['alergi']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                            value="true" {{ @$cetak['praAnestesi']['subjective']['alergi']['ada'] == 'true' ? 'checked' : '' }} >
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Alergi terhadap"
                                            style=""
                                            name="fisik[praAnestesi][subjective][alergi][keterangan]"
                                            value="{{ @$cetak['praAnestesi']['subjective']['asma']['keterangan'] }}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Hipertensi</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][hipertensi][ada]"
                                            type="radio" value="false" {{ @$cetak['praAnestesi']['subjective']['hipertensi']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][hipertensi][ada]"
                                            type="radio" value="true" {{ @$cetak['praAnestesi']['subjective']['hipertensi']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][hipertensi][pengobatan]"
                                            value="{{ @$cetak['praAnestesi']['subjective']['hipertensi']['pengobatan'] }}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Merokok</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][merokok][ada]" type="radio"
                                            value="false"  {{ @$cetak['praAnestesi']['subjective']['merokok']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][merokok][ada]" type="radio"
                                            value="true"  {{ @$cetak['praAnestesi']['subjective']['merokok']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Terakhir kali merokok"
                                            style=""
                                            name="fisik[praAnestesi][subjective][merokok][terakhirMerokok]"
                                            value="{{ @$cetak['praAnestesi']['subjective']['merokok']['terakhirMerokok']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Gastritis</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][gastritis][ada]" type="radio"
                                            value="false" {{ @$cetak['praAnestesi']['subjective']['gastritis']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][gastritis][ada]" type="radio"
                                            value="true" {{ @$cetak['praAnestesi']['subjective']['gastritis']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][gastritis][pengobatan]"
                                            value="{{ @$cetak['praAnestesi']['subjective']['gastritis']['pengobatan']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Diabetes</td>
                            <td>
                                <div style="">
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][diabetes][ada]" type="radio"
                                        value="false" {{ @$cetak['praAnestesi']['subjective']['diabetes']['ada'] == 'false' ? 'checked' : '' }}>
                                    <label for="">Tidak</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][diabetes][ada]" type="radio"
                                        value="true" {{ @$cetak['praAnestesi']['subjective']['diabetes']['ada'] == 'true' ? 'checked' : '' }}>
                                    <label for="">YA</label>
                                    <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][diabetes][pengobatan]"
                                            value="{{ @$cetak['praAnestesi']['subjective']['diabetes']['pengobatan'] }}">
                                </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Obat yang sedang didapat</td>
                            <td>
                                {{ @$cetak['praAnestesi']['subjective']['obatOnGoing']}}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Angina</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][angina][ada]" type="radio"
                                            value="false" {{ @$cetak['praAnestesi']['subjective']['angina']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][angina][ada]" type="radio"
                                            value="true" {{ @$cetak['praAnestesi']['subjective']['angina']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Kejang</td>
                            <td>
                                <div style="">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][kejang][ada]" type="radio"
                                            value="false" {{ @$cetak['praAnestesi']['subjective']['kejang']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][kejang][ada]" type="radio"
                                            value="true" {{ @$cetak['praAnestesi']['subjective']['kejang']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Lain-lain</td>
                            <td>
                                {{ @$cetak['praAnestesi']['anamnesa']['lain-lain']}}
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Objective</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width:50%; font-weight:bold;"> Kesadaran</td>
                        <td colspan="2"> 
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                    value="CM" {{ @$cetak['praAnestesi']['objective']['kesadaran'] == 'CM' ? 'checked' : '' }}>
                                <label for="">CM</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                    value="Apatis" {{ @$cetak['praAnestesi']['objective']['kesadaran'] == 'Apatis' ? 'checked' : '' }}>
                                <label for="">Apatis</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                    value="Somnolen" {{ @$cetak['praAnestesi']['objective']['kesadaran'] == 'Somnolen' ? 'checked' : '' }}>
                                <label for="">Somnolen</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                    value="Soporous" {{ @$cetak['praAnestesi']['objective']['kesadaran'] == 'Soporous' ? 'checked' : '' }}>
                                <label for="">Soporous</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                    value="Coma" {{ @$cetak['praAnestesi']['objective']['kesadaran'] == 'Coma' ? 'checked' : '' }}>
                                <label for="">Coma</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="">
                          <label style="margin-right: 10px;">GCS</label> 
                          <label class="form-check-label" style="">E</label>
                          <input type="text" name="fisik[praAnestesi][objective][GCS][E]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="E" class="form-control" value="{{ @$cetak['praAnestesi']['objective']['GCS']['E'] }}">
                          <label class="form-check-label" style="">M</label>
                          <input type="text" name="fisik[praAnestesi][objective][GCS][M]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="M" class="form-control" value="{{ @$cetak['praAnestesi']['objective']['GCS']['M'] }}">
                          <label class="form-check-label" style="">V</label>
                          <input type="text" name="fisik[praAnestesi][objective][GCS][V]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="V" class="form-control" value="{{ @$cetak['praAnestesi']['objective']['GCS']['V'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Tinggi Badan</td>
                        <td>
                            <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][tinggiBadan]"
                                value="{{ @$cetak['praAnestesi']['objective']['tinggiBadan'] }}">
                        </td>
                        <td> cm </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Berat Badan</td>
                        <td>
                            <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][beratBadan]"
                                value="{{ @$cetak['praAnestesi']['objective']['beratBadan'] }}">
                        </td>
                        <td>Kg</td>
                    </tr>
    

                    <tr>
                        <td colspan="3" style="width:50%; font-weight:bold;"> 
                            Tanda Vital
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;"> Tekanan Darah </td>
                        <td colspan="2">
                            {{ @$cetak['praAnestesi']['objective']['tandaVital']['tekananDarah']['sistolik'] }} / {{ @$cetak['praAnestesi']['objective']['tandaVital']['tekananDarah']['diastolik'] }} mmHg
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Nadi</td>
                        <td> <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][tandaVital][nadi]"
                                value="{{ @$cetak['praAnestesi']['objective']['tandaVital']['nadi'] }}">
                        </td>
                        <td> x/menit </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Respirasi</td>
                        <td> <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][tandaVital][respirasi]"
                                value="{{ @$cetak['praAnestesi']['objective']['tandaVital']['respirasi'] }}">
                        </td>
                        <td> x/menit </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;"> Suhu </td>
                        <td> <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][tandaVital][suhu]"
                                value="{{ @$cetak['praAnestesi']['objective']['tandaVital']['suhu'] }}">
                        </td>
                        <td> oC </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;"> Skor Nyeri </td>
                        <td colspan="2"> <input style="width: 100%" type="number"
                                name="fisik[praAnestesi][objective][tandaVital][skorNyeri]"
                                value="{{ @$cetak['praAnestesi']['objective']['tandaVital']['skorNyeri'] }}">
                        </td>
                    </tr>

                    <tr>
                        <td style="width:50%; font-weight:bold;">Jalan Nafas: mallampati skor</td>
                        <td colspan="2">
                            <div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][jalanNafas]"
                                        type="radio" value="1"  {{ @$cetak['praAnestesi']['objective']['jalanNafas'] == '1' ? 'checked' : '' }} >
                                    <label for="">1</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][jalanNafas]"
                                        type="radio" value="2"  {{ @$cetak['praAnestesi']['objective']['jalanNafas'] == '2' ? 'checked' : '' }} >
                                    <label for="">2</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][jalanNafas]"
                                        type="radio" value="3"  {{ @$cetak['praAnestesi']['objective']['jalanNafas'] == '3' ? 'checked' : '' }} >
                                    <label for="">3</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][jalanNafas]"
                                        type="radio" value="4"  {{ @$cetak['praAnestesi']['objective']['jalanNafas'] == '4' ? 'checked' : '' }} >
                                    <label for="">4</label>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="width:50%; font-weight:bold;">Gigi</td>
                        <td colspan="2">
                            <div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][gigi][0]"
                                        type="checkbox" value="komplit"  {{ @$cetak['praAnestesi']['objective']['gigi'][0] == 'komplit' ? 'checked' : '' }} >
                                    <label for="">Komplit</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][gigi][1]"
                                        type="checkbox" value="tidak komplit"  {{ @$cetak['praAnestesi']['objective']['gigi'][1] == 'tidak komplit' ? 'checked' : '' }} >
                                    <label for="">Tidak Komplit</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][gigi][2]"
                                        type="checkbox" value="goyang"  {{ @$cetak['praAnestesi']['objective']['gigi'][2] == 'goyang' ? 'checked' : '' }} >
                                    <label for="">Goyang</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][gigi][3]"
                                        type="checkbox" value="palsu"  {{ @$cetak['praAnestesi']['objective']['gigi'][3] == 'palsu' ? 'checked' : '' }} >
                                    <label for="">Palsu</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Objective</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td style="width:50%; font-weight:bold;">Leher</td>
                        <td colspan="2">
                            <div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][leher]"
                                        type="radio" value="Mobile"  {{ @$cetak['praAnestesi']['objective']['leher'] == 'Mobile' ? 'checked' : '' }} >
                                    <label for="">Mobile</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][leher]"
                                        type="radio" value="Terbatas"  {{ @$cetak['praAnestesi']['objective']['leher'] == 'Terbatas' ? 'checked' : '' }} >
                                    <label for="">Terbatas</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][leher]"
                                        type="radio" value="Trauma"  {{ @$cetak['praAnestesi']['objective']['leher'] == 'Trauma' ? 'checked' : '' }} >
                                    <label for="">Trauma</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][leher]"
                                        type="radio" value="TMD"  {{ @$cetak['praAnestesi']['objective']['leher'] == 'TMD' ? 'checked' : '' }} >
                                    <label for="">TMD (Thyromental Distance)</label>
                                    <div style="margin-left: 1.5rem;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher_tmd]"
                                            type="radio" value="> 6 cm"  {{ @$cetak['praAnestesi']['objective']['leher_tmd'] == '> 6 cm' ? 'checked' : '' }} >
                                            <label for="" style="font-weight: normal">> 6 cm</label>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher_tmd]"
                                            type="radio" value="< 6 cm"  {{ @$cetak['praAnestesi']['objective']['leher_tmd'] == '< 6 cm' ? 'checked' : '' }} >
                                            <label for="" style="font-weight: normal">&lt; 6 cm</label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Paru</td>
                        <td colspan="2">
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][paru]"
                                            type="radio" value="Dalam Batas Normal"  {{ @$cetak['praAnestesi']['objective']['paru'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                        <label for="">Dalam Batas Normal</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][paru]"
                                            type="radio" value="Lainnya"  {{ @$cetak['praAnestesi']['objective']['paru'] == 'Lainnya' ? 'checked' : '' }} >
                                        <label for="">Lainnya</label>
                            </div>
                            <textarea class="form-control" name="fisik[praAnestesi][objective][paru_lainnya]" placeholder="Isi jika Lainnya" rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['paru_lainnya']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Jantung</td>
                        <td colspan="2">
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jantung]"
                                            type="radio" value="Dalam Batas Normal"  {{ @$cetak['praAnestesi']['objective']['jantung'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                        <label for="">Dalam Batas Normal</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jantung]"
                                            type="radio" value="Lainnya"  {{ @$cetak['praAnestesi']['objective']['jantung'] == 'Lainnya' ? 'checked' : '' }} >
                                        <label for="">Lainnya</label>
                            </div>
                            <textarea class="form-control" name="fisik[praAnestesi][objective][jantung_lainnya]" placeholder="Isi jika Lainnya" rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['jantung_lainnya']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Abdomen</td>
                        <td colspan="2">
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][abdomen]"
                                            type="radio" value="Dalam Batas Normal"  {{ @$cetak['praAnestesi']['objective']['abdomen'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                        <label for="">Dalam Batas Normal</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][abdomen]"
                                            type="radio" value="Lainnya"  {{ @$cetak['praAnestesi']['objective']['abdomen'] == 'Lainnya' ? 'checked' : '' }} >
                                        <label for="">Lainnya</label>
                            </div>
                            <textarea class="form-control" name="fisik[praAnestesi][objective][abdomen_lainnya]" placeholder="Isi jika Lainnya" rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['abdomen_lainnya']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Ekstremitas</td>
                        <td colspan="2">
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][ekstremitas]"
                                            type="radio" value="Dalam Batas Normal"  {{ @$cetak['praAnestesi']['objective']['ekstremitas'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                        <label for="">Dalam Batas Normal</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][ekstremitas]"
                                            type="radio" value="Lainnya"  {{ @$cetak['praAnestesi']['objective']['ekstremitas'] == 'Lainnya' ? 'checked' : '' }} >
                                        <label for="">Lainnya</label>
                            </div>
                            <textarea class="form-control" name="fisik[praAnestesi][objective][ekstremitas_lainnya]" placeholder="Isi jika Lainnya" rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['ekstremitas_lainnya']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">Lain-lain</td>
                        <td colspan="2">
                            <textarea class="form-control" name="fisik[praAnestesi][objective][dll]" rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['dll']}}</textarea>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table>
      <tr>
          <td colspan="2" style="font-weight: bold;">
              Pemeriksaan Penunjang
          </td>
      </tr>
      <tr>
          <td style="width:50%; font-weight:bold;">Laboratorium</td>
          <td>
              <textarea class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][laboratorium]" rows="15">{{@$cetak['praAnestesi']['objective']['penunjang']['laboratorium']}}</textarea>
          </td>
      </tr>
      <tr>
          <td style="width:50%; font-weight:bold;">EKG</td>
          <td>
              <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][ekg]"  value="{{ @$cetak['praAnestesi']['objective']['penunjang']['ekg']}}">
          </td>
      </tr>
      <tr>
          <td style="width:50%; font-weight:bold;">Rontgen</td>
          <td>
              <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][rontgen]"  value="{{ @$cetak['praAnestesi']['objective']['penunjang']['rontgen']}}">
          </td>
      </tr>
      <tr>
          <td style="width:50%; font-weight:bold;">Lain-Lain</td>
          <td>
              <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][dll]"  value="{{ @$cetak['praAnestesi']['objective']['penunjang']['dll']}}">
          </td>
      </tr>
      <tr>
          <td style="width:50%; font-weight:bold;">Hasil Konsultasi Bagian Lain</td>
          <td>
              <textarea class="form-control" name="fisik[praAnestesi][objective][penunjang][konsul]"  rows="2" style="width: 100%;">{{ @$cetak['praAnestesi']['objective']['penunjang']['konsul']}}</textarea>
          </td>
    </table>
    <table>
      <tr>
          <td style="vertical-align: middle; width:20%;">
              <b>Asesmen</b>
          </td>
          <td colspan="5" style="width: 80%;">
              <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                      <td style="width:50%; font-weight:bold;">Skala Nyeri Vas Scale</td>
                      <td>
                          <div style="">
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="1"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == '1' ? 'checked' : '' }} >
                                  <label for="">1</label>
                              </div>
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="2"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == '2' ? 'checked' : '' }} >
                                  <label for="">2</label>
                              </div>
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="3"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == '3' ? 'checked' : '' }} >
                                  <label for="">3</label>
                              </div>
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="4"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == '4' ? 'checked' : '' }} >
                                  <label for="">4</label>
                              </div>
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="5"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == '5' ? 'checked' : '' }} >
                                  <label for="">5</label>
                              </div>
                              <div style="width:100%;">
                                  <input class="form-check-input"
                                      name="fisik[praAnestesi][asesmen][vas_scale]"
                                      type="radio" value="E"  {{ @$cetak['praAnestesi']['asesmen']['vas_scale'] == 'E' ? 'checked' : '' }} >
                                  <label for="">E</label>
                              </div>
                          </div>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
      <tr>
          <td style="vertical-align: middle; width:20%;">
              <b>Planning</b>
          </td>
          <td colspan="5" style="width: 80%;">
              <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                    <td style="width:50%; font-weight:bold;"> Persetujuan Tindakan Anestesi / Sedasi</td>
                    <td>
                        <div style="">
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][persetujuan]"
                                    type="radio" value="Setuju"  {{ @$cetak['praAnestesi']['planning']['persetujuan'] == 'Setuju' ? 'checked' : '' }} >
                                <label for="">Setuju</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][persetujuan]"
                                    type="radio" value="Tidak Setuju"  {{ @$cetak['praAnestesi']['planning']['persetujuan'] == 'Tidak Setuju' ? 'checked' : '' }} >
                                <label for="">Tidak Setuju</label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="font-weight: bold;">
                        Preoperatif
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Puasa Mulai Jam</td>
                    <td>
                        <input class="form-control" type="text" name="fisik[praAnestesi][planning][preOperatif][puasa]" style="width: 100%" value="{{ @$cetak['praAnestesi']['planning']['preOperatif']['puasa']}}"/>
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Premedikasi</td>
                    <td>
                        <input class="form-control" type="text" name="fisik[praAnestesi][planning][preOperatif][preMedikasi]" style="width: 100%" value="{{ @$cetak['praAnestesi']['planning']['preOperatif']['preMedikasi']}}"/>
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Lain-Lain</td>
                    <td>
                        <textarea class="form-control" rows="3" name="fisik[praAnestesi][planning][lainLain]" style="width: 100%;">{{ @$cetak['praAnestesi']['planning']['lainLain'] }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="font-weight: bold;">
                        Intraoperatif
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Jenis Anestesi</td>
                    <td>
                        <div style="">
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                    type="radio" value="Umum"  {{ @$cetak['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Umum' ? 'checked' : '' }} >
                                <label for="">Umum</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                    type="radio" value="Regional"  {{ @$cetak['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Regional' ? 'checked' : '' }} >
                                <label for="">Regional</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                    type="radio" value="Kombinasi"  {{ @$cetak['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Kombinasi' ? 'checked' : '' }} >
                                <label for="">Kombinasi</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                    type="radio" value="Sedasi"  {{ @$cetak['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Sedasi' ? 'checked' : '' }} >
                                <label for="">Sedasi</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                    type="radio" value="MAC"  {{ @$cetak['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'MAC' ? 'checked' : '' }} >
                                <label for="">MAC</label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="font-weight: bold;">
                        Postoperatif
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Rencana penanganan nyeri</td>
                    <td>
                        <textarea class="form-control" name="fisik[praAnestesi][planning][postOperatif][penangananNyeri]" rows="2" style="width: 100%">{{ @$cetak['praAnestesi']['planning']['postOperatif']['penangananNyeri']}}</textarea>
                    </td>
                </tr>
                
                <tr>
                    <td style="width:50%; font-weight:bold;">Perawatan pasca operatif</td>
                    <td>
                        <textarea class="form-control" name="fisik[praAnestesi][planning][postOperatif][perawatan]" rows="2" style="width: 100%">{{ @$cetak['praAnestesi']['planning']['postOperatif']['perawatan']}}</textarea>
                    </td>
                </tr>
          
                <tr>
                    <td style="width:50%; font-weight:bold;">Surat Ijin Anestesi</td>
                    <td>
                        <div style="">
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][suratIzinAnestesi]"
                                    type="radio" value="Tidak"  {{ @$cetak['praAnestesi']['planning']['suratIzinAnestesi'] == 'Tidak' ? 'checked' : '' }} >
                                <label for="">Tidak</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][suratIzinAnestesi]"
                                    type="radio" value="Ya"  {{ @$cetak['praAnestesi']['planning']['suratIzinAnestesi'] == 'Ya' ? 'checked' : '' }} >
                                <label for="">Ya</label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="width:50%; font-weight:bold;">Edukasi</td>
                    <td>
                        <div style="">
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][edukasi]"
                                    type="radio" value="Tidak"  {{ @$cetak['praAnestesi']['planning']['edukasi'] == 'Tidak' ? 'checked' : '' }} >
                                <label for="">Tidak</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][edukasi]"
                                    type="radio" value="Ya"  {{ @$cetak['praAnestesi']['planning']['edukasi'] == 'Ya' ? 'checked' : '' }} >
                                <label for="">Ya</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:50%; font-weight:bold;">Produk Darah bila diperlukan</td>
                    <td>
                        <div style="">
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][produkDarah][pilihan]"
                                    type="radio" value="Tidak"  {{ @$cetak['praAnestesi']['planning']['produkDarah']['pilihan'] == 'Tidak' ? 'checked' : '' }} >
                                <label for="">Tidak</label>
                            </div>
                            <div style="width:100%;">
                                <input class="form-check-input"
                                    name="fisik[praAnestesi][planning][produkDarah][pilihan]"
                                    type="radio" value="Ya"  {{ @$cetak['praAnestesi']['planning']['produkDarah']['pilihan'] == 'Ya' ? 'checked' : '' }} >
                                <label for="">Ya</label>
                                <input type="text" class="form-control" name="fisik[praAnestesi][planning][produkDarah][penjelasan]" value="{{ @$cetak['praAnestesi']['planning']['produkDarah']['penjelasan'] }}" >
                            </div>
                        </div>
                    </td>
                </tr>
              </table>
          </td>
      </tr>
    </table>

    <br>
    <table style="border: 0px; width:100%;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                
            </td>
            <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                Dokter <br><br>
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
                @else
                  <br><br><br>
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
                {{ Auth::user()->pegawai->nama }}
            </td>
        </tr>
    </table>

</body>

</html>