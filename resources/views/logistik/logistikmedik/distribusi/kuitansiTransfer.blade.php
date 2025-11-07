<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Transfer Stok</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 15pt;
		}
    </style>


  </head>

  <body onload="print()">
  	<div class="container">
  		<table style="width: 100%">
  			<tr>
  				<td style="width: 50%">
  					{{ config('app.nama') }} <br> {{ config('app.kota') }} <br>
  					{{ config('app.alamat') }}
  				</td>
  				<td style="vertical-align: middle; width: 50%">
  					<b style="font-size: 11pt">SURAT PERMINTAAN BARANG</b>
  				</td>
  			</tr>
  		</table>

  		<br>
		<b>Gudang Asal: {{ @$namaGudang->gudang->nama }}</b> <br>
		<b>Gudang Tujuan: {{ @$namaGudang->gudangTujuan->nama }}</b> <br>
		<b>No Permintaan : {{ @$data[0]->nomor }}</b><br>
		<b>Tanggal : {{ @tgl_indo(@$data[0]->tanggal_permintaan) }}</b>
  		<table style="width: 100%" class="table table-bordered">
  			<thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th class="text-center">Stok Gudang Pengirim</th>
				
                <th class="text-center">Permintaan</th>
                <th clastyle="width: 100px;">Dikirim</th>
				<th class="text-center">Keterangan</th>
              </tr>
            </thead>
            <tbody>
				@foreach ($data as $d)
				  <tr>
					<td>{{ $no++ }}</td>
					<td>{{ @$d->barang->nama }} </td>
					<td class="text-center">{{ $d->stokGudangAsal}}</td>
				
					<td class="text-center">{{ $d->jumlah_permintaan }}</td>
					<td class="text-center">{{ $d->terkirim }}</td>
					<td class="text-center"></td>
				  </tr>
				@endforeach
            </tbody>
  		</table>
  		<br>
		 
		{{-- <table style="width: 100%">

			<tr>
				<td style="width: 50%" class="text-left"></td>
				<td style="width: 50%" >
					{{ configrs()->kota }}, {{ tgl_indo($d->tanggal_permintaan) }} <br><br><br><br>
					{{ baca_user($data[0]->user_id) }}
				</td>
			</tr>
		</table> --}}
  		<table style="width: 100%">
		
  			<tr>
				<td style="width: 50%" >
					Depo <br><br><br><br>
					{{ @baca_user(@$data[0]->user_id) }}
				</td>
  				<td style="width: 100%"></td>
  				<td style="width: 50%" class="text-center">
  					Gudang <br><br><br><br>
  					{{ Auth::user()->name }}
  				</td>
  			</tr>
  		</table>



	</div>
  </body>
</html>
