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
        <h3 class="text-center">Laporan Rehabilitasi Medik Periode {{ date('d M Y', strtotime($tga)) }} Sampai {{ date('d M Y', strtotime($tgb)) }}</h3>
        <br/>
        <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">No. RM</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">L/P</th>
                    <th class="text-center">Poli</th>
                    <th class="text-center">Bayar</th>
                    <th class="text-center">Dokter</th>
                    <th class="text-center">Pelaksana</th>
                    <th class="text-center">Icd 10</th>
                    <th class="text-center">Icd 9</th>
                    <th class="text-center">Tindakan</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Tarif</th>
                </tr>
            </thead>
            <tbody>
                @php $jumlah = 0; @endphp
                @foreach ($lap as $key => $d)
                    @php
                        $icd10 = App\PerawatanIcd10::where('registrasi_id', $d->registrasi_id)->get();
                        $icd9 = App\PerawatanIcd9::where('registrasi_id', $d->registrasi_id)->get();


                        $nt     = explode('||', $d->tindakan);
                        $total  = explode('||', $d->total);
                        $tgl    = explode('||', $d->tanggal);
                    @endphp
                    <tr>
                        <td class="text-center" rowspan="{{ count($total) }}">{{ $no++ }}</td>
                        <td rowspan="{{ count($total) }}">{{ $d->pasien->no_rm }}</td>
                        <td rowspan="{{ count($total) }}">{{ $d->pasien->nama }}</td>
                        <td class="text-center" rowspan="{{ count($total) }}">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                        <td class="text-center" rowspan="{{ count($total) }}">{{ $d->pasien->kelamin }}</td>
                        <td rowspan="{{ count($total) }}">{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                        <td class="text-center" rowspan="{{ count($total) }}">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                        <td rowspan="{{ count($total) }}">{{ baca_dokter($d->dokter_id) }}</td>
                        <td rowspan="{{ count($total) }}">{{ baca_pegawai($d->radiografer) }}</td>
                        <td rowspan="{{ count($total) }}">
                           @if (isset($icd10))
                            @foreach ($icd10 as $t)
                                    {{ $t->icd10 }},
                            @endforeach
                           @endif
                        </td>
                        <td rowspan="{{ count($total) }}">
                            @if (isset($icd9))
                             @foreach ($icd9 as $t)
                                     {{ $t->icd9 }},
                             @endforeach
                            @endif
                         </td>
                    @if(count($total) > 1)
                        @foreach($total as $k => $t)
                            @if($k == 0)
                                <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                <td class="text-right">{{ number_format($t) }}</td>
                            @else
                                <tr>
                                    <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                    <td class="text-right">{{ number_format($t) }}</td>
                                </tr>
                            @endif
                            @php $jumlah += (int)$t; @endphp
                        @endforeach
                    @else
                            
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
            </tbody>
        </table>
    </body>
</html>
