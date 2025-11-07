@extends('master')

@section('header')
  <h1>Logistik Non Medik</h1>
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
          <div class="col-sm-6">
            <div class="form-group">
              <label for="no_po" class="col-sm-4 control-label">Nomor PO</label>
              <div class="col-sm-8">
                <input type="text" name="no_po" value="{{ $po->no_po }}" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
              <div class="col-sm-8">
                <input type="text" name="tanggal" value="{{ tanggalPeriode($po->tanggal) }}" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="supplier" class="col-sm-4 control-label">Supplier</label>
              <div class="col-sm-8">
                <input type="text" name="supplier" value="{{ $po->supplier }}" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-center" style="vertical-align: middle;">Nama Barang</th>
                    <th class="text-center" style="vertical-align: middle;">Jumlah</th>
                    <th class="text-center" style="vertical-align: middle;">Satuan</th>
                    <th class="text-center" style="vertical-align: middle;">Terima</th>
                    {{-- <th class="text-center" style="vertical-align: middle;">HNA</th>
                    <th class="text-center" style="vertical-align: middle;">Total HNA</th> --}}
                    {{-- <th class="text-center" style="vertical-align: middle;">Dskn (%)</th>
                    <th class="text-center" style="vertical-align: middle;">Dskn (Rp.)</th> --}}
                    {{-- <th class="text-center" style="vertical-align: middle;">PPN</th>
                    <th class="text-center" style="vertical-align: middle;">HPP</th>
                    <th class="text-center" style="vertical-align: middle;">Harga Jual</th>
                    <th class="text-center" style="vertical-align: middle;">Harga Jual @</th>
                    <th class="text-center" style="vertical-align: middle;">No. Batch</th>
                    <th class="text-center" style="vertical-align: middle;">Exp. Date</th> --}}
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $d)
                    <tr>
                      <td>{{ $d->barang->nama }}</td>
                      <td class="text-center">{{ $d->sisa }}</td>
                      <td>{{ $d->bacasatuan->nama }}</td>
                      <td></td>
                      {{-- <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td> --}}
                      <td>
                        <button type="button" onclick="prosesPenerimaan({{ $d->id_po }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check"></i></button>
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

  <div class="modal fade" id="modalPenerimaan">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formPenerimaanPO" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="no_po" class="col-sm-4 control-label">No. PO</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_po" value="" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
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
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="no_faktur" class="col-sm-4 control-label">No. Faktur</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_faktur" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal_penerimaan" class="col-sm-4 control-label">Tanggal Penerimaan</label>
                  <div class="col-sm-8">
                    <input type="text" name="tanggal_penerimaan" value="{{ date('d-m-Y') }}" class="form-control datepicker">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="namaBarang" class="col-sm-4 control-label">Nama Barang</label>
                  <div class="col-sm-8">
                    <input type="text" name="namaBarang" value="" readonly="true" class="form-control">
                    <input type="hidden" name="masterbarang_id" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="namaBarang" class="col-sm-4 control-label">Jumlah</label>
                  <div class="col-sm-3">
                    <input type="text" name="jumlah" readonly="true" value="" class="form-control">
                  </div>
                  <label for="namaBarang" class="col-sm-2 control-label">Satuan</label>
                  <div class="col-sm-3">
                    <input type="text" readonly="true" name="satuan" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group groupDiterima">
                  <label for="diterima" class="col-sm-4 control-label">Barang Diterima</label>
                  <div class="col-sm-8">
                    <input type="text" name="terima" value="" class="form-control" required="true">
                    <small class="text-danger errorDiterima"></small>
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
                    <input type="text" name="hna" onkeyup="kalkulasi()" value="" class="form-control uang">
                  </div>
                </div>
                <div class="form-group">
                  <label for="diskon" class="col-sm-4 control-label">Diskon</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="diskon_rupiah" onkeyup="diskonRupiah()" value="0" class="form-control uang">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      <input type="text" name="diskon_persen" onkeyup="diskonPersen()" value="0" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
                  <div class="col-sm-8">
                    <input type="text" name="keterangan" value="" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
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
                  <label for="harga_jual" class="col-sm-4 control-label">Harga Jual</label>
                  <div class="col-sm-3">
                    <input type="text" name="harga_jual" value="" class="form-control">
                  </div>
                  <label for="harga_jual_satuan" class="col-sm-2 control-label">Satuan</label>
                  <div class="col-sm-3">
                    <input type="text" name="harga_jual_satuan" class="form-control" value="">
                  </div>
                </div>
                {{--  <div class="form-group">
                  <label for="batch_no" class="col-sm-4 control-label">No. Batch</label>
                  <div class="col-sm-8">
                    <input type="text" name="batch" value="" class="form-control" required="true">
                  </div>
                </div>  --}}
                <div class="form-group">
                  <label for="expired_date" class="col-sm-4 control-label">Expired Date</label>
                  <div class="col-sm-8">
                    <input type="text" name="expired" value="" required="true" class="form-control datepicker">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  $('.uang').maskNumber({
    thousands: '.',
    integer: true,
  });

  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function prosesPenerimaan(id) {
    $('#modalPenerimaan').modal('show')
    $('#formPenerimaanPO')[0].reset()
    $.ajax({
      url: '/logistiknonmedik/nonmedikpenerimaan/get-item-po/'+id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      $('.modal-title').text('Input Penerimaan Nomor PO: '+resp.item.no_po)
      $('input[name="no_po"]').val(resp.item.no_po)
      $('input[name="tanggal"]').val(resp.item.tanggal)
      $('input[name="supplier"]').val(resp.item.supplier)
      $('input[name="no_faktur"]').val(resp.item.no_po)
      $('input[name="masterbarang_id"]').val(resp.item.masterbarang_id)
      $('input[name="keterangan"]').val(resp.item.keterangan)
      $('input[name="namaBarang"]').val(resp.namaBarang.nama)
      $('input[name="hna_lama"]').val(ribuan(resp.namaBarang.harga_beli))
      $('input[name="jumlah"]').val(resp.item.sisa)
      $('input[name="satuan"]').val(resp.satuan.nama)
    });

  }

  function kalkulasi() {
    var terima = $('input[name="terima"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var total_hna = terima * hna
    var ppn = total_hna * (10/100)
    var hpp = total_hna + ppn
    var harga_jual = hpp + (20/100 * hpp)
    var harga_jual_satuan = harga_jual / terima

    $('input[name="total_hna"]').val(ribuan(total_hna))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
  }

  function diskonPersen() {
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var persen = $('input[name="diskon_persen"]').val();
    var diskon = hna * persen/100
    $('input[name="diskon_rupiah"]').val(ribuan(diskon))
  }

  function diskonRupiah() {
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var rupiah = $('input[name="diskon_rupiah"]').val();
    var diskon = rupiah / hna * 100
    $('input[name="diskon_persen"]').val(diskon)
  }

  function save(){
      var data = $('#formPenerimaanPO').serialize()
      var id = $('input[name="id"]').val()
      var url = '{{ route('logistiknonmedikPenerimaan.store') }}'

      $.post( url, data, function(resp){
        if (resp.sukses == true) {
          $('#formPenerimaanPO')[0].reset()
          $('#modalPenerimaan').modal('hide')
          location.reload();
        }
      })
  }


</script>
@endsection
