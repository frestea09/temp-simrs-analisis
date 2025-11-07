@extends('master')
@section('header')
  <h1>Bridging E-Klaim Rawat Jalan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/e-claim/dataRawatJalan', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::date('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>

        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::date('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama Pasien</th>
              <th>Poli</th>
              <th>Dokter Penanggung Jawab</th>
              <th>Cara Bayar</th>
              <th>No. SEP</th>
              <th>Tgl Reg</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ $d->pasien->no_rm }}</td>
                <td>{{ $d->pasien->nama }}</td>
                <td>{{ $d->poli->nama }}</td>
                <td>{{ $d->dokter->nama }}</td>
                <td>{{ baca_carabayar($d->bayar).' - '.$d->tipe_jkn }}</td>
                <td>{{ $d->no_sep }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                <td>
                  <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-database"></i></a>
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
