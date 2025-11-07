@extends('master')

@section('header')
<h1>Laporan Jaga Rawat Darurat</h1>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		{!! Form::open(['method' => 'GET', 'url' => 'frontoffice/laporan/jaga-igd', 'class'=>'form-horizontal'])
		!!}
		{{-- {{ csrf_field() }} --}}
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
			</div>
			<div class="col-md-5">
				<div class="form-group text-center">
					{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover' style="font-size:12px;" >
				<thead>
					<tr>
						<th class="v-middle text-center" >No</th>
						<th class="v-middle text-center" >Reg Id</th>
						<th class="v-middle text-center" >Nama</th>
						<th class="v-middle text-center" >Jenis Pasien</th>
						<th class="v-middle text-center" >Waktu Observasi</th>
						<th class="v-middle text-center" >Cara Pulang</th>
						<th class="v-middle text-center" >Meninggal</th>
						<th class="v-middle text-center" >Diinapkan</th>
						<th class="v-middle text-center"  style="min-width:90px">Rujuk</th>
						<th class="v-middle text-center"  style="min-width:90px">Obs. Anak</th>
						<th class="v-middle text-center"  style="min-width:90px">Obs. Dewasa</th>
						<th class="v-middle text-center"  style="min-width:90px">Resus</th>
						<th class="v-middle text-center"  style="min-width:90px">Triage</th>
						<th class="v-middle text-center"  style="min-width:90px">Bedah</th>
						<th class="v-middle text-center"  style="min-width:90px">Iso</th>
						<th class="v-middle text-center"  style="min-width:90px">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($daruratItems as $d)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td class="text-center">{{ $d->regID }}</td>
						<td class="text-center">{{ $d->nama }}</td>
						<td class="text-center">{{ $d->status == 'baru' ? 'Baru' : 'Lama' }}</td>
						<td class="text-center">{{ $d->waktu_observasi }}</td>
						<td class="text-center">{{ $d->cara_pulang ?? '-' }}</td>
						<td class="text-center">{{ $d->meninggal ?? '-' }}</td>
						<td class="text-center">{{ $d->inap ?? 'Tidak' }}</td>
						<td class="text-center">{{ $d->rujuk ?? '-' }}</td>
						<td class="text-center">{{ $d->obs_anak ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->obs_dewasa ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->resus ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->triage ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->bedah ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->iso ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->keterangan ?? '-' }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
            <div style="display: flex; justify-content: center">
                {{$pagination->appends(['tga' => $tga, 'tgb' => $tgb, 'crb' => $crb])->links()}}
            </div>
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