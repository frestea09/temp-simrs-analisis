@extends('master')
@section('header')
  <h1>Radiologi - Transaksi Langsung <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		<form action="{{ url('radiologi/simpan-transaksi-langsung') }}" method="POST" id="formRadiologiLangsung" class="form-horizontal">
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
							<input type="text" name="pemeriksa" class="form-control" value="">
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
							<th>Nama Lengkap</th>
							<th>Alamat</th>
							<th>Pemeriksaan</th>
							<th>Waktu</th>
							<th>Input</th>
							<th>Cetak</th>
							<th>Edit</th>
							<th>cetak ekspertise</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ $d->alamat }}</td>
								<td>{{ $d->pemeriksaan }}</td>
								<td>{{ $d->created_at->format('Y-m-d H:i:s') }}</td>
								<td>
									<a href="{{ url('/radiologi/entry-transaksi-langsung/'.$d->registrasi_id) }}" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-database"></i></a>
								</td>
								<td>
									<a href="{{ url('radiologi/cetakRadLangsung/'.$d->registrasi_id) }}" target="_blank" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-print"></i></a>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-danger btn-sm btn-flat" onclick="tekspertise({{ $d->registrasi_id }})"><i class="fa fa-edit"></i></button>
								</td>
								<td class="text-center">
									<a href="{{ url('/radiologi/cetak-langsung-ekpertise/'.$d->registrasi_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
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
						<th>No. Dokumen</th>
						<td>
						<input type="text" name="no_dokument" class="form-control">
						</td>
						<th>Tanggal Ekspertise </th>
						<td colspan="3">
						{!! Form::text('tanggal_eksp', null, ['class' => 'form-control datepicker ', 'required' => 'required']) !!}
						</td>
					</tr>
					<tr>
						<th>Klinis </th>
						<td colspan="3">
						<input type="text" name="klinis" class="form-control">
						</td>
					</tr>
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
