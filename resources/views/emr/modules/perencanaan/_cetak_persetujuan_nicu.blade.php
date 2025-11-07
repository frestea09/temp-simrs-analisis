<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PERNYATAAN PERSETUJUAN DIRAWAT DIRUANG NICU</title>
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

    <h1 style="text-decoration: underline">PERNYATAAN PERSETUJUAN DIRAWAT DIRUANG NICU</h1>
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
                <td style="width: 50%">: {{ @$nicu->nama }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Umur</td>
                <td style="width: 50%">: {{ @$nicu->umur }} , jenis kelamin: {{@$nicu->jenis_kelamin}}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Alamat</td>
                <td style="width: 50%">: {{ @$nicu->alamat }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Bukti diri / KTP</td>
                <td style="width: 50%">: {{ @$nicu->bukti_diri }}</td>
            </tr>
        </table>
    </div>

    <div style="padding: 10px;">
        <table style="width: 75%">
            <tr>
                <td>Sebagai <strong>{{@$nicu->selaku}}</strong> dari pasien: </td>
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
                <td style="width: 50%;" class="bold">Tanggal Lahir</td>
                <td style="width: 50%">: {{@$reg->pasien->tmplahir}}, {{ date('d-m-Y', strtotime(@$reg->pasien->tgllahir)) }} <br>
                Umur: {{hitung_umur(@$reg->pasien->tgllahir)}}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Dirawat di bagian / kamar </td>
                <td style="width: 50%">: {{ baca_kamar(@$reg->rawat_inap->kamar_id) }} RSUD Soreang</td>
            </tr>
        </table>
    </div>
    <p style="padding-left: 10px;">Dengan ini menyatakan PERSETUJUAN untuk dirawat di Ruang NICU, setelah mendapat penjelasan dari dokter / perawat yang mengerti seluruhnya tata cara, administrasi, pengobatan dan tujuan perawatan tersebut serta kemungkinan resiko yang dapat terjadi. </p>
    <p style="padding-left: 10px;">Demikian pernyataan ini saya buat dengan penuh kesadaran dan memahami sepenuhnya termasuk menerima segala resiko dari perawatan tersebut. </p>


    <table style="margin-top: 25px">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;text-align:center">Soreang, {{date('d-m-Y H:i', strtotime($cetak->created_at))}}</td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">Mengetahui <br> {{@$nicu->selaku}}</td>
            <td style="width: 50%;text-align:center">Yang menyatakan</td>
        </tr>
        <tr style="height: 80px">
            <td style="width: 50%;vertical-align: bottom;text-align:center">{{@$reg->pasien->nama}}</td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">{{ @$nicu->nama }}</td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">Mengetahui <br> Perawat Bagian</td>
            <td style="width: 50%;text-align:center">Dokter yang merawat</td>
        </tr>
        <tr style="height: 80px">
            <td style="width: 50%;vertical-align: bottom;text-align:center">{{ baca_pegawai(@$nicu->perawat) }}</td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">{{ baca_dokter(@$reg->rawat_inap->dokter_id) }}</td>
        </tr>
    </table>
</body>

</html>
