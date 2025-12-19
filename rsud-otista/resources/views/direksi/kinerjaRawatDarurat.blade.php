@extends('master')

@section('header')
  <h1>Kinerja Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/direksi/kinerja-rawat-darurat', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('cara_bayar') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('cara_bayar') ? ' has-error' : '' }}" type="button">Bayar</button>
              </span>
              <select name="carabayar" class="form-control select2">
                <option value="2">NON JKN</option>
                <option value="1">JKN</option>
              </select>
              <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Klinik</button>
              </span>
              <select name="poli_id" class="form-control select2">
                  @foreach ($klinik as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('dokter_id') ? ' has-error' : '' }}" type="button">Dokter</button>
                </span>
                <select name="dokter_id" class="form-control select2" style="width: 100%">
                  <option value="all"> [ Semua ] </option>
                  @foreach ($dokter as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
            </div>
        </div>

        <div class="col-md-2">

        </div>

        </div>
        <div class="clearfix" style="height: 10px"></div>
        <div class="row">
          <div class="col-md-3">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tgl</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">s/d Tgl</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="btn-group pull-left">
              <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> EXCEL</button>
            </div>
          </div>
        </div>
      {!! Form::close() !!}

    <hr>
    <div class="well">
      <h4>Keterangan</h4>
      <ol>
        <li>Untuk Mendownload <b>Pasien JKN </b>Sebaiknya di pecah minimal 3 kali dalam 1 bulan, misal tanggal 1 - 10, 11 - 20, dan 21 - 30/31</li>
        <li>Kalau ternyata dengan rentang 10 hari tetap tidak bisa silakan di kurangi ke rentang 5 hari, mulai tanggal 1 - 5 dan seterusnya</li>
      </ol>
    </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection


@section('script')
    <script type="text/javascript">
      $('.select2').select2();
    </script>
@endsection
