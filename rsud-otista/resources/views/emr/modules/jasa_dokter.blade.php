@extends('master')

@section('header')
<h1>JASA DOKTER</h1>
@endsection
<style>
  .new {
    background-color: #e4ffe4;
  }
</style>
@section('content')
@php

$poli = request()->get('poli');
$dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    @include('emr.modules.addons.profile')
    <div class="row">
      <div class="col-md-12">
        @include('emr.modules.addons.tabs')
      </div>
    </div>
    <br/>
    <form action="{{ url('emr-jasa-dokter/'.$unit.'/'.$reg->id.'?poli='.$poli.'&dpjp='.$dpjp) }}" class="form-horizontal" role="form" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="reg_id" value="{{$reg->id}}">
      <input type="hidden" name="unit" value="{{$unit}}">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="dokter" class="col-sm-3 control-label">Dokter</label>
            <div class="col-sm-9">
              <select name="dokter" class="form-control" readonly style="width: 100%">
                <option value="{{$dpjp}}">{{baca_dokter($dpjp)}}</option>
              </select>
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="depo" class="col-sm-3 control-label">Bayar</label>
            <div class="col-sm-9">
              
            </div>
          </div> --}}
        </div>
        {{--  --}}
        <div class="col-sm-6">
          
          <div class="form-group">
            <label for="periode" class="col-sm-3 control-label">Periode</label>
            <div class="col-sm-4 {{ $errors->has('tglAwal') ? 'has-error' :'' }}">
              <input type="text" name="tglAwal" autocomplete="off" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker">
            </div>
            <div class="col-sm-1 text-center">
              s/d
            </div>
            <div class="col-sm-4 {{ $errors->has('tglAkhir') ? 'has-error' :'' }}">
              <input type="text" name="tglAkhir" autocomplete="off" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
              <button type="submit" name="submit" value="lanjut" class="btn btn-primary btn-flat">VIEW</button>
              <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat">EXCEL</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
          {{-- <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed"> --}}
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
               {{-- <thead class="bg-primary"> --}}
                <tr>
                  <th style="vertical-align: middle;" class="text-center">No</th>
                  <th style="vertical-align: middle;" class="text-center">Nama</th>
                  <th style="vertical-align: middle;" class="text-center">No. RM</th>
                  <th style="vertical-align: middle;" class="text-center">Baru / Lama</th>
                  <th style="vertical-align: middle;" class="text-center">JK</th>
                  <th style="vertical-align: middle;" class="text-center">Ruang/Poli</th>
                  <th style="vertical-align: middle;" class="text-center">Cara Bayar</th>
                  <th style="vertical-align: middle;" class="text-center">Tanggal</th>
                  {{-- <th style="vertical-align: middle;" class="text-center">Dokter</th> --}}
                  <th style="vertical-align: middle;" class="text-center">Tindakan</th>
                  <th style="vertical-align: middle;" class="text-center">Tarif</th>
                </tr>
              </thead>
              <tbody>
                @if (isset($data) && !empty($data))
                  @foreach ($data as $no => $d)
                    @php
                      $reg = \Modules\Registrasi\Entities\Registrasi::select('poli_id','status_reg')->where('id', $d->registrasi_id)->first();
                      $irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
                      $pasien = \Modules\Pasien\Entities\Pasien::select('nama', 'no_rm', 'kelamin')->where('id', $d->pasien_id)->first();
                      $detail = \App\Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();
                    @endphp
                    <tr>
                      <td class="text-center">{{ ++$no }}</td>
                      <td>{{ @$pasien->nama }}</td>
                      <td>{{ @$pasien->no_rm }}</td>
                      <td>
                        @if ($d->jenis_pasien == '1')
                          Baru
                        @else
                          Lama
                        @endif
                      </td>
                      <td>{{ @$pasien->kelamin }}</td>
                      <td>
                        @if(substr($reg->status_reg, 0, 1) == 'G' || substr($reg->status_reg, 0, 1) == 'I')
                        {{ $irna ? baca_kamar($irna->kamar_id) : NULL }}
                        @else
                        {{ baca_poli($reg->poli_id) }}
                        @endif
                      </td>
                      <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                      <td>{{ $d->created_at->format('d-m-Y') }}</td>
                      {{-- <td>{{ baca_dokter($d->dokter_id) }}</td> --}}
                      <td>
                        {{$d->namatarif}}
                      </td>
                      <td class="text-right">{{ number_format($d->total) }}</td>
                    </tr>
                  @endforeach
                @endif

              </tbody>
              <tfoot>
                <tr>
                  <th colspan="9" class="text-right">Total Tarif</th>
                  <th class="text-right">{{ isset($data) && !empty($data) ? number_format($data->sum('total')) : NULL }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

    $(".skin-red").addClass( "sidebar-collapse" );
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      // alert(target);
    });
    $('.select2').select2();
    $("#date_tanpa_tanggal").datepicker( {
        format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    }); 
 
</script>
@endsection