@extends('master')
@section('header')
  <h1>Laporan Evaluasi EMR Dokter </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/laporan-evaluasi-emr-dokter', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Poli</button>
            </span>
              {!! Form::select('poli', $poli,null, ['class' => 'form-control select2','placeholder'=>'Pilih salah satu']) !!}
          </div>
        </div>
        {{-- <div class="col-md-4">
          <br/>
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" id="" type="button">Dokter</button>
            </span>
              {!! Form::select('dokter', $dokter,null, ['class' => 'form-control select2','placeholder'=>'Pilih salah satu']) !!}
          </div>
        </div> --}}

        <div class="col-md-4">
          <br/>
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
        
      </div>
      <br/>
        
      </div>
      {!! Form::close() !!}
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Jumlah Kunjungan</th>
                <th>EMR Terisi Lengkap</th>
                <th>EMR Belum Lengkap</th>
                <th>Kesimpulan</th>
              </tr>
            </thead>
            <tbody>
                @foreach($dataEvaluasi as $dokter => $item)
                  @php
                    $nomor = $loop->iteration;
                  @endphp
                  @foreach ($item as $key => $regis)
                    @if ($key == 0)
                      <tr>
                        <td rowspan="{{count($item)}}">{{ @$nomor }}</td>
                        <td rowspan="{{count($item)}}">{{ @$regis['namaDokter'] }}</td>
                        <td>{{ @$regis['poli'] }}</td>
                        <td>{{ @$regis['totalKunjungan'] }}</td>
                        <td>{{ @$regis['emrTerisi'] }}</td>
                        <td>{{ @$regis['emrBelum'] }}</td>
                        <td>{{ @$regis['kesimpulan'] .'%' }}</td>
                      </tr>
                    @else
                      <tr>
                        <td>{{ @$regis['poli'] }}</td>
                        <td>{{ @$regis['totalKunjungan'] }}</td>
                        <td>{{ @$regis['emrTerisi'] }}</td>
                        <td>{{ @$regis['emrBelum'] }}</td>
                        <td>{{ @$regis['kesimpulan'] .'%' }}</td>
                      </tr>
                    @endif
                  @endforeach
                @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="6">
                  *Data kelengkapan pengisian diambil dari data Resume yang terisi dan diperoleh dari asesmen awal ( untuk pasien baru )
                   dan CPPT ( untuk pasien lama). data pengisian e-resep tidak dapat dijadikan standar kelengkapan EMR dikarenakan e-resep bersifat situsional
                </td>
              </tr>
              <tr>
                <td colspan="6">
                  *Dikarenakan pada periode maret-mei TTE belum dapat digunakan secara optimal karena beberapa faktor, 
                  maka hasil laporan diambil dari data pengisian tanpa TTE sebagai standar data yang lengkap terisi.
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
    </div>
  </div>

@endsection

@section('script')
  <script>
        $('.select2').select2();
  </script>
@endsection