@extends('master')
@section('header')
  <h1>Laporan<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        <h4>Laporan Pemakaian Obat Narkotika</h4>
        </div>
        <div class="box-body">
            <form action="{{ url('farmasi/laporan/pemakaian-obat-harian-narkotika') }}" class="form-horizontal" role="form" method="POST">
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
                            <input type="text" autocomplete="off" name="tgl_awal" value="{{ isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('d-m-Y') }}" class="form-control datepicker">
                        </div>
                        <div class="col-sm-1 text-center">
                            s/d
                        </div>
                        <div class="col-sm-4 {{ $errors->has('tgl_akhir') ? 'has-error' :'' }}">
                            <input type="text"  autocomplete="off" name="tgl_akhir" value="{{ isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('d-m-Y') }}" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="depo" class="col-sm-3 control-label">Gudang</label>
                        <div class="col-sm-9">
                            <select name="jenis" class="form-control select2" style="width: 100%">
                            @if (isset($_POST['jenis']) && $_POST['jenis'] == 'TA')
                                <option value="">Semua</option>
                                <option value="TA" selected="true">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                                <option value="2">IBS</option>
                            @elseif (isset($_POST['jenis']) && $_POST['jenis'] == 'TI')
                                <option value="">Semua</option>
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI" selected="true">Rawat Inap</option>
                                <option value="2">IBS</option>
                            @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TG')
                                <option value="">Semua</option>
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG" selected="true">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                                <option value="2">IBS</option>
                            @elseif(isset($_POST['jenis']) && $_POST['jenis'] == '2')
                                <option value="">Semua</option>
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG" >Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                                <option value="2" selected="true">IBS</option>
                            @else
                                <option value="" selected="true">Semua</option>
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                                <option value="2">IBS</option>
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="depo" class="col-sm-3 control-label">Obat (Pilih)</label>
                        <div class="col-sm-9">
                            <select name="masterobat_id" class="form-control select2" style="width: 100%">
                             <option value="">Semua</option>
                             @foreach ($obat as $item)
                             <option value="{{$item->id}}" {{@$_POST['masterobat_id'] == $item->id ? 'selected' :''}}>{{$item->nama}}</option>
                             @endforeach
                            </select>
                            <b class="text-red">*</b> Pilih Obat jika mau mencari nama sesuai database SIMRS
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="VIEW">
                            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                            {{-- <input type="submit" name="pdf" class="btn btn-warning btn-flat fa-file-excel-o" value="PDF"> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <br/><br/><br/>
                    <div class="form-group">
                        <label for="depo" class="col-sm-3 control-label">Obat(Tulis Manual)</label>
                            <div class="col-sm-9">
                                <input name="namaobat" value="{{@$_POST['namaobat']}}" class="form-control" style="width: 100%" placeholder="Contoh : Codein">
                                <br/><b class="text-red">*</b> Tulis obat manual jika ingin mengambil data obat sesuai yang ditulis
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
                <h3 class="box-title">Detail List Pemakaian Obat Narkotika</h3>
                <table class="table table-bordered table-striped" border="1" id="data">
                    <thead class="bg-olive">
                    <tr>
                        <th>Tanggal</th>
                        <th>No.Faktur</th>
                        <th>Pasien</th>
                        <th>No RM</th>
                        <th>Alamat</th>
                        <th>Nama Dokter</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Harga Pokok</th>
                        <th>Harga Satuan</th>
                        <th>Harga Jual</th>
                        <th>Harga Jual (Jumlah)</th>
                        <th>Ruangan/Poli</th>
                        <th>Cara Bayar</th>
                        <th>User</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (!empty($pemakaian))
                            @foreach ($pemakaian as $key => $d)
                            @php
                                  $reg = \Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
                                  $total = @$d->hargajual * @$d->jumlah;
                             

                            @endphp
                          
                                
                          
                            <tr>
                                <td>{{ $d->created_at}}</td>
                                <td>
                                    @if ($d->gudang_id == 2)
                                         {{str_replace("FRI","FRO", $d->no_resep)}}
                                    @else
                                         {{ @$d->no_resep }}
                                    @endif                                
                                </td>
                                <td>{{ baca_pasien(@$reg->pasien_id) }}</td>
                                <td>{{ @$reg->pasien->no_rm }}</td>
                                <td>{{ @$reg->pasien->alamat }}</td>
                                <td>{{ baca_dokter(@$d->dokter) }}</td>
                                <td>{{ baca_obat($d->obat) }}</td>
                                <td>{{ @$d->jumlah }}</td>
                                <td>{{ number_format(@$d->hargajual) }}</td>
                                <td>{{ number_format(@$d->hargabeli) }}</td>
                                <td>{{ number_format(@$d->hargajual) }}</td>
                                <td>{{ number_format(@$total) }}</td>
                                @php
                                    $ruang = App\Rawatinap::where('registrasi_id', $reg->id)->first() 
                                @endphp
                                @if (isset($_POST['jenis']) && $_POST['jenis'] == 'TI')
                                    <td>{{ baca_kelompok(@$ruang->kelompokkelas_id) }}</td>
                                @else
                                     <td>{{ baca_poli($reg->poli_id) }} </td> 
                                @endif
                              
                                <td>{{ baca_carabayar(@$d->cara_bayar_id )}}</td>
                                <td>{{ baca_user( @$d->user_id) }}</td>
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
