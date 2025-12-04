@extends('master')

@section('header')
  <h1>Master Jurnal Pengeluaran</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if (isset($is_edit) && $is_edit == 1) Ubah Jurnal Pengeluaran {{$data['code']}} @else Tambah Jurnal Pengeluaran @endif  &nbsp;

        </h3>
      </div>
      <div class="box-body">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('code', 'Kode Jurnal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('code', $code, ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('code') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('tanggal', date('d F Y', strtotime($tanggal)), ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('keterangan', $keterangan, ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('keterangan', 'Verifikasi', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;<a href="{{ route('journal_operasional.verif', $id) }}" class="btn btn-sm btn-info btn-flat">Verifikasi <i class="fa fa-credit-card"></i></a>
                </div>
            </div>
        </div>
        @if (isset($pembayaran_detail))
          <div class="col-sm-12">
            <hr>
          </div>
          <div class="col-sm-12">
            {!! Form::label('pembayaran', 'Detail Pembayaran', ['class' => 'control-label']) !!}
            <div class='table-responsive'>
              <table class="table table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Tarif</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pembayaran_detail as $key_pd => $pd)
                    <tr @if (isset($pd['as_total'])) style="font-weight:bold" @endif>
                      <td> @if (!isset($pd['as_total'])) {{ $key_pd+1 }} @endif</td>
                      <td>{{ $pd['namatarif'] }}</td>
                      <td>{{ number_format($pd['total']) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endif
        <div class="col-sm-12">
          <hr>
        </div>
        <div class="col-sm-12">
          {!! Form::label('journal', 'Detail Journal', ['class' => 'control-label']) !!}
          <div class='table-responsive'>
            <table class='table table-condensed table-bordered'>
              <thead>
                <tr>
                  {{-- <th>No</th> --}}
                  <th>Kode Akun</th>
                  <th>Nama Akun</th>
                  {{-- <th>Kas dan Bank</th> --}}
                  <th>Debit</th>
                  <th>Credit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($journal_detail as $d)
                  <tr @if (isset($d['as_total'])) style="font-weight:bold" @endif>
                    {{-- <td>{{ $key+1 }}</td> --}}
                    <td>{{ $d['akun']['code'] }}</td>
                    <td>{{ $d['akun']['nama'] }}</td>
                    {{-- @if (is_null($d['kas_bank']))
                    <td> - </td>
                    @else
                    <td>{{ $d['kas_bank']['code'] . ' - ' . $d['kas_bank']['nama'] }}</td>
                    @endif --}}
                    <td @if (isset($d['as_total']) && $d['debit'] != $d['credit']) style="background: #FF5D5D;color:white;" @endif>{{ number_format($d['debit']) }}</td>
                    <td @if (isset($d['as_total']) && $d['debit'] != $d['credit']) style="background: #FF5D5D;color:white;" @endif>{{ number_format($d['credit']) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@stop