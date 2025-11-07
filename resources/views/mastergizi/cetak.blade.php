@extends('master')
@section('header')
  <h1>Cetak Label Gizi Pasien Rawat Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'gizi/cetak', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true,'autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <br>

        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No. RM Baru</th>
              <th>Nama Pasien</th>
              <th class="text-center"> Kelamin</th>
              <th class="text-center"> Usia</th>
              <th class="text-center"> Diet</th>
              <th class="text-center"> Waktu Makan</th>
              <th class="text-center"> Kamar</th>
              <th class="text-center"> Bed</th>
              <th class="text-center"> Tgl Registrasi</th>
              <th class="text-center"> Label</th> 
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              @php
                  $konsul_gizi = App\EmrInapPerencanaan::where('registrasi_id', $d->id)->where('type', 'konsultasi-gizi')->orderBy('id', 'DESC')->first();
                  $konsul = $konsul_gizi ? json_decode($konsul_gizi->keterangan) : null;
              @endphp
              @if (!empty($d->pasien_id))
                <tr class="text-center">
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  <td class="text-left">{{ !empty($d->pasien_id) ? strtoupper($d->pasien->nama) : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? hitung_umur($d->pasien->tgllahir) : '' }}</td>
                  <td>
                      {{ !empty($konsul) && isset($konsul->bentuk_makanan) ? $konsul->bentuk_makanan : '' }}
                      {{ !empty($konsul) && isset($konsul->jenis_diet) ? ', ' . $konsul->jenis_diet : '' }}
                  </td>
                  <td>{{ !empty($konsul) && isset($konsul->waktu_makan) ? $konsul->waktu_makan : '' }}</td> 
                  <td>{{ !empty($d->rawat_inap) ? $d->rawat_inap->kamar->nama : '' }}</td>
                  <td>{{ !empty($d->rawat_inap) ? $d->rawat_inap->bed->nama : '' }}</td>
                  <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                  <td><a href="{{ url('gizi/cetak-label/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a></td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>

@endsection
