@extends('master')
@section('header')
  <h1>Tahun Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Tahun Tariif &nbsp;
        <a href="{{ url('tahuntarif/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Tahun Tarif</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tahuntarif as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->tahun }}</td>
                <td><a href="{{ url('tahuntarif/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
