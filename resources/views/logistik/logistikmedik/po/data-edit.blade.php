<br>
<div class="table-responsive">
	<table class="table table-hover table-bordered table-condensed">
		<thead>
	        <tr>
				<th style="text-center">Nama Barang</th>
				<th class="text-center">Jumlah</th>
				<th class="text-center">Satuan</th>
				<th class="text-center">Harga</th>
				<th>Hapus</th>
	        </tr>
	      </thead>
		<tbody>
			@php
			$sum = 0;
								
			@endphp
			@foreach ($data as $d)
				<tr>
					<td>{{ $d->barang->nama }}</td>

					{{-- @if ($d->verifikasi == 'B') --}}
						<td class="text-center" style="width:10%"><input type="number" name="jumlah{{ $d->id }}" value="{{ $d->jumlah }}" onchange=editJumlah({{ $d->id }}) class="form-control"></td>
					{{-- @else
						<td class="text-center" style="width:10%"><input type="number" name="jumlah{{ $d->id }}" value="{{ $d->jumlah }}" class="form-control" ></td>
					@endif --}}

					<td class="text-center">{{ $d->satBeli->nama }}</td>
					@php
					$sum += $d->totalHarga;
										
					@endphp
					<td class="text-center">Rp. {{ number_format($d->totalHarga) }}</td>
					<td class="">
					
						<a onclick="hapusPO({{ $d->id }})" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></a>
						
					</td>
				</tr>
				
			@endforeach
			<tr>
				<td colspan="1" class="text-right">Total</td>
				<td colspan="3" class="text-right">	Rp. {{ number_format($sum) }}</td>
				<input type="hidden" name="sum" value="{{ $sum }}">
			</tr>
			<tr>
				<td colspan="1" class="text-right">
					PPN 
				</td>
				<td colspan="1" class="text-right">
					<input type="number" class="form-control" value="{{ @$data[0]->jml_ppn }}" onchange="editPPN()" name="ppnPersen">
				</td>
				<td colspan="2" class="text-right">

					@php
						
						$ppnAwal = $sum * @$data[0]->jml_ppn / 100;
						$ppnAkhir = $ppnAwal + $sum;
					@endphp
					<input type="number" class="form-control text-right" value="{{ $ppnAwal }}" name="totalPPN" readonly>
				</td>

			</tr>
			<tr>
				<td colspan="1" class="text-right">
					Total Keseluruhan
				</td>
				<td colspan="3" class="text-right">
					Rp. {{ number_format($ppnAkhir) }}
				</td>
			 </tr>
		</tbody>
	</table>
</div>
