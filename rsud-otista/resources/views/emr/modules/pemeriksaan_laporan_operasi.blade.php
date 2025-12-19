@extends('master')
@section('header')
<h1>{{baca_unit($unit)}} - Laporan Operasi <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Laporan Operasi</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
        </div>
      </div> 
      <div class='table-responsive' style="margin-top: 2rem;">
        <div><b>Laporan Operasi</b></div>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Registrasi</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($laporan as $p)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->registrasi->created_at)) }}</td>
                    <td>
                        <a href="{{ url('emr/pemeriksaan-laporan-operasi/cetak/'.$unit.'/'.$reg->id.'/'.$p->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
          </tbody>        
        </table>
      </div>
      <div class='table-responsive' style="margin-top: 2rem;">
        <div><b>Laporan Operasi Ranap</b></div><br>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Registrasi</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($laporan_ranap as $p)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->registrasi->created_at)) }}</td>
                    <td>
                        <a href="{{ url('emr/pemeriksaan-laporan-operasi/cetak/'.$unit.'/'.$reg->id.'/'.$p->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
          </tbody>        
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')

@endsection
