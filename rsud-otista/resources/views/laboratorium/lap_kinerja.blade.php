@extends('master')

@section('header')
    <h1>Laporan Kinerja Laboratorium</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <form action="{{ url('laboratorium/laporan-kinerja') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pelayanan" class="col-sm-3 control-label">Pelayanan</label>
                            <div class="col-sm-9">
                                <select name="pelayanan" class="form-control select2" style="width: 100%">
                                    @if (isset($jenisReg) && $jenisReg == 'TA')
                                        <option value="TA" selected="true">Rawat Jalan</option>
                                        <option value="TG">Rawat Darurat</option>
                                        <option value="TI">Rawat Inap</option>
                                        <option value="PB">Penjualan Langsung</option>
                                    @elseif (isset($jenisReg) && $jenisReg == 'TI')
                                        <option value="TA">Rawat Jalan</option>
                                        <option value="TG">Rawat Darurat</option>
                                        <option value="TI" selected="true">Rawat Inap</option>
                                        <option value="PB">Penjualan Langsung</option>
                                    @elseif(isset($jenisReg) && $jenisReg == 'TG')
                                        <option value="TA">Rawat Jalan</option>
                                        <option value="TG" selected="true">Rawat Darurat</option>
                                        <option value="TI">Rawat Inap</option>
                                        <option value="PB">Penjualan Langsung</option>
                                    @elseif(isset($jenisReg) && $jenisReg == 'PB')
                                        <option value="TA">Rawat Jalan</option>
                                        <option value="TG">Rawat Darurat</option>
                                        <option value="TI">Rawat Inap</option>
                                        <option value="PB" selected="true">Penjualan Langsung</option>
                                    @else
                                        <option value="TA">Rawat Jalan</option>
                                        <option value="TG">Rawat Darurat</option>
                                        <option value="TI">Rawat Inap</option>
                                        <option value="PB">Penjualan Langsung</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bayar" class="col-sm-3 control-label">Bayar</label>
                            <div class="col-sm-9">
                                <select name="bayar" class="form-control select2" style="width: 100%">
                                    <option value="">Semua</option>
                                    @foreach ($cara_bayar as $d)
                                        @if (isset($_POST['bayar']) && $_POST['bayar'] == $d->id)
                                            <option value="{{ $d->id }}" selected="true">{{ $d->carabayar }}</option>
                                        @else
                                            <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="periode" class="col-sm-3 control-label">Periode</label>
                            <div class="col-sm-4">
                                <input type="text" name="tglAwal"
                                    value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : null }}"
                                    class="form-control datepicker">
                            </div>
                            <label for="periode" class="col-sm-1 control-label">s/d</label>
                            <div class="col-sm-4">
                                <input type="text" name="tglAkhir"
                                    value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : null }}"
                                    class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bayar" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                {{-- <button type="submit" name="submit" value="lanjut" class="btn btn-primary btn-flat">LANJUT</button> --}}
                                <button type="submit" name="submit" value="excel"
                                    class="btn btn-success btn-flat">EXCEL</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="data" class="table table-hover table-bordered table-condensed">
                            <thead class="bg-primary">
                                <tr>
                                    <th style="vertical-align: middle;" class="text-center">No</th>
                                    <th style="vertical-align: middle;" class="text-center">Nama</th>
                                    <th style="vertical-align: middle;" class="text-center">No. RM</th>
                                    <th style="vertical-align: middle;" class="text-center">No. SEP</th>
                                    <th style="vertical-align: middle;" class="text-center">Baru / Lama</th>
                                    <th style="vertical-align: middle;" class="text-center">JK</th>
                                    <th style="vertical-align: middle;" class="text-center">Ruang/Poli</th>
                                    <th style="vertical-align: middle;" class="text-center">Cara Bayar</th>
                                    <th style="vertical-align: middle;" class="text-center">Tanggal</th>
                                    <th style="vertical-align: middle;" class="text-center">Dokter</th>
                                    <th style="vertical-align: middle;" class="text-center">Cara Pulang</th>
                                    <th style="vertical-align: middle;" class="text-center">Pemeriksaan</th>
                                    <th style="vertical-align: middle;" class="text-center">Lunas</th>
                                    <th style="vertical-align: middle;" class="text-center">Tarif RS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($labs['lab_new']) && !empty($labs['lab_new']))
                                    @php
                                        $no = 1;
                                        $totalAll = 0;

                                    @endphp
                                    @foreach ($labs['lab_new'] as $key => $d)
                                        @php
                                            $reg = Modules\Registrasi\Entities\Registrasi::find($key);

                                            $total = count($d);

                                        @endphp
                                        <tr>
                                            <td rowspan="{{ $total }}" class="text-center">{{ $no++ }}</td>
                                            <td rowspan="{{ $total }}">{{ @$reg->pasien->no_rm }}</td>
                                            <td rowspan="{{ $total }}">{{ @$reg->no_sep }}</td>
                                            <td rowspan="{{ $total }}">{{ @$reg->pasien->nama }}</td>
                                            <td rowspan="{{ $total }}" class="text-center">
                                                {{ @$reg->status == 'baru' ? 'Baru' : 'Lama' }}</td>
                                            <td rowspan="{{ $total }}" class="text-center">
                                                {{ @$reg->pasien->kelamin }}</td>




                                            @foreach ($d as $k => $t)
                                                {{-- {{dd($t)}} --}}

                                                @php
                                                    $totalAll += $t->total;

                                                    $irna = \App\Rawatinap::select('kamar_id')
                                                        ->where('registrasi_id', $t->registrasi_id)
                                                        ->first();

                                                    $subtotal = $t->total;
                                                    $jenis = $t->jenis;
                                                    $cara_bayar_id = $t->cara_bayar_id;
                                                    $created_at = $t->created_at;
                                                    $dokter_id = $t->dokter_id;
                                                    $namatarif = $t->namatarif;
                                                    $lunas = $t->lunas;
                                                @endphp
                                                @if ($k !== 0)
                                                    <tr>
                                                @endif
                                                <td>
                                                    @if ($jenis == 'TA' || $jenis == 'TG')
                                                        {{ baca_poli(@$reg->poli_id) }}
                                                    @elseif($jenis == 'TI')
                                                        {{ $irna ? baca_kamar($irna->kamar_id) : null }}
                                                    @endif
                                                </td>
                                                <td>{{ baca_carabayar($cara_bayar_id) }}</td>
                                                <td>{{ $created_at->format('d-m-Y') }}</td>
                                                <td>{{ baca_dokter($dokter_id) }}</td>
                                                <td>{{ baca_carapulang($reg->pulang) }}</td>
                                                <td>{{ $namatarif }}</td>
                                                <td>
                                                    @if ($lunas == 'Y')
                                                        Lunas
                                                    @else
                                                        Belum Lunas
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($subtotal) }}</td>
                                                </tr>
                                            @endforeach
                                </tr>
                                @endforeach
                                {{-- @php
                       dd($totalAll);
                @endphp --}}
                                @endif

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="11" class="text-right">Total Tarif</th>
                                    <th class="text-right">{{ number_format(@$totalAll) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="11" class="text-right">Total Pemeriksaan</th>
                                    <th class="text-right">{{ isset($data) ? count($data) : null }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()
    </script>
@endsection
