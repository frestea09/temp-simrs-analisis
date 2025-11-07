@extends('master')
@section('header')
  <h1>Form Pembuatan SEP<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'cari-sep/noka', 'class' => 'form-horizontal']) !!}

          <div class="form-group{{ $errors->has('no_kartu') ? ' has-error' : '' }}">
              {!! Form::label('no_kartu', 'No. Kartu', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::text('no_kartu', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('no_kartu') }}</small>
              </div>
              <div class="col-sm-2">
                {!! Form::submit("Cari", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
          </div>
      {!! Form::close() !!}

      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>Nama</th>
              <th>No. JKN</th>
              <th>Jenis JKN</th>
              <th>Hak Kelas</th>
              <th>Status Kartu</th>
              <th>NIK</th>
              <th>tgl cetak kartu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $nama }}</td>
              <td>{{ $no_kartu }}</td>
              <td>{{ $jenis }}</td>
              <td>{{ $hak_kelas }}</td>
              <td>{{ $keterangan }}</td>
              <td>{{ $nik }}</td>
              <td>{{ $tgl_cetak }}</td>
            </tr>
          </tbody>
        </table>
      </div>
@endsection
