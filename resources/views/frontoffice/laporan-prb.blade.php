@extends('master')

@section('header')
<h1>Laporan PRB</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>

  <div class="box-body">
    {!! Form::open([
        'method' => 'POST',
        'url' => 'frontoffice/laporan/data-prb',
        'class' => 'form-horizontal'
    ]) !!}
    {{ csrf_field() }}

    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label class="col-md-3 control-label">Periode</label>
          <div class="col-md-4">
            {!! Form::text('tga', $tga, [
                'class' => 'form-control datepicker',
                'autocomplete' => 'off'
            ]) !!}
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>

          <div class="col-md-4">
            {!! Form::text('tgb', $tgb, [
                'class' => 'form-control datepicker',
                'autocomplete' => 'off'
            ]) !!}
            <small class="text-danger">{{ $errors->first('tgb') }}</small>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
        <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
      </div>
    </div>
    {!! Form::close() !!}

    <hr>

    {{-- ===================== TABLE ===================== --}}
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed" id="data">
        <thead>
          <tr>
            <th>No</th>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Tanggal Registrasi</th>
            <th>Tanggal Kunjungan</th>
            <th>Dokter</th>
            <th>Poliklinik</th>
            <th>Diagnosa</th>
            {{-- <th>Tanggal Kontrol PRB</th> --}}
          </tr>
        </thead>
        <tbody>
          @if(!empty($rujukan))
            @foreach ($rujukan as $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_registrasi)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_kunjungan)->format('d-m-Y') }}</td>
                <td>{{ $d->nama_dokter }}</td>
                <td>{{ $d->nama_poli }}</td>
                <td>{{ $d->assesment ?? '-' }}</td>
                {{-- <td>
                  {{ !empty($d->waktu_prb)
                      ? \Carbon\Carbon::parse($d->waktu_prb)->format('d-m-Y')
                      : '-' }}
                </td> --}}
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <div class="box-footer">
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $('.select2').select2();
  });
</script>
@endsection