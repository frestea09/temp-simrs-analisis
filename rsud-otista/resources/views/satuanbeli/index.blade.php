@extends('master')
@section('header')
  <h1>Satuan Beli </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Satuan Beli &nbsp;
          <a href="{{ route('satuanbeli.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
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
              @foreach ($satuanbeli as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>
                    <a href="{{ route('satuanbeli.edit', $d->id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
