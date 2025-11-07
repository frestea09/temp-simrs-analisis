@extends('master')
@section('header')
  <h1>Supliyer </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Supliyer &nbsp;
          <a href="{{ route('supliyer.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kode</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Pimpinan</th>
                <th>Aktif</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($supliyer as $key => $value)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->kode }}</td>
                <td>{{ $value->telepon }}</td>
                <td>{{ $value->alamat }}</td>
                <td>{{ $value->pimpinan }}</td>
                <td>{{ $value->aktif }}</td>
                <td><a href="{{ url('supliyer/'.$value->id.'/edit') }}" class="btn btn-success btn-md"><i class="fa fa-edit"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
