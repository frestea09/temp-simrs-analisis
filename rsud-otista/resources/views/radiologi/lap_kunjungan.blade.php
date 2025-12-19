@extends('master')
@section('header')
  <h1>Radiologi - Laporan Kunjungan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/radiologi/laporan-kunjungan', 'class' => 'form-horizontal']) !!}

        <div class="row">
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('politipe') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('politipe') ? ' has-error' : '' }}" type="button">Layanan</button>
              </span>
              {!! Form::select('pasien_asal', ['TA'=>'Rawat Jalan', 'TG'=>'Rawat Darurat', 'TI'=>'Rawat Inap'], 'TA', ['class' => 'chosen-select datepicker']) !!}
              <small class="text-danger">{{ $errors->first('politipe') }}</small>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <div class="btn-group">
            {{-- <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW"> --}}
            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
          </div>
        </div>
        </div>

      {!! Form::close() !!}
      <hr>
      @isset($kunjungan)
        <h4 class="text-primary" style="margin-bottom: -10px">Total Pengunjung: {{ $kunjungan->count() }}</h4>
        <div class='table-responsive'>
          <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. RM</th>
                <th>Umur</th>
                {{-- @if ($pasien_asal == 'TI')
                  <th>Kamar</th>
                @else --}}
                  <th>Asal</th>
                {{-- @endif --}}
                <th>Dokter</th>
                {{-- <th>Status</th> --}}
                <th>Waktu Kunjungan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kunjungan as $key => $d)
                  @php
                    // $reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
                    // $pasien = Modules\Pasien\Entities\Pasien::find(@$d->pasien_id);
                  @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->registrasi->pasien->nama }}</td>
                  <td>{{ @$d->registrasi->pasien->no_rm }}</td>
                  <td>{{ @$d->registrasi->pasien ? hitung_umur(@$d->registrasi->pasien->tgllahir) : NULL }}</td>
                  <td>{{@cek_jenis_reg($d->registrasi->status_reg)}}</td>
                  {{-- @if ($pasien_asal == 'TI')
                    <td>{{ baca_kamar(App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first()->kamar_id) }}</td>
                  @else --}}
                  {{-- <td>{{ @$pasien->alamat }}</td> --}}
                  {{-- @endif --}}
                  <td>{{ baca_user($d->user_id) }}</td>
                  {{-- <td>{{ $d->status }}</td> --}}
                  <td>{{ tanggal($d->created_at) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endisset

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    

  </script>
@endsection
