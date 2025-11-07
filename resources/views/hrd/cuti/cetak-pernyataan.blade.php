<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT PERNYATAAN</title>
    <style>
        .borderless td, .borderless th {
            border: none !important;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h1 class="text-center">SURAT PERNYATAAN</h1><br><br>
        <p>Yang bertanda tangan dibawah ini : </p>
        <div class="row">
            <div class="col-sm-12">
                <table>
                    <tr>
                        <td width="100">Nama</td>
                        <td width="20">:</td>
                        <td width="500">{{ $data['cuti']->pegawai->nama }}</td>
                    </tr>
                    <tr>
                        <td width="100">NIP</td>
                        <td width="20">:</td>
                        <td width="500">{{ $data['cuti']->pegawai->nip }}</td>
                    </tr>
                    <tr>
                        <td width="100">Pangkat/Gol</td>
                        <td width="20">:</td>
                        <td width="500">{{ isset($data['cuti']->kepangkatan->pangkat) ? $data['cuti']->kepangkatan->pangkat.', '.$data['cuti']->kepangkatan->golongan : null}}</td>
                    </tr>
                    <tr>
                        <td width="100">Jabatan</td>
                        <td width="20">:</td>
                        <td width="500">{{ isset($data['cuti']->pegawai->struktur->nama) ? $data['cuti']->pegawai->struktur->nama : null }}</td>
                    </tr>
                    <tr>
                        <td width="100">Unit Kerja</td>
                        <td width="20">:</td>
                        <td width="500">RSUD 45 Kabupaten Kuningan</td>
                    </tr>
                </table>
            </div>
        </div><br>
        <p>
            Dengan ini menyatakan sehubungan dengan permohonan cuti <b>{{ $data['cuti']->jenis_cuti->nama }}</b> yang saya ajukan selama <b>{{ $data['cuti']->lama_cuti }} hari kerja </b> terhitung mulai tanggal <b>{{ \Carbon\Carbon::parse($data['cuti']->tglmulai)->format('d-m-Y') }}</b> s/d <b>{{  \Carbon\Carbon::parse($data['cuti']->tglselesai)->format('d-m-Y')  }}</b>, agar tidak mengganggu pelaksanaan kegiatan selama menjalani cuti saya menyerahkan kewenangan pelaksanaan tugas kepada : 
        </p>
        <div class="row">
            <div class="col-sm-12">
                <table>
                    <tr>
                        <td width="100">Nama</td>
                        <td width="20">:</td>
                        <td width="500">{{ $data['cuti']->pegawai_pelimpahan->nama }}</td>
                    </tr>
                    <tr>
                        <td width="100">NIP</td>
                        <td width="20">:</td>
                        <td width="500">{{ $data['cuti']->pegawai_pelimpahan->nip }}</td>
                    </tr>
                    <tr>
                        <td width="100">Pangkat/Gol</td>
                        <td width="20">:</td>
                        <td width="500">{{ isset($data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->pangkat) ? $data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->pangkat.', '.$data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->golongan : null}}</td>
                    </tr>
                    <tr>
                        <td width="100">Jabatan</td>
                        <td width="20">:</td>
                        <td width="500">{{ isset($data['cuti']->pegawai_pelimpahan->struktur->nama) ? $data['cuti']->pegawai_pelimpahan->struktur->nama : null }}</td>
                    </tr>
                    <tr>
                        <td width="100">Unit Kerja</td>
                        <td width="20">:</td>
                        <td width="500">RSUD 45 Kabupaten Kuningan</td>
                    </tr>
                </table>
            </div>
        </div><br>
        <p>
            Demikian surat pernyataan ini dibuat untuk diketahui dan dipergunakan sebagaimana mestinya.
        </p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="text-right" style="float:right;">
                {{-- <div class="text-center"> --}}
                    <p class="text-center">Kuningan, {{ \Carbon\Carbon::parse($data['cuti']->created_at)->format('d-m-Y') }}</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="text-center">{{ $data['cuti']->pegawai->nama }}</p>
                    <p class="text-center">NIP. {{ $data['cuti']->pegawai->nip }}</p>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</body>
</html>