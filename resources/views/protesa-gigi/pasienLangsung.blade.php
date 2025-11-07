@extends('master')
@section('header')
  <h1>Protesa Gigi - Pasien Langsung <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		@if (!empty($data))
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama Lengkap</th>
							<th class="text-center">Alamat</th>
							<th class="text-center">Pemeriksaan</th>
							<th class="text-center">Waktu</th>
							<th class="text-center">Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@if (isset($data))
						@foreach ($data as $d)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $d->nama }}</td>
							<td>{{ $d->alamat }}</td>
							<td>{{ $d->pemeriksaan }}</td>
							<td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
							<td>
								@if($d->status_reg == 'P1')
										<a href="{{ url('/protesa-gigi/insert-tindakan/jenazah/langsung/'.$d->registrasi_id.'/'.$d->pasien_id) }}" class="btn btn-flat btn-sm btn-info"><i class="fa fa-bed"></i></a>
								@else
										<a href="{{ url('/protesa-gigi/insert-tindakan/ambulans/langsung/'.$d->registrasi_id.'/'.$d->pasien_id) }}" class="btn btn-flat btn-sm btn-danger"><i class="fa fa-ambulance"></i></a>
								@endif
								{{--  insert-tindakan/ambulans/ranap/16121/69767  --}}
								<a href="{{ url('protesa-gigi/tindakan-cetak/'.$d->registrasi_id) }}" target="_blank" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-print"></i></a>
							</td>
						</tr>
					@endforeach
						@endif
					</tbody>
				</table>
			</div>
		@endif
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
