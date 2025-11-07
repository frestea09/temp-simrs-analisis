<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
    <style>
        table, th, td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
        .border-top{
            border-top: 0.5px solid rgb(85, 83, 83);
        }
        .border-right{
            border-right: 0.5px solid rgb(85, 83, 83) !important;
        }
        .borderles-table{
            border: none;
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
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    <table style="border: 1px solid">
      <tr >
        <th colspan="1" style="border: 1px solid;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </th>
        <th colspan="5" style="font-size: 20pt; border: 1px solid;">
          <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK HEMODIALISIS</b>
        </th>
      </tr>
      <tr>
        <td colspan="6" style="border: 1px solid;">
          <b>TANGGAL PEMERIKSAAN : </b>
          {{ date('d-m-Y',strtotime(@$soap->created_at)) }}
        </td>
      </tr>
        <tr>
            <td colspan="2" style="border: 1px solid;">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2" style="border: 1px solid;">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td style="border: 1px solid;">
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td style="border: 1px solid;">
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="border: 1px solid;">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td style="border: 1px solid;">
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>ANAMNESA</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            1. Keluhan Utama <br/>
            @if (is_array(@json_decode(@$soap->fisik, true)['keluhan_utama']['pilihan']))
              @foreach (@json_decode(@$soap->fisik, true)['keluhan_utama']['pilihan'] as $item)
                - {{@$item}} <br>
              @endforeach
            @else
              - {{ @json_decode(@$soap->fisik, true)['keluhan_utama']['pilihan'] == 'Lainnya' ? '' : @json_decode(@$soap->fisik, true)['keluhan_utama']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['keluhan_utama']['pilihan_lain'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <br/><br>
            @endif  
            2. Nyeri (NRS) <br>
            @if (@json_decode(@$soap->fisik, true)['keluhan_utama']['nyeri']['pilihan'] == 'Tidak')
              - Tidak
            @else
              <br>
              <img src="{{ asset('Skala-nyeri-wajah.png') }}" style="width: 200px"> <br>
              - {{ @json_decode(@$soap->fisik, true)['keluhan_utama']['skalaNyeri'] ? '(Skala nyeri : ' . @json_decode(@$soap->fisik, true)['keluhan_utama']['skalaNyeri'] . ')' : '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endif

          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5" style="border: 1px solid;">

            @php
              $pemeriksaan_fisik = json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']
            @endphp
            1. Keadaan Umum <br/>
            @if (@$pemeriksaan_fisik['keadaan_umum']['pilihan'])
              @if (is_array(@$pemeriksaan_fisik['keadaan_umum']['pilihan']))
                @foreach (@$pemeriksaan_fisik['keadaan_umum']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan'] == 'Lainnya' ? '' : @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['keadaan_umum']['pilihan_lain'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
              @endif  
            @else
              Tidak ada keluhan <br><br>
            @endif
            2. Kesadaran <br/>
            @if (@$pemeriksaan_fisik['kesadaran']['pilihan'])
              @if (is_array(@$pemeriksaan_fisik['kesadaran']['pilihan']))
                @foreach (@$pemeriksaan_fisik['kesadaran']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['kesadaran']['pilihan'] == 'Lainnya' ? '' : @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['kesadaran']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['kesadaran']['pilihan_lain'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
              @endif  
            @else
              Tidak ada keluhan <br><br>
            @endif
            3. Tanda Vital<br/>
            - TD : {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['tekanan_darah']['sistole'] }} / {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['tekanan_darah']['diastole'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Nadi : {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['nadi']['frek_pilihan_lain'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - RR : {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['respirasi']['frek_detail'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Temp : {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['suhu'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
            - Berat Badan : (Pre HD {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['berat_badan']['preHd'] }} Kg) -  (BB Kering {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['berat_badan']['bb_kering'] }} Kg) - (BB Post HD yang lalu {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['berat_badan']['bb_post_hd_lalu'] }} Kg) - (BB Post HD {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['berat_badan']['bb_post_hd'] }} Kg) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/><br/>
            4. Konjungtiva <br/>
            @if (@$pemeriksaan_fisik['konjungtiva']['pilihan'])
              @if (is_array(@$pemeriksaan_fisik['konjungtiva']['pilihan']))
                @foreach (@$pemeriksaan_fisik['konjungtiva']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan'] == 'Lainnya' ? '' : @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['konjungtiva']['pilihan_lain'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
              @endif  
            @else
              Tidak ada keluhan <br><br>
            @endif
            5. Ekstremitas <br/>
            @if (@$pemeriksaan_fisik['ekstremitas']['pilihan'])
              @if (is_array(@$pemeriksaan_fisik['ekstremitas']['pilihan']))
                @foreach (@$pemeriksaan_fisik['ekstremitas']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['ekstremitas']['pilihan'] }} <br><br>
              @endif  
            @else
              Tidak ada keluhan <br><br>
            @endif
            6. Akses Vaskular <br/>
            @if (@$pemeriksaan_fisik['akses_vaskular']['pilihan'])
              @if (is_array(@$pemeriksaan_fisik['akses_vaskular']['pilihan']))
                @foreach (@$pemeriksaan_fisik['akses_vaskular']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['akses_vaskular']['pilihan'] }} <br><br>
              @endif  
            @else
              Tidak ada keluhan <br><br>
            @endif
            7. Risiko Jatuh Pre HD <br/>
            @if (@$pemeriksaan_fisik['risiko_jatuh_pre_hd']['pilihan'])
            - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['risiko_jatuh_pre_hd']['pilihan'] }} <br><br>
            @else
              Tidak ada keluhan <br><br>
            @endif
            8. Risiko Jatuh Post HD <br/>
            @if (@$pemeriksaan_fisik['risiko_jatuh_post_hd']['pilihan'])
            - {{ @json_decode(@$soap->fisik, true)['perawat_pemeriksaan_fisik']['risiko_jatuh_post_hd']['pilihan'] }} <br><br>
            @else
              Tidak ada keluhan <br><br>
            @endif
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>PEMERIKSAAN PENUNJANG</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
              {{ @json_decode(@$soap->fisik, true)['pemeriksaan_penunjang']['detail'] }} <br><br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>GIZI</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>Tanggal : </b>  {{ @json_decode(@$soap->fisik, true)['gizi']['tanggal'] }} <br><br>
            <b>MIS, Score Total : </b>  {{ @json_decode(@$soap->fisik, true)['gizi']['mis_score'] }} <br><br>
            <b>Kesimpulan : </b>  {{ @json_decode(@$soap->fisik, true)['gizi']['kesimpulan']['pilihan'] }} <br><br>
            <b>Rekomendasi : </b>  {{ @json_decode(@$soap->fisik, true)['gizi']['rekomendasi']}} <br><br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>RIWAYAT PSIKOSOSIAL</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            Keyakinan / tradisi / budaya yang berkaitan dengan pelayanan kesehatan<br/>
            - {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['keyakinan_tradisi']['pilihan'] == 'Ya' ? 'Ya, ' : @json_decode(@$soap->fisik, true)['riwayat_psikososial']['keyakinan_tradisi']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['keyakinan_tradisi']['pilihan_ya'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
            Kendala komunikasi <br/>
            - {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['kendala_komunikasi']['pilihan'] == 'Ya' ? 'Ya, ' : @json_decode(@$soap->fisik, true)['riwayat_psikososial']['kendala_komunikasi']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['kendala_komunikasi']['pilihan_ya'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
            Yang merawat di rumah <br/>
            - {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['perawat_dirumah']['pilihan'] == 'Ya' ? 'Ada, ' : @json_decode(@$soap->fisik, true)['riwayat_psikososial']['perawat_dirumah']['pilihan'] }} {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['perawat_dirumah']['pilihan_ya'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
            Kondisi saat ini <br/>
            @if (is_array(@json_decode(@$soap->fisik, true)['riwayat_psikososial']['kondisi_saat_ini']['pilihan']))
              @foreach (@json_decode(@$soap->fisik, true)['riwayat_psikososial']['kondisi_saat_ini']['pilihan'] as $item)
                - {{@$item}} <br>
              @endforeach
            @else
              - {{ @json_decode(@$soap->fisik, true)['riwayat_psikososial']['kondisi_saat_ini']['pilihan'] }} <br><br>
            @endif  
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>DIAGNOSA KEPERAWATAN</b>
          </td>
          <td colspan="3" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[diagnosa_keperawatan_dx][pilihan1]"
                  {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan1'] == '1. Kelebihan volume cairan' ? 'checked' : '' }}
                  type="checkbox" value="1. Kelebihan volume cairan">
              <label class="form-check-label" style="font-weight: 400;">1. Kelebihan volume cairan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan2]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan2'] == '2. Gangguan perfusi jaringan' ? 'checked' : '' }}
                    type="checkbox" value="2. Gangguan perfusi jaringan">
                <label class="form-check-label" style="font-weight: 400;">2. Gangguan perfusi jaringan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan3]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan3'] == '3. Gangguan keseimbangan cairan' ? 'checked' : '' }}
                    type="checkbox" value="3. Gangguan keseimbangan cairan">
                <label class="form-check-label" style="font-weight: 400;">3. Gangguan keseimbangan cairan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan4]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan4'] == '4. Penurunan curah jantung' ? 'checked' : '' }}
                    type="checkbox" value="4. Penurunan curah jantung">
                <label class="form-check-label" style="font-weight: 400;">4. Penurunan curah jantung</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan5]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan5'] == '5. Nutrisi kurang dari kebutuhan tubuh' ? 'checked' : '' }}
                    type="checkbox" value="5. Nutrisi kurang dari kebutuhan tubuh">
                <label class="form-check-label" style="font-weight: 400;">5. Nutrisi kurang dari kebutuhan tubuh</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan6]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan6'] == '6. Ketidakpatuhan terhadap diit' ? 'checked' : '' }}
                    type="checkbox" value="6. Ketidakpatuhan terhadap diit">
                <label class="form-check-label" style="font-weight: 400;">6. Ketidakpatuhan terhadap diit</label>
            </div>
          </td>
          <td colspan="2" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[diagnosa_keperawatan_dx][pilihan7]"
                  {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan7'] == '7. Gangguan rasa nyaman' ? 'checked' : '' }}
                  type="checkbox" value="7. Gangguan rasa nyaman">
              <label class="form-check-label" style="font-weight: 400;">7. Gangguan rasa nyaman</label> - 
              {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan7_detail'] }}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan8]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan8'] == 'Lain-lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain-lain">
                <label class="form-check-label" style="font-weight: 400;">Lain-lain</label> - 
                {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan8_detail'] }}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[diagnosa_keperawatan_dx][pilihan9]"
                    {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan9'] == 'Lain-lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain-lain">
                <label class="form-check-label" style="font-weight: 400;">Lain-lain</label> - 
            </div>
            {{ @json_decode(@$soap->fisik, true)['diagnosa_keperawatan_dx']['pilihan9_detail'] }}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>INTERVENSI KEPERAWATAN</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan1]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan1'] == 'Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat' ? 'checked' : '' }}
                  type="checkbox" value="Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat">
              <label class="form-check-label" style="font-weight: 400;">Monitor berat badan, inatake out put, Atur posisi pasien agar ventilasi adekuat</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan2]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan2'] == 'Observasi pasien (Monitor vital sign) dan mesin' ? 'checked' : '' }}
                  type="checkbox" value="Observasi pasien (Monitor vital sign) dan mesin">
              <label class="form-check-label" style="font-weight: 400;">Observasi pasien (Monitor vital sign) dan mesin</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan3]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan3'] == 'Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan' ? 'checked' : '' }}
                  type="checkbox" value="Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan">
              <label class="form-check-label" style="font-weight: 400;">Kaji kemampuan pasien mendapatkan nutrisi yang dibutuhkan</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan4]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan4'] == 'PENKES, diet, AV-Shunt' ? 'checked' : '' }}
                  type="checkbox" value="PENKES, diet, AV-Shunt">
              <label class="form-check-label" style="font-weight: 400;">PENKES, diet, AV-Shunt</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan5]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan5'] == 'Ganti balutan luka sesuai dengan prosedur' ? 'checked' : '' }}
                  type="checkbox" value="Ganti balutan luka sesuai dengan prosedur">
              <label class="form-check-label" style="font-weight: 400;">Ganti balutan luka sesuai dengan prosedur</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan6]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan6'] == 'Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)' ? 'checked' : '' }}
                  type="checkbox" value="Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)">
              <label class="form-check-label" style="font-weight: 400;">Bila pasien mulai hipotensi (mual, muntah, keringat dingin, pusing kram, hipoglikemi berikan cairan sesuai SPO)</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan7]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan7'] == 'Berikan terapi oksigen sesuai kebutuhan' ? 'checked' : '' }}
                  type="checkbox" value="Berikan terapi oksigen sesuai kebutuhan">
              <label class="form-check-label" style="font-weight: 400;">Berikan terapi oksigen sesuai kebutuhan</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan8]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan8'] == 'Hentikan HD sesuai indikasi' ? 'checked' : '' }}
                  type="checkbox" value="Hentikan HD sesuai indikasi">
              <label class="form-check-label" style="font-weight: 400;">Hentikan HD sesuai indikasi</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan9]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan9'] == 'Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki' ? 'checked' : '' }}
                  type="checkbox" value="Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki">
              <label class="form-check-label" style="font-weight: 400;">Posisikan supinasi dengan elevasi kepala 30° dan elevasi kaki</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan10]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan10'] == 'Monitor tanda dan gejala infeksi (lokal dan sistemik)' ? 'checked' : '' }}
                  type="checkbox" value="Monitor tanda dan gejala infeksi (lokal dan sistemik)">
              <label class="form-check-label" style="font-weight: 400;">Monitor tanda dan gejala infeksi (lokal dan sistemik)</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan11]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan11'] == 'Monitor tanda dan gejala hipoglikemi' ? 'checked' : '' }}
                  type="checkbox" value="Monitor tanda dan gejala hipoglikemi">
              <label class="form-check-label" style="font-weight: 400;">Monitor tanda dan gejala hipoglikemi</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_keperawatan][pilihan12]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_keperawatan']['pilihan12'] == 'Lakukan teknik, distraksi, relaksasi' ? 'checked' : '' }}
                  type="checkbox" value="Lakukan teknik, distraksi, relaksasi">
              <label class="form-check-label" style="font-weight: 400;">Lakukan teknik, distraksi, relaksasi</label>
            </div>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>INTERVENSI KOLABORASI</b>
          </td>
          <td colspan="3" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan1]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan1'] == 'Program HD' ? 'checked' : '' }}
                  type="checkbox" value="Program HD">
              <label class="form-check-label" style="font-weight: 400;">Program HD</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan2]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan2'] == 'Pemberian Erytropetin' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian Erytropetin">
              <label class="form-check-label" style="font-weight: 400;">Pemberian Erytropetin</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan3]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan3'] == 'Pemberian Analgetik' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian Analgetik">
              <label class="form-check-label" style="font-weight: 400;">Pemberian Analgetik</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan4]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan4'] == 'Transfusi darah' ? 'checked' : '' }}
                  type="checkbox" value="Transfusi darah">
              <label class="form-check-label" style="font-weight: 400;">Transfusi darah</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan5]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan5'] == 'Pemberian preparat besi' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian preparat besi">
              <label class="form-check-label" style="font-weight: 400;">Pemberian preparat besi</label>
            </div>
          </td>
          <td colspan="2" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan6]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan6'] == 'Pemberian Ca Gluconas' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian Ca Gluconas">
              <label class="form-check-label" style="font-weight: 400;">Pemberian Ca Gluconas</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan7]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan7'] == 'Obat obat emergensi' ? 'checked' : '' }}
                  type="checkbox" value="Obat obat emergensi">
              <label class="form-check-label" style="font-weight: 400;">Obat obat emergensi</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan8]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan8'] == 'Pemberian Antipiretik' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian Antipiretik">
              <label class="form-check-label" style="font-weight: 400;">Pemberian Antipiretik</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan9]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan9'] == 'Pemberian Antibiotik' ? 'checked' : '' }}
                  type="checkbox" value="Pemberian Antibiotik">
              <label class="form-check-label" style="font-weight: 400;">Pemberian Antibiotik</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[intervensi_kolaborasi][pilihan10]"
                  {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan10'] == 'Lain-lain' ? 'checked' : '' }}
                  type="checkbox" value="Lain-lain">
              <label class="form-check-label" style="font-weight: 400;">Lain-lain</label> - 
              {{ @json_decode(@$soap->fisik, true)['intervensi_kolaborasi']['pilihan10_detail'] }}
            </div>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>INSTRUKSI MEDIK</b>
          </td>
          <td colspan="2" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan1]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan1'] == 'Inisiasi' ? 'checked' : '' }}
                  type="checkbox" value="Inisiasi">
              <label class="form-check-label" style="font-weight: 400;">Inisiasi</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan2]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan2'] == 'Akut' ? 'checked' : '' }}
                  type="checkbox" value="Akut">
              <label class="form-check-label" style="font-weight: 400;">Akut</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan3]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan3'] == 'Rutin' ? 'checked' : '' }}
                  type="checkbox" value="Rutin">
              <label class="form-check-label" style="font-weight: 400;">Rutin</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan4]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan4'] == 'SLED' ? 'checked' : '' }}
                  type="checkbox" value="SLED">
              <label class="form-check-label" style="font-weight: 400;">SLED</label> - 
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan4_detail'] }}
            </div>
          </td>
          <td colspan="1" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan5]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan5'] == 'TD' ? 'checked' : '' }}
                  type="checkbox" value="TD">
              <label class="form-check-label" style="font-weight: 400;">TD (Jam)</label> - 
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan5_detail'] }} Jam
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan6]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan6'] == 'QB' ? 'checked' : '' }}
                  type="checkbox" value="QB">
              <label class="form-check-label" style="font-weight: 400;">QB (ml/mnt)</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan6_detail'] }} ml/mnt
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan7]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan7'] == 'QD' ? 'checked' : '' }}
                  type="checkbox" value="QD">
              <label class="form-check-label" style="font-weight: 400;">QD (ml/mnt)</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan7_detail'] }} ml/mnt
            </div>
          </td>
          <td colspan="2" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan8]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan8'] == 'UF Goal' ? 'checked' : '' }}
                  type="checkbox" value="UF Goal">
              <label class="form-check-label" style="font-weight: 400;">UF Goal (ml)</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan8_detail'] }} ml
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan9]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan9'] == 'Prog. Prolling: Na' ? 'checked' : '' }}
                  type="checkbox" value="Prog. Prolling: Na">
              <label class="form-check-label" style="font-weight: 400;">Prog. Prolling: Na (Na)</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan9_detail'] }} Na
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan10]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan10'] == 'UF' ? 'checked' : '' }}
                  type="checkbox" value="UF">
              <label class="form-check-label" style="font-weight: 400;">UF</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan10_detail'] }}
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[instruksi_medik][pilihan11]"
                  {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan11'] == 'Bicarbonat' ? 'checked' : '' }}
                  type="checkbox" value="Bicarbonat">
              <label class="form-check-label" style="font-weight: 400;">Bicarbonat</label> -
              {{ @json_decode(@$soap->fisik, true)['instruksi_medik']['pilihan11_detail'] }}
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="5" style="border: 1px solid;">
            <b>Diallsat</b> <br>
            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['diallsat']['pilihan1'])
              - Bicarbonat <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['diallsat']['pilihan2'])
              - Condactivity ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['diallsat']['pilihan2_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['diallsat']['pilihan3'])
              - Temperatur ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['diallsat']['pilihan3_detail']}}) <br>
            @endif

            <br>
            <b>Heparinisasi</b> <br>
            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan1'])
              - Dosis sirkulasi ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan1_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan2'])
              - Dosis Maintenance ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan2_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan3'])
              - Intermitten ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan3_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan4'])
              - LMWH ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan4_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan5'])
              - Tanpa Heparin, Penyebab ({{@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan5_detail']}}) <br>
            @endif

            @if (@json_decode(@$soap->fisik, true)['instruksi_medik']['heparinisasi']['pilihan6'])
              - Program bilas NaCI 0.9 % 100 cc / jam / setengah jam  <br>
            @endif
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>PENYULIT SELAMA HD</b>
          </td>
          <td colspan="3" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[penyulit_selama_hd][pilihan1]"
                  {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan1'] == 'Masalah Akses' ? 'checked' : '' }}
                  type="checkbox" value="Masalah Akses">
              <label class="form-check-label" style="font-weight: 400;">Masalah Akses</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan2]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan2'] == 'Nyeri dada' ? 'checked' : '' }}
                    type="checkbox" value="Nyeri dada">
                <label class="form-check-label" style="font-weight: 400;">Nyeri dada</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan3]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan3'] == 'Perdarahan' ? 'checked' : '' }}
                    type="checkbox" value="Perdarahan">
                <label class="form-check-label" style="font-weight: 400;">Perdarahan</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[penyulit_selama_hd][pilihan4]"
                  {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan4'] == 'Aritmia' ? 'checked' : '' }}
                  type="checkbox" value="Aritmia">
              <label class="form-check-label" style="font-weight: 400;">Aritmia</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan5]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan5'] == 'First Use Syndrome' ? 'checked' : '' }}
                    type="checkbox" value="First Use Syndrome">
                <label class="form-check-label" style="font-weight: 400;">First Use Syndrome</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan6]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan6'] == 'Gatal-gatal' ? 'checked' : '' }}
                    type="checkbox" value="Gatal-gatal">
                <label class="form-check-label" style="font-weight: 400;">Gatal-gatal</label>
            </div>
          </td>
          <td colspan="2" style="border: 1px solid;">
            <div>
              <input class="form-check-input"
                  name="fisik[penyulit_selama_hd][pilihan7]"
                  {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan7'] == 'Sakit Kepala' ? 'checked' : '' }}
                  type="checkbox" value="Sakit Kepala">
              <label class="form-check-label" style="font-weight: 400;">Sakit Kepala</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan8]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan8'] == 'Demam' ? 'checked' : '' }}
                    type="checkbox" value="Demam">
                <label class="form-check-label" style="font-weight: 400;">Demam</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan9]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan9'] == 'Mual dan Muntah' ? 'checked' : '' }}
                    type="checkbox" value="Mual dan Muntah">
                <label class="form-check-label" style="font-weight: 400;">Mual dan Muntah</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[penyulit_selama_hd][pilihan10]"
                  {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan10'] == 'Menggigil / dingin' ? 'checked' : '' }}
                  type="checkbox" value="Menggigil / dingin">
              <label class="form-check-label" style="font-weight: 400;">Menggigil / dingin</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan11]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan11'] == 'Kram Otot' ? 'checked' : '' }}
                    type="checkbox" value="Kram Otot">
                <label class="form-check-label" style="font-weight: 400;">Kram Otot</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan12]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan12'] == 'Hiperkalemia' ? 'checked' : '' }}
                    type="checkbox" value="Hiperkalemia">
                <label class="form-check-label" style="font-weight: 400;">Hiperkalemia</label>
            </div>
            <div>
              <input class="form-check-input"
                  name="fisik[penyulit_selama_hd][pilihan10]"
                  {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan10'] == 'Hipotensi' ? 'checked' : '' }}
                  type="checkbox" value="Hipotensi">
              <label class="form-check-label" style="font-weight: 400;">Hipotensi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan11]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan11'] == 'Hipertensi' ? 'checked' : '' }}
                    type="checkbox" value="Hipertensi">
                <label class="form-check-label" style="font-weight: 400;">Hipertensi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[penyulit_selama_hd][pilihan12]"
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan12'] == 'Lain-lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain-lain">
                    {{ @json_decode(@$soap->fisik, true)['penyulit_selama_hd']['pilihan12_detail'] }}
            </div>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>EVALUASI PERAWATAN</b>
          </td>
          <td colspan="5" style="border: 1px solid; white-space: pre-line;">
              {{ @json_decode(@$soap->fisik, true)['evaluasi_perawatan']['detail'] }} <br><br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>DISCHARGE PLANNING</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>Rencana Lama Rawat Inap : </b> <br>
            - Dapat ditetapkan : 
            {{ @json_decode(@$soap->fisik, true)['rencanaRanap']['dapatDitetapkan']['hari'] ?? '-' }} Hari, Tanggal pulang : {{ @json_decode(@$soap->fisik, true)['rencanaRanap']['dapatDitetapkan']['tanggal'] ?? '-' }}<br><br>
            - Tidak dapat ditetapkan, karena {{ @json_decode(@$soap->fisik, true)['rencanaRanap']['tidakDapatDitetapkan']['alasan'] ?? '-' }} <br><br>
            <b>Ketika pulang masih memerlukan perawatan lanjutan : </b> <br>
            - {{ @json_decode(@$soap->fisik, true)['rencanaRanap']['perawatan_lanjutan'] == 'Ya' ? '' : @json_decode(@$soap->fisik, true)['rencanaRanap']['perawatan_lanjutan'] }} {{ @json_decode(@$soap->fisik, true)['rencanaRanap']['perawatan_lanjutan_ya'] ?? '' }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br><br>
          </td>
        </tr>

    </table>

    <div style="page-break-after: always;"></div>

    <h5 class="text-center" style="text-align: center; font-size: 18px;"><b>Tindakan Keperawatan</b></h5>
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;" border="1" cellspacing="0" cellpadding="3">
        <thead style="border: 1px solid black;">
          <tr style="border: 1px solid black;">
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Observasi</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Jam</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Qb</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Uf Rate</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Tek Drh</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Nadi</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Suhu</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Resp</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">
              Intake <br>
                1. NaCI 0.9 % <br>
                2. Dextrose 40% <br>
                3. Makan / minum <br>
                4. Lain-lain <br>
                <b>(Ditulis no)</b>
            </th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Out-put</th>
            <th style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Keterangan Lain</th>
          </tr>
        </thead>
        <tbody>
          @for ($i = 1; $i<=5; $i++)  
          <tr>
            <td style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Intra HD</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['jam'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['qb'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['uf_rate'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['tek_drh'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['nadi'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['suhu'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['resp'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['intake'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['output'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['intra_hd'][$i]['keterangan_lain'] }}
            </td>
          </tr>
          @endfor
          <tr>
            <td style="vertical-align: middle; font-size: 12px; font-weight: bold; border: 1px solid black;">Post HD</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['jam'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['qb'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['uf_rate'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['tek_drh'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['nadi'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['suhu'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['resp'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['intake'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['output'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['post_hd']['keterangan_lain'] }}
            </td>
          </tr>
          <tr>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">Jml : 
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['jumlah'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">Balance : 
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['balance'] }}
            </td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
          </tr>
          <tr>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;" colspan="3">Total UF (ml):
              {{ @json_decode(@$soap->fisik, true)['tindakan_keperawatan']['total_uf'] }}
            <td style="vertical-align: middle; font-size: 12px; border: 1px solid black;">&nbsp;</td>
          </tr>
        </tbody>
      </table>
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Perawat
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (isset($proses_tte))
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
          {{ baca_user(@$soap->user_id) }}
        </td>
      </tr>
    </table>
    
  </body>
</html>
 