@extends('master')
@section('header')
  <h1>Laporan<small>Pemakaian Obat</small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body" >
            <form action="{{ url('farmasi/laporan/pemakaian-obat') }}" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="row">
                <div class="col-sm-12">
                     {{-- <div class="form-group">
                        <label for="nama" class="col-sm-3 control-label">Nama Obat</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="obat" style="width: 100%;">
                                    <option value="">SEMUA</option>
                                @foreach ($obat as $key => $d)
                                    @if (!empty($_POST['obat']) && $_POST['obat'] == $d->masterobat_id)
                                        <option value="{{ $d->masterobat_id }}" selected>{{ $d->nama }}</option>
                                    @else
                                        <option value="{{ $d->masterobat_id }}" >{{ $d->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>  --}}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="periode" class="col-sm-3 control-label">Periode</label>
                            <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                                <input type="text" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : @valid_date(@$awal) }}" class="form-control datepicker">
                            </div>
                            <div class="col-sm-1 text-center">
                                s/d
                            </div>
                            <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                                <input type="text" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : @valid_date(@$akhir) }}" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                                <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                                <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value="PDF">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
        <div class="box-body">
            <div class="table-responsive">
                <br>
                <table class="table table-bordered table-striped" border="1" >
                    <thead class="bg-olive">
                    <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: center">No</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Nama Obat</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Bentuk Sediaan</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Stok Awal</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Jumlah Penerimaan</th>
                        <th colspan="5" style="text-align: center; vertical-align: center">Jumlah Penggunaan</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Harga per item (Rp.)</th>
                        <th rowspan="2" style="text-align: center; vertical-align: center">Total (Rp.)</th>
                    </tr>
                    <tr>
                        <th>Rawat Jalan</th>
                        <th>Rawat Inap</th>
                        <th>IGD</th>
                        <th>Bebas</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (!empty($pemakaian))
                            @foreach ($pemakaian as $stocks)
                                <tr>
                                    @php
                                        $masterobat = @App\Masterobat::find(@$stocks->masterobat_id);
                                        $stokAwal = @App\Logistik\LogistikStock::where('masterobat_id', @$masterobat->id)->where('gudang_id', 3)->whereDate('created_at', '<=', $awal)->orderBy('id', 'DESC')->first()->total;
                                        $penerimaan = @App\Logistik\LogistikStock::where('masterobat_id', @$masterobat->id)->where('gudang_id', 3)->whereBetween('created_at', [$awal, $akhir])->sum('masuk');
                                    @endphp
                                    <td>{{$no++}}</td>
                                    <td>{{ baca_obat(@$masterobat->id) }}</td>
                                    <td>
                                        {{ baca_satuan_jual(@$masterobat->satuanjual_id) }}
                                    </td>
                                    <td>
                                        {{$stokAwal }}
                                    </td>
                                    <td>
                                        {{$penerimaan}}
                                    </td>
                                    <td>{{$stocks->jalan}}</td>
                                    <td>{{$stocks->inap}}</td>
                                    <td>{{$stocks->darurat}}</td>
                                    <td>{{$stocks->bebas}}</td>
                                    <td>{{$stocks->total}}</td>
                                    <td>{{ number_format(baca_obat_harga(@$masterobat->id)) }}</td>
                                    <td>{{ number_format(baca_obat_harga(@$masterobat->id) * $stocks->total) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (!empty($pemakaian))
                    {{$pemakaian->appends(['tgl_awal' => $awal, 'tgl_akhir' => $akhir ])->links()}}
                @endif
            </div>
        </div>
        </div>
    </div>
@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
  </script>
@endsection
