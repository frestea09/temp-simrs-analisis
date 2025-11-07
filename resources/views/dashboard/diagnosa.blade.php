@extends('dashboard.template')
@section('header')
		<h1 style="font-size: 16pt;"> Dashboard Pelayanan {{ config('app.nama') }} Tanggal {{ tanggalkuitansi(date('d-m-Y')) }}</h1>
@endsection
@section('content')

  <div class="row">
    <div class="col-md-12">
      {!! Form::open(['method' => 'POST', 'url' => 'diagnosa', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker text-center', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-1 text-center">s/d</div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker text-center', 'required' => 'required']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
        </div>
      </div>
      {!! Form::close() !!}
      <p class="small text-info">Data di bawah adalah data terbaru bulan ini. Jika ingin mengganti tanggal silakan ganti tanggal di form di atas!</p>
    </div>
  </div>

  {{-- Kunjungan Poli --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">
            10 Besar Diagnosa Rawat Jalan &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>ICD10</th>
                <th>Diagnosa</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($irj as $key => $d)
                <tr>
                  <td class="text-center">{{ $no_irj++ }}</td>
                  <td>{{ $d->diagnosa }}</td>
                  <td>{{ baca_icd10($d->diagnosa) }}</td>
                  <td class="text-center">{{ $d->jumlah }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            10 Besar Diagnosa Rawat Inap  &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>ICD10</th>
                <th>Diagnosa</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($irna as $key => $d)
                <tr>
                  <td class="text-center">{{ $no_irna++ }}</td>
                  <td>{{ $d->diagnosa }}</td>
                  <td>{{ baca_icd10($d->diagnosa) }}</td>
                  <td class="text-center">{{ $d->jumlah }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
            
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    
  </script>
@endsection