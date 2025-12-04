@extends('master')

@section('header')
    <h1>Pindah Saldo Kas dan Bank</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                @if (isset($is_edit) && $is_edit == 1) Pindah Saldo {{ $data['code'] }}
                @else Pindah Saldo @endif &nbsp;

            </h3>
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => ['saldo.kas_bank.transfer', $data['induk']['id']], 'class' =>
            'form-horizontal']) !!}
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    {!! Form::label('code', 'Kode Jurnal', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::label('code', $data['induk']['code'] . ' - ' . $data['induk']['nama'], [
                        'class' => 'col-sm-8
                        control-label',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('code') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal Transfer', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('id_akun_coa') ? ' has-error' : '' }}">
                    {!! Form::label('id_akun_coa', 'Tujuan Transfer', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('tujuan', $data['akun_coa'], null, [
                        'class' => 'form-control
                        select2',
                        'style' => 'width:100%',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('id_akun_coa') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('debit') ? ' has-error' : '' }}">
                    {!! Form::label('debit', 'Jumlah Transfer', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('total_transaksi', 0, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('debit') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr>
            </div>
            <div class="col-sm-12">
                <hr>
                <div class="btn-group pull-right">
                    <a href="{{ route('journal_umum.index') }}" class="btn btn-warning btn-flat">Batal</a>
                    {!! Form::submit('Simpan', ['class' => 'btn btn-success btn-flat']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })

        function removeBox(params) {
            $(params).parent().parent().remove()
        }

    </script>
@endsection
