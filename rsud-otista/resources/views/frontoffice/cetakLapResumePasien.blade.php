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
        <h3 class="text-center">Data Morbiditas & Mortalitas Rawat Jalan Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h3>
        <table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ICD9</th>
                    <th class="text-center">ICD10</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">6hr L</th>
                    <th class="text-center">6hr P</th>
                    <th class="text-center">6-28hr L</th>
                    <th class="text-center">6-28hr P</th>
                    <th class="text-center">28hr-1th L</th>
                    <th class="text-center">28hr-1th P</th>
                    <th class="text-center">1-4th L</th>
                    <th class="text-center">1-4th P</th>
                    <th class="text-center">4-14th L</th>
                    <th class="text-center">4-14th P</th>
                    <th class="text-center">14-24th L</th>
                    <th class="text-center">14-24th P</th>
                    <th class="text-center">24-44th L</th>
                    <th class="text-center">24-44th P</th>
                    <th class="text-center">44-64th L</th>
                    <th class="text-center">44-64th P</th>
                    <th class="text-center">>64th L</th>
                    <th class="text-center">>64th P</th>
                    <th class="text-center">L</th>
                    <th class="text-center">P</th>
                    <th class="text-center">KB</th>
                    <th class="text-center">KJ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($p_icd9 as $i)
                    @php 
                        $kelamin    = explode('||',$i->gender);
                        $gender     = array_count_values($kelamin);
                        $range      = getRange($i->lahir, $i->gender);
                        $status     = array_count_values(explode('||',$i->status));
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $i->icd9 }}</td>
                        <td>
                            @foreach(array_count_values(explode('||', $i->icd10)) as $k => $v)
                                {{ $k.',' }}
                            @endforeach
                        </td>
                        <td>{{ getICD9($i->icd9) }}</td>
                        <td class="text-center">{{ $range[0] }}</td>
                        <td class="text-center">{{ $range[1] }}</td>
                        <td class="text-center">{{ $range[2] }}</td>
                        <td class="text-center">{{ $range[3] }}</td>
                        <td class="text-center">{{ $range[4] }}</td>
                        <td class="text-center">{{ $range[5] }}</td>
                        <td class="text-center">{{ $range[6] }}</td>
                        <td class="text-center">{{ $range[7] }}</td>
                        <td class="text-center">{{ $range[8] }}</td>
                        <td class="text-center">{{ $range[9] }}</td>
                        <td class="text-center">{{ $range[10] }}</td>
                        <td class="text-center">{{ $range[11] }}</td>
                        <td class="text-center">{{ $range[12] }}</td>
                        <td class="text-center">{{ $range[13] }}</td>
                        <td class="text-center">{{ $range[14] }}</td>
                        <td class="text-center">{{ $range[15] }}</td>
                        <td class="text-center">{{ $range[16] }}</td>
                        <td class="text-center">{{ $range[17] }}</td>
                        <td class="text-center">{{ (isset($gender['L'])) ? $gender['L'] : 0 }}</td>
                        <td class="text-center">{{ (isset($gender['P'])) ? $gender['P'] : 0 }}</td>
                        <td class="text-center">{{ (isset($status['baru'])) ? $status['baru'] : 0 }}</td>
                        <td class="text-center">{{ count($kelamin) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</html>
