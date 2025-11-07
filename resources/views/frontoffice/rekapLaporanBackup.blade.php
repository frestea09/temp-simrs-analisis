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
            font-size: 11px
        }

        .v-middle {
            vertical-align: middle !important;
        }

        .no-wrap {
            white-space: nowrap
        }
    </style>
</head>

<body onload="print()">
    <h3 class="text-center">Laporan Pengunjung Rawat Jalan Periode {{ date('d M Y', strtotime($tga)) }} Sampai
        {{ date('d M Y', strtotime($tgb)) }}</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th class="v-middle text-center" rowspan="2">No</th>
                <th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
                <th class="v-middle text-center" rowspan="2">No. RM</th>
                <th class="v-middle text-center" rowspan="2">Nama</th>
                <th class="v-middle text-center" rowspan="2">Bayar</th>
                <th class="text-center" colspan="15">Rekap Tindakan</th>
            </tr>
            <tr>
                <th class="v-middle text-center">T. Jalan</th>
                <th class="v-middle text-center">Lab</th>
                <th class="v-middle text-center">Rad</th>
                <th class="v-middle text-center">Operasi</th>
                <th class="v-middle text-center">B. Darah</th>
                <th class="v-middle text-center">PDL</th>
                <th class="v-middle text-center">Family Folder</th>
                <th class="v-middle text-center">O2</th>
                <th class="v-middle text-center">Diet</th>
                <th class="v-middle text-center">Fisio</th>
                <th class="v-middle text-center">EKG</th>
                <th class="v-middle text-center">Amblns</th>
                <th class="v-middle text-center">ADK</th>
                <th class="v-middle text-center">Visite</th>
                <th class="v-middle text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $all = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; $ceck = 0; @endphp
            @foreach ($rajal as $rj)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($rj->created_at)) }}</td>
                <td class="text-center">{{ ($rj->pasien_id != '') ? $rj->pasien->no_rm : '' }}</td>
                <td>{{ ($rj->pasien_id != '') ? $rj->pasien->nama : '' }}</td>
                <td class="text-center">{{ baca_carabayar($rj->bayar) }}</td>
                @for($i = 1; $i <= 16; $i++) @if($i !=2 && $i !=3) @foreach ($rj->tindakan as $t)
                    @if($i == $t->mapping)
                    <td class="text-right">{{ number_format($t->jumlah) }}</td>
                    @php $all[$i-1] += $t->jumlah; @endphp
                    @php $ceck = 1; @endphp
                    @endif
                    @endforeach
                    @if($ceck == 0)
                    <td class="text-right">{{ number_format(0) }}</td>
                    @else
                    @php $ceck = 0; @endphp
                    @endif
                    @endif
                    @endfor
                    <td class="text-right">{{ number_format($rj->total) }}</td>
                    @php $all[16] += $rj->total; @endphp
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-center">Total</th>
                @foreach ($all as $k => $a)
                @if($k != 2 && $k != 1)
                <th class="text-right">{{ number_format($a) }}</th>
                @endif
                @endforeach
            </tr>
        </tfoot>
    </table>
    {{-- <h4>Data Visit Dokter</h4>
        <table class="table table-bordered table-hover" style="width:650px">
            <thead>
                <tr>
                    <th class="text-center" width="15px">No</th>
                    <th class="text-center">Dokter</th>
                    <th class="text-center">Visite</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $_no = 1; $t_visite = 0; @endphp
                @foreach ($visite as $v)
                    <tr>
                        <td class="text-center" width="15px">{{ $_no++ }}</td>
    <td>{{ baca_dokter($v->dokter_id) }}</td>
    <td class="text-center">{{ $v->visite }}</td>
    <td class="text-right" width="35px">{{ number_format($v->nominal) }}</td>
    </tr>
    @php $t_visite += $v->nominal; @endphp
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th>{{ number_format($t_visite) }}</th>
        </tr>
    </tfoot>
    </table> --}}
</body>

</html>