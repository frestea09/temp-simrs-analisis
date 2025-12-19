<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SURAT PERNYATAAN MENOLAK RUJUK</title>
    <style>
        * {
            /* font-size: 12px; */
        }
        body {
            padding-left:100px;
            padding-right:100px;
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
{{-- <body> --}}
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
    <hr/>
    <br/>
    <br/>
    <h1 style="text-decoration: underline">SURAT PERNYATAAN MENOLAK RUJUK</h1>
    <br/>
    <br/>
    <div style="padding: 10px;">
        <table style="width: 75%">
            <tr>
                <td>Yang bertanda tangan dibawah ini :</td>
            </tr>
        </table>
    </div>

    <div style="display: flex; flex-flow: row; gap: 30px;padding-left: 10px">
        <table style="width: 50%">
            <tr>
                <td style="width: 50%;" class="bold">Nama</td>
                <td style="width: 50%">: {{ @$paps->nama }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">No. Identitas/KTP/SIM/dll</td>
                <td style="width: 50%">: {{ @$paps->no_identitas }}</td>
            </tr>
            <tr>
                <td style="width: 50%;" class="bold">Alamat</td>
                <td style="width: 50%">: {{ @$paps->alamat }}</td>
            </tr>
        </table>
    </div>

     
    <p style="padding-left: 13px;margin-left:80px;">Hubungan dengan penderita sebagai Ayah / Ibu : {{@$paps->hubungan}}</p>
    <p style="padding-left: 10px;text-align:justify">
        Bertanggung jawab atas keaadan / kesehatan penderita sekalipun kami sudah memperoleh
        penjelasan langsung dari petugas / Dokter yang merawat perihal keadaan atau penyakit penderita tersebut, tetapi keluarga pasien menolak untuk dirujuk ke 
        Rumah sakit besar yang peralatannya lebih lengkap.
    </p>


    <table style="margin-top: 25px">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;text-align:center">Soreang, {{date('d-m-Y H:i', strtotime($cetak->created_at))}}</td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">Dokter / Petugas Ruangan</td>
            <td style="width: 50%;text-align:center">Yang Membuat Pernyataan</td>
        </tr>
        <tr style="height: 80px">
            <td style="width: 50%;vertical-align: bottom;text-align:center">{{@baca_dokter($reg->dokter_id)}}</td>
            <td style="width: 50%; vertical-align: bottom;text-align:center">{{ @$paps->nama }}</td>
        </tr>
    </table>
</body>

</html>
