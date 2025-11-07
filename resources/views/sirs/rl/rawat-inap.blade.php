@extends('master')
@section('header')
  <h1>Laporan RL 3.1 Kegiatan Pelayanan Rawat Inap </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-pelayanan-rawat-inap', 'class'=>'form-hosizontal']) !!}
      <div class="row">
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
                <th class="text-center" rowspan="2" valign="top">JENIS PELAYANAN</th>
                <th class="text-center" rowspan="2" valign="top">PASIEN AWAL TAHUN</th>
                <th class="text-center" rowspan="2" valign="top">PASIEN MASUK</th>
                <th class="text-center" rowspan="2" valign="top">PASIEN KELUAR HIDUP</th>
                <th class="text-center" colspan="2" valign="top">PASIEN KELUAR MATI</th>
                <th class="text-center" rowspan="2" valign="top">JUMLAH LAMA DIRAWAT</th>
                <th class="text-center" rowspan="2">PASIEN AKHIR TAHUN</th>
                <th class="text-center" rowspan="2">JUMLAH HARI PERAWATAN</th>
                <th class="text-center" colspan="6">RINCIAN HARI PERAWATAN PER KELAS</th>
            </tr>
            <tr>
                <th class="text-center">< 48 jam</th>
                <th class="text-center">≥ 48 jam</th>
                <th class="text-center">VVIP</th>
                <th class="text-center">VIP</th>
                <th class="text-center">I</th>
                <th class="text-center">II</th>
                <th class="text-center">III</th>
                <th class="text-center">Kelas Khusus</th>
            </tr>
          </thead>
          <tbody>
            @if ( isset($pelayanan_rawat_inap) )
              @foreach ($pelayanan_rawat_inap as $key => $d)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-center">{{$d->kegiatan}}</td>
                    <td class="text-center">{{$d->tahunbaru}}</td>
                    <td class="text-center">{{$d->masuk}}</td>
                    <td class="text-center">{{$d->keluar_hidup}}</td>
                    <td class="text-center">{{$d->keluar_mati_kurang_48}}</td>
                    <td class="text-center">{{$d->keluar_mati_lebih_48}}</td>
                    <td class="text-center">{{$d->lama_dirawat}} Hari</td>
                    <td class="text-center">{{$d->tahunakhir}}</td>
                    <td class="text-center">{{$d->lama_dirawat}} Hari</td>
                    <td class="text-center">{{$d->vvip}}</td>
                    <td class="text-center">{{$d->vip}}</td>
                    <td class="text-center">{{$d->kelas1}}</td>
                    <td class="text-center">{{$d->kelas2}}</td>
                    <td class="text-center">{{$d->kelas3}}</td>
                    <td class="text-center">{{ 0 }}</td>
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
