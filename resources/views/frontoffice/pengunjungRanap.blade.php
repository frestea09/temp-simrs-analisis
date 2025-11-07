@extends('master')

@section('header')
  <h1>Laporan Rawat Inap</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/laporan-ranap', 'class'=>'form-horizontal']) !!}
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
						<label for="blp" class="col-md-3 control-label">Bulan Pulang</label>
						<div class="col-md-4">
							{!! Form::text('blp', $blp ?? '', ['class' => 'form-control monthpicker', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('blp') }}</small>
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
					{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
						{{--  <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">  --}}
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' id="table" style="font-size:10px">
				<thead>
					  <tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2"></th>
						<th class="v-middle text-center" rowspan="2">Nama</th>
						<th class="v-middle text-center" rowspan="2">No SEP</th>
						<th class="v-middle text-center" rowspan="2">Tanggal Masuk</th>
						<th class="v-middle text-center" rowspan="2">Tanggal Keluar</th>
						<th class="v-middle text-center" rowspan="2">Hari Rawat</th>
						<th class="v-middle text-center" rowspan="2">No MR</th>
						<th class="v-middle text-center" rowspan="2">Ket Pulang</th>
						<th class="v-middle text-center" rowspan="2">No Kwit</th>
						<th class="v-middle text-center" rowspan="2">SMF</th>
					</tr>
				</thead>
				<tbody>
						@foreach ($irna as $d)
						<?php
						$tgl1 = new DateTime(@$d->tgl_masuk);
						$tgl2 = new DateTime(@$d->tgl_keluar);
						$hari = $tgl2->diff($tgl1)->days + 1;
						?>
						<tr>
							<td>
									{{ @str_replace("Kelas","",baca_kamar($d->kamar_id)) }}
							</td>
							<td class="text-center">{{ baca_carabayar($d->bayar) }} {{$d->bayar == 1 ? $d->tipe_jkn : ''}}</td>
							
							<td>{{ $d->nama }}</td>
							<td>{{ $d->no_sep }}</td>
							<td>{{ date('d/m/Y',strtotime($d->tgl_masuk)) }}</td>
							<td>{{ date('d/m/Y',strtotime($d->tgl_keluar)) }}</td>
							<td class="text-center">{{ $hari }}</td>
							<td class="text-center">{{ $d->no_rm }}</td>
							<td>{{ $d->kondisi_akhir_pasien ? @baca_carapulang($d->kondisi_akhir_pasien) :'' }}</td>
							<td>&nbsp;</td>
							<td>{{@baca_poli($d->poli_id)}}</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('script')
  <script type="text/javascript">
  $(".skin-blue").addClass( "sidebar-collapse" );
    $(document).ready(function() {
		$('#table').DataTable();
      	$('.datepicker').datepicker();
      	$('.select2').select2();
    });
  </script>
  <script>
	$(document).ready(function () {
		$('.monthpicker').datepicker({
			format: "yyyy-mm",
			startView: "months",
			minViewMode: "months",
			autoclose: true
		});
	});
  </script>
@endsection
