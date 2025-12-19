@extends('master')

@section('header')
  <h1>Laporan Pengunjung Rawat Jalan</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/pengunjung-irj', 'class'=>'form-horizontal']) !!}
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
									<option value="{{ $c->id }}"{{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group text-center">
						{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
						<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
						{{--  <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">  --}}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover'>
				<thead>
					<tr>
						<td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
					  </tr>
					  {{-- <tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2">No. SEP</th>
						<th class="v-middle text-center" rowspan="2">No. RM</th>
						<th class="v-middle text-center" rowspan="2">Nama</th>
						<th class="v-middle text-center" rowspan="2">Alamat</th>
						<th class="v-middle text-center" rowspan="2">Umur</th>
						<th class="v-middle text-center" rowspan="2">Jenis Kelamin</th>
						<th class="v-middle text-center" rowspan="2">No Hp</th>
						<th class="v-middle text-center" rowspan="2">Cara Bayar</th>
						<th class="v-middle text-center" rowspan="2">Poli</th>
						<th class="v-middle text-center" rowspan="2">Dokter</th>
						<th class="v-middle text-center" rowspan="2" style="min-width:90px">Tanggal</th>
						<th class="v-middle text-center" rowspan="2">Jenis Pendaftaran</th>
						<th class="v-middle text-center" rowspan="2">User</th>
					</tr> --}}
				</thead>
				<tbody>
					 <tbody>
						@if (count($rajal) > 0)
							
							@foreach ($rajal as $d)
							<tr>
								<td class="text-center">{{ $no++ }}</td>
								<td class="text-center">{{ $d->no_sep }}</td>
								<td class="text-center">{{ $d->no_rm }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ $d->alamat }}</td>
								<td>{{ hitung_umur($d->tgllahir) }}</td>
								<td>{{ $d->kelamin }}</td>
								<td>{{ $d->nohp }}</td>
								<td>{{ baca_carabayar($d->bayar) }}</td>
								<td>{{ baca_poli($d->poli_id) }}</td>
								<td>{{ baca_dokter($d->dokter_id) }}</td>
								<td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
								<td>
									@if ($d->nomor_antrian == null)
										<i>Onsite</i>
									@else
										<i>Online</i>	
									@endif
								</td>
								<td>{{ $d->user }}</td>
							</tr>
							@endforeach
						@endif
					</tbody>
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
