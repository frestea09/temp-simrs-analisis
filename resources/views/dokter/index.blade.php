@extends('master')
@section('header')
  <h1>Dokter</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Dokter &nbsp;
        <a href="{{ url('dokter/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Poli</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dokter as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->nama }}</td>
                <td>{{ $e->poli->nama }}</td>
                <td><a href="{{ url('dokter/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
