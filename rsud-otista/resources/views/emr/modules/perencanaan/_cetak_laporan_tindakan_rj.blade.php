<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tindakan Rawat Jalan AN {{@$pasien->nama}}</title>
    <style>
        table, td{
            border: 1px solid black;
            border-collapse: collapse
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
<body onload="window.print()">
    @if (isset($proses_tte))
        <div class="footer">
            Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif
    <table style="width: 100%">
        <tr>
            <td style="width: 20%; text-align:center; " >
                {{-- <img src="{{ public_path('images/' . configrs()->logo) }}" alt="logo" style="width: 80px;margin: 10px 5px"> --}}
                <img src="{{ asset('images/' . configrs()->logo) }}"style="width: 80px;margin: 10px 5px">
            </td>
            <td style="width: 40%; font-weight:bold;font-size:20px;text-align:center">LAPORAN TINDAKAN RAWAT JALAN</td>
            <td style="width: 40%;padding: 5px">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">NORM : </span> {{@$pasien->no_rm}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">NAMA : </span> {{@$pasien->nama}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">TGL LAHIR : </span> {{date('d-m-Y', strtotime(@$pasien->tgllahir))}} 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px">
                <span style="font-weight: bold">Tanggal Tindakan : </span> {{ @$cetak->tgl_tindakan ? date('d-m-Y', strtotime(@$cetak->tgl_tindakan)) : '-'}}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px; text-align: center;font-weight:bold"> Uraian Tindakan </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px;">{{@$cetak->uraian_tindakan}}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 70%; padding: 5px">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Diagnosa : </span> {{@$cetak->diagnosa}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Tindakan : </span> {{@$cetak->tindakan}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Jaringan yang dieksisi : </span> {{@$cetak->jaringanEksisi}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Dikirim ke PA : </span> {{@$cetak->sendToPA}} 
                </div>
            </td>
            <td style="width: 30%; padding: 5px">
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Dokter : </span> {{baca_dokter(@$cetak->dokter)}} 
                </div>
                <div style="padding: 3px 0">
                    <span style="font-weight: bold">Asisten : </span> {{baca_pegawai(@$cetak->asisten)}} 
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 5px; text-align: center;font-weight:bold"> Instruksi Post Tindakan </td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px;">{{@$cetak->instruksi}}</td>
        </tr>
    </table>
    <table width="100%" style="border-collapse: collapse; border: 0px solid black !important">
        <tr>
            <td style="border: 0px solid black !important; text-align: center" width="35%">
                @if (@$ttd)
                    Tanda Tangan Pasien
                @endif
            </td>
            <td style="border: 0px solid black !important" width="35%">&nbsp;</td>
            <td style="border: 0px solid black !important; text-align: center;">
                <p style="">Tanda Tangan Dokter</p>
            </td>
        </tr>
        <tr>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important">&nbsp;</td>
        </tr>
        <tr>
            <td style="border: 0px solid black !important; text-align: center;">
                @if (@$ttd)
                    <img src="{{asset('images/upload/ttd/' . $ttd->tanda_tangan)}}" alt="ttd" width="200" height="100">
                @endif
            </td>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important; text-align: center;">
                {{-- @if (isset($proses_tte))
                    #
                @elseif (isset($tte_nonaktif)) --}}
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$dokter->nama . ' | ' . @$dokter->nip));
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                {{-- @else
                    &nbsp;
                @endif --}}
            </td>
        </tr>
        <tr>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important">&nbsp;</td>
        </tr>
        <tr>
            <td style="border: 0px solid black !important; text-align: center;">
                @if (@$ttd)
                    <p>{{$pasien->nama}}</p>
                @endif
            </td>
            <td style="border: 0px solid black !important">&nbsp;</td>
            <td style="border: 0px solid black !important; text-align: center;">
                @if (isset($proses_tte) || isset($tte_nonaktif))
                    <p style="">{{Auth::user()->pegawai->nama}}</p>
                @else
                    <p style="">{{@$dokter->nama}}</p>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>