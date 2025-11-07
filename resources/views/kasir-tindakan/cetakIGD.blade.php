@extends('master')

@section('header')
  <h1>Kasir IGD - Cetak Ulang <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kasir/cetakIGD', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>JK</th>
              <th>Cara Bayar</th>
              <th class="text-center">Kwitansi</th>
              {{-- <th class="text-center">Kwitansi Non Jasa Racik</th> --}}
              <th class="text-center">Rincian Biaya</th>
              {{-- <th class="text-center">Rincian Biaya Non Jasa Racik</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($pemb as $key => $d)
              @php
                $bayar = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
              @endphp
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->nama : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $d->pasien->kelamin : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? $bayar->bayars->carabayar : '' }} {{ !empty($bayar->tipe_jkn) ? ' - '.$bayar->tipe_jkn : '' }}</td>
                  <td class="text-center">
                    <a href="{{ url('kasir/cetak/cetakkuitansi/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/cetak/cetakkuitansinonjasaracik/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
                  <td class="text-center">
                    <a href="{{ url('kasir/rincian-biaya/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('kasir/rincian-biaya-non-jasa/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                  </td> --}}
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
