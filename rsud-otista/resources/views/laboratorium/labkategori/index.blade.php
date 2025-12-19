@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Lab Kategori &nbsp;
          <a href="{{ route('labkategori.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
          
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Edit</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($labkategori as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>
                    <a href="{{ route('labkategori.edit', $d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('laboratorium/hapus-lapkategori/'.$d->id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></a>
                  <td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
