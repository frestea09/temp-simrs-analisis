@extends('master')

@section('header')
  <h1>Cetak Dokumen</h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Filter</h3>
		</div>
		<div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cetak-dokumen', 'class'=>'form-horizontal']) !!}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-7">
					<div class="form-group">
						<label for="no_rm" class="col-md-3 control-label">NO. RM</label>
						<div class="col-md-4">
							{!! Form::text('no_rm', $no_rm, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('no_rm') }}</small>
						</div>
					</div>
					
				</div>
				<div class="col-md-5">
					<div class="form-group text-center">
						<input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
						@if (isset($request->realtime))
							<a href="{{url('/frontoffice/antrian-realtime')}}"  class="btn btn-warning btn-flat">KEMBALI</a>
							
						@endif
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<hr>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover'>
				<thead>
					<tr class="text-center">
						<th>No</th>
						<th>No. RM</th>
						<th>Nama Pasien</th>
						<th class="text-center">Kelamin</th>
						<th class="text-center">Tgl Registrasi</th>
						<th class="text-center">Pelayanan</th>
						<th class="text-center">SEP</th>
						<th class="text-center">E-Resume</th>
						<th class="text-center">Resep</th>
						<th class="text-center">Hasil Lab</th>
						<th class="text-center">Hasil Radiologi</th>
					</tr>
				</thead>
                <tbody>
					@foreach ($registrasi as $r)
						@php
							$status_reg = cek_status_reg($r->status_reg);
						@endphp
						<tr>
							<td class="text-center">{{$no++}}</td>
							<td class="text-center">{{$pasien->no_rm}}</td>
							<td class="text-center">{{$pasien->nama}}</td>
							<td class="text-center">{{$pasien->kelamin}}</td>
							<td class="text-center">{{$r->created_at}}</td>
							<td>
								@if ($status_reg == 'I')
									Rawat Inap
								@elseif ($status_reg == 'J')
									Rawat Jalan
								@elseif ($status_reg == 'G')
									IGD
								@endif
							</td>
							<td class="text-center">
								@if (!empty($r->no_sep))
								<a href="{{ url('cetak-sep/'.$r->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
								@else
								-
								@endif
							</td>
							<td class="text-center">
								@if (!empty(json_decode(@$r->tte_resume_pasien)->base64_signed_file))
									<a href="{{ url('cetak-tte-eresume-pasien/pdf/' . @$r->id) }}"
										target="_blank" class="btn btn-success btn-sm btn-flat"> <i
											class="fa fa-print"></i> </a>
								@else
								<a href="{{ url('cetak-eresume-pasien/pdf/'.$r->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
								@endif
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
							</td>
							<td class="text-center">
								@if (!empty(json_decode(@$r->tte_hasillab_lis)->base64_signed_file))
									<a href="{{ url('pemeriksaanlab/cetakAll-lis-tte/' . @$r->id) }}"
										target="_blank" class="btn btn-success btn-sm btn-flat"> <i
											class="fa fa-print"></i> </a>
								@else
								<a href="{{ url('pemeriksaanlab/cetakAll-lis/'.$r->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
								@endif
							</td>
							<td> 
								<div class="btn-group">
								  <button type="button" class="btn btn-sm btn-success">Cetak</button>
								  <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
									  <span class="caret"></span>
									  <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
									@foreach ($r->ekspertise as $p)
									  <li>
										<a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$p->registrasi_id."/".$p->folio_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
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
	</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.datepicker').datepicker();
      $('.select2').select2();
    });

	function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }
  </script>
@endsection
