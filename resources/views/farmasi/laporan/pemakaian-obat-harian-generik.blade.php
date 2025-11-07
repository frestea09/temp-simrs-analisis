@extends('master')
@section('header')
  <h1>Laporan<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        <h4>Laporan Pemakaian Obat Generik</h4>
        </div>
        <div class="box-body">
            <form action="{{ url('farmasi/laporan/pemakaian-obat-harian-generik') }}" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="row">
                <div class="col-sm-6">
                    {{--  <div class="form-group">
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
                   <br/><br/><br/>
                    <div class="form-group">
                        <label for="periode" class="col-sm-3 control-label">Periode</label>
                        <div class="col-sm-4 {{ $errors->has('tgl_awal') ? 'has-error' :'' }}">
                            <input type="text" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : NULL }}" class="form-control datepicker">
                        </div>
                        <div class="col-sm-1 text-center">
                            s/d
                        </div>
                        <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                            <input type="text" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : NULL }}" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="depo" class="col-sm-3 control-label">Gudang</label>
                        <div class="col-sm-9">
                            <select name="jenis" class="form-control select2" style="width: 100%">
                            @if (isset($_POST['jenis']) && $_POST['jenis'] == 'TA')
                                <option value="TA" selected="true">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                            @elseif (isset($_POST['jenis']) && $_POST['jenis'] == 'TI')
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI" selected="true">Rawat Inap</option>
                            @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TG')
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG" selected="true">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                            @else
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                            <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value="PDF">
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
                <h3 class="box-title">Detail List Pemakaian Obat Generik</h3>
                <table class="table table-bordered table-striped" border="1" id="data">
                    <thead class="bg-olive">
                    <tr>
                        <th>No.Faktur</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Harga Obat (Rp.)</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Terpakai (item)</th>
                        <th>Stok (item)</th>
                        <th>Expired</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (!empty($pemakaian))
                            @foreach ($pemakaian as $key => $d)
                            <tr>
                                <td>{{ $d->no_resep }}</td>
                                <td>{{ baca_obat($d->masterobat_id) }}</td>
                                <td>
                                    @php
                                      $datas = App\Masterobat::where('id',$d->masterobat_id)->first();
                                    @endphp
                                     {{ baca_satuan_jual($datas->satuanjual_id) }}
                                </td>
                                <td>{{ number_format(baca_obat_harga($d->masterobat_id)) }}</td>
                                <td>{{ @historimasuk($d->masterobat_id) }}</td>
                                <td>{{ @historikeluar($d->masterobat_id) }}</td>
                                <td>{{ $d->jumlah_total+$d->jml_kronis_total }}</td>
                                <td>{{ @stok($d->masterobat_id) }}</td>
                                <td>{{ @expired($d->masterobat_id)}}</td>
                                <td>{{ @Ket($d->masterobat_id)}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
