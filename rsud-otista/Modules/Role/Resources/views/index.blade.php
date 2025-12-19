@extends('master')

@section('header')
  <h1>Master Role </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Role &nbsp;
          <a href="{{ route('role.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Role</th>
                <th>Display</th>
                <th>Keterangan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($role as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->display_name }}</td>
                    <td>{{ $d->description }}</td>
                    <td></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
