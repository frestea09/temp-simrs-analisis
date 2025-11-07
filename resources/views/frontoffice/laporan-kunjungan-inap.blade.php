@extends('master')

@section('header')
  <h1>Laporan Kunjungan Rawat Inap</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter Laporan</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/laporan-kunjungan-irna', 'class'=>'form-horizontal']) !!}
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
		
      <div class="table-responsive mt-3">
        <table class="table table-bordered"  width="100px">
            <thead>
            <tr>
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center" rowspan="2">Ruangan</th> 
                <th class="text-center" colspan="2">Jenis Kunjungan</th>
                {{-- <th>
                    <td colspan="3">Users Info</td>
                
               
                    <tr>
                        <td>1</td>
                        <td>John Carter</td>
                        <td>johncarter@mail.com</td>
                     </tr>
                </th> --}}
                
                <th class="text-center" rowspan="2">Jumlah</th> 
                <th class="text-center" colspan="3">Asal Pasien</th>
                <th class="text-center" rowspan="2">Jumlah</th> 
                <th class="text-center" colspan="8">Cara Bayar</th>
                <th class="text-center" rowspan="2">Jumlah</th> 
                
            </tr>
            
            <tr class="text-center">
                <th>Lama</th>
                <th>Baru</th>
                <th>Igd</th>
                <th>Ponek</th>
                <th>Poliklinik</th>
                <th>UMUM</th>
                <th>PBI</th>
                <th>NON PBI</th>
                <th>SKTM</th>
                <th>MANDIRI</th>
                <th>SWASTA</th>
                <th>PNS</th>
                <th>P3K</th>
            </tr>    
            </thead>
          <tbody>
            @foreach ($kunjungan as $k)
             @if ($k->kamar_id)
              <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_kamar($k->kamar_id) }}</td>
                  <td>
                    {{ $k->lama }}
                  </td>
                    
                  <td>{{ $k->baru }}</td>
                  <td>{{ $k->jumlahStatus }}</td>
                  <td>{{ $k->igd }}</td>
                  <td>{{ $k->ponek }}</td>
                  <td>{{ $k->rajal }}</td>
                  <td>{{ $k->igd + $k->ponek + $k->rajal }}</td>
                  <td>{{ $k->umum }}</td>
                  <td>{{ $k->pbi }}</td>
                  <td>{{ $k->nonpbi }}</td>
                  <td>{{ $k->sktm }}</td>
                  <td>{{ $k->mandiri }}</td>
                  <td>{{ $k->swasta }}</td>
                  <td>{{ $k->pns }}</td>
                  <td>{{ $k->p3k }}</td>
                  <td>{{ $k->jkn + $k->umum }}</td>
              </tr>
                 
             @endif
            @endforeach
          </tbody> 
        </table>
      </div>
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
