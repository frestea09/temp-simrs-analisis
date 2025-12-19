@extends('master')
@section('header')
<h1>Laporan Penyusutan Piutang </h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/penyusutan_piutang', 'class' =>
        'form-horizontal']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 pull-right">
                        <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#saldoPiutang">
                            Buat Data Saldo Piutang
                        </button>
                        <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#penyusutanPiutang">
                            Buat Data Penyusutan Piutang
                        </button>
                        <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="Penyisihan">
                        <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="Klasifikasi">
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        {{--
            ==================================================================================================
            --}}
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed' id='laporan_akutansi'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cara Bayar / Tahun</th>
                        <th>Saldo Piutang</th>
                        <th>Penyisihan Piutang</th>
                        <th>Penghapusan Piutang</th>
                        <th>Penambahan Klaim / Piutang</th>
                        <th>Total Klaim</th>
                        <th>Pembayaran Piutang</th>
                        <th>Sisa Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($data as $d)
                        <tr style="font-weight: bold;">
                            <td>{{ $i++ }}</td>
                            <td>{{ $d['carabayar'] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if ($d['penyisihanpiutang'])
                                @foreach ($d['penyisihanpiutang'] as $pp)
                                    <tr>
                                        <td></td>
                                        <td>
                                            @if (isset($pp['tahun']))
                                                {{ $pp['tahun'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($pp['saldo_piutang']))
                                                {{ $pp['saldo_piutang'] }}
                                            @endif
                                        </td>
                                        @if ($pp['pengurangan'])
                                            <td>{{ $pp['pengurangan']['penyisihan'] }}</td>
                                            <td>{{ $pp['pengurangan']['penghapusan'] }}</td>
                                            <td>{{ $pp['pengurangan']['penambahan'] }}</td>
                                            <td>{{ $pp['saldo_piutang'] + $pp['pengurangan']['penambahan'] }}</td>
                                            <td>{{ $pp['pengurangan']['pembayaran'] }}</td>
                                            <td>{{ ($pp['saldo_piutang'] + $pp['pengurangan']['penambahan']) - $pp['pengurangan']['pembayaran'] }}</td>
                                        @else
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
    <div class="box-footer">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="saldoPiutang" tabindex="-1" role="dialog" aria-labelledby="saldoPiutangTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST', 'route' => 'simpan.penyusutan_piutang', 'class' => 'form-horizontal'])
            !!}
            <div class="modal-header">
                <h5 class="modal-title" id="saldoPiutangTitle">
                    {!! Form::label('header', 'Buat Data Saldo Piutang', ['class' => 'col-sm-5 control-label']) !!}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                        {!! Form::label('tahun', 'Tahun Laporan', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('tahun', date('Y'), ['class' => 'form-control yearPicker']) !!}
                            <small class="text-danger">{{ $errors->first('tahun') }}</small>
                        </div>
                    </div>
                    <div id="cara_bayar" class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                        {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('cara_bayar_id', $cara_bayar, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                            <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('saldo_piutang') ? ' has-error' : '' }}">
                        {!! Form::label('saldo_piutang', 'Saldo Piutang', ['class' => 'col-sm-4 control-label'])
                        !!}
                        <div class="col-sm-8">
                            {!! Form::text('saldo_piutang', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('saldo_piutang') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal fade" id="penyusutanPiutang" tabindex="-1" role="dialog" aria-labelledby="penyusutanPiutangTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST', 'route' => 'simpan.pengurangan_piutang', 'class' => 'form-horizontal'])
            !!}
            <div class="modal-header">
                <h5 class="modal-title" id="penyusutanPiutangTitle">
                    {!! Form::label('header', 'Buat Data Penyusutan Piutang', ['class' => 'col-sm-5 control-label']) !!}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('akutansi_penyisihan_piutang_id') ? ' has-error' : '' }}">
                        {!! Form::label('akutansi_penyisihan_piutang_id', 'Saldo Piutang dan Tahun', ['class' => 'col-sm-5 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::select('akutansi_penyisihan_piutang_id', $saldo_piutang, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                            <small class="text-danger">{{ $errors->first('akutansi_penyisihan_piutang_id') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                        {!! Form::label('tahun', 'Tahun Penyusutan', ['class' => 'col-sm-5 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('tahun', date('Y'), ['class' => 'form-control yearPicker']) !!}
                            <small class="text-danger">{{ $errors->first('tahun') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('penyisihan') ? ' has-error' : '' }}">
                        {!! Form::label('penyisihan', 'Penyisihan Piutang', ['class' => 'col-sm-5 control-label'])
                        !!}
                        <div class="col-sm-7">
                            {!! Form::text('penyisihan', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('penyisihan') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('penghapusan') ? ' has-error' : '' }}">
                        {!! Form::label('penghapusan', 'Penghapusan Piutang', ['class' => 'col-sm-5 control-label'])
                        !!}
                        <div class="col-sm-7">
                            {!! Form::text('penghapusan', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('penghapusan') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('penambahan') ? ' has-error' : '' }}">
                        {!! Form::label('penambahan', 'Penambahan Piutang', ['class' => 'col-sm-5 control-label'])
                        !!}
                        <div class="col-sm-7">
                            {!! Form::text('penambahan', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('penambahan') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('pembayaran') ? ' has-error' : '' }}">
                        {!! Form::label('pembayaran', 'Pembayaran Piutang', ['class' => 'col-sm-5 control-label'])
                        !!}
                        <div class="col-sm-7">
                            {!! Form::text('pembayaran', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('pembayaran') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
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