@extends('master')
@section('header')
  <h1>Detail Kinerja Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" id="rincian">
				<thead>
					<tr>
						<th>No</th>
						<th>Tindakan</th>
						<th>Pelayanan</th>
						<th>Tanggal Pemeriksaan</th>
						<th>User</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($detail as $d)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $d->namatarif }}</td>
							<td>{{ ($d->jenis == 'TG') ? 'Rawat Darurat' : '' }}</td>
							<td>{{ $d->created_at->format('d-m-Y') }}</td>
							<td>{{ $d->user->name }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>


    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')
	<script>
  $(function () {

    $('#rincian').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });

</script>
@stop
