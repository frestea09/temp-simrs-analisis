<table id='data' class='table-striped table-bordered table-hover table-condensed table'>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. RM</th>
            <th>Umur</th>
            <th>Asal Pasien</th>
            <th>Alamat</th>
            <th>Cara Bayar</th>
            <th>Dokter</th>
            <th>Pemeriksaan</th>
            <th>Waktu Kunjungan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kunjungan as $key => $d)
        {{-- {{ dd($d) }} --}}
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $d['nama_pasien'] }}</td>
            <td>{{ $d['no_rm'] }}</td>
            <td>{{ $d['umur'] }}</td>
            <td>
                @if ($d['jenis'] == 'TI')
                <i>Rawat Inap</i>
                @elseif ($d['jenis'] == 'TA')
                <i>Rawat Jalan</i>
                @elseif ($d['jenis'] == 'TG')
                <i>Gawat Darurat</i>
                @endif
            </td>
            <td>{{ @$d['alamat'] }}</td>
            <td>{{ $d['cara_bayar'] }}</td>
            <td>{{ $d['dokter'] }}</td>
            <td>
                @foreach ($d['nama_tarif'] as $item)
                - {{ $item }} <br>
                @endforeach
            </td>
            <td>{{ $d['tanggal_kunjungan'] }}</td>
        </tr>
        @endforeach
    </tbody>
    </tbody>
</table>