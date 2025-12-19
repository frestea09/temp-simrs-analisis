@extends('master')

@section('header')
  <h1>Laporan <small>PEMAKAIAN OBAT HARIAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      <form action="{{ url('farmasi/laporan/pemakaian-obat-harian') }}" class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-sm-6">
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
            {{-- <div class="form-group">
              <label for="depo" class="col-sm-3 control-label">Jenis</label>
              <div class="col-sm-9">
                <select name="cara_bayar_id" class="form-control select2" style="width: 100%">
                    <option value="">[--Semua--]</option>
                    @foreach (\Modules\Registrasi\Entities\Carabayar::whereIn('id',['1','2'])->get() as $d)
                    @if (isset($_POST['cara_bayar_id']) && $_POST['cara_bayar_id'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ $d->carabayar }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div> --}}
          </div>
          {{--  --}}
          <div class="col-sm-6">
            <div class="form-group">
              {{-- <label for="dokter" class="col-sm-3 control-label">Dokter</label> --}}
              <div class="col-sm-9">
                {{-- <select name="dokter" class="form-control select2" style="width: 100%">
                  <option value="">[--Semua--]</option>
                  @foreach (\Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                    @if (isset($_POST['dokter']) && $_POST['dokter'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endif
                  @endforeach
                </select> --}}
              </div>
            </div>
            <div class="form-group">
              <label for="periode" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-4 {{ $errors->has('tglAwal') ? 'has-error' :'' }}">
                <input type="text" name="tglAwal" autocomplete="off" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker" required>
              </div>
              <div class="col-sm-1 text-center">
                s/d
              </div>
              <div class="col-sm-4 {{ $errors->has('tglAkhir') ? 'has-error' :'' }}">
                <input type="text" name="tglAkhir" autocomplete="off" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" name="submit" value="lanjut" class="btn btn-primary btn-flat">VIEW</button>
                <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat">EXCEL</button>
                <a href="/farmasi/laporan/pemakaian-obat-harian" class="btn btn-default btn-flat fa-file-pdf" > REFRESH </a>
              </div>
            </div>
          </div>
        </div>
      </form>
     
      @if (isset($pemakaian) && !empty($pemakaian))
      <b>Periode : Tgl {{ $tgl1 }}   s/d  {{ $tgl2 }}</b>
      @endif
      <br/><br/>
      <div class="row">
          <div class="col-sm-12">
            {{-- <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed"> --}}
                <div class='table-responsive'>
                  <table class='table table-striped table-bordered table-hover table-condensed' id='data' style="font-size:12px;">
                {{-- <thead class="bg-primary"> --}}
                  <thead>
                  <tr>
                    <th style="vertical-align: middle;" class="text-center">No</th>
                    <th style="vertical-align: middle;" class="text-center">Obat(Batch)</th>
                    <th style="vertical-align: middle;" class="text-center">Satuan</th>
                    <th style="vertical-align: middle;" class="text-center">Keluar (Pemakaian)</th>
                    <th style="vertical-align: middle;" class="text-center">Masuk</th>
                    <th style="vertical-align: middle;" class="text-center">Harga (item)</th>
                    <th style="vertical-align: middle;" class="text-center">Jumlah Harga (Rp.)</th>
                    <th style="vertical-align: middle;" class="text-center">Sisa (item)</th>
                    <th style="vertical-align: middle;" class="text-center">Expired</th>
                    {{-- <th style="vertical-align: middle;" class="text-center">Keterangan</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @if (isset($pemakaian) && !empty($pemakaian))
                    @foreach ($pemakaian as $no => $d)
                      {{-- @php
                        $reg = \Modules\Registrasi\Entities\Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
                        $irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
                        $pasien = \Modules\Pasien\Entities\Pasien::select('nama', 'no_rm', 'kelamin')->where('id', $d->pasien_id)->first();
                        $detail = \App\Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();
                      @endphp --}}
                      <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td>{{ @$d->master_obat->nama }} ({{@$d->logistik_batch->nomorbatch}})</td>
                        <td>{{ @baca_satuan_jual($d->master_obat->satuanjual_id) }}</td>
                        <td>{{ @$d->keluar }}</td>
                        <td>{{ @$d->masuk }}</td>
                        <td>{{ @number_format($d->logistik_batch->hargajual_umum) }}</td>
                        <td>{{ @number_format($d->logistik_batch->hargajual_umum*$d->keluar) }}</td>
                        <td>{{ @$d->total }}</td>
                        <td>{{ date('d-m-Y',strtotime(@$d->logistik_batch->expireddate)) }}</td>
                        {{-- <td>{{ @$d->keterangan }}</td> --}}
                      </tr>
                    @endforeach
                  @endif

                </tbody>
                <tfoot>
                    <tr>
                      <th colspan="8" class="text-right">Total Harga Jual</th>
                      <th class="text-right">{{ isset($pemakaian) && !empty($pemakaian) ? number_format($pemakaian->sum('hargajual')) : NULL }}</th>
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
