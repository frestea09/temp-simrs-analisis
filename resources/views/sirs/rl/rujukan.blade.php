@extends('master')
@section('header')
  <h1>Laporan RL 3.14 Kegiatan Rujukan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-rujukan', 'class'=>'form-hosizontal']) !!}
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
                <th class="text-center" rowspan="2" valign="top">JENIS SPESIALISASI</th>
                <th class="text-center" colspan="6" valign="top">RUJUKAN</th>
                <th class="text-center" colspan="3">DIRUJUK</th>
            </tr>
            <tr>
                <th class="text-center">DITERIMA DARI PUSKESMAS</th>
                <th class="text-center">DITERIMA DARI FASILITAS KES. LAIN</th>
                <th class="text-center">DITERIMA DARI RS LAIN</th>
                <th class="text-center">DIKEMBALIKAN KE PUSKESMAS</th>
                <th class="text-center">DIKEMBAlIKAN KE FASILITAS KES.LAIN</th>
                <th class="text-center">DIKEMBALIKAN KE RS ASAL</th>
                <th class="text-center">PASIEN RUJUKAN</th>
                <th class="text-center">PASIEN DATANG SENDIRI</th>
                <th class="text-center">DITERIMA KEMBALI</th>
            </tr>
          </thead>
          <tbody>
            @if ( isset($kegitan_rujukan) )
              @php
                  $diterimaPuskesmas = 0;
                  $diterimaFaskes = 0;
                  $diterimaRS = 0;
                  $pasienRujukan = 0;
                  $pasienSendiri = 0;
              @endphp
              @foreach ($kegitan_rujukan as $key => $d)
              @php
                  $diterimaPuskesmas += @$d['data']['rujukan'][1]['Puskesmas'];
                  $diterimaFaskes += @$d['data']['rujukan'][2]['Dokter Praktek'] + @$d['data']['rujukan'][4]['Bidan'] + @$d['data']['rujukan'][5]['Balai Pengobatan'] + @$d['data']['rujukan'][6]['null'];
                  $diterimaRS += @$d['data']['rujukan'][3]['Rumah Sakit'];
                  $pasienRujukan += @$d['data']['rujukan'][2]['Dokter Praktek'] + @$d['data']['rujukan'][4]['Bidan'] + @$d['data']['rujukan'][5]['Balai Pengobatan'] + @$d['data']['rujukan'][6]['null'];
                  $pasienSendiri += @$d['data']['rujukan'][0]['Datang Sendiri'];
              @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d['poli'] }}</td>
                  <td>{{ @$d['data']['rujukan'][1]['Puskesmas'] }}</td>
                  <td>{{ @$d['data']['rujukan'][2]['Dokter Praktek'] + @$d['data']['rujukan'][4]['Bidan'] + @$d['data']['rujukan'][5]['Balai Pengobatan'] + @$d['data']['rujukan'][6]['null'] }}</td>
                  <td>{{ @$d['data']['rujukan'][3]['Rumah Sakit'] }}</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>{{ @$d['data']['rujukan'][2]['Dokter Praktek'] + @$d['data']['rujukan'][4]['Bidan'] + @$d['data']['rujukan'][5]['Balai Pengobatan'] + @$d['data']['rujukan'][6]['null'] }}</td>
                  <td>{{ @$d['data']['rujukan'][0]['Datang Sendiri'] }}</td>
                  <td>0</td>
                </tr>
              @endforeach
              <tr>
                <th>###</th>
                <th>Total</th>
                <th>{{ $diterimaPuskesmas }}</th>
                <th>{{ $diterimaFaskes }}</th>
                <th>{{ $diterimaRS }}</th>
                <th>{{ 0 }}</th>
                <th>{{ 0 }}</th>
                <th>{{ 0 }}</th>
                <th>{{ $pasienRujukan }}</th>
                <th>{{ $pasienSendiri }}</th>
                <th>{{ 0 }}</th>
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