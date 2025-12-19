@extends('master')
@section('header')
  <h1>Biaya Registrasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Biaya Registrasi &nbsp;
        <a href="{{ url('biayaregistrasi/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Tipe Biaya Registrasi</th>
                <th>Shift</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($biayaregistrasi as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->tipe }}</td>
                <td>{{ $e->shift }}</td>
                <td><a href="{{ url('biayaregistrasi/'.$e->id.'/edit') }}"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
