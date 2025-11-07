@extends('master')
@section('header')
  <h1>RL 5.4 Laporan 10 Besar Diagnosa IRJ </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '10-besar-diagnosa-irj-baru', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
          </div>
          <small class="text-info"><i>Isi 0 jika ingin melihat semua</i></small>
        </div>
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
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
                <th class="text-center" rowspan="2" valign="top">No</th>
                <th class="text-center" rowspan="2" valign="top">Kode ICD</th>
                <th class="text-center" rowspan="2" valign="top">Golongan Sebab Penyakit</th>
                <th class="text-center" colspan="2" valign="top">Pasien Baru Menurut Jenis Kelamin</th>
                <th class="text-center" rowspan="2" valign="top">Jumlah Kasus Baru</th>
                <th class="text-center" rowspan="2" valign="top">Jumlah Kunjungan</th>
              </tr>
              <tr>
                {{-- <th></th>
                <th></th>
                <th></th>
                <th></th> --}}
                <th class="text-center">Laki</th>
                <th class="text-center">Perempuan</th>
                {{-- <th></th>
                <th></th> --}}
              </tr>
            </thead>
            <tbody>
              @if ( isset($irj) )
              @foreach ($irj as $key => $d)
                @php
                    $registrasi_id = explode('||',$d->registrasi_id);
                    $dtd = \App\PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')
                                            // ->join('sirrsl_icd10s', 'icd10s.kategori_nomor', '=', 'sirrsl_icd10s.id')
                                            ->where('perawatan_icd10s.icd10', $d->diagnosa)
                                            ->first();
                    $kasus_baru = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->where('perawatan_icd10s.kasus', 'Baru')
                    ->whereIn('registrasis.id', $registrasi_id)
                    // ->where('perawatan_icd10s.status', 'baru')
                    ->count();

                    $kasus_lama = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->where('perawatan_icd10s.kasus', 'Lama')
                    ->whereIn('registrasis.id', $registrasi_id)
                    // ->where('perawatan_icd10s.status', 'baru')
                    ->count();


                    $laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('perawatan_icd10s.kasus', ['Baru', 'Lama'])
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'L')
                    // ->where('perawatan_icd10s.status', 'baru')
                    ->count();
                    $perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('perawatan_icd10s.kasus', ['Baru', 'Lama'])
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'P')
                    // ->where('perawatan_icd10s.status', 'baru')
                    ->count();
                @endphp
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ isset($dtd->dtd) ? $dtd->dtd : $d->diagnosa }}</td>
                  <td>{{ isset($dtd->nama) ? $dtd->nama : baca_icd10($d->diagnosa) }}</td>
                  <td>{{ $laki_laki }}</td>
                  <td>{{ $perempuan }}</td>
                  <td>{{ $laki_laki + $perempuan }}</td>
                  <td>{{ $kasus_baru + $kasus_lama }}</td>
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection
