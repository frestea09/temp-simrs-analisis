@extends('master')
@section('header')
  <h1>Laporan RL 5.1 Pengujung</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'kegiatan-pengujung', 'class'=>'form-hosizontal']) !!}
      <div class="row">
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
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Jenis Kedatangan</th>
                <td>Jumlah</td>
              </tr>
              <tr>
                <th>Pengujung Lama</th>
                <td>{{ $pengujung_lama }}</td>
              </tr>
              <tr>
                <th>Pengujung Baru</th>
                <td>{{ $pengujung_baru }}</td>
              </tr>
            </thead>
          </table>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection
