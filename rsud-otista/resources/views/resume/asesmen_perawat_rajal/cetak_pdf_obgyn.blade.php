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
    </style>
  </head>
  <body>


    <table>
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 18pt;">
            <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK OBGYN</b>
          </th>
        </tr>
        <tr>
          <td colspan="6">
            Tanggal Pemeriksaan : {{ date('d-m-Y',strtotime(@$emrPemeriksaan->created_at)) }}
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
              <b>ANAMNESA</b>
          </td>
          <td colspan="3">
            @if (@$soap['keluhanUtama'])
              Keluhan Utama: {{ @$soap['keluhanUtama'] }}   
              <br>         
            @endif
            @if (@$soap['riwayatPenyakit'])
              Riwayat Penyakit: {{ @$soap['riwayatPenyakit'] }}   
              <br>         
            @endif
            @if (@$soap['riwayat_alergi']['pilihan']) 
              Riwayat Alergi: {{ @$soap['riwayat_alergi']['pilihan'] }}
              <br>
            @endif
            @if (@$soap['sistem_organ']['keluhan'])
              Sistem Organ (Keluhan): {{ @$soap['sistem_organ']['keluhan'] }}   
              <br>         
            @endif
            @if (@$soap['nyeri']['keadaanUmum']['pilihan'])
              Keadaan Umum: <br>
              @if (is_array(@$soap['nyeri']['keadaanUmum']['pilihan']))
                @foreach (@$soap['nyeri']['keadaanUmum']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                {{ @$soap['nyeri']['keadaanUmum']['pilihan'] ?? 'Tidak ada keluhan' }}
              @endif  
              <br>
            @endif
            @if (@$soap['nyeri']['kesadaran']['pilihan'])
              Kesadaran: <br>
              @if (is_array(@$soap['nyeri']['kesadaran']['pilihan']))
                @foreach (@$soap['nyeri']['kesadaran']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                {{ @$soap['nyeri']['kesadaran']['pilihan'] ?? 'Tidak ada keluhan' }}
              @endif  
            @endif
          </td>
          <td colspan="2">
            GCS <br>
            E: {{ @$soap['GCS']['E'] }} <br>
            M: {{ @$soap['GCS']['M'] }} <br>
            V: {{ @$soap['GCS']['V'] }} <br>
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="3" style="vertical-align: top;">
            <ol>
              <li>
                Tanda Vital<br/>
                <ul>
                  <li>TD : {{ @$soap['tanda_vital']['tekanan_darah'] }} mmHG</li>
                  <li>Nadi : {{ @$soap['tanda_vital']['nadi'] }} x/menit</li>
                  <li>RR : {{ @$soap['tanda_vital']['RR'] }} x/menit</li>
                  <li>Temp : {{ @$soap['tanda_vital']['temp'] }} °C</li>
                  <li>Berat Badan : {{ @$soap['tanda_vital']['BB'] }} Kg</li>
                  <li>Tinggi Badan : {{ @$soap['tanda_vital']['TB'] }} Cm</li>
                </ul>
              </li>
              <li>
                Muka
                <ul>
                  <li>Cloasma Gravidarum: {{ @$soap['pemeriksaanFisik']['muka']['cloasma'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>
                Mata
                <ul>
                  <li>Konjungtiva: {{ @$soap['pemeriksaanFisik']['mata']['konjungtiva'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>
                Leher
                <ul>
                  <li>Kelenjar Tiroid Pembesaran: {{ @$soap['pemeriksaanFisik']['leher']['tiroid'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Vena Juglaris Peningkatan: {{ @$soap['pemeriksaanFisik']['leher']['vena'] ?? 'Tidak ada keluhan' }}</li>
                  <li>KGB Pembesaran: {{ @$soap['pemeriksaanFisik']['leher']['kgb'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>
                Dada
                <ul>
                  <li>Payudara: {{ @$soap['pemeriksaanFisik']['dada']['payudara'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Puting Susu Menonjol: {{ @$soap['pemeriksaanFisik']['dada']['putingMenonjol'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Kolostrum: {{ @$soap['pemeriksaanFisik']['dada']['kolostrum'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Benjolan: {{ @$soap['pemeriksaanFisik']['dada']['benjolan'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Retraksi: {{ @$soap['pemeriksaanFisik']['dada']['retraksi'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
            </ol>
          </td>
          <td colspan="2" style="vertical-align: top;">
            <ol start="6">
              <li>
                Abdomen
                <ul>
                  <li>Striae Gravidarum: {{ @$soap['pemeriksaanFisik']['abdomen']['striae'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Bekas Luka Operasi: {{ @$soap['pemeriksaanFisik']['abdomen']['bekasLukaOperasi'] ?? 'Tidak ada keluhan' }}</li>
                  <li>TFU: {{ @$soap['pemeriksaanFisik']['tfu'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Leopold I: {{ @$soap['pemeriksaanFisik']['palpasi']['LI'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Leopold II: {{ @$soap['pemeriksaanFisik']['palpasi']['LII'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Leopold III: {{ @$soap['pemeriksaanFisik']['palpasi']['LIII'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Leopold IV: {{ @$soap['pemeriksaanFisik']['palpasi']['LIV'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>
                Auskultasi
                <ul>
                  <li>His: {{ @$soap['pemeriksaanFisik']['auskultasi']['his'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Durasi: {{ @$soap['pemeriksaanFisik']['auskultasi']['durasi'] ?? 'Tidak ada keluhan' }}</li>
                  <li>DJJ: {{ @$soap['pemeriksaanFisik']['auskultasi']['djj']['text'] .' '. @$soap['pemeriksaanFisik']['auskultasi']['djj']['pilihan']  }}</li>
                  <li>TBJA: {{ @$soap['pemeriksaanFisik']['auskultasi']['tbja'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>
                Saluran Kemih &amp; Genitalia
                <ul>
                  <li>Pengeluaran:  <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] as $pengeluaran)
                        - {{@$pengeluaran}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['pengeluaran']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                  <li>Kelainan: {{ @$soap['pemeriksaanFisik']['genitalia']['kelainan']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Lochea: <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['lochea']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] as $lochea)
                        - {{@$lochea}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['lochea']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                  <li>Perineum: <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['perineum']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] as $perineum)
                        - {{@$perineum}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['perineum']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                  <li>Jahitan: <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['jahitan']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] as $jahitan)
                        - {{@$jahitan}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['jahitan']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                  <li>Robekan: <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['robekan']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] as $robekan)
                        - {{@$robekan}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['robekan']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                  <li>Anus: <br>
                    @if (is_array(@$soap['pemeriksaanFisik']['genitalia']['anus']['pilihan']))
                      @foreach (@$soap['pemeriksaanFisik']['genitalia']['anus']['pilihan'] as $anus)
                        - {{@$anus}} <br>
                      @endforeach
                    @else
                      {{ @$soap['pemeriksaanFisik']['genitalia']['anus']['pilihan'] ?? 'Tidak ada keluhan' }}
                    @endif
                  </li>
                </ul>
              </li>
              <li>
                Gyonecologi
                <ul>
                  <li>Kelenjar Bartholini: {{ @$soap['pemeriksaanFisik']['gyonecologi']['kelenjarBartholini']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
                  <li>Inspekulo: {{ @$soap['pemeriksaanFisik']['gyonecologi']['inspekulo'] ?? 'Tidak ada keluhan' }}</li>
                </ul>
              </li>
              <li>Ekstremitas Atas dan Bawah: {{ @$soap['pemeriksaanFisik']['ekstremitasAtasBawah'] ?? 'Tidak ada keluhan' }}</li>
              <li>Oedem: {{ @$soap['pemeriksaanFisik']['oedem']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
              <li>Varises: {{ @$soap['pemeriksaanFisik']['varises']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
              <li>Kekuatan Otot dan Sendi: {{ @$soap['pemeriksaanFisik']['kekuatanOtot']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
              <li>Reflex: {{ @$soap['pemeriksaanFisik']['reflex']['pilihan'] ?? 'Tidak ada keluhan' }}</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
            <b>PEMERIKSAAN DALAM</b>
          </td>
          <td colspan="5" style="vertical-align: top;">
            <ol>
              <li>Vulva Vagina: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['vulvaVagina'] ?? 'Tidak ada keluhan' }}</li>
              <li>Portio: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['portio'] ?? 'Tidak ada keluhan' }}</li>
              <li>Ketuban: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['ketuban'] ?? 'Tidak ada keluhan' }}</li>
              <li>Pembukaan: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['pembukaan'] ?? 'Tidak ada keluhan' }}</li>
              <li>Presentase Fetus: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['presentaseFetus'] ?? 'Tidak ada keluhan' }}</li>
              <li>Hodge/Station: {{ @$soap['pemeriksaanFisik']['pemeriksaanDalam']['hodge'] ?? 'Tidak ada keluhan' }}</li>
            </ol>
          </td>
        </tr>

    </table>
    <br>
    <!-- <table>
        <tr>
            <td style="text-align: right !important!;">
                Dicetak Tanggal<br>
                {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
            </td>
        </tr>
    </table> -->
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
          
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
            {{@Auth::user()->name}}
        </td>
      </tr>
    </table>

  </body>
</html>
 