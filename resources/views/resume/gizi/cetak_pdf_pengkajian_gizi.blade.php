<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengkajian Gizi</title>
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
              <b>PENGKAJIAN GIZI</b>
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
              <b>ANTROPOMETRI</b>
          </td>
          <td colspan="5">
              <b>Dewasa :</b> <br>
              - BB Saat Ini : {{@$assesment['pengkajian']['antropometri']['dewasa']['bb_saat_ini']}} Kg <br>
              - BB Biasanya : {{@$assesment['pengkajian']['antropometri']['dewasa']['bb_biasanya']}} Kg <br>
              - Penurunan BB : {{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb']}} %  dalam {{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb_dalam']}}<br>
              - Tinggi Badan : {{@$assesment['pengkajian']['antropometri']['dewasa']['tinggi_badan']}} cm <br>
              - LILA : {{@$assesment['pengkajian']['antropometri']['dewasa']['lila']}}
              - IMT : {{@$assesment['pengkajian']['antropometri']['dewasa']['imt']}}
              - Status Gizi : {{@$assesment['pengkajian']['antropometri']['dewasa']['status_gizi']}}
              <br><br>
              <b>Anak :</b>
              - BB Saat ini : {{@$assesment['pengkajian']['antropometri']['anak']['bb_saat_ini']}} Kg <br>
              - BB Biasanya : {{@$assesment['pengkajian']['antropometri']['anak']['bb_biasanya']}} Kg <br>
              - Penurunan BB : {{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb']}} dalam {{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb_dalam']}} <br>
              - Tinggi Badan : {{@$assesment['pengkajian']['antropometri']['anak']['tinggi_badan']}} cm <br>
              - LILA : {{@$assesment['pengkajian']['antropometri']['anak']['lila']}} <br>
              - Standar Deviasi : BB/U = {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['1']}} , PB, TB/U = {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['2']}} , BB/PB, TB = {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['3']}} <br>
              - Status Gizi : {{@$assesment['pengkajian']['antropometri']['anak']['status_gizi']}} <br>
          </td>
        </tr>
        <tr>
          <td>
              <b>Bio Kimia Terkait Gizi</b>
          </td>
          <td colspan="5">
            {{@$assesment['pengkajian']['biokimia']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>Fisik Klinis Gizi</b>
          </td>
          <td colspan="5">
            <table style="width: 100%; border: 1px solid black; font-size:12px;" class="table table-striped table-hover table-condensed form-box">
                    @php
                        $fisik = @$assesment['pengkajian']['fisik_klinis_gizi'] ?? [];
                    @endphp

                    @php
                        function rowFisik($label, $name, $value) {
                            if (!isset($value[$name]) || $value[$name] == null) return '';
                            return '
                            <tr style="border: 1px solid black;">
                                <td colspan="2" style="font-weight: bold;border: 1px solid black;">'. $label .'</td>
                                <td colspan="2" style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi]['.$name.']"
                                            '.($value[$name] == "Ya" ? "checked" : "").'
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td colspan="2" style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi]['.$name.']"
                                            '.($value[$name] == "Tidak" ? "checked" : "").'
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>';
                        }
                    @endphp

                    {!! rowFisik('Gangguan Nafsu Makan', 'gangguan_nafsu_makan', $fisik) !!}
                    {!! rowFisik('Kembung', 'kembung', $fisik) !!}
                    {!! rowFisik('Mual', 'mual', $fisik) !!}
                    {!! rowFisik('Konstipasi', 'konstipasi', $fisik) !!}
                    {!! rowFisik('Muntah', 'muntah', $fisik) !!}
                    {!! rowFisik('Kepala dan Mata', 'kepala_dan_mata', $fisik) !!}
                    {!! rowFisik('Atropi otot lengan', 'antropi_otot_lengan', $fisik) !!}
                    {!! rowFisik('Diare', 'gigi_geligi', $fisik) !!}
                    {!! rowFisik('Hilang lemak subkutan', 'hilang_lemak_subkutan', $fisik) !!}
                    {!! rowFisik('Gangguan menelan', 'gangguan_menelan', $fisik) !!}
                    {!! rowFisik('Gangguan mengunyah', 'gangguan_mengunyah', $fisik) !!}
                    {!! rowFisik('Gangguan menghisap', 'gangguan_menghisap', $fisik) !!}
                    {!! rowFisik('Sesak', 'sesak', $fisik) !!}
                    {!! rowFisik('Stomatitis', 'stomatitis', $fisik) !!}

                    @if(!empty($fisik['lainnya']))
                    <tr style="border: 1px solid black;">
                        <td style="font-weight: bold;border: 1px solid black;">Lainnya</td>
                        <td style="border: 1px solid black;" class="text-center" colspan="2">
                            {{ $fisik['lainnya'] }}
                        </td>
                    </tr>
                    @endif
                <tr>
                  <td colspan="6" style="width:50%; font-weight:bold;">Tanda Vital</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Tekanan Darah (mmHG)</label><br/>
                    {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['tekanan_darah']}}
                  </td>
                  <td style="padding: 5px;">
                      <label class="form-check-label" style="font-weight: normal;"> Suhu (°C)</label><br/>
                      {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['suhu']}}
                    </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                    {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['nadi']}}
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Respirasi (x/menit)</label><br/>
                    {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['respirasi']}}
                  </td>
                  <td style="padding: 5px;">
                    <label class="form-check-label" style="font-weight: normal;">Saturasi (x/menit)</label><br/>
                    {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['saturasi']}}
                  </td>
                  <td>&nbsp;</td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
              <b>RIWAYAT DIET</b>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
              <tr>
                  <td style="width: 20%;">
                      Asupan Nutrisi RS
                  </td>
                  <td>
                    {{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_rs']}}
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Asupan Nutrisi SMRS
                  </td>
                  <td>
                    {{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_smrs']}}
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Asupan Nutrisi Cairan
                  </td>
                  <td>
                    {{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_cairan']}}
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Pantangan makan
                  </td>
                  <td>
                    {{@$assesment['pengkajian']['riwayat_diet']['pantangan_makan']}}
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Pengalaman diet sebelumnya
                  </td>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                              {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label" style="font-weight: 400;">Ya</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                              {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Riwayat konseling gizi
                  </td>
                  <td>
                      <div>
                          <input class="form-check-input"
                              name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                              {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Ya' ? 'checked' : '' }}
                              type="radio" value="Ya">
                          <label class="form-check-label" style="font-weight: 400;">Ya</label>
                      </div>
                      <div>
                          <input class="form-check-input"
                              name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                              {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Tidak' ? 'checked' : '' }}
                              type="radio" value="Tidak">
                          <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Alergi makanan
                  </td>
                  <td>
                      <table style="width: 100%; border: 1px solid black; font-size:12px;" class="table table-striped table-hover table-condensed form-box">
                          <tr style="border: 1px solid black;">
                              <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                  Telur
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                              <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                  Gluten/gandum
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                          </tr>
                          <tr style="border: 1px solid black;">
                              <td style="font-weight: bold;border: 1px solid black;">
                                  Udang
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                              <td style="font-weight: bold;border: 1px solid black;">
                                  Susu sapi / produk olahan
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                          </tr>
                          <tr style="border: 1px solid black;">
                              <td style="font-weight: bold;border: 1px solid black;">
                                  Ikan
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                              <td style="font-weight: bold;border: 1px solid black;">
                                  Kacang-kacangan
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Ya' ? 'checked' : '' }}
                                          type="radio" value="Ya">
                                      <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                          {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Tidak' ? 'checked' : '' }}
                                          type="radio" value="Tidak">
                                      <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                  </div>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
              <tr>
                  <td style="width: 20%;">
                      Alergi makanan lainnya
                  </td>
                  <td>
                    {{@$assesment['pengkajian']['riwayat_diet']['alergi_makanan_lainnya']}}
                  </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA GIZI</b>
          </td>
          <td colspan="5">
            {{@$assesment['diagnosa_gizi']}}
          </td>
        </tr>
        <tr>
          <td>
              <b>INTERVENSI GIZI</b>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
              <tr>
                  <td style="width: 20%;">
                      Tujuan
                  </td>
                  <td>
                    {{@$assesment['intervensi_gizi']['tujuan']}}
                  </td>
              </tr>
              <tr>
                  <td colspan="2" style="width: 20%;">
                      Preskrisi Diet
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">a. Bentuk makanan</td>
                  <td>
                      <table style="width: 100%; border: 1px solid black; font-size:12px;" class="table table-striped table-hover table-condensed form-box">
                          <tr style="border: 1px solid black;">
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'MC' ? 'checked' : '' }}
                                          type="radio" value="MC">
                                      <label class="form-check-label" style="font-weight: 400;">MC</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'BR' ? 'checked' : '' }}
                                          type="radio" value="BR">
                                      <label class="form-check-label" style="font-weight: 400;">BR</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Sippy' ? 'checked' : '' }}
                                          type="radio" value="Sippy">
                                      <label class="form-check-label" style="font-weight: 400;">Sippy</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div style="display: flex; vertical-align:middle">
                                      <input style="margin: 0" class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Lainnya' ? 'checked' : '' }}
                                          type="radio" value="Lainnya">
                                      <label class="form-check-label" style="font-weight: 400; margin: 0 1rem 0 0;">Lainnya</label>
                                      {{@$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan_lain']}}
                                  </div>
                              </td>
                          </tr>
                          <tr style="border: 1px solid black;">
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan saring (TD I) ' ? 'checked' : '' }}
                                          type="radio" value="Makanan saring (TD I) ">
                                      <label class="form-check-label" style="font-weight: 400;">Makanan saring (TD I) </label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan lunak (TD II)' ? 'checked' : '' }}
                                          type="radio" value="Makanan lunak (TD II)">
                                      <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD II)</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan lunak (TD III)' ? 'checked' : '' }}
                                          type="radio" value="Makanan lunak (TD III)">
                                      <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD III)</label>
                                  </div>
                              </td>
                              <td style="border: 1px solid black; width: 10%;" class="text-center">
                                  <div>
                                      <input class="form-check-input"
                                          name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                          {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan biasa (TD IV)  ' ? 'checked' : '' }}
                                          type="radio" value="Makanan biasa (TD IV)  ">
                                      <label class="form-check-label" style="font-weight: 400;">Makanan biasa (TD IV)  </label>
                                  </div>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">b. Jenis diet</td>
                  <td>
                    {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] }}
                    {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet_lainnya'] }}
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">c. Frekuensi</td>
                  <td>
                    {{@$assesment['intervensi_gizi']['preskripsi_diet']['frekuensi']}}
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">d. Rute</td>
                  <td>
                    @foreach (@$assesment['intervensi_gizi']['preskripsi_diet']['rute'] ?? [] as $rute)
                        - {{$rute}} <br>
                    @endforeach                
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">e. Kebutuhan</td>
                  <td>
                      Energi :
                      <br>
                      {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['energi'] }}
                      <br>
                      Protein :
                      <br>
                      {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['protein'] }}
                      <br>
                      Lemak :
                      <br>
                      {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['lemak'] }}
                      <br>
                      Karbohidrat :
                      <br>
                      {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['karbohidrat'] }}
                      <br>
                  </td>
              </tr>
              <tr>
                  <td style="font-weight: bold; width: 20%;">f. Edukasi</td>
                  <td>
                    {{@$assesment['intervensi_gizi']['preskripsi_diet']['edukasi']}}
                  </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
              <b>MONITORING DAN EVALUASI</b>
          </td>
          <td colspan="5">
            {{@$assesment['monitoring_dan_evaluasi']}}
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
              Nutrisionis
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
 