@extends('master')

@section('header')
  <h1>Jurnal Umum </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Jurnal Umum &nbsp;
          <a href="{{ route('journal_umum.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>Tanggal</th>
                <th>Kode Jurnal</th>
                <th>Status</th>
                <th>Total Transaksi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  {{-- <td>{{ $key+1 }}</td> --}}
                  <td>{{ date('d-m-Y', strtotime($d['tanggal'])) }}</td>
                  <td>{{ $d['code'] }}</td>
                  <td>@if ($d['verifikasi'] == 1) Sudah Verifikasi @else Belum Verifikasi @endif</td>
                  <td>{{ number_format(($d['debit'] + $d['credit']) / 2) }}</td>
                  <td>
                    <a href="{{ route('journal_umum.show', $d['id']) }}" class="btn btn-success btn-sm"><i class="fa fa-info"></i></a>
                    @if ($d['verifikasi'] == 0)
                      <a href="{{ route('journal_operasional.verifikasi', $d['id']) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop