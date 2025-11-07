<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Permintaan</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 9pt;
		}
    </style>


  </head>

  <body>
  	<div class="container">
  		<table style="width: 100%">
  			<tr>
  				<td style="width: 50%">
  					{{ config('app.nama') }} <br> {{ config('app.kota') }} <br>
  					{{ config('app.alamat') }}
  				</td>
  				<td style="vertical-align: middle; width: 50%">
					  <b style="font-size: 11pt">SURAT PERMINTAAN OBAT</b><br>
					  <b style="font-size: 10pt">{{ $nomor }}</b><br>
  				</td>
  			</tr>
  		</table>

  		<br>
		<b>Gudang Asal: {{ \App\Logistik\LogistikGudang::find($gudang->gudang_asal)->nama }}</b> <br>
		<b>Gudang Tujuan: {{ \App\Logistik\LogistikGudang::find($gudang->gudang_tujuan)->nama }}</b>
  		<table style="width: 100%" class="table table-bordered">
  			<thead>
  				<tr>
  					<th class="text-center">No</th>
  					<th>Nama Barang</th>
  					<th class="text-center">Jumlah Permintaan</th>
  					{{-- <th class="text-center">Sisa Stok Depo Asal</th> --}}
  					<th>Tanggal</th>
  				</tr>
  			</thead>
  			<tbody>
  				@foreach ($data as $d)
  					<tr>
  						<td class="text-center">{{ $no++ }}</td>
  						<td>{{ \App\Masterobat::find($d->masterobat_id)->nama }}</td>
  						<td class="text-center">{{ $d->jumlah_permintaan }}</td>
  						{{-- <td class="text-center">{{ $d->sisa_stock }}</td> --}}
  						<td>{{ tgl_indo($d->tanggal_permintaan) }}</td>
  					</tr>
  				@endforeach
  			</tbody>
  		</table>
  		<br>
  		<table style="width: 100%">
  			<tr>
  				<td style="width: 50%"></td>
  				<td style="width: 50%" class="text-center">
  					{{ configrs()->kota }}, {{ tgl_indo($d->tanggal_permintaan) }} <br><br><br><br>
  					{{ Auth::user()->name }}
  				</td>
  			</tr>
  		</table>



	</div>
  </body>
</html>
