@extends('master')
@section('header')
  <h1>Rujukan</h1>
@endsection
@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Rujukan &nbsp;
        <a href="{{ url('perusahaan/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>

      </h3>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Rujukan</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rujukan as $k)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $k->nama }}</td>
              <td><a href="{{ url('rujukan/'.$k->id.'/edit') }}" class="btn btn-flat btn-sm btn-info"><i class="fa fa-edit"></i></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@stop
