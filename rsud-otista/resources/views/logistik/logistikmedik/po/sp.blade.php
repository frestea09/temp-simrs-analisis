<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak SP</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 8pt;
		}
		@page {
			padding-bottom: 3cm;
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
					<img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 50px;position:absolute;left:20"><br>
					<h5><b> PEMERINTAH KABUPATEN BANDUNG</b></h5>
					<b style="font-size:16px;">{{config('app.nama_kop_rs')}}</b><br>
					{{config('app.alamat_kop')}}<br/> Telp: {{configrs()->tlp}},Email: {{configrs()->email}}<br>
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
						<td style="width: 20%; padding-bottom: 60px">
							<p>Nomor SP :{{ @$no_sp ?? $po->no_sp }}</p>
							<p>Lampiran :{{ $po->lampiran }}</p>
							Perihal  :{{ $po->perihal }}
						</td>
						<td style="padding-left: 40%;width: 30%">
							<p>Soreang, {{ @$tanggal_cetak_sp ?? $po->tanggal }}</p>
							<p style="padding-top: 1px">Kepada Yth</p>
							<p style="padding-top: 1px">{{ $po->supplier }}</p>
							<p style="padding-top: 1px">Di</p>
							<p style="padding-top: 1px">Tempat</p>
			
						</td>
					</tr>
					
					
				</tbody>
			</table>
		</div>
		</div>
		<div class="row">
			<div class="col-sm-12 "> 
				Berdasarkan Usulan Dari Pejabat RSUD Oto Iskandar Di Nata Nomor:  {{ @$no_usulan_cetak_sp ?? $po->no_usulan }}, 
             {{ @$tanggal_cetak_sp ?? $po->tanggal }}, Maka Dengan Ini Kami Mengatakan Pesanan Barang / Jasa Dengan Perincian Sebagai Berikut :
            </div>
			<br/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th class="text-center">No</th>
								{{-- <th>No PO</th> --}}
								<th>Nama Barang</th>
								{{-- <th>Satuan</th> --}}
								<th>Harga Satuan</th>
								<th>Diskon</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Jumlah Harga</th>
							</tr>
						</thead>
						<tbody>
							@php
								$sum = 0;
								$no = 1;
							@endphp
							@foreach ($data as $d)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
									{{-- <td>{{ $d->no_po }}</td> --}}
									<td>{{ $d->barang->nama }}</td>
									{{-- <td>{{ baca_satuan_beli($d->satuan) }}</td> --}}
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
									<td colspan="5" class="text-right">
										Total
									</td>
									<td colspan="3" class="text-right">
										Rp. {{ number_format($sum) }}
									</td>
								 </tr>
								 <tr>
									<td colspan="5" class="text-right">
										{{-- PPN {{ $po->jml_ppn ?? 0 }}% --}}
										PPN 11%
									</td>
									<td colspan="3" class="text-right">
										@php
											$ppnAwal = $sum * 11 / 100;
											$ppnAkhir = $ppnAwal + $sum;
										@endphp
										Rp. {{ number_format($ppnAwal) }}
									</td>
								 </tr>
								 <tr>
									<td colspan="5" class="text-right">
										Total Keseluruhan
									</td>
									<td colspan="3" class="text-right">
										Rp. {{ number_format($ppnAkhir) }}
									</td>
								 </tr>
								 <tr>
									<td colspan="1" class="text-right">
										Terbilang
									</td>
									<td colspan="7">
										{{ terbilang($ppnAkhir) }} Rupiah
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
					<tr class="text-left">
							
							<td style="25%">
								<p>Demikian surat pesanan ini dibuat untuk dapat di gunakan sebagai mana semestinya</p>
							</td>
	
					</tr>
				</table>
			</div>
		</div>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%; ">
				<tr class="text-right">
						@php
							$peg = App\LogistikPejabatPengadaan::all();
                			$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($peg[0]->nama . ' | ' . $peg[0]->nip));
						@endphp
						<td style="25%" class="text-lrft">
							Pejabat Pembuat Komitmen<br><br><br>
              				<img src="data:image/png;base64, {!! $base64 !!} "> <br>
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
