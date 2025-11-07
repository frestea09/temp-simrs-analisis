@extends('master')
@section('header')
<h1>{{baca_unit($unit)}} - Pemeriksaan Laboratorium Patalogi Anatomi <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pemeriksaan Laboratorium Patalogi Anatomi</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </div>
      </div> 
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>No Lab</th>
              <th>Tanggal</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($labPa as $p)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $p->no_lab }}</td>
              <td>{{ date('d-m-Y',strtotime($p->created_at)) }}</td>
              <td>
              <a href="{{ url("pemeriksaanlabCommon/cetak/".$reg->id."/".$p->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument }} </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
