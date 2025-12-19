@extends('master')
@section('header')
  <h1>Cetak Barcode <small></small></h1>
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
              <th>Poli Tujuan</th>
              <th>Dokter</th>
            </tr>
          </thead>
          <tbody>
            @isset($reg)
              <tr>
                <td>{{ $reg->pasien->nama }}</td>
                <td>{{ $reg->pasien->no_rm }}</td>
                <td>{{ baca_poli($reg->poli_id) }}</td>
                <td>{{ baca_dokter($reg->dokter_id) }}</td>
              </tr>
            @endisset

          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  @if ($reg)
    <META HTTP-EQUIV="REFRESH" CONTENT="5; URL={{ url('frontoffice/cetak_barcode/'.$reg->pasien->id.'/'.$reg->id) }}">
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
