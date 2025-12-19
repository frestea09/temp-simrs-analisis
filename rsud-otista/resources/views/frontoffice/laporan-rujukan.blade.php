@extends('master')
@section('header')
<h1>Laporan Rujukan</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/rujukan', 'class'=>'form-horizontal']) !!}
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="tga" class="col-md-3 control-label">Periode</label>
          <div class="col-md-4">
            {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <div class="col-md-4">
            {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            <small class="text-danger">{{ $errors->first('tgb') }}</small>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
        <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
        {{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">  --}}
      </div>
    </div>
    {!! Form::close() !!}

    <hr>
    {{-- ================================================================================================== --}}
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
        <thead>
          <tr>
            <th>No</th>
            <th>No.RM</th>
            <th>Nama Pasien</th>
            <th>Tanggal Kunjungan</th>
            <th>Dokter yang Merujuk</th>
            <th>Unit</th>
            <th>Asal Poliklinik</th>
            <th>Ruangan</th>
            <th>Diagnosa</th>
            <th>Faskes Rujukan</th>
            <th>Rumah Sakit Rujukan</th>
            <th>Jenis Rujukan</th>
          </tr>
        </thead>
        <tbody>
          @if(!empty($rujukan))
            @foreach ($rujukan as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->no_rm }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ \Carbon\Carbon::parse($d->tanggal_kunjungan)->format('d-m-Y') }}</td>
              <td>{{ $d->nama_dokter }}</td>
              <td>{{ $d->unit }}</td>
              <td>{{ $d->nama_poli}}</td>
              <td>{{ $d->ruangan ?? '-' }}</td>
              <td>{{ $d->assesment ?? '-' }}</td>
              <td>{{ $d->diRujukKe }}</td>
              <td>{{ $d->rsRujukan }}</td>
              <td></td>
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
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
@endsection
