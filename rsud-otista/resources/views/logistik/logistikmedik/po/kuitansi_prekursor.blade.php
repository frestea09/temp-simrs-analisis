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
			<table style="width:100%">
			<tr>
				{{-- <td class="text-right"></td> --}}
				<td class="text-center">
					<img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 50px;position:absolute;left:40">
					<b style="font-size:16px;">{{config('app.nama_kop_rs')}}</b><br>
					{{config('app.alamat_kop')}}<br/> Telp dan Fax {{ config('app.fax') }}/Phone {{configrs()->tlp}}/Email :Email: {{configrs()->email}}<br>
				</td>
			</tr>
			</table>
            <div class="col-sm-12 text-center">
                
                
                <hr>
            </div>
        </div>
  		{{-- <div class="row">
  			<div class="col-sm-12">
  				{{ config('app.nama') }} <br> {{ config('app.kota') }} <br>
  				{{ config('app.alamat') }}
  			</div>
  		</div> --}}
  		<br>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="width: 15%">Nomor SP</td><td style="width: 35%">: {{ $po->no_sp }}</td><br>
						{{-- <td style="width: 15%">Perihal</td><td style="width: 35%">: {{ $po->perihal }}</td><br>
						<td style="width: 15%"></td><td style="width: 35%">: {{ $po->no_sp }}</td><br> --}}
						<td >Kepada Yth : {{ $po->supplier }}<br>
							Di. Tempat<br>
			
						</td>
					</tr>
					<tr>
						<td style="width: 15%">Perihal</td><td style="width: 35%">: {{ $po->perihal }}</td>
					</tr>
					<tr>
						<td style="width: 15%">Lampiran</td><td style="width: 35%">: {{ $po->lampiran }}</td>
					</tr>
					
					
				</tbody>
			</table>
		</div>
		</div>

		<br> 
		<div class="row">
			<div class="col-sm-12 "> 
				Berdasarkan Usulan Dari Pejabat RSUD Oto Iskandar Di Nata Nomor:  {{ $po->no_usulan }}, 
             {{ date('d M Y') }}, Maka Dengan Ini Kami Mengatakan Pesanan Barang / Jasa Dengan Perincian Sebagai Berikut :
            </div>
			<br/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th>Nama Barang</th>
								<th>Satuan</th>
								<th>Merk</th>
								<th>Harga Satuan</th>
								<th>Diskon</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Total Harga Per Barang</th>
							</tr>
						</thead>
						<tbody>
							@php
								$sum = 0;
								
							@endphp
							@foreach ($data as $d)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
									<td>{{ $d->barang->nama }}</td>
									<td>{{ baca_satuan_beli($d->satuan) }}</td>
									<td></td>
									<td class="text-center">Rp. {{number_format($d->harga) }}</td>
									<td class="text-center">{{ $d->diskon_persen }}</td>
									<td class="text-center">{{ $d->jumlah }}</td>
									<td>Rp. {{ number_format($d->totalHarga) }}</td>
									@php
										$sum += $d->totalHarga;
										
									@endphp
								</tr>
							@endforeach
								 <tr>
									<td colspan="7" class="text-right">
										Total
									</td>
									<td colspan="1">
										Rp. {{ number_format($sum) }}
									</td>
								 </tr>
								 <tr>
									<td colspan="7" class="text-right">
										PPN 11%
									</td>
									<td colspan="1">
										@php
											$ppnAwal = $sum * 11 / 100;
											$ppnAkhir = $ppnAwal + $sum;
										@endphp
										Rp. {{ number_format($ppnAwal) }}
									</td>
								 </tr>
								 <tr>
									<td colspan="7" class="text-right">
										Total Keseluruhan
									</td>
									<td colspan="1">
										Rp. {{ number_format($ppnAkhir) }}
									</td>
								 </tr>
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<br>

	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%; ">
				<tr>
						@php
							$peg = App\LogistikPejabatPengadaan::all()
						@endphp
						<td style="25%" class="text-lrft">
							Pejabat Pembuat Komitmen<br><br><br><br><br><br>
							{{$peg[0]->nama }}<br>
							NIP:{{$peg[0]->nip }}<br>
							
						</td>

				</tr>
			</table>
		</div>
	</div>

	</div>
  </body>
</html>
