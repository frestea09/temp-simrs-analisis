<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
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
    </style>
  </head>
  <body>
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    {{-- @php
      $user = $soap->user;
      $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $user->id)->first();
    @endphp --}}
    <table>
      <tr>
        <th colspan="1">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </th>
        <th colspan="5" style="font-size: 18pt;">
          <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK {{ baca_poli(@$reg->poli_id) }}</b>
        </th>
      </tr>
      <tr>
        <td colspan="6">
          Tanggal Pemeriksaan : {{ date('d-m-Y',strtotime(@$soap->created_at)) }}
        </td>
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
              <b>KELUHAN UTAMA</b>
          </td>
          <td colspan="5">
              {{ @json_decode(@$soap->fisik, true)['anamnesa'] }}
          </td>
        </tr>
        <tr>
            <td>
                <b>RIWAYAT MEDIK SEBELUMNYA</b>
            </td>
            <td colspan="5">
                <div style="line-height: 10px;">
                    <strong>Hipertensi</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['hipertensi']['pilihan'] }} - {{ @json_decode(@$soap->fisik, true)['riwayat_medik']['hipertensi']['sebutkan'] }}</p>
                </div>
                <div style="line-height: 10px;">
                    <strong>Penyakit Jantung</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['penyakitJantung']['pilihan'] ?? '-' }}</p>
                </div>
                <div style="line-height: 10px;">
                    <strong>Kelainan Darah</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['kelainanDarah']['pilihan'] ?? '-' }}</p>
                </div>
                <div style="line-height: 10px;">
                    <strong>Diabetes</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['diabetes']['pilihan'] ?? '-' }}</p>
                </div>
                <div style="line-height: 10px;">
                    <strong>Alergi</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['alergi']['pilihan'] }} - {{ @json_decode(@$soap->fisik, true)['riwayat_medik']['alergi']['sebutkan'] }}</p>
                </div>
                <div style="line-height: 10px;">
                    <strong>Riwayat Medis Lainnya</strong>
                    <p>{{ @json_decode(@$soap->fisik, true)['riwayat_medik']['medisLainnya']['pilihan'] }} - {{ @json_decode(@$soap->fisik, true)['riwayat_medik']['medisLainnya']['pilihanAda'] }}</p>
                </div>
            </td>
          </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5">
            1. Tanda Vital <br/>
            - TD : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['tekanan_darah1']['sebutkan'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Nadi : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['nadi']['sebutkan'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - RR : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['RR']['sebutkan'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Temp : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['temp']['sebutkan'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
            - Berat Badan : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['BB']['sebutkan'] }} Kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Tinggi Badan : {{ @json_decode(@$soap->fisik, true)['tanda_vital']['TB']['sebutkan'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/><br/>
          </td>
        </tr>
        <tr>
          <td>
              <b>RIWAYAT KESEHATAN GIGI</b>
          </td>
          <td colspan="5">
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl1'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi1'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala1'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl2'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi2'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala2'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl3'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi3'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala3'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl4'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi4'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala4'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl5'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi5'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala5'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl6'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi6'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala6'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl7'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi7'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala7'] ?? '-' }}
            </div>
            <div>
              <span>TGL:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['tgl8'] ?? '-' }}
              <span>Gigi:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['gigi8'] ?? '-' }}
              <span>Skala:</span>
              {{ @json_decode(@$soap->fisik, true)['riwayatKesehatanGigi']['skala8'] ?? '-' }}
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="6">
            <b>PEMERIKSAAN PENUNJANG</b> <br>
            @foreach (@$rads as $rad)
            - {{ @$rad->namatarif }} <b>({{ baca_dokter(@$rad->dokter_pelaksana) }})</b><br>
            @endforeach
            @foreach (@$labs as $lab)
            - {{ @$lab->namatarif }} <b>({{ baca_dokter(@$lab->dokter_pelaksana) }})</b><br>
            @endforeach
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
            <b>RIWAYAT GIGI SEBELUMNYA</b>
            <br>
            <div>
              <span style="width: 50%;">- APAKAH PASIEN SUDAH PERNAH MENDAPATKAN PERAWATAN GIGI
                  SEBELUMNYA : </span>
              <span>
                  <input type="checkbox" id="perawatanGigi_1" name="fisik[riwayatGigi][perawatanGigi][pilihan]"
                      value="Tidak" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['perawatanGigi']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                  <label for="perawatanGigi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                  <input type="checkbox" id="perawatanGigi_2" name="fisik[riwayatGigi][perawatanGigi][pilihan]"
                      value="Ya" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['perawatanGigi']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                  <label for="perawatanGigi_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
              </span>
            </div>
            <div>
              <span style="width: 50%;">- APAKAH PASIEN MENYIKAT GIGI 2 x SEHARI : </span>
              <span>
                <input type="radio" id="menyikat2x_1" name="fisik[riwayatGigi][menyikat2x][pilihan]"
                value="Tidak" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikat2x']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                <label for="menyikat2x_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                <input type="radio" id="menyikat2x_2" name="fisik[riwayatGigi][menyikat2x][pilihan]"
                    value="Ya"  {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikat2x']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                <label for="menyikat2x_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
              </span>
            </div>
            <div>
              <span style="width: 50%;">- APAKAH PASIEN MENYIKAT GIGI SESUDAH MAKAN : </span>
              <span>
                <input type="radio" id="menyikatSesudahMakan_1" name="fisik[riwayatGigi][menyikatSesudahMakan][pilihan]"
                value="Tidak" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikatSesudahMakan']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                <label for="menyikatSesudahMakan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                <input type="radio" id="menyikatSesudahMakan_2" name="fisik[riwayatGigi][menyikatSesudahMakan][pilihan]"
                    value="Ya"  {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikatSesudahMakan']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                <label for="menyikatSesudahMakan_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
              </span>
            </div>
            <div>
              <span style="width: 50%;">- APAKAH PASIEN MENYIKAT GIGI SEBELUM TIDUR : </span>
              <span>
                <input type="radio" id="menyikatSebelumTidur_1"
                    name="fisik[riwayatGigi][menyikatSebelumTidur][pilihan]" value="Tidak"  {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikatSebelumTidur']['pilihan'] == 'Tidak' ? 'checked' : ''}}>
                <label for="menyikatSebelumTidur_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                <input type="radio" id="menyikatSebelumTidur_2"
                    name="fisik[riwayatGigi][menyikatSebelumTidur][pilihan]" value="Ya" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['menyikatSebelumTidur']['pilihan'] == 'Ya' ? 'checked' : ''}}>
                <label for="menyikatSebelumTidur_2"
                    style="font-weight: normal; margin-right: 10px;">Ya</label><br />
              </span>
            </div>
            <div>
              <span style="width: 50%;">- BAGAIMANA CARA GERAKAN MENYIKAT GIGI : </span>
              <span>
                <span class="form-check-label" for="flexCheckDefault"
                style="margin-right: 10px; font-weight: 400;">
                MEMUTAR
              </span>
              <input class="form-check-input" name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]"
                  type="checkbox" value="Memutar" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['gerakanMenyikatGigi']['pilihan'] == 'Memutar' ? 'checked' : ''}}>
              <span class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                MAJU MUNDUR
              </span>
              <input class="form-check-input" name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]"
                  type="checkbox" value="Maju Mundur" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['gerakanMenyikatGigi']['pilihan'] == 'Maju Mundur' ? 'checked' : ''}}>
              <span class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                SEARAH TUMBUH GIGI
              </span>
              <input class="form-check-input" name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]"
                  type="checkbox" value="Searah Tumbuh Gigi" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['gerakanMenyikatGigi']['pilihan'] == 'Searah Tumbuh Gigi' ? 'checked' : ''}}>
              </span>
            </div>
            <div>
              <span style="width: 50%;">- APAKAH PASIEN MEMPUNYAI KEBIASAAN : </span>
                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">Minum Kopi</span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumKopiYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['minumKopiYa'] == 'Minum Kopi' ? 'checked' : ''}}>

                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">Minum Alkohol </span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumAlkoholYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['minumAlkoholYa'] == 'Minum Alkohol' ? 'checked' : ''}}>

                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;">Merokok </span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][merokokYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['merokokYa'] == 'Merokok' ? 'checked' : ''}}>

                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;"> Mengunyah 1 sisi </span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][mengunyah1sisiYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['mengunyah1sisiYa'] == 'Mengunyah 1 sisi' ? 'checked' : ''}}>

                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;"> Menggigit Pensil </span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][menggigitPensilYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['menggigitPensilYa'] == 'Menggigit Pensil' ? 'checked' : ''}}>

                <span class="form-check-label" for="flexCheckDefault" style="margin-right: 10px; font-weight: 400;"> BRUXISM </span>
                <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][bruxismYa]"
                  type="checkbox" {{ @json_decode(@$soap->fisik, true)['riwayatGigi']['kebiasaan']['bruxismYa'] == 'BRUXISM' ? 'checked' : ''}}>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
            <b>DIAGNOSA KEPERAWATAN GIGI DAN MULUT</b>
            <br>
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['1'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KEBUTUHAN AKAN BEBAS DARI RASA NYERI PADA LEHER DAN KEPALA
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['2'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KEBUTUHAN AKAN KESAN WAJAH YANG SEHAT
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['3'] == 'true')
              <span>
                - TIDAK TERPENUHINYA INTEGRASI (KEBUTUHAN) JARINGAN KULIT, MUKOSA DAN MEMBRAN PADA LEHER DAN
                KEPALA
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['4'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KEBUTUHAN PENGETAHUAN / PEMAHAMAN YANG BAIK TENTANG KESEHATAN GIGI DAN MULUT
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['5'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KEBUTUHAN AKAN BEBAS DARI MASALAH KECEMASAN / STREES
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['6'] == 'true')
              <span>
                - TIDAK TERPENUHINYA TANGGUNG JAWAB AKAN KESEHATAN GIGI DAN MULUT SENDIRI
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['7'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KEBUTUHAN AKAN PERLINDUNGAN DARI RESIKO PENYAKIT GIGI DAN MULUT
              </span> <br>
            @endif
            @if (@json_decode(@$soap->fisik, true)['diagnosaGigiMulut']['8'] == 'true')
              <span>
                - TIDAK TERPENUHINYA KONDISI BIOLOGIS GIGI DAN MULUT DENGAN BAIK
              </span> <br>
            @endif
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              @foreach (@$folio as $tindakan)
              - {{ @$tindakan->namatarif }}<br>
              @endforeach
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
            <b>PENGOBATAN</b><br/>
            @foreach (@$obats as $obat)
            - {{ substr(strtoupper(baca_obat(@$obat->masterobat_id)), 0, 40) }}<br>
            @endforeach
          </td>
        </tr>
        
        
    </table>
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if ($soap->type == 'fisik_gigi')
            Dokter
          @elseif ($soap->type == 'fisik_gigi_perawat')
            Perawat
          @endif
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
          {{baca_user($soap->user_id)}}
        </td>
      </tr>
    </table>
    
  </body>
</html>
 