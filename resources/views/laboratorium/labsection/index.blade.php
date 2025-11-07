@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Lab Section &nbsp;
          <a href="{{ route('labsection.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
          {{-- <a href="{{ route('labkategori.create') }}" class="btn btn-warning btn-sm"><i class="fa fa-recycle"></i></a> --}}
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
              @foreach ($labsection as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>
                    <a href="{{ route('labsection.edit', $d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                  <td>
                    {{-- <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a> --}}
                    <a href="{{ url('laboratorium/hapus-lapsection/'.$d->id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
