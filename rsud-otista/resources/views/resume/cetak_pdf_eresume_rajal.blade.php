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

        .page_break_after{
          page-break-after: always;
        }
    </style>
  </head>
  <body>
    @if (isset($cetak_tte))
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
            <b>ASESMEN RAWAT JALAN</b>
          </th>
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
              @if (isset($tipe))
                @if ($tipe == "dokter")
                  {{ @json_decode(@$soap->fisik, true)['anamnesa'] }}
                @elseif ($tipe == "perawat")
                  {{ @json_decode(@$soap->fisik, true)['keluhan_utama'] }}
                @endif
              @else
                {{ @json_decode(@$soap->fisik, true)['anamnesa'] }}
              @endif
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5">
              {{ @json_decode(@$soap->fisik, true)['pemeriksaan_fisik'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>DIAGNOSA</b>
          </td>
          <td colspan="5">
              {{ @json_decode(@$soap->fisik, true)['diagnosis'] }}
          </td>
        </tr>
        <tr>
          <td colspan="3" style="vertical-align: top;">
              <b>PENGOBATAN</b><br/>
              @foreach (@$obats as $obat)
              - {{ substr(strtoupper(baca_obat(@$obat->masterobat_id)), 0, 40) }}<br>
              @endforeach
          </td>
          <td colspan="3" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              @foreach (@$folio as $tindakan)
              - {{ @$tindakan->namatarif }}<br>
              @endforeach
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN PENUNJANG</b>
          </td>
          <td colspan="5">
            @foreach (@$rads as $rad)
            - {{ @$rad->namatarif }}<br>
            @endforeach
            @foreach (@$labs as $lab)
            - {{ @$lab->namatarif }}<br>
            @endforeach
          </td>
        </tr>
    </table>
    <div class="page_break_after"></div>
    <table>
      <tr>
        <td>
            <b>PLANNING</b>
        </td>
        <td colspan="5">
          {{ @json_decode(@$soap->fisik, true)['planning'] }}
          @if (count(@$eresep) > 0)
          <br/>
          @foreach (@$eresep as $items)
            @foreach (@$items->resep_detail as $v)
              - {{@$v->logistik_batch->master_obat->nama}}({{@$v->qty}})
            @endforeach
          @endforeach
          @endif
        </td>
      </tr>
    </table>
    <br>
    <table>
      <tr>
          <td style="text-align: right !important!;">
              Waktu Pengisian<br>
              {{ date('d-m-Y H:i',strtotime($soap->created_at)) }}
          </td>
      </tr>
  </table>
    <table style="border: 0px; margin-top: 3rem;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          
          @if (isset($tipe))
            @if ($tipe == "dokter")
              Dokter
            @elseif ($tipe == "perawat")
              Perawat
            @endif
          @else
            @if (str_contains(baca_user($soap->user_id),'dr.'))
                Dokter
            @else
                Perawat
            @endif
          @endif
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          @if (isset($cetak_tte))
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
          @if (isset($tipe))
            @if ($tipe == "dokter")
              {{baca_user($soap->userdokter_id)}}
            @elseif ($tipe == "perawat")
              {{baca_user($soap->user_id)}}
            @endif
          @else
            {{baca_user($soap->user_id)}}
          @endif
        </td>
      </tr>
    </table>
    {{-- @if (isset($cetak_tte))
      <table style="border: none; position: absolute; top: 580px;">
        <thead>
          <tr style="border: none">
            <th style="border: 0px;"></th>
            <th style="border: 0px;"></th>
            <th style="border: 0px;"></th>
            <th style="border: 0px;"></th>
            <th style="border: 0px;"></th>
          </tr>
        </thead>
        <tbody style="">
          <tr style="border: 0px;">
            <td colspan="1" style="border: 0px;">
                <img style="width: 120px;" src="{{asset('balai-sertifikat-elektronik.png')}}" alt="logo-balai-sertifikat">
            </td>
            <td colspan="5" style="border: 0px;">
              <p>
                Dokumen ini ditandatangani secara elektronik menggunakan Sertifikat Elektronik yang diterbitkan BSrE-BSSN. 
                UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil 
                cetakannya merupakan alat bukti hukum yang sah."
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    @endif --}}
  </body>
</html>
 