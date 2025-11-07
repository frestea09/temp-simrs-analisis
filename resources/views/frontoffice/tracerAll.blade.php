@extends('master')
@section('header')
  <h1>Cetak Tracer <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>Poli Tujuan</th>
              <th>Dokter</th>
              <th>Cara Bayar</th>
              <th>Antrian</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->pasien->nama }}</td>
                <td>{{ $d->pasien->no_rm }}</td>
                <td>{{ !empty($d->poli_id) ? $d->poli->nama : NULL }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ baca_carabayar($d->bayar) }}</td>
                <td class="text-center">{{ $d->antrian_poli }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
  @if ($data->count() > 0)
    <META HTTP-EQUIV="REFRESH" CONTENT="10; URL={{ url('frontoffice/cetakTracerAll') }}">
  @endif

@endsection

@section('script')
  <script type="text/javascript">
  $(document).ready(function() {
    setInterval(function () {
      location.reload();
    },15000); //defaul: 10000
  });
  </script>
@endsection
