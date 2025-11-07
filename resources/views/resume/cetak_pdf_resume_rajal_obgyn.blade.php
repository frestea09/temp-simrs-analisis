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

    <table>
      <tr>
        <th colspan="1">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </th>
        <th colspan="5" style="font-size: 20pt;">
          <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK OBGYN</b>
        </th>
      </tr>
      <tr>
        <td colspan="2">
          <b>TANGGAL PEMERIKSAAN</b>
        </td>
        <td colspan="4">
          {{ date('d-m-Y',strtotime(@$emrPemeriksaan->created_at)) }}
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
            - TD : {{ @$soap['tanda_vital']['tekanan_darah'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Nadi : {{ @$soap['tanda_vital']['nadi'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - RR : {{ @$soap['tanda_vital']['RR'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Temp : {{ @$soap['tanda_vital']['temp'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
            - Berat Badan : {{ @$soap['tanda_vital']['BB'] }} Kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Tinggi Badan : {{ @$soap['tanda_vital']['TB'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/><br/>
            2. Pemeriksaan Fisik Dokter : <br/>
            {{ @$soap['pemeriksaan_fisik'] }} 
          </td>
        </tr>
        @if (@$gambar->image != null)
          <tr>
            <td colspan="6" style="text-align: center;">
              <b>GAMBAR STATUS LOKALIS OBGYN</b>
              <br/><br/>
              <img src="{{ public_path('images/'.@$gambar->image) }}" alt="" style="width: 400px; height: 200px;">
              {{-- <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
            </td>
          </tr>
        @endif
        <tr>
          <td colspan="6">
            <b>PEMERIKSAAN PENUNJANG</b> <br>
              @foreach (@$rads as $rad)
              - {{ @$rad->namatarif }}<br>
              @endforeach
              @foreach (@$labs as $lab)
              - {{ @$lab->namatarif }}<br>
              @endforeach
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSIS</b>
          </td>
          <td colspan="5">
              {{ @$soap['diagnosis'] }}
          </td>
        </tr>
        <tr>
          <td colspan="3" style="vertical-align: top;">
            <b>TINDAKAN</b><br/>
            @foreach (@$folio as $tindakan)
            - {{ @$tindakan->namatarif }}<br>
            @endforeach
          </td>
          <td colspan="3" style="vertical-align: top;">
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
        <tr>
          <td>
              <b>DISCHARGE PLANNING</b>
          </td>
          <td colspan="5">
            @php
              $dischargePlanning = null;
              if (@$soap['dischargePlanning']['kontrol']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['kontrol']['dipilih'] . ', ' . @$soap['dischargePlanning']['kontrol']['waktu'];
              } elseif (@$soap['dischargePlanning']['kontrolPRB']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['kontrolPRB']['dipilih'] . ', ' . @$soap['dischargePlanning']['kontrolPRB']['waktu'];
              } elseif (@$soap['dischargePlanning']['dirawat']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['dirawat']['dipilih'] . ', ' . @$soap['dischargePlanning']['dirawat']['waktu'];
              } elseif (@$soap['dischargePlanning']['dirujuk']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['dirujuk']['dipilih'] . ', ' . @$soap['dischargePlanning']['dirujuk']['waktu'];
              } elseif (@$soap['dischargePlanning']['Konsultasi']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['Konsultasi']['dipilih'] . ', ' . @$soap['dischargePlanning']['Konsultasi']['waktu'];
              } elseif (@$soap['dischargePlanning']['pulpak']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['pulpak']['dipilih'] . ', ' . @$soap['dischargePlanning']['pulpak']['waktu'];
              } elseif (@$soap['dischargePlanning']['meninggal']['dipilih']) {
                $dischargePlanning = @$soap['dischargePlanning']['meninggal']['dipilih'] . ', ' . @$soap['dischargePlanning']['meninggal']['waktu'];
              }
            @endphp
            {{ $dischargePlanning }}
          </td>
        </tr>

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
          {{ baca_dokter($reg->dokter_id) }}
        </td>
      </tr>
    </table>
    
  </body>
</html>
 