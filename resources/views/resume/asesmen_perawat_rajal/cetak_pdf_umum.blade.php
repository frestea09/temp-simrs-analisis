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
@php
    error_reporting(0);
@endphp

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
            @if (@$soap['riwayat_alergi']['pilihan']) 
              Riwayat Alergi: {{ @$soap['riwayat_alergi']['pilihan'] }}
              <br>
            @endif
            @if (@$soap['keluhan_utama'])
              Keluhan Utama: {{ @$soap['keluhan_utama'] }}   
              <br>         
            @endif
            @if (@$soap['keadaan_umum'])
              Keadaan Umum: {{ @$soap['keadaan_umum'] }}
              <br>
            @endif
            @if (@$soap['kesadaran'])
              Kesadaran: <br>
              @if (is_array(@$soap['kesadaran']['pilihan']))
                @foreach (@$soap['kesadaran']['pilihan'] as $item)
                  - {{@$item}} <br>
                @endforeach
              @else
                {{ @$soap['kesadaran'] ?? 'Tidak ada keluhan' }}
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
              <li>Pernyarafan: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['pernyarafan']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['pernyarafan']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['pernyarafan']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Pernapasan: 
                @if (is_array(@$soap['pemeriksaanFisik']['pernapasan']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['pernapasan']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['pernapasan']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Kardiovaskuler: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['kardiovaskuler']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['kardiovaskuler']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['kardiovaskuler']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Pencernaan: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['pencernaan']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['pencernaan']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['pencernaan']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Endokrin: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['endokrin']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['endokrin']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['endokrin']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Reproduksi: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['reproduksi']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['reproduksi']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['reproduksi']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Abdomen: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['abdomen']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['abdomen']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['abdomen']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Kulit: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['kulit']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['kulit']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['kulit']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              <li>Mata: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['mata']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['mata']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['mata']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
            </ol>
          </td>
          <td colspan="2" style="vertical-align: top;">
            <ol start="8">
              <li>Genetalia: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['genetalia']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['genetalia']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['genetalia']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Urinaria: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['urinaria']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['urinaria']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['urinaria']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Gigi: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['gigi']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['gigi']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['gigi']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Ekstremitas Atas: <br>
                @if (is_array($soap['pemeriksaanFisik']['ektremitasAtas']['pilihan']))
                  @foreach ($soap['pemeriksaanFisik']['ektremitasAtas']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ $soap['pemeriksaanFisik']['ektremitasAtas']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Ekstremitas Bawah: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['ektremitasBawah']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['ektremitasBawah']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['ektremitasBawah']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Muka / Wajah: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['muka']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['muka']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['muka']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Telinga: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['telinga']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['telinga']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['telinga']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Hidung: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['hidung']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['hidung']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['hidung']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Tenggorokan: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['tenggorokan']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['tenggorokan']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['tenggorokan']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
            <b>RESIKO JATUH</b>
          </td>
          <td colspan="5" style="vertical-align: top;">
            <ol>
              <li>Apakah ada riwayat jatuh dalam waktu 3 bulan sebab apapun : {{ @$soap['risikoJatuh']['riwayatJatuh']['pilihan'] == '25' ? 'Ya' : 'Tidak' }}</li>
              <li>Diagnosis sekunder (Apakah memiliki lebih dari satu penyakit) : {{ @$soap['risikoJatuh']['diagnosisSekunder']['pilihan'] == '15' ? 'Ya' : 'Tidak' }}</li>
              <li>
                Alat bantu berjalan : 
                @if (@$soap['risikoJatuh']['alatBantu']['pilihan'] == 30)
                  Dibantu perawat/tidak menggunakan alat bantu/bed rest
                @elseif(@$soap['risikoJatuh']['alatBantu']['pilihan'] == 15)
                  Menggunakan alat bantu : kruk/tongka, kursi roda
                @elseif(@$soap['risikoJatuh']['alatBantu']['pilihan'] == 0)
                  Merambat dengan berpegangan pada benda di sekitar (meja, kursi, lemari, dll)
                @endif
              </li>
              <li>
                Apakah terpasang infus/pemberian anti koagulan (heparin)/obat lain yang mempunyai efek samping risiko jatuh : 
                {{ @$soap['risikoJatuh']['efekSamping']['pilihan'] == 20 ? 'Ya' : 'Tidak' }}
              </li>
              <li>
                Kondisi untuk melakukan gerakan berpindah / mobilisasi : 
                @if (@$soap['risikoJatuh']['mobilisasi']['pilihan'] == 30)
                Ada keterbatasan berjalan (pincang, diseret)
                @elseif(@$soap['risikoJatuh']['mobilisasi']['pilihan'] == 15)
                Lemah (tidak bertenaga)
                @elseif(@$soap['risikoJatuh']['mobilisasi']['pilihan'] == 0)
                Normal/bed rest/Imobilisasi
                @endif
              </li>
              <li>
                Bagaimana Status Mental :
                {{ @$soap['risikoJatuh']['mobilisasi']['pilihan'] == 15 ? 'Tidak Menyadari kelemahannya' : 'Menyadari kelemahannya' }}
              </li>
            </ol>
          </td>
        </tr>
        {{-- <tr>
          <td colspan="2" style="vertical-align: top">
            <b>STATUS PEDIATRI</b>
            <br>
            {{ @$soap['status_pediatri']['status_gizi'] }}
            <br>
            {{ @$soap['status_pediatri']['riwayat_imunisasi'] }}
            <br>
            {{ @$soap['status_pediatri']['riwayat_tumbuh_kembang'] }}
          </td>
          <td colspan="4" style="text-align: center">
            <b>STATUS LOKALIS</b>
            <br>
            @if (@$gambar->image != null)
              <img src="{{ public_path('images/'.@$gambar->image) }}" alt="" style="width: 400px; height: 200px;">
            @else
              <h4><i>Tidak Ada Status Lokalis</i></h4>
            @endif
          </td>
        </tr> --}}
        {{-- <tr>
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
            <b>DIAGNOSIS</b>
            <br>
            {{ @$soap['diagnosis'] }}
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
        
        
        <tr>
          <td>
              <b>PLANNING</b>
          </td>
          <td colspan="5">
            {{ @$soap['planning'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>PENANGANAN PASIEN</b>
          </td>
          <td colspan="5">
            {{ @$soap['penanganan_pasien'] }}
          </td>
        </tr> --}}

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
 