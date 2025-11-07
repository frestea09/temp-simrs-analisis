<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skrining Gizi Dewasa</title>
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
              <b>SKRINING GIZI DEWASA</b>
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
            <h5 class="text-center"><b>SKRINING NUTRISI DEWASA</b></h5>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                
              <tr>
                <td style="width: 50%; font-weight:bold">BB</td>
                <td>
                  {{ @$nutrisi['bb']['detail'] }}
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan ?
                    <ul>
                      <li>Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) => 0</li>
                      <li>Tidak yakin (Tanyakan apakah baju/celana terasa longgar) => 2</li>
                      <li>
                        Ya, berapa penurunan berat badan tersebut ?
                        <ul>
                          <li>1 - 5 kg => 1</li>
                          <li>6 - 10 kg => 2</li>
                          <li>11 - 15 kg => 3</li>
                          <li>> 15 kg => 4</li>
                          <li>Tidak Yakin => 2</li>
                        </ul>
                      </li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                  {{ @$nutrisi['skor']['1'] }}
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun **? (Misalnya asupan makan hanya 1/4 dari biasanya)
                    <ul>
                        <li>Tidak => 0</li>
                        <li>Ya => 1</li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                  {{ @$nutrisi['skor']['2'] }}
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">
                    3. Sakit Berat ***)
                    <ul>
                      <li>Tidak => 0</li>
                      <li>Ya => 2</li>
                    </ul>
                </td>
                <td style="vertical-align: middle;">
                  {{ @$nutrisi['skor']['3'] }}
                </td>
              </tr>

            </table>
          </td>
        </tr>
        <tr>
          <td>
            <h5 class="text-center"><b>SKRINING NUTRISI DEWASA</b></h5>
          </td>
          <td colspan="5">
            <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
              <tr>
                <td style="width:50%; font-weight:bold;">Total Skor</td>
                <td>
                  {{ @$nutrisi['skor']['total'] }}
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;">Kesimpulan dan tindak lanjut</td>
                <td>
                  {{ @$nutrisi['skor']['kesimpulan'] }}
                </td>
              </tr>
              <tr>
                <td colspan="2">Keterangan</td>
              </tr>
              <tr>
                <td style="width:50%; font-weight:bold;" colspan="2">
                  <ul style="font-weight: normal">
                      <li>
                        Total skor >= 2 : Risiko malnutrisi.
                      </li>
                      <li>
                        *Malnutrisi yang dimaksud dalam hal ini adalah kurang gizi.
                      </li>
                      <li>
                        ** Asupan makan yang buruk dapat juga terjadi karena gangguan mengunyah atau menelan
                      </li>
                      <li>
                        Penurunan berat badan yang tidak direncanakan pada pasien dengan kelebihan berat atau obes berisiko terjadinya malnutrisi.
                      </li>
                      <li>
                        *** Penyakit yang berisiko terjadi gangguan gizi diantaranya: dirawat di HCU/ICU, penurunan kesadaran, 
                        kegawatan abdomen (pendarahan, ileus, perotonitis, asites massif, tumor intrabdomen besar, post operasi), 
                        gangguan pernapasan berat, keganasan komplikasi, gagal jantung, gagal ginjal kronik, gagal hati, diabetes melitus, 
                        atau kondisi sakit berat lain.
                      </li>
                  </ul>
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
 