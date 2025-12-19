@extends('master')

@section('header')
  <h1>Laporan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal: &nbsp;
      </h4>
    </div>
    <div class="box-body">
      <form action="{{ url('logistikmedik/laporan/pendapatan-pasien-bpjs') }}" class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="periode" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                <input type="text" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL }}" class="form-control datepicker">
              </div>
              <div class="col-sm-1 text-center">
                s/d
              </div>
              <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                <input type="text" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value=" &#xf1c3; PDF">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
    <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Pendapatan Obat Pasien BPJS
      </h4>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed" id="data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Jumlah Pedapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($reg))
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($reg as $d)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ !empty($d->pasien_id) ? baca_pasien($d->pasien_id) :'' }}</td>
                                        <td>{{ number_format(\Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('tarif_id', 10000)->sum('total')) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()
</script>
@endsection
