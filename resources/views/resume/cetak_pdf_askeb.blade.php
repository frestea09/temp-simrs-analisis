<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Askeb {{ $reg->pasien->nama }} ({{ $reg->pasien->no_rm }})</title>
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
          padding-bottom: 1cm;
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
          <th colspan="5" style="font-size: 18pt;">
            <b>ASUHAN KEBIDANAN</b>
          </th>
        </tr>
        <tr>
          <td colspan="6">
            Tanggal Pemeriksaan : {{ date('d-m-Y',strtotime(@$askeb->created_at)) }}
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
              <b>DIAGNOSA</b>
          </td>
          <td colspan="5">
            @if (@$diagnosis != null)
              @foreach (@$diagnosis as $diagnosa)
              - {{ $diagnosa }} <br>
              @endforeach
            @else
              <i>Belum Ada Yang Dipilih</i>
            @endif
          </td>
        </tr>

        <tr>
          <td>
            <b>INTERVENSI</b>
          </td>
          <td colspan="5" style="vertical-align: top;">
            @if (@$siki != null)
              @foreach (@$siki as $intervensi)
              - {{ $intervensi }} <br>
              @endforeach
            @else
              <i>Belum Ada Yang Dipilih</i>
            @endif
          </td>
        </tr>
        
        
        <tr>
          <td>
              <b>IMPLEMENTASI</b>
          </td>
          <td colspan="5">
            @if (@$implementasi != null)
              @foreach (@$implementasi as $item)
              - {{ $item }} <br>
              @endforeach
            @else
              <i>Belum Ada Yang Dipilih</i>
            @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>Tindakan</b>
          </td>
          <td colspan="5">
            @if (@$tindakan != null)
              @foreach (@$tindakan as $item)
                @if ($item !== 'null')
                  - {{ $item }} <br>  
                @endif
              @endforeach
            @else
              <i> </i>
            @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>Evaluasi</b>
          </td>
          <td colspan="5">
            {{@$askeb->evaluasi}}
          </td>
        </tr>
    </table>

    <br>

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
        <td colspan="3" style="text-align: center; border: 0px; margin: 0; padding: 0;">
          @if (isset($proses_tte))
          <span style="margin-left: 1rem;">
            <br>
            #
            <br>
          </span>
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
          {{ baca_user($askeb->user_id) }}
        </td>
      </tr>
    </table>

  </body>
</html>
 