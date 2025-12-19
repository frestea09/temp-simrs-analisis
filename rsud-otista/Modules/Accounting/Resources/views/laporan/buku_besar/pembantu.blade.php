@extends('master')
@section('header')
    <h1>Laporan Buku Besar Penerimaan </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="row">
                {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/buku_besar_pembantu', 'class' =>
                'form-horizontal']) !!}
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                        type="button">Tanggal</button>
                                </span>
                                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' =>
                                'required']) !!}
                                <small class="text-danger">{{ $errors->first('tga') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group{{ $errors->has('tgs') ? ' has-error' : '' }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default{{ $errors->has('tgs') ? ' has-error' : '' }}"
                                        type="button">Sampai Tanggal</button>
                                </span>
                                {!! Form::text('tgs', null, ['class' => 'form-control datepicker', 'required' =>
                                'required']) !!}
                                <small class="text-danger">{{ $errors->first('tgs') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 pull-right">
                            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                {{-- {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/buku_besar_penerimaan_export', 'class' =>
                'form-horizontal']) !!}
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="input-group{{ $errors->has('tgea') ? ' has-error' : '' }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default{{ $errors->has('tgea') ? ' has-error' : '' }}"
                                        type="button">Bulan Awal</button>
                                </span>
                                {!! Form::text('tgea', null, ['class' => 'form-control monthpicker', 'required' =>
                                'required']) !!}
                                <small class="text-danger">{{ $errors->first('tgea') }}</small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group{{ $errors->has('tges') ? ' has-error' : '' }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default{{ $errors->has('tges') ? ' has-error' : '' }}"
                                        type="button">Bulan Akhir</button>
                                </span>
                                {!! Form::text('tges', null, ['class' => 'form-control monthpicker', 'required' =>
                                'required']) !!}
                                <small class="text-danger">{{ $errors->first('tges') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5 pull-right">
                            <button type="submit" name="excel" class="btn btn-success btn-flat"
                                value="monthly">Buku Besar</button>
                            <button type="submit" name="excel" class="btn btn-success btn-flat"
                                value="bku">BKU</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!} --}}
            </div>
            <hr>
            {{--
            ==================================================================================================
            --}}
            @foreach ($data as $item)
                <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed laporan_akutansi'>
                        <thead>
                            <tr>
                                <th>Kode Akun</th>
                                <th colspan="4">Nama Akun</th>
                                <th rowspan="2">
                                    {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/buku_besar_penerimaan',
                                    'class' => 'form-horizontal']) !!}
                                    {!! Form::hidden('tga', null, ['class' => 'form-control form_datetime', 'required' =>
                                    'required']) !!}
                                    {!! Form::hidden('tgs', null, ['class' => 'form-control form_datetime', 'required' =>
                                    'required']) !!}
                                    <button type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                                        value="{{ $item['id'] }}">EXCEL</button>
                                    {!! Form::close() !!}
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $item['code'] }}</td>
                                <td colspan="4">{{ $item['nama'] }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Bukti</th>
                                <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item['detail'] as $key => $d)
                                <tr>
                                    {{-- <td>{{ $key + 1 }}</td>
                                    --}}
                                    <td>{{ date('H:i d-m-Y', strtotime($d['created_at'])) }}</td>
                                    <td>{{ $d['code'] }}</td>
                                    <td>{{ $d['keterangan'] }}</td>
                                    <td>{{ number_format((int) $d['debit']) }}</td>
                                    <td>{{ number_format((int) $d['credit']) }}</td>
                                    <td>{{ number_format((int) $d['saldo']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>{{ number_format((int) $item['total']['debit']) }}</td>
                                <td>{{ number_format((int) $item['total']['credit']) }}</td>
                                <td>{{ number_format((int) $item['total']['saldo']) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endforeach


        </div>
        <div class="box-footer">
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.yearPicker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
            $('.select2').select2();

            if ($('select[name="jenis_pasien"]').val() == 1) {
                $('select[name="tipe_jkn"]').removeAttr('disabled');
            } else {
                $('select[name="tipe_jkn"]').attr('disabled', true);
            }

            $('select[name="jenis_pasien"]').on('change', function() {
                if ($(this).val() == 1) {
                    $('select[name="tipe_jkn"]').removeAttr('disabled');
                } else {
                    $('select[name="tipe_jkn"]').attr('disabled', true);
                }

            });
        });

    </script>
@endsection
