<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Bagian</th>
				<th>Kepala</th>
				<th>Tipe</th>
				<th>Penanggung Jawab</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($gudang as $d)
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $d->kode }}</td>
					<td>{{ $d->nama }}</td>
					<td>{{ $d->bagian }}</td>
					<td>{{ $d->kepala }}</td>
					<td>{{ $d->tipe }}</td>
					<td>{{ $d->penanggungjawab }}</td>
					<td>
						<button type="button" class="btn btn-primary btn-sm btn-flat" onclick="editForm({{ $d->id }})">
							<i class="fa fa-edit"></i>
						</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>