<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skrining Gizi Perinatologi</title>
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
              <b>SKRINING GIZI PERINATOLOGI</b>
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
            <h5 class="text-center"><b>SKRINING NUTRISI PERINATOLOGI</b></h5>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                <tr>
                    <td colspan="2" style="width: 50%;">Tanggal Lahir</td>
                    <td>
                        {{ @$skrining['tanggal_lahir'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%; font-weight: bold;">1. Penilaian Pertumbuhan</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Berat badan saat ini</td>
                    <td>
                        {{ @$skrining['bb_saat_ini'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Lingkar kepala</td>
                    <td>
                        {{ @$skrining['lingkar_kepala'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Panjang badan</td>
                    <td>
                        {{ @$skrining['panjang_badan'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Berat badan lahir</td>
                    <td>
                        {{ @$skrining['berat_badan_lahir'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Lingkar kepala lahir</td>
                    <td>
                        {{ @$skrining['lingkar_kepala_lahir'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%;">Panjang badan lahir</td>
                    <td>
                        {{ @$skrining['panjang_badan_lahir'] }}
                    </td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
            <td>
              <h5 class="text-center"><b>SKRINING NUTRISI PERINATOLOGI</b></h5>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="3" style="width: 50%; font-weight: bold;">2. Ketentuan Golongan Risiko</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Tinggi</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Prematur usia < 28 minggu' ? 'checked' : '' }}
                                    type="radio" value="Prematur usia < 28 minggu">
                                <label class="form-check-label">Prematur usia &lt; 28 minggu</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Berat badan lahir sangat rendah < 1000 g' ? 'checked' : '' }}
                                    type="radio" value="Berat badan lahir sangat rendah < 1000 g">
                                <label class="form-check-label">Berat badan lahir sangat rendah &lt; 1000 g</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Bayi yang mengalami NEC setelah mendapat makanan' ? 'checked' : '' }}
                                    type="radio" value="Bayi yang mengalami NEC setelah mendapat makanan">
                                <label class="form-check-label">Bayi yang mengalami NEC setelah mendapat makanan</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Atau bayi yang mengalami gastroinstestinal perforasi' ? 'checked' : '' }}
                                    type="radio" value="Atau bayi yang mengalami gastroinstestinal perforasi">
                                <label class="form-check-label">Atau bayi yang mengalami gastroinstestinal perforasi</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)' ? 'checked' : '' }}
                                    type="radio" value="Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)">
                                <label class="form-check-label">Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Sedang</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Prematur 28-31 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Prematur 28-31 minggu, dengan kondisi baik">
                                <label class="form-check-label">Prematur 28-31 minggu, dengan kondisi baik</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'IUGR (berat < 9 persentile)' ? 'checked' : '' }}
                                    type="radio" value="IUGR (berat < 9 persentile)">
                                <label class="form-check-label">IUGR (berat &lt; 9 persentile)</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Berat badan lahir sangat rendah 1000 - 1500 g' ? 'checked' : '' }}
                                    type="radio" value="Berat badan lahir sangat rendah 1000 - 1500 g">
                                <label class="form-check-label">Berat badan lahir sangat rendah 1000 - 1500 g</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan' ? 'checked' : '' }}
                                    type="radio" value="Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan">
                                <label class="form-check-label">Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Rendah</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_rendah]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_rendah'] == 'Prematur 32 - 36 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Prematur 32 - 36 minggu, dengan kondisi baik">
                                <label class="form-check-label">Prematur 32 - 36 minggu, dengan kondisi baik</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_rendah]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_rendah'] == 'Bayi > 37 minggu dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Bayi > 37 minggu dengan kondisi baik">
                                <label class="form-check-label">Bayi > 37 minggu dengan kondisi baik</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
              <h5 class="text-center"><b>SKRINING NUTRISI PERINATOLOGI</b></h5>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                    <tr>
                        <td colspan="4" style="width: 50%; font-weight: bold;">2. Ketentuan Intervensi Dukungan Tim Nutrisi</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            Dukungan tim nutrisi pada bayi diberikan berdasarkan kriteria berikut :
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table style="width: 100%; border: 1px solid black; font-size:12px;" class="table table-striped table-hover table-condensed form-box">
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Bayi yang termasuk golongan risiko tinggi
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        {{@$skrining['ketentuan_intervensi']['param1']['detail']}}
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Berat badan lahir tidak kembali dalam 2 minggu usia kelahiran
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        {{@$skrining['ketentuan_intervensi']['param2']['detail']}}
                                    </td>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Penurunan berat badan > 15 %
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        {{@$skrining['ketentuan_intervensi']['param3']['detail']}}
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Penambahan berat badan &lt; 10 g/kg/hari selama 2 minggu
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        {{@$skrining['ketentuan_intervensi']['param4']['detail']}}
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        NEC atau operasi gastrointestinal
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        {{@$skrining['ketentuan_intervensi']['param5']['detail']}}
                                    </td>
                                </tr>
                            </table>
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
 