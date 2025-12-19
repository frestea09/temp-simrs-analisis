@extends('master')
@section('header')
  <h1>Biaya Pemeriksaan Infus</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Biaya Pemeriksaan Infus &nbsp;
        <a href="{{ url('biayapemeriksaaninfus/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Total Tarif</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($biayapemeriksaan as $key=>$e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->nama_biaya }}</td>
                <td>{{ @$e->detail ? count($e->detail) : 0 }}</td>
                <td>
                    <a href="{{ url('biayapemeriksaaninfus/'.$e->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                </td>
                <td>
                    <a href="{{ url('biayapemeriksaaninfus/'.$e->id.'/delete') }}"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
