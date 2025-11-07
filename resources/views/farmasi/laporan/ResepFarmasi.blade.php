@extends('master')

@section('header')
  <h1>Farmasi <small>LAPORAN LEMBAR RESEP</small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      <form action="{{ url('farmasi/laporan-resep') }}" class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="depo" class="col-sm-3 control-label">Apotik</label>
              <div class="col-sm-9">
                <select name="jenis" class="form-control select2" style="width: 100%">
                  @if (isset($_POST['jenis']) && $_POST['jenis'] == 'TA')
                    <option value="TA" selected="true">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="2">IBS</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif (isset($_POST['jenis']) && $_POST['jenis'] == 'TI')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI" selected="true">Rawat Inap</option>
                    <option value="2">IBS</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TG')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG" selected="true">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="2">IBS</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @elseif(isset($_POST['jenis']) && $_POST['jenis'] == 'TL')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="2">IBS</option>
                    <option value="TL" selected="true">Transaksi Lain - Lain</option>
                  @elseif(isset($_POST['jenis']) && $_POST['jenis'] == '2')
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="2" selected="true">IBS</option>
                    <option value="TL">Transaksi Lain - Lain</option>
                  @else
                    <option value="TA">Rawat Jalan</option>
                    <option value="TG">Rawat Darurat</option>
                    <option value="TI">Rawat Inap</option>
                    <option value="2">IBS</option>
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
            <div class="form-group">
              <label for="user" class="col-sm-3 control-label">User</label>
              <div class="col-sm-9">
                <select name="user" class="form-control select2" style="width: 100%">
                  <option value="">[--Semua--]</option>
                  @foreach ($userFarmasi as $key => $d)
                    @if (isset($_POST['user']) && $_POST['user'] == $d->user_id)
                    <option value="{{ $d->user_id }}" selected="true">{{ baca_user($d->user_id) }}</option>
                    @else
                      <option value="{{ $d->user_id }}">{{ baca_user($d->user_id) }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
           <div class="form-group">
            <label for="kelompok_kelas" class="col-sm-3 control-label">Kelompok</label>
            <div class="col-md-9">
                <select name="kelompok_kelas" class="form-control select2" id="">
                    <option value=""> [--Semua--] </option>
                    @foreach ($kelompok_kelas as $id => $kelompok)
                    <option value="{{ $id }}">{{ $kelompok }}</option>
                    @endforeach
                </select>
            </div>
           </div>


            
          </div>
          {{--  --}}
          <div class="col-sm-6">
            {{-- <div class="form-group">
              <label for="dokter" class="col-sm-3 control-label">Obat</label>
              <div class="col-sm-9">
                <select name="obat" class="form-control select2" style="width: 100%">
                  <option value="">[--Semua--]</option>
                  @foreach (\App\Masterobat::all() as $d)
                    @if (isset($_POST['obat']) && $_POST['obat'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ @$d->nama }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ @$d->nama }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div> --}}
            <div class="form-group">
              <label for="periode" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-4 {{ $errors->has('tglAwal') ? 'has-error' :'' }}">
                <input type="text" name="tglAwal" autocomplete="off" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker">
              </div>
              <div class="col-sm-1 text-center">
                s/d
              </div>
              <div class="col-sm-4 {{ $errors->has('tglAkhir') ? 'has-error' :'' }}">
                <input type="text" name="tglAkhir" autocomplete="off" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" name="submit" value="lanjut" class="btn btn-primary btn-flat">VIEW</button>
                <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat">EXCEL</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="row">
          <div class="col-sm-12">
            {{-- <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed"> --}}
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                  <thead>
                 {{-- <thead class="bg-primary"> --}}
                  <tr>
                    <th style="vertical-align: middle;" class="text-center">No</th>
                    <th style="vertical-align: middle;" class="text-center">No Resep</th>
                    <th style="vertical-align: middle;" class="text-center">Nama User</th>
                    <th style="vertical-align: middle;" class="text-center">Nama Pasien</th>
                    <th style="vertical-align: middle;" class="text-center">No. RM</th>
                    <th style="vertical-align: middle;" class="text-center">Baru / Lama</th>
                    <th style="vertical-align: middle;" class="text-center">JK</th>
                    <th style="vertical-align: middle;" class="text-center">Ruang/Poli</th>
                    <th style="vertical-align: middle;" class="text-center">Cara Bayar</th>
                    <th style="vertical-align: middle;" class="text-center">Tanggal</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @if (isset($data) && !empty($data))
                    @foreach ($data as $no => $d)
                      @php
                        $reg = \Modules\Registrasi\Entities\Registrasi::select('poli_id','status_reg')->where('id', $d->registrasi_id)->first();
                        $irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
                        $pasien = \Modules\Pasien\Entities\Pasien::select('nama', 'no_rm', 'kelamin')->where('id', $d->pasien_id)->first();
                        $detail = \App\Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();
                      @endphp
                      <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td>

                          @if (isset($d->gudang_id)) 
                            {{ str_replace("FRI","FRO", $d->no_resep) }};
                          @else 
                            {{ $d->no_resep }};
                          @endif

                        </td>
                        <td>{{ baca_user($d->user_id) }}</td>
                        <td>{{ @$pasien->nama }}</td>
                        <td>{{ @$pasien->no_rm }}</td>
                        <td>
                          @if ($d->jenis_pasien == '1')
                            Baru
                          @else
                            Lama
                          @endif
                        </td>
                        <td>{{ @$pasien->kelamin }}</td>
                        <td>
                          @if(substr(@$reg->status_reg, 0, 1) == 'G' || substr(@$reg->status_reg, 0, 1) == 'I')
                          {{ $irna ? baca_kamar($irna->kamar_id) : NULL }}
                          @else
                          {{ baca_poli(@$reg->poli_id) }}
                          @endif
                        </td>
                        <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                        <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                       
                        {{-- <td>
                          @if ($detail)
                            <ol>
                            @foreach ($detail as $r)
                              <li>{{ \App\Masterobat::select('id', 'nama')->where('id', $r->masterobat_id)->first()->nama }} ({{ $r->jumlah }})</li>
                            @endforeach
                            </ol>
                          @endif
                        </td> --}}
                        {{-- <td class="text-right">{{ number_format($d->hargajualtotal) }}</td> --}}
                      </tr>
                    @endforeach
                  @endif

                </tbody>
              
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
