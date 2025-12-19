<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT PELIMPAHAN</title>
    <style>
        .borderless td, .borderless th {
            border: none !important;
        }
    </style>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css" media="screen">
      /* body{
        font-size: 9pt;
        margin: 0 2cm;
      } */
    </style>
</head>
{{-- <body> --}}
<body onload="window.print()">
    <table style="width: 100%; margin-left: 30px;">
        <tr>
            <td style="width:10%;">
                <img src="{{ url('images/logorsud.png') }}" style="width: 100px;">
                {{-- <img src="{{ public_path('images/logorsud.png') }}" style="width: 100px;"> --}}
            </td>
            <td class="text-center" style="width:90%;">
                PEMERINTAH KABUPATEN KUNINGAN<br />
                <b>RUMAH SAKIT UMUM DAERAH "45"</b><br>
                Jln.Jendral Sudirman No.68 (0232) 871885 Fax. 874701<br>
                <b>KUNINGAN</b><br>
                Kode Pos : 45511
            </td>
        </tr>
      </table>
      <hr>
      <h4 class="text-center"><u>SURAT KETERANGAN PELIMPAHAN TUGAS</u></h4>
      <p class="text-center">Nomor: .........../.........../ Kepeg & SDk</p><br><br>
      <p>Yang bertanda tangan dibawah ini :</p>
      <div class="row">
        <div class="col-sm-12">
            @if(isset($data['pegStruktur']->id))
            <table>
                <tr>
                    <td width="200">Nama</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['pegStruktur']->nama }}</td>
                </tr>
                <tr>
                    <td width="200">Tempat Tgl. Lahir</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['pegStruktur']->tmplahir }}, {{ \Carbon\Carbon::parse($data['pegStruktur']->tgllahir)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td width="200">NIP</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['pegStruktur']->nip }}</td>
                </tr>
                <tr>
                    <td width="200">Pangkat/Gol. RUang</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['pegStruktur']->biodata->kepangkatan->pangkat) ? $data['pegStruktur']->biodata->kepangkatan->pangkat.', '.$data['cuti']->kepangkatan->golongan : null }}</td>
                </tr>
                <tr>
                    <td width="200">Jabatan</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['pegStruktur']->struktur->nama) ? $data['pegStruktur']->struktur->nama : null }}</td>
                </tr>
                <tr>
                    <td width="200">Unit Kerja</td>
                    <td width="20">:</td>
                    <td width="500">RSUD 45 Kabupaten Kuningan</td>
                </tr>
            </table>
            @else
            <table>
                <tr>
                    <td width="200">Nama</td>
                    <td width="20">:</td>
                    <td width="500">H. AHYADIN, S.Sos, M,Si</td>
                </tr>
                <tr>
                    <td width="200">Tempat Tgl. Lahir</td>
                    <td width="20">:</td>
                    <td width="500">Kuningan, 13 September 1965</td>
                </tr>
                <tr>
                    <td width="200">NIP</td>
                    <td width="20">:</td>
                    <td width="500">19650913 198710 1 001</td>
                </tr>
                <tr>
                    <td width="200">Pangkat/Gol. RUang</td>
                    <td width="20">:</td>
                    <td width="500">Pembina, IV/a</td>
                </tr>
                <tr>
                    <td width="200">Jabatan</td>
                    <td width="20">:</td>
                    <td width="500">Wadir Bidang Administrasi Umum dan Keuangan</td>
                </tr>
                <tr>
                    <td width="200">Unit Kerja</td>
                    <td width="20">:</td>
                    <td width="500">RSUD 45 Kabupaten Kuningan</td>
                </tr>
            </table>
            @endif
        </div>
    </div>
      <p>Dengan ini menerangkan bahwa untuk melaksanakan tugas kedinasan saudara :</p>
      <div class="row">
        <div class="col-sm-12">
            <table>
                <tr>
                    <td width="200">Nama</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['cuti']->pegawai->nama }}</td>
                </tr>
                <tr>
                    <td width="200">Tempat, Tgl. Lahir</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['cuti']->pegawai->tmplahir }}, {{ \Carbon\Carbon::parse($data['cuti']->pegawai->tgllahir)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td width="200">NIP</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['cuti']->pegawai->nip }}</td>
                </tr>
                <tr>
                    <td width="200">Pangkat/Gol. RUang</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['cuti']->kepangkatan->pangkat) ? $data['cuti']->kepangkatan->pangkat.', '.$data['cuti']->kepangkatan->golongan : null}}</td>
                </tr>
                <tr>
                    <td width="200">Jabatan</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['cuti']->pegawai->struktur->nama) ? $data['cuti']->pegawai->struktur->nama : null }}</td>
                </tr>
                <tr>
                    <td width="200">Unit Kerja</td>
                    <td width="20">:</td>
                    <td width="500">RSUD 45 Kabupaten Kuningan</td>
                </tr>
            </table>
        </div>
    </div>
      <p>Selama yang bersangkutan melaksanakan <b>{{ $data['cuti']->jenis_cuti->nama }}</b>, maka tugas - tugas akan dilaksanakan oleh :</p>
      <div class="row">
        <div class="col-sm-12">
            <table>
                <tr>
                    <td width="200">Nama</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['cuti']->pegawai_pelimpahan->nama }}</td>
                </tr>
                <tr>
                    <td width="200">NIP</td>
                    <td width="20">:</td>
                    <td width="500">{{ $data['cuti']->pegawai_pelimpahan->nip }}</td>
                </tr>
                <tr>
                    <td width="200">Pangkat/Gol. RUang</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->pangkat) ? $data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->pangkat.', '.$data['cuti']->pegawai_pelimpahan->biodata->kepangkatan->golongan : null}}</td>
                </tr>
                <tr>
                    <td width="200">Jabatan</td>
                    <td width="20">:</td>
                    <td width="500">{{ isset($data['cuti']->pegawai_pelimpahan->struktur->nama) ? $data['cuti']->pegawai_pelimpahan->struktur->nama : null }}</td>
                </tr>
                <tr>
                    <td width="200">Unit Kerja</td>
                    <td width="20">:</td>
                    <td width="500">RSUD 45 Kabupaten Kuningan</td>
                </tr>
            </table>
        </div>
    </div>
    <p>Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    <br>
    @if(isset($data['pegStruktur']->id))
    <div class="text-right" style="float:right;">
        <p class="text-center">Kuningan, {{ \Carbon\Carbon::parse($data['cuti']->created_at)->format('d-m-Y') }}</p>
        <p class="text-center">An.DIREKTUR RSUD "45" KAB.KUNINGAN</p>
        <p class="text-center">{{ isset($data['pegStruktur']->struktur->nama) ? $data['pegStruktur']->struktur->nama : null }}</p>
        {{-- <p class="text-center">DAN KEUANGAN</p> --}}
        <br>
        <br>
        <br>
        <br>
        <p class="text-center">{{ $data['pegStruktur']->nama }}</p>
        <p class="text-center">{{ isset($data['pegStruktur']->biodata->kepangkatan->pangkat) ? $data['pegStruktur']->biodata->kepangkatan->pangkat.', '.$data['cuti']->kepangkatan->golongan : null }}</p>
        <p class="text-center">NIP. {{ $data['pegStruktur']->nip }}</p>
    </div>
    @else
    <div class="text-right" style="float:right;">
        <p class="text-center">Kuningan, {{ \Carbon\Carbon::parse($data['cuti']->created_at)->format('d-m-Y') }}</p>
        <p class="text-center">An.DIREKTUR RSUD "45" KAB.KUNINGAN</p>
        <p class="text-center">WADIR BIDANG ADMINISTRATOR UMUM</p>
        <p class="text-center">DAN KEUANGAN</p>
        <br>
        <br>
        <br>
        <br>
        <p class="text-center">H. AHYADIN, S.Sos, M.Si</p>
        <p class="text-center">Pembina</p>
        <p class="text-center">NIP. 19650913 198710 1 001</p>
    </div>
    @endif
</body>
</html>