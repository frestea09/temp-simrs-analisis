<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data PDF</title>
        <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
        <style>
            body{font-size: 11px}
            .v-middle{vertical-align: middle !important;}
            .no-wrap{white-space: nowrap}
        </style>
    </head>
    <body onload="print()">
        <h3 class="text-center">Laporan Bangsal Berdasarkan Cara Bayar Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h3>
        <table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    @php($total = [])
                    <th>No</th>
                    <th>Bangsal</th>
                    @foreach ($carabayar as $k => $cb)
                        @php($total[$k] = 0)
                        <th>{{ $cb->carabayar }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($bangsal as $bs)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ baca_kelompok($bs->id) }}</td>
                        @foreach ($carabayar as $k => $cr)
                            @php($lapTotal = lapByCaraBayar($bs->id, $cr->id, 'TI', $tga, $tgb))
                            @php($total[$k] += $lapTotal)
                            <td class="text-right">{{ number_format($lapTotal) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">#</td>
                    <th>TOTAL</th>
                    @foreach ($total as $t)
                        <th class="text-right">{{ number_format($t) }}</th>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </body>
</html>
