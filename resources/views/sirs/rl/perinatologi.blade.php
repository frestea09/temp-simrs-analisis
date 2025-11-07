@extends('master')
@section('header')
  <h1>Perinatologi - RL 3.5</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Periode</h3>
  </div>
  <div class="box-body">
  {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/perinatologi', 'class'=>'form-horizontal']) !!}
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
        @if(isset($result_perinatologi))
          @php
            $totRumahSakit = 0;
            $totBidan = 0;
            $totPuskesmas = 0;
            $totFaskes = 0;
            $totJmlMatiRujMedis = 0;
            $totMatiRujMedis = 0;
            $totJmlMatiRujNonMedis = 0;
            $totMatiRujNonMedis = 0;
            $totJmlMatiNonRuj = 0;
            $totMatiNonRuj = 0;
            $totDirujuk = 0;
          @endphp
          @foreach($result_perinatologi as $item)
            @php
              $totRumahSakit += $item['rujukan'][3]['Rumah Sakit perinatologi_hidup']+$item['rujukan'][3]['Rumah Sakit perinatologi_mati']+$item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'];
              $totBidan += $item['rujukan'][2]['Dokter Praktek perinatologi_hidup']+$item['rujukan'][2]['Dokter Praktek perinatologi_mati']+$item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'];
              $totPuskesmas += $item['rujukan'][1]['Puskesmas perinatologi_hidup']+$item['rujukan'][1]['Puskesmas perinatologi_mati']+$item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'];
              $totFaskes += $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][4]['Bidan perinatologi_hidup'] + $item['rujukan'][6]['null perinatologi_hidup'] + $item['rujukan'][0]['Datang Sendiri perinatologi_hidup'] + $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati'] + $item['rujukan'][5]['Balai Pengobatan perinatologi_sebab_mati'];
              $totJmlMatiRujMedis += ($item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati']) - $item['rujukan'][0]['dirujuk perinatologi_mati'] + ($item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati']) - $item['rujukan'][0]['dirujuk perinatologi_sebab_mati'];
              $totMatiRujMedis += ($item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati']) - $item['rujukan'][0]['dirujuk perinatologi_mati'] + ($item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati']) - $item['rujukan'][0]['dirujuk perinatologi_sebab_mati']+($item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][4]['Bidan perinatologi_hidup'] + $item['rujukan'][6]['null perinatologi_hidup'] + $item['rujukan'][1]['Puskesmas perinatologi_hidup'] + $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][3]['Rumah Sakit perinatologi_hidup'] + + $item['rujukan'][0]['Datang Sendiri perinatologi_hidup']) - $item['rujukan'][0]['dirujuk perinatologi_hidup'];
              $totJmlMatiRujNonMedis += 0;
              $totMatiRujNonMedis += 0;
              $totJmlMatiNonRuj += 0;
              $totMatiNonRuj += 0;
              $totDirujuk += $item['rujukan'][0]['dirujuk perinatologi_hidup'] + $item['rujukan'][0]['dirujuk perinatologi_mati'] + $item['rujukan'][0]['dirujuk perinatologi_sebab_mati'];
            @endphp
            <tr style="{{ ($item['parent']==null) ? 'background-color:#c5ecff;' : '' }}">
              <td>{{ $item['no'] }}</td>
              <td>{{ $item['nama'] }}</td>
              <td> <!-- Rujukan RS Lain -->
                @if( $item['parent'] == 1 )
                  {{ $item['rujukan'][3]['Rumah Sakit perinatologi_hidup'] }}
                @elseif( $item['parent'] == 4 )
                  {{ $item['rujukan'][3]['Rumah Sakit perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ $item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td>  <!-- Dokter Praktek -->
                @if( $item['parent'] == 1 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] }}
                @elseif( $item['parent'] == 4 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td>  <!-- Rujukan Puskesmas -->
                @if( $item['parent'] == 1 )
                  {{ $item['rujukan'][1]['Puskesmas perinatologi_hidup'] }}
                @elseif( $item['parent'] == 4 )
                  {{ $item['rujukan'][1]['Puskesmas perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ $item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td>  <!-- Faskes Lainnya -->
                @if( $item['parent'] == 1 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][4]['Bidan perinatologi_hidup'] + $item['rujukan'][6]['null perinatologi_hidup'] + $item['rujukan'][0]['Datang Sendiri perinatologi_hidup'] }}
                @elseif( $item['parent'] == 4 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td>  <!-- Jml Mati Rujukan Medis -->
                @if( $item['parent'] == 1 )
                  {{-- {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][4]['Bidan perinatologi_hidup'] + $item['rujukan'][6]['null perinatologi_hidup'] + $item['rujukan'][1]['Puskesmas perinatologi_hidup'] + $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan']34]['Rumah SakitS Lain perinatologi_hidup'] + + $item['rujukan'][0]['Datang Sendiri perinatologi_hidup']) - $item['rujukan'][0]['dirujuk perinatologi_hidup'] }} --}} {{ 0 }}
                @elseif( $item['parent'] == 4 )
                  {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati']) - $item['rujukan'][0]['dirujuk perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati']) - $item['rujukan'][0]['dirujuk perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td> <!-- Jml Total Rujukan Medis -->
                @if( $item['parent'] == 1 )
                  {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][4]['Bidan perinatologi_hidup'] + $item['rujukan'][6]['null perinatologi_hidup'] + $item['rujukan'][1]['Puskesmas perinatologi_hidup'] + $item['rujukan'][2]['Dokter Praktek perinatologi_hidup'] + $item['rujukan'][3]['Rumah Sakit perinatologi_hidup'] + + $item['rujukan'][0]['Datang Sendiri perinatologi_hidup']) - $item['rujukan'][0]['dirujuk perinatologi_hidup'] }} 
                @elseif( $item['parent'] == 4 )
                  {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][4]['Bidan perinatologi_mati'] + $item['rujukan'][6]['null perinatologi_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_mati']) - $item['rujukan'][0]['dirujuk perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ ($item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][4]['Bidan perinatologi_sebab_mati'] + $item['rujukan'][6]['null perinatologi_sebab_mati'] + $item['rujukan'][1]['Puskesmas perinatologi_sebab_mati'] + $item['rujukan'][2]['Dokter Praktek perinatologi_sebab_mati'] + $item['rujukan'][3]['Rumah Sakit perinatologi_sebab_mati'] + $item['rujukan'][0]['Datang Sendiri perinatologi_sebab_mati']) - $item['rujukan'][0]['dirujuk perinatologi_sebab_mati'] }}
                @endif
              </td>
              <td> <!-- Jml Mati Rujukan Non Medis -->
                @if( $item['parent'] == 1 )
                  {{ 0 }}
                @elseif( $item['parent'] == 4 )
                  {{ 0 }}
                @elseif( $item['parent'] == 7 )
                  {{ 0 }}
                @endif
              </td>
              <td> <!-- Jml Total Rujukan Non Medis -->
                @if( $item['parent'] == 1 )
                  {{ 0 }}
                @elseif( $item['parent'] == 4 )
                  {{ 0 }}
                @elseif( $item['parent'] == 7 )
                  {{ 0 }}
                @endif
              </td>
              <td> <!-- Jml Mati Non Rujukan -->
                @if( $item['parent'] == 1 )
                  {{ 0 }}
                @elseif( $item['parent'] == 4 )
                  {{ 0 }}
                @elseif( $item['parent'] == 7 )
                  {{ 0 }}
                @endif
              </td>
              <td> <!-- Jml Total Non Rujukan -->
                @if( $item['parent'] == 1 )
                  {{ 0 }}
                @elseif( $item['parent'] == 4 )
                  {{ 0 }}
                @elseif( $item['parent'] == 7 )
                  {{ 0 }}
                @endif
              </td>
              <td> <!-- Jml Dirujuk -->
                @if( $item['parent'] == 1 )
                  {{ $item['rujukan'][0]['dirujuk perinatologi_hidup'] }}
                @elseif( $item['parent'] == 4 )
                  {{ $item['rujukan'][0]['dirujuk perinatologi_mati'] }}
                @elseif( $item['parent'] == 7 )
                  {{ $item['rujukan'][0]['dirujuk perinatologi_sebab_mati'] }}
                @endif
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
            <th>{{ $totMatiRujMedis }}</th>
            <th>{{ $totJmlMatiRujNonMedis }}</th>
            <th>{{ $totMatiRujNonMedis }}</th>
            <th>{{ $totJmlMatiNonRuj }}</th>
            <th>{{ $totMatiNonRuj }}</th>
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