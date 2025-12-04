@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Pasien tset &nbsp;
          <a href="{{ route('pasien.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Kelamin</th>
                <th>Umur</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $key => $d)
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
@stop
