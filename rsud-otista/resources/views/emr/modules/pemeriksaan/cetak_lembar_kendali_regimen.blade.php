<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Lembar Kendali Regimen Kemoterapi</title>
    <style>
        @page {
        margin: 20px;
        }

        body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        }

        h5 {
        text-align: center;
        margin: 10px 0;
        font-size: 14px;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        }

        .table th,
        .table td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        vertical-align: middle;
        font-size: 11px;
        }

        .table thead th {
        background: #f5f5f5;
        font-weight: bold;
        }

        .no-border td {
        border: none !important;
        text-align: left;
        font-size: 12px;
        padding: 2px 4px;
        }

        .no-border-table {
            border: none;
            border-collapse: collapse;
            width: 100%;
        }

        .no-border-table td {
            border: none !important;
            padding: 2px 4px;
            text-align: left;
            vertical-align: top;
        }

        tr { page-break-inside: avoid; }
    </style>
    </head>
    <body>
    @php
        $laporans = @json_decode(@$laporan->fisik, true);
        $hours = array_merge(range(7,24), range(1,6));
    @endphp

    <table class="table" style="width: 100%;"> 
        <tr>
            <td style="width: 50%; padding: 5px;">
                <table class="no-border-table">
                    <tr>
                        <td style="text-align: center;">
                            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 90px;">
                        </td>
                        <td style="text-align: center;">
                            <b style="font-size:16px;">PEMERINTAH KABUPATEN BANDUNG</b> <br>
                            <b style="font-size:16px;">RSUD OTO ISKANDAR DINATA</b> <br>
                            <b style="font-size:12px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
                            <b style="font-size:12px; font-weight:normal;">Telp : {{ configrs()->tlp }}</b><br/>
                            <b style="font-size:12px; font-weight:normal;">Email : {{ configrs()->email }}</b><br/>
                        </td>
                    </tr>
                </table>               
            </td>
            <td style="width:30%; vertical-align: top;">
                <table class="no-border-table" style="width: 100%; padding: 5px; margin-top: 10px;">
                    <tr>
                        <td style="width: 40%;">Nomor RM</td>
                        <td style="width: 60%;">: {{@$reg->pasien->no_rm}}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{@$reg->pasien->nama}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{@$reg->pasien->tgllahir}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ @$reg->pasien->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Alergi</td>
                        <td>: </td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%; vertical-align: top;">
                <span style="font-size: 8px;">RENCANA REGIMEN KEMOTERAPI DOSIS/M³ (LPT)</span>
                <table style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th style="text-align:center; width: 50%;">Regimen</th>
                        <th style="text-align:center; width: 50%;">Dosis</th>
                    </tr>
                    <tr>
                        <td style="height: 60px;"></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <h3 style="text-align: center;"><u>JADWAL KEMOTERAPI</u></h3>
    <!-- Tabel Intake Output -->
    <table class="table table-striped table-bordered table-hover table-condensed text-center" style="font-size:15px; width:100%;">
        <tr>
            <td>SIKLUS KE</td>
            <td colspan="2">{{ @$laporans['siklus1'] }}</td>
            <td colspan="2">{{ @$laporans['siklus2'] }}</td>
            <td colspan="2">{{ @$laporans['siklus3'] }}</td>
            <td colspan="2">{{ @$laporans['siklus4'] }}</td>
            <td colspan="2">{{ @$laporans['siklus5'] }}</td>
            <td colspan="2">{{ @$laporans['siklus6'] }}</td>
        </tr>
        <tr>
            <td>HARI KE</td>
            <td colspan="2">{{ @$laporans['hari1'] }}</td>
            <td colspan="2">{{ @$laporans['hari2'] }}</td>
            <td colspan="2">{{ @$laporans['hari3'] }}</td>
            <td colspan="2">{{ @$laporans['hari4'] }}</td>
            <td colspan="2">{{ @$laporans['hari5'] }}</td>
            <td colspan="2">{{ @$laporans['hari6'] }}</td>
        </tr>
        <tr>
            <td>TANGGAL</td>
            <td colspan="2">{{ @$laporans['tgl1'] }}</td>
            <td colspan="2">{{ @$laporans['tgl2'] }}</td>
            <td colspan="2">{{ @$laporans['tgl3'] }}</td>
            <td colspan="2">{{ @$laporans['tgl4'] }}</td>
            <td colspan="2">{{ @$laporans['tgl5'] }}</td>
            <td colspan="2">{{ @$laporans['tgl6'] }}</td>
        </tr>
        <tr>
            <td>BERAT BADAN</td>
            <td colspan="2">{{ @$laporans['berat1'] }}</td>
            <td colspan="2">{{ @$laporans['berat2'] }}</td>
            <td colspan="2">{{ @$laporans['berat3'] }}</td>
            <td colspan="2">{{ @$laporans['berat4'] }}</td>
            <td colspan="2">{{ @$laporans['berat5'] }}</td>
            <td colspan="2">{{ @$laporans['berat6'] }}</td>
        </tr>
        <tr>
            <td>LUAS PERMUKAAN TUBUH</td>
            <td colspan="2">{{ @$laporans['luasPermukaan1'] }}</td>
            <td colspan="2">{{ @$laporans['luasPermukaan2'] }}</td>
            <td colspan="2">{{ @$laporans['luasPermukaan3'] }}</td>
            <td colspan="2">{{ @$laporans['luasPermukaan4'] }}</td>
            <td colspan="2">{{ @$laporans['luasPermukaan5'] }}</td>
            <td colspan="2">{{ @$laporans['luasPermukaan6'] }}</td>
        </tr>
        <tr>
            <td>NAMA OBAT</td>
            <td>Dosis</td>
            <td>Sediaan</td>
            <td>Dosis</td>
            <td>Sediaan</td>
            <td>Dosis</td>
            <td>Sediaan</td>
            <td>Dosis</td>
            <td>Sediaan</td>
            <td>Dosis</td>
            <td>Sediaan</td>
            <td>Dosis</td>
            <td>Sediaan</td>
        </tr>
        @for ($row = 1; $row <= 7; $row++)
        <tr>
            <td>{{ @$laporans['namaObat'][$row] }}</td>
            <td>{{ @$laporans['dosis1'][$row] }}</td>
            <td>{{ @$laporans['sediaan1'][$row] }}</td>
            <td>{{ @$laporans['dosis2'][$row] }}</td>
            <td>{{ @$laporans['sediaan2'][$row] }}</td>
            <td>{{ @$laporans['dosis3'][$row] }}</td>
            <td>{{ @$laporans['sediaan3'][$row] }}</td>
            <td>{{ @$laporans['dosis4'][$row] }}</td>
            <td>{{ @$laporans['sediaan4'][$row] }}</td>
            <td>{{ @$laporans['dosis5'][$row] }}</td>
            <td>{{ @$laporans['sediaan5'][$row] }}</td>
            <td>{{ @$laporans['dosis6'][$row] }}</td>
            <td>{{ @$laporans['sediaan6'][$row] }}</td>
        </tr>
        @endfor
        <tr>
            <td>NAMA, NIP dan TANDA TANGAN DOKTER YANG MERAWAT (DPJP)</td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus1']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus2']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus3']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus4']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus5']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus6']))
                    @php
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
        </tr>
        <tr>
            <td>NAMA dan TANDA TANGAN PASIEN/KELUARGA</td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus1']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus2']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus3']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus4']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus5']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
            <td colspan="2" style="text-align: center;">
                @if(!empty($laporans['siklus6']))
                    @if ($pasien->tanda_tangan)
                        <img src="{{ public_path('images/upload/ttd/' . @$pasien->tanda_tangan) }}" alt="ttd" width="100" height="50"><br>
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <td>KETERANGAN</td>
            <td colspan="9" style="text-align: left; vertical-align: top;">
                {{@$laporans['keterangan']}}
            </td>
            <td colspan="3">
                <table style="width: 100%;" class="no-border-table">
                    <tr>
                        <td style="text-align: center;">Mengetahui Tim Cancer RSUD Otista</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
</html>