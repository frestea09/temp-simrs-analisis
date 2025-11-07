<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Telepon</th>
				<th>No. HP</th>
				<th>Status</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $d)
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $d->nama }}</td>
					<td>{{ $d->alamat }}</td>
					<td>{{ $d->telepon }}</td>
					<td>{{ $d->nohp }}</td>
					<td>
						@if ($d->status == 1)
							Aktif
						@else
							Tidak Aktif
						@endif
					</td>
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