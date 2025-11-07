@extends('master')
@section('header')
  <h1>RL 3.4 Kebidanan</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Periode</h3>
  </div>
  <div class="box-body">
  {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/kebidanan', 'class'=>'form-horizontal']) !!}
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="tga" class="col-md-2 control-label">Periode</label>
          <div class="col-md-5">
            {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <div class="col-md-5">
            {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            <small class="text-danger">{{ $errors->first('tgb') }}</small>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group text-center">
          <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
          <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
          {{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK"> --}}
        </div>
      </div>
    </div>
  {!! Form::close() !!}
  <hr>
  <div class='table-responsive'>
    <table class='table table-bordered table-hover'>
      <thead>
        <tr>
          <th class="text-center" rowspan="3">No</th>
          <th class="text-center" rowspan="3">Jenis Kegiatan</th>
          <th class="text-center" colspan="8">Rujukan</th>
          <th class="text-center" colspan="2" rowspan="2">Non Rujukan</th>
          <th class="text-center" rowspan="3">Dirujuk</th>
        </tr>
        <tr>
          <th class="text-center" colspan="6">Medis</th>
          <th class="text-center" colspan="2">Non Medis</th>
        </tr>
        <tr>
          <th class="text-center">Rumah Sakit</th>
          <th class="text-center">Bidan</th>
          <th class="text-center">Puskesmas</th>
          <th class="text-center">Faskes Lainnya</th>
          <th class="text-center">Jumlah Mati</th>
          <th class="text-center">Jumlah Total</th>
          <th class="text-center">Jumlah Mati</th>
          <th class="text-center">Jumlah Total</th>
          <th class="text-center">Jumlah Mati</th>
          <th class="text-center">Jumlah Total</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($result_kebidanan))
        @php
          $totRumahSakit = 0;
          $totBidan = 0;
          $totPuskesmas = 0;
          $totFaskes = 0;
          $totJmlMatiRujMedis = 0;
          $totRujMedis = 0;
          $totJmlMatiRujNonMedis = 0;
          $totRujNonMedis = 0;
          $totJmlMatiNonRuj = 0;
          $totNonRuj = 0;
          $totDirujuk = 0;
        @endphp
          @foreach($result_kebidanan as $item)
            @php
              $totRumahSakit += $item['rujukan'][3]['Rumah Sakit'];
              $totBidan += $item['rujukan'][4]['Bidan'];
              $totPuskesmas += $item['rujukan'][1]['Puskesmas'];
              $totFaskes += $item['rujukan'][2]['Dokter Praktek'] + $item['rujukan'][0]['Datang Sendiri'];
              $totJmlMatiRujMedis += $item['rujukan'][0]['Datang Sendiri mati'] + $item['rujukan'][1]['Puskesmas mati'] + $item['rujukan'][3]['Rumah Sakit'] + $item['rujukan'][2]['Dokter Praktek mati'];
              $totRujMedis += $item['rujukan'][0]['Datang Sendiri mati'] + $item['rujukan'][1]['Puskesmas mati'] + $item['rujukan'][3]['Rumah Sakit'] + $item['rujukan'][2]['Dokter Praktek mati'] + $item['rujukan'][2]['Dokter Praktek'] + $item['rujukan'][0]['Datang Sendiri'] + $item['rujukan'][1]['Puskesmas'] + $item['rujukan'][4]['Bidan'] + $item['rujukan'][3]['Rumah Sakit'];
              $totJmlMatiRujNonMedis += 0;
              $totRujNonMedis += 0;
              $totJmlMatiNonRuj += 0;
              $totNonRuj += 0;
              $totDirujuk += $item['rujukan'][0]['Datang Sendiri dirujuk'] + $item['rujukan'][1]['Puskesmas dirujuk'] + $item['rujukan'][3]['Rumah Sakit dirujuk'] + $item['rujukan'][2]['Dokter Praktek dirujuk'];
            @endphp
            <tr>
              <td>{{ $item['no'] }}</td>
              <td>{{ $item['nama'] }}</td>
              <td> <!-- Rumah Sakit -->
                {{ $item['rujukan'][3]['Rumah Sakit'] }}
              </td>
              <td>  <!-- Bidan -->
                {{ $item['rujukan'][4]['Bidan'] }}
              </td>
              <td>  <!-- Puskesmas -->
                {{ $item['rujukan'][1]['Puskesmas'] }}
              </td>
              <td>  <!-- Faskes Lainnya -->
                {{ $item['rujukan'][2]['Dokter Praktek'] + $item['rujukan'][0]['Datang Sendiri'] }}
              </td>
              <td>  <!-- Jml Mati Rujukan Medis -->
                {{ $item['rujukan'][0]['Datang Sendiri mati'] + $item['rujukan'][1]['Puskesmas mati'] + $item['rujukan'][3]['Rumah Sakit'] + $item['rujukan'][2]['Dokter Praktek mati'] }}
              </td>
              <td> <!-- Jml Total Rujukan Medis -->
                {{ $item['rujukan'][0]['Datang Sendiri mati'] + $item['rujukan'][1]['Puskesmas mati'] + $item['rujukan'][3]['Rumah Sakit'] + $item['rujukan'][2]['Dokter Praktek mati'] + $item['rujukan'][2]['Dokter Praktek'] + $item['rujukan'][0]['Datang Sendiri'] + $item['rujukan'][1]['Puskesmas'] + $item['rujukan'][4]['Bidan'] + $item['rujukan'][3]['Rumah Sakit'] }}
              </td>
              <td> <!-- Jml Mati Rujukan Non Medis -->
                {{ 0 }}
              </td>
              <td> <!-- Jml Total Rujukan Non Medis -->
                {{ 0 }}
              </td>
              <td> <!-- Jml Mati Non Rujukan -->
                {{ 0 }}
              </td>
              <td> <!-- Jml Total Non Rujukan -->
                {{ 0 }}
              </td>
              <td> <!-- Jml Dirujuk -->
                {{ $item['rujukan'][0]['Datang Sendiri dirujuk'] + $item['rujukan'][1]['Puskesmas dirujuk'] + $item['rujukan'][3]['Rumah Sakit dirujuk'] }}
              </td>
            </tr>
          @endforeach
          <tr>
            <th>#</th>
            <th>TOTAL</th>
            <th>{{ $totRumahSakit }}</th>
            <th>{{ $totBidan }}</th>
            <th>{{ $totPuskesmas }}</th>
            <th>{{ $totFaskes }}</th>
            <th>{{ $totJmlMatiRujMedis }}</th>
            <th>{{ $totRujMedis }}</th>
            <th>{{ $totJmlMatiRujNonMedis }}</th>
            <th>{{ $totRujNonMedis }}</th>
            <th>{{ $totJmlMatiNonRuj }}</th>
            <th>{{ $totNonRuj }}</th>
            <th>{{ $totDirujuk }}</th>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable({
          'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
        })
        $('.datepicker').datepicker();
    });
  </script>
@endsection