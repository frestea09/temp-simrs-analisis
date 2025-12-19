<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SBAR Pasien</title>
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
        * {
            font-size: 11px;
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
            font-size: 14px;
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
            <th colspan="6" style="font-size: 14px">
                <b style="font-size: 18px;">TRANSFER INTERNAL</b> <br>
                (SUMMARY LIST)
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
            <td colspan="2" style="vertical-align: top;">
                <b>Jenis Pembayaran</b> <br>
                {{ baca_carabayar($reg->bayar) }}
            </td>
            <td colspan="2" style="vertical-align: top;">
                <b>Alasan Dirawat</b> <br>
                {{ @explode('|', @$sbar->keterangan)[0] }}
            </td>
            <td colspan="2" style="vertical-align: top;">
                <b>Alasan Pindah</b> <br>
                {{@explode('|', @$sbar->keterangan)[1] }}
            </td>
        </tr>
        <tr>
            {{-- <th>Tanggal Berkunjung</th> --}}
            <th>S</th>
            <th>B</th>
            <th>A</th>
            <th>R</th>
            <th>Dialihkan Ke</th>
            <th>Penginput</th>
        </tr>
        <tr>
            <td>{{@$sbar->situation}}</td>
            <td>{{@$sbar->background}}</td>
            <td>{{@$sbar->assesment}}</td>
            <td>{{@$sbar->recomendation}}</td>
            <td>{{@$sbar->discharge}}</td>
            <td>{{@baca_user($sbar->user_id)}}</td>
        </tr>
        {{-- <tr>
            <td>
                <b>Riwayat Alergi</b>
            </td>
            <td colspan="5">
                
            </td>
        </tr>
       
        @foreach ($resume as $key => $d)
        <tr>
            <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y H:i:s') }}</td>
            <td>{!! $d->subject !!}</td>
            <td>{!! $d->object !!}</td>
            <td>{!! $d->assesment !!}</td>
            <td>{!! $d->planing !!}</td>
            <td>{!! $d->diagnosa !!}</td>
            <td>{!! $d->tindakan !!}</td>
            <td>{{ baca_dokter($reg->dokter_id) }}</td>
        </tr>
        @endforeach --}}
    </table>
    <br>
    <table>
        <tr>
            <td style="text-align: right !important!;">
                Tanggal Berkunjung<br>
                {{ \Carbon\Carbon::parse($sbar->created_at)->format('d-m-Y H:i:s') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right !important!;">
                Dicetak Tanggal<br>
                {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
            </td>
        </tr>
    </table>

    <table style="border: 0px;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                @if (isset($proses_tte) || isset($tte_nonaktif))
                    {{Auth::user()->pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat'}}
                @else
                    @if (@$pegawai->kategori_pegawai == 1)
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
            <td colspan="3" style="text-align: center; border: 0px; padding: 2rem;">
                @if (isset($proses_tte))
                    #
                @elseif (isset($tte_nonaktif))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                @endif
            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                @if (isset($proses_tte) || isset($tte_nonaktif))
                    {{Auth::user()->pegawai->nama}}
                @else
                    {{ @$pegawai->nama }}
            @endif
            </td>
        </tr>
    </table>

  </body>
</html>
