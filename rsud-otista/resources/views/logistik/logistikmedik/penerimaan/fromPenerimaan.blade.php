@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Penerimaan PO
      </h3>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'logistikmedik/penerimaan/savePenerimaan', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="url" value="{{ Request::segment(6) }}">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="no_po" class="col-sm-4 control-label">No. SP</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_po" value="{{ $item->no_po }}" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal" class="col-sm-4 control-label">Tanggal SP</label>
                  <div class="col-sm-8">
                    <input type="text" name="tanggal" value="{{ $item->tanggal }}" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="supplier" class="col-sm-4 control-label">Supplier</label>
                  <div class="col-sm-8">
                    <input type="text" name="supplier" value="{{ $item->supplier }}" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="no_faktur" class="col-sm-4 control-label">No. Faktur</label>
                  <div class="col-sm-8">
                    <input type="text" name="no_faktur" value="{{ $berita->no_faktur }}" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tanggal_penerimaan" class="col-sm-4 control-label">Tanggal Faktur</label>
                  <div class="col-sm-8">
                    <input type="text" name="tanggal_penerimaan" value="{{ $berita->tanggal_faktur }}" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="namaBarang" class="col-sm-4 control-label">Nama Barang</label>
                  <div class="col-sm-8">
                    <input type="text" name="namaBarang" value="{{ $berita->nama }}" readonly="true" class="form-control">
                    <input type="hidden" name="masterobat_id" value="{{ $item->masterobat_id }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="namaBarang" class="col-sm-4 control-label">Jumlah Dikirim</label>
                  <div class="col-sm-3">
                    <input type="text" name="jumlah" readonly="true" value="{{ $berita->kondisi }}" class="form-control">
                  </div>
                  <label for="namaBarang" class="col-sm-2 control-label">Satuan</label>
                  <div class="col-sm-3">
                    <input type="text" readonly="true" name="satuan" value="{{ $berita->satuan }}" class="form-control">
                  </div>
                </div>
                <div class="form-group groupDiterima">
                  <label for="diterima" class="col-sm-4 control-label">Barang Diterima</label>
                  <div class="col-sm-8">
                    <input type="text" readonly="true" name="terima" value="{{ $berita->kondisi }}" class="form-control" required="true">
                    <small class="text-danger errorDiterima"></small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="hna_lama" class="col-sm-4 control-label">HNA Lama</label>
                  <div class="col-sm-8">
                    <input type="text" name="hna_lama" onkeyup="kalkulasi()" value="{{ number_format($namaBarang->hargabeli) }}" class="form-control uang">
                  </div>
                </div>
                <div class="form-group">
                  <label for="hna" class="col-sm-4 control-label">HNA Baru</label>
                  <div class="col-sm-8">
                    <input type="text" name="hna" value="" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="diskon" class="col-sm-4 control-label">Diskon</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="diskon_rupiah" onkeyup="diskonRupiah()" value="" class="form-control uang">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      <input type="text" name="diskon_persen" onkeyup="diskonPersen()" value="" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
                  <div class="col-sm-8">
                    <input type="text" name="keterangan" value="-" class="form-control">
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
                 <div class="form-group">
                  <label for="batch_no" class="col-sm-4 control-label">No. Batch</label>
                  <div class="col-sm-8">
                    <input type="text" name="batch" value="" class="form-control" required="true">
                  </div>
                </div> 
                <div class="form-group">
                  <label for="expired_date" class="col-sm-4 control-label">Expired Date</label>
                  <div class="col-sm-8">
                    <input type="text" name="expired" value="" required="true" class="form-control datepicker">
                  </div>
                </div>
              </div>
            </div>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                {!! Form::submit('Simpan', ['class' => 'btn btn-primary btn-flat','onclick'=>'return confirm("Yakin data sudah benar semua?")']) !!}
          {!! Form::close() !!}
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
    var terima = $('input[name="terima"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split(',').join("") )
    var persen = $('input[name="diskon_persen"]').val();
    var diskon = hna * persen/100
    $('input[name="diskon_rupiah"]').val(ribuan(diskon))

    var total_hna = (terima * hna) - (diskon*terima)
    var ppn = parseInt(total_hna * (10/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = parseInt(hpp + (20/100 * hpp))
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(diskon))
    $('input[name="total_hna"]').val(ribuan(total_hna))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))

  }

  function diskonRupiah() {
    var cek_diskon = parseInt( $('input[name="diskon_rupiah"]').val().split('.').join("") );
    var terima = $('input[name="terima"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )
    var rupiah = $('input[name="diskon_rupiah"]').val();
    var diskon = rupiah / hna * 100
    $('input[name="diskon_persen"]').val(diskon)


    var total_hna = (terima * hna) - (cek_diskon * terima)
    var ppn = parseInt(total_hna * (10/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = parseInt(hpp + (28/100 * hpp))
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(cek_diskon))
    $('input[name="total_hna"]').val(ribuan(total_hna))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
  }

  function kalkulasi() {
    var diskon = parseInt( $('input[name="diskon_rupiah"]').val().split('.').join("") );
    var terima = $('input[name="terima"]').val()
    var hna = parseInt( $('input[name="hna"]').val().split('.').join("") )

    var total_hna = (terima * hna) - ( diskon * terima)
    var ppn = parseInt(total_hna * (10/100))
    var hpp = parseInt(total_hna + ppn)
    var harga_jual = hpp + (28/100 * hpp)
    var harga_jual_satuan = parseInt(harga_jual / terima)

    $('input[name="total_diskon"]').val(ribuan(diskon))
    $('input[name="total_hna"]').val(total_hna.toFixed(2))
    $('input[name="ppn"]').val(ribuan(ppn))
    $('input[name="hpp"]').val(ribuan(hpp))
    $('input[name="harga_jual"]').val(ribuan(harga_jual))
    $('input[name="harga_jual_satuan"]').val(ribuan(harga_jual_satuan))
  }

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
        alert('Penerimaan berhasil di simpan!');
        location.replace("{{ url('/logistikmedik/penerimaan') }}");
      }
    });

  }


</script>
@endsection