<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Berita Acara</title>

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
  		<br>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%;">
				<tbody>
					<tr>
                        <td class="text-center">
                            <h5><b>BERITA ACARA PENERIMA DAN PEMERIKSAAN BARANG</b></h5>
                            <h5><b>{{ $po->no_sp }}</b></h5>
                        </td>
                    </tr>
					
					
				</tbody>
			</table>
		</div>
		</div>

		<br> 
		<div class="row">
			<div class="col-sm-12 "> 
				<p>
                    Pada hari. Bertempat di Rumah Umum Daerah Oto Iskandar Di Nata.Berdasarkan Keputusan Direktur Rumah Sakit
                    Umum Daerah Oto Iskandar Di Nata Nomor : yang bertanda tangan di bawah ini Pejabat Pembuat Komitmen Yang Bersumber Dari Pendapatan
                    Fungsional Rumah Sakit Umum Daerah Oto Iskandar Di Nata
                </p>
            </div>
            <div class="col-sm-12 "> 
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <h5>Nama Perusahaan     : {{ $po->supplier }}</h5>
                                <h5>Alamat Perusahaan   :</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 "> 
				Berdasarkan realisasi dari Surat Pesanan dari Pejabat Pembuat Komitmen Nomor:  {{ $po->no_sp }}/ 
             {{ $po->tanggal }}, dengan jumlah dan jenis baranag berikut :
            </div>
			<br/>
			<div class="col-sm-8">
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th>No PO</th>
								<th>Nama Barang</th>
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
									<td>{{ $d->no_po }}</td>
									<td>{{ $d->barang->nama }}</td>
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
								<p>Demikian Berita Acara Pemeriksaan Barang Ini , di buat dalam rangkap 4  (empat) untuk di pergunakan sebagaimana mestinya</p>
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
							$peg = App\LogistikPejabatPengadaan::all()
						@endphp
                        <td style="25%" class="text-left">
							Penyedia Barang / Jasa<br><br><br><br><br><br>
							{{$po->supplier }}<br>
							
							
						</td>
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



    <div class="container">
	<div class="row" style="padding-top: 400px">
		<div class="col-sm-12">
			<table style="width: 100%;">
				<tbody>
					<tr>
                        <td class="text-center">
                            <h5><b>BERITA ACARA PEMERIKSAAN BARANG</b></h5>
                            <h5><b>{{ $po->no_sp }}</b></h5>
                        </td>
                    </tr>
					
					
				</tbody>
			</table>
		</div>
		</div>
		
		<br> 
		<div class="row">
			<div class="col-sm-12 "> 
				<p>
                    Pada hari {{ date('d-M-Y') }}. Bertempat di {{config('app.nama_kop_rs')}}.Berdasarkan Keputusan Direktur {{config('app.nama_kop_rs')}}
                	NOMOR : PA. 01/995/TU/2022 yang bertanda tangan di bawah ini <b>Tim Teknis Pemeriksa Barang/Jasa</b> Yang Bersumber Dari Pendapatan
					Fungsional {{config('app.nama_kop_rs')}}, telah meaksanakan Pemeriksaan Barang Sebagai Realisasi Surat Pesanan dari Pejabat
					Pembuat Komitmen Nomor: 027/ 40 -FAR/PPK-RSUD OTISTA /III/2023 tanggal {{ date('d-M-Y') }} dengan keterangan : Jenis Barang Dan Jumlah Barang Sesuai Dengan Surat Pesanan
					
                </p>
            </div>
			<br/>
		</div>
		<br>
	<div class="row">
			<div class="col-sm-12">
				<table style="width: 100%; ">
					<tr class="text-left">
							
							<td style="25%">
								<p>Demikian Berita Acara Pemeriksaan Barang Ini , di buat dalam rangkap 4  (empat) untuk di pergunakan sebagaimana mestinya</p>
							</td>
	
					</tr>
				</table>
			</div>
		</div>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%; ">
				<tr class="text-left">
						<td style="padding-left: 100px">

						</td>
						<td style="padding-top: 50px"  >
							

							<p class="text-center">Soreang, {{ date('d M Y') }}</p>
							<p class="text-center">Tim Teknis Pemeriksa Pengadaan Barang/Jaksa</p>
							<p class="text-center">{{config('app.nama_kop_rs')}}</p>
							<p class="text-center">Pengadaan Obat</p>
							<p class="text-center">Tahun Anggaran 2023</p>
							<br>
							<br>
							1. Cece Rachmat M. A.md.Kep		:    Ketua    (...............) <br>
							<br>
							<br>
							<br>
							2. Iman Firman					:  Sekretaris  (...............) <br>
							<br>
							<br>
							<br>
							3. Komariah, SSI,Apt            :   Anggota     (...............) <br>
						</td>

				</tr>
			</table>
		</div>
	</div>

	</div>



	

	<div class="row" style="padding-top: 700px">
		<div class="col-sm-12">
			<table style="width: 100%;">
				<tbody>
					<tr>
                        <td class="text-center">
                            <h5><b>BERITA ACARA SERAH TERIMA BARANG</b></h5>
                            <h5><b>{{ $po->no_sp }}</b></h5>
                        </td>
                    </tr>
					
					
				</tbody>
			</table>
		</div>
		</div>

		<br> 
		<div class="row">
			<div class="col-sm-12 "> 
				<p>
                    Pada hari {{ date('d M Y') }}. Bertempat di Rumah Umum Daerah Oto Iskandar Di Nata. yang bertanda tangan di bawah ini.
                </p>
            </div>
            <div class="col-sm-12 "> 
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="padding-left: 30px">
								@php
							$peg = App\LogistikPejabatPengadaan::all()
								@endphp
                                <h5>Nama     : {{ $peg[0]->nama }}</h5>
                                <h5>Jabatan  : Pejabat Pembuat Komitmen RSUD Soreang</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
			<div class="col-sm-12 "> 
				<p>
                    Dalam Hal Ini Bertindak Sebagai <b>Pejabat Pembuat Komitmen</b> Yang Selanjutnya Disebut PIHAK KESATU
                </p>
            </div>
            <div class="col-sm-12 "> 
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="padding-left: 30px">
								@php
							$peg = App\LogistikPejabatPengadaan::all()
								@endphp
                                <h5>Nama     : ASEP HERMANSYAH,S.Sos</h5>
                                <h5>Jabatan  : Pejabat Pembuat Komitmen RSUD Soreang</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
			<div class="col-sm-12 "> 
				<p>
                    Dalam Hal Ini Bertindak Sebagai <b>Pengurus Barang Pembantu</b> Yang Selanjutnya Disebut PIHAK KEDUA
                </p>
            </div>
			<div class="col-sm-12 " style="padding-top: 20px"> 
				<p>
                   PIHAK KE SATU menyatakan telah melaksanakan pemeriksan terhadap obat yang di pesan melalui surat yang di pesan
				   melalui surat pesanan Nomor: 027/ 40 -FAR/PPK-RSUD OTISTA /III/2023 tanggal {{ date('d M Y') }} dalam kondisi
				   baik dan sesuai dengan spesifikasi yang terdapat  dalam Berita Acara Pemeriksaan Barang. Pemeriksaan Barang 
				   Nomor : 16 /BAP- I/III/2023 (jenis barang terlampir). Untuk selanjutnya diserah terimakan kepada : PIHAK KEDUA
                </p>
            </div>
            <div class="col-sm-12 "> 
				 Demikian Berita Acara Serah Terima Barang ini kami buat dengan sebenarnya untuk dapat di pergunakan sebagai mana semestinya.
            </div>
			<br/>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table style="width: 100%; ">
					<tr class="text-right">
							<td style="25%">
								<h5 class="text-center">PIHAK KESATU</h5><br>
								<p class="text-center">Pejabat Pembuat Komitmen</p><br><br><br><br><br><br>
								
								
								<p class="text-center">{{$peg[0]->nama }}</p>
								
							</td>
							<td>
								<h5 class="text-center">PIHAK KEDUA</h5><br>
								<p class="text-center">Pengurus Barang Pembantu</p><br><br><br><br><br><br>
								
								<p class="text-center">ASEP HERMANSYAH,S,Sos</p>
								
							</td>
	
					</tr>
				</table>
			</div>
		</div>
















  </body>
</html>
