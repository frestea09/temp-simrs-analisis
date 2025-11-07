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
          <td colspan="5" style="vertical-align: top;">
            Tanda Vital<br/>
            <ul>
              <li>TD : {{ @$soap['tanda_vital']['tekanan_darah'] }} mmHG</li>
              <li>Nadi : {{ @$soap['tanda_vital']['nadi'] }} x/menit</li>
              <li>RR : {{ @$soap['tanda_vital']['RR'] }} x/menit</li>
              <li>Temp : {{ @$soap['tanda_vital']['temp'] }} °C</li>
              <li>Berat Badan : {{ @$soap['tanda_vital']['BB'] }} Kg</li>
              <li>Tinggi Badan : {{ @$soap['tanda_vital']['TB'] }} Cm</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td><b>STATUS MENTAL</b></td>
          <td colspan="3" style="vertical-align: top;">
            <ol>
              <li>Penampilan: {{ @$soap['statusMental']['penampilan']['pilihan'] }}</li>
              <li>Pembicaraan: {{ @$soap['statusMental']['pembicaraan']['pilihan'] }}</li>
              <li>Aktivitas Motoric: {{ @$soap['statusMental']['aktivitasMotoric']['pilihan'] }}</li>
              <li>Alam Perasaan: {{ @$soap['statusMental']['alamPerasaan']['pilihan'] }}</li>
              <li>Afek: {{ @$soap['statusMental']['afek']['pilihan'] }}</li>
              <li>Interaksis Elama Wawancara: {{ @$soap['statusMental']['interaksis']['pilihan'] }}</li>
              <li>Persepsi / Halusinasi: {{ @$soap['statusMental']['persepsi']['pilihan'] }}</li>
              <li>Proses Pikir: {{ @$soap['statusMental']['prosesPikir']['pilihan'] }}</li>
            </ol>
          </td>
          <td colspan="2" style="vertical-align: top;">
            <ol start="9">
              <li>Isi Pikir: {{ @$soap['statusMental']['isiPikir']['pilihan'] }}</li>
              <li>Waham: {{ @$soap['statusMental']['waham']['pilihan'] }}</li>
              <li>Tingkat Kesadaran: {{ @$soap['statusMental']['tingkatKesadaran']['pilihan'] }}</li>
              <li>Disorientasi: {{ @$soap['statusMental']['disorientasi']['pilihan'] }}</li>
              <li>Memori: {{ @$soap['statusMental']['memori']['pilihan'] }}</li>
              <li>Tingkat Konsentrasi dan Berhitung: {{ @$soap['statusMental']['tingkatKonsentrasi']['pilihan'] }}</li>
              <li>Muka / Wajah: {{ @$soap['statusMental']['kemampuanPenilaian']['pilihan'] }}</li>
              <li>Telinga: {{ @$soap['statusMental']['dayaTarikDiri']['pilihan'] }}</li>
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
          {{ @Auth::user()->name }}
        </td>
      </tr>
    </table>

  </body>
</html>
 