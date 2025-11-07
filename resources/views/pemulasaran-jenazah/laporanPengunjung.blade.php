@extends('master')
@section('header')
    <h1>Laporan Pemulasaran Jenazah</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => '/pemulasaran-jenazah/laporan-pengunjung', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
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
                    <div class="form-group">
                        <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
                        <div class="col-md-8">
                            <select class="form-control select2" style="width: 100%" name="bayar">
                                <option value="0" {{ ($bayar == 0) ? 'selected' : '' }}>SEMUA</option>
                            @foreach ($cara_bayar as $cb)
                                <option value="{{ $cb->id }}" {{ ($bayar == $cb->id) ? 'selected' : '' }}>{{ $cb->carabayar }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group text-center">
                        <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                        {{--  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">  --}}
                        <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK">
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
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
                        @foreach ($pengunjung as $key => $d)
                            @php
                                $nt     = explode('||', $d->tindakan);
                                $total  = explode('||', $d->total);
                                $tgl    = explode('||', $d->tanggal);
                                $dokter = explode('||', $d->dokter);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $d->pasien->no_rm }}</td>
                                <td>{{ $d->pasien->nama }}</td>
                                <td class="text-center">{{ ($d->status == 'baru') ? 'Baru' : 'Lama' }}</td>
                                <td class="text-center">{{ $d->pasien->kelamin }}</td>
                                <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                                <td class="text-center">{{ strtoupper(baca_carabayar($d->bayar)) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                            @if(count($total) > 1)
                                @foreach($total as $k => $t)
                                    @if($k == 0)
                                        <td>{{ baca_dokter($dokter[$k]) }}</td>
                                        <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                        <td class="text-right">{{ number_format($t) }}</td>
                                    @else
                                        <tr>
                                            <td>{{ baca_dokter($dokter[$k]) }}</td>
                                            <td>{{ (isset($nt[$k])) ? $nt[$k] : '' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($tgl[$k])) }}</td>
                                            <td class="text-right">{{ number_format($t) }}</td>
                                        </tr>
                                    @endif
                                    @php $jumlah += (int)$t; @endphp
                                @endforeach
                            @else
                                    <td>{{ baca_dokter($dokter[0]) }}</td>
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
