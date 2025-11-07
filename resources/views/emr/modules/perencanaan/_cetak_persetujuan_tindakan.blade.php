<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PERNYATAAN PERSETUJUAN PASIEN/KELUARGA TERHADAP TINDAKAN</title>
    <style>
        * {
            font-size: 12px
        }

        h1 {
            text-align: center;
            font-size: 18px;
        }

        .bold {
            font-weight: bold;
        }

        .border {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .p-1 {
            padding: 1rem;
        }

        .text-center {
            text-align: center;
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


    @php
        $jenis_informasi = [
            "pemasangan_infus" => "Pemasangan Infus",
            "pemasangan_dower_cathether" => "Pemasangan Dower Cathether",
            "tindakan_restrain" => "Tindakan Restrain (Pengikatan)",
            "test_antibiotik" => "Tes Untuk Antibiotik",
            "injeksi" => "Pemberian Suntikan/Injeksi",
            "pemasangan_ngt" => "Pemasangan NGT",
            "pemasangan_ogt" => "Pemasangan OGT",
            "pemasangan_bidai" => "Pemasangan Bodao",
            "suction_nasofaring" => "Suction Nasofaring",
            "penjahitan_luka_derajat" => "Penjahitan Luka Derajat Ringan",
        ]
    @endphp
    <h1 style="text-decoration: underline">PERNYATAAN PERSETUJUAN PASIEN/KELUARGA TERHADAP TINDAKAN</h1>

    <table class="border" style="width: 100%;">
        <tr class="border">
            <td class="border bold p-1 text-center" rowspan="2">NO</td>
            <td class="border bold p-1 text-center" rowspan="2">TGL JAM</td>
            <td class="border bold p-1 text-center" rowspan="2">JENIS INFORMASI</td>
            <td class="border bold p-1 text-center" rowspan="2">ISI INFORMASI</td>
            <td class="border bold p-1 text-center" colspan="2">Tanda Tangan</td>
        </tr>
        <tr class="border">
            <td class="border bold p-1 text-center">Pasien/Keluarga</td>
            <td class="border bold p-1 text-center">Petugas</td>
        </tr>
        @foreach ($jenis_informasi as $key => $jenis)
            <tr class="border">
                <td class="border p-1">{{$loop->iteration}}</td>
                <td class="border p-1">{{$tindakan["tgl_".$key]}}</td>
                <td class="border p-1">{{$jenis}}</td>
                <td class="border p-1">{{$tindakan[$key]}}</td>
                <td class="border p-1">&nbsp;</td>
                <td class="border p-1">&nbsp;</td>
            </tr>
        @endforeach
        {{-- @foreach ($jenis_informasi as $key => $jenis) --}}
        {{-- {{dd($jenis, $key, $tindakan["tgl_".$key], $jenis, $tindakan[$key])}} --}}
            {{-- <tr class="border bold">{{$loop->iteration}}</tr> --}}
            {{-- <tr class="border">{{$tindakan["tgl_".$key]}}</tr>
            <tr class="border">{{$jenis}}</tr>
            <tr class="border">{{$tindakan[$key]}}</tr> --}}
        {{-- @endforeach --}}
    </table>
</body>

</html>
