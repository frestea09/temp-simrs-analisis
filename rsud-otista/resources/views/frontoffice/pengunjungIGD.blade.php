@extends('master')

@section('header')
<h1>Laporan Pengunjung Rawat Darurat</h1>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/pengunjung-igd', 'class'=>'form-horizontal'])
		!!}
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-7">
				<div class="form-group">
					<label for="tga" class="col-md-3 control-label">Periode</label>
					<div class="col-md-4">
						{!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
						<small class="text-danger">{{ $errors->first('tga') }}</small>
					</div>
					<div class="col-md-4">
						{!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
						<small class="text-danger">{{ $errors->first('tgb') }}</small>
					</div>
				</div>
				<div class="form-group">
					<label for="nama" class="col-md-3 control-label">Cara Bayar</label>
					<div class="col-md-8">
						<select name="cara_bayar" class="form-control select2">
							<option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
							@foreach ($carabayar as $c)
							<option value="{{ $c->id }}" {{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}
								@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="nama" class="col-md-3 control-label">Dokter</label>
					<div class="col-md-8">
						<select name="dokter_id" class="form-control select2" style="width: 100%">
							<option value="0" {{ (@$dokter_id == 0) ? 'selected' : '' }}>Semua</option>
							@foreach ($dokter as $d)
								<option value="{{ $d->id }}"{{ (@$dokter_id == $d->id) ? 'selected' : '' }}>{{ $d->nama }}
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group text-center">
					{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
					{{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" formtarget="_blank"
						value="CETAK"> --}}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' style="font-size:12px;">
				<thead>
					<tr>
						<td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
					  </tr>
					{{-- <tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2">No. RM</th>
						<th class="v-middle text-center" rowspan="2">Nama</th>
						<th class="v-middle text-center" rowspan="2">Alamat</th>
						<th class="v-middle text-center" rowspan="2">Umur</th>
						<th class="v-middle text-center" rowspan="2">Jenis Kelamin</th>
						<th class="v-middle text-center" rowspan="2">No. HP</th>
						<th class="v-middle text-center" rowspan="2">Penanggung Jawab</th>
						<th class="v-middle text-center" rowspan="2">Cara Bayar</th>
						<th class="v-middle text-center" rowspan="2">Pelayanan</th>
						<th class="v-middle text-center" rowspan="2">Dokter</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">User</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">Keterangan</th>
					</tr> --}}
				</thead>
				<tbody>
					@if (count($darurat) > 0)
					
						@foreach ($darurat as $d)
						<tr>
							<td class="text-center">{{ $no++ }}</td>
							<td class="text-center">{{ $d->no_rm }}</td>
							<td>{{ $d->nama }}</td>
							<td>{{ $d->alamat }}</td>
							<td>{{ hitung_umur($d->tgllahir) }}</td>
							<td>{{ $d->kelamin }}</td>
							<td>{{ $d->nohp }}</td>
							<td>{{ @$d->nama_keluarga}}</td>
							<td>{{ baca_carabayar($d->bayar) }}</td>
							@if (substr($d->politipe,0,1) == 'I')
							<td>Rawat Inap</td>
							@elseif(substr($d->politipe,0,1) == 'G')
							<td>Rawat Darurat</td>
							@elseif(substr($d->politipe,0,1) == 'J')
							<td>Rawat Jalan</td>

							@endif
							<td>{{ baca_dokter($d->dokter_id) }}</td>
							<td class="text-center">{{ date('d-m-Y H:i:s', strtotime($d->created_at)) }}</td>
							<td class="text-center">{{ baca_user($d->user_id) }}</td>
							<td class="text-center">{{ $d->keterangan }}</td>
						</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	@endsection

	@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
      $('.datepicker').datepicker();
      $('.select2').select2();
    });
	</script>
	@endsection