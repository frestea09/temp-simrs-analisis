<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">{{ $nama_obat }}</h4>
  <div class="table-responsive">
    <table class="table table-hover table-bordered table-condensed">
      <tbody>
        <tr>
          <td>Jumlah Permintaan</td>
          <td>: <b>{{ $jumlah_permintaan->jumlah_permintaan }}</b></td>
        </tr>
        <tr>
          <td>Sisa Stok di {{ baca_gudang_logistik($permintaan->gudang_tujuan) }}</td>
          <td>: <b> {{ $stok_pusat }}</b></td>
        </tr>
        <tr>
          <td>Total Stok di {{ baca_gudang_logistik($permintaan->gudang_asal) }}</td>
          <td>: <b> {{ $permintaan->sisa_stock }}</b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-body">
  <form id="formDetailKirim" method="post" class="form-horizontal">
      {{ csrf_field() }} {{ method_field('POST') }}
      <input type="hidden" name="masterobat_id" value="{{ $permintaan->masterobat_id }}">
      <input type="hidden" name="gudang_asal" value="{{ $permintaan->gudang_asal }}">
      <input type="hidden" name="gudang_tujuan" value="{{ $permintaan->gudang_asal }}">
      <input type="hidden" name="nomor_permintaan" value="{{ $permintaan->nomor }}">
      <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed" id="data">
          <thead>
              <tr>
                  <th>Nomor Batch</th>
                  <th>Expired Date</th>
                  <th>Stok</th>
                  <th style="width: 100px;">Dikirim</th>
                  <th style="width: 100px;"></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($batches as $d)
              <tr>
                  <th>{{ $d->nomorbatch }}</th>
                  <th>{{ $d->expireddate }}</th>
                  <th>{{ $d->stok }}</th>
                  <th style="width: 100px;">
                      <input type="number" min="0" max="" name="jumlah_dikirim{{ $d->id }}" class="form-control"></th>
                  <th style="width: 100px;"><button type="button" onclick="saveDetailTransfer({{ $d->id }})" class="btn btn-primary btn-flat pull-right"> <i class="fa fa-icon fa-send"></i> KIRIM</button></th>
              </tr>
              @endforeach
          </tbody>
          </table>
      </div>
  </form>
</div>
