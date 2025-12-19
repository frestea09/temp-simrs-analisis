@extends('master')
@section('header')
  <h1>Antrian Cetak SEP <small></small></h1>
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
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>No. SEP</th>
              <th>Poli Tujuan</th>
              <th>Dokter</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sep as $d)
              <tr>
                <td>{{ $d->pasien->nama }}</td>
                <td>{{ $d->pasien->no_rm }}</td>
                <td>{{ $d->no_sep }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  @if ($sep->count() > 0)
    <META HTTP-EQUIV="REFRESH" CONTENT="5; URL={{ url('frontoffice/cetak-sep/') }}">
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
