<h1>Laporan Rujukan</h1>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Tanggal Kunjungan</th>
            <th>Dokter yang Merujuk</th>
            <th>Unit</th>
            <th>Asal Poliklinik</th>
            <th>Ruangan</th>
            <th>Diagnosa</th>
            <th>Faskes Rujukan</th>
            <th>Rumah Sakit Rujukan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rujukan as $index => $d)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $d->no_rm }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ \Carbon\Carbon::parse($d->tanggal_kunjungan)->format('d-m-Y') }}</td>
            <td>{{ $d->nama_dokter }}</td>
            <td>{{ $d->unit }}</td>
            <td>{{ $d->nama_poli }}</td>
            <td>{{ $d->ruangan ?? '-' }}</td>
            <td>{{ $d->assesment ?? '-' }}</td>
            <td>{{ $d->diRujukKe }}</td>
            <td>{{ $d->rsRujukan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
