@extends('master')
@section('header')
  <h1>Faktur </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            Faktur Baru
        </h3>
      </div>
      <div class="box-body">
          <div id="faktur">
              <form class="form-horizontal" id="formFaktur" method="post">
                  {{ csrf_field() }} {{ method_field('POST') }}

              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group" id="groupNoFaktur">
                        <label for="nomorfaktur" class="col-md-3 control-label">Nomor Faktur</label>
                        <div class="col-md-9">
                            <input type="text" name="no_faktur" class="form-control" >
                            <span class="text-danger" id="no_faktur-error"></span>
                        </div>
                      </div>
                      <div class="form-group" id="groupTanggal">
                        <label for="tanggal" class="col-md-3 control-label">Tanggal</label>
                        <div class="col-md-9">
                            <input type="text" name="tanggal" class="form-control datepicker" >
                            <span class="text-danger" id="tanggal-error"></span>
                        </div>
                      </div>
                      <div class="form-group" id="groupSupplier">
                        <label for="supplier" class="col-md-3 control-label">Supplier</label>
                        <div class="col-md-9">
                            <select class="form-control chosen-select" name="supplier_id">
                                @foreach ($supplier as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="supplier-error"></span>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group" id="groupKeterangan">
                        <label for="keterangan" class="col-md-3 control-label">Keterangan</label>
                        <div class="col-md-9">
                            <input type="text" name="keterangan" class="form-control" >
                            <span class="text-danger" id="keterangan-error"></span>
                        </div>
                      </div>
                      <div class="form-group" id="groupNoTransaksi">
                        <label for="nomortransaksi" class="col-md-3 control-label">No. Transaksi</label>
                        <div class="col-md-9">
                            <input type="text" name="no_transaksi" class="form-control" >
                            <span class="text-danger" id="no_transaksi-error"></span>
                        </div>
                      </div>
                      <div class="form-group" id="groupSumberDana">
                        <label for="sumberdana" class="col-md-3 control-label">Sumber Dana</label>
                        <div class="col-md-9">
                            <select class="form-control chosen-select" name="sumber_dana">
                                <option value=""></option>
                            </select>
                            <span class="text-danger" id="sumber_dana-error"></span>
                        </div>
                      </div>
                      <div class="col-md-9 col-md-offset-3">
                          <button type="button" id="saveButton" class="btn btn-primary btn-flat">
                              LANJUT
                          </button>
                      </div>
                  </div>
              </div>
              </form>
          </div>

          <div id="fakturDetail" class="hidden">
              <form id="formAdd" method="post" class="form-horizontal">
                  {{ csrf_field() }} {{ method_field('POST') }}
                  <input type="hidden" name="faktur_id" value="">
                  <div class="row">
                      <div class="col-md-6">

                          <div class="form-group">
                            <label for="kode_item" class="col-sm-3 control-label">Kode </label>
                            <div class="col-sm-6">
                                <input type="text" name="kode_item" class="form-control" readonly="true">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" id="cariItem" class="btn btn-default btn-flat">
                                  <i class="fa fa-search"> </i> CARI
                                </button>
                            </div>
                          </div>

                          <div class="form-group" id="groupNamaItem">
                            <label for="nama" class="col-sm-3 control-label">Nama </label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_item" class="form-control" readonly="true">
                                <span class="text-danger" id=nama_item-error></span>
                            </div>
                          </div>

                          <div class="form-group" id="groupJumlahItem">
                            <label for="jumlah" class="col-sm-3 control-label">Jumlah </label>
                            <div class="col-sm-9">
                                <input type="text" name="jumlah_item" class="form-control" id="" placeholder="">
                                <span class="text-danger" id=jumlah_item-error></span>
                            </div>
                          </div>

                  </div>
                  <div class="col-md-6">
                      <div class="form-group"id="groupSatuan">
                        <label for="satuan" class="col-sm-3 control-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" name="satuan" class="form-control" id="" placeholder="">
                            <span class="text-danger" id=satuan-error></span>
                        </div>
                      </div>
                      <div class="form-group"id="groupHarga">
                        <label for="harga" class="col-sm-3 control-label">Harga + PPN</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga" class="form-control" id="" placeholder="">
                            <span class="text-danger" id=harga-error></span>
                        </div>
                      </div>
                      <div class="form-group"id="groupTotal">
                        <label for="total" class="col-sm-3 control-label">Total</label>
                        <div class="col-sm-9">
                            <input type="text" name="total" class="form-control" id="" placeholder="">
                            <span class="text-danger" id=total-error></span>
                        </div>
                      </div>
                      <div class="col-md-9 col-md-offset-3">
                          <button type="button"  id="saveItem" class="btn btn-primary btn-flat pull-left">Tambahkan</button>
                      </div>

                  </div>
              </div>
               </form>

              <hr>
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Nama Barang</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Harga Satuan + PPN</th>
                      <th>Total</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                  <tbody> </tbody>
                </table>
              </div>
          </div>


      </div>


{{-- MODAL ITEM --}}
      <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body">
                <div class='table-responsive'>
                  <table id="masterObat" class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Add</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              </form>
            </div>
          </div>
        </div>
      </div>

@stop

@section('script')
    <script type="text/javascript">
    $(document).on('click', '#saveButton', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/faktur-save',
            type: 'POST',
            data: $('#formFaktur').serialize(),
            success: function (data) {
                console.log(data);
                if(data.sukses == false) {
                    if(data.errors.no_faktur) {
                        $('#groupNoFaktur').addClass('has-error');
                        $('#no_faktur-error').html( data.errors.no_faktur[0] );
                    }
                    if(data.errors.tanggal) {
                        $('#groupTanggal').addClass('has-error');
                        $('#tanggal-error').html( data.errors.tanggal[0] );
                    }
                    if(data.errors.supplier_id) {
                        $('#groupSupplier').addClass('has-error');
                        $('#supplier-error').html( data.errors.supplier_id[0] );
                    }
                    if(data.errors.keterangan) {
                        $('#groupKeterangan').addClass('has-error');
                        $('#keterangan-error').html( data.errors.keterangan[0] );
                    }
                    if(data.errors.no_transaksi) {
                        $('#groupNoTransaksi').addClass('has-error');
                        $('#no_transaksi-error').html( data.errors.no_transaksi[0] );
                    }
                }

                if(data.sukses == true) {
                    $('#formFaktur')[0].reset();
                    $('#groupNoFaktur').removeClass('has-error');
                    $('#no_faktur-error').html( "" );
                    $('#groupTanggal').removeClass('has-error');
                    $('#tanggal-error').html( "" );
                    $('#groupSupplier').removeClass('has-error');
                    $('#supplier-error').html( "" );
                    $('#groupKeterangan').removeClass('has-error');
                    $('#keterangan-error').html( "" );
                    $('#groupNoTransaksi').removeClass('has-error');
                    $('#no_transaksi-error').html( "" );

                    $('#faktur').addClass('hidden');
                    $('#fakturDetail').removeClass('hidden');
                    $('input[name="faktur_id"]').val(data.faktur_id);
                }
            }
        });
    })

    //OPEN MODAL OBAT
    $('#cariItem').on('click', function() {
        $('#addItem').modal('show');
        $('.modal-title').text('Tambah Obat');
        $('#masterObat').DataTable().destroy();
        $('#masterObat').DataTable({
              'language': {
                  'url': '/json/pasien.datatable-language.json',
              },

              autoWidth: false,
              processing: true,
              serverSide: true,
              ajax: '/po-masterobat',
              columns: [
                  {data: 'nama'},
                  {data: 'add', searchable: false}
              ]
        });

    });

    //ADD TO FORM
    $(document).on('click', '.insert',function () {
        $('input[name="kode_item"]').val($(this).attr('data-kode'));
        $('input[name="nama_item"]').val($(this).attr('data-nama'));
        $('#addItem').modal('hide');
    });

    </script>
@endsection
