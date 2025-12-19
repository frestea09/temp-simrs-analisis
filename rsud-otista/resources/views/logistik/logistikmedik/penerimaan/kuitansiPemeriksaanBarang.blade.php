<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Penerimaan</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 9pt;
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
            <h5>BERITA ACARA PEMERIKSAAN BARANG</h5>
            <h6> Nomor : {{ $barang->no_bapb }}</h6>
            <br>
        </div>
		<p style="width: 100%">
            Pada hari ini {{ !empty($barang->created_at) ? $barang->created_at : '' }}, bertempat di {{configrs()->nama}}, dasar Keputusan Direktur {{configrs()->nama}} Nomor : 510.2/34/Sekretariat/2019, tgl. 9 Januari 2019, yang bertanda tangan dibawah ini Panitia Penerima Hasil Pekerjaan ( PPHP ). 
            Masing-masing sesuai  hak dan kewenangannya, menyatakan dengan sebenarnya telah melaksanakan pemeriksaan hasil pengadaan Barang/Jasa Bahan Pelayanan yang dilakukan oleh Panitia Pengadaan sesuai dengan ketentuan terhadap realisasi Surat Pesanan : Nomor : {{ !empty($barang->no_po) ? $barang->no_po :'' }} dengan spesifikasi sebagai berikut : 
		</p>
		
		<br>
		<p style="width: 100%">
			Hasil Pemeriksaan diyatakan
                a. Bak
                b. Kurang/Tidak Baik
            Yang selanjutnya menyerahkan aset hasil pengadaan barang/jasa kepada direktur melalui Pejabat Pembuat Komitmen/ PPK.

            Demikian Berita Acara ini dibuat dalam rangkap 4 (empat) untuk dipergunakan sebagaimana mestinya.	
		</p>
        <br>
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Faktur</th>
                    <th>Nama Obat</th>
                    <th>Satuan</th>
                    <th>Stok Gudang</th>
                    <th class="text-center">Jumlah Dipesan</th>
                    <th class="text-center">Jumlah Dikirim</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no =1;
                @endphp
                @foreach ($baranglist as $d)
                    @php
                        $obat = \App\Masterobat::where('nama', $d->nama)->first();
                    @endphp
                    <tr>
                        <th>{{ $no++ }}</th>
                        <td>{{ $d->no_faktur }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->satuan }}</td>
                        <td>{{ !empty(\App\Logistik\LogistikStock::where('masterobat_id', $obat->id)->latest()->first()->total) ? \App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $obat->id)->latest()->first()->total: 0}}</td>
                        <td class="text-center">{{ $d->jumlah }}</td>
                        <td class="text-center">{{ $d->kondisi }}</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table style="width: 20%; float: left">
			<tbody>
				<tr>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th class="text-center" style="font-size: 10px;">PENYEDIA BARANG/JASA</th>
				</tr>
				<tr>
					<th class="text-center" style="font-size: 10px;">{{ $barang->saplier }}</th>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th class="text-center"><br><br><br><br>(_________________)</th>
					<th class="text-center"> </th>
				</tr>
			</tbody>
        </table>
        <table style="width: 70%; float: right">
            <tr>
                @foreach ($pegawai as $user)
                    <td style="font-size: 11px;" class="text-center">
                        {{ $user->jabatan }}<br><br><br><br><br><br>
                        {{ $user->nama }}<br>
                        {{ $user->nip }}
                    </td>
                @endforeach
            </tr>
        </table>
		{{-- <table style="width: 50%; float: right">
			<tbody>
				<tr>
					<th class="text-center"></th>
					<th class="text-center">Kuningan, {{ !empty($barang->created_at) ? $barang->created_at : '' }}</th>
				</tr>
				<tr>
                    <th></th>
					<th class="text-center">PANITIA PEMERIKSA BARANG</th>
				</tr>
				<tr>
					<th class="text-center"></th>
					<th class="text-center">{{ $barang->saplier }}</th>
				</tr>
				<tr>
					<th class="text-center"></th>
                    <th class="text-center" style="margin-bottom: -900px">
                        @foreach ($pegawai as $d)
                            <br>{{ $d->nama }}<br><br>
                        @endforeach
                    </th>
				</tr>
			</tbody>
		</table> --}}
	</div>
  </body>
</html>
