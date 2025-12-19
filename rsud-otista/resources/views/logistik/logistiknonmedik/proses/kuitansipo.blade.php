<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi PO NONMEDIK</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 8pt;
		}
    </style>
  </head>

  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-sm-12">
  				RUMAH SAKIT UMUM DAERAH 45 <br> KABUPATEN KUNINGAN <br>
  				Jl. Jendral Sudirman No. 68 Kuningan Tlp. (0232) 871885
  			</div>
  		</div>
  		<br>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="width: 15%">Nomor Pesanan</td><td style="width: 35%">: {{ $po->no_po }}</td>
						<td colspan="2">Kuningan, {{ tgl_indo($po->tanggal) }}
					</tr>
					<tr>
						<td>Sifat </td><td>: Reguler / Cito</td>
						<td colspan="2">Kepada Yth. {{ $po->supplier }}
					</tr>
					{{--  <tr>
						<td>Hal</td><td>: Belanja Bahan Obat-obatan</td>
						<td colspan="2">{{ \App\Logistik\LogistikSupplier::where('nama', 'like', '%'.$po->supplier.'%')->first()->alamat }}</td>
					</tr>  --}}
					{{--  <tr>
						<td>Kode Rekening</td> <td>: {{ $po->kode_rekening }}</td>
						<td colspan="2">{{ \App\Logistik\LogistikSupplier::where('nama', 'like',  '%'.$po->supplier.'%')->first()->nohp }}</td>
					</tr>  --}}
					<tr>
						<td>Jenis Pengadaan</td> <td>: {{ $po->jenis_pengadaan }}</td>
					</tr>
					{{--  <tr>
						<td>Kategori Obat</td> <td>: {{ \App\Kategoriobat::find($po->kategori_obat)->nama }}</td>
					</tr>  --}}
				</tbody>
			</table>
		</div>
		</div>

		<br>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th>Nama Barang</th>
								<th class="text-center">Jumlah</th>
								<th>Satuan</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $d)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
									<td>{{ $d->barang->nama }}</td>
									<td class="text-center">{{ $d->jumlah }}</td>
									<td>{{ $d->satuan->nama }}</td>
									<td>{{ $d->keterangan }}</td>
								</tr>
							@endforeach
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<br>

	<div class="row">
		<div class="col-sm-12">
			{{--  <table style="width: 100%; ">
				<tr>
					@foreach ($pejabat as $user)
						<td style="25%" class="text-center">
							{{ $user->jabatan }}<br><br><br><br>
							{{ $user->nama }}<br>
							{{ $user->nip }}
						</td>
					@endforeach
				</tr>
			</table>  --}}
		</div>
	</div>

	</div>
  </body>
</html>
