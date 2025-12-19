@extends('master')
@section('header')
  <h1>Echocardiogram - Hasil Echocardiogram <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'echocardiogram/hasil-echocardiogram', 'class'=>'form-hosizontal']) !!}
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
		<table class="table table-striped table-bordered table-hover table-condensed" id="data">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama</th>
              <th>No RM</th>
              <th>Cara Bayar</th>
              <th>Klinik / Ruangan</th>
              <th>Tanggal Pendaftaran</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
          	@foreach ($echocardiogram as $d)
                <tr>
                  <td>{{ $no++  }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td> <a href="{{ url("echocardiogram/cetak-echocardiogram/".$d->registrasi_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-print"></i> </a> </td>
                </tr>
          	@endforeach
          </tbody>
        </table>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
