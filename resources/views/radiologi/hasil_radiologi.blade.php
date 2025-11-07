@extends('master')
@section('header')
  <h1>Radiologi - Hasil Radiologi <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
		{!! Form::open(['method' => 'POST', 'url' => 'radiologi/hasil-radiologi', 'class'=>'form-hosizontal']) !!}
		<div class="row">
			<div class="col-md-6">
			<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
				<span class="input-group-btn">
				<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal Registrasi</button>
				</span>
				{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
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
              {{-- <th>No Dokumen</th>
              <th>Ekspertise</th> --}}
              <th>Tanggal Pendaftaran</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @isset($radiologi)
              @foreach ($radiologi as $d)
                  @php
                      $reg = \Modules\Registrasi\Entities\Registrasi::find($d->id);
                      $folio = Modules\Registrasi\Entities\Folio::find($d->folios_id);
                  @endphp
                  <tr>
                    <td>{{ $no++  }}</td>
                    <td>{{ baca_pasien($reg->pasien_id) }}</td>
                    <td>{{ baca_norm($reg->pasien_id) }}</td>
                    <td>{{ baca_carabayar($reg->bayar) }}</td>
                    <td>{{ baca_poli($reg->poli_id) }}</td>
                    {{-- <td>{{ $d->no_dokument }}</td>
                    <td>{!! substr($d->ekspertise,0,50) !!}</td> --}}
                    <td>{{ $reg->created_at->format('d-m-Y H:i:s') }}</td>
                    <td> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                          <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (\App\RadiologiEkspertise::where('registrasi_id', $d->id)->get() as $p)
                              <li>
                                <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->id."/".$folio->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                                @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                  <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$d->id."/".$d->folios_id)}}" target="_blank" class="btn btn-success btn-sm btn-flat"> Dokumen TTE </a>
                                @elseif (!empty(@$p->tte))
                                  <a href="{{ url("/dokumen_tte/".@$p->tte)}}" target="_blank" class="btn btn-success btn-sm btn-flat"> Dokumen TTE </a>
                                    @endif
                              </li>
                            @endforeach
                          </ul>
                        </div>
                    </td>
                  </tr>
              @endforeach
            @endisset
          </tbody>
        </table>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
