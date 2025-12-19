@extends('master')

@section('header')
  <h1>Laporan Jumlah Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'laboratorium/laporan-jumlah-pemeriksaan', 'class'=>'form-horizontal']) !!}
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
				</div>
				<div class="col-md-5">
					{{-- <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN"> --}}
					<input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		
	@isset($kunjungan)
      <div class="table-responsive mt-3">
        <table class="table table-bordered"  width="100px">
            <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tindakan</th>
                <th class="text-center">Jumlah</th>
            </tr>  
            </thead>
          <tbody>
				@foreach ($kunjungan as $k)
				@php
					$jumlah = Modules\Tarif\Entities\Tarif::where('nama', '=', $k->namatarif)->first();
				@endphp
					@if ($jumlah)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $k->namatarif }}</td>
							<td>{{ $jumlah->total == 0 ? 0 : floor($k->total / $jumlah->total)}}</td>
						</tr>
					@endif
				@endforeach
          </tbody> 
        </table>
      </div>
	  @endisset
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
