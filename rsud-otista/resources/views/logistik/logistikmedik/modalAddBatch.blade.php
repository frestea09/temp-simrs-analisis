<div class="modal fade" id="addBatch">
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
                  <input type="text" name="expired_date" class="form-control datepicker" required>
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
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanBatch()">Simpan</button>
          </div>
        </div>
      </div>
  </div>
