@extends('master')
@section('header')
  <h1>Laporan USG</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/usg', 'class'=>'form-hosizontal']) !!}
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
          <th rowspan="3" class="text-center">Poli</th>
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
                  $total_kontraktor = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                                      ->where('registrasis.poli_id', $d->id)
                                      ->where('registrasis.status_reg', 'like', 'J%')
                                      ->where('registrasis.tipe_jkn', '!=','PBI')
                                      ->where('registrasis.tipe_jkn', '!=','PNS')
                                      ->where('registrasis.tipe_jkn', '!=','SWASTA')
                                      ->where('registrasis.tipe_jkn', '!=','MANDIRI')
                                      ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                  $total_kontraktor_baru = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                                      ->where('registrasis.poli_id', $d->id)
                                      ->where('registrasis.status_reg', 'like', 'J%')
                                      ->where('registrasis.status', 'baru')
                                      ->where('registrasis.tipe_jkn', '!=','PBI')
                                      ->where('registrasis.tipe_jkn', '!=','PNS')
                                      ->where('registrasis.tipe_jkn', '!=','SWASTA')
                                      ->where('registrasis.tipe_jkn', '!=','MANDIRI')
                                      ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                  $total_kontraktor_lama = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                                      ->where('registrasis.poli_id', $d->id)
                                      ->where('registrasis.status', 'lama')
                                      ->where('registrasis.status_reg', 'like', 'J%')
                                      ->where('registrasis.tipe_jkn', '!=','PBI')
                                      ->where('registrasis.tipe_jkn', '!=','PNS')
                                      ->where('registrasis.tipe_jkn', '!=','SWASTA')
                                      ->where('registrasis.tipe_jkn', '!=','MANDIRI')
                                      ->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();


                  $umum                = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();                     
                  $umum_baru           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();                             
                  $umum_lama           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.bayar', 2)->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();                             

                  $pbi                = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $pbi_lama           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $pbi_baru           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PBI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                  $pns                = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $pns_lama           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $pns_baru           = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'PNS')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                  $swasta              = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $swasta_lama         = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $swasta_baru         = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'SWASTA')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();

                  $mandiri              = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $mandiri_lama         = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'baru')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
                  $mandiri_baru         = Modules\Registrasi\Entities\Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')->where('registrasis.status', 'lama')->where('registrasis.tipe_jkn', 'MANDIRI')->where('registrasis.poli_id', $d->id)->where('registrasis.status_reg', 'like', 'J%')->where('namatarif', 'like', '%usg%')->whereBetween('folios.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count();
        
               @endphp
              <tr>
              <td>{{ $no++ }}</td>
              <td class="text-center">{{baca_poli($d->id)}}</td>
              <td class="text-center">{{ $umum }}</td>
              <td class="text-center">{{ $pbi }}</td>
              <td class="text-center">{{ $pns }}</td>
              <td class="text-center">{{ $swasta }}</td>
              <td class="text-center">{{ $mandiri }}</td>
              <td class="text-center">{{ $total_kontraktor }}</td>
              <td class="text-center">{{ @$total_kontraktor_lama+@$umum_lama+@$pbi_lama+@$pns_lama+$swasta_lama+$mandiri_lama }}</td>
              <td class="text-center">{{  @$total_kontraktor_baru+@$umum_baru+@$pbi_baru+@$pns_baru+$swasta_baru+$mandiri_baru }}</td>
              <td class="text-center">{{  @$total_kontraktor_lama+@$umum_lama+@$pbi_lama+@$pns_lama+$swasta_lama+$mandiri_lama+@$total_kontraktor_baru+@$umum_baru+@$pbi_baru+@$pns_baru+$swasta_baru+$mandiri_baru}}</td>
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
