@extends('master')

@section('header')
<h1>Master Jurnal Penerimaan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if (isset($is_edit) && $is_edit == 1) Ubah Jurnal Penerimaan {{$data['code']}} @else Tambah Jurnal Penerimaan @endif &nbsp;
        </h3>
    </div>
    <div class="box-body">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('code', 'Kode Jurnal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('code', $journal['code'], ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('code') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('tanggal', date('d F Y', strtotime($journal['tanggal'])), ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;{!! Form::label('keterangan', $journal['keterangan'], ['class' => 'control-label']) !!}
                    <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    : &nbsp;@if ($journal['verifikasi'] == 0) <label class="control-label">Belum Verifikasi</label> @else <label class="control-label">Sudah Verifikasi</label> @endif
                </div>
            </div>
        </div>
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
                        @foreach ($journal['pembayaran_detail'] as $key_pd => $pd)
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
                        {!! Form::model($journal, ['route' => ['journal_operasional.update', $journal['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                        @foreach ($journal['journal_detail'] as $d)
                        <tr @if (isset($d['as_total'])) style="font-weight:bold" @endif>
                            {{-- <td>{{ $key+1 }}</td> --}}
                            <td>{{ $d['akun']['code'] }}</td>
                            <td>{{ $d['akun']['nama'] }}</td>
                            {{-- @if (is_null($d['kas_bank']))
                                <td> - </td>
                                @else
                                <td>{{ $d['kas_bank']['code'] . ' - ' . $d['kas_bank']['nama'] }}</td>
                            @endif --}}
                            
                            <td @if (isset($d['as_total']) && $d['debit'] != $d['credit']) style="background: #FF5D5D;color:white;" @endif>{!! Form::text('journal_detail['.$d['id'].'][debit]', number_format($d['debit']), ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiah()']) !!}</td>
                            <td @if (isset($d['as_total']) && $d['debit'] != $d['credit']) style="background: #FF5D5D;color:white;" @endif>{!! Form::text('journal_detail['.$d['id'].'][credit]', number_format($d['credit']), ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiah()']) !!} </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="btn-group pull-right">
            <a href="{{ route('journal_operasional.index') }}" class="btn btn-warning btn-flat">Batal</a>
            {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
<script>
// Currency
    $('.uang').maskNumber({
        thousands: ',',
        integer: true,
    }); 
</script>
@endsection