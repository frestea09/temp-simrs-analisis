<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Pemakaian</title>

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
					{{ configrs()->nama }} <br> {{ 'Kota '.ucWords(configrs()->kota) }} <br>
					  
					{{ ucWords(configrs()->alamat) }} Tlp. {{ configrs()->tlp }}
  				</td>
  				<td style="vertical-align: middle; width: 50%">
  					<b style="font-size: 11pt">SURAT Pemakaian OBAT</b>
  				</td>
  			</tr>
  		</table>
  		<table style="width: 100%" class="table table-bordered">
  			<thead>
  				<tr>
  					<th class="text-center">No</th>
  					<th>Nama Barang</th>
                    <th>Gudang</th>
					<th>Jumlah Pemakaian</th>
					<th>Sisa Stok</th>
                    <th>Keterangan</th>
  					<th>Tanggal</th>
  				</tr>
  			</thead>
  			<tbody>
  				@foreach ($data as $d)
  					<tr>
  						<td class="text-center">{{ $no++ }}</td>
  						<td>{{ \App\Masterobat::find($d->masterobat_id)->nama }}</td>
                        <td class="text-center">{{ baca_gudang_logistik($d->gudang_id) }}</td>  
						<td class="text-center">{{ $d->jumlah }}</td>
						<td class="text-center">{{ \App\Logistik\LogistikStock::where('gudang_id', Auth::user()->gudang_id)->where('masterobat_id', $d->masterobat_id)->latest()->first()->total }}
						</td>
                        <td class="text-center">{{ $d->keterangan }}</td>
  						<td>{{ $d->created_at }}</td>
  					</tr>
  				@endforeach
  			</tbody>
  		</table>
  		<br>
  		<table style="width: 100%">
  			<tr>
  				<td style="width: 50%"></td>
  				<td style="width: 50%" class="text-center">
  					{{ configrs()->kota }}, {{ $d->created_at }} <br><br><br><br>
  					{{ Auth::user()->name }}
  				</td>
  			</tr>
  		</table>
	</div>
  </body>
</html>
