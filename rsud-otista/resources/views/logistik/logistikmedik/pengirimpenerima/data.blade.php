<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered" id="data">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Periode Awal</th>
				<th>Periode Akhir</th>
				<th>Transaksi Awal</th>
				<th>Transaksi Akhir</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $d)
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $d->nama }}</td>
					<td>{{ tanggalPeriode($d->periodeAwal) }}</td>
					<td>{{ tanggalPeriode($d->periodeAkhir) }}</td>
					<td>{{ tanggalPeriode($d->transaksiAwal) }}</td>
					<td>{{ tanggalPeriode($d->transaksiAkhir) }}</td>
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

@section('script')
	<script type="text/javascript">
		  $('#data').DataTable({
		      'paging'      : true,
		      'lengthChange': false,
		      'searching'   : false,
		      'ordering'    : true,
		      'info'        : true,
		      'autoWidth'   : false
		    })
	</script>
@endsection