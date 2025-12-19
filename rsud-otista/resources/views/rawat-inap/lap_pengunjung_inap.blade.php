@extends('master')
@section('header')
  <h1>Rawat Inap - Laporan Pengunjung </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/lap_pengunjung_inap', 'class'=>'form-horizontal']) !!}
      <div class="row">
        {{--  <div class="col-md-4">
          <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}" type="button">Klinik</button>
              </span>
              {!! Form::select('poli_id', $klinik, NULL, ['class' => 'chosen-select datepicker']) !!}
              <small class="text-danger">{{ $errors->first('politipe') }}</small>
          </div>
        </div>  --}}
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-4">
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
      <h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $reg->count() }}</h4>

      
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. RM</th>
              <th>Umur</th>
              <th>Ruangan</th>
              <th>Dokter</th>
              <th>Jenis Pasien</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ hitung_umur($d->tgllahir) }}</td>
                <td>
                  {{ baca_kamar($d->kamar_id) }}
                </td>
                <td>
                  {{ baca_dokter($d->dokter_id) }}
                </td>
                <td>
                  {{ $d->status }}
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>


@endsection
