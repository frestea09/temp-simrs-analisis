<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Edukasi Pasien Keluarga_{{ @$reg->pasien->no_rm }}</title>
    <style>
        table{
          width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 15px;
        }

        table.no-border,
        table.no-border th,
        table.no-border td {
            border: none !important;
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
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 18pt;">
            <b>FORMULIR EDUKASI PASIEN KELUARGA</b>
          </th>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
              <b>Poli / Ruangan</b><br>
              {{ @$reg->rawat_inap ? @$reg->rawat_inap->kamar->nama : @$reg->poli->nama }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
    </table>
    <br>
    <table>
      <tr>
        <td colspan="2">
          <b>A. Asesmen Kebutuhan Edukasi</b>
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Agama</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['agama']['pilihan'] }} {{ @$asessment['kebutuhan_edukasi']['agama']['pilihan_lain'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">
          Keyakinan dan nilai-nilai budaya yang dianut pasien dan keluarga berhubungan dengan kesehatan 
          (contoh: tidak bersedia transfusi, tidak makan daging, tidak mau menggunakan obat-obatan yang mengandung babi, dll)</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['agama']['keyakinan_nilai'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Kemampuan Membaca</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['kemampuan_membaca']['pilihan'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Tingkat Pendidikan</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['tingkat_pendidikan']['pilihan'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Bahasa yang digunakan sehari-hari</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Terdapat hambatan dalam penerimaan edukasi</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan'] }}
          @if(@$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan'] == 'Ya')
            <br>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][pendengaran]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['pendengaran'] == 'Pendengaran' ? 'checked' : '' }}
                    type="checkbox" value="Pendengaran">
                <label class="form-check-label" style="font-weight: 400;">Pendengaran</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][penglihatan]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['penglihatan'] == 'Penglihatan' ? 'checked' : '' }}
                    type="checkbox" value="Penglihatan">
                <label class="form-check-label" style="font-weight: 400;">Penglihatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][kognitif]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['kognitif'] == 'Kognitif' ? 'checked' : '' }}
                    type="checkbox" value="Kognitif">
                <label class="form-check-label" style="font-weight: 400;">Kognitif</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][fisik]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['fisik'] == 'Fisik' ? 'checked' : '' }}
                    type="checkbox" value="Fisik">
                <label class="form-check-label" style="font-weight: 400;">Fisik</label>
            </div>

            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][emosi]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['emosi'] == 'Emosi' ? 'checked' : '' }}
                    type="checkbox" value="Emosi">
                <label class="form-check-label" style="font-weight: 400;">Emosi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][budaya]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['budaya'] == 'Budaya' ? 'checked' : '' }}
                    type="checkbox" value="Budaya">
                <label class="form-check-label" style="font-weight: 400;">Budaya</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][agama]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['agama'] == 'Agama' ? 'checked' : '' }}
                    type="checkbox" value="Agama">
                <label class="form-check-label" style="font-weight: 400;">Agama</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][motivasi]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['motivasi'] == 'Motivasi' ? 'checked' : '' }}
                    type="checkbox" value="Motivasi">
                <label class="form-check-label" style="font-weight: 400;">Motivasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][bahasa]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['bahasa'] == 'Bahasa' ? 'checked' : '' }}
                    type="checkbox" value="Bahasa">
                <label class="form-check-label" style="font-weight: 400;">Bahasa</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][nilai]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['nilai'] == 'Nilai / Kepercayaan' ? 'checked' : '' }}
                    type="checkbox" value="Nilai / Kepercayaan">
                <label class="form-check-label" style="font-weight: 400;">Nilai / Kepercayaan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][lain]"
                    {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['lain'] == 'Lainnya' ? 'checked' : '' }}
                    type="checkbox" value="Lainnya">
                {{ @$asessment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['lain_detail'] ?? 'Lainnya' }}
            </div>
          @endif
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Kesediaan pasien menerima informasi</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['ketersediaan_pasien_menerima_informasi']['pilihan'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Butuh penerjemah bahasa</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['butuh_penerjemah_bahasa']['pilihan'] }}
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Pasien membutuhkan edukasi kolaboratif</td>
        <td>
          {{ @$asessment['kebutuhan_edukasi']['butuh_edukasi_kolaboratif']['pilihan'] }}
        </td>
      </tr>
    </table>

    <br>

    <table>
      <thead style="display: table-row-group;">
        <tr>
          <th style="text-align: left;" colspan="5">
            <b>B. Perencanaan Edukasi</b>
          </th>
        </tr>
        <tr>
          <th>Tgl dan Waktu</th>
          <th>Profesi</th>
          <th>Materi</th>
          <th>Metode</th>
          <th>Media</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['tanggal_waktu'] ?? '-' }}
          </td>
          <td>
            Dokter Spesialis / DPJP
          </td>
          <td>
            <div>
              <input class=""
                  name="fisik[perencanaan_edukasi][dokter_dpjp][materi][kondisi_kesehatan]"
                  {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['materi']['kondisi_kesehatan'] == 'Kondisi Kesehatan dan diagnosis' ? 'checked' : '' }}
                  type="checkbox" value="Kondisi Kesehatan dan diagnosis">
              <label class="form-check-label" style="font-weight: 400;">Kondisi Kesehatan dan diagnosis</label>
            </div>
            <div>
                <input class=""
                    name="fisik[perencanaan_edukasi][dokter_dpjp][materi][teknik_rehabilitasi]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['materi']['teknik_rehabilitasi'] == 'Teknik teknik rehabilitasi' ? 'checked' : '' }}
                    type="checkbox" value="Teknik teknik rehabilitasi">
                <label class="form-check-label" style="font-weight: 400;">Teknik teknik rehabilitasi</label>
            </div>
            <div>
                <input class=""
                    name="fisik[perencanaan_edukasi][dokter_dpjp][materi][lain]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                    {{@$asessment['perencanaan_edukasi']['dokter_dpjp']['materi']['lain_detail'] ?? 'Lainnya'}}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][dokter_dpjp][metode][diskusi]"
                  {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                  type="checkbox" value="Diskusi">
              <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][metode][ceramah]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                    type="checkbox" value="Ceramah">
                <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][metode][demonstrasi]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][metode][simulasi]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                    type="checkbox" value="Simulasi">
                <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][metode][lain]"
                    {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                  {{@$asessment['perencanaan_edukasi']['dokter_dpjp']['metode']['lain_detail'] ?? 'Lainnya'}}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][dokter_dpjp][media][leaflet]"
                  {{ @$asessment['perencanaan_edukasi']['dokter_dpjp']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                  type="checkbox" value="Leaflet">
              <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][media][audio_visual]"
                    {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                    type="checkbox" value="Audio Visual">
                <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][media][lembar_balik]"
                    {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                    type="checkbox" value="Lembar balik">
                <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][media][alat_peraga]"
                    {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                    type="checkbox" value="Alat peraga">
                <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][dokter_dpjp][media][lain]"
                    {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                  {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['perencanaan_edukasi']['perawat']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['perencanaan_edukasi']['perawat']['tanggal_waktu'])) : '-'}}
          </td>
          <td>
            Perawat / Bidan
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][perawat][materi][manajemen_nyeri]"
                  {{ @$asessment['perencanaan_edukasi']['perawat']['materi']['manajemen_nyeri'] == 'Manajemen Nyeri' ? 'checked' : '' }}
                  type="checkbox" value="Manajemen Nyeri">
              <label class="form-check-label" style="font-weight: 400;">Manajemen Nyeri</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][materi][penggunaan_peralatan]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['materi']['penggunaan_peralatan'] == 'Penggunaan peralatan medis secara efektif dan aman' ? 'checked' : '' }}
                    type="checkbox" value="Penggunaan peralatan medis secara efektif dan aman">
                <label class="form-check-label" style="font-weight: 400;">Penggunaan peralatan medis secara efektif dan aman</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][materi][lain]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['perawat']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][perawat][metode][diskusi]"
                  {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                  type="checkbox" value="Diskusi">
              <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][metode][ceramah]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                    type="checkbox" value="Ceramah">
                <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][metode][demonstrasi]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][metode][simulasi]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                    type="checkbox" value="Simulasi">
                <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][metode][lain]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['perawat']['metode']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][perawat][media][leaflet]"
                  {{ @$asessment['perencanaan_edukasi']['perawat']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                  type="checkbox" value="Leaflet">
              <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][media][audio_visual]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                    type="checkbox" value="Audio Visual">
                <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][media][lembar_balik]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                    type="checkbox" value="Lembar balik">
                <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][media][alat_peraga]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                    type="checkbox" value="Alat peraga">
                <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][perawat][media][lain]"
                    {{ @$asessment['perencanaan_edukasi']['perawat']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['perencanaan_edukasi']['perawat']['media']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['perencanaan_edukasi']['farmasi']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['perencanaan_edukasi']['farmasi']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            Farmasi
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][farmasi][materi][penggunaan_obat]"
                  {{ @$asessment['perencanaan_edukasi']['farmasi']['materi']['penggunaan_obat'] == 'Penggunaan obat-obatan secara efektif dan aman' ? 'checked' : '' }}
                  type="checkbox" value="Penggunaan obat-obatan secara efektif dan aman">
              <label class="form-check-label" style="font-weight: 400;">Penggunaan obat-obatan secara efektif dan aman</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][materi][efek_samping_obat]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['materi']['efek_samping_obat'] == 'Efek samping obat' ? 'checked' : '' }}
                    type="checkbox" value="Efek samping obat">
                <label class="form-check-label" style="font-weight: 400;">Efek samping obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][materi][potensi_interaksi]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['materi']['potensi_interaksi'] == 'Potensi interaksi obat yang diresepkan dengan obat lain serta makanan' ? 'checked' : '' }}
                    type="checkbox" value="Potensi interaksi obat yang diresepkan dengan obat lain serta makanan">
                <label class="form-check-label" style="font-weight: 400;">Potensi interaksi obat yang diresepkan dengan obat lain serta makanan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][materi][lain]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['farmasi']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][farmasi][metode][diskusi]"
                  {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                  type="checkbox" value="Diskusi">
              <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][metode][ceramah]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                    type="checkbox" value="Ceramah">
                <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][metode][demonstrasi]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][metode][simulasi]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                    type="checkbox" value="Simulasi">
                <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][metode][lain]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['farmasi']['metode']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][farmasi][media][leaflet]"
                  {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                  type="checkbox" value="Leaflet">
              <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][media][audio_visual]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                    type="checkbox" value="Audio Visual">
                <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][media][lembar_balik]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                    type="checkbox" value="Lembar balik">
                <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][media][alat_peraga]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                    type="checkbox" value="Alat peraga">
                <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][farmasi][media][lain]"
                    {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['farmasi']['media']['lain_detail'] ?? 'Lainnya'}}
            </div>
          </td>
        </tr>
        <tr>
          <td style="" class="text-center">
              {{ @$asessment['perencanaan_edukasi']['nutrisionis']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['perencanaan_edukasi']['nutrisionis']['tanggal_waktu'])) : '-'}}
          </td>
          <td style="" class="text-center">
              Nutrisionis
          </td>
          <td style="">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][materi][diet_dan_nutrisi]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['materi']['diet_dan_nutrisi'] == 'Diet dan nutrisi yang benar' ? 'checked' : '' }}
                          type="checkbox" value="Diet dan nutrisi yang benar">
                      <label class="form-check-label" style="font-weight: 400;">Diet dan nutrisi yang benar</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][materi][lain1]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain">
                      {{ @$asessment['perencanaan_edukasi']['nutrisionis']['materi']['lain_detail1'] ?? 'Lainnya'}}
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][materi][lain2]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain">
                      {{ @$asessment['perencanaan_edukasi']['nutrisionis']['materi']['lain_detail2'] ?? 'Lainnya' }}
                  </div>
          </td>
          <td style="">
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][metode][diskusi]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                          type="checkbox" value="Diskusi">
                      <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][metode][ceramah]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                          type="checkbox" value="Ceramah">
                      <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][metode][demonstrasi]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                          type="checkbox" value="Demonstrasi">
                      <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][metode][simulasi]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                          type="checkbox" value="Simulasi">
                      <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                  </div>
                  <div>
                      <input class="form-check-input"
                          name="fisik[perencanaan_edukasi][nutrisionis][metode][lain]"
                          {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                          type="checkbox" value="Lain">
                      {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['lain_detail'] ?? 'Lainnya' }}
                  </div>
          </td>
          <td style="">
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][nutrisionis][media][leaflet]"
                  {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                  type="checkbox" value="Leaflet">
              <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][nutrisionis][media][audio_visual]"
                    {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                    type="checkbox" value="Audio Visual">
                <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][nutrisionis][media][lembar_balik]"
                    {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                    type="checkbox" value="Lembar balik">
                <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][nutrisionis][media][alat_peraga]"
                    {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                    type="checkbox" value="Alat peraga">
                <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][nutrisionis][media][lain]"
                    {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['nutrisionis']['media']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['perencanaan_edukasi']['lain_lain']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['perencanaan_edukasi']['lain_lain']['tanggal_waktu'])) : '-' }}
          </td>
          <td></td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][lain_lain][materi][lain1]"
                  {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                  type="checkbox" value="Lain">
              {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail1'] ?? 'Lainnya 1'}}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][materi][lain2]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                 {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail2'] ?? 'Lainnya 2' }}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][materi][lain3]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain3'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail3'] ?? 'Lainnya 3' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][lain_lain][metode][diskusi]"
                  {{ @$asessment['perencanaan_edukasi']['lain_lain']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                  type="checkbox" value="Diskusi">
              <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][metode][ceramah]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                    type="checkbox" value="Ceramah">
                <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][metode][demonstrasi]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][metode][simulasi]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                    type="checkbox" value="Simulasi">
                <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][metode][lain]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                 {{ @$asessment['perencanaan_edukasi']['nutrisionis']['metode']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[perencanaan_edukasi][lain_lain][media][leaflet]"
                  {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                  type="checkbox" value="Leaflet">
              <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][media][audio_visual]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                    type="checkbox" value="Audio Visual">
                <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][media][lembar_balik]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                    type="checkbox" value="Lembar balik">
                <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][media][alat_peraga]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                    type="checkbox" value="Alat peraga">
                <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[perencanaan_edukasi][lain_lain][media][lain]"
                    {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['perencanaan_edukasi']['lain_lain']['media']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <br>

    <table>
      <thead>
        <tr>
          <th style="text-align: left;" colspan="7">
            <b>C. Pelaksanaan Edukasi</b>
          </th>
        </tr>
        <tr>
          <th>Tgl dan Waktu</th>
          <th>Materi Edukasi</th>
          <th>Durasi (Menit)</th>
          <th>Verifikasi</th>
          <th>Tgl Rencana Re-edukasi / Redemonstrasi</th>
          <th>Pemberi Edukasi</th>
          <th>Pasien / Keluarga</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['dokter_dpjp']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Dokter Spesialis / DPJP</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kondisi_kesehatan]"
                  {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kondisi_kesehatan'] == 'Kondisi Kesehatan dan diagnosis pasti' ? 'checked' : '' }}
                  type="checkbox" value="Kondisi Kesehatan dan diagnosis pasti">
              <label class="form-check-label" style="font-weight: 400;">Kondisi Kesehatan dan diagnosis pasti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][hasil_pemeriksaan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['hasil_pemeriksaan'] == 'Hasil pemeriksaan diagnostik' ? 'checked' : '' }}
                    type="checkbox" value="Hasil pemeriksaan diagnostik">
                <label class="form-check-label" style="font-weight: 400;">Hasil pemeriksaan diagnostik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][tindakan_medis]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['tindakan_medis'] == 'Tindakan Medis' ? 'checked' : '' }}
                    type="checkbox" value="Tindakan Medis">
                <label class="form-check-label" style="font-weight: 400;">Tindakan Medis</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][perkiraan_hari_perawatan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['perkiraan_hari_perawatan'] == 'Perkiraan hari perawatan' ? 'checked' : '' }}
                    type="checkbox" value="Perkiraan hari perawatan">
                <label class="form-check-label" style="font-weight: 400;">Perkiraan hari perawatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][penjelasan_komplikasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['penjelasan_komplikasi'] == 'Penjelasan komplikasi' ? 'checked' : '' }}
                    type="checkbox" value="Penjelasan komplikasi">
                <label class="form-check-label" style="font-weight: 400;">Penjelasan komplikasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_timbulnya_masalah]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_timbulnya_masalah'] == 'Kemungkinan timbulnya masalah selama masa pemulihan' ? 'checked' : '' }}
                    type="checkbox" value="Kemungkinan timbulnya masalah selama masa pemulihan">
                <label class="form-check-label" style="font-weight: 400;">Kemungkinan timbulnya masalah selama masa pemulihan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_alternatif_pengobatan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_alternatif_pengobatan'] == 'Kemungkinan alternatif pengobatan' ? 'checked' : '' }}
                    type="checkbox" value="Kemungkinan alternatif pengobatan">
                <label class="form-check-label" style="font-weight: 400;">Kemungkinan alternatif pengobatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_keberhasilan_pengobatan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_keberhasilan_pengobatan'] == 'Kemungkinan keberhasilan pengobatan' ? 'checked' : '' }}
                    type="checkbox" value="Kemungkinan keberhasilan pengobatan">
                <label class="form-check-label" style="font-weight: 400;">Kemungkinan keberhasilan pengobatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_yang_terjadi_apabila_tidak_diobati]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_yang_terjadi_apabila_tidak_diobati'] == 'Kemungkinan yang terjadi apabila tidak diobati' ? 'checked' : '' }}
                    type="checkbox" value="Kemungkinan yang terjadi apabila tidak diobati">
                <label class="form-check-label" style="font-weight: 400;">Kemungkinan yang terjadi apabila tidak diobati</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['durasi'] ?? '-' }}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['dokter_dpjp']['tgl_rencana'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['dokter_dpjp']['pemberi_edukasi'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['dokter_dpjp']['pasien_keluarga'] ?? '-'}}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['perawat']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['perawat']['tanggal_waktu'])) : '-'}}
          </td>
          <td>
            <b>Keperawatan / Kebidanan</b>
            <br>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][hand_hygiene]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['hand_hygiene'] == 'Hand Hygiene' ? 'checked' : '' }}
                    type="checkbox" value="Hand Hygiene">
                <label class="form-check-label" style="font-weight: 400;">Hand Hygiene</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][mobilisasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['mobilisasi'] == 'Mobilisasi / ROM' ? 'checked' : '' }}
                    type="checkbox" value="Mobilisasi / ROM">
                <label class="form-check-label" style="font-weight: 400;">Mobilisasi / ROM</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][batuk_efektif]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['batuk_efektif'] == 'Batuk Efektif' ? 'checked' : '' }}
                    type="checkbox" value="Batuk Efektif">
                <label class="form-check-label" style="font-weight: 400;">Batuk Efektif</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_luka]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_luka'] == 'Perawatan luka' ? 'checked' : '' }}
                    type="checkbox" value="Perawatan luka">
                <label class="form-check-label" style="font-weight: 400;">Perawatan luka</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_pasca_bedah]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_pasca_bedah'] == 'Perawatan pasca bedah' ? 'checked' : '' }}
                    type="checkbox" value="Perawatan pasca bedah">
                <label class="form-check-label" style="font-weight: 400;">Perawatan pasca bedah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][penanganan_cara_perawatan]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['penanganan_cara_perawatan'] == 'Penanganan dan cara Perawatan di rumah' ? 'checked' : '' }}
                    type="checkbox" value="Penanganan dan cara Perawatan di rumah">
                <label class="form-check-label" style="font-weight: 400;">Penanganan dan cara Perawatan di rumah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][asi_eksklusif]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['asi_eksklusif'] == 'ASI Eksklusif / cara menyusui' ? 'checked' : '' }}
                    type="checkbox" value="ASI Eksklusif / cara menyusui">
                <label class="form-check-label" style="font-weight: 400;">ASI Eksklusif / cara menyusui</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_bayi]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_bayi'] == 'Perawatan bayi baru lahir' ? 'checked' : '' }}
                    type="checkbox" value="Perawatan bayi baru lahir">
                <label class="form-check-label" style="font-weight: 400;">Perawatan bayi baru lahir</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_tali_pusat]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_tali_pusat'] == 'Perawatan tali pusat' ? 'checked' : '' }}
                    type="checkbox" value="Perawatan tali pusat">
                <label class="form-check-label" style="font-weight: 400;">Perawatan tali pusat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_payudara]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_payudara'] == 'Perawatan payudara' ? 'checked' : '' }}
                    type="checkbox" value="Perawatan payudara">
                <label class="form-check-label" style="font-weight: 400;">Perawatan payudara</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][pemenuhan_kebutuhan_cairan]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['pemenuhan_kebutuhan_cairan'] == 'Pemenuhan kebutuhan cairan' ? 'checked' : '' }}
                    type="checkbox" value="Pemenuhan kebutuhan cairan">
                <label class="form-check-label" style="font-weight: 400;">Pemenuhan kebutuhan cairan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][personal_hygiene]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['personal_hygiene'] == 'Personal hygiene' ? 'checked' : '' }}
                    type="checkbox" value="Personal hygiene">
                <label class="form-check-label" style="font-weight: 400;">Personal hygiene</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['pelaksanaan_edukasi']['perawat']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['perawat']['durasi'] ?? '-' }}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][perawat][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['perawat']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][perawat][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['perawat']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['perawat']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['perawat']['tgl_rencana'])) : '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['perawat']['pemberi_edukasi'] ?? '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['perawat']['pasien_keluarga'] ?? '-' }}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['farmasi']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['farmasi']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Farmasi</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][farmasi][materi][penggunaan_obat]"
                  {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['penggunaan_obat'] == 'Penggunaan obat-obatan secara efektif dan aman' ? 'checked' : '' }}
                  type="checkbox" value="Penggunaan obat-obatan secara efektif dan aman">
              <label class="form-check-label" style="font-weight: 400;">Penggunaan obat-obatan secara efektif dan aman</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][potensi_interaksi_obat]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['potensi_interaksi_obat'] == 'Potensi interaksi obat' ? 'checked' : '' }}
                    type="checkbox" value="Potensi interaksi obat">
                <label class="form-check-label" style="font-weight: 400;">Potensi interaksi obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][nama_obat]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['nama_obat'] == 'Nama obat dan kegunaannya' ? 'checked' : '' }}
                    type="checkbox" value="Nama obat dan kegunaannya">
                <label class="form-check-label" style="font-weight: 400;">Nama obat dan kegunaannya</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][kontra_indikasi_obat]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['kontra_indikasi_obat'] == 'Kontra indikasi obat' ? 'checked' : '' }}
                    type="checkbox" value="Kontra indikasi obat">
                <label class="form-check-label" style="font-weight: 400;">Kontra indikasi obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][aturan_pemakaian]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['aturan_pemakaian'] == 'Aturan pemakaian dan dosis obat' ? 'checked' : '' }}
                    type="checkbox" value="Aturan pemakaian dan dosis obat">
                <label class="form-check-label" style="font-weight: 400;">Aturan pemakaian dan dosis obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][jumlah_obat]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['jumlah_obat'] == 'Jumlah obat yang diberikan' ? 'checked' : '' }}
                    type="checkbox" value="Jumlah obat yang diberikan">
                <label class="form-check-label" style="font-weight: 400;">Jumlah obat yang diberikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][cara_penyimpanan]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['cara_penyimpanan'] == 'Cara penyimpanan obat' ? 'checked' : '' }}
                    type="checkbox" value="Cara penyimpanan obat">
                <label class="form-check-label" style="font-weight: 400;">Cara penyimpanan obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][efek_samping_obat]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['efek_samping_obat'] == 'Efek samping obat' ? 'checked' : '' }}
                    type="checkbox" value="Efek samping obat">
                <label class="form-check-label" style="font-weight: 400;">Efek samping obat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['pelaksanaan_edukasi']['farmasi']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            {{ @$asesment['pelaksanaan_edukasi']['farmasi']['durasi'] ?? '-' }}
          </td>
          <td>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][sudah_mengerti]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mengerti">
                <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['farmasi']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['farmasi']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['farmasi']['tgl_rencana'])) : '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['farmasi']['pemberi_edukasi'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['farmasi']['pasien_keluarga'] ?? '-'}}
          </td>
        </tr>
        <tr>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tanggal_waktu'])) : '-'}}
          </td>
          <td>
            <b>Diet dan Nutrisi</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][status_gizi]"
                  {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['status_gizi'] == 'Status gizi dan menjelaskan makanan RS' ? 'checked' : '' }}
                  type="checkbox" value="Status gizi dan menjelaskan makanan RS">
              <label class="form-check-label" style="font-weight: 400;">Status gizi dan menjelaskan makanan RS</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][diet_selama_perawatan]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['diet_selama_perawatan'] == 'Diet selama perawatan' ? 'checked' : '' }}
                    type="checkbox" value="Diet selama perawatan">
                <label class="form-check-label" style="font-weight: 400;">Diet selama perawatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][diet_untuk_dirumah]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['diet_untuk_dirumah'] == 'Diet untuk dirumah' ? 'checked' : '' }}
                    type="checkbox" value="Diet untuk dirumah">
                <label class="form-check-label" style="font-weight: 400;">Diet untuk dirumah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][pembatasan_diet_jika_pasien]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['pembatasan_diet_jika_pasien'] == 'Pembatasan diet jika pasien membawa makanan dari rumah' ? 'checked' : '' }}
                    type="checkbox" value="Pembatasan diet jika pasien membawa makanan dari rumah">
                <label class="form-check-label" style="font-weight: 400;">Pembatasan diet jika pasien membawa makanan dari rumah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][penyimpanan_makanan]"
                    {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['penyimpanan_makanan'] == 'Penyimpanan makanan yang dibawa dari luar rumah sakit' ? 'checked' : '' }}
                    type="checkbox" value="Penyimpanan makanan yang dibawa dari luar rumah sakit">
                <label class="form-check-label" style="font-weight: 400;">Penyimpanan makanan yang dibawa dari luar rumah sakit</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][jenis_jenis_makanan]"
                    {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['jenis_jenis_makanan'] == 'Jenis-jenis makanan yang dapat dipilih selama perawatan' ? 'checked' : '' }}
                    type="checkbox" value="Jenis-jenis makanan yang dapat dipilih selama perawatan">
                <label class="form-check-label" style="font-weight: 400;">Jenis-jenis makanan yang dapat dipilih selama perawatan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain1]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail1'] ?? 'Lainnya' }}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain2]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail2'] ?? 'Lainnya'}}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain3]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain3'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail3'] ?? 'Lainnya'}}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain4]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain4'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail4'] ?? 'Lainnya'}}
            </div>
          </td>
          <td>
              {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['durasi'] ?? '-'}}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tgl_rencana'])) : '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['pemberi_edukasi'] ?? '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['diet_dan_nutrisi']['pasien_keluarga'] ?? '-' }}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['rehab_medik']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Rehabilitasi Medik</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][rehab_medik][materi][teknik_teknik_rehab]"
                  {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['teknik_teknik_rehab'] == 'Teknik-teknik rehabilitasi' ? 'checked' : '' }}
                  type="checkbox" value="Teknik-teknik rehabilitasi">
              <label class="form-check-label" style="font-weight: 400;">Teknik-teknik rehabilitasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][gerak_aktif_pasif]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['gerak_aktif_pasif'] == 'Gerak aktif & pasif' ? 'checked' : '' }}
                    type="checkbox" value="Gerak aktif dan pasif">
                <label class="form-check-label" style="font-weight: 400;">Gerak aktif dan pasif</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][mobilisasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['mobilisasi'] == 'Mobilisasi yang dianjurkan' ? 'checked' : '' }}
                    type="checkbox" value="Mobilisasi yang dianjurkan">
                <label class="form-check-label" style="font-weight: 400;">Mobilisasi yang dianjurkan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][excercise]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['excercise'] == 'Excercise' ? 'checked' : '' }}
                    type="checkbox" value="Excercise">
                <label class="form-check-label" style="font-weight: 400;">Excercise</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][fisioterapi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['fisioterapi'] == 'Fisioterapi' ? 'checked' : '' }}
                    type="checkbox" value="Fisioterapi">
                <label class="form-check-label" style="font-weight: 400;">Fisioterapi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][terapi_okupasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['terapi_okupasi'] == 'Terapi okupasi' ? 'checked' : '' }}
                    type="checkbox" value="Terapi okupasi">
                <label class="form-check-label" style="font-weight: 400;">Terapi okupasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][ortotik_wicara]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['ortotik_wicara'] == 'Ortotik wicara' ? 'checked' : '' }}
                    type="checkbox" value="Ortotik wicara">
                <label class="form-check-label" style="font-weight: 400;">Ortotik wicara</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][ortotik_prostetik]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['ortotik_prostetik'] == 'Ortotik prostetik' ? 'checked' : '' }}
                    type="checkbox" value="Ortotik prostetik">
                <label class="form-check-label" style="font-weight: 400;">Ortotik prostetik</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain1]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                 {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain_detail1'] ?? 'Lainnya'}}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain2]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain_detail2'] ?? 'Lainnhya'}}
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['durasi'] ?? '-'}}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rehab_medik']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['rehab_medik']['tgl_rencana'])) : '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rehab_medik']['pemberi_edukasi'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rehab_medik']['pasien_keluarga'] ?? '-'}}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['alat_medis']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Informasi penggunaan alat medis secara efektif dan aman</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][alat_medis][materi][infus]"
                  {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['infus'] == 'Infus' ? 'checked' : '' }}
                  type="checkbox" value="Infus">
              <label class="form-check-label" style="font-weight: 400;">Infus</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][syringe_pump]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['syringe_pump'] == 'Syringe Pump' ? 'checked' : '' }}
                    type="checkbox" value="Syringe Pump">
                <label class="form-check-label" style="font-weight: 400;">Syringe Pump</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][infus_pump]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['infus_pump'] == 'Infus Pump' ? 'checked' : '' }}
                    type="checkbox" value="Infus Pump">
                <label class="form-check-label" style="font-weight: 400;">Infus Pump</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][ventilator]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['ventilator'] == 'Ventilator' ? 'checked' : '' }}
                    type="checkbox" value="Ventilator">
                <label class="form-check-label" style="font-weight: 400;">Ventilator</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][o2nc]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['o2nc'] == 'O2 NC' ? 'checked' : '' }}
                    type="checkbox" value="O2 NC">
                <label class="form-check-label" style="font-weight: 400;">O2 NC</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][hemodialisa]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['hemodialisa'] == 'Hemodialisa' ? 'checked' : '' }}
                    type="checkbox" value="Hemodialisa">
                <label class="form-check-label" style="font-weight: 400;">Hemodialisa</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][ogt]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['ogt'] == 'OGT' ? 'checked' : '' }}
                    type="checkbox" value="OGT">
                <label class="form-check-label" style="font-weight: 400;">OGT</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][wsd]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['wsd'] == 'WSD' ? 'checked' : '' }}
                    type="checkbox" value="WSD">
                <label class="form-check-label" style="font-weight: 400;">WSD</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][kateter_urin]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['kateter_urin'] == 'Kateter urin' ? 'checked' : '' }}
                    type="checkbox" value="Kateter urin">
                <label class="form-check-label" style="font-weight: 400;">Kateter urin</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][cpap]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['cpap'] == 'CPAP' ? 'checked' : '' }}
                    type="checkbox" value="CPAP">
                <label class="form-check-label" style="font-weight: 400;">CPAP</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][drain]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['drain'] == 'Drain' ? 'checked' : '' }}
                    type="checkbox" value="Drain">
                <label class="form-check-label" style="font-weight: 400;">Drain</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][fototherapy]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['fototherapy'] == 'Fototherapy' ? 'checked' : '' }}
                    type="checkbox" value="Fototherapy">
                <label class="form-check-label" style="font-weight: 400;">Fototherapy</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][ngt]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['ngt'] == 'NGT' ? 'checked' : '' }}
                    type="checkbox" value="NGT">
                <label class="form-check-label" style="font-weight: 400;">NGT</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['alat_medis']['materi']['lain_detail'] ?? 'Lainnya'}}
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['alat_medis']['durasi'] ?? '-' }}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{ @$asesment['pelaksanaan_edukasi']['alat_medis']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asesment['pelaksanaan_edukasi']['alat_medis']['tgl_rencana'])) : '-' }}
          </td>
          <td>
            {{ @$asesment['pelaksanaan_edukasi']['alat_medis']['pemberi_edukasi'] ?? '-' }}
          </td>
          <td>
            {{ @$asesment['pelaksanaan_edukasi']['alat_medis']['pasien_keluarga'] ?? '-' }}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['rohaniawan']['tanggal_waktu'])) : '-'}}
          </td>
          <td>
            <b>Rohaniawan</b>
            <br>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][rohaniawan][materi][bimbingan_ibadah]"
                  {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['bimbingan_ibadah'] == 'Bimbingan ibadah' ? 'checked' : '' }}
                  type="checkbox" value="Bimbingan ibadah">
              <label class="form-check-label" style="font-weight: 400;">Bimbingan ibadah</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][materi][bimbingan_doa]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['bimbingan_doa'] == 'Bimbingan doa' ? 'checked' : '' }}
                    type="checkbox" value="Bimbingan doa">
                <label class="form-check-label" style="font-weight: 400;">Bimbingan doa</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][materi][konseling_spritiual]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['konseling_spritiual'] == 'Konseling spiritual akhir hayat' ? 'checked' : '' }}
                    type="checkbox" value="Konseling spiritual akhir hayat">
                <label class="form-check-label" style="font-weight: 400;">Konseling spiritual akhir hayat</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain1]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain_detail1'] ?? 'Lainnya'}}
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain2]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                 {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain_detail2'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rohaniawan']['durasi'] ?? '-'}}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rohaniawan']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['rohaniawan']['tgl_rencana'])) : '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rohaniawan']['pemberi_edukasi'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['rohaniawan']['pasien_keluarga'] ?? '-'}}
          </td>
        </tr>
        <tr>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Manajemen Nyeri</b>
            <br>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][farmakologi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['farmakologi'] == 'Farmakologi' ? 'checked' : '' }}
                    type="checkbox" value="Farmakologi">
                <label class="form-check-label" style="font-weight: 400;">Farmakologi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][non_farmakologi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['non_farmakologi'] == 'Non Farmakologi' ? 'checked' : '' }}
                    type="checkbox" value="Non Farmakologi">
                <label class="form-check-label" style="font-weight: 400;">Non Farmakologi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][distraksi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['distraksi'] == 'Distraksi' ? 'checked' : '' }}
                    type="checkbox" value="Distraksi">
                <label class="form-check-label" style="font-weight: 400;">Distraksi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][relaksasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['relaksasi'] == 'Relaksasi' ? 'checked' : '' }}
                    type="checkbox" value="Relaksasi">
                <label class="form-check-label" style="font-weight: 400;">Relaksasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][gate_control]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['gate_control'] == 'Gate Control' ? 'checked' : '' }}
                    type="checkbox" value="Gate Control">
                <label class="form-check-label" style="font-weight: 400;">Gate Control</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                 {{@$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['lain_detail'] ?? 'Lainnya'}}
            </div>
          </td>
          <td>
            {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['durasi'] ?? '-' }}
          </td>
          <td>
            <div>
              <input class="form-check-input"
                  name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][sudah_mengerti]"
                  {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                  type="checkbox" value="Sudah mengerti">
              <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{ @$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['tgl_rencana'])) : '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['pemberi_edukasi'] ?? '-' }}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['manajemen_nyeri']['pasien_keluarga'] ?? '-' }}
          </td>
        </tr>
        <tr>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tanggal_waktu'] ? date('d-m-Y H:i', strtotime(@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tanggal_waktu'])) : '-' }}
          </td>
          <td>
            <b>Informasi bagi pasien dan keluarga</b>
            <br>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][hak_kewajiban]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['hak_kewajiban'] == 'Hak dan kewajiban pasien' ? 'checked' : '' }}
                    type="checkbox" value="Hak dan kewajiban pasien">
                <label class="form-check-label" style="font-weight: 400;">Hak dan kewajiban pasien</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][tata_tertib]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['tata_tertib'] == 'Tata tertib RS' ? 'checked' : '' }}
                    type="checkbox" value="Tata tertib RS">
                <label class="form-check-label" style="font-weight: 400;">Tata tertib RS</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][hak_berpartisipasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['hak_berpartisipasi'] == 'Hak untuk berpartisipasi pada proses pelayanan' ? 'checked' : '' }}
                    type="checkbox" value="Hak untuk berpartisipasi pada proses pelayanan">
                <label class="form-check-label" style="font-weight: 400;">Hak untuk berpartisipasi pada proses pelayanan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][pemasangan_gelang]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['pemasangan_gelang'] == 'Pemasangan gelang identitas pasien/gelang risiko' ? 'checked' : '' }}
                    type="checkbox" value="Pemasangan gelang identitas pasien/gelang risiko">
                <label class="form-check-label" style="font-weight: 400;">Pemasangan gelang identitas pasien/gelang risiko</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][lain]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                    type="checkbox" value="Lain">
                {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['lain_detail'] ?? 'Lainnya' }}
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['durasi'] ?? '-'}}
          </td>
          <td>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][sudah_mengerti]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mengerti">
                <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][berpartisipasi_mengambil_keputusan]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                    type="checkbox" value="Berpartisipasi mengambil keputusan">
                <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][sudah_mampu_mendemonstrasikan]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                    type="checkbox" value="Sudah mampu mendomenstrasikan">
                <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][reedukasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-edukasi">
                <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
            </div>
            <div>
                <input class="form-check-input"
                    name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][redemonstrasi]"
                    {{ @$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                    type="checkbox" value="Re-demonstrasi">
                <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
            </div>
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tgl_rencana'] ? date('d-m-Y', strtotime(@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tgl_rencana'])) : '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['pemberi_edukasi'] ?? '-'}}
          </td>
          <td>
            {{@$asessment['pelaksanaan_edukasi']['informasi_bagi_pasien']['pasien_keluarga'] ?? '-'}}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="no-border" style="width:100%">
        <tr>
            <td style="text-align:center;"></td>
            <td style="text-align:center;">Soreang, {{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
        </tr>
        <tr>
            <td style="width:50%;text-align:center;">Pasien</td>
            <td style="width:50%;text-align:center;">Dokter</td>
        </tr>
        <tr>
            <td style="width:50%;text-align:center;">
                @if (@$ttd_pasien->tanda_tangan)
                    <img src="{{public_path('images/upload/ttd/' . $ttd_pasien->tanda_tangan)}}" alt="ttd" width="200" height="100">
                @endif
            </td>
            <td style="width:50%;text-align:center;">
                @php
                    $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                    @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . '|' . $dokter->sip))
                @endphp
                <img src="data:image/png;base64, {!! $base64 !!}">
            </td>
        </tr>
        <tr>
            <td style="width:50%;text-align:center;">{{$reg->pasien->nama}}</td>
            <td style="width:50%;text-align:center;">
                {{@$dokter->nama}}<br>
                SIP.{{@$dokter->sip}}
            </td>
        </tr>
    </table>
  </body>
</html>
 