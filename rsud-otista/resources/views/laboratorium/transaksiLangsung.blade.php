@extends('master')
@section('header')
  <h1>Laboratorium - Transaksi Langsung <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'laboratorium/searchpasien', 'class' => 'form-search']) !!}
		<label for="keyword" class="text text-primary">Cari Pasien: {{ session('idlama') }}</label>
		<div class="input-group input-group-md {{ $errors->has('keyword') ? ' has-error' : '' }}">
				<input type="text" name="keyword" id="keyword" class="typeahead form-control" placeholder="Ketik nama, alamat, atau Nomor RM">
				<small class="text-danger">{{ $errors->first('keyword') }}</small>
				<span class="input-group-btn">
				<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
				</span>
		</div>
		{!! Form::close() !!}

		<form action="{{ url('laboratorium/simpan-transaksi-langsung') }}" method="POST" class="form-horizontal">
			{{ csrf_field() }} {{ method_field('POST') }}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">Nama lengkap</label>
						<div class="col-md-9">
							<input type="text" name="nama" required class="form-control" value="{{ old('nama') }}">
							<small class="text-danger">{{ $errors->first('nama') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">NIK</label>
						<div class="col-md-9">
							<input type="text" name="nik" required class="form-control" value="{{ old('nik') }}">
						</div>
					</div>
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">NO.BPJS</label>
						<div class="col-md-9">
							<input type="text" name="no_jkn" placeholder="ISI JIKA ADA" class="form-control" value="{{ old('no_jkn') }}">
						</div>
					</div>
					<div class="form-group {{ $errors->has('alamat') ? ' has-error' : '' }}">
						<label for="alamat" class="col-md-3 control-label">Alamat</label>
						<div class="col-md-9">
							<textarea name="alamat" required class="form-control">{{ old('alamat') }}</textarea>
							<small class="text-danger">{{ $errors->first('alamat') }}</small>
						</div>
					</div>
					<div class="form-group {{ $errors->has('rt') ? ' has-error' : '' }}">
						<label for="alamat" class="col-md-3 control-label">RT</label>
						<div class="col-md-3">
							<input name="rt" class="form-control">
						</div>
						<label for="alamat" class="col-md-3 control-label">RW</label>
						<div class="col-md-3">
							<input name="rw" class="form-control">
						</div>
					</div>
					<div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
						{!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
								{!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], null, ['class' => 'chosen-select']) !!}
								<small class="text-danger">{{ $errors->first('kelamin') }}</small>
						</div>
					</div>
								
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">No. HP</label>
						<div class="col-md-9">
							<input type="text" name="nohp" class="form-control" value="" required>
						</div>
					</div>
					<div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
						{!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
							{!! Form::text('tgllahir', null, ['class' => 'form-control datepicker', 'id'=>'tgllahir']) !!}
							<small class="text-danger">{{ $errors->first('tgllahir') }}</small>
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">Pemeriksaan</label>
						<div class="col-md-9">
							<input type="text" name="pemeriksaan" class="form-control" value="" required>
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
		</form>
		<hr>
			{!! Form::open(['method' => 'POST', 'url' => 'laboratorium/entry-tindakan-langsung', 'class'=>'form-hosizontal']) !!}
			<div class="row">
				<div class="col-md-6">
				<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
					<span class="input-group-btn">
					<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
					</span>
					{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
				</div>
				</div>
			</div>
			{!! Form::close() !!}
			<hr>
		@if (!empty($data))
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pasien</th>
							<th>RM</th>
							<th>Alamat</th>
							<th>Pemeriksaan</th>
							<th>Waktu</th>
							<th>Entry Tindakan</th>
							<th>Cetak Billing</th>
							<th>Input Hasil LAB</th>
							<th>Cetak Hasil LAB</th>
							{{-- <th>Aksi</th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ @$d->no_rm }}</td>
								<td>{{ $d->alamat }}</td>
								<td>{{ $d->pemeriksaan }}</td>
								<td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
								<td>
									<a href="{{ url('/laboratorium/entry-transaksi-langsung/'.$d->registrasi_id) }}" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></a>
								</td>
								<td>
									<a href="{{ url('laboratorium/tindakan-cetak/'.$d->registrasi_id) }}" target="_blank" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-print"></i></a>
								</td>
								<td>
									<a href="{{ url('pemeriksaanlab/create-pasien-langsung/'.$d->registrasi_id) }}" target="_blank" class="btn btn-flat btn-sm btn-success"><i class="fa fa-file"></i></a>
								</td>
								<td>
									@if (cek_hasil_lab($d->registrasi_id) >= 1)
									  @php
										$hasil = App\Hasillab::where('registrasi_id', $d->registrasi_id)->get();
				  
									  @endphp
									  {{-- @foreach ($hasil as $key => $r)
										<a href="{{ url('pemeriksaanlab/cetak/'.$d->id.'/'.$r->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
									  @endforeach --}}
									  <div class="btn-group">
										  <button type="button" class="btn btn-sm btn-success">Cetak</button>
										  <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
											  <span class="caret"></span>
											  <span class="sr-only">Toggle Dropdown</span>
										  </button>
										  <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
											@foreach ($hasil as $p)
												<li><a href="{{ url('pemeriksaanlab/cetak-pasien-langsung/'.$d->registrasi_id.'/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
											@endforeach
										  </ul>
									  </div>
									@endif
									
								  </td>
								  {{-- <td>
									<button class="btn btn-flat btn-sm btn-danger delete" data-id="{{ $d->id }}"><i class="fa fa-trash-o"></i></button>
								  <td> --}}
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

{{-- @section('script')
<script>
	$(document).on('click', '.delete', function(){
		let id = $(this).attr('data-id');
		alert(id);
	})
</script>
@endsection --}}