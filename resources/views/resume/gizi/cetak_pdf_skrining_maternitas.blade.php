<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skrining Gizi Maternitas</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
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
        .page_break_after{
          page-break-after: always;
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
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 20pt;">
              <b>SKRINING GIZI MATERNITAS</b>
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
            <h5 class="text-center"><b>SKRINING NUTRISI MATERNITAS</b></h5>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;;" class="table table-striped table-bordered table-hover table-condensed form-box">
              <tr>
                  <td colspan="3" style="font-weight:bold;">Skrining kehamilan dan nifas (Berdasarkan sumber: RSCM)</td>
              </tr>
              <tr>
                  <td colspan="2">1. Apakah asupan makan berkurang, karena tidak nafsu makan?</td>
                  <td style="vertical-align: middle; width: 20%;">
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter1'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter1]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter1'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak</label>
                  </td>
              </tr>
              <tr>
                  <td colspan="2">2. Ada gangguan metabolisme (DM, gangguan fungsi tiroid, infeksi kronis, seperti HIV/AIDS, TB, Lupus, Lain-lain)</td>
                  <td style="vertical-align: middle; width: 20%;">
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter2]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak</label>
                      {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter2_lain'] }}
                  </td>
              </tr>
              <tr>
                  <td colspan="2">3. Ada penambahan berat badan yang kurang atau lebih selama kehamilan?</td>
                  <td style="vertical-align: middle; width: 20%;">
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter3'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter3]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak</label>
                  </td>
              </tr>
              <tr>
                  <td colspan="2">4. Nilai Hb &lt; 10 g/dl atau HCT &lt; 30%</td>
                  <td style="vertical-align: middle; width: 20%;">
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter4'] == 'Ya' ? 'checked' : '' }}
                          type="radio" value="Ya">
                      <label class="form-check-label">Ya</label>
                      <input class="form-check-input"
                          name="fisik[skrining_nutrisi_dewasa][skrining_kehamilan_dan_nifas][parameter4]"
                          {{ @$skrining['skrining_kehamilan_dan_nifas']['parameter4'] == 'Tidak' ? 'checked' : '' }}
                          type="radio" value="Tidak">
                      <label class="form-check-label">Tidak</label>
                  </td>
              </tr>
              <tr>
                  <td colspan="3" style="width: 50%; font-weight:bold;">Total Skor</td>
              </tr>
              <tr>
                  <td colspan="3" style="width: 50%; font-weight:bold;">
                      <ul>
                          <li>Jika jawaban ya 1 s/d 3 rujuk ke dietisien</li>
                          <li>Jika jawaban ya > 3, rujuk ke Dokter Spesialis Gizi Klinik</li>
                      </ul>
                  </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <h5 class="text-center"><b>SKRINING NUTRISI MATERNITAS</b></h5>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;;" class="table table-striped table-bordered table-hover table-condensed form-box">
              <tr>
                <td style="width: 50%;">Berat Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                <td colspan="2" style="padding: 5px;">
                      {{ @$skrining['berat_badan']}}
                </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Panjang Badan atau Tinggi Badan Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                          {{ @$skrining['panjang_badan'] }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Berat Badan Menurut Panjang Badan Atau Tinggi Badan <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                      {{@$skrining['berat_badan_menurut_tinggi_badan']}}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 0 - 60 bulan</b></td>
                    <td colspan="2" style="padding: 5px;">
                        {{ @$skrining['imt_bayi']}}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">Index Masa Tubuh (IMT) Menurut Umur <br> <b>anak usia 5 - 18 tahun</b></td>
                    <td colspan="2" style="padding: 5px;">
                        {{@$skrining['imt_anak']}}
                    </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <h5 class="text-center"><b>SKRINING NUTRISI MATERNITAS</b></h5>
            </td>
            <td colspan="5">
              <table style="width: 100%; font-size:12px;;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                    <td colspan="3" style="font-weight: bold;">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan?</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)' ? 'checked' : '' }}
                                type="radio" value="Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir)">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) (0)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'Tidak yakin (tanyakan apakah baju/celana terasa longgar)' ? 'checked' : '' }}
                                type="radio" value="Tidak yakin (tanyakan apakah baju/celana terasa longgar)">
                            <label class="form-check-label" style="font-weight: 400;">Tidak yakin (tanyakan apakah baju/celana terasa longgar) (2)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1'] == 'ya' ? 'checked' : '' }}
                                type="radio" value="ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya, berapa penurunan berat badan tersebut?</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '1 - 5 Kg' ? 'checked' : '' }}
                                type="radio" value="1 - 5 Kg">
                            <label class="form-check-label" style="font-weight: 400;">1 - 5 Kg (1)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '6 - 10 Kg' ? 'checked' : '' }}
                                type="radio" value="6 - 10 Kg">
                            <label class="form-check-label" style="font-weight: 400;">6 - 10 Kg (2)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '11 - 15 Kg' ? 'checked' : '' }}
                                type="radio" value="11 - 15 Kg">
                            <label class="form-check-label" style="font-weight: 400;">11 - 15 Kg (3)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == '> 15 Kg' ? 'checked' : '' }}
                                type="radio" value="> 15 Kg">
                            <label class="form-check-label" style="font-weight: 400;">> 15 Kg (4)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter1_ya]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter1_ya'] == 'Tidak yakin' ? 'checked' : '' }}
                                type="radio" value="Tidak yakin">
                            <label class="form-check-label" style="font-weight: 400;"> Tidak yakin (2)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;">2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun? (Misalnya asupan makan hanya 1/4 dari biasanya)</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter2'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter2]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter2'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya (1)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;">3. Sakit Berat?</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 20%;" colspan="3">
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter3'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak (0)</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][parameter3]"
                                {{ @$skrining['pasien_ginekologi_onkologi']['parameter3'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya (2)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;">Kesimpulan &amp; Tindak lanjut</td>
                    <td colspan="2"> 
                        <div >
                            <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_lebih_2]"
                            {{ @$skrining['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_lebih_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Total Skor > 2, rujuk ke dietisien untuk asesmen gizi</label>
                        </div>
                        <div >
                            <input class="form-check-input" name="fisik[skrining_nutrisi_dewasa][pasien_ginekologi_onkologi][kesimpulan_tindak_lanjut][total_skor_kurang_2]"
                            {{ @$skrining['pasien_ginekologi_onkologi']['kesimpulan_tindak_lanjut']['total_skor_kurang_2'] == 'true' ? 'checked' : '' }} type="checkbox"
                            value="true">
                            <label class="form-check-label">Total Skor &lt; 2, Skrining ulang 7 hari</label>
                        </div>
                    </td>
                </tr>
              </table>
            </td>
          </tr>
    </table>
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (str_contains(baca_user($data->user_id),'dr.'))
              Dokter
          @else
              Perawat
          @endif
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
          @if (isset($cetak_tte))
            {{ Auth::user()->name }}
          @else
            {{baca_user($data->user_id)}}
          @endif
        </td>
      </tr>
    </table>
  </body>
</html>
 