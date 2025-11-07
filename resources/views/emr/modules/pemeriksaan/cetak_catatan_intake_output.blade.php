<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Catatan Intake Output Cairan</title>
    <style>
        @page {
        margin: 20px;
        }

        body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        }

        h5 {
        text-align: center;
        margin: 10px 0;
        font-size: 14px;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        }

        .table th,
        .table td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        vertical-align: middle;
        font-size: 11px;
        }

        .table thead th {
        background: #f5f5f5;
        font-weight: bold;
        }

        .no-border td {
        border: none !important;
        text-align: left;
        font-size: 12px;
        padding: 2px 4px;
        }

        .no-border-table {
            border: none;
            border-collapse: collapse;
            width: 100%;
        }

        .no-border-table td {
            border: none !important;
            padding: 2px 4px;
            text-align: left;
            vertical-align: top;
        }

        tr { page-break-inside: avoid; }
    </style>
    </head>
    <body>
    @php
        $laporans = @json_decode(@$laporan->fisik, true);
        $hours = array_merge(range(7,24), range(1,6));
    @endphp

    <table class="table"> 
        <tr>
            <td style="width: 20%; padding: 5px;">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 90px;">
            </td>
            <td style="width:55%; text-align: center;">
                <b style="font-size:16px;">PEMERINTAH KABUPATEN BANDUNG</b> <br>
                <b style="font-size:16px;">RSUD OTO ISKANDAR DINATA</b> <br>
                <b style="font-size:12px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
                <b style="font-size:12px; font-weight:normal;">Telp : {{ configrs()->tlp }}</b><br/>
                <b style="font-size:12px; font-weight:normal;">Email : {{ configrs()->email }}</b><br/>
            </td>
            <td style="width: 25%; vertical-align: top;">
                <table class="no-border-table" style="width: 100%; padding: 5px; margin-top: 10px;">
                    <tr>
                        <td style="width: 40%;">Nomor RM</td>
                        <td style="width: 60%;">: {{@$reg->pasien->no_rm}}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{@$reg->pasien->nama}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{@$reg->pasien->tgllahir}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ @$reg->pasien->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class="no-border-table" style="font-size: 15px; width: 100%;">
        <tr>
            <td style="width: 50%">Hari : {{ hari($laporan->created_at) }}</td>
            <td style="width: 50%;">Tanggal : {{ date('d-m-Y', strtotime($laporan->created_at)) }}</td>
        </tr>
    </table>
    <!-- Tabel Intake Output -->
    <table class="table">
        <thead>
        <tr>
            <th rowspan="3">PUKUL</th>
            <th rowspan="3">ORAL</th>
            <th colspan="4">INTAKE</th>
            <th rowspan="3">TOTAL</th>
            <th colspan="6">OUTPUT</th>
        </tr>
        <tr>
            <th colspan="2">INFUS &amp; DARAH</th>
            <th colspan="2">OBAT</th>
            <th rowspan="2">URINE</th>
            <th rowspan="2">FAECES</th>
            <th rowspan="2">MUNTAH/NGT</th>
            <th rowspan="2">DRAIN/DARAH</th>
            <th rowspan="2">TOTAL</th>
            <th rowspan="2" style="width:15%;">NAMA PETUGAS</th>
        </tr>
        <tr>
            <th style="width:15%;">NAMA &amp; JUMLAH</th>
            <th style="width:5%;">SISA</th>
            <th style="width:15%;">NAMA &amp; JUMLAH</th>
            <th style="width:5%;">SISA</th>
        </tr>
        </thead>
        <tbody>
        @foreach($hours as $jam)
        <tr>
            <td>{{ $jam }}</td>
            <td>{{ @$laporans['intake']['oral'][$jam] }}</td>
            <td colspan="2">{{ @$laporans['intake']['infus_darah'][$jam] }}</td>
            <td colspan="2">{{ @$laporans['intake']['obat'][$jam] }}</td>
            <td>{{ @$laporans['intake']['total'][$jam] }}</td>
            <td>{{ @$laporans['output']['urine'][$jam] }}</td>
            <td>{{ @$laporans['output']['faeces'][$jam] }}</td>
            <td>{{ @$laporans['output']['muntah_ngt'][$jam] }}</td>
            <td>{{ @$laporans['output']['drain_darah'][$jam] }}</td>
            <td>{{ @$laporans['output']['total'][$jam] }}</td>
            <td>{{ @$laporans['nama_petugas'][$jam] }}</td>
        </tr>

        {{-- Baris Jml --}}
        @if(in_array($jam,[12,20]))
        <tr>
            <td><b>Jml</b></td>
            <td>{{ @$laporans['intake']['oral']['jml_'.$jam] }}</td>
            <td colspan="2">{{ @$laporans['intake']['infus_darah']['jml_'.$jam] }}</td>
            <td colspan="2">{{ @$laporans['intake']['obat']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['intake']['total']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['output']['urine']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['output']['faeces']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['output']['muntah_ngt']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['output']['drain_darah']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['output']['total']['jml_'.$jam] }}</td>
            <td>{{ @$laporans['nama_petugas']['jml_'.$jam] }}</td>
        </tr>
        @endif

        {{-- Baris Tanggal --}}
        @if($jam==24)
        <tr>
            <td colspan="13"><b>Tanggal:</b> {{ @$laporans['tanggal'] }}</td>
        </tr>
        @endif

        {{-- Baris Total --}}
        @if($jam==6)
        <tr>
            <td><b>Total</b></td>
            <td>{{ @$laporans['intake']['oral']['total'] }}</td>
            <td colspan="2">{{ @$laporans['intake']['infus_darah']['total'] }}</td>
            <td colspan="2">{{ @$laporans['intake']['obat']['total'] }}</td>
            <td>{{ @$laporans['intake']['total']['total'] }}</td>
            <td>{{ @$laporans['output']['urine']['total'] }}</td>
            <td>{{ @$laporans['output']['faeces']['total'] }}</td>
            <td>{{ @$laporans['output']['muntah_ngt']['total'] }}</td>
            <td>{{ @$laporans['output']['drain_darah']['total'] }}</td>
            <td>{{ @$laporans['output']['total']['total'] }}</td>
            <td>{{ @$laporans['nama_petugas']['total'] }}</td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
    </body>
</html>