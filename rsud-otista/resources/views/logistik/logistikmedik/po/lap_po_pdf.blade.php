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
    <h3 style="text-align: center">Laporan Logistik Po</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th>No</th>
                <th>No. PO</th>
                <th>Supplier</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($po as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->no_po }}</td>
                <td>{{ $d->supplier }}</td>
                <td>{{ $d->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>