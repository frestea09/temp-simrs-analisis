@extends('master')

@section('header')
  <h1>Laporan Harian</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/laporan-harian', 'class'=>'form-horizontal']) !!}
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
					<div class="form-group text-center">
						<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
						<input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover'>
				<thead>
					<tr>
						<th class="v-middle text-center" rowspan="2">No</th>
						<th class="v-middle text-center" rowspan="2">Poli Klinik</th>
						<th class="v-middle text-center" colspan="2">Cara Bayar</th>
						<th class="v-middle text-center" colspan="2">Cara Daftar</th>
					</tr>
                    <tr>
						<th class="v-middle text-center" >Umum</th>
						<th class="v-middle text-center" >JKN</th>

						<th class="v-middle text-center" >Online</th>
						<th class="v-middle text-center" >Offline</th>
					</tr>
				</thead>
                <tbody>
                @foreach ($polis as $poli)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$poli->nama}}</td>

                        <td class="text-center">{{$poli->umum}}</td>
                        <td class="text-center">{{$poli->jkn}}</td>
                        
                        <td class="text-center">{{$poli->online}}</td>
                        <td class="text-center">{{$poli->offline}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
						<th class="text-center" style="font-weight: bold" colspan="2" rowspan="2">Total</th>
						<th class="text-center" style="font-weight: bold">{{$total_umum}}</th>
						<th class="text-center" style="font-weight: bold">{{$total_jkn}}</th>
						<th class="text-center" style="font-weight: bold">{{$total_online}}</th>
						<th class="text-center" style="font-weight: bold">{{$total_offline}}</th>
					</tr>
                    <tr>
						<th class="text-center" style="font-weight: bold" colspan="4">{{$total_keseluruhan}}</th>
						
					</tr>
                </tfoot>
			</table>
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
