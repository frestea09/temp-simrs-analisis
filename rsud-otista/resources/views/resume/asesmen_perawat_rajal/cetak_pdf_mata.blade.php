<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Asesmen {{ @$reg->pasien->nama }}</title>
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
          <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK MATA</b>
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
                <b>Nama Jelas DPJP</b>
            </td>
            <td colspan="5">
                {{ baca_dokter($reg->dokter_id) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Jenis Pembayaran</b>
            </td>
            <td colspan="5">
                {{ baca_carabayar($reg->bayar) }}
            </td>
        </tr>
        <tr>
          <td>
              <b>ANAMNESA</b>
          </td>
          <td colspan="3">
            @if (@$soap['riwayat_alergi']['pilihan'])
              Riwayat Alergi: {{ @$soap['riwayat_alergi']['pilihan'] }} <br>
            @endif
            @if (@$soap['keadaan_umum'])
              Keluhan Utama: {{ @$soap['keadaan_umum'] }} <br>
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
            <ol start="11">
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
              <li>Keadaan Emosional: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['keadaanEmosional']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['keadaanEmosional']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['keadaanEmosional']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif    
              </li>
              <li>Kebutuhan Edukasi: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Bicara: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['bicara']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['bicara']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['bicara']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Bahasa Sehari-Hari: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['bahasa']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['bahasa']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['bahasa']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Perlu Penerjemah: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['penerjemah']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['penerjemah']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['penerjemah']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Hambatan Edukasi: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['hambatanEdukasi']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Edukasi Yang Diberikan: <br>
                @if (is_array(@$soap['pemeriksaanFisik']['edukasi']['pilihan']))
                  @foreach (@$soap['pemeriksaanFisik']['edukasi']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['pemeriksaanFisik']['edukasi']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
            <b>STATUS PEDIATRI</b>
          </td>
          <td colspan="5" style="vertical-align: top;">
            {{ @$soap['pemeriksaanFisik']['statusGizi'] }}
            <br>
            {{ @$soap['pemeriksaanFisik']['statusPediatrik'] }}
            <br>
            {{ @$soap['pemeriksaanFisik']['riwayatImunisasi'] }}
            <br>
            {{ @$soap['pemeriksaanFisik']['riwayatTumbuh'] }}
          </td>
        </tr>
        <tr>
          
          <td colspan="6" style="text-align: center; font-size: 10pt; padding: 15px 100px 15px 100px;">
            <table style="">
              <thead>
                <tr>
                  <th colspan="3"><b>STATUS LOKALIS 1</b></th>
                </tr>
                <tr>
                  <th style="width: 40%; text-align: center; padding: 5px;">Pemeriksaan</th>
                  <th style="width: 30%; text-align: center; padding: 5px;">OD</th>
                  <th style="width: 30%; text-align: center; padding: 5px;">OS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding: 5px;">1. Pemeriksaan Visus</td>
                  <td style="padding: 5px;">{{ @$soap['pemeriksaanVisus']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['pemeriksaanVisus']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">2. Pemeriksaan Keseimbangan Posisi Bola Mata</td>
                  <td style="padding: 5px;">{{ @$soap['keseimbanganBolaMata']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['keseimbanganBolaMata']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">3. Pemeriksaan Gerak Bola Mata</td>
                  <td style="padding: 5px;">{{ @$soap['gerakBolaMata']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['gerakBolaMata']['os'] }}</td>
                </tr>
                @if (@$gambar1->image != null)
                  <tr>
                    <td colspan="3" style="text-align: center;">
                      <img src="{{ public_path('images/'.@$gambar1->image) }}" alt="" style="height: 240px;">
                    </td>
                  </tr>
                @endif
                <tr>
                  <td style="padding: 5px;">4. Pemeriksaan Tekanan Intraocular</td>
                  <td style="padding: 5px;">{{ @$soap['tekananIntraocular']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['tekananIntraocular']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">5. Pemeriksaan Segmen Anterior</td>
                  <td style="padding: 5px;">{{ @$soap['segmenAnterior']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['segmenAnterior']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">a. Palpebra</td>
                  <td style="padding: 5px;">{{ @$soap['palpebra']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['palpebra']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">b. Konjungtiva</td>
                  <td style="padding: 5px;">{{ @$soap['konjungtiva']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['konjungtiva']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">c. Kornea</td>
                  <td style="padding: 5px;">{{ @$soap['kornea']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['kornea']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">d. Bilik Mata Depan</td>
                  <td style="padding: 5px;">{{ @$soap['bilikMataDepan']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['bilikMataDepan']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">e. Iris</td>
                  <td style="padding: 5px;">{{ @$soap['iris']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['iris']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">f. Pupil</td>
                  <td style="padding: 5px;">{{ @$soap['pupil']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['pupil']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px 5px 5px 15px;">g. Lensa</td>
                  <td style="padding: 5px;">{{ @$soap['lensa']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['lensa']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">6. Pemeriksaan Lapang Pandang</td>
                  <td style="padding: 5px;">{{ @$soap['lapangPandang']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['lapangPandang']['os'] }}</td>
                </tr>
                <tr>
                  <td style="padding: 5px;">7. Pemeriksaan Funduskopi</td>
                  <td style="padding: 5px;">{{ @$soap['funduskopi']['od'] }}</td>
                  <td style="padding: 5px;">{{ @$soap['funduskopi']['os'] }}</td>
                </tr>
                
              </tbody>
            </table>
          </td>
        </tr>
        @if (@$gambar2->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              <b>GAMBAR STATUS LOKALIS 2</b>
              <br/><br/><br>

              <img src="{{ public_path('images/'.@$gambar2->image) }}" alt="" style="width: 400px; height: 150px;">
              <br><br>
              {{ @$soap['lokalis2']['keterangan'] }}
              {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            </td>
          </tr>
        @endif
        @if (@$gambar3->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              <b>GAMBAR STATUS LOKALIS 3</b>
              <br/><br/><br>
              <img src="{{ public_path('images/'.@$gambar3->image) }}" alt="" style="width: 400px; height: 150px;">
              <br><br>
              {{ @$soap['lokalis3']['keterangan'] }}
              {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            </td>
          </tr>
        @endif
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
        </tr> --}}
        <tr>
          <td>
            <b>Fungsional</b>
          </td>
          <td colspan="5" style="">
            <ol>
              <li>Alat Bantu: {{ @$soap['fungsional']['alatBantu']['pilihan'] }}</li>
              <li>Protesa: {{ @$soap['fungsional']['protesa']['pilihan'] }}</li>
              <li>Cacat Tubuh: {{ @$soap['fungsional']['cacatTubuh']['pilihan'] }}</li>
              <li>Activity of Daily Living (ADL): {{ @$soap['fungsional']['adl']['pilihan'] }}</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
              <b>Nyeri</b>
          </td>
          <td colspan="5">
            <ol>
              <li>Nyeri: {{ @$soap['nyeri']['pilihan'] }}</li>
              <li>Provokatif: {{ @$soap['nyeri']['provokatif']['pilihan'] }}</li>
              <li>Quality: <br>
                @if (is_array(@$soap['nyeri']['quality']['pilihan']))
                  @foreach (@$soap['nyeri']['quality']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['nyeri']['quality']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
              <li>Region: {{ @$soap['nyeri']['region']['pilihan'] }}</li>
              <li>Severity: {{ @$soap['nyeri']['severity']['pilihan'] }}</li>
              <li>Time / Durasi (Menit): {{ @$soap['nyeri']['durasi'] }}</li>
              <li>Nyeri Hilang Jika: <br>
                @if (is_array(@$soap['nyeri']['nyeri_hilang']['pilihan']))
                  @foreach (@$soap['nyeri']['nyeri_hilang']['pilihan'] as $item)
                    - {{@$item}} <br>
                  @endforeach
                @else
                  {{ @$soap['nyeri']['nyeri_hilang']['pilihan'] ?? 'Tidak ada keluhan' }}
                @endif  
              </li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
              <b>Resiko Jatuh</b>
          </td>
          <td colspan="5">
            <ol>
              <li>Apakah ada riwayat jatuh dalam waktu 3 bulan sebab apapun: 
                @if(@$soap['risikoJatuh']['riwayatJatuh']['pilihan'] == '25')
                Ya
                @elseif(@$soap['risikoJatuh']['riwayatJatuh']['pilihan'] == '0')
                Tidak
                @endif 
              </li>
              <li>Diagnosis sekunder : Apakah memiliki lebih dari satu penyakit: 
                @if(@$soap['risikoJatuh']['diagnosisSekunder']['pilihan'] == '15')
                Ya
                @elseif(@$soap['risikoJatuh']['diagnosisSekunder']['pilihan'] == '0')
                Tidak
                @endif 
              </li>
              <li>Alat bantu berjalan: 
                @if(@$soap['risikoJatuh']['alatBantu']['pilihan'] == '30')
                Merambat dengan berpegangan pada benda di sekitar (meja, kursi, lemari, dll)
                @elseif(@$soap['risikoJatuh']['alatBantu']['pilihan'] == '15')
                  Menggunakan alat bantu : kruk/tongka, kursi roda
                @elseif(@$soap['risikoJatuh']['alatBantu']['pilihan'] == '0')
                  Dibantu perawat/tidak menggunakan alat bantu/bed rest
                @endif
              </li>
              <li>Apakah terpasang infus/pemberian anti koagulan (heparin)/obat lain yang mempunyai efek samping risiko jatuh: 
                @if(@$soap['risikoJatuh']['statusMental']['pilihan'] == '20')
                Ya
                @elseif(@$soap['risikoJatuh']['statusMental']['pilihan'] == '0')
                Tidak
                @endif 
              </li>
              <li>Kondisi untuk melakukan gerakan berpindah / mobilisasi: 
                @if(@$soap['risikoJatuh']['mobilisasi']['pilihan'] == '30')
                  Ada keterbatasan berjalan (pincang, diseret)
                @elseif(@$soap['risikoJatuh']['mobilisasi']['pilihan'] == '15')
                  Lemah (tidak bertenaga)
                @elseif(@$soap['risikoJatuh']['mobilisasi']['pilihan'] == '0')
                  Normal/bed rest/Imobilisasi
                @endif
              </li>
              <li>Bagaimana Status Mental:
                @if(@$soap['risikoJatuh']['statusMental']['pilihan'] == '15')
                Tidak menyadari kelemahannya
                @elseif(@$soap['risikoJatuh']['statusMental']['pilihan'] == '0')
                Menyadari kelemahannya
                @endif 
              </li>
            </ol>
          </td>
        </tr>
    </table>

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
          {{ Auth::user()->name }}
        </td>
      </tr>
    </table>
    

  </body>
</html>
 