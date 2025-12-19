@extends('master')

@section('header')
  <h1>Master Poli Type </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Politype &nbsp;
          <a href="{{ route('politype.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($politype as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->kode }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>
                    <a href="{{ route('politype.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
