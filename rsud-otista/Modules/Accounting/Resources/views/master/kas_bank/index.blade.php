@extends('master')

@section('header')
  <h1>Master Kas dan Bank </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Kas dan Bank &nbsp;
          <a href="{{ route('master.kas_bank.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>Kode</th>
                <th>Nama</th>
                <th>No Rek</th>
                <th>Akun COA</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  {{-- <td>{{ $key+1 }}</td> --}}
                  <td>{{ $d['code'] }}</td>
                  <td>{{ $d['nama'] }}</td>
                  <td>{{ $d['no_rek'] }}</td>
                  <td>{{ implode(' - ', [$d['akun_coa']['code'], $d['akun_coa']['nama']]) }}</td>
                  <td>@if ($d['status'] == 1) Active @else Inactive @endif</td>
                  <td>
                    <a href="{{ route('master.kas_bank.edit', $d['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
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
