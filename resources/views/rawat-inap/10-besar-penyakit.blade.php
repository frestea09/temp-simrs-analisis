@extends('master')
@section('header')
  <h1>Laporan Daftar 10 Besar Penyakit Rawat Inap</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/laporan-10-besar-penyakit', 'class'=>'form-hosizontal']) !!}
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
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      {{-- ================================================================================================== --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle; width: 5%;" valign="middle">No</th>
                {{-- <th class="text-center" style="vertical-align: middle;">Bulan</th>
                <th class="text-center" style="vertical-align: middle;">Tahun</th> --}}
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">ICD</th>
                <th class="text-center" style="vertical-align: middle; width: 35%;" valign="middle">Diagnosa</th>
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">Pasien Keluar Hidup Menurut Jenis Kalamin (LK)</th>
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">Pasien Keluar Hidup Menurut Jenis Kalamin (PR)</th>
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">Pasien Keluar Mati Menurut Jenis Kalamin (LK)</th>
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">Pasien Keluar Mati Menurut Jenis Kalamin (PR)</th>
                {{-- <th class="text-center" style="vertical-align: middle; width: 5%;">Total Hidup & Mati</th> --}}
                <th class="text-center" style="vertical-align: middle; width: 10%;" valign="middle">Total</th>
              </tr>
              {{-- <tr>
                <th class="text-center">Laki</th>
                <th class="text-center">Perempuan</th>
                <th class="text-center">LK + PR</th>
                <th class="text-center">Laki</th>
                <th class="text-center">Perempuan</th>
                <th class="text-center">LK + PR</th>
              </tr> --}}
            </thead>
            <tbody>
              @if ( isset($data) )
              @foreach ($data as $key => $d)
                @php
                    $registrasi_id = explode('||',$d->registrasi_id);
                    // dd($registrasi_id);
                    // $kasus_baru = \App\sirrl\RlIcd10::where('icd10', $d->diagnosa)->where('status', 'baru')->count();
                    $hidup_laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'L')
                    ->where('registrasis.kondisi_akhir_pasien', '!=', 4)
                    ->count();
                    $hidup_perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'P')
                    ->where('registrasis.kondisi_akhir_pasien', '!=', 4)
                    ->count();
                    $mati_laki_laki = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'L')
                    ->where('registrasis.kondisi_akhir_pasien', '=', 4)
                    ->count();
                    $mati_perempuan = \App\PerawatanIcd10::join('registrasis', 'perawatan_icd10s.registrasi_id', '=', 'registrasis.id')
                    ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
                    ->where('perawatan_icd10s.icd10', $d->diagnosa)
                    ->whereIn('registrasis.id', $registrasi_id)
                    ->where('pasiens.kelamin', 'P')
                    ->where('registrasis.kondisi_akhir_pasien', '=', 4)
                    ->count();
                @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->diagnosa }}</td>
                  {{-- <td>
                    @php
                      $diagn = DB::table('icd10s')->where('nomor',$d->diagnosa)->first();
                      $nama = DB::table('sirrsl_icd10s')->where('id',$diagn->kategori_nomor)->first();
                    @endphp
                    {{ $nama->nama }}
                  </td> --}}
                  <td>{{ baca_icd10($d->diagnosa) }}</td>
                  <td class="text-center" style="vertical-align: middle;">{{ $hidup_laki_laki }}</td>
                  <td class="text-center" style="vertical-align: middle;">{{ $hidup_perempuan }}</td>
                  {{-- <td>{{ $hidup_laki_laki + $hidup_perempuan }}</td> --}}
                  <td class="text-center" style="vertical-align: middle;">{{ $mati_laki_laki }}</td>
                  <td class="text-center" style="vertical-align: middle;">{{ $mati_perempuan }}</td>
                  {{-- <td>{{ $mati_laki_laki + $mati_perempuan }}</td> --}}
                  <td class="text-center" style="vertical-align: middle;">{{ $hidup_laki_laki+$hidup_perempuan+$mati_laki_laki+$mati_perempuan }}</td>
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

  @section('script')
  <script>
    $('#data-table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  </script>
  @endsection