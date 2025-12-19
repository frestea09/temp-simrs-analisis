@extends('master')

@section('header')
  <h1>Batal Bayar<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Bayar</th>
              <th>User Pelunasan</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tindakan Nama</th>
              <th>Tindakan Pelaksana</th>
              <th>No Kwitansi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->namatarif }}</td>
                <td>{{ $d->pelaksana }}</td>
                <td>{{ $d->no_kwitansi }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
