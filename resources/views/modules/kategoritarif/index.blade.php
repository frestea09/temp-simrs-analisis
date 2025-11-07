@extends('master')

@section('header')
  <h1>Master Kategori Tarif Instalasi</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Kategori Tarif Instalasi &nbsp;
          <a href="{{ route('kategoritarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kategori Header</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kategoritarif as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->namatarif }}</td>
                <td>{{ $d->kategoriheader->nama }}</td>
                <td>
                  <a href="{{ route('kategoritarif.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
@stop
