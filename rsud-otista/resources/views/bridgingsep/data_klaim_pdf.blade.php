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
    <h3 style="text-align: center">Laporan Klaim Berkas VClaim BPJS Kesehatan</h3>
    </br>
    <table class='table table-bordered table-hover'>
        <thead class="bg-primary">
            <tr class="text-center">
                <th class="text-center" style="vertical-align: middle;">No</th>
                <th class="text-center" style="vertical-align: middle;">Nama</th>
                <th class="text-center" style="vertical-align: middle;">No RM</th>
                <th class="text-center" style="vertical-align: middle;">Nomer SEP</th>
                <th class="text-center" style="vertical-align: middle;">Poli</th>
                <th class="text-center" style="vertical-align: middle;">Tanggal SEP</th>
                <th class="text-center" style="vertical-align: middle;">Tanggal Pulang</th>
                <th class="text-center" style="vertical-align: middle;">Kode Grouper</th>
                <th class="text-center" style="vertical-align: middle;">Biaya Pengajuan</th>
                <th class="text-center" style="vertical-align: middle;">Biaya Disetujui</th>
                <th class="text-center" style="vertical-align: middle;">Tarif Grouper</th>
                <th class="text-center" style="vertical-align: middle;">Tarif Topup</th>
                <th class="text-center" style="vertical-align: middle;">Tarif Rs</th>
                <th class="text-center" style="vertical-align: middle;">Selisih</th>
                <th class="text-center" style="vertical-align: middle;">Status</th>
            </tr>
        </thead>
        <tbody id="viewKlaim">
            @foreach ($sml['response']['klaim'] as $key)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $key['Inacbg']['nama'] }}</td>
                <td>{{ $key['peserta']['noMR'] }}</td>
                <td>{{ $key['noSEP'] }}</td>
                <td>{{ $key['poli'] }}</td>
                <td>{{ $key['tglSep'] }}</td>
                <td>{{ $key['tglPulang'] }}</td>
                <td>{{ $key['Inacbg']['kode'] }}</td>
                <td>{{ $key['biaya']['byTarifGruper'] }}</td>
                <td>{{ $key['biaya']['bySetujui'] }}</td>
                <td>{{ $key['biaya']['byTarifGruper'] }}</td>
                <td>{{ $key['biaya']['byTopup'] }}</td>
                <td>{{ $key['biaya']['byTarifRS'] }}</td>
                <td>{{ ($key['biaya']['byTopup']) + ($key['biaya']['byTarifGruper']) - ($key['biaya']['byTarifRS']) }}
                </td>
                <td>{{ $key['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
    </script>
</body>

</html>