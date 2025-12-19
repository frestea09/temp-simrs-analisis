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
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/pengunjung-irna', 'class'=>'form-horizontal']) !!}
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
						<label for="nama" class="col-md-3 control-label" >Cara Bayar</label>
						<div class="col-md-8">
							<select name="cara_bayar" class="form-control select2" style="width: 100%">
								<option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
								@foreach ($carabayar as $c)
									<option value="{{ $c->id }}"{{ ($crb == $c->id) ? 'selected' : '' }}>{{ $c->carabayar }}
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label" >Status Pulang</label>
						<div class="col-md-8">
							<select name="status_pulang" class="form-control select2" style="width: 100%">
								<option value="0" {{ ($sp == 0) ? 'selected' : '' }}>Semua</option>
								@foreach ($status_pulang as $s)
									<option value="{{ $s->id }}"{{ ($sp == $s->id) ? 'selected' : '' }}>{{ $s->namakondisi }}
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Ruangan</label>
						<div class="col-md-8">
							<select name="kelompok" class="form-control select2" style="width: 100%">
								<option value="0" {{ ($crb == 0) ? 'selected' : '' }}>Semua</option>
								@foreach ($kelompok as $d)
									<option value="{{ $d->id }}"{{ ($klmpk == $d->id) ? 'selected' : '' }}>{{ $d->kelompok }}
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="tanggal" class="col-md-3 control-label">Pekerjaan</label>
						<div class="col-md-8">
						  <select class="form-control select2" name="pekerjaan">
							<option value="">[Semua]</option>
							@foreach ($pekerjaan as $key => $p)
							@if (!empty($_POST['pekerjaan']) && $_POST['pekerjaan'] == $p->id)
							<option value="{{ $p->id }}" selected>{{ $p->nama }}</option>
							@else
							<option value="{{ $p->id }}">{{ $p->nama }}</option>
							@endif
			  
							@endforeach
						  </select>
						</div>
					  </div>
				</div>
				<div class="col-md-5">
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

					<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
						{{--  <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">  --}}
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' id="dataTable" style="font-size:11px;">
				<thead>
					{{-- <tr>
						<td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
					  </tr> --}}
					  <tr>
						<th class="v-middle text-center" >No</th>
						<th class="v-middle text-center" >No. RM</th>
						<th class="v-middle text-center" >No. SEP</th>
						<th class="v-middle text-center" >Nama</th>
						<th class="v-middle text-center" >Alamat</th>
						<th class="v-middle text-center" >Pekerjaan</th>
						<th class="v-middle text-center" >Umur</th>
						<th class="v-middle text-center" >Jenis Kelamin</th>
						<th class="v-middle text-center" >No Hp</th>
						<th class="v-middle text-center" >Cara Bayar</th>
						<th class="v-middle text-center" >Tanggal Masuk</th>
						<th class="v-middle text-center" >Tanggal Keluar</th>
						<th class="v-middle text-center" >Pelayanan</th>
						<th class="v-middle text-center" >Kelas</th>
						<th class="v-middle text-center" >Kamar</th>						
						<th class="v-middle text-center" >Bed</th>
						<th class="v-middle text-center" >Riwayat Mutasi</th>
						<th class="v-middle text-center" >Dokter</th>
						<th class="v-middle text-center" >Petugas</th>
						<th class="v-middle text-center" >Keterangan</th>
						<th class="v-middle text-center" >Diagnosa</th>
						<th class="v-middle text-center" >Status Pulang</th>
						<th class="v-middle text-center"  style="min-width:90px">Tanggal</th>
					</tr>
				</thead>
				<tbody>
					@if (count($irna) > 0) 
						
						@foreach ($irna as $d)
						@php
							@$riwayat_mutasi = \App\HistoriRawatInap::where('registrasi_id',$d->registrasi_id)->orderBy('id','DESC')->select('bed_id')->get();
						@endphp
						<tr>
							<td class="text-center">{{ @$no++ }}</td>
							<td class="text-center">{{ @$d->no_rm }}</td>
							<td class="text-center">{{ @$d->no_sep }}</td>
							<td>{{ @$d->nama }}</td>
							<td>{{ @$d->alamat }}</td>
							<td>{{ @baca_pekerjaan(@$d->pekerjaan_id) }}</td>
							<td>{{ hitung_umur($d->tgllahir) }}</td>
							<td>{{ @$d->kelamin }}</td>
							<td>{{ @$d->nohp }}</td>
							<td>{{ @$d->carabayar }} - {{ @$d->tipe_jkn }}</td>
							<td>
								{{ @$d->tgl_masuk ? date('d-m-Y, H:i', strtotime(@$d->tgl_masuk)) : '-'}}
							</td>
							<td>
								{{ @$d->tgl_keluar ? date('d-m-Y, H:i', strtotime(@$d->tgl_keluar)) : '-'}}
							</td>
							
							@if (substr($d->politipe,0,1) == 'I')
								<td>Rawat Inap</td>
							@elseif(substr($d->politipe,0,1) == 'G')
								<td>Rawat Darurat</td>
							@elseif(substr($d->politipe,0,1) == 'J')
								<td>Rawat Jalan</td>
							@endif

							<td>{{@$d->nama_kelas}}</td>
							<td>{{@$d->nama_kamar}}</td>
							<td>{{@$d->nama_bed}}</td>
							<td>
								<ul style="padding-left:15px">
									@if (count($riwayat_mutasi) > 0)
									@foreach ($riwayat_mutasi as $item)
										
									@endforeach
									<li>{{baca_bed($item->bed_id)}}</li>
									@endif
								</ul>
							</td>
							<td>{{ @$d->dpjp }}</td>
							<td>{{ @$d->user }}</td>
							<td>{{ @$d->keterangan }}</td>
							<td>{{ @$d->diagnosa }}</td>
							<td class="text-center">{{ @$d->namakondisi }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
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
      	$('.select2').select2();
        $("#dataTable").DataTable().destroy()
        $('#dataTable').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },
            pageLength: 10,
            autoWidth: false,
            processing: false,
            serverSide: false,
            ordering: false,
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
