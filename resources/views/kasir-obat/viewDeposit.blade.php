<hr>
<h4>Deposit</h4>
<div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Keluarga</th>
				<th class="text-center">Tanggal</th>
				<th class="text-center">Deposit</th>
				<th class="text-center">Return</th>
				<th class="text-center">Total</th>
				<th class="text-center">Kasir</th>
				<th class="text-center">Return</th>
				<th class="text-center" width="150px">Cetak</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($dp as $d)
				<tr>
					<td class="text-center">{{ $no++ }}</td>
					<td>{{ $d->keluarga }}</td>
					<td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
					<td class="text-right">{{ number_format($d->nominal) }}</td>
					<td class="text-right">{{ number_format($d->return) }}</td>
					<td class="text-right">{{ number_format($d->nominal - $d->return) }}</td>
					<td>{{ $d->kasir }}</td>
					<td class="text-center">
						@if($d->return == 0)
							<buttAon type="button" onclick="returnDp({{ $d->registrasi_id }},{{ $d->id }})" class="btn btn-primary btn-flat"> <i class="fa fa-check"></i> </buttAon>
						@endif
					</td>
					<th class="text-center">
						<a href="{{ url('kasir/cetak-deposit/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i> DP</a>
					@if($d->return > 0)
						<a href="{{ url('kasir/cetak-return/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i> RET</a>
					@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
