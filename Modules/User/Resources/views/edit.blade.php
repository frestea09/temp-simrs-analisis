@extends('master')
@section('header')
  <h1>Management User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data User &nbsp;
        <a href="{{ route('user.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($user as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->name }}</td>
              <td>{{ $d->email }}</td>
              <td>
                @foreach ($d->role as $r)
                  {{$r->name}}
                @endforeach
              </td>
              <td></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
