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
  	<div class="container">
		<div class="col-sm-12 text-center">
            <h6>PEMERINTAH KABUPATEN KUNINGAN</h6>
            <h6>{{ configrs()->nama }}</h6>
            <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
            <hr>
            <h5>BERITA ACARA PENERIMAAN BARANG</h5>
            <br>
        </div>
		<br>
		<p style="width: 100%">
			Pada hari ini {{ !empty($pemeriksa->created_at) ? $pemeriksa->created_at : '' }}, dasar Keputusan Bupati Kuningan Nomor : {{ $pegawai->sk }}, tgl. 01 Januari 2018, yang bertanda tangan dibawah ini :
		</p>
		<table style="width: 100%">
			<tbody>
				<tr>
					<th style="width: 5%">Nama</th>
					<th style="width: 5%">:</th>
					<th>{{ $pegawai->nama }}</th>
				</tr>
				<tr>
					<th style="width: 5%">Jabatan</th>
					<th style="width: 5%">:</th>
					<th>{{ $pegawai->jabatan }}</th>
				</tr>
			</tbody>
		</table>
		<br>
		<p style="width: 100%">
			Menyatakan dengan sesungguhnya bahwa saya menerima barang yang diserahkan  Panitia Pengadaan Barang dari Rekanan {{configrs()->nama}} : 
			sesuai dengan isi BERITA ACARA PEMERIKSAAN BARANG, Nomor : {{ !empty($pemeriksa->no_bapb) ? $pemeriksa->no_bapb : '' }}  tanggal:  dengan nama barang terlampir dalam BAPB	
		</p>
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
		<p style="width: 100%">
			Demikianlah Berita Acara Penerimaan Barang ini dibuat rangkap 4 (empat) untuk dipergunakan sebagaimana mestinya.
		</p>
		<br>
		<table style="width: 100%">
			<tbody>
				<tr>
					<th class="text-center"></th>
					<th class="text-center">Kuningan, {{ !empty($pemeriksa->created_at) ? $pemeriksa->created_at : '' }}</th>
				</tr>
				<tr>
					<th class="text-center">Yang Menyerahkan</th>
					<th class="text-center">Yang Menerima</th>
				</tr>
				<tr>
					<th class="text-center">Panitia Pengadaan/ PPK Medis</th>
					<th class="text-center">Bendahara Barang RSUD 45</th>
				</tr>
				<tr>
					<th class="text-center"><br><br><br><br><br></th>
					<th class="text-center"><br><br><br><br><br></th>
				</tr>
				<tr>
					<th class="text-center">{{ !empty($pegawaiPPKMedis)? $pegawaiPPKMedis->nama :'' }}</th>
					<th class="text-center">{{ !empty($pegawai)? $pegawai->nama :'' }}</th>
				</tr>
			</tbody>
		</table>

	</div>
  </body>
</html>
