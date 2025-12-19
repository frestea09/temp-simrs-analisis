<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 4px;
        }
        th {
            background: #eee;
        }
        tr {
            page-break-inside: avoid;
        }
        td {
            min-height: 20px;
            vertical-align: top;
        }
    </style>

    {{-- <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet"> --}}
</head>
    <body onload="print()">
        <h3 class="text-center">Laporan Pengunjung Operasi Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h3>
        <br/>
        <table class='table table-bordered table-hover' style="width: 100%;">
            <thead style="border:1px solid #000;">
                <tr class="text-center">
                    <th class="text-center">No</th>
                    <th class="text-center">No. RM</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">L/P</th>
                    <th class="text-center">Bayar</th>
                    <th class="text-center">Dr. Bedah</th>
                    <th class="text-center">Dr. Anestesi</th>
                    <th class="text-center">Dr. Anak</th>
                    <th class="text-center">Perawat</th>
                    <th class="text-center">Tindakan</th>
                    <th class="text-center">Cito</th>
                    <th class="text-center">Poli</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Tarif</th>
                    <th class="text-center">Kamar</th>
                    <th class="text-center">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $jumlah = 0; 
                    $no = 1; 
                @endphp

                @foreach ($operasi_new as $key => $group)
                    @php
                        $reg = Modules\Registrasi\Entities\Registrasi::find($key);
                        $first = true;
                    @endphp

                    @foreach ($group as $t)
                        <tr>
                            @if ($first)
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ @$reg->pasien->no_rm }}</td>
                                <td>{{ @$reg->pasien->nama }}</td>
                                <td class="text-center">{{ @$reg->status == 'baru' ? 'Baru' : 'Lama' }}</td>
                                <td class="text-center">{{ @$reg->pasien->kelamin }}</td>
                                <td class="text-center">{{ strtoupper(baca_carabayar(@$reg->bayar)) }}</td>
                                @php $first = false; @endphp
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif

                            <td>{{ @baca_dokter($t->dokter_bedah) }}</td>
                            <td>{{ @baca_dokter($t->dokter_anestesi) }}</td>
                            <td>{{ @baca_dokter($t->dokter_anak) }}</td>
                            <td>{{ @baca_pegawai($t->perawat) }}</td>
                            <td>{{ @$t->tarif->kategoritarif->namatarif }} - {{ $t->namatarif }}</td>
                            <td>{{ $t->cyto !== null ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ $t->poli_id ? baca_poli($t->poli_id) : baca_poli($reg->poli_id) }}</td>
                            <td>{{ date('d-m-Y', strtotime($t->created_at)) }}</td>
                            <td class="text-right">{{ number_format($t->total) }}</td>
                            <td>{{ @baca_kamar($t->kamar_id) }}</td>
                            <td>{{ @$t->catatan }}</td>
                        </tr>
                        @php $jumlah += $t->total; @endphp
                    @endforeach
                @endforeach
            </tbody>
            <tfoot style="border:1px solid #000;">
                <tr>
                    <th class="text-center" colspan="15">Total</th>
                    <th class="text-right">{{ number_format($jumlah) }}</th>
                </tr>
            </tfoot>
        </table>
        <h4>Total Tindakan Dokter Bedah</h4>
        {{-- <table class='table table-bordered table-hover' style="width:650px">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Dokter Bedah</th>
                    <th class="text-center" width="100px">Total Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @php $_no = 1; @endphp
            @foreach ($detail_dokter as $dd)
                <tr>
                    <td class="text-center" width="15px">{{ $_no++ }}</td>
                    <td>{{ baca_dokter($dd->dokter_bedah) }}</td>
                    <td class="text-center">{{ $dd->jumlah }}</td>
                </tr>
            @endforeach
            </tbody>
        </table> --}}
    </body>
</html>
