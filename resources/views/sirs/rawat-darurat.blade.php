@extends('master')
@section('header')
<h1>Rekap Laporan</h1>
@endsection

@section('content')

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
      Rawat Darurat
    </h3>
    <div class="text-right">
      <a href="{{ url('sirs/rl') }}" class="btn btn-default">Kembali</a>
      <a href="{{ url('sirs/rl/rawat-darurat/toExcel') }}" class="btn btn-success">Excel</a>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Pelayanan</th>
            <th>Total Pasien Rujukan</th>
            <th>Total Pasien Non Rujukan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>IGD Maternal</td>
            <td>{{ $data['rujukan_maternal'] }}</td>
            <td>{{ $data['nonRujukan_maternal'] }}</td>
          </tr>
          <tr>
            <td>2</td>
            <td>IGD Perinatologi</td>
            <td>{{ $data['rujukan_perinatologi'] }}</td>
            <td>{{ $data['nonRujukan_perinatologi'] }}</td>
          </tr>
          <tr>
            <td>3</td>
            <td>IGD Ponek</td>
            <td>{{ $data['rujukan_ponek'] }}</td>
            <td>{{ $data['nonRujukan_ponek'] }}</td>
          </tr>
          <tr>
            <td>4</td>
            <td>IGD Umum</td>
            <td>{{ $data['rujukan_umum'] }}</td>
            <td>{{ $data['nonRujukan_umum'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection