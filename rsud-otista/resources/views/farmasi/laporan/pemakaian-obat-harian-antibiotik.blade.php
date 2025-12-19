@extends('master')
@section('header')
  <h1>Laporan<small></small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        <h4>Laporan Pemakaian Obat Antibiotik</h4>
        </div>
        <div class="box-body">
            <form action="{{ url('farmasi/laporan/pemakaian-obat-harian-antibiotik') }}" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="row">
                <div class="col-sm-6">
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
                <label for="depo" class="col-sm-3 control-label">Kamar</label>
                    <div class="col-sm-9">
                        <select name="kamar" class="form-control select2" style="width: 100%">
                            @foreach ($kamar as $id => $nama)
                                <option value="{{$id}}" {{@$filter_kamar == $id ? 'selected' : ''}}>{{$nama}}</option>
                            @endforeach
                        </select>
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
            </div>
        </form>
    </div>
</div>
<div class="box box-success">
    <div class="box-header with-border">
    <div class="box-body">
        <div class="table-responsive">
            <br>
            <h3 class="box-title">Detail List Pemakaian Obat Antibiotik</h3>
            <table class="table table-bordered table-striped" border="1" id="data">
                <thead class="bg-olive">
                <tr>
                    <th>Pasien</th>
                    <th>No RM</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Diagnosa</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Lama Perawatan (Hari)</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                    @if (!empty($pemakaian))
                        @foreach ($pemakaian as $key => $d)
                        <tr>
                            <td>{{ baca_pasien(@$d->pasien_id) }}</td>
                            <td>{{ @$d->no_rm }}</td>
                            <td>{{ hitung_umur(@$d->tgllahir) }}</td>
                            <td>{{ @$d->kelamin }}</td>
                            <td>{{ baca_icd10(@$d->diagnosa_inap ?? $d->diagnosa_awal) }}</td>
                            <td>{{ @$d->tgl_masuk }}</td>
                            <td>{{ @$d->tgl_keluar }}</td>
                            <td>
                                @php
                                    $tglmasuk = Carbon\Carbon::parse(@$d->tgl_masuk);
                                    $tglkeluar = Carbon\Carbon::parse(@$d->tgl_keluar);

                                    if ($d->tgl_keluar) {
                                        $jumlahHari = $tglmasuk->diffInDays($tglkeluar);
                                    } else {
                                        $jumlahHari = '-';
                                    }
                                @endphp
                                {{$jumlahHari}}
                            </td>
                            <td>{{ baca_obat(@$d->obat) }}</td>
                            <td>{{ @$d->jumlah }}</td>
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
