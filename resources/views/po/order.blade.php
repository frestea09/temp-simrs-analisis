@extends('master')

@section('header')
  <h1>PO </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            PO Baru
        </h3>
      </div>
      <div class="box-body">
          <div class="row">
              <div class="col-md-6">
                  @if (!isset($po_id))
                      {!! Form::open(['method' => 'POST', 'url' => '/po-order', 'class' => 'form-horizontal']) !!}

                          <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                              {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                              <div class="col-sm-9">
                                  {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!}
                                  <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                              {!! Form::label('supplier', 'Supplier', ['class' => 'col-sm-3 control-label']) !!}
                              <div class="col-sm-9">
                                  {!! Form::select('supplier_id', App\Supliyer::pluck('nama', 'id'), null, ['class' => 'chosen-select']) !!}
                                  <small class="text-danger">{{ $errors->first('supplier_id') }}</small>
                              </div>
                          </div>

                          <div class="btn-group pull-right">
                              <a href="{{ url('po') }}" class="btn btn-warning btn-flat">Batal</a>
                              {!! Form::submit("Lanjut", ['class' => 'btn btn-success btn-flat']) !!}
                          </div>
                      {!! Form::close() !!}
                  @else
                      <form id="formAdd" method="post" class="form-horizontal">
                          {{ csrf_field() }} {{ method_field('POST') }}
                          <input type="hidden" name="po_id" value="{{ $po_id }}">
                          <input type="hidden" name="no_po" value="{{ $no_po }}">

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
                          <div class="form-group"id="groupSatuan">
                            <label for="satuan" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-9">
                                <input type="text" name="satuan" class="form-control" id="" placeholder="">
                                <span class="text-danger" id=satuan-error></span>
                            </div>
                          </div>
                          <button type="button" id="saveItem" class="btn btn-primary btn-flat pull-right">Tambahkan</button>
                          </form>
                  @endif

              </div>
              <div class="col-md-6">
                  @isset($_POST['supplier_id'])
                      <h4>Detail Order</h4>
                      <div class='table-responsive'>
                        <table class='table table-striped table-bordered table-hover table-condensed'>
                          <tbody>
                             <tr>
                                 <th>Tanggal</th> <td> {{ tgl_indo($tanggal) }} </td>
                             </tr>
                            <tr>
                              <th>No. PO</th> <td> {{ $no_po }} </td>
                            </tr>
                            <tr>
                              <th>Distributor</th> <td> {{ App\Supliyer::where('id', $supplier_id)->first()->nama }} </td>
                            </tr>
                            <tr>
                                <th>Petugas</th> <td> {{ $user_create }} </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="pull-right">
                          <a href="{{ url('po-cetak/'.$po_id) }}" target="_blank" class="btn btn-info btn-md btn-flat"><i class="fa fa-file-pdf-o"></i> CETAK </a>
                      </div>
                  @endisset
              </div>
          </div>
          <br>
            @isset($_POST['supplier_id'])

              <div class='table-responsive'>
                <table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama Item</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>

              <div class="pull-right">
                  <a href="{{ url('po') }}" class="btn btn-success btn-flat" onclick="return confirm('Yakin transaksi diselesaikan?')">SELESAI</a>
              </div>
            @endisset
      </div>
    </div>

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
        //DATA DETAIL
        var id = $('input[name="po_id"]').val();
        var table = $('#dataDetailPO').DataTable({
              'language': {
                  'url': '/json/pasien.datatable-language.json',
              },
              lengthChange: false,
              paging      : false,
              searching   : false,
              ordering    : false,
              autoWidth   : false,
              processing  : false,
              info        : false,
              serverSide  : true,
              ajax: '/po-detail/'+id,
              columns: [
                  {data: 'rownum'},
                  {data: 'kode_item'},
                  {data: 'nama_item'},
                  {data: 'jumlah'},
                  {data: 'satuan'},
                  {data: 'delete'},

              ]
        });

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



        $('#saveItem').on('click', function () {
            $.ajax({
                type: 'POST',
                url: '/po-simpanitem',
                data: $('#formAdd').serialize(),
                success: function (data) {
                    console.log(data);
                    if(data.sukses == false) {
                        if(data.errors.nama_item) {
                            $('#groupNamaItem').addClass('has-error');
                            $('#nama_item-error').html( data.errors.nama_item )
                        }
                        if(data.errors.jumlah_item) {
                            $('#groupJumlahItem').addClass('has-error');
                            $('#jumlah_item-error').html( data.errors.jumlah_item )
                        }
                        if(data.errors.satuan) {
                            $('#groupSatuan').addClass('has-error');
                            $('#satuan-error').html( data.errors.satuan )
                        }
                    };

                    if(data.sukses == true) {
                        table.ajax.reload();
                        $('#groupNamaItem').removeClass('has-error');
                        $('#nama_item-error').html( "" )
                        $('#groupJumlahItem').removeClass('has-error');
                        $('#jumlah_item-error').html( "" )
                        $('#groupSatuan').removeClass('has-error');
                        $('#satuan-error').html( "" )

                        $('input[name="kode_item"]').val("");
                        $('input[name="nama_item"]').val("");
                        $('input[name="jumlah_item"]').val("");
                        $('input[name="satuan"]').val("");
                    }
                }

            });
        });

    //HAPUS ITEM
    $(document).on('click', '.hapus', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        if (confirm('Apakah yakin item ini akan dihapus?')) {
            $.ajax({
                url: 'po-hapus-detail/' + id,
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    if(data.sukses == true) {
                        table.ajax.reload();
                    }
                }
            });
        }
    })

    </script>
@endsection
