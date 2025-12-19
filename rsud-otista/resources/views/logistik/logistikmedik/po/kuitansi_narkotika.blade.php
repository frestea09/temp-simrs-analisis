<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi PO</title>

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
  				{{-- {{ config('app.nama') }} <br> {{ config('app.kota') }} <br>
                  {{ config('app.alamat') }} --}}
                  <h4 class="text-center"><u>SURAT PESANAN NARKOTIKA</u></h4>
  			</div>
  		</div>
          <br>
		<div class="row">
			<div class="col-sm-12">
				<p>
					Yang bertanda Tangan Dibawah Ini :
				</p>
				<table style="width:100%;">
					<tbody>
						<tr>
							<td style="width: 15%">Nama</td><td style="width: 35%">: {{ $pegawai->nama }}</td>
						</tr>
						<tr>
							<td style="width: 15%">Jabatan</td><td style="width: 35%">: {{ $pegawai->kompetensi }}</td>
						</tr>
						<tr>
							<td style="width: 15%">Alamat</td><td style="width: 35%">: {{ $pegawai->alamat }}</td>
						</tr>
					</tbody>
				</table>
				<p>
					Mengajukan Pesanan Narkotika Kepada:
				</p>
				<table style="width:100%;">
					<tbody>
						<tr>
							<td style="width: 15%">Nama Distributor</td>
							<td style="width: 35%">: {{ $po->supplier }}</td>
						</tr>
						<tr>
							<td style="width: 15%">Alamat</td>
							<td style="width: 35%">: {{ \App\Logistik\LogistikSupplier::where('nama', 'like', '%'.$po->supplier.'%')->first()->alamat }}, {{ \App\Logistik\LogistikSupplier::where('nama', 'like',  '%'.$po->supplier.'%')->first()->nohp }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<p>
            Sebagai Berikut :
        </p>
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
									<td>{{ $d->satBeli->nama }}</td>
									<td>{{ $d->keterangan }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
        <p>
            Narkotika tersebut akan dipergunkan untuk keperluan Apotik.
        </p>
		<table style="width:100%; margin-bottom: -10px;">
			<tbody>
				<tr>
					<th class="text-center" style="width:40%">
					<br>
					<br>
					<br>

					</th>
					<th class="text-center" style="width:40%">
						
						
					</th>
					<th class="text-center" style="width:40%">
						<h6 style="font-size: 60%;">Makassar, {{ date('d-m-Y') }}</h6>
						<h6 style="font-size: 60%;">Pemesan,</h6>
					<br>
					<br>
					<br>
					<u>{{ $pegawai->nama }}</u><br>
					SIPA. {{ $pegawai->sip }}
					</th>
				</tr>
			</tbody>
		</table>

	</div>
  </body>
</html>
