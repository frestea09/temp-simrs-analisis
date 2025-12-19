@extends('master')
@section('header')
  <h1>Radiologi - Transaksi Langsung <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'radiologi/searchpasien', 'class' => 'form-search']) !!}
		<label for="keyword" class="text text-primary">Cari Pasien Lama: {{ session('idlama') }}</label>
		<div class="input-group input-group-md {{ $errors->has('keyword') ? ' has-error' : '' }}">
				<input type="text" name="keyword" id="keyword" class="typeahead form-control" placeholder="Ketik nama, alamat, atau Nomor RM">
				<small class="text-danger">{{ $errors->first('keyword') }}</small>
				<span class="input-group-btn">
				<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
				</span>
		</div>
		{!! Form::close() !!}

		<form action="{{ url('radiologi/simpan-transaksi-langsung') }}" method="POST" id="formRadiologiLangsung" class="form-horizontal">
			{{ csrf_field() }} {{ method_field('POST') }}
			<input type="hidden" name="poli_id" value="{{poliRadiologi()}}">
			<div class="row">
				<div class="col-md-6">
					<label for="keyword" class="text text-primary">Pasien Baru: </label>
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">Nama lengkap</label>
						<div class="col-md-9">
							<input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
							<small class="text-danger">{{ $errors->first('nama') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">NIK</label>
						<div class="col-md-9">
							<input type="text" name="nik" required class="form-control" value="{{ old('nik') }}">
						</div>
					</div>
					<div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
						{!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
								{!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], null, ['class' => 'chosen-select']) !!}
								<small class="text-danger">{{ $errors->first('kelamin') }}</small>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-md-3 control-label">No. HP</label>
						<div class="col-md-9">
							<input type="text" name="nohp" class="form-control" value="" required>
						</div>
					</div>
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						<label for="nama" class="col-md-3 control-label">NO.BPJS</label>
						<div class="col-md-9">
							<input type="text" name="no_jkn" placeholder="ISI JIKA ADA" class="form-control" value="{{ old('no_jkn') }}">
						</div>
					</div>
					
				</div>
				<div class="col-md-6">
					<br/>
					<div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
						{!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
							{!! Form::text('tgllahir', null, ['class' => 'form-control datepicker', 'id'=>'tgllahir','required'=>true,'autocomplete'=>'off']) !!}
							<small class="text-danger">{{ $errors->first('tgllahir') }}</small>
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
		</form>
		<hr>
		{!! Form::open(['method' => 'POST', 'url' => 'radiologi/transaksi-langsung', 'class'=>'form-hosizontal']) !!}
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
							<th>Billing</th>
							<th>Cetak</th>
							<th>Cetak Billing</th>
							<th>Ekspertise</th>
							<th>Cetak Ekspertise</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ $d->no_rm }}</td>
								<td>{{ $d->alamat }}</td>
								<td>{{ $d->pemeriksaan }}</td>
								<td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
								<td>
									<a href="{{ url('/radiologi/entry-transaksi-langsung/'.$d->registrasi_id) }}" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-database"></i></a>
								</td>
								<td>
									<a href="{{ url('radiologi/cetakRadLangsung/'.$d->registrasi_id) }}" target="_blank" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-print"></i></a>
								</td>
								<td>
									<a href="{{ url('radiologi/cetakRincianRad/ird/'.$d->registrasi_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
								</td>
								<td class="text-center">
									<a class="btn btn-success btn-xs" target="_blank" href="{{url('/radiologi/create-ekspertise/'.$d->registrasi_id)}}">Proses</a>
									{{-- <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="tekspertise({{ $d->registrasi_id }})"><i class="fa fa-edit"></i></button> --}}
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-danger">Cetak</button>
										<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
										  @foreach (\App\RadiologiEkspertise::where('registrasi_id', $d->registrasi_id)->get() as $p)
											<li>
											  <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
											</li>
										  @endforeach
										</ul>
									  </div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
    </div>
	<div class="modal fade" id="ekspertiseModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form method="POST" class="form-horizontal" id="formEkspertise">
				{{ csrf_field() }}
				<input type="hidden" name="registrasi_id" value="">
				<input type="hidden" name="ekspertise_id" value="">
				<input type="hidden" name="poli_id" value="{{poliRadiologi()}}">
				
				<div class="table-responsive">
				<table class="table table-condensed table-bordered">
					<tbody>
					<tr>
						<th>Nama Pasien </th> <td class="nama"></td>
						<th>Alamat </th><td class="alamat" colspan="3"></td>
					</tr>
					{{-- <tr>
						<th>Umur </th><td class="umur"></td>
						<th>No. RM </th><td class="no_rm" colspan="3"></td>
					</tr> --}}
					<tr>
						<th>Pemeriksaan</th><td><ol class="pemeriksaan"></ol>  </td>
						<th>Tanggal Pemeriksaan </th><td class="tgl_priksa"></td>
					</tr>
					<tr>
						<th>Dokter</th>
						<td>
							<select name="dokter_id" class="form-control select2" style="width: 100%">
							@foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
								<option value="{{ $d->id }}">{{ $d->nama }}</option>
							@endforeach
							</select>
						</td>
						<th>Dokter Pengirim</th>
						<td>
							<select name="dokter_pengirim" class="form-control select2" style="width: 100%">
							@foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
								<option value="{{ $d->id }}">{{ $d->nama }}</option>
							@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<th>Klinis</th>
						<td>
						  {{-- <input type="text" name="no_dokument" class="form-control"><p style="color: red">wajib isi</p> --}}
						  <input type="text" name="klinis" class="form-control">
						</td>
						<th>Tanggal Ekspertise </th>
						<td colspan="3">
						  {!! Form::text('tanggal_eksp', null, ['class' => 'form-control datepicker ', 'required' => 'required']) !!}
						</td>
					  </tr>
					  {{-- <tr>
						<th>Klinis </th>
						<td>
						  <input type="text" name="klinis" class="form-control">
						</td>
					  </tr> --}}
					<tr>
						<th>Ekspertise</th>
						<td colspan="3">
						<textarea name="ekspertise" class="form-control"></textarea>
						</td>
					</tr>
					</tbody>
				</table>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
			</div>
			</div>
		</div>
		</div>
    <div class="box-footer">
    </div>
  </div>
@endsection
@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

  <script type="text/javascript">
	 $('.select2').select2();
    CKEDITOR.replace('ekspertise', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function tekspertise(registrasi_id) {
      $('#ekspertiseModal').modal('show')
      $('.modal-title').text('Input Ekpertise')
      $("#formEkspertise")[0].reset()
      CKEDITOR.instances['ekspertise'].setData('')
      $.ajax({
        url: '/radiologi/ekspertise-langsung/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.nama').text(data.pasien.nama)
        $('.alamat').text(data.pasien.alamat)
        $('.tgl_priksa').text(data.tindakan.created_at)
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="klinis"]').val(data.ep.klinis)
        $('input[name="tanggal_eksp"]').val(data.tanggal)
        $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
        $('select[name="dokter_pengirim"]').val(data.ep.dokter_pengirim).trigger('change')
        $('.pemeriksaan').empty()
        $.each(data.tindakan, function(index, val) {
          $('.pemeriksaan').append('<li>'+val.namatarif+'</li>')
        });
        if (data.ep != '') {
          $('input[name="ekspertise_id"]').val(data.ep.id)
          $('input[name="no_dokument"]').val(data.ep.no_dokument)
          CKEDITOR.instances['ekspertise'].setData(data.ep.ekspertise)
        }
      })
      .fail(function() {

      });
    }

    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var ekspertise = CKEDITOR.instances['ekspertise'].getData();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)

      $.ajax({
        url: '/radiologi/ekspertise',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert('Ekspertise berhasil disimpan.')
        }

      });
    }
  </script>
@endsection
