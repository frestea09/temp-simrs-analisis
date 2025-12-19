@extends('master')

@section('header')
  <h1>Logistik</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Penerimaan PO
      </h3>
    </div>
    <div class="box-body">
      <form class="form-horizontal" id="" method="POST">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="no_po" class="col-sm-4 control-label">Nomor PO</label>
              <div class="col-sm-8">
                <input type="text" name="no_po" value="{{ $po->no_po }}" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
              <div class="col-sm-8">
                <input type="text" name="tanggal" value="{{ tanggalPeriode($po->tanggal) }}" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="supplier" class="col-sm-4 control-label">Supplier</label>
              <div class="col-sm-8">
                <input type="text" name="supplier" value="{{ $po->supplier }}" class="form-control" readonly>
                {{-- <select name="supplierPo" id="supplierPoSelect" class="form-control select2" style="width: 100%; height: auto;">
                  <option value="">-- Supplier --</option>
                  @foreach(@$supplier as $supp)
                    <option value="{{ $supp->nama }}" {{ $supp->nama == @$po->supplier ? 'selected' : '' }}>{{ $supp->nama }}</option>
                  @endforeach
                </select> --}}
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-center" style="vertical-align: middle;">No Faktur</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Barang</th>
                    <th class="text-center" style="vertical-align: middle;">Jumlah Diterima</th>
                    <th class="text-center" style="vertical-align: middle;">Satuan</th>
                    <th class="text-center" style="vertical-align: middle;">Terima</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $d)
                     @php
                        $obat = $obats->where('nama', $d->nama)->first();
                     @endphp
                    <tr>
                      <td>{{ $d->no_faktur }}</td>
                      <td>{{ $d->nama }}</td>
                      <td class="text-center">
                        {{ $d->jumlah_diterima }}
                      </td>
                      <td>{{ $d->satuan }}</td>
                      <td>
                        <button type="button" onclick="addBatch( {{ @$obat->id }}, {{$d->id}} )" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-plus"></i> MASUKKAN BATCH</button>
                        @if ($batches->where('bapb_id', $d->id)->first())
                            <button type="button" onclick="showBatch({{$d->id}})" class="btn btn-default btn-flat"> <i class="fa fa-icon fa-eye"></i>  {{ $batches->where('bapb_id', $d->id)->sum('jumlah_item_diterima') }}</button>
                        @else
                            <button type="button" class="btn btn-default btn-flat"> <i class="fa fa-icon fa-eye"></i> 0</button>
                        @endif
                        {{-- <a type="button" href="{{ url('/logistikmedik/penerimaan/get-item-po/'.$po->id_po.'/'.baca_faktur($d->no_faktur).'/'.Request::segment(4)) }}" class="btn btn-primary btn-flat"><i class="fa fa-check"></i></a> --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="13" class="text-right">
                      <a href="{{ url('logistikmedik/penerimaan') }}" class="btn btn-default btn-flat">KEMBALI</a>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Penerimaan PO
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr class="bg-primary">
                  <th class="text-center" style="vertical-align: middle;">No Faktur</th>
                  <th class="text-center" style="vertical-align: middle;">Nama Barang</th>
                  <th class="text-center" style="vertical-align: middle;">Jumlah Dikirim</th>
                  <th class="text-center" style="vertical-align: middle;">Batch</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($list_penerimaan as $d)
                  <tr>
                    <td>{{ $d->no_faktur }}</td>
                    <td>{{ $d->masterobat_id }}</td>
                    
                    <td>{{ $d->terima }}</td>
                    <td>{{ $d->batch }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="13" class="text-right">
                    <a href="{{ url('logistikmedik/penerimaan') }}" class="btn btn-default btn-flat">KEMBALI</a>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> --}}

  {{-- <div class="modal fade" id="modalPenerimaan"> --}}
  <div class="modal fade" id="addBatch">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formPenerimaanPO" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}

            <input type="hidden" name="bapb_id">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="namaBarang" class="col-sm-4 control-label">Nama Barang</label>
                  <div class="col-sm-8">
                    <input type="text" name="namaBarang" value="" readonly="true" class="form-control">
                    <input type="hidden" name="masterobat_id" value="">
                     <input type="hidden" name="url" value="{{Request::segment(4)}}">
                  </div>
                </div>
                <div class="form-group">
                 <label for="batch_no" class="col-sm-4 control-label">No. Batch</label>
                 <div class="col-sm-8">
                   <input type="text" name="batch" value="" class="form-control" required="true">
                 </div>
               </div>
               <div class="form-group">
                 <label for="expired_date" class="col-sm-4 control-label">Expired Date</label>
                 <div class="col-sm-8">
                   <input type="text" name="expired" value=""  autocomplete="off" required="true" class="form-control datepicker">
                 </div>
               </div>
               <div class="form-group">
                <label for="jatuh_tempo" class="col-sm-4 control-label">Jatuh Tempo</label>
                <div class="col-sm-8">
                  <input type="text" name="jatuh_tempo" value="{{@$tgl_jth_tempo}}"  autocomplete="off" required="true" class="form-control datepicker">
                </div>
              </div>
               <div class="form-group">
                <label for="tgl_bayar" class="col-sm-4 control-label">Tgl.Bayar</label>
                <div class="col-sm-8">
                  <input type="text" name="tgl_bayar" value="{{@$tgl_jth_tempo}}"  autocomplete="off" required="true" class="form-control datepicker">
                </div>
              </div>
              <div class="form-group groupPembayaran">
                <label for="diterima" class="col-sm-4 control-label">Cara Bayar</label>
                <div class="col-sm-8">
                  <select name="jenis_pembayaran" class="form-control" >
                    <option value="1">Cash</option>
                    <option value="2" selected>Faktur</option>
                  </select>
                  {{-- <input type="text" name="terima" value="" data-max="" class="form-control" required="true"> --}}
                  <small class="text-danger errorDiterima"></small>
                </div>
                {{-- <label for="satuan" class="col-sm-2 control-label">Jenis.Brg</label>
                <div class="col-sm-3">
                  <select name="jenis_obat" class="form-control" >
                    <option value="1">JKN</option>
                    <option value="2">Umum</option>
                  </select>
                </div> --}}
              </div>
               <div class="form-group groupDiterima">
                <label for="diterima" class="col-sm-4 control-label">Jml.Box</label>
                <div class="col-sm-3">
                  <input type="text" name="terima" value="" data-max="" class="form-control terima" required="true">
                  <small class="text-danger errorDiterima"></small>
                </div>
                <label for="satuan" class="col-sm-2 control-label">Isi</label>
                <div class="col-sm-3">
                  <input type="number" name="satuan" value="" class="form-control satuan">
                </div>
              </div>
               
                <div class="form-group">
                  <label for="jml_satuan" class="col-sm-4 control-label">Jml.Satuan</label>
                  <div class="col-sm-8">
                    <input type="text" name="jml_satuan" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="no_po" class="col-sm-4 control-label">No. PO</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_po" value="" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal" class="col-sm-4 control-label">Tanggal PO</label>
                  <div class="col-sm-8">
                    <input type="text" name="tanggal" value="" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="supplier" class="col-sm-4 control-label">Supplier</label>
                  <div class="col-sm-8">
                    <input type="text" name="supplier" value="" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="no_faktur" class="col-sm-4 control-label">No. Faktur</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_faktur" value="" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal_penerimaan" class="col-sm-4 control-label">Tanggal Faktur</label>
                  <div class="col-sm-8">
                    <input type="text" name="tanggal_penerimaan" value="{{ date('d-m-Y') }}" class="form-control datepicker" readonly>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="jumlah_total" class="col-sm-4 control-label">Jumlah Total</label>
                  <div class="col-sm-8">
                    <input type="text" name="jumlah_total" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="hna_lama" class="col-sm-4 control-label">HNA Lama</label>
                  <div class="col-sm-8">
                    <input type="text" name="hna_lama" onkeyup="kalkulasi()" value="" class="form-control uang">
                  </div>
                </div>
                <div class="form-group">
                  <label for="hna" class="col-sm-4 control-label">HNA Baru</label>
                  <div class="col-sm-8">
                    <input type="text" name="hna" value="" class="form-control uang hna">
                  </div>
                </div>
                <div class="form-group">
                  <label for="jml_total" class="col-sm-4 control-label">Total</label>
                  <div class="col-sm-8">
                    <input type="text" name="jml_total" value="" placeholder="HNA Baru x Jml.Box" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="diskon" class="col-sm-4 control-label">Diskon</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      <input type="text" name="diskon_persen" onkeyup="diskonPersen()" value="" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="diskon_rupiah" onkeyup="diskonRupiah()" value="" class="form-control uang">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="total_hna" class="col-sm-4 control-label">Total HNA</label>
                  <div class="col-sm-8">
                    <input type="text" name="total_hna" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="ppn" class="col-sm-4 control-label">PPN</label>
                  <div class="col-sm-8">
                    <input type="text" name="ppn" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="hpp" class="col-sm-4 control-label">HPP</label>
                  <div class="col-sm-8">
                    <input type="text" name="hpp" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="harga_jual" class="col-sm-4 control-label">Harga Keseluruhan</label>
                  <div class="col-sm-8">
                    <input type="text" name="harga_jual" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="harga_jual" class="col-sm-4 control-label">Harga Dari Faktur</label>
                  <div class="col-sm-8">
                    <input type="number" name="harga_jual_faktur" step="any" id="currency"  value="" class="form-control currency" placeholder="contoh : 9000.65">
                    <small>Jika menulis "Koma" gunakan ' . '</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="harga_jual_satuan" class="col-sm-4 control-label">Harga Jual Umum ( Satuan )</label>
                  <div class="col-sm-8">
                    <input type="text" name="harga_jual_satuan" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="harga_jual_jkn" class="col-sm-4 control-label">Harga Jual JKN <br/>( Satuan )</label>
                  <div class="col-sm-8">
                    <input type="text" name="harga_jual_jkn" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
                  <div class="col-sm-8">
                    <input type="text" name="keterangan" value="" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <span  style="color:red" class="pull-left"><b><i>* Semua form wajib diisi</i></b></span>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="savePenerimaan()">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- detailbacth --}}
  <div class="modal fade" id="showBatch">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4> <h4 class="modal-total"></h4>
        </div>
        <div class="modal-body">
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Nomer Faktur</th>
                <th>Nomer Batches</th>
                <th>Nama Obat</th>
                <th>Expired Date</th>
                <th>Jumlah Diterima</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
              </tr>
            </thead>
            <tbody class="listBatches">
            </tbody>
          
          </table>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="simpanBatch()">Simpan</button>
        </div> --}}
      </div>
    </div>
  </div>

  {{-- <div class="modal fade" id="addBatch"> --}}
    <div class="modal fade" id="add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form id="formBatch" method="post" class="form-horizontal">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id" value="">
              <input type="hidden" name="masterobat_id" value="">

              <div class="form-group nipGroup">
                <label for="nama_obat" class="col-sm-3 control-label">Nama Obat</label>
                <div class="col-sm-9">
                  <input type="text" name="nama_obat" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group nipGroup">
                <label for="satuanbeli_id" class="col-sm-3 control-label">Satuan Beli</label>
                <div class="col-sm-9">
                  <select name="satuanbeli_id" class="form-control select2" style="width: 100%">
                    @foreach ($satuanbeli as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group nipGroup">
                <label for="satuanjual_id" class="col-sm-3 control-label">Satuan Jual</label>
                <div class="col-sm-9">
                  <select name="satuanjual_id" class="form-control select2" style="width: 100%">
                    @foreach ($satuanjual as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group nipGroup">
                <label for="nomor_batch" class="col-sm-3 control-label">Nomor Batch</label>
                <div class="col-sm-9">
                  <input type="text" name="nomor_batch" class="form-control"   required>
                  <small class="text-danger nomor_batchError"></small>
                </div>
              </div>
              <div class="form-group nipGroup">
                <label for="supplier" class="col-sm-3 control-label">Supplier</label>
                <div class="col-sm-9">
                  <select name="supplier_id" class="form-control select2" style="width: 100%">
                    @foreach ($supplier as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                  <small class="text-danger supplierError"></small>
                </div>
              </div>
              <div class="form-group namaGroup">
                <label for="stok" class="col-sm-3 control-label">Stok</label>
                <div class="col-sm-9">
                  <input type="number" name="stok" class="form-control" required>
                  <small class="text-danger stokError"></small>
                </div>
              </div>
              <div class="form-group jabatanGroup">
                <label for="expired_date" class="col-sm-3 control-label">Expired Date</label>
                <div class="col-sm-9">
                  <input type="text" name="expired_date" class="form-control datepicker" autocomplete="off" required>
                  <small class="text-danger expired_dateError"></small>
                </div>
              </div>
              
              <div class="form-group jabatanGroup">
                <label for="hargabeli" class="col-sm-3 control-label">Harga Beli</label>
                <div class="col-sm-9">
                  <input type="number" name="hargabeli" class="form-control" required>
                  <small class="text-danger hargabeliError"></small>
                </div>
              </div>
              <div class="form-group jabatanGroup">
                <label for="hargajualumum" class="col-sm-3 control-label">Harga Jual Umum</label>
                <div class="col-sm-9">
                  <input type="number" name="hargajualumum" class="form-control" required>
                  <small class="text-danger hargajualumumError"></small>
                </div>
              </div>
              <div class="form-group jabatanGroup">
                <label for="hargajualjkn" class="col-sm-3 control-label">Harga Jual JKN</label>
                <div class="col-sm-9">
                  <input type="number" name="hargajualjkn" class="form-control" required>
                  <small class="text-danger hargajualjknError"></small>
                </div>
              </div>
              <div class="form-group jabatanGroup">
                <label for="hargajualdinas" class="col-sm-3 control-label">Harga Jual Dinas</label>
                <div class="col-sm-9">
                  <input type="number" name="hargajualdinas" class="form-control" required>
                  <small class="text-danger hargajualdinasError"></small>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Exit</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanBatch()">Simpan</button>
          </div>
        </div>
      </div>
  </div>



@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2()
    $('.uang').maskNumber({
      thousands: '.',
      integer: true,
    });
    // $('.currency').maskNumber("#,##0.00", {
    //   reverse: false,
    //   thousands: '.'
    // });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function prosesPenerimaan(id, no_faktur) {
    alert('no_faktur');
    $('#modalPenerimaan').modal('show')
    $('#formPenerimaanPO')[0].reset()
    $.ajax({
      url: '/logistikmedik/penerimaan/get-item-po/'+id+'/'+no_faktur,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      $('.modal-title').text('Input Penerimaan Nomor PO: '+resp.item.no_po)
      $('input[name="no_po"]').val(resp.item.no_po)
      $('input[name="tanggal"]').val(resp.item.tanggal)
      $('input[name="supplier"]').val(resp.item.supplier)
      $('input[name="no_faktur"]').val(resp.berita.no_faktur)
      $('input[name="tanggal_penerimaan"]').val(resp.berita.tanggal_faktur)
      $('input[name="masterobat_id"]').val(resp.item.masterobat_id)
      $('input[name="keterangan"]').val(resp.item.keterangan)
      $('input[name="namaBarang"]').val(resp.namaBarang.nama)
      $('input[name="hna_lama"]').val(ribuan(resp.namaBarang.hargabeli))
      $('input[name="jumlah"]').val(resp.item.sisa)
      $('input[name="satuan"]').val(resp.satuan.nama)
    });
  }

  function editPenerimaan(no_po) {
    $('#modalPenerimaan').modal('show')
    $('#formPenerimaanPO')[0].reset()
    $.ajax({
      url: '/logistikmedik/penerimaan/edit-get-item-po/'+no_po,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      $('.modal-title').text('Edit Penerimaan Nomor PO: '+resp.item.no_po)
      $('input[name="no_po"]').val(resp.item.no_po)
      $('input[name="tanggal"]').val(resp.item.tanggal)
      $('input[name="supplier"]').val(resp.item.supplier)
      $('input[name="no_faktur"]').val(resp.item.no_po)
      $('input[name="masterobat_id"]').val(resp.item.masterobat_id)
      $('input[name="keterangan"]').val(resp.item.keterangan)
      $('input[name="namaBarang"]').val(resp.namaBarang.nama)
      $('input[name="hna_lama"]').val(ribuan(resp.namaBarang.hargabeli))
      $('input[name="jumlah"]').val(resp.item.sisa)
      $('input[name="satuan"]').val(resp.satuan.nama)
      $('input[name="terima"]').val(resp.penerimaan.terima)
      $('input[name="terima"]').val(resp.penerimaan.terima)
    });
  }

  function diskonPersen() {
    var terima = $('input[name="jumlah_total"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var persen = $('input[name="diskon_persen"]').val();
    var diskon = hna * (persen/100)
    $('input[name="diskon_rupiah"]').val(ribuan(diskon))

    var total_hna = (terima * hna) - (diskon*terima)
    var ppn = parseInt(total_hna * (11/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = parseInt(hpp + (25/100 * hpp))
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(diskon))
    $('input[name="total_hna"]').val(ribuan(total_hna))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
    $('input[name="harga_jual_jkn"]').val(ribuan(harga_jual_satuan))

  }


  function diskonRupiah() {
    var cek_diskon = parseInt( $('input[name="diskon_rupiah"]').val().split('.').join("") );
    var terima = $('input[name="jumlah_total"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var rupiah = $('input[name="diskon_rupiah"]').val();
    var diskon = rupiah/hna * 100
    $('input[name="diskon_persen"]').val(diskon)


    var total_hna = (terima * hna) - (cek_diskon * terima)
    var ppn = parseInt(total_hna * (11/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = parseInt(hpp + (28/100 * hpp))
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(cek_diskon))
    $('input[name="total_hna"]').val(ribuan(total_hna))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
    $('input[name="harga_jual_jkn"]').val(ribuan(harga_jual_satuan))
  }

  function kalkulasi() {
    var diskon = parseInt( $('input[name="diskon_rupiah"]').val().split('.').join("") );
    var terima = $('input[name="jumlah_total"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )

    var total_hna = (terima * hna) - ( diskon * terima)
    var ppn = parseInt(total_hna * (11/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = hpp + (10/100 * hpp) //margin harga
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(diskon))
    $('input[name="total_hna"]').val(total_hna.toFixed(2))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
    $('input[name="harga_jual_jkn"]').val(ribuan(harga_jual_jkn))
  }

  $('#supplierPoSelect').on('change', function() {
    var supp = $(this).val();
    var noPo = $('input[name="no_po"]').val();

    var data = {
      '_token': $('meta[name="csrf-token"]').attr('content'),
      'supplier': supp,
      'noPo': noPo,
    };

    $.ajax({
      url: '/logistikmedik/penerimaan/editPenerimaan',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(res) {
      if(res.code == 200){
        location.reload()
        return alert('Sukses: '+ res.message);
      }
    })
    .fail(function (jqXHR, textStatus, error) {
      return alert(jqXHR.responseText);
    });
  });

  function savePenerimaan() {
    
    var data = $('#formPenerimaanPO').serialize()
    $.ajax({
      url: '/logistikmedik/penerimaan/savePenerimaan',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(json) {
      if(json.sukses == false){
        if (json.error.diterima) {
          $('.groupDiterima').addClass('has-error')
          $('.errorDiterima').text(json.error.diterima[0])
        }

      }

      if (json.sukses == true) {
        $('#formPenerimaanPO')[0].reset();
        alert('Penerimaan berhasil di simpan!');
        location.reload();
      }
    });

  }
  // validate jumlah
  $(document).on('keyup change',"input.terima", function(){
    // let id = $(this).attr('id');
    let max = $(this).attr('data-max');
    console.log(max)
    $("input[name='terima']").attr('style','');
    if( parseInt(max) < parseInt(this.value) ){
      alert('Pengiriman Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='terima']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='terima']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
    }
  })

  // validate jumlah satuan
  $(document).on('keyup change',"input.satuan", function(){
    let max = parseInt($("input[name='terima']").val()) * parseInt(this.value);
    $("input[name='jml_satuan']").val(max); 
  })
  
  // validate hna baru x jumlah box
  $(document).on('keyup change',"input.hna", function(){
    let max = parseInt($("input[name='terima']").val()) * parseInt(this.value.split('.').join(""));
    // console.log(max)
    $("input[name='jml_total']").val(ribuan(max)); 
  })

  
  function addBatch(masterobat_id, id) {
    $('#formBatch')[0].reset();
    status = 0
    $('#addBatch').modal('show')
    $.get('/logistikmedik/namaObatBatch/'+masterobat_id+'/'+id, function(resp){
      $('.modal-title').text('Tambah Batch '+resp.obat.nama)
      $("input[name='bapb_id']").val(resp.berita_acara.id);
      $("input[name='masterobat_id']").val(resp.obat.id);
      $("input[name='namaBarang']").val(resp.obat.nama);
      $("input[name='hna_lama']").val(resp.obat.hargabeli);
      $('select[name="supplier_id"]').val(resp.obat.supplier_id).trigger('change')
      $('select[name="satuanbeli_id"]').val(resp.obat.satuanbeli_id).trigger('change')
      $('select[name="satuanjual_id"]').val(resp.obat.satuanjual_id).trigger('change')
      // $("input[name='satuan']").val(resp.beli);
      $("input[name='terima']").val(resp.berita_acara.jumlah_diterima);
      $("input[name='no_po']").val(resp.berita_acara.no_po);
      $("input[name='supplier']").val(resp.berita_acara.saplier);
      $("input[name='no_faktur']").val(resp.berita_acara.no_faktur);
      $("input[name='tanggal_faktur']").val(resp.berita_acara.tanggal_faktur);
      $("input[name='jumlah']").val(resp.berita_acara.kondisi);
      $('input[name="jumlah_total"]').val(resp.berita_acara.jumlah_diterima)
      $("input[name='tanggal']").val(resp.po.tanggal);
      $("input[name='terima']").attr('data-max',resp.berita_acara.jumlah_diterima);
    })
  }
  

  function showBatch(id) {
    $('#showBatch').modal('show')
    $.get('/logistikmedik/penerimaan/list-batches/'+id, function(resp){
      $('.modal-title').text('Nomor Batch '+resp.nomer_batch.nomorbatch)
      $('.modal-total').text('Jumlah Diterima : '+resp.jumlah)
      $('.listBatches').empty();
    $.each(resp.batches, function(index, val) {
      var row = '<tr>' +
        '<td>'+ resp.bapb.no_faktur+'</td>' +
        '<td>'+val.nomorbatch + '</td>' +
        '<td>' + val.nama_obat + '</td>' +
        '<td>' + val.expireddate + '</td>' +
        '<td><input class="form-control" value="' + val.jumlah_item_diterima + '" name="jumlah_batch" type="number"></td>' +
        '<td><input class="form-control" value="' + val.hargabeli + '" name="hargaBeli" type="text"></td>' +
        '<td><input class="form-control" value="' + val.hargajual_jkn + '" name="hargaJual" type="text"></td>' +
        '<td><input class="form-control" name="id_batch" id="id_batch" value="' + val.id + '" type="hidden"></td>' +
        '<td><button class="btn btn-primary" data-id="' + val.id + '">Edit</button> <br> <input class="btn btn-danger" value="Hapus" type="button" data-id="' + val.id + '"></td>' +
        '<td></td>' +
        '</tr>';

          $('.listBatches').append(row);
        });

    $('.listBatches').on('click', 'button[data-id]', function() {
      var id = $(this).data('id');
      var jumlah_batch  =  $("input[name='jumlah_batch']").val()
      var hargaBeli  =  $("input[name='hargaBeli']").val()
      var hargaJual  =  $("input[name='hargaJual']").val()
      $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
      url: '/logistikmedik/penerimaan/editBatch/'+id,
      type: 'POST',
      dataType: 'json',
      data: {
        jumlah_batch:jumlah_batch,
        hargaBeli:hargaBeli,
        hargaJual:hargaJual,
      },
    })
    .done(function(json) {
        alert('Berhasil Edit!');
        location.reload();
    });
    });



    $('.listBatches').on('click', 'input[data-id]', function() {
      var id = $(this).data('id');
      $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
      url: '/logistikmedik/penerimaan/hapusBatch/'+id,
      type: 'POST',
      dataType: 'json',
    })
    .done(function(json) {
        alert('Berhasil Hapus!');
        location.reload();
    });
    });







    })
  }


  $('.tampilModalUbah').on('click', function(){
    
  })




  // function editBatch(){
  //   var id_batch =  $("input[name='id_batch']").val()
  //   var jumlah_batch  =  $("input[name='jumlah_batch']").val()
  //   var data = $('.listBatches').serialize()
  //   $.ajax({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //      },
  //     url: '/logistikmedik/penerimaan/editBatch/'+id_batch,
  //     type: 'POST',
  //     dataType: 'json',
  //     data: {
  //       jumlah_batch:jumlah_batch
  //     },
  //   })
  //   .done(function(json) {
  //     if(json.sukses == false){
  //       if (json.error.diterima) {
  //         $('.groupDiterima').addClass('has-error')
  //         $('.errorDiterima').text(json.error.diterima[0])
  //       }

  //     }

  //     if (json.sukses == true) {
  //       alert('Berhasil Edit!');
  //       location.reload();
  //     }
  //   });


  // }
  


</script>
@endsection