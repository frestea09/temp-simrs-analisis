<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SIPEKA</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px; /* kecilkan agar muat */
        }
        h2, h4 {
            text-align: center;
            margin: 0;
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: fixed; /* biar kolom fix */
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }
        th {
            background: #f2f2f2;
            text-align: center;
        }
        ul {
            margin: 0;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <h2>LAPORAN HASIL PENGADUAN (SIPEKA)</h2>
    <h4>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</h4>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Tanggal Kejadian</th>
                <th>Lokasi Kejadian</th>
                <th>Bagian Permasalahan</th>
                <th>Jenis Permasalahan Petugas/Karyawan</th>
                <th>Bidang Petugas/Karyawan</th>
                <th>Nama Petugas/Karyawan</th>
                <th>Fasilitas Bermasalah</th>
                <th>Jenis Permasalahan Fasilitas</th>
                <th>Jenis Permasalahan Administrasi</th>
                <th>Komplain</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->no_hp }}</td>
                <td>{{ $data->tanggal_kejadian }}</td>
                <td>{{ $data->lokasi_kejadian }}</td>
                <td>{{ $data->bagian_permasalahan }}</td>
                <td>
                    @php $petugas = json_decode($data->jenis_permasalahan_petugas, true); @endphp
                    @if(is_array($petugas) && !empty($petugas))
                        <ul>
                            @foreach($petugas as $p)
                                <li>{{ $p }}</li>
                            @endforeach
                        </ul>
                    @elseif(!empty($data->jenis_permasalahan_petugas) && $data->jenis_permasalahan_petugas !== 'null')
                        {{ $data->jenis_permasalahan_petugas }}
                    @endif
                </td>
                <td>{{ $data->bidang_petugas_karyawan }}</td>
                <td>{{ $data->nama_petugas_karyawan }}</td>
                <td>
                    @php $fasilitas = json_decode($data->masalah_fasilitas, true); @endphp
                    @if(is_array($fasilitas) && !empty($fasilitas))
                        <ul>
                            @foreach($fasilitas as $f)
                                <li>{{ $f }}</li>
                            @endforeach
                        </ul>
                    @elseif(!empty($data->masalah_fasilitas) && $data->masalah_fasilitas !== 'null')
                        {{ $data->masalah_fasilitas }}
                    @endif
                </td>
                <td>
                    @php $jf = json_decode($data->jenis_masalah_fasilitas, true); @endphp
                    @if(is_array($jf) && !empty($jf))
                        <ul>
                            @foreach($jf as $j)
                                <li>{{ $j }}</li>
                            @endforeach
                        </ul>
                    @elseif(!empty($data->jenis_masalah_fasilitas) && $data->jenis_masalah_fasilitas !== 'null')
                        {{ $data->jenis_masalah_fasilitas }}
                    @endif
                </td>
                <td>{{ $data->jenis_permasalahan_administrasi }}</td>
                <td>{{ $data->komplain }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
