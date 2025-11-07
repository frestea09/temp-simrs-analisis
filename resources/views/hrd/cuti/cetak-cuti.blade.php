<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT CUTI</title>
    <style>
        .borderless td, .borderless th {
            border: none !important;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table{
            width:100%;
        }
        p {
            margin: 0 0 0px;
        }
    </style>
</head>
{{-- <body> --}}
<body onload="window.print()">
    <div class="container">
        {{-- <h1 class="text-center">SURAT CUTI</h1><br><br> --}}
        <table >
            <tr>
                <th colspan="6">I. Data Pegawai</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td class="text-center">:</td>
                <td>{{ $data['cuti']->pegawai->nama }}</td>
                <td>NIP</td>
                <td class="text-center">:</td>
                <td>{{ isset($data['cuti']->pegawai->nip) ? $data['cuti']->pegawai->nip : '..................' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td class="text-center">:</td>
                <td>{{ $data['cuti']->pegawai->struktur->nama }}</td>
                <td>Masa Kerja</td>
                <td class="text-center">:</td>
                <td></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td class="text-center">:</td>
                <td>RSUD 45 Kabupaten Kuningan</td>
                <td colspan="3"></td>
            </tr>
        </table>
        <table >
            <tr>
                <th colspan="6">II. Jenis Cuti yang di Ambil **</th>
            </tr>
            <tr>
                <td>1. Cuti Tahunan</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 1) ? 'V' : '-' }}</td>
                <td>2. Cuti Besar</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 4) ? 'V' : '-' }}</td>
            </tr>
            <tr>
                <td>3. Cuti Sakit</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 2) ? 'V' : '-' }}</td>
                <td>4. Cuti Melahirkan</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 5) ? 'V' : '-' }}</td>
            </tr>
            <tr>
                <td>5. Cuti Karena Alasan Penting</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 3) ? 'V' : '-' }}</td>
                <td>6. Cuti Luar Tanggungan Negara</td>
                <td class="text-center">{{ ($data['cuti']->jenis_cuti->id == 6) ? 'V' : '-' }}</td>
            </tr>
        </table>
        <table >
            <tr>
                <th colspan="6">III. Alasan Cuti</th>
            </tr>
            <tr>
                <td colspan="6">{{ $data['cuti']->alasan_cuti }}</td>
            </tr>
        </table>
        <table >
            <tr>
                <th colspan="5">IV. Lama Cuti<th>
            </tr>
            <tr>
                <td class="text-center">Selama</td>
                <td class="text-center">{{ $data['cuti']->lama_cuti }} Hari</td>
                <td class="text-center">Mulai Tanggal</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($data['cuti']->tglmulai)->format('d-m-Y') }}</td>
                <td class="text-center">s/d</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($data['cuti']->tglselesai)->format('d-m-Y') }}</td>
            </tr>
        </table>
        <table >
            <tr>
                <th colspan="6">V. Catatan Cuti ***</th>
            </tr>
            <tr>
                <td class="text-center">Tahunan</td>
                <td class="text-center">Sisa</td>
                <td class="text-center">Keterangan</td>
                <td>2. Cuti Besar</td>
                <td class="text-center">{{ ($data['cuti_besar'] != 0) ? $data['cuti_besar'] : '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">N-2</td>
                <td class="text-center"></td>
                <td></td>
                <td>3. Cuti Sakit</td>
                <td class="text-center">{{ ($data['cuti_sakit'] != 0) ? $data['cuti_sakit'] : '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">N-1</td>
                <td class="text-center"></td>
                <td></td>
                <td>4. Cuti Melahirkan</td>
                <td class="text-center">{{ ($data['cuti_lahir'] != 0) ? $data['cuti_lahir'] : '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">N</td>
                <td class="text-center">{{ ($data['jenis'][0]->kuota - $data['cuti_tahunan']) }}</td>
                <td class="text-center"></td>
                <td>5. Cuti Karena Alasan Penting</td>
                <td class="text-center">{{ ($data['cuti_penting'] != 0) ? $data['cuti_penting'] : '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>6. Cuti Luar Tanggungan Negara</td>
                <td class="text-center">{{ ($data['cuti_luar'] != 0) ? $data['cuti_luar'] : '-' }}</td>
            </tr>
        </table>
        <table >
            <tr>
                <td colspan="2"><b>VI.Alamat Selama Menjalankan Cuti</b><td>
            </tr>
            <tr>
                <td></td>
                <td>Telepon</td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">{{ $data['cuti']->alasan_cuti }}</td>
                <td class="text-center">{{ $data['cuti']->telepon }}</td>
                <td>
                    <p class="text-center">Hormat Saya</p>
                    <br>
                    <br>
                    <p class="text-center"><u>{{ $data['cuti']->pegawai->nama }}</u></p>
                    <p class="text-center">NIP. {{ $data['cuti']->pegawai->nip }}</p>
                </td>
            </tr>
        </table>
        @foreach( $data['cuti']->approve_cuti as $key => $val )
        @if( $key < 3 )
        <table >
            <tr>
                @if( $key == 0 )
                    <th colspan="4">VII.Pertimbangan Atasan Langsung **<th>
                @elseif( $key == 1 )
                    {{-- <th colspan="4">VIII.Pertimbangan Atasan Langsung **<th> --}}
                    @php
                         continue;
                    @endphp
                @elseif( $key == 2 )
                    <th colspan="4">VIII.Keputusan Pejabat Yang Berwenang Memberikan Cuti **<th>
                @endif
            </tr>
            <tr>
                <td class="text-center" style="width: 20%">
                    Disetujui 
                    @if( $key == 0 )
                        @if( $val->status == "disetujui" ) 
                            <b style="color:green;">V</b> 
                        @endif
                    @endif
                </td>
                <td class="text-center" style="width: 20%">
                    Perubahan ***
                    @if( $key == 0 )
                        @if( $val->status == "perubahan" ) 
                            <b style="color:green;">V</b> 
                        @endif
                    @endif
                </td>
                <td class="text-center" style="width: 20%">
                    Ditangguhkan ***
                    @if( $key == 0 )
                        @if( $val->status == "ditangguhkan" ) 
                            <b style="color:green;">V</b> 
                        @endif
                    @endif
                </td>
                <td class="text-center" style="width: 20%">
                    Tidak Disetujui ****
                    @if( $key == 0 )
                        @if( $val->status == "ditolak" ) 
                            <b style="color:green;">V</b> 
                        @endif
                    @endif
                </td>
                <td class="text-center">
                    Pejabat
                </td>
            </tr>
            <tr style="height: 50%">
                <td class="text-center">
                    @if( $key == 0 )
                        @if( $val->status == "disetujui" )
                            <p class="text-center">{{ $val->struktur->nama }}</p>
                            <br>
                            <br>
                            <p class="text-center"><u>{{ $val->pegawai->nama }}</u></p>
                            <p class="text-center">NIP. {{ $val->pegawai->nip }}</p>
                        @endif
                    @else
                        @if( $val->status == "disetujui" )  
                            <p class="text-center"><b style="color:green;">V</b></p>
                        @endif
                    @endif
                </td>
                <td>
                    @if( $key == 0 )
                        @if( $val->status == "perubahan" )
                            <p class="text-left">Tanggal :  {{ \Carbon\Carbon::parse($val->tgl_awal)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($val->tgl_akhir)->format('d-m-Y')}}</p>
                            <p class="text-left">Alasan : <i>{{ $val->alasan }}</i></p>
                            <p class="text-center">{{ $val->struktur->nama }}</p>
                            <br>
                            <br>
                            <p class="text-center"><u>{{ $val->pegawai->nama }}</u></p>
                            <p class="text-center">NIP. {{ $val->pegawai->nip }}</p>
                        @endif
                    @else
                        @if( $val->status == "perubahan" )  
                            <p class="text-center"><b style="color:green;">V</b></p>
                            <p class="text-left">Tanggal :  {{ \Carbon\Carbon::parse($val->tgl_awal)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($val->tgl_akhir)->format('d-m-Y')}}</p>
                            <p class="text-left">Alasan : <i>{{ $val->alasan }}</i></p>
                        @endif
                    @endif
                </td>
                <td>
                    @if( $key == 0 )
                        @if( $val->status == "ditangguhkan" )
                            <p class="text-left">Tanggal :  {{ \Carbon\Carbon::parse($val->tgl_awal)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($val->tgl_akhir)->format('d-m-Y')}}</p>
                            <p class="text-left">Alasan : <i>{{ $val->alasan }}</i></p>
                            <p class="text-center">{{ $val->struktur->nama }}</p>
                            <br>
                            <br>
                            <p class="text-center"><u>{{ $val->pegawai->nama }}</u></p>
                            <p class="text-center">NIP. {{ $val->pegawai->nip }}</p>
                        @endif
                    @else
                        @if( $val->status == "ditangguhkan" )  
                            <p class="text-center"><b style="color:green;">V</b></p>
                            <p class="text-left">Tanggal :  {{ \Carbon\Carbon::parse($val->tgl_awal)->format('d-m-Y')}} - {{ \Carbon\Carbon::parse($val->tgl_akhir)->format('d-m-Y')}}</p>
                            <p class="text-left">Alasan : <i>{{ $val->alasan }}</i></p>
                        @endif
                    @endif
                </td>
                <td>
                    @if( $key == 0 )
                        @if( $val->status == "ditolak" )
                            <p class="text-center">Alasan : <i>{{ $val->alasan }}</i></p>
                            <p class="text-center">{{ $val->struktur->nama }}</p>
                            <br>
                            <br>
                            <p class="text-center"><u>{{ $val->pegawai->nama }}</u></p>
                            <p class="text-center">NIP. {{ $val->pegawai->nip }}</p>
                        @else
                        <br><br><br><br><br><br>
                        @endif
                    @else
                        @if( $val->status == "ditolak" )  
                            <p class="text-center"><b style="color:green;">V</b></p>
                            <p class="text-center">Alasan : <i>{{ $val->alasan }}</i></p>
                        @else
                        <br><br><br><br><br><br>
                        @endif
                    @endif
                </td>
                <td>
                    @if($key == 2)
                        {{-- @if($val->status != "menunggu") --}}
                            <p class="text-center">{{ $val->struktur->nama }}</p>
                            <br>
                            <br>
                            <p class="text-center"><u>{{ $val->pegawai->nama }}</u></p>
                            <p class="text-center">NIP. {{ $val->pegawai->nip }}</p>
                        {{-- @endif --}}
                    @else
                            {{-- @if(isset($data['cuti']->approve_cuti[1]->struktur->nama)) --}}
                                {{-- @if($data['cuti']->approve_cuti[1]->status != "menunggu") --}}
                                    <p class="text-center">{{ $data['cuti']->approve_cuti[1]->struktur->nama }}</p>
                                    <br>
                                    <br>
                                    <p class="text-center"><u>{{ $data['cuti']->approve_cuti[1]->pegawai->nama }}</u></p>
                                    <p class="text-center">NIP. {{ $data['cuti']->approve_cuti[1]->pegawai->nip }}</p>
                                {{-- @else
                                <br><br><br><br><br><br>
                                @endif --}}
                            {{-- @else
                            <br><br><br><br><br><br>
                            @endif --}}
                    @endif
                </td>
            </tr>
        </table>
        @endif
        @endforeach
        {{-- <table >
            <tr>
                <th colspan="3">IX.Keputusan Pejabat Yang Berwenang Memberikan Cuti **<th>
            </tr>
            <tr>
                <td class="text-center">Disetujui</td>
                <td class="text-center">Perubahan ***</td>
                <td class="text-center">Ditangguhkan ***</td>
                <td class="text-center">Tidak Disetujui ****</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <p class="text-center">Pejabat</p>
                    <br>
                    <br>
                    <p class="text-center"><u>.........................................</u></p>
                    <p class="text-center">NIP. .....................</p>
                </td>
            </tr>
        </table> --}}
        <table>
            <tr>
                <td colspan="3">Catatan : </td>
            </tr>
            <tr>
                <td>*</td>
                <td class="text-center">:</td>
                <td>Coret yang tidak perlu</td>
            </tr>
            <tr>
                <td>**</td>
                <td class="text-center">:</td>
                <td>Pilih salah satu dengan memberi tanda ceklis</td>
            </tr>
            <tr>
                <td>***</td>
                <td class="text-center">:</td>
                <td>Diisi oleh pejabat yang menangani bidang kepegawaian PNS mengajukan cuti</td>
            </tr>
            <tr>
                <td>****</td>
                <td class="text-center">:</td>
                <td>Diberi tanda ceklis dan alasannya</td>
            </tr>
            <tr>
                <td>N</td>
                <td class="text-center">:</td>
                <td>Cuti tahun berjalan</td>
            </tr>
            <tr>
                <td>N-1</td>
                <td class="text-center">:</td>
                <td>Cuti 1 tahun sebelumnya</td>
            </tr>
        </table>
    </div>
</body>
</html>