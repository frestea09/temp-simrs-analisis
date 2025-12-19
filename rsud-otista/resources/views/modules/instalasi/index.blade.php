@extends('master')
@section('header')
  <h1>Master Instalasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Instalasi Rumah Sakit
        <a href="{{ route('instalasi.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> &nbsp; Tambah Instalasi</a>
      </h3>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Instalasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($instalasi as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->nama }}</td>
              <td>
                <a href="{{ route('instalasi.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
