@extends('master')
@section('header')
<h1>Rekap Laporan</h1>
@endsection

@section('content')

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
      Gigi & Mulut
    </h3>
    <div class="text-right">
      <a href="{{ url('sirs/rl') }}" class="btn btn-default">Kembali</a>
      <a href="{{ url('rekap-laporan/gigi-mulut/toExcel') }}" class="btn btn-success">Excel</a>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Mapping</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $data['mapping'] as $key => $item)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->tarif_count }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection