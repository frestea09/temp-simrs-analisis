<br>
<div class="table-responsive">
	<table class="table table-hover table-bordered table-condensed">
		<thead>
	        <tr>
	          <th style="width: 28%;">Nama Barang</th>
	          <th class="text-center">Jumlah Diminta</th>
	          <th class="text-center">Satuan</th>
	          <th class="text-center">Hapus</th>
	        </tr>
	      </thead>
		<tbody>
			@foreach ($data as $d)
				<tr>
					<td>{{ $d->barang->nama }}</td>
					<td class="text-center">{{ $d->jumlah }}</td>
					<td class="text-center">{{ $d->satBeli->nama }}</td>
					<td class="text-center">
						<a onclick="hapusPO({{ $d->id }})" class="btn btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
