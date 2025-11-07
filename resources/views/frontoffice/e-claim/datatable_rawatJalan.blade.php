@extends('master')
@section('header')
  <h1>Bridging E-Klaim Rawat Jalan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      <div class='table-responsive'>
        <table id='eklaimRJ' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama Pasien</th>
              <th>Poli</th>
              <th>Dokter Penanggung Jawab</th>
              <th>Cara Bayar</th>
              <th>No. SEP</th>
              <th>Tgl Reg</th>
              <th>Proses</th>
            </tr>
          </thead>

        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
