@extends('master')
@section('header')
  <h1>Laporan RL 3.15 Cara Bayar </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-cara-bayar', 'class'=>'form-hosizontal']) !!}
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
                <th class="text-center" rowspan="2" valign="top">CARA PEMBAYARAN</th>
                <th class="text-center" colspan="2" valign="top">PASIEN RAWAT INAP</th>
                <th class="text-center" rowspan="2" valign="top">JUMLAH PASIEN RAWAT JALAN</th>
                <th class="text-center" colspan="3">JUMLAH PASIEN</th>
            </tr>
            <tr>
                <th class="text-center">JUMLAH PASIEN KELUAR</th>
                <th class="text-center">JUMLAH LAMA DIRAWAT</th>
                <th class="text-center">LABORATORIUM</th>
                <th class="text-center">RADIOLOGI</th>
                <th class="text-center">LAIN-LAIN</th>
            </tr>
          </thead>
          <tbody>
            @if ( isset($carabayar) )
              @foreach ($carabayar as $d)
                <tr>
                  <td>{{ $no++ }}</td>
                <td class="text-center">{{$d->carabayar}}</td>
                  <td class="text-center">{{$d->jumlahinap}}</td>
                  <td class="text-center">{{$d->hariinap}} Hari</td>
                  <td class="text-center">{{$d->jumlahjalan}}</td>
                  <td class="text-center">{{$d->jumlahrad}}</td>
                  <td class="text-center">{{$d->jumlahlab}}</td>
                  <td class="text-center"></td>
                  <td class="text-center"></td>
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
