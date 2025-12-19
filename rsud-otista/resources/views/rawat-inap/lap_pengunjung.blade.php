@extends('master')

@section('header')
  <h1>Laporan Pengunjung Rawat Inap</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'rawatinap/lap-pengunjung', 'class'=>'form-horizontal']) !!}
			{!! Form::hidden('pasien_id', null) !!}
			<div class="row">
				<div class="col-md-3">
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
				  </div>
				  <div class="col-md-3">
					<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
					  <span class="input-group-btn">
						<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
					  </span>
					  <input name="tga" class="form-control datepicker" required="required">
					  <small class="text-danger">{{ $errors->first('tga') }}</small>
					</div>
					 </div>
					 <div class="col-md-3">
						<div class="input-group">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button">s/d Tanggal</button>
						  </span>
						  <input name="tgb" class="form-control datepicker" required="required">
						</div>
					  </div>
					   <div class="col-md-3">
					<div class="input-group">
					<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
					<input type="submit" name="submit" class="btn btn-danger btn-flat" value="CETAK" formtarget="_blank">
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
	@if($crb == 5)
			<div class="table-responsive">
				<table class='table table-bordered table-hover'>
					<thead>
						<tr>
							<th class="v-middle text-center">No</th>
							<th class="v-middle text-center" style="min-width:90px">Masuk</th>
							<th class="v-middle text-center" style="min-width:90px">Keluar</th>
							<th class="v-middle text-center">No. RM</th>
							<th class="v-middle text-center">Nama</th>
							<th class="v-middle text-center">Bayar</th>
							<th class="v-middle text-center" style="min-width:90px">Kamar</th>
							<th class="v-middle text-center">DIagnosa Pulang</th>
							<th class="v-middle text-center">Dokter</th>
							<th class="v-middle text-center">Tindakan</th>
							<th class="v-middle text-center">Qty</th>
							<th class="v-middle text-center">Tarif</th>
							<th class="v-middle text-center">Total</th>
						</tr>
					</thead>
					<tbody>
					@foreach($rawatinap as $rn)
						<tr>
							<td class="text-center">{{ $no++ }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($rn->tgl_masuk)) }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($rn->tgl_keluar)) }}</td>
							<td class="text-center">{{ $rn->no_rm }}</td>
							<td>{{ $rn->nama }}</td>
							<td class="text-center">{{ baca_carabayar($rn->carabayar_id) }}</td>
							<td>{{ baca_kamar($rn->kamar_id) }}</td>
							<td>{{ $rn->icd9s }}</td>
							<td>{{ baca_dokter($rn->dokter_id) }}</td>
							<td>{{ $rn->namatarif }}</td>
							<td>{{ $rn->total / $rn->tarif }}</td>
							<td class="text-right">{{ number_format($rn->tarif) }}</td>
							<td class="text-right">{{ number_format($rn->total) }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
	@else
		{{-- yang diubah dibawah --}}
		<div class='table-responsive'>
			<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
			  <thead>
				<tr>
				  <th>No</th>
				  <th>Nama</th>
				  <th>No. RM</th>
				  <th>Umur</th>
				  <th>Klinik Tujuan</th>
				  <th>Cara Bayar</th>
				  <th>Dokter</th>
				  <th>Jenis Pasien</th>
				</tr>
			  </thead>
			  <tbody>
				@foreach ($rawatinap as $key => $d)
				  @php
					$reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
				  @endphp
				  <tr>
					<td>{{ $no++ }}</td>
					<td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nama }}</td>
					<td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->no_rm }}</td>
					<td>{{ hitung_umur(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->tgllahir) }}</td>
					<td>
					  @if ($reg)
						{{ baca_poli($reg->poli_id) }}
					  @else 
						{{ NULL }}
					  @endif
					</td>
					<td>{{ baca_carabayar($d->bayar) }}</td>
					<td>
					  @if ($reg)
						{{ baca_dokter($reg->dokter_id) }}
					  @else 
						{{ NULL }}
					  @endif
					</td>
					<td>
					  @if (!empty($reg->status) )
						{{ $reg->status }}
					  @else 
						{{ NULL }}
					  @endif
					</td>
				  </tr>
				@endforeach
	
			  </tbody>
			</table>
		  </div>
		  {{-- sampe sini  --}}
	
		
	@endif
	</div>
    
    {{-- MODAL SEARCH pasien --}}
	<div class="modal fade" id="searchPasien" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id=""></h4>
				</div>
				<div class="modal-body">
					<div class='table-responsive'>
						<table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
								<th>No. RM</th>
								<th>Nama Lengkap</th>
								<th>Alamat</th>
								<th>Input</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.datepicker').datepicker();
      $('.select2').select2();
      $('select[name="kelas"]').on('change', function () {
        var kelas_id = $(this).val();
        if(kelas_id) {
            $.ajax({
                url: '/lap-irna-getkamar/'+kelas_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="kamar"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="kamar"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
          $.ajax({
              url: '/lap-irna-getkamar/',
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $('select[name="kamar"]').empty();
                  $('select[name="kamar"]').append('<option value="">[Semua]</option>');
                  $.each(data, function(key, value) {
                      $('select[name="kamar"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
              }
          });
        }
      });

      //SEARCH PASIEN
      $('#openModal').on('click', function () {
        $("#dataPasien").DataTable().destroy();
        $('#searchPasien').modal('show');
        $('.modal-title').text('Cari Pasien');
        $('#dataPasien').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/frontoffice/lap-rekammedis/datapasien',
            columns: [
                {data: 'no_rm'},
                {data: 'nama'},
                {data: 'alamat'},
                {data: 'input', searchable: false},
            ]
        });
      });

      $(document).on('click', '.inputPasien', function (e) {
        $('input[name="nama"]').val($(this).attr('data-nama'));
        $('input[name="no_rm"]').val($(this).attr('data-no_rm'));
        $('input[name="pasien_id"]').val($(this).attr('data-pasien_id'));
        $('#searchPasien').modal('hide');
      });

      $('input[name="nama"]').on('keyup', function () {
        if ( $('input[name="nama"]').val() == '' ) {
          $('input[name="no_rm"]').val('');
          $('input[name="pasien_id"]').val('');
        }
      });


    });

  </script>
@endsection
