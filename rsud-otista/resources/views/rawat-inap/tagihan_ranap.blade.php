@extends('master')
@section('header')
    <h1>Laporan Tagihan<small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"></div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/tagihan-ranap', 'class'=>'form-horizontal']) !!}
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Periode</label>
                    <div class="col-md-4">
                        <input type="text" name="tga" value="{{ $tga }}" class="form-control datepicker" autocomplete="off" >
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="tgb" value="{{ $tgb }}" class="form-control datepicker" autocomplete="off" >
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tindakan</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="tarif_id">
                        <option value="0" {{ ($tarif_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($tindakan as $t)
                            <option value="{{ $t->id }}" {{ ($tarif_id == $t->id) ? 'selected' : '' }}>{{ $t->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Dokter</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="dokter_id">
                            <option value="0" {{ ($dokter_id == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->id }}" {{ ($dokter_id == $d->id) ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
                    <div class="col-md-8">
                        <select class="form-control select2" style="width: 100%" name="jenis_pasien">
                            <option value="0" {{ ($jenis_pasien == 0) ? 'selected' : '' }}>SEMUA</option>
                        @foreach ($cara_bayar as $cb)
                            <option value="{{ $cb->id }}" {{ ($jenis_pasien == $cb->id) ? 'selected' : '' }}>{{ $cb->carabayar }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="pull-left form-group">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="TAMPILKAN">
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        {{-- ================================================================================================== --}}
        @isset($irna_new)
            <div class='table-responsive'>
                <table class='table table-bordered table-hover' style="font-size:11px;">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">No. RM</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Ruangan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Bayar</th>
                            <th class="text-center">Dokter Pelaksana</th>
                            <th class="text-center">Dokter DPJP</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Nama Tindakan</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($irna_new as $key => $d)
                    @php
                        $total    = count($d);
                    @endphp
                    <tr>
                        <td rowspan="{{$total}}" class="text-center">{{$no++}}</td>
                        {{-- <td><button data-toggle="collapse" data-target="#{{$key}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Detail Obat</button> {{@$reg->pasien->no_rm}}</td> --}}
                        <td rowspan="{{$total}}">{{@$d[0]->no_rm}}</td>
                        <td rowspan="{{$total}}">{{@$d[0]->nama}}</td>
                        <td rowspan="{{ $total }}">{{ @$d[0]->kelompok }}</td>
                        <td rowspan="{{$total}}" class="text-center">{{ @$d[0]->status == 'baru' ? 'Baru' : 'Lama' }}</td>
                        <td rowspan="{{$total}}" class="text-center">{{ @$d[0]->kelamin }}</td>
                        {{-- <td>IBS / Operasi</td> --}}
                        <td class="text-center" rowspan="{{$total}}">{{ strtoupper(@$d[0]->carabayar) }} {{ @$d[0]->bayar == '1' ? ' - '. @$d[0]->tipe_jkn : '' }}</td>

                        <td>{{ @$d[0]->pelaksana}}</td>
                        <td>{{ @$d[0]->dpjp}}</td>
                        <td>{{date('d-m-Y',strtotime(@$d[0]->created_at))}}</td>
                        <td>{{ @$d[0]->namatarif }}</td>
                        <td>{{ number_format(@$d[0]->total) }}</td>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach($d as $k => $t)
                            @if($k !== 0)
                            <tr>
                                <td>{{ @$t->pelaksana}}</td>
                                <td>{{ @$t->dpjp}}</td>
                                <td>{{date('d-m-Y',strtotime(@$t->created_at))}}</td>
                                <td>{{ @$t->namatarif }}</td>
                                <td>{{ number_format(@$t->total) }}</td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="11">Total</th>
                            <th class="text-right">{{ number_format(@$grandTotal) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        
        @endisset
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.select2').select2()
        $(".skin-blue").addClass( "sidebar-collapse" );
        $(document).ready(function() {
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
