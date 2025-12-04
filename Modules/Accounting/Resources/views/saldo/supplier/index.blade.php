@extends('master')

@section('header')
  <h1>Saldo Supplier </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Saldo Supplier &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>No</th>
                <th>Nama</th>
                <th>Telepone</th>
                <th>Nama Pejabat</th>
                <th>Status</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Saldo</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $d)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $d['nama'] }}</td>
                  <td>{{ $d['telepon'] }}</td>
                  <td>{{ $d['nama_pejabat'] }}</td>
                  <td>@if ($d['status'] == 1) Active @else Inactive @endif</td>
                  <td>{{ $d['journal']['debit'] }}</td>
                  <td>{{ $d['journal']['credit'] }}</td>
                  <td>{{ $d['journal']['total'] }}</td>
                  {{-- <td>
                    <a href="{{ route('politype.edit', $d['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
