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
    <h3 class="text-center">Laporan Pengunjung Rawat Jalan </br>Periode {{ date('d M Y', strtotime($tga)) }} Sampai
        {{ date('d M Y', strtotime($tgb)) }}</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th class="v-middle text-center">No</th>
                <th class="v-middle text-center">No. RM</th>
                <th class="v-middle text-center">Nama</th>
                <th class="v-middle text-center">Alamat</th>
                <th class="v-middle text-center">Umur</th>
                <th class="v-middle text-center">Jenis Kelamin</th>
                <th class="v-middle text-center">Cara Bayar</th>
                <th class="v-middle text-center">Poli</th>
                <th class="v-middle text-center">Dokter</th>
                <th class="v-middle text-center">Tanggal</th>
                <th class="v-middle text-center">Status</th>
            </tr>
        </thead>
        {{-- <tbody> --}}
        <tbody>
            @forelse ($rajal as $d)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ hitung_umur($d->tgllahir) }}</td>
                <td>{{ $d->kelamin }}</td>
                <td>{{ baca_carabayar($d->bayar) }} - {{$d->tipe_jkn}}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                <td>{{ $d->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center">Data tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>