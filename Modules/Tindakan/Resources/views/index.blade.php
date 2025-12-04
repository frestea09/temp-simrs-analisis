@extends('master')

@section('header')
  <h1>Rawat Jalan  - Billing System - Entry Tindakan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Entri Tindakan &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'tindakan.search']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::date('tgb', null, ['class' => 'form-control', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
            </div>
          </div>
          </div>
        {!! Form::close() !!}

        <hr>

        {{-- Data Registrasi --}}

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>No. Reg</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Bayar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->reg_id }}</td>
                  <td>{{ $d->dokter->nama }}</td>
                  <td>{{ $d->poli->nama }}</td>
                  <td>{{ $d->bayar }}</td>
                  <td>
                    <a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
