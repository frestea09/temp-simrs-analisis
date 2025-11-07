<html>
<head>
    <meta charset="utf-8">
    <title>Cetak SPK</title>
    <!-- Bootstrap 3.3.7 -->
    <!-- {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}} -->
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
        @page {
            margin-top: 1cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }
    </style>

</head>

<body>
    <table style="width: 100%; margin-left: 10px;">
        <tr>
            <td style="width:30%;">
                <img src="{{ public_path('images/1522307566LOGO KABUPATEN KUNINGAN.png') }}" style="width: 100px; float: left;">
            </td>
            <td class="text-center" style="width:30%; font-weight: bold;">
                <img src="{{ public_path('images/logorsud.png') }}" style="width: 100px; float: right;">
            </td>
        </tr>
    </table>

    <div class="row">
        <div class="col-sm-12 text-center">
            <h6>PEMERINTAH KABUPATEN KUNINGAN</h6>
            <h6>{{ configrs()->nama }}</h6>
            <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
            <hr>
            <h5>SURAT PERINTAH KERJA</h5>
            <h6>no</h6>
            <br>
        </div>
        <table style="width: 100%;">
            <tbody class="table table-borderless">
                <tr>
                    <td> Nama</td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td> Jabatan </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td> Alamat </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td> Untuk mengerjakan </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td>Terbilang </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td>Waktu Pelaksanaan </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td>Terhitung mulai Tanggal </td>
                    <td>:</td>
                    <td> </td>
                </tr>
                <tr>
                    <td>Sampai dengan Tanggal </td>
                    <td>:</td>
                    <td> </td>
                </tr>
            </tbody>
        </table>
        Dengan ketentuan sebagai berikut :
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td> 1.</td>
                    <td>Harga tersebut diatas sudah termasuk pajak – pajak dan ongkos angkut sampai tiba di gudang RSUD ’45 Kuningan</td>
                </tr>
                <tr>
                    <td> 2.</td>
                    <td>Pengadaan barang tersebut tidak dibenarkan diborongkan kembali kepada pihak lain baik sebagian, maupun keseluruhan</td>
                </tr>
                <tr>
                    <td> 3.</td>
                    <td>Pelaksanaan pembayaran dibebankan kepada anggaran : ________________________________ Kode Rekening ;______________________ Tahun anggaran :___________sebagai berikut :</td>
                    
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    a. Pembayaran pertama dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. </td>
                            </tr>
                            <tr>
                                <td> 
                                    b. Pembayaran kedua dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. </td>
                            </tr>
                            <tr>
                                <td>
                                    c. Pembayaran ketiga dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. </td>
                            </tr>
                            <tr>
                                <td>
                                    d. Pembayaran keempat dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. </td>
                            </tr>
                            <tr>
                                <td>
                                    e. Jumlah Total
                                </td>
                                <td>Rp. </td>
                            </tr>
                        </tbody>
                    </table>
                </tr>
                <tr>
                    <td> 4.</td>
                    <td>Merk, Type dan ukuran barang tersebut diatas harus sesuai dengan petunjuk dan permintaan dari RSUD ’45 Kuningan</td>
                </tr>
                <tr>
                    <td> 5.</td>
                    <td>Apabila pihak rekanan/penyedia barang tidak dapat mengadakan barang dalam waktu yang sudah ditetapkan diatas, maka kepada rekanan dikenakan denda keterlambatan pekerjaan sesuai ketentuan yang berlaku.</td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>