@extends('master')
@section('header')
  <h1>Laporan RL 3.2 Kujungan Rawat Darurat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kujungan-rawat-darurat', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
          <thead>
          <tr>
            <th class="text-center" rowspan="2" valign="top">No</th>
            <th class="text-center" rowspan="2" valign="top">JENIS PELAYANAN</th>
            <th class="text-center" colspan="2" valign="top">TOTAL PASIEN</th>
            <th class="text-center" colspan="3">TINDAK LANJUT PELAYANAN</th>
            <th class="text-center" rowspan="2">MATI < 24Jam </th>
            <th class="text-center" rowspan="2">MATI > 24Jam </th>
            <th class="text-center" colspan="2">DOA</th>
            </tr>
            <tr>
                <th class="text-center">RUJUKAN</th>
                <th class="text-center">NON RUJUKAN</th>
                <th class="text-center">DIRAWAT</th>
                <th class="text-center">DIRUJUK</th>
                <th class="text-center">PULANG</th>
                <th class="text-center">Y</th>
                <th class="text-center">N</th>
            </tr>
          </thead>
          <tbody>
            @if ( isset($rl_kujungan_rawat_darurat) )
              @php
                  $pasienRujukan = 0;
                  $pasienNonRujukan = 0;
                  $dirawat = 0;
                  $dirujuk = 0;
                  $pulang = 0;
                  $matiIGD_1 = 0;
                  $matiIGD_2 = 0;
                  $doa_1 = 0;
                  $doa_2 = 0;
              @endphp
              @foreach ($rl_kujungan_rawat_darurat as $key => $d)
              @php
                  $pasienRujukan += @$d['data']['rujukan']['Puskesmas'] + @$d['data']['rujukan']['Dokter Praktek'] ;
                  $pasienNonRujukan += @$d['data']['rujukan']['Datang Sendiri'] + @$d['data']['rujukan']['null'];
                  $dirawat += @$d['data']['kondisi']['Inap'];
                  $dirujuk += @$d['data']['kondisi']['Di Rujuk'];
                  $pulang += (@$d['data']['kondisi']['Pulang Atas Persetujuan Dokter'] + @$d['data']['kondisi']['Pulang Atas Permintaan Sendiri'] + @$d['data']['kondisi']['Lain - lain'] +  @$d['data']['kondisi']['null']) ;
                  $matiIGD_1 += @$d['data']['kondisi']['Meninggal Dibawah 24 Jam'];
                  $matiIGD_2 +=   @$d['data']['kondisi']['Meninggal Diatas 24 Jam'] ;
                  $doa_1 +=   @$d['data']['doa']['Y'] ;
                  $doa_2 +=   @$d['data']['doa']['N'] ;
              @endphp
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ @$d['poli'] }}</td>
                  <td>{{ @$d['data']['rujukan']['Puskesmas'] + @$d['data']['rujukan']['Dokter Praktek'] }}</td>
                  <td>{{ @$d['data']['rujukan']['Datang Sendiri'] + @$d['data']['rujukan']['null'] }}</td>
                  <td>{{ @$d['data']['kondisi']['Inap'] }}</td>
                  <td>{{ @$d['data']['kondisi']['Di Rujuk'] }}</td>
                  <td>{{ (@$d['data']['kondisi']['Pulang Atas Persetujuan Dokter'] + @$d['data']['kondisi']['Pulang Atas Permintaan Sendiri'] + @$d['data']['kondisi']['Lain - lain']  + @$d['data']['kondisi']['null'])  }}</td>
                  <td>{{ @$d['data']['kondisi']['Meninggal Dibawah 24 Jam']}}</td>
                  <td>{{  @$d['data']['kondisi']['Meninggal Diatas 24 Jam']   }}</td>
                  <td>{{  @$d['data']['doa']['Y']   }}</td>
                  <td>{{  @$d['data']['doa']['N']   }}</td>
                </tr>
              @endforeach
              <tr>
                <th>###</th>
                <th>Total</th>
                <th>{{ @$pasienRujukan }}</th>
                <th>{{ @$pasienNonRujukan }}</th>
                <th>{{ @$dirawat }}</th>
                <th>{{ @$dirujuk }}</th>
                <th>{{ @$pulang - ($matiIGD_1 + $matiIGD_2) }}</th>
                <th>{{ @$matiIGD_1 }}</th>
                <th>{{ @$matiIGD_2 }}</th>
                <th>{{ @$doa_1 }}</th>
                <th>{{ @$doa_2 }}</th>
              </tr>
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
  <script>
    $('#data-table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  </script>
  @endsection