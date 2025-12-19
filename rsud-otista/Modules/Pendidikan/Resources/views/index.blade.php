@extends('master')
@section('header')
  <h1>Pendidikan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pendidikan &nbsp;
        <a href="{{ url('pendidikan/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Pendidikan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pendidikan as $k)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $k->pendidikan }}</td>
                <td><a href="{{ url('pendidikan/'.$k->id.'/edit') }}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
@endsection
