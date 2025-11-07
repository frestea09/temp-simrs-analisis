<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        body {
            font-size: 11px;
            margin: 1em;
        }

        .v-middle {
            vertical-align: middle !important;
        }

        .no-wrap {
            white-space: nowrap
        }

        .table-bordered th,
        .table-bordered td {
            border: 2px solid #ddd !important;
        }
    </style>
</head>

<body onload="print()">
    <h3 class="text-center">Laporan Pengunjung IGD </br>Periode {{ date('d M Y', strtotime($tga)) }} Sampai
        {{ date('d M Y', strtotime($tgb)) }}</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th class="v-middle text-center" rowspan="2">No</th>
                <th class="v-middle text-center" rowspan="2">No. RM</th>
                <th class="v-middle text-center" rowspan="2">Nama</th>
                <th class="v-middle text-center" rowspan="2">Alamat</th>
                <th class="v-middle text-center" rowspan="2">Umur</th>
                <th class="v-middle text-center" rowspan="2">Jenis Kelamin</th>
                <th class="v-middle text-center" rowspan="2">Cara Bayar</th>
                <th class="v-middle text-center" rowspan="2">Pelayanan</th>
                <th class="v-middle text-center" rowspan="2">Dokter</th>
                <th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($darurat as $d)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ hitung_umur($d->tgllahir) }}</td>
                <td>{{ $d->kelamin }}</td>
                <td>{{ baca_carabayar($d->bayar) }}</td>
                @if (substr($d->politipe,0,1) == 'I')
                <td>Rawat Inap</td>
                @elseif(substr($d->politipe,0,1) == 'G')
                <td>Rawat Darurat</td>
                @elseif(substr($d->politipe,0,1) == 'J')
                <td>Rawat Jalan</td>

                @endif
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($d->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>