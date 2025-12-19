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
    <h3 style="text-align: center">Laporan Kunjungan - Rawat Darurat</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Umur</th>
                <th>Jenis Kelamin</th>
                <th>Cara Bayar</th>
                <th>Pelayanan</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Jenis Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($darurat as $rdar)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $rdar->no_rm }}</td>
                <td>{{ $rdar->nama }}</td>
                <td>{{ $rdar->alamat }}</td>
                <td>{{ hitung_umur($rdar->tgllahir) }}</td>
                <td>{{ $rdar->kelamin }}</td>
                <td>{{ baca_carabayar($rdar->bayar) }}</td>
                <td>{{ $rdar->triage_nama }}</td>
                <td>{{ baca_dokter($rdar->dokter_id) }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($rdar->created_at)) }}</td>
                <td>{{ cek_jenis_reg($rdar->status_reg) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>