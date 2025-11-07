@extends('master')

@section('header')
  <h1>Logistik - Peminjaman Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Peminjaman Obat
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal" action="{{ route('simpan-rincian-pinjam-obat') }}">
          {{ csrf_field() }}
          <input type="hidden" value="{{ $pinjamobat->id }}" name="pinjamobat_id">
          <input type="hidden" value="{{ $pinjamobat->nomorberitaacara }}" name="nomorberita">
          <input type="hidden" value="{{ App\Rstujuanpinjam::where('id', $pinjamobat->id)->first()->nama }}" name="pinjamdari">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="jenis_pengadaan" class="col-sm-4 control-label">Nomor Berita Acara</label>
                <div class="col-sm-8">
                  <input type="text" name="nomorberita" value="{{ $pinjamobat->nomorberitaacara }}" id="" class="form-control" disabled>
                </div>
              </div>
              <div class="form-group">
                <label for="jenis_pengadaan" class="col-sm-4 control-label">Pinjam Dari</label>
                <div class="col-sm-8">
                  <input type="text" name="nomorberita" id="" value="{{ $pinjamobat->pinjam_dari }}" class="form-control" disabled>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ $pinjamobat->tgl_pinjam }}" name="tanggal" class="form-control datepicker" disabled>
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>
            </div>
          </div>
          {{-- DETAIL PO --}}
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Nomor Batch</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Expired Date</th>
                      <th>Harga Beli</th>
                      <th>Harga Jual</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 10%">
                        <select name="masterobat_id" onchange="setSatuan()" class="form-control select2" style="width: 100%">
                          <option value="">[ -- ]</option>
                          @foreach ($masterobat as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | Rp. {{ number_format($d->hargajual) }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td style="width: 10%" class="kolomJumlah"><input type="text" name="nomorbatch" class="form-control"></td>
                      <td style="width: 10%" class="kolomJumlah"><input type="number" name="jumlah" class="form-control"></td>
                      <td style="width: 15%">
                        <select name="satuan"  class="form-control select2" style="width: 100%;" readonly>
                          <option value="">[ -- ]</option>
                          @foreach ($satuan as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td style="width: 15%">
                        <input type="text" name="expired" value="" class="form-control datepicker">
                      </td>
                      <td style="width: 15%">
                        <input type="number" name="hargabeli" value="" class="form-control">
                      </td>
                      <td style="width: 15%">
                        <input type="number" name="hargajual" value="" class="form-control">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
                        <button type="submit" class="btn btn-primary btn-flat pull-right">
                          Simpan
                      </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </form>
    </div>
  </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
             Data Obat
        </h3>
      </div>
      <div class="box-body">
            {{-- DETAIL PO --}}
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nomor Batch</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Expired Date</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Hapus</th>
                      </tr>
                    </thead>
                    @isset($rincian)
                      <tbody>
                        @foreach ($rincian as $i)
                        @php
                            $batch = App\LogistikBatch::where('id', $i->logistik_batch_id)->first();
                        @endphp
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ baca_obat($i->masterobat_id) }}</td>
                            <td>{{ $batch->nomorbatch }}</td>
                            <td>{{ $i->jumlah }}</td>
                            <td>{{ $batch->satuanbeli_id }}</td>
                            <td>{{ $batch->expireddate }}</td>
                            <td>{{ number_format($batch->hargabeli) }}</td>
                            <td>{{ number_format($batch->hargajual_umum) }}</td>
                            <td><a href="{{ url('hapus-pinjam-obat/'.$i->id) }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-icon fa-trash"></i> </a></td>
                          </tr>
                        @endforeach
                      </tbody>
                    @endisset
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
