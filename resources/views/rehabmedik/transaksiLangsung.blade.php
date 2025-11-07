@extends('master')
@section('header')
  <h1>Rehabmedik - Transaksi Langsung <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{{--  <form action="{{ url('radiologi/simpan-transaksi-langsung') }}" method="POST" id="formRadiologiLangsung" class="form-horizontal">
			{{ csrf_field() }} {{ method_field('POST') }}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">Nama lengkap</label>
						<div class="col-md-9">
							<input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
							<small class="text-danger">{{ $errors->first('nama') }}</small>
						</div>
					</div>
					<div class="form-group {{ $errors->has('alamat') ? ' has-error' : '' }}">
						<label for="alamat" class="col-md-3 control-label">Alamat</label>
						<div class="col-md-9">
							<textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
							<small class="text-danger">{{ $errors->first('alamat') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Pemeriksaan</label>
						<div class="col-md-9">
							<input type="text" name="pemeriksaan" class="form-control" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="alamat" class="col-md-3 control-label">&nbsp;</label>
						<div class="col-md-9">
							<button type="submit" class="btn btn-primary btn-flat">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</form>  --}}
		<hr>
		@if (!empty($data))
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Lengkap</th>
							<th>Alamat</th>
							<th>Pemeriksaan</th>
							<th>Input</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ $d->alamat }}</td>
								<td>{{ $d->pemeriksaan }}</td>
								<td>
									<a href="{{ url('/rehabmedik/entry-tindakan-irj/'.$d->registrasi_id.'/'.$d->pasien_id) }}" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-database"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
       
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
