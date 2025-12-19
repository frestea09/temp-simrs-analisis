<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemeriksaan MCU</title>
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
    </style>
  </head>
  <body>

    <table style="border: 1px solid">
      <tr >
        <th colspan="1" style="border: 1px solid;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </th>
        <th colspan="5" style="font-size: 20pt; border: 1px solid;">
          <b>Pemeriksaan MCU</b>
        </th>
      </tr>
      <tr>
        <td colspan="6" style="border: 1px solid;">
          <b>TANGGAL PEMERIKSAAN : </b>
          {{ date('d-m-Y',strtotime(@$mcu->created_at)) }}
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
        {{-- <tr>
          <td style="border: 1px solid;">
              <b>Keluhan Utama</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['keluhan_utama'] }}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>Riwayat Penyakit Sebelumnya</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['riwayat_penyakit_sebelumnya']}}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>Riwayat Penyakit Dahulu</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['riwayat_penyakit_dahulu'] }}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>Riwayat Penyakit Keluarga</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['riwayat_penyakit_keluarga'] }}
          </td>
        </tr> --}}
        <tr>
          <td style="border: 1px solid;">
              <b>ANAMNESA</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
              {{ @json_decode(@$emrPemeriksaan->fisik, true)['anamnesa'] }} <br>
              - Riwayat Penyakit Sebelumnya : {{ @json_decode(@$emrPemeriksaan->fisik, true)['riwayat_penyakit_sebelumnya'] }} <br>
              - Riwayat Pengobatan Sebelumnya : {{ @json_decode(@$emrPemeriksaan->fisik, true)['riwayat_pengobatan_sebelumnya'] }} <br>
              - Riwayat Operasi/Tindakan : {{ @json_decode(@$emrPemeriksaan->fisik, true)['riwayat_operasi_tindakan'] }} <br>
              - Riwayat Penyakit Keluarga : {{ @json_decode(@$emrPemeriksaan->fisik, true)['riwayat_penyakit_keluarga'] }} <br>
              - Riwayat Vaksin/Imunisasi : {{ @json_decode(@$emrPemeriksaan->fisik, true)['riwayat_vaksin_imunisasi'] }} <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>STATUS GENERALIS</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>A. Tanda Vital</b> <br/>
            - TD : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['TD'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Nadi : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['nadi'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - RR : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['RR'] }} x/menit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Temp : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['temp'] }} °C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Berat Badan : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['BB'] }} kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Tinggi Badan : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['TB'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Lingkar Perut : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['lingkar_perut'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - BMI : {{ @json_decode(@$mcu->fisik, true)['tanda_vital']['BMI'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kesadaran : {{ @json_decode(@$mcu->fisik, true)['statusGeneralis']['keadaanUmum']['kesadaran'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Habitus : {{ @json_decode(@$mcu->fisik, true)['statusGeneralis']['keadaanUmum']['habitus'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>B. Pemeriksaan Fisik</b><br/>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['pemeriksaan_fisik'] }} <br>
            <br>
            <b>C. Kelainan Kulit</b><br/>
            {{ @json_decode(@$mcu->fisik, true)['statusGeneralis']['kelainanKulit']['pilihan'] }} <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>STATUS LOKALIS</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            <b>A. Kepala</b> <br/>
            - Ukuran kepala : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['ukuranKepala']['ukuran'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kelainan Mata : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanMata']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanMata']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanMata']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kacamata : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kacamata']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>B. Telinga</b><br/>
            - Percakapan berbisik (Telinga Kanan) M : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['berbisikKanan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Percakapan berbisik (Telinga Kiri) M : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['berbisikKiri'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Kelainan Telinga : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanTelinga']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanTelinga']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanTelinga']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>C. Hidung</b><br/>
            - Kelainan Hidung : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanHidung']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanHidung']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanHidung']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>D. Kerongkongan</b><br/>
            - Kelainan Kerongkongan : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanKerongkongan']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanKerongkongan']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanKerongkongan']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>E. Suara</b><br/>
            - Kelainan Suara : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanSuara']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanSuara']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['kelainanSuara']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>F. Leher</b><br/>
            - Pembesaran Kelenjar : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['leher']['pembesaranKelenjar']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Pembesaran Vena Jugularis : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['leher']['pembesaranVenaJugularis']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;"></td>
          <td colspan="5" style="border: 1px solid;">
            <br>
            <b>G. Dada</b><br/>
            - Bentuk dan Gerak Paru-Paru : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['bentukParu']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Raba (Palpasi) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['palpasi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Ketok (Perkusi) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['perkusi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Bising Nafas : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['bisingNafas']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Ronchi Basah : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['ronchiBasah']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['ronchiBasah']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['dada']['ronchiBasah']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>H. Jantung</b><br/>
            - Iclus Cordis : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['iclusCordis']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['iclusCordis']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['iclusCordis']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Raba (Thrill) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaRaba']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaRaba']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaRaba']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Ketok : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaKetok']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaKetok']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaKetok']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Periksa Dengar : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaDengar']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaDengar']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['periksaDengar']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Tambahan Bunyi Dasar : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bunyiDasar']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bunyiDasar']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bunyiDasar']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Bising Jantung : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bisingJantung']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bisingJantung']['sebutkan'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['jantung']['bisingJantung']['sebutkan'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            <b>I. Gigi dan Mulut</b><br/>
            - D (Berlubang) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['gigi_mulut']['d'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - M (Tanggul) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['gigi_mulut']['m'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - F (Sudah Ditambal) : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['gigi_mulut']['f'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            <br>
            Pemeriksaan Penunjang : {{ @json_decode(@$mcu->fisik, true)['penunjang'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            Kesimpulan : {{ @json_decode(@$mcu->fisik, true)['kesimpulan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            Catatan : {{ @json_decode(@$mcu->fisik, true)['catatan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>ABDOMEN</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            - Inspeksi : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['inspeksi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Palpasi : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['palpasi']['pilihan'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            - Nyeri Tekan : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['lokasi'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['nyeriTekan']['lokasi'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
            {{-- - Hernia : {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['hernia']['pilihan'] }} {{ @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['hernia']['lokasi'] ? ', ' . @json_decode(@$mcu->fisik, true)['statusLokalis']['abdomen']['hernia']['lokasi'] : '' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br> --}}
            <br>
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>EKSTREMITAS ATAS</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['ekstremitas_atas'] }}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>EKSTREMITAS BAWAH</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['ekstremitas_bawah'] }}
          </td>
        </tr>
        <tr>
          <td style="border: 1px solid;">
              <b>STATUS LOKALIS</b>
          </td>
          <td colspan="5" style="border: 1px solid;">
            {{ @json_decode(@$mcu->fisik, true)['keterangan_status_lokalis'] }}
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
          @if (isset($proses_tte))
          <br><br><br>
            #
          <br><br><br>
          @elseif (isset($tte_nonaktif))
          @php
            $dokter = Modules\Pegawai\Entities\Pegawai::find($mcu->user_id);
            $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
          @endphp
          <img src="data:image/png;base64, {!! $base64 !!} ">
          @else
            <br><br>
          @endif
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_user($mcu->user_id) }}
        </td>
      </tr>
    </table>
    
  </body>
</html>
 