@extends('master')
@section('header')
  <h1>Laporan DBD </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/laporan-db', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <br/>
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="TAMPILKAN">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
        </div>
        
      </div>
      <br/>
      {{-- <div class="row">
        
      </div> --}}
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
      @if ( isset($dbd) )
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>RM</th>
                <th>NIK</th>
                <th>Dokter</th>
                <th>Kasus</th>
                <th>Rujuk Ke</th>
                <th>Tgl. Registrasi</th>
                <th>ICD 9</th>
                <th>ICD 10</th>
                <th>Keterangan</th>
                <th>Asuransi</th>
                <th>Alamat</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dbd as $key => $d)
              @php
              $icd9 = App\PerawatanIcd9::where('registrasi_id', $d->reg_id)->first();
              $pasien = Modules\Registrasi\Entities\Registrasi::where('pasien_id',$d->pasien_id)->count();
              @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_pasien($d->pasien_id) }}</td>
                  <td>{{ $d->no_rm}}</td>
                  <td>{{ $d->nik}}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>

                    @if ($pasien > 1)
                        <p>Lama</p>
                    @else
                        <p>Baru</p>    
                    @endif

                </td>
                  <td>{{ baca_rujukan(@$d->rujukkan) }}</td>
                  <td>{{ Carbon\Carbon::parse(@$d->tgl_regis)->format('d-m-Y') }}</td>
                  <td>{{ baca_icd9(@$icd9->icd9) }}</td>
                  <td>{{ baca_icd10(@$d->icd10) }}</td>
                  <td>{{ @$d->keterangan }}</td>
                  <td>{{ @$d->tipe_jkn }}</td>
                  <td>{{ @$d->alamat }}</td>
                  <td>{{ baca_propinsi(@$d->province_id) }}</td>
                  <td>{{ baca_kabupaten(@$d->regency_id) }}</td>
                  <td>{{ baca_kecamatan(@$d->district_id) }}</td>
                  <td>{{ baca_kelurahan(@$d->village_id) }}</td>
                </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      @endif


    </div>
  </div>
@endsection