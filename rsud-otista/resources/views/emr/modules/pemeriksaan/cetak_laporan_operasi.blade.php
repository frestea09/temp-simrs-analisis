<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.5cm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .center-text {
            text-align: center;
            font-weight: bold;
        }
        .right-text {
            text-align: right;
            font-weight: bold;
        }
        .container {
            padding-top: 1%;
            padding-bottom: 1%;
        }
        .container-to-right {
            text-align: right;
            padding: 1% 1%;
        }
        .container-medium {
            width: 50%;
            padding: 1%;
        }
        .container-border {
            border: 1px solid black;
        }
        .container-custom-left {
            padding-top: 1%;
            padding-left: 0.8%;
        }
        .container-custom-bottom {
            padding-bottom: 7%;
        }
        .size-medium {
            width: 40%;
        }
        @media print {
          .page-break {
              page-break-before: always;
          }
    .hide-on-print {
        visibility: hidden;
    }

      }
    </style>
</head>
<body>
    <table style="width: 100%; padding: 10px;">
        <tr>
            <td rowspan="2" style="width: 20%; text-align:center; border:1px solid black; padding:10px;">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"><br>
                {{-- <b style="font-size:10px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                <b style="font-size:10px;">{{ strtoupper(configrs()->dinas) }}</b><br/> --}}
                <b style="font-size:10px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                <b style="font-size:7px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td rowspan="2" colspan="2" class="center-text" style="border:1px solid black;">LAPORAN OPERASI</td>
            <td rowspan="2" style="width: 30%; border:1px solid black; font-size:11px; padding:10px;">
                <b>No. RM</b> : {{ $pasien->no_rm }}<br><br>
                <b>Nama</b> : {{ $pasien->nama }} <span>{{ $pasien->kelamin }}</span><br><br>
                <b>Tgl. Lahir</b> : {{ $pasien->tgllahir }}<br><br>
                <b>Umur</b> : {{ hitung_umur($pasien->tgllahir) }}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 10px; margin-top: -15;">
        <tr>
            <td colspan="2" style="width: 50%;"><b>Ruang Operasi:</b> {{ $asessment['ruangOperasi'] ?? '' }}</td>
            <td colspan="2" style="width: 50%;"><b>Kamar:</b> {{ $asessment['kamar'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 50%;"><b>Cito/Terencana:</b> {{ $asessment['sifat'] ?? '' }}</td>
            <td colspan="2" style="width: 50%;"><b>Tanggal Operasi:</b> {{ $asessment['tglOperasi'] ?? '' }}</td>
        </tr>
        <tr>
            <td rowspan="2" style="width: 25%"><b>Pembedah:</b> {{ $asessment['pembedah'] ?? '' }}</td>
            <td style="width: 25%;"><b>Asisten I:</b> {{ $asessment['asisten1'] ?? '' }}</td>
            <td colspan="2" rowspan="2" style="width: 50%;"><b>Perawat Instrumen:</b> {{ $asessment['perawat_instrumen'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Asisten II:</b> {{ $asessment['asisten2'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Ahli Anestesi:</b> {{ $asessment['ahliAnestesi'] ?? '' }}</td>
            <td><b>Jenis Anestesi:</b> {{ $asessment['jenisAnastesi'] ?? '' }}</td>
            <td colspan="2" rowspan="2"><b>Obat-obatan Anestesi:</b> {{ $asessment['obatAnestesi'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Perawat Anestesi:</b> {{ $asessment['perawat_anestesi'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 50%;"><b>Diagnosa Pra-Bedah:</b> {{ $asessment['diagnosaPraBedah'] ?? '' }}</td>
            <td colspan="2" style="width: 50%;"><b>Indikasi Operasi:</b> {{ $asessment['indikasiOperasi'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 50%;"><b>Diagnosa Pasca-Bedah:</b> {{ $asessment['diagnosaPascaBedah'] ?? '' }}</td>
            <td colspan="2" style="width: 50%;"><b>Jenis Operasi:</b> {{ $asessment['jenisOperasi'] ?? '' }}</td>
        </tr>
        <tr>
            <td rowspan="2"><b>Desinfeksi kulit dengan:</b> {{ $asessment['desinfeksi'] ?? '' }}</td>
            <td><b>Jaringan dieksisi:</b> {{ $asessment['jaringanEksisi'] ?? '' }}</td>
            <td colspan="2" rowspan="2"><b>Gol. Operasi:</b> {{ $asessment['golOperasi'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Dikirim ke Bagian PA:</b>
                <div style="">
                    <div style="width:100%;">
                    <label for="dikirimKePA_1">
                        <input class="form-check-input"
                            name="fisik[dikirimKePA]" id="dikirimKePA_1"
                            type="radio" value="Ya"  {{ @$asessment['dikirimKePA'] == 'Ya' ? 'checked' : '' }} >
                        Ya
                    </label>
                    </div>
                    <div style="width:100%;">
                    <label for="dikirimKePA_2">
                        <input class="form-check-input"
                            name="fisik[dikirimKePA]" id="dikirimKePA_2"
                            type="radio" value="Tidak"  {{ @$asessment['dikirimKePA'] == 'Tidak' ? 'checked' : '' }} >
                        Tidak
                    </label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Jam Operasi Dimulai:</b> {{ $asessment['jamOperasiMulai'] ?? '' }}
                <b>Jam Operasi Selesai:</b> {{ $asessment['jamOperasiSelesai'] ?? '' }}
                <b>Lama Operasi Berlangsung:</b> {{ $asessment['lamaOperasi'] ?? '' }}
            </td>
            <td colspan="2"><b>Jenis Bahan yang dikirim ke laboratorium untuk pemeriksaan:</b> {{ $asessment['jenisBahan'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Macam Sayatan (bila perlu dengan gambar):</b> {{ $asessment['macamSayatan'] ?? '' }}</td>
            <td colspan="2"><b>Posisi Penderita:</b> {{ $asessment['posisiPenderita'] ?? '' }}</td>
        </tr>
        <tr style="height:150px;">
            <td colspan="4"><b>Singkatan kelainan/temuan:</b><br>{{ $asessment['singkatanKelainan'] ?? '' }}</td>
        </tr>
    </table>

    <div style="page-break-after: always;"></div>

    <table style="width: 100%; padding: 10px;">
        <tr>
            <td rowspan="2" style="width: 20%; text-align:center; border:1px solid black; padding:10px;">
                <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;"><br>
                {{-- <b style="font-size:10px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                <b style="font-size:10px;">{{ strtoupper(configrs()->dinas) }}</b><br/> --}}
                <b style="font-size:10px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                <b style="font-size:7px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td rowspan="2" colspan="2" class="center-text" style="border:1px solid black;">LAPORAN OPERASI</td>
            <td rowspan="2" style="width: 30%; border:1px solid black; font-size:11px; padding:10px;">
                <b>No. RM</b> : {{ $pasien->no_rm }}<br><br>
                <b>Nama</b> : {{ $pasien->nama }} <span>{{ $pasien->kelamin }}</span><br><br>
                <b>Tgl. Lahir</b> : {{ $pasien->tgllahir }}<br><br>
                <b>Umur</b> : {{ hitung_umur($pasien->tgllahir) }}
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 10px; text-align: center; margin-top: -15;">
        <tr>
            <td colspan="2" style="text-align: center;"><b>Laporan Operasi Lengkap (Riwayat perjalanan Operas yang terperinci dan lengkap)</b></td>
        </tr>
        <tr>
            <td colspan="2"><b>Teknik Operasi dan Temuan Intra-Operasi:</b><br>{{ $asessment['teknikOperasi'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Instruksi Anestesi:</b><br>{{ $asessment['instruksiAnestesi'] ?? '' }}</td>
        </tr>
    </table>
    
    <table style="width: 100%; padding: 10px; text-align: center; margin-top: -15; border: 1px solid black;">
        <tr>
            <td colspan="2" style="border: none; text-align: left;"><b>Instruksi Pasca Bedah:</b></td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">1. Kontrol: {{ $asessment['instruksi_pasca_bedah']['kontrol'] ?? '' }}</td>
            <td style="border: none; text-align: left;">5. Obat-obatan: {{ $asessment['instruksi_pasca_bedah']['obat_obatan'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">2. Puasa: {{ $asessment['instruksi_pasca_bedah']['puasa'] ?? '' }}</td>
            <td style="border: none; text-align: left;">6. Ganti Balutan: {{ $asessment['instruksi_pasca_bedah']['gantiBalutan'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">3. Drain: {{ $asessment['instruksi_pasca_bedah']['drain'] ?? '' }}</td>
            <td style="border: none; text-align: left;">7. Lain-lain: {{ $asessment['instruksi_pasca_bedah']['lainLain'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: left;">4. Infus: {{ $asessment['instruksi_pasca_bedah']['infus'] ?? '' }}</td>
            <td style="border: none;"></td>
        </tr>
    </table>

    <br>
    <table style="width: 100%; border-collapse: collapse; border: none; margin-top: 10px; padding: 10px;">
        <tr style="border: none;">
            <td style="border: none; text-align: left; width: 50%;">
                <b>Pembuat Laporan:</b><br><br><br>
                <u>{{ $asessment['pembedah'] ?? '' }}</u>
            </td>
            <td style="border: none; text-align: right; width: 50%;">
                <b>Soreang, {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</b><br><br><br>
                <u>{{ $asessment['pembedah'] ?? '' }}</u>
            </td>
        </tr>
    </table>

</body>
</html>