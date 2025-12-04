@extends('master')

@section('header')
  <h1>Jurnal Pengeluaran </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Jurnal Pengeluaran &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'accounting/journal_pengeluaran', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="col-md-4">
                <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                    </span>
                    {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group{{ $errors->has('tgs') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                      <button class="btn btn-default{{ $errors->has('tgs') ? ' has-error' : '' }}" type="button">Sampai Tanggal</button>
                    </span>
                    {!! Form::text('tgs', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tgs') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tanggal" class="col-md-3">Status</label>
                  <div class="col-md-7">
                    <select name="status" value="{{$status}}" class="form-control">
                      <option value="2" @if ($status == '2') selected @endif>[Semua]</option>
                      <option value="1" @if ($status == '1') selected @endif>Verifikasi</option>
                      <option value="0" @if ($status == '0') selected @endif>Belum Verifikasi</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('status') }}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3 pull-right">
                <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
                {{-- <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL"> --}}
              </div>
            </div>
          </div>
          <div class="col-md-8">
          </div>
        </div>
  
        {!! Form::close() !!}
        <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>Tanggal</th>
                <th>Kode Jurnal</th>
                <th>Status</th>
                <th>Total Transaksi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  {{-- <td>{{ $key+1 }}</td> --}}
                  <td>{{ date('d-m-Y', strtotime($d['tanggal'])) }}</td>
                  <td>{{ $d['code'] }}</td>
                  <td>@if ($d['verifikasi'] == 1) Sudah Verifikasi @else Belum Verifikasi @endif</td>
                  <td>{{ number_format($d['total_transaksi']) }}</td>
                  <td>
                    <a href="{{ route('journal_pengeluaran.show', $d['id']) }}" class="btn btn-success btn-sm"><i class="fa fa-info"></i></a>
                    @if ($d['verifikasi'] == 0)
                      <a href="{{ route('journal_pengeluaran.verifikasi', $d['id']) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                    @endif
                    @if (isset($d['id']))
                      <a href="{{ route('journal_pengeluaran.edit', $d['id']) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop