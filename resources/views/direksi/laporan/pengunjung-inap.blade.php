@extends('master')

@section('header')
  <h1>Laporan Pengunjung Rawat Inap</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'direksi/laporan/pengunjung/inap', 'class'=>'form-horizontal']) !!}
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
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Rujukan</label>
						<div class="col-md-8">
							<select name="rujukan" class="form-control select2">
								<option value="0" {{ ($rjkn == 0) ? 'selected' : '' }}>Semua</option>
								@foreach ($rujukan as $c)
									<option value="{{ $c->id }}"{{ ($rjkn == $c->id) ? 'selected' : '' }}>{{ $c->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
						{{--  <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">  --}}
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' id="table">
				<thead>
					  <tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2">No. RM</th>
						<th class="v-middle text-center" rowspan="2">Nama</th>
						<th class="v-middle text-center" rowspan="2">Alamat</th>
						<th class="v-middle text-center" rowspan="2">Umur</th>
						<th class="v-middle text-center" rowspan="2">Jenis Kelamin</th>
						<th class="v-middle text-center" rowspan="2">Cara Bayar</th>
						<th class="v-middle text-center" rowspan="2">Rujukan</th>
						<th class="v-middle text-center" rowspan="2">Pelayanan</th>
						<th class="v-middle text-center" rowspan="2">Dokter</th>
						<th class="v-middle text-center" rowspan="2">Tanggal</th>
						<th class="v-middle text-center" rowspan="2">Diagnosa</th>
						<th class="v-middle text-center" rowspan="2">Prosedure</th>
						<th class="v-middle text-center" rowspan="2">Tanggal Registrasi</th>
						<th class="v-middle text-center" rowspan="2">Tanggal Lahir</th>
					</tr>
				</thead>
				<tbody>
						@foreach ($irna as $k => $d)
						<tr>
							<td class="text-center">{{ $k+1 }}</td>
							<td class="text-center">{{ $d->no_rm }}</td>
							<td>{{ $d->nama }}</td>
							<td>{{ $d->alamat }}</td>
							<td>{{ hitung_umur($d->tgllahir) }}</td>
							<td>{{ $d->kelamin }}</td>
							<td>{{ baca_carabayar($d->bayar) }}</td>
							<td>{{ $d->pengirim_rujukan == null ? '-' : baca_rujukan($d->pengirim_rujukan) }}</td>
							{{-- @if (substr($d->politipe,0,1) == 'I') --}}
							<td>Rawat Inap</td>
							{{-- @elseif(substr($d->politipe,0,1) == 'G')
							<td>Rawat Darurat</td>
							@elseif(substr($d->politipe,0,1) == 'J')
							<td>Rawat Jalan</td>
								
							@endif --}}
							<td>{{ baca_dokter($d->dokter_id) }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
							{{-- <td>{{ (isset($d->first_icd10->icd10)) ? baca_icd10($d->first_icd10->icd10) : null }}</td>
							<td>{{ (isset($d->latest_icd10->icd10)) ? baca_icd10($d->latest_icd10->icd10) : null }}</td> --}}
							<td>
								<ul>
									@foreach($d->icd10 as $v)
										<li>{{ baca_icd10($v->icd10 )}}</li>
									@endforeach
								</ul>
							</td>
							<td>
								<ul>
									@foreach($d->icd9 as $v)
										<li>{{ getICD9($v->icd9 )}}</li>
									@endforeach
								</ul>
							</td>
							<td>{{ date('d-m-Y', strtotime($d->reg_created_at)) }}</td>
							<td>{{ date('d-m-Y', strtotime($d->tgllahir)) }}</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
		$('#table').DataTable();
      	$('.datepicker').datepicker();
      	$('.select2').select2();
    });
  </script>
@endsection
