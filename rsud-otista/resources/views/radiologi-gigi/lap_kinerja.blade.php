@extends('master')

@section('header')
  <h1>Laporan Kinerja Radiologi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
       <div class="row">
        <form action="{{ url('radiologi-gigi/laporan-kinerja') }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pelayanan" class="col-sm-3 control-label">Pelayanan</label>
                <div class="col-sm-9">
                  <select name="pelayanan" class="form-control select2" style="width: 100%">
                    @if (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TA')
                      <option value="">Semua</option>
                      <option value="TA" selected="true">Rawat Jalan</option>
                      <option value="TI">Rawat Inap</option>
                      <option value="TG">Rawat Darurat</option>
                    @elseif (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TI')
                      <option value="">Semua</option>
                      <option value="TA">Rawat Jalan</option>
                      <option value="TI" selected="true">Rawat Inap</option>
                      <option value="TG">Rawat Darurat</option>
                    @elseif (isset($_POST['pelayanan']) && $_POST['pelayanan'] == 'TG')
                      <option value="">Semua</option>
                      <option value="TA">Rawat Jalan</option>
                      <option value="TI">Rawat Inap</option>
                      <option value="TG" selected="true">Rawat Darurat</option>
                    @else
                      <option value="" selected>Semua</option>
                      <option value="TA">Rawat Jalan</option>
                      <option value="TI">Rawat Inap</option>
                      <option value="TG">Rawat Darurat</option>
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
                  <input type="text" autocomplete="off" name="tglAwal" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker">
                </div>
                <label for="periode" class="col-sm-1 control-label">s/d</label>
                <div class="col-sm-4">
                  <input type="text" autocomplete="off" name="tglAkhir" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker">
                </div>
              </div>
              <div class="form-group">
                <label for="bayar" class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                  <button type="submit" name="submit" value="lanjut" class="btn btn-primary btn-flat">LANJUT</button>
                  <button type="submit" name="submit" value="excel" class="btn btn-success btn-flat">EXCEL</button>
                </div>
              </div>
            </div>
            </div>
          </form>

        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" style="font-size:11px;">
                <thead class="bg-primary">
                  <tr>
                    <th style="vertical-align: middle;" class="text-center">No</th>
                    <th style="vertical-align: middle;" class="text-center">Nama Pasien</th>
                    <th style="vertical-align: middle;" class="text-center">No. RM</th>
                    <th style="vertical-align: middle;" class="text-center">Baru / Lama</th>
                    <th style="vertical-align: middle;" class="text-center">JK</th>
                    <th style="vertical-align: middle;" class="text-center">Ruang/Poli</th>
                    <th style="vertical-align: middle;" class="text-center">Cara Bayar</th>
                    <th style="vertical-align: middle;" class="text-center">Tanggal Last Expertise</th>
                    <th style="vertical-align: middle;" class="text-center">Tanggal Input</th>
                    <th style="vertical-align: middle;" class="text-center">Penginput</th>
                    <th style="vertical-align: middle;" class="text-center">Radiografer</th>
                    <th style="vertical-align: middle;" class="text-center">Dokter</th>
                    <th style="vertical-align: middle;" class="text-center">Pemeriksaan</th>
                    <th style="vertical-align: middle;" class="text-center">Tarif RS</th>
                  </tr>
                </thead>
                <tbody>
                  @if (isset($data) && !empty($data))
                    @foreach ($data as $d)
                      @php
                        $ekspertise = @\App\RadiologiEkspertise::where('registrasi_id', $d->registrasi_id)->orderBy('created_at', 'desc')->first();
                        $reg = \Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
                        $irna = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
                        $pasien = \Modules\Pasien\Entities\Pasien::select('nama', 'no_rm', 'kelamin')->where('id', $d->pasien_id)->first();
                     
                     @endphp
                      <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $reg->pasien->nama }}</td>
                        <td>{{ $reg->pasien->no_rm }}</td>
                        <td>
                          @if ($d->jenis_pasien == '1')
                            Baru
                          @else
                            Lama
                          @endif
                        </td>
                        <td>{{ $reg->pasien->kelamin }}</td>
                        <td>
                          @if ($d->jenis == 'TA' || $d->jenis == 'TG')
                            {{ baca_poli(@$reg->poli_id) }}
                          @elseif($d->jenis == 'TI')
                            {{ $irna ? baca_kamar($irna->kamar_id) : NULL }}
                          @endif
                        </td>
                        <td>{{ baca_carabayar($d->cara_bayar_id) }} {{@$d->registrasi->tipe_jkn}}</td>
                        <td>
                          @if (@$ekspertise->created_at == null)
                              {{ @date('d/m/Y H:i:s ',strtotime(@$ekspertise->updated_at)) }}
                          @else
                              {{-- <i>Belum Di Ekspertise</i>     --}}
                              {{ @date('d/m/Y H:i:s ',strtotime(@$ekspertise->created_at)) }}
                          @endif
                        </td>
                        <td>{{ date('d/m/Y H:i:s',strtotime($d->created_at)) }}</td>
                        <td>{{ baca_user(@$d->user_id) }}</td>
                        <td>{{ baca_pegawai(@$d->radiografer) }}</td>
                        <td>{{ baca_dokter(@$d->dokter_radiologi) }}</td>
                        <td>{{ $d->namatarif }}</td>
                        <td class="text-right">{{ number_format($d->total) }}</td>
                      </tr>
                    @endforeach
                  @endif

                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="13" class="text-right">Total Tarif</th>
                    <th class="text-right">{{ isset($total) ? number_format($total) : NULL }}</th>
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
