@extends('master')

@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Pegawai &nbsp;
          <a href="{{ route('pegawai.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>TTL</th>
                <th>Kelamin</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pegawai as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->tmplahir }}, {{ $d->tgllahir }}</td>
                  <td>{{ $d->kelamin }}</td>
                  <td>{{ $d->agama }}</td>
                  <td>{{ $d->alamat }}</td>
                  <td>
                    <a href="{{ route('pegawai.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
