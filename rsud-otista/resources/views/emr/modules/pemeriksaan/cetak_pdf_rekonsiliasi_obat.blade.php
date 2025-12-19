<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Penelusuran Obat</title>
    <style>
        * {
          font-size: 11px;
        }
        table{
          width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 8px;
            /* text-align: left; */
        }
        @page {
            padding-bottom: 2cm;
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
        .no-border, .no-border td, .no-border th {
            border: none !important;
        }
    </style>
  </head>
  <body>

    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    @php 
      $rekonsiliasi = is_array($assesment['rekonsiliasi'] ?? null) ? $assesment['rekonsiliasi'] : [];
      $obatAlergi = is_array($assesment['obatAlergi'] ?? null) ? $assesment['obatAlergi'] : [];
      $no = 1;
    @endphp
    <table style="border: none !important; width:100%;font-size:12px;"> 
        <tr>
          <td style="width:10%; text-align: center; width: 30%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 25px;"> <br>
            <b style="font-size:8px;">RSUD OTO ISKANDAR DINATA</b><br/>
            <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
            <b style="font-size:6px; font-weight:normal;"> {{ configrs()->tlp }}</b><br/>
            <b style="font-size:6px; font-weight:normal;"> Laman : {{ configrs()->website }} <span style="font-size:5px; margin-left:5px">Email : {{ configrs()->email }}</span></b><br/>
          </td>
          <td style="text-align: center; width: 30%; vertical-align: middle;">
              <h2 class="text-center" style="margin-top: 0rem; vertical-align: middle;">FORMULIR PENELUSURAN OBAT</h2>
              <h2 class="text-center" style="margin-top: 0rem; vertical-align: middle;">(REKONSILIASI)</h2>
          </td>
          <td style="width: 40%; vertical-align: top; padding: 15px;">
            <div>
                <div>
                    No RM : {{@$reg->pasien->no_rm}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Nama : {{@$reg->pasien->nama}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Tgl. Lahir : {{@$reg->pasien->tgllahir}} <br>
                </div>
                <div style="margin-top: .5rem; margin-bottom: .5rem;">
                    Tgl. Masuk : {{@$reg->created_at}} <br>
                </div>
            </div>
          </td>
        </tr>
    </table>
    <table style="width: 100%; text-align: center;" class="border">
      <thead>
        <tr class="border">
          <th rowspan="2" class="border bold" style="width: 5%;">NO</th>
          <th rowspan="2" class="border bold">Nama Obat</th>
          <th rowspan="2" class="border bold">Dosis</th>
          <th rowspan="2" class="border bold">Frekuensi</th>
          <th rowspan="2" class="border bold">Alasan Makan Obat</th>
          <th colspan="2" class="border bold">Obat Dilanjutkan</th>
        </tr>
        <tr class="border">
          <th class="border bold" style="width: 10%;">Ya</th>
          <th class="border bold" style="width: 10%;">Tidak</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($rekonsiliasi as $r_obat)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$r_obat['nama_obat'] }}</td>
                <td>{{ @$r_obat['dosis'] }}</td>
                <td>{{ @$r_obat['frekuensi'] }}</td>
                <td>{{ @$r_obat['alasan_makan'] }}</td>
                <td style="text-align: center; font-family: 'DejaVu Sans';">
                  @if (($r_obat['obat_dilanjutkan'] ?? '') === 'YA')
                    &#10004;
                  @endif
                </td>
                <td style="text-align: center; font-family: 'DejaVu Sans';">
                  @if (($r_obat['obat_dilanjutkan'] ?? '') === 'TIDAK')
                    &#10004;
                  @endif
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <br><br>
    <table style="width: 100%; text-align: center;" class="border">
      <thead>
        <tr class="border">
          <th class="border bold" style="width: 5%;">NO</th>
          <th class="border bold">Daftar Obat yang Menimbulkan Alergi</th>
          <th class="border bold">Tingkat Alergi</th>
          <th class="border bold">Reaksi Alergi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($obatAlergi as $a_obat)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$a_obat['nama_obat'] }}</td>
                <td>{{ @$a_obat['tingkat_alergi'] }}</td>
                <td>{{ @$a_obat['reaksi_alergi'] }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <br>
    <span>*Ringan / Sedang / Berat</span> <br>
    <span>Semua Jenis Obat (Obat Resep, Bebas, Herbal)</span>
    <br><br>
    <table style="width: 100%; text-align: center;" class="no-border">
      <tr>
        <td style="width: 50%;">&nbsp;</td>
        <td style="width: 50%;">Soreang, {{ \Carbon\Carbon::parse($assesments->created_at)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="width: 50%;">Apoteker</td>
        <td style="width: 50%;">Dokter</td>
      </tr>
      <tr>
        <td>
            {{-- @if (isset($proses_tte))
            <br><br><br>
              #
            <br><br><br>
            @elseif (isset($tte_nonaktif)) --}}
            @php
              $apoteker = Modules\Pegawai\Entities\Pegawai::find(409); // Apt. Adiyah, S.Farm., MM.RS
              $base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($apoteker->nama . ' | ' . $apoteker->nip));
            @endphp
              <img src="data:image/png;base64, {!! $base64 !!} ">
            {{-- @else
              <br><br>
            @endif --}}
        </td>
        <td>
            {{-- @if (isset($proses_tte))
            <br><br><br>
              #
            <br><br><br>
            @elseif (isset($tte_nonaktif)) --}}
            @php
              $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
            @endphp
              <img src="data:image/png;base64, {!! $base64 !!} ">
            {{-- @else
              <br><br>
            @endif --}}
        </td>
      </tr>
      <tr>
        <td>{{@$apoteker->nama}}</td>
        <td>{{@$dokter->nama}}</td>
      </tr>
    </table>
  </body>
</html>
 