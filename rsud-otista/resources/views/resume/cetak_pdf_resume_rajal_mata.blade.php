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
          <td colspan="5">
              {{ @$soap['anamnesa'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5">
            1. Tanda Vital <br/>
            - TD : {{ @$soap['tanda_vital']['tekanan_darah1']['sebutkan'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Nadi : {{ @$soap['tanda_vital']['nadi']['sebutkan'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - RR : {{ @$soap['tanda_vital']['RR']['sebutkan'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Temp : {{ @$soap['tanda_vital']['temp']['sebutkan'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
            - Berat Badan : {{ @$soap['tanda_vital']['BB']['sebutkan'] }} Kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Tinggi Badan : {{ @$soap['tanda_vital']['TB']['sebutkan'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/><br/>
            2. Pemeriksaan Fisik Dokter : <br/>
            {{ @$soap['pemeriksaan_fisik'] }} 
          </td>
        </tr>
        <tr>
          <td>
            <b>STATUS PEDIATRI</b>
          </td>
          <td colspan="5" style="vertical-align: top;">
            {{ @$soap['status_pediatri']['status_gizi'] }}
            <br>
            {{ @$soap['status_pediatri']['riwayat_imunisasi'] }}
            <br>
            {{ @$soap['status_pediatri']['riwayat_tumbuh_kembang'] }}
          </td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: center; font-size: 10pt; padding: 15px 100px 15px 100px;">
            <table style="">
              <thead>
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
          <td>
            <b>DIAGNOSA</b>
          </td>
          <td colspan="5" style="">
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
        </tr>
        @if (@$gambar1->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              @if (@$gambar1->image != null)
                        <img src="{{ public_path('images/'.@$gambar1->image) }}" alt="" style="height: 520px;">
              @endif
            </td>
          </tr>
        @endif

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
          
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_dokter($reg->dokter_id) }}
        </td>
      </tr>
    </table>
    

  </body>
</html>
 