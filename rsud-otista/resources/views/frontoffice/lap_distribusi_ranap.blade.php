@extends('master')
@section('header')
  <h1>Laporan Distribusi Ranap </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/distribusi-ranap', 'class'=>'form-hosizontal']) !!}
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
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
          <tr>
            <th rowspan="3" class="text-center">No</th>
            <th rowspan="3" class="text-center">RUANGAN</th>
            <th colspan="6" class="text-center">Jumlah Pasien Per Status Bayar</th>
            <th colspan="3" rowspan="2" class="text-center">Jumlah Pasien Per Status</th>
          </tr>
          <tr>
            <th rowspan="2" class="text-center">Bayar Sendiri (Umum)</th>
            <th colspan="4" class="text-center">KONTRAK</th>
            <th rowspan="2" class="text-center">KONTRAKTOR</th>
          </tr>
          <tr>
            <th class="text-center">BPJS PBI</th>
            <th class="text-center">BPJS PNS</th>
            <th class="text-center">BPJS SWASTA</th>
            <th class="text-center">BPJS MANDIRI</th>
            <th class="text-center" rowspan="2">LAMA</th>
            <th class="text-center" rowspan="2">BARU</th>
            <th class="text-center" rowspan="2">TOTAL</th>
          </tr>
         
          </thead>
          <tbody>
            @if ( isset($kelompok) )
             
              @foreach ($kelompok as $d)
                @php
                    $total_kontraktor = App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')
                                        ->where('registrasis.bayar', 1)
                                        ->where('rawatinaps.kelompokkelas_id', $d->id)
                                        ->where('registrasis.tipe_jkn', '!=','PBI')
                                        ->where('registrasis.tipe_jkn', '!=','PNS')
                                        ->where('registrasis.tipe_jkn', '!=','SWASTA')
                                        ->where('registrasis.tipe_jkn', '!=','MANDIRI')
                                        ->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count()
                @endphp
                <tr>
                <td>{{ $no++ }}</td>
                <td class="text-center">{{baca_kelompok($d->id)}}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 2)->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'PBI')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'PNS')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'SWASTA')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'MANDIRI')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ $total_kontraktor }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.status', 'lama')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.status', 'baru')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
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
