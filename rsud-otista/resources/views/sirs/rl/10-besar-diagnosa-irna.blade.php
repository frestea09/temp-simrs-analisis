@extends('master')
@section('header')
  <h1>Laporan RL 5.3 Daftar 10 Besar Penyakit Rawat Inap</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '10-besar-diagnosa-irna-baru', 'class'=>'form-hosizontal']) !!}
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
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
            <thead>
              <tr>
                <th class="text-center" rowspan="2">No</th>
                {{-- <th class="text-center" rowspan="2">Bulan</th>
                <th class="text-center" rowspan="2">Tahun</th> --}}
                <th class="text-center" rowspan="2">ICD10</th>
                <th class="text-center" rowspan="2">Diagnosa</th>
                {{-- <th valign="top" colspan="2">Pasien Keluar Hidup Menurut Jenis Kalamin</th>
                <th valign="top">Jumlah Pasien Keluar Hidup</th>
                <th valign="top" colspan="2">Pasien Keluar Mati Menurut Jenis Kalamin</th>
                <th valign="top">Jumlah Pasien Keluar Mati</th>
                <th class="text-center" rowspan="2">Total Hidup & Mati</th> --}}
                <th class="text-center" rowspan="2">Jumlah</th>
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
                  {{-- <td>{{ $hidup_laki_laki }}</td>
                  <td>{{ $hidup_perempuan }}</td>
                  <td>{{ $hidup_laki_laki + $hidup_perempuan }}</td>
                  <td>{{ $mati_laki_laki }}</td>
                  <td>{{ $mati_perempuan }}</td>
                  <td>{{ $mati_laki_laki + $mati_perempuan }}</td> --}}
                  {{-- <td>{{ $hidup_laki_laki+$hidup_perempuan+$mati_laki_laki+$mati_perempuan }}</td> --}}
                  <td>{{ $d->jumlah }}</td>
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