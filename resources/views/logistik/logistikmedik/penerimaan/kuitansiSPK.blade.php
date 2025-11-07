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
                <img src="{{ asset('images/'.configrs()->logo) }}" style="width: 100px; float: left;">
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
            <h6>{{ !empty($spk->nomor) ? $spk->nomor : '' }}</h6>
            <br>
        </div>
        <table>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $spk->nama_jabatan }}</td>
                </tr>
                <tr>
                    <td>Jabatan </td>
                    <td>:</td>
                    <td>{{ $spk->jabatan }}</td>
                </tr>
                <tr>
                    <td> Alamat </td>
                    <td>:</td>
                    <td> {{ $spk->alamat }} </td>
                </tr>
                <tr>
                    <td> Untuk mengerjakan </td>
                    <td>:</td>
                    <td> {!! $spk->mengerjakan  !!} </td>
                </tr>
                <tr>
                    <td> No Spk </td>
                    <td>:</td>
                    <td> {{ $spk->no_po }} </td>
                </tr>
                <tr>
                    <td>Terbilang </td>
                    <td>:</td>
                    <td> {{ $spk->terbilang }} </td>
                </tr>
                <tr>
                    <td>Waktu Pelaksanaan </td>
                    <td>:</td>
                    <td> {{ $spk->waktu_pelaksanaan }} {{ $spk->waktu_hari }} </td>
                </tr>
                <tr>
                    <td>Terhitung mulai Tanggal </td>
                    <td>:</td>
                    <td> {{ $spk->mulai_tanggal }} </td>
                </tr>
                <tr>
                    <td>Sampai dengan Tanggal </td>
                    <td>:</td>
                    <td> {{ $spk->sampai_tanggal }} </td>
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
                    <td>Apabila pihak rekanan/penyedia barang tidak dapat mengadakan barang dalam waktu yang sudah ditetapkan diatas, maka kepada rekanan dikenakan denda keterlambatan pekerjaan sesuai ketentuan yang berlaku.</td>
                </tr>
                    {{-- <table>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $no++ }} Jumlah Pembayaran No Faktur {{ $item->no_faktur }} Sebesar 
                                    </td>
                                    <td>Rp. {{ number_format($item->hpp) }}</td>
                                </tr>
                            @endforeach
                            
                            <tr>
                                <td> 
                                    b. Pembayaran kedua dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. {{ $spk->pembayarana_kedua }}</td>
                            </tr>
                            <tr>
                                <td>
                                    c. Pembayaran ketiga dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. {{ $spk->pembayarana_ketiga }}</td>
                            </tr>
                            <tr>
                                <td>
                                    d. Pembayaran keempat dapat dilaksanakan sebesar
                                </td>
                                <td>Rp. {{ $spk->pembayarana_keempat }}</td>
                            </tr>
                            <tr>
                                <td>
                                    e. Jumlah Total
                                </td>
                                <td>Rp. {{ $spk->total_pembayarana }}</td>
                            </tr>
                        </tbody>
                    </table> --}}
                <tr>
                    <td> 4.</td>
                    <td>Merk, Type dan ukuran barang tersebut diatas harus sesuai dengan petunjuk dan permintaan dari RSUD ’45 Kuningan</td>
                </tr>
                <tr>
                    <td valign="top"> 5.</td>
                    <td>Pelaksanaan pembayaran dibebankan kepada anggaran : {{ $spk->anggaran }} Kode Rekening : {{ $spk->kode_rekening }} Tahun anggaran : {{ $spk->tahun_anggaran }} Dengan Pembayaran sebagai berikut :<br>
                    <table>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>No Faktur {{ $item->no_faktur }} Sebesar Rp. {{ number_format(\App\Logistik\LogistikPenerimaan::where('no_faktur',$item->no_faktur)->sum('total_hna')) }}</td>
                                    <td>
                                        PPN Rp. {{ number_format(\App\Logistik\LogistikPenerimaan::where('no_faktur',$item->no_faktur)->sum('ppn')) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="1"> 
                                    Jumlah Total Rp. <b><u>{{ number_format($total) }}</u></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table><br>
        <table style="width: 100%">
			<tbody>
				<tr>
					<td class="text-center"></td>
					<td class="text-center">Kuningan, {{ !empty($spk->created_at) ? $spk->created_at : '' }}</td>
				</tr>
				<tr>
					<td class="text-center">Yang Menerima Perintah / Penyedia</td>
					<td class="text-center">Yang Memberi Perintah</td>
				</tr>
				<tr>
					<td class="text-center">{{ $spk->nama }}</td>
					<td class="text-center">{{ $pegawai_pengadaan->jabatan }}<br> {{configrs()->nama}}</td>
				</tr>
				<tr>
					<td class="text-center"><br><br><br><br><br></td>
					<td class="text-center"><br><br><br><br><br></td>
				</tr>
				<tr>
					<td class="text-center">(_____________________)</td>
					<td class="text-center"><u>{{ $pegawai_pengadaan->nama }}</u></td>
                </tr>
                <tr>
					<td class="text-center"></td>
					<td class="text-center">{{ $pegawai_pengadaan->nip }}</td>
				</tr>
			</tbody>
		</table>
    </div>
</body>

</html>