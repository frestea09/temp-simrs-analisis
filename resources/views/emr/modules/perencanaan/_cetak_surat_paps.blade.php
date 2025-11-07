<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SURAT PERNYATAAN ATAS PERMINTAAN SENDIRI (APS)</title>
    <style>
        * {
            font-size: 12px
        }

        table,
        th,
        td {
            border: none;
            border-collapse: collapse;
            width: 100%;
            height: min-content;
        }

        th,
        td {
            padding: 4px;
            vertical-align: top;
            /* text-align: left; */
        }

        h1 {
            text-align: center;
            font-size: 18px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body onload="print()">
    <table border=0 style="width:95%;font-size:12px;">
        <tr>
            <td style="width:10%;">
                <img src="{{ asset('images/' . configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
                <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
                <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
              </td>
        </tr>
    </table>

    <h1 style="text-decoration: underline">SURAT PERNYATAAN ATAS PERMINTAAN SENDIRI (APS)</h1>
    <div style="padding: 10px;">
        <table style="width: 75%">
            <tr>
                <td>Saya yang bertanda tangan dibawah ini :</td>
            </tr>
        </table>
    </div>

    <div style="display: flex; flex-flow: row; gap: 30px;padding-left: 10px">
        <table style="width: 50%">
            <tr>
                <td style="width: 50%;" class="bold">NAMA</td>
                <td style="width: 50%">: {{ @$reg->pasien->nama }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">No. Rekam Medis</td>
                <td style="width: 50%">: {{ $reg->pasien->no_rm }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Tanggal Lahir</td>
                <td style="width: 50%">: {{@$reg->pasien->tmplahir}}, {{ date('d-m-Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Alamat</td>
                <td style="width: 50%">: {{ @$reg->pasien->alamat }}</td>
            </tr>
        </table>
    </div>

    <div style="padding: 10px;">
        <table style="width: 75%">
            <tr>
                <td>Selaku <strong>{{@$paps->selaku}}</strong> dari pasien: </td>
            </tr>
        </table>
    </div>

    <div style="display: flex; flex-flow: row; gap: 30px;padding-left: 10px">
        <table style="width: 50%">
            <tr>
                <td style="width: 50%;" class="bold">NAMA</td>
                <td style="width: 50%">: {{ $paps->saksi }}</td>
            </tr>
        </table>
    </div>
    <p style="padding-left: 13px;">Dengan ini menyatakan : </p>
    <div style="padding: 10px; margin-left:30px">
        <ol>
            <li>Dengan sadar tanpa paksaan dari PIHAK manapun meminta kepada pihak Rumah Sakit untuk PULANG ATAS PERMINTAAN SENDIRI yang merupakan hak saya / pasien dengan alasan : <span style="font-style: italic">{{@$paps->alasan}}</span> </li>
            <li>Saya telah memahami sepenuhnya penjelasan yang diberikan dari pihak Rumah Sakit mengenai penyakit dan kemungkinan / konsekuensi terbaik sampai terburuk atas keputusan yang saya ambil serta tanggung jawab saya dalam mengambil keputusan ini.</li>
            <li>Apabila terjadi sesuatu hal berkaitan dengan putusan yang telah diambil, maka hal tersebut adalah menjadi tanggung jawab pasien/keluarga sepenuhnya dan tidak akan menyangkut pautkan / menuntuk rumah sakit ini</li>
            <li>Atas keputusan saya ini, RUmah Sakit telah memberikan penjelasan mengenai alternatif pengobatan selanjutnya</li>
        </ol>
    </div>
    <p style="padding-left: 10px;">Demikian pernyataan ini saya buat dengan sesungguhnya untuk diketahui dan digunakan sebagaimana perlunya. </p>


    <table style="margin-top: 25px">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;text-align:center">Soreang, {{date('d-m-Y H:i', strtotime($cetak->created_at))}}</td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">Saksi / keluarga</td>
            <td style="width: 50%;text-align:center">Pembuat Pernyataan</td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">
                @if ($ttd_saksi)
                    <img src="{{ asset('images/upload/ttd/' . @$ttd_saksi->tanda_tangan) }}" alt="ttd" width="200" height="100">
                @else
                    <br><br><br><br>
                @endif
            </td>
            <td style="width: 50%;text-align:center">
                @if ($reg->pasien->tanda_tangan)
                    <img src="{{ asset('images/upload/ttd/' . @$reg->pasien->tanda_tangan) }}" alt="ttd" width="200" height="100">
                @else
                    <br><br><br><br>
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 50%;vertical-align: bottom;text-align:center">{{@$paps->saksi}}</td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">{{ @$reg->pasien->nama }}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; text-align:center;">Petugas RS</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; text-align: center;">
                {{-- @if (isset($cetak_tte))
                <span style="margin-left: 1rem;">
                    #
                </span>
                    <br>
                    <br>
                @elseif (isset($tte_nonaktif)) --}}
                    @php
                        @$pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $cetak->user_id)->first();
                        @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pegawai->nama . ' , ' . @$pegawai->sip . ' , ' . @$cetak->created_at))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                {{-- @endif --}}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; vertical-align: bottom;text-align:center">{{ @$pegawai->nama }}</td>
        </tr>
    </table>
</body>

</html>
