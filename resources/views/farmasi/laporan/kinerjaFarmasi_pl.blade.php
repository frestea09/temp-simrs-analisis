@extends('master')

@section('header')
  <h1>Farmasi <small>LAPORAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      <form action="{{ url('farmasi/laporan-kinerja') }}" class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="depo" class="col-sm-3 control-label">Depo</label>
              <div class="col-sm-9">
                <select name="jenis" class="form-control select2" style="width: 100%">
                  @if (isset($_POST['jenis']) && $_POST['jenis'] == 'TA')
                    <option value="TA" selected="true">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif (isset($_POST['jenis']) && $_POST['jenis'] == 'TI')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI" selected="true">Rawat Inap</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TG')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG" selected="true">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TL')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="TL" selected="true">Transaksi Lain - Lain</option>
                  @else
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="depo" class="col-sm-3 control-label">Bayar</label>
              <div class="col-sm-9">
                <select name="cara_bayar_id" class="form-control select2" style="width: 100%">
                  @foreach (\Modules\Registrasi\Entities\Carabayar::all() as $d)
                    @if (isset($_POST['cara_bayar_id']) && $_POST['cara_bayar_id'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ $d->carabayar }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          {{--  --}}
          <div class="col-sm-6">
            <div class="form-group">
              <label for="dokter" class="col-sm-3 control-label">Dokter</label>
              <div class="col-sm-9">
                <select name="dokter" class="form-control select2" style="width: 100%">
                  @foreach (\Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="periode" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-4 {{ $errors->has('tglAwal') ? 'has-error' :'' }}">
                <input type="text" name="tglAwal" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker">
              </div>
              <div class="col-sm-1 text-center">
                s/d
              </div>
              <div class="col-sm-4 {{ $errors->has('tglAkhir') ? 'has-error' :'' }}">
                <input type="text" name="tglAkhir" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" name="submit" class="btn btn-primary btn-flat">VIEW</button>
                <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat">EXCEL</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead class="bg-primary">
                  <tr>
                    <th style="vertical-align: middle;" class="text-center">No</th>
                    <th style="vertical-align: middle;" class="text-center">Nama</th>
                    <th style="vertical-align: middle;" class="text-center">Tanggal</th>
                    <th style="vertical-align: middle;" class="text-center">Dokter</th>
                    <th style="vertical-align: middle;" class="text-center">Obat</th>
                    <th style="vertical-align: middle;" class="text-center">User</th>
                    <th style="vertical-align: middle;" class="text-center">Tarif RS</th>
                  </tr>
                </thead>
                <tbody>
                  @if (isset($data) && !empty($data))
                    @foreach ($data as $d)
                      @php
                        $pasien = \App\Penjualanbebas::where('registrasi_id', $d->registrasi_id)->first();
                        $detail = \App\Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();
                      @endphp
                      <tr>
                        <td class="text-center"></td>
                        <td>{{ $pasien->nama }}</td>
                        <td>{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>{{ $pasien->dokter }}</td>
                        <td>
                          @if ($detail)
                            <ol>
                            @foreach ($detail as $r)
                              <li>{{ \App\Masterobat::find($r->masterobat_id)->nama }}</li>
                            @endforeach
                            </ol>
                          @endif
                        </td>
                        <td class="text-left">{{ baca_user($d->user_id) }}</td>
                        <td class="text-right">{{ number_format($d->total) }}</td>
                      </tr>
                    @endforeach
                  @endif

                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5" class="text-right">Total Tarif</th>
                    <th class="text-right">{{ isset($data) && !empty($data) ? number_format($data->sum('total')) : NULL }}</th>
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
