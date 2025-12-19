@extends('master')
@section('header')
    <h1>Laporan Saldo Anggaran Lebih </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'accounting/laporan/sal', 'class' =>
            'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal" class="col-md-4">Tahun Laporan</label>
                        <div class="col-md-6">
                            <input type="text" autocomplete="off" name="tha" value="{{ $tha }}"
                                class="form-control yearPicker">
                            <small class="text-danger">{{ $errors->first('tha') }}</small>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
                                data-target="#exampleModalLong">
                                Buat Data
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 pull-right">
                            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="SUBMIT">
                            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXPORT">
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
                            <th>Akun</th>
                            <th>
                                @if (isset($tha)) {{ $tha }} @else - @endif
                            </th>
                            <th>
                                @if (isset($ths)) {{ $ths }} @else - @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($data as $d)
                            <tr>
                                <td>
                                    @if ($d['nama'] != '' && $d['nama'] != 'Koreksi Yang Menambah / Mengurangi Ekuitas')
                                        {{ $i++ }}
                                    @endif
                                </td>
                                <td>{{ $d['nama'] }}</td>
                                <td>
                                    @if ($d['nama'] != '' && $d['nama'] != 'Koreksi Yang Menambah / Mengurangi Ekuitas')
                                        {{ number_format((int) $d['now']) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($d['nama'] != '' && $d['nama'] != 'Koreksi Yang Menambah / Mengurangi Ekuitas')
                                        {{ number_format((int) $d['before']) }}
                                    @endif
                                </td>
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
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['method' => 'POST', 'route' => 'simpan.sal', 'class' => 'form-horizontal'])
                !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {!! Form::label('header', 'Buat Data Saldo Anggaran Lebih', ['class' => 'col-sm-4 control-label']) !!}
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
                        <div class="form-group{{ $errors->has('penggunaan_sal') ? ' has-error' : '' }}">
                            {!! Form::label('penggunaan_sal', 'Penggunaan SAL', ['class' => 'col-sm-4 control-label'])
                            !!}
                            <div class="col-sm-8">
                                {!! Form::text('penggunaan_sal', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('penggunaan_sal') }}</small>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('sisa_pembiayaan_anggaran') ? ' has-error' : '' }}">
                            {!! Form::label('sisa_pembiayaan_anggaran', 'Sisa Lebih/Kurang Pembiayaan Anggaran', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('sisa_pembiayaan_anggaran', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('sisa_pembiayaan_anggaran') }}</small>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('koreksi_sal_tahun_sebelum') ? ' has-error' : '' }}">
                            {!! Form::label('koreksi_sal_tahun_sebelum', 'Koreksi Pembukuan Tahun Sebelumnya', ['class' => 'col-sm-4 control-label'])
                            !!}
                            <div class="col-sm-8">
                                {!! Form::text('koreksi_sal_tahun_sebelum', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('koreksi_sal_tahun_sebelum') }}</small>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('lain_lain') ? ' has-error' : '' }}">
                            {!! Form::label('lain_lain', 'Lain-lain', [
                            'class' => 'col-sm-4
                            control-label',
                            ]) !!}
                            <div class="col-sm-8">
                                {!! Form::text('lain_lain', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('lain_lain') }}</small>
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
