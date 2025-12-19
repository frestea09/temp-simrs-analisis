@extends('master')
@section('header')
  <h1>Kelompok Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Kelompok Tarif &nbsp;
        <a href="{{ url('kelompoktarif/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Kelompok Tarif</th>
                <th style="width: 10%;">Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kelompoktarif as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->kelompok }}</td>
                <td><a href="{{ url('kelompoktarif/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
