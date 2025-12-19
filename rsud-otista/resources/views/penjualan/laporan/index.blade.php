@extends('master')
@section('header')
    <h1>Laporan Penjualan Obat </h1>
    <style>
        table.table-report {
            border: 1px solid grey;
            margin-top: 20px;
        }

        table.table-report>thead>tr>th {
            border: 1px solid grey;
        }

        table.table-report>tbody>tr>td {
            border: 1px solid grey;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            {{-- <h3 class="box-title">
        Periode Tanggal &nbsp;
      </h3> --}}
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'penjualan/laporan', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="periode" class="col-sm-3 control-label">Periode</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" autocomplete="off" name="tga"
                                        value="{{ isset($_POST['tga']) ? $_POST['tga'] : null }}"
                                        class="form-control datepicker">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" autocomplete="off" name="tgb"
                                        value="{{ isset($_POST['tgb']) ? $_POST['tgb'] : null }}"
                                        class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis" class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-9">
                            <button type="submit" name="submit" class="btn btn-primary btn-flat">TAMPIL LIST</button>
                            <button type="submit" name="submit" value="KALKULASI" class="btn btn-primary btn-flat">TAMPIL KALKULASI</button>
                            <button type="EXCEL" name="submit" value="EXCEL"
                            class="btn btn-success btn-flat">EXCEL</button>
                            <button type="CETAK" name="submit" value="CETAK"
                                class="btn btn-warning btn-flat">CETAK</button>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">


                </div>
            </div>
            {!! Form::close() !!}

            @isset($penjualan)
                <h4>Periode: {{ $tga }} s/d {{ $tgb }}</h4>
                <div class="table-responsive">
                    @if($tampilKalkulasi)
                        <table class="table-hover table-condensed table-bordered table-report table">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">RAWAT JALAN</th>
                                    <th class="text-center">RAWAT INAP</th>
                                    <th class="text-center">GAWAT DARURAT</th>
                                    <th class="text-center">IBS</th>
                                    <th class="text-center">Penjualan Bebas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Jumlah Penjualan</b></td>
                                    <td>{{ number_format(@$hasilJalan['jumlah_penjualan']) }}</td>
                                    <td>{{ number_format(@$hasilIRNA['jumlah_penjualan']) }}</td>
                                    <td>{{ number_format(@$hasilIGD['jumlah_penjualan']) }}</td>
                                    <td>{{ number_format(@$hasilOperasi['jumlah_penjualan']) }}</td>
                                    <td>{{ number_format(@$hasilBebas['jumlah_penjualan']) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total Penjualan Harga Jual</b></td>
                                    <td>{{ number_format(@$hasilJalan['total_harga_jual']) }}</td>
                                    <td>{{ number_format(@$hasilIRNA['total_harga_jual']) }}</td>
                                    <td>{{ number_format(@$hasilIGD['total_harga_jual']) }}</td>
                                    <td>{{ number_format(@$hasilOperasi['total_harga_jual']) }}</td>
                                    <td>{{ number_format(@$hasilBebas['total_harga_jual']) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total Penjualan Harga Pokok</b></td>
                                    <td>{{ number_format(@$hasilJalan['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilIRNA['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilIGD['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilOperasi['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilBebas['total_harga_jual_pokok']) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Selisih</b></td>
                                    <td>{{ number_format(@$hasilJalan['total_harga_jual'] - @$hasilJalan['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilIRNA['total_harga_jual'] - @$hasilIRNA['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilIGD['total_harga_jual'] - @$hasilIGD['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilOperasi['total_harga_jual'] - @$hasilOperasi['total_harga_jual_pokok']) }}</td>
                                    <td>{{ number_format(@$hasilBebas['total_harga_jual'] - @$hasilBebas['total_harga_jual_pokok']) }}</td>
                                </tr> - 
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="table-responsive">
                    @if(!$tampilKalkulasi)
                    <table class="table-hover table-bordered table-condensed table" id="dataPenjualan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Faktur</th>
                                <th>Nama Pasien</th>
                                <th>No. RM</th>
                                <th class="text-center">Total</th>
                                <th>Jenis Pasien</th>
                                <th class="text-center">Tanggal</th>
                                <th>User</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (true)
                                @foreach ($penjualan as $d)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $d->namatarif }}</td>
                                        <td>{{ @$d->pasien_id == 0 ? 'Pasien Langsung' : @$d->nama_pasien }}</td>
                                        <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : @$d->no_rm }}</td>
                                        <td class="text-right">{{ number_format($d->total) }}</td>
                                        <td class="text-center">
                                            {{ !empty($d->cara_bayar_id) ? $d->carabayar : 'Penjualan Langsung' }}</td>
                                        <td class="text-right">{{ $d->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $d->username }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm btn-flat"
                                                onclick="detailLaporan('{{ $d->namatarif }}')"><i
                                                    class="fa fa-folder-open"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th class="text-center" colspan="8">Data lebih dari 3000 tidak bisa di tampilkan</th>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    @endif
                </div>
            @endisset


            <div class="modal fade" id="detailpenjualan">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div id="dataDetailPenjualan"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

        @section('script')
            <script type="text/javascript">
                $(function() {

                    $('#dataPenjualan').DataTable({
                        'language': {
                            "url": "/json/pasien.datatable-language.json",
                        },
                        'paging': true,
                        'lengthChange': false,
                        'searching': true,
                        'ordering': true,
                        'info': false,
                        'autoWidth': false
                    });
                });

                function detailLaporan(faktur) {
                    $('#detailpenjualan').modal('show');
                    $('.modal-title').text('Detail Penjualan No. Faktur: ' + faktur);
                    $('#dataDetailPenjualan').load('/penjualan/laporan/' + faktur)
                }
            </script>
        @endsection
