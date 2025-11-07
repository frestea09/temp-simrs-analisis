@extends('master')
@section('header')
  <h1>Penyakit Rawat Jalan (sebab luar) - RL 4B</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Periode</h3>
  </div>
  <div class="box-body">
  {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/penyakit-rawat-jalan-sebab-luar', 'class'=>'form-horizontal']) !!}
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
          <th class="text-center">No</th>
          <th class="text-center">DTD</th>
          <th class="text-center">TERPERINCI</th>
          <th class="text-center">Nama</th>
          <th class="text-center">6hr L</th>
          <th class="text-center">6hr P</th>
          <th class="text-center">6-28hr L</th>
          <th class="text-center">6-28hr P</th>
          <th class="text-center">28hr-1th L</th>
          <th class="text-center">28hr-1th P</th>
          <th class="text-center">1-4th L</th>
          <th class="text-center">1-4th P</th>
          <th class="text-center">4-14th L</th>
          <th class="text-center">4-14th P</th>
          <th class="text-center">14-24th L</th>
          <th class="text-center">14-24th P</th>
          <th class="text-center">24-44th L</th>
          <th class="text-center">24-44th P</th>
          <th class="text-center">44-64th L</th>
          <th class="text-center">44-64th P</th>
          <th class="text-center">>64th L</th>
          <th class="text-center">>64th P</th>
          {{-- <th class="text-center">L</th>
          <th class="text-center">P</th> --}}
          <th class="text-center">KB L</th>
          <th class="text-center">KB P</th>
          <th class="text-center">Jml KB</th>
          <th class="text-center">KJ</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($p_icd10 as $i)
          @php 
            $kelamin    = explode('||',$i['gender']);
            $pasien_id    = explode('||',$i['pasien_id']);
            $gender     = array_count_values($kelamin);
            $range      = getRange($i['lahir'], $i['gender']);
            $kejadianBaru = array_filter(explode('||', $i['pasien']));
            $KBL = 0;
						$KBP = 0;
              foreach( $kejadianBaru as $val ){
                if( stripos($val,'L') ){
                  $KBL += 1;
                }else{
                  $KBP += 1;
                }
            	}
          // $same_pasien = '';
          // foreach($pasien_id as $val){
          //   if( $val != $same_pasien ){

          //   }
          // }
            
          @endphp
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $i['dtd'] }}</td>
            <td>{{ $i['daftar'] }}</td>
            <td>{{ $i['nama'] }}</td>
            <td class="text-center">{{ $range[0] }}</td>
            <td class="text-center">{{ $range[1] }}</td>
            <td class="text-center">{{ $range[2] }}</td>
            <td class="text-center">{{ $range[3] }}</td>
            <td class="text-center">{{ $range[4] }}</td>
            <td class="text-center">{{ $range[5] }}</td>
            <td class="text-center">{{ $range[6] }}</td>
            <td class="text-center">{{ $range[7] }}</td>
            <td class="text-center">{{ $range[8] }}</td>
            <td class="text-center">{{ $range[9] }}</td>
            <td class="text-center">{{ $range[10] }}</td>
            <td class="text-center">{{ $range[11] }}</td>
            <td class="text-center">{{ $range[12] }}</td>
            <td class="text-center">{{ $range[13] }}</td>
            <td class="text-center">{{ $range[14] }}</td>
            <td class="text-center">{{ $range[15] }}</td>
            <td class="text-center">{{ $range[16] }}</td>
            <td class="text-center">{{ $range[17] }}</td>
            {{-- <td class="text-center">{{ (isset($gender['L'])) ? $gender['L'] : 0 }}</td>
            <td class="text-center">{{ (isset($gender['P'])) ? $gender['P'] : 0 }}</td> --}}
            <td class="text-center">{{ $i['kb_cwo'] }}</td>
            <td class="text-center">{{ $i['kb_cwe'] }}</td>
            <td class="text-center">{{ $i['kb'] }}</td>
            <td class="text-center">{{ ($KBL+$KBP) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable({
            searching   : true,
            ordering    : true,
        })
        $('.datepicker').datepicker();
    });
  </script>
@endsection