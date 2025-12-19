<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data PDF</title>
        <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    </head>
    <body onload="print()">
        <h3 class="text-center">Laporan Protesa Gigi Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h3>
        <br/>
        <table class='table table-bordered table-hover'>
            <thead>
                <tr class="text-center">
                    <th class="text-center">No</th>
                    <th class="text-center">No. RM</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">L/P</th>
                    <th class="text-center">Poli</th>
                    <th class="text-center">Bayar</th>
                    <th class="text-center">Dokter</th>
                    <th class="text-center">Tindakan</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Tarif</th>
                </tr>
            </thead>
            <tbody>
            @php $jumlah = 0; @endphp
            @foreach ($pengunjung as $key => $d)
                @php
                    $nt     = explode('||', $d->tindakan);
                    $total  = explode('||', $d->total);
                    $tgl    = explode('||', $d->tanggal);
                    $dokter = explode('||', $d->dokter);
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->pasien->no_rm }}</td>
                    <td>{{ $d->pasien->nama }}</td>
                    <td class="text-center">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                    <td class="text-center">{{ $d->pasien->kelamin }}</td>
                    <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                    <td class="text-center">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                @if(count($total) > 1)
                    @foreach($total as $k => $t)
                        @if($k == 0)
                            <td>{{ baca_dokter($dokter[$k]) }}</td>
                            <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                            <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                            <td class="text-right">{{ number_format($t) }}</td>
                        @else
                            <tr>
                                <td>{{ baca_dokter($dokter[$k]) }}</td>
                                <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                <td class="text-right">{{ number_format($t) }}</td>
                            </tr>
                        @endif
                        @php $jumlah += (int)$t; @endphp
                    @endforeach
                @else
                        <td>{{ baca_dokter($dokter[0]) }}</td>
                        <td>{{ (isset($nt[0])) ? $nt[0] : '' }}</td>
                        <td>{{ date('d-m-Y', strtotime($tgl[0])) }}</td>
                        <td class="text-right">{{ number_format($total[0]) }}</td>
                    </tr>
                    @php $jumlah += (int)$total[0]; @endphp
                @endif
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="10">Total</th>
                    <th class="text-right">{{ number_format($jumlah) }}</th>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
