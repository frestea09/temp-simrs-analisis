<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Surveilans Infeksi_{{ @$reg->pasien->no_rm }}</title>
    <style>
        table{
          width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            /* padding: 15px; */
            padding: 0;
            /* text-align: left; */
        }

        .pdd {
            padding: 15px;
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
        .page_break_after{
          page-break-after: always;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
  </head>
  <body>

    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    <table>
        <tr>
          <th colspan="1" class="pdd">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 18pt;" class="pdd">
            <b>FORMULIR SURVEILANS INFEKSI</b>
          </th>
        </tr>
        <tr>
            <td colspan="2" class="pdd">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2" class="pdd">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td class="pdd">
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}
            </td>
            <td class="pdd">
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="4" class="pdd">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td class="pdd">
              <b>Poli / Ruangan</b><br>
              {{ @$reg->rawat_inap ? @$reg->rawat_inap->kamar->nama : @$reg->poli->nama }}
            </td>
            <td class="pdd">
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
    </table>
    <br>
    <table>
      <tr>
        <td style="width: 30%;" class="pdd"><b>Diagnosa Saat Masuk</b></td>
        <td class="pdd">
          {{ @$asessment['diagnosa_saat_masuk']}}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;" class="pdd"><b>Faktor Resiko Selama Di Rawat</b></td>
        <td class="pdd">
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][keganasan]"
                    {{ @$asessment['faktor_risiko']['keganasan'] == 'Keganasan' ? 'checked' : '' }}
                    type="checkbox" value="Keganasan">
                <label class="form-check-label" style="font-weight: 400;">Keganasan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][gizi_buruk]"
                    {{ @$asessment['faktor_risiko']['gizi_buruk'] == 'Gizi Buruk' ? 'checked' : '' }}
                    type="checkbox" value="Gizi Buruk">
                <label class="form-check-label" style="font-weight: 400;">Gizi Buruk</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][ggn_imunitas]"
                    {{ @$asessment['faktor_risiko']['ggn_imunitas'] == 'Ggn. Imunitas' ? 'checked' : '' }}
                    type="checkbox" value="Ggn. Imunitas">
                <label class="form-check-label" style="font-weight: 400;">Ggn. Imunitas</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][diabetes]"
                    {{ @$asessment['faktor_risiko']['diabetes'] == 'Diabetes' ? 'checked' : '' }}
                    type="checkbox" value="Diabetes">
                <label class="form-check-label" style="font-weight: 400;">Diabetes</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][hiv]"
                    {{ @$asessment['faktor_risiko']['hiv'] == 'HIV' ? 'checked' : '' }}
                    type="checkbox" value="HIV">
                <label class="form-check-label" style="font-weight: 400;">HIV</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][hbv]"
                    {{ @$asessment['faktor_risiko']['hbv'] == 'HBV' ? 'checked' : '' }}
                    type="checkbox" value="HBV">
                <label class="form-check-label" style="font-weight: 400;">HBV</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[faktor_risiko][hcv]"
                    {{ @$asessment['faktor_risiko']['hcv'] == 'HCV' ? 'checked' : '' }}
                    type="checkbox" value="HCV">
                <label class="form-check-label" style="font-weight: 400;">HCV</label>
            </div>
        </td>
      </tr>
    </table>

    <br>

    <div class="page_break_after"></div>    

    <table class="border" style="width: 100%; font-size: 10px;">
        <tr class="border">
            <td rowspan="2" class="border text-center bold">NO</td>
            <td rowspan="2" class="border text-center bold">Lokasi</td>
            <td rowspan="2" class="border text-center bold">Kode Akses 1/2/3/4</td>
            <td colspan="2" class="border text-center bold">Tanggal Pemasangan</td>
            <td colspan="2" class="border text-center bold">Kemerahan</td>
            <td colspan="2" class="border text-center bold">Bengkak</td>
            <td colspan="2" class="border text-center bold">Demam</td>
            <td colspan="2" class="border text-center bold">Nyeri</td>
            <td colspan="2" class="border text-center bold">Pus</td>
            <td rowspan="2" class="border text-center bold">Hasil Kultur Darah</td>
        </tr>
        <tr class="border">
            <td class="border bold text-center">Mulai</td>
            <td class="border bold text-center">S/D Selesai</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
        </tr>

        @for ($i = 1; $i <= 27; $i++)
            <tr class="border">
                <td class="border bold" style="text-align:center">
                    {{$i}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_risiko_infeksi'][$i]['lokasi']}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_risiko_infeksi'][$i]['kode_akses']}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_risiko_infeksi'][$i]['tanggal_pemasangan']['mulai']}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_risiko_infeksi'][$i]['tanggal_pemasangan']['selesai']}}
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][kemerahan][ya]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['kemerahan']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][kemerahan][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['kemerahan']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][bengkak][ya]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['bengkak']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][bengkak][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['bengkak']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][demam][ya]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['demam']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][demam][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['demam']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][nyeri][ya]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['nyeri']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][nyeri][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['nyeri']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][pus][ya]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['pus']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][pus][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_risiko_infeksi'][$i]['pus']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                </td>
                <td class="border text-center" style="padding:2px">
                    {{@$asessment['pengawasan_risiko_infeksi'][$i]['hasil_kultur_darah']}}
                </td>
            </tr>
        @endfor
    </table>

    <br>

    <table>
        <tr>
          <td style="width: 30%; padding:5px"><b>PHLEBITIS</b></td>
          <td style="padding: 5px">
            {{ @$asessment['phlebitis']['pilihan']}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>IADP</b></td>
          <td style="padding: 5px">
            {{ @$asessment['iadp']['pilihan']}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>TOTAL HARI PEMASANGAN</b></td>
          <td style="padding: 5px">
            <div>
                - <b>Kateterperifer (Hari) : </b> {{@$asessment['kateterperifer']}}
            </div>
            <div>
                - <b>Katetersentral (Hari) : </b> {{@$asessment['katetersentral']}}
            </div>
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>PENGAWASAN INFEKSI SALURAN KEMIH (ISK)</b></td>
          <td style="padding: 5px">
            {{ @$asessment['kateter_urin']['pilihan']}}
          </td>
        </tr>
    </table>

    <br>

    <div class="page_break_after"></div>

    <table class="border" style="width: 100%; font-size: 10px;">
        <tr class="border">
            <td rowspan="2" class="border text-center bold">NO</td>
            <td colspan="2" class="border text-center bold">Tanggal Pemasangan</td>
            <td colspan="2" class="border text-center bold">Kemerahan Dalam Urin</td>
            <td colspan="2" class="border text-center bold">Demam</td>
            <td colspan="2" class="border text-center bold">Nyeri Berkemih</td>
            <td colspan="2" class="border text-center bold">Pus Dalam Urin</td>
            <td rowspan="2" class="border text-center bold">Hasil Kultur Urin</td>
        </tr>
        <tr class="border">
            <td class="border bold text-center">Mulai</td>
            <td class="border bold text-center">S/D</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
        </tr>

        @for ($i = 1; $i <= 3; $i++)
            <tr class="border">
                <td class="border bold" style="text-align: center">
                    {{$i}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['tanggal_pemasangan']['mulai']}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['tanggal_pemasangan']['selesai']}}
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][kemerahan][ya]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['kemerahan']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][kemerahan][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['kemerahan']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][demam][ya]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['demam']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][demam][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['demam']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][nyeri][ya]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['nyeri']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][nyeri][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['nyeri']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][pus][ya]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['pus']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][pus][tidak]" style="display:inline-block;" {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['pus']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pengawasan_infeksi_saluran_kemih'][$i]['hasil_kultur']}}
                </td>
            </tr>
        @endfor
    </table>

    <br>

    <table>
        <tr>
          <td style="width: 30%; padding:5px"><b>KEJADIAN ISK</b></td>
          <td style="padding: 5px">
            {{ @$asessment['kejadian_isk']['pilihan']}}
          </td>
        </tr>
    </table>

    <br>

    <table class="border" style="width: 100%; font-size: 10px;">
        <tr class="border">
            <td colspan="15" class="text-center">
                <b>PEMASANGAN VENTILATOR ASSOCIATED PNEUMONIA (VAP)</b>
            </td>
        </tr>
        <tr class="border">
            <td rowspan="2" class="border text-center bold">NO</td>
            <td rowspan="2" class="border text-center bold">Tanggal Kejadian</td>
            <td colspan="2" class="border text-center bold">Batuk</td>
            <td colspan="2" class="border text-center bold">Demam</td>
            <td colspan="2" class="border text-center bold">Leukositosis / Leukopeni</td>
            <td colspan="2" class="border text-center bold">Ronkhi</td>
            <td colspan="2" class="border text-center bold">Sesak</td>
            <td colspan="3" class="border text-center bold">Jenis Sputum</td>
        </tr>
        <tr class="border">
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Ya</td>
            <td class="border bold text-center">Tidak</td>
            <td class="border bold text-center">Encer</td>
            <td class="border bold text-center">Kental</td>
            <td class="border bold text-center">Purulent</td>
        </tr>

        @for ($i = 1; $i <= 2; $i++)
            <tr class="border">
                <td class="border bold text-center">
                    {{$i}}
                </td>
                <td class="border" style="padding:2px">
                    {{@$asessment['pemasangan_ventilator_associated'][$i]['tanggal_kejadian']}}
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][batuk][ya]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['batuk']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][batuk][tidak]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['batuk']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][demam][ya]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['demam']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][demam][tidak]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['demam']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][leukopeni][ya]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['leukopeni']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][leukopeni][tidak]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['leukopeni']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][ronkhi][ya]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['ronkhi']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][ronkhi][tidak]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['ronkhi']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][sesak][ya]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['sesak']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][sesak][tidak]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['sesak']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][encer]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['encer'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][kental]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['kental'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
                <td class="border text-center">
                    <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][purulen]" style="display:inline-block;" {{@$asessment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['purulen'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                </td>
            </tr>
        @endfor
    </table>

    <br>

    <table>
        <tr>
          <td style="width: 30%; padding:5px"><b>Tanggal Pasang</b></td>
          <td style="padding: 5px">
            {{ @$asessment['tanggal_pasang_ventilator']}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>PEMANTAUAN INFEKSI DAERAH OPERASI (IDO)</b></td>
          <td style="padding: 5px">
            Pemakaian antibiotika profilaksis : {{ @$asessment['pemakaian_antibioka_profilaksis']['ya'] }} {{ @$asessment['pemakaian_antibioka_profilaksis']['sebutkan'] }}
          </td>
        </tr>
    </table>

    <br>

    {{-- <div class="page_break_after"></div> --}}

    <table class="border" style="width: 100%; font-size: 10px">
        <tr class="border">
            <td rowspan="2" class="border text-center bold" style="padding: 5px">Keadaan Luka</td>
            <td colspan="22" class="border text-center bold" style="padding: 5px">Hari Operasi</td>
        </tr>
        <tr class="border">
            @for ($i = 1; $i <= 22; $i++)
                <td class="border bold text-center" style="padding: 5px">{{$i}}</td>
            @endfor
        </tr>

        <tr class="border">
            <td class="border text-center bold" style="padding: 5px">KEMERAHAN</td>
            @for ($i = 1; $i <= 22; $i++)
                <td class="border bold text-center" style="padding: 5px">
                    {{@$assesment['pemantauan_infeksi_daerah_operasi']['kemerahan'][$i]}}
                </td>
            @endfor
        </tr>

        <tr class="border">
            <td class="border text-center bold" style="padding: 5px">EDEMA</td>
            @for ($i = 1; $i <= 22; $i++)
                <td class="border bold text-center" style="padding: 5px">
                    {{@$assesment['pemantauan_infeksi_daerah_operasi']['edema'][$i]}}
                </td>
            @endfor
        </tr>

        <tr class="border">
            <td class="border text-center bold" style="padding: 5px">CAIRAN</td>
            @for ($i = 1; $i <= 22; $i++)
                <td class="border bold text-center" style="padding: 5px">
                    {{@$assesment['pemantauan_infeksi_daerah_operasi']['cairan'][$i]}}
                </td>
            @endfor
        </tr>

        <tr class="border">
            <td class="border text-center bold" style="padding: 5px">NYERI</td>
            @for ($i = 1; $i <= 22; $i++)
                <td class="border bold text-center" style="padding: 5px">
                    {{@$assesment['pemantauan_infeksi_daerah_operasi']['nyeri'][$i]}}
                </td>
            @endfor
        </tr>
    </table>

    <br>

    <table>
        <tr>
          <td style="width: 30%; padding:5px"><b>Kejadian Infeksi Daerah (IDO)</b></td>
          <td style="padding: 5px">
            {{ @$asessment['kejadian_infeksi_daerah']['pilihan']}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>PEMANTAUAN INFEKSI DAERAH OPERASI (IDO)</b></td>
          <td style="padding: 5px">
            Pemakaian antibiotika profilaksis : {{ @$asessment['pemakaian_antibioka_profilaksis']['ya'] }} {{ @$asessment['pemakaian_antibioka_profilaksis']['sebutkan'] }}
          </td>
        </tr>
    </table>

    <br>

    <table class="border" style="width: 100%; font-size: 10px">
        <tr class="border">
            <td colspan="8" class="border text-center bold">Kondisi Pasien</td>
            <td colspan="6" class="border text-center bold">Inspeksi Kulit</td>
        </tr>
        <tr class="border">
            <td colspan="2" class="border text-center bold">Immobilisasi</td>
            <td colspan="2" class="border text-center bold">Penurunan Sensori</td>
            <td colspan="2" class="border text-center bold">Adanya Penekanan</td>
            <td colspan="2" class="border text-center bold">Kelembaban Kulit</td>
            <td colspan="2" class="border text-center bold">Kemerahan</td>
            <td colspan="2" class="border text-center bold">Lecet</td>
            <td colspan="2" class="border text-center bold">Luka Tekan</td>
        </tr>
        <tr class="border">
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
            <td class="border text-center bold">Ya</td>
            <td class="border text-center bold">Tidak</td>
        </tr>
        <tr class="border">
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][immobilisasi][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['immobilisasi']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][immobilisasi][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['immobilisasi']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][penuruan_sensori][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['penuruan_sensori']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][penuruan_sensori][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['penuruan_sensori']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][adanya_penekanan][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['adanya_penekanan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][adanya_penekanan][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['adanya_penekanan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kelembaban_kulit][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['kelembaban_kulit']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kelembaban_kulit][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['kelembaban_kulit']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kemerahan][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['kemerahan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kemerahan][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['kemerahan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][lecet][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['lecet']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][lecet][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['lecet']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][luka_tekan][ya]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['luka_tekan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
            <td class="border text-center">
                <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][luka_tekan][tidak]" style="display:inline-block;" {{@$asessment['pemantauan_luka_tekan']['1']['luka_tekan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
          <td style="width: 30%; padding:5px"><b>KEJADIAN LUKA TEKAN / DEKUBITUS</b></td>
          <td style="padding: 5px">
            {{ @$asessment['kejadian_luka_tekan_dekubitus']['pilihan']}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%; padding:5px"><b>TANGGAL PASIEN KELUAR RS</b></td>
          <td style="padding: 5px">
            {{ @$asessment['tanggal_pasien_keluar_rs']}}
          </td>
        </tr>
    </table>

    <br>

  </body>
</html>
 