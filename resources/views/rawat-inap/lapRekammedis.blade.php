@extends('master')
@section('header')
    <h1>Laporan Rekam Medis</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'rawatinap/laporan-rekammedis', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('tga', 'Periode', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                            <small class="text-danger">{{ $errors->first('tga') }}</small>
                        </div>
                        <div class="col-sm-4">
                        {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                        {{--  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">  --}}
                        <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
        @isset($lap)
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Poli</th>
                            <th class="text-center">Bayar</th>
                            <th class="text-center">Dokter</th>
                            <th class="text-center">Tindakan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $jumlah = 0; @endphp
                        @foreach ($lap as $key => $d)
                            @php
                                $nt     = explode('||', $d->tindakan);
                                $total  = explode('||', $d->total);
                                $tgl    = explode('||', $d->tanggal);
                            @endphp
                            <tr>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ $no++ }}</td>
                                <td rowspan="{{ count($total) }}">{{ $d->pasien->no_rm }}</td>
                                <td rowspan="{{ count($total) }}">{{ $d->pasien->nama }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ $d->pasien->kelamin }}</td>
                                <td rowspan="{{ count($total) }}">{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                                <td class="text-center" rowspan="{{ count($total) }}">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                                <td rowspan="{{ count($total) }}">{{ baca_dokter($d->dokter_id) }}</td>
                            @if(count($total) > 1)
                                @foreach($total as $k => $t)
                                    @if($k == 0)
                                        <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                        <td class="text-right">{{ number_format($t) }}</td>
                                    @else
                                        <tr>
                                            <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                            <td class="text-right">{{ number_format($t) }}</td>
                                        </tr>
                                    @endif
                                    @php $jumlah += (int)$t; @endphp
                                @endforeach
                            @else
                                    <td>{{ (isset($nt[0])) ? $nt[0] : '' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($tgl[0])) }}</td>
                                    <td class="text-right">{{ number_format($total[0]) }}</td>
                                </tr>
                                @php $jumlah += (int)$total[0]; @endphp
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="10">Total</th>
                                <th class="text-right">{{ number_format($jumlah) }}</th>
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
        @endisset
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            if($('select[name="jenis_pasien"]').val() == 1) {
                $('select[name="tipe_jkn"]').removeAttr('disabled');
            } else {
                $('select[name="tipe_jkn"]').attr('disabled', true);
            }

            $('select[name="jenis_pasien"]').on('change', function () {
                if ($(this).val() == 1) {
                $('select[name="tipe_jkn"]').removeAttr('disabled');
                } else {
                $('select[name="tipe_jkn"]').attr('disabled', true);
                }
            });
        });
    </script>
@endsection
