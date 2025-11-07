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
    <h3 style="text-align: center">Laporan Kunjungan Rawat Jalan</h3>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. RM</th>
                <th>Umur</th>
                <th>L/P</th>
                <th>Pekerjaan</th>
                <th>Klinik Tujuan</th>
                <th>Dokter DPJP</th>
                <th>Cara Bayar</th>
                <th>Tanggal</th>
                <th>Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reg as $key => $d)
            @php
            $datas = \App\PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
                    ->where('perawatan_icd10s.registrasi_id', $d->registrasi_id)
                    ->whereBetween('perawatan_icd10s.created_at', [$tga,$tgb])
                    ->get();
                    
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ hitung_umur($d->tgllahir) }}</td>
                <td class="text-center">{{ $d->kelamin }}</td>
                <td>{{ @baca_pekerjaan($d->pekerjaan_id) }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ baca_carabayar($d->bayar) }} {{ ($d->bayar == 1) ? $d->tipe_jkn : NULL }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td>
                    @if (count($datas) > 0)
                      @foreach ($datas as $it)
                        {{ $it->nama }}<br/>  
                      @endforeach
                    @else 
                      - 
                    @endif
                  </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>