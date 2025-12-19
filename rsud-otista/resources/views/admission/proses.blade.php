@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Pemilihan Kamar Perawatan &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <h3>Data Pasien</h3>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tbody>
            <tr>
              <td>No. RM</td> <td>{{ $reg->pasien->no_rm }}</td> <td>Jenis Kelamin</td> <td>{{ $reg->pasien->kelamin }}</td>
            </tr>
            <tr>
              <td>Nama Lengkap</td> <td>{{ $reg->pasien->nama }}</td> <td>Jenis Pasien </td> <td>{{ baca_carabayar($reg->bayar) }}</td>
            </tr>
            <tr>
              <td>No. RM</td> <td>{{ hitung_umur($reg->pasien->tgllahir) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
@stop
