@extends('master')
@section('header')
  <h1>Sebab Sakit</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Sebab Sakit &nbsp;
        <a href="{{ url('sebabsakit/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
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
              </tr>
            </thead>
            <tbody>
              @foreach ($sebabsakit as $k)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $k->nama }}</td>
                <td><a href="{{ url('sebabsakit/'.$k->id.'/edit') }}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
