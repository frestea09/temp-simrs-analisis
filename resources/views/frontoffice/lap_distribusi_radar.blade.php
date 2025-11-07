@extends('master')
@section('header')
  <h1>Laporan Distribusi Rawat Darurat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/distribusi-radar', 'class'=>'form-hosizontal']) !!}
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
          <th rowspan="3" class="text-center">POLI</th>
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
          @if ( isset($poli) )
           
            @foreach ($poli as $d)
              @php
                  $total_kontraktor = Modules\Registrasi\Entities\Registrasi::where('bayar', 1)
                                      ->where('poli_id', $d->id)
                                      ->where('status_reg', 'like', 'G%')
                                      ->where('tipe_jkn', '!=','PBI')
                                      ->where('tipe_jkn', '!=','PNS')
                                      ->where('tipe_jkn', '!=','SWASTA')
                                      ->where('tipe_jkn', '!=','MANDIRI')
                                      ->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count()
              @endphp
              <tr>
              <td>{{ $no++ }}</td>
              <td class="text-center">{{baca_poli($d->id)}}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 2)->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn', 'PBI')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn', 'PNS')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn', 'SWASTA')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn', 'MANDIRI')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ $total_kontraktor }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('status', 'lama')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('status', 'baru')->where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('poli_id', $d->id)->where('status_reg', 'like', 'G%')->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
            </tr>
            @endforeach
          @endif
          </tbody>
        </table>
      </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection
