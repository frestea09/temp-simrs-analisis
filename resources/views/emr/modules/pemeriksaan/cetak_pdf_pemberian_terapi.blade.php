<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pemberian Terapi</title>
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
    <table style="width: 100%;" class="no-border"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          {{-- <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;"> --}}
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          {{-- <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}

        </td>
      </tr>
    </table>
    <br><br>
    <table style="width: 100%; text-align: center;" class="border">
      <tr class="border">
          <td class="border bold" rowspan="3">NO</td>
          <td class="border bold" rowspan="3">NAMA OBAT (TULISKAN NAMA DAN DOSIS LENGKAP)</td>
          <td class="border bold" rowspan="3">CARA DAN FREKUENSI PEMBERIAN</td>
          <td class="border bold" colspan="17">TANGGAL</td>
          <td class="border bold" rowspan="3">KET</td>
      </tr>
      <tr class="border">
          <td class="border bold" rowspan="2">WAKTU/PETUGAS</td>
          <td class="border" colspan="4">
              {{@$assesment['tanggal_1']['tanggal']}}
          </td>
          <td class="border" colspan="4">
              {{@$assesment['tanggal_2']['tanggal']}}
          </td>
          <td class="border" colspan="4">
              {{@$assesment['tanggal_3']['tanggal']}}
          </td>
          <td class="border" colspan="4">
              {{@$assesment['tanggal_4']['tanggal']}}
          </td>
      </tr>
      <tr class="border">
          <td class="border bold">I</td>
          <td class="border bold">II</td>
          <td class="border bold">III</td>
          <td class="border bold">IV</td>
          <td class="border bold">I</td>
          <td class="border bold">II</td>
          <td class="border bold">III</td>
          <td class="border bold">IV</td>
          <td class="border bold">I</td>
          <td class="border bold">II</td>
          <td class="border bold">III</td>
          <td class="border bold">IV</td>
          <td class="border bold">I</td>
          <td class="border bold">II</td>
          <td class="border bold">III</td>
          <td class="border bold">IV</td>
      </tr>

      @for ($i = 1; $i <= 15; $i++)
          <tr class="border">
              <td class="border  bold" rowspan="2">{{$i}}</td>
              <td class="border" rowspan="2">
                  {{@$assesment['pemberian_terapi'][$i]['nama_obat']}}
              </td>
              <td class="border" rowspan="2">
                  {{@$assesment['pemberian_terapi'][$i]['frekuensi_pemberian']}}
              </td>
              <td class="border bold">JAM</td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['4']}}
              </td>
              <td rowspan="2">
                  {{@$assesment['pemberian_terapi'][$i]['keterangan']}}
              </td>
          </tr>

          <tr class="border">
              <td class="border bold">NAMA</td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['4']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['1']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['2']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['3']}}
              </td>
              <td class="border">
                  {{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['4']}}
              </td>
          </tr>
      @endfor
    </table>
    <br><br>
    <table style="width: 100%; text-align: center;" class="no-border">
      <tr>
        <td style="width: 50%;">Perawat</td>
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
              $perawat = Modules\Pegawai\Entities\Pegawai::where('user_id', $assesments->user_id)->first();
              $base64  = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($perawat->nama . ' | ' . $perawat->nip));
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
        <td>{{baca_user(@$assesments->user_id)}}</td>
        <td>{{@$dokter->nama}}</td>
      </tr>
    </table>
    <br>
    <table style="width: 100%; text-align: center;" class="no-border">
      <tr>
        <td>Apoteker</td>
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
              $base64   = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($apoteker->nama . ' | ' . $apoteker->nip));
            @endphp
              <img src="data:image/png;base64, {!! $base64 !!} ">
            {{-- @else
              <br><br>
            @endif --}}
        </td>
      </tr>
      <tr>
        <td>{{@$apoteker->nama}}</td>
      </tr>
    </table>
  </body>
</html>
 