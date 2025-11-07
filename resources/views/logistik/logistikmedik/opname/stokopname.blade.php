@extends('master')

@section('header')
  <h1>Logistik <small>Stok Opname {{ $gudang->nama }}</small></h1>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
          <span>Stok Opname Per Obat Per Batch :</span>
        </div>
        <div class="box-body">
            <form method="POST" class="form-horizontal" action="{{ url('logistikmedik/kartustok/dataStok') }}" id="form">
              {{ csrf_field() }}
              {!! Form::hidden('gudang', $gudang->nama) !!}
                <div class="col-sm-7">
                  <div class="form-group">
                    <label for="masterobat_id" class="col-sm-2 control-label">Obat</label>
                    <div class="col-sm-10">
                    <select name="masterobat_id" id="masterObat" class="form-control" style="width : 100%" onchange="cariBatch()">
                    </select>
                  </div>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <div class="col-sm-12">
                      {{-- <a class="btn btn-primary btn-flat"> <i class="fa fa-icon fa-eye"></i>  TAMPILKAN BATCH</a> --}}
                      <a href="" class="btn btn-primary btn-flat cariBacth"> <i class="fa fa-icon fa-eye"></i>  TAMPILKAN BATCH</a>
                      
                       {{-- <button type="button" onclick="tampil()" class="btn btn-primary btn-flat" id="simpan"> <i class="fa fa-icon fa-eye"></i> TAMPILKAN BATCH</button> --}}
                        {{-- <button type="button" onclick="addBatch()" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-plus"></i> TAMBAH BATCH</button> --}}
                    </div>
                  </div>
                </div>
            </form>
        </div>
      </div>
  </div>
</div>

@isset($masterobat)
    
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="box-title">
      <h4> 
        <b class="text-primary">{{ $masterobat ? $masterobat->nama : NULL  }} </b>
          Total Stok: {{ $masterobat ? App\LogistikBatch::where('masterobat_id', $masterobat->id)->where('gudang_id',Auth::user()->gudang_id)->sum('stok') : NULL  }} 
          <button type="button" onclick="addBatch( {{ $masterobat->id }} )" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-plus"></i> TAMBAH BATCH</button>
      </h4>
      
    </div>
  </div>
  <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          @if ($batch->count() > 0)
          <div class="table-responsive">
            * Jika ada stok minus, maka isikan kolom opname angka minusnya untuk me-reset,contoh
            Jika Stok <b>-1000</b>,jika ingin reset menjadi 0, maka isikan <b>"1000"</b>,baru isikan stok yang terbaru agar stok tidak "minus".</b>
            <table class="table table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th class="text-center">Nomor Batch</th>
                  <th class="text-center">Stok Tercatat</th>
                  <th class="text-center">Expired Date</th>
                  <th>Keterangan</th>
                  <th class="text-center">Stok Opname</th>
                  @if (Auth::user()->id == 147 || Auth::user()->id == 148)
                  <th>Edit</th>
                  <th>Hapus</th>
                  @endif
                  <th>Opname</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($batch as $item)
                  {!! Form::model($item, ['id' => 'form-opname-'.$item->id, 'route' => ['simpan-opname-batch', $item->id], 'method' => 'post', 'class' => 'form-horizontal form-opname', 'enctype' => 'multipart/form-data' ]) !!}
                    <input class="form-control" type="hidden" name="logistikbatch_id" value="{{ $item->id }}" >
                    <input class="form-control" type="hidden" name="masterobat_id" value="{{ $item->masterobat_id }}" >
                    <input class="form-control" type="hidden" name="namaobat" value="{{ baca_obat($item->masterobat_id) }}" >

                      <tr>
                          <td class="text-center">{{ $no++ }}</td>
                          <td width="20%">
                            <input class="form-control" name="nomorbatch" type="hidden"  value="{{ $item->nomorbatch }}" >
                            {{ $item->nomorbatch }}
                          </td>
                          <td width="10%" class="text-center">
                            <input class="form-control text-center" name="stok_tercatat" type="hidden" value="{{ $item->stok }}" >
                            {{ $item->stok }}
                          </td>
                          <td class="text-center">
                            <input class="form-control text-center" name="expired" type="hidden" value="{{ $item->expireddate }}">
                            {{ $item->expireddate ? @date("d-m-Y", strtotime(@$item->expireddate)) :'' }}
                          </td>
                          <td><input class="form-control text-center" name="keterangan" type="text" name="keterangan" value="{{ !empty($opname->keterangan) ? $opname->keterangan : 'Opname Tgl. '.date('d-m-Y') }}"></td>
                          <td width="10%">
                            <input class="form-control text-center" name="stok_opname" type="number" min="0" value="">
                            <small class="text-danger">{{ $errors->first('stok_opname') }}</small>

                          </td>

                          @if (Auth::user()->id == 147 || Auth::user()->id == 148)
                            {{-- @if (cekBatchOpname($item->id)) --}}
                            <td><button type="button" onclick="edit({{ $item->id }})" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-icon fa-pencil-square-o"></i></button></td>
                            <td><button type="button" onclick="edit({{ $item->id }})" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-icon fa-trash"></i></button></td>
                            {{-- @else
                            <td><button type="button" onclick="edit({{ $item->id }})" class="btn btn-primary btn-flat btn-sm" disabled> <i class="fa fa-icon fa-pencil-square-o"></i></button></td>
                            <td><button type="button" onclick="edit({{ $item->id }})" class="btn btn-danger btn-flat btn-sm" disabled> <i class="fa fa-icon fa-trash"></i></button></td>
                            @endif --}}
                          @endif

                          <td>
                              {{-- @if (cekBatchOpname($item->id))
                                  <button type="button"class="btn btn-default btn-flat" disabled><i class="fa fa-check"> <del>Opname</del></i></button>
                              @else --}}
                                  <button type="button" id="btn-opname" data-id="{{ $item->id }}" data-attr="{{ $no-1 }}" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-save"></i> Opname</button>
                                  <button type="button" id="btn-delete-opname" data-id="{{ $item->id }}" data-attr="{{ $no-1 }}" class="btn btn-danger btn-flat"> <i class="fa fa-icon fa-trash-o"></i> Hapus</button>
                              {{-- @endif --}}
                          </td>
                      </tr>
                      {!! Form::close() !!}

                  @endforeach
              </tbody>
            </table>
          </div>
          @else
          <h5 class="text-center text-red"> Data Batch tidak ditemukan. silahkan Tambahkan Batch.</h5>
              
          @endif
        </div>
      </div>
  </div>
</div>
@endisset

  <div class="modal fade" id="addTambahBatch">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form id="formTambahBatch" method="post" class="form-horizontal">
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
             
              <div class="form-group namaGroup">
                <label for="stok" class="col-sm-3 control-label">Stok</label>
                <div class="col-sm-9">
                  <input type="number" name="stok" class="form-control" required>
                  <small class="text-danger stokError"></small>
                </div>
              </div>
            
             @if (Auth::user()->id == 601 || Auth::user()->id == 1 || Auth::user()->id == 600 || Auth::user()->id == 755) 
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
            @else

            <div class="form-group jabatanGroup">
              <label for="hargabeli" class="col-sm-3 control-label">Harga Beli</label>
              <div class="col-sm-9">
                <input type="number" name="hargabeli" class="form-control" readonly>
                <small class="text-danger hargabeliError"></small>
              </div>
            </div>
            <div class="form-group jabatanGroup">
              <label for="hargajualumum" class="col-sm-3 control-label">Harga Jual Umum</label>
              <div class="col-sm-9">
                <input type="number" name="hargajualumum" class="form-control" readonly>
                <small class="text-danger hargajualumumError"></small>
              </div>
            </div>
            <div class="form-group jabatanGroup">
              <label for="hargajualjkn" class="col-sm-3 control-label">Harga Jual JKN</label>
              <div class="col-sm-9">
                <input type="number" name="hargajualjkn" class="form-control" readonly>
                <small class="text-danger hargajualjknError"></small>
              </div>
            </div>
            <div class="form-group jabatanGroup">
              <label for="hargajualdinas" class="col-sm-3 control-label">Harga Jual Dinas</label>
              <div class="col-sm-9">
                <input type="number" name="hargajualdinas" class="form-control" readonly>
                <small class="text-danger hargajualdinasError"></small>
              </div>
            </div>










             @endif
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanBatch()">Simpan</button>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="editBatch">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form id="formEditBatch" method="post" class="form-horizontal">
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
             
              <div class="form-group namaGroup">
                <label for="stok" class="col-sm-3 control-label">Stok</label>
                <div class="col-sm-9">
                  <input type="number" name="stok" class="form-control" required>
                  <small class="text-danger stokError"></small>
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
            <button type="button" class="btn btn-primary btn-flat" onclick="editBatch()">Simpan</button>
          </div>
        </div>
      </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2();

  //  function tampil(){
  //     var masterobat_id= $("select[name='masterobat_id']").val();
  //         // periode = $("select[name='periode']").val();
  //         // abjad = $("select[name='filter_nama']").val();
  //     $.get("getObat/"+masterobat_id, function(resp){
  //       if(resp.sukses == false){
  //         alert('Data tidak ditemukan, silahkan Masukkan Data Obat di tombol "TAMBAH BATCH" !!');
  //         // location.reload();
  //       }else{
  //         $("#viewData").html(resp)
  //       }
  //     })
  //   }


  $('#masterObat').select2({
      placeholder: "Pilih Obat...",
      ajax: {
          url: '/get-master-obat/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  $('#supplier').select2({
      placeholder: "Pilih Supplier...",
      ajax: {
          url: '/logistikmedik/get-supplier/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  function addBatch(masterobat_id) {
    $('#formTambahBatch')[0].reset();
    $('#addTambahBatch').modal('show')
    $("input[name='masterobat_id']").val(masterobat_id);
    $.get('/logistikmedik/addNamaObatBatch/'+masterobat_id, function(resp){
      $('.modal-title').text('Tambah Batch '+resp.obat.nama)
      $("input[name='nama_obat']").val(resp.obat.nama);
      $('select[name="supplier_id"]').val(resp.obat.supplier_id).trigger('change')
      //$('select[name="satuanbeli_id"]').val(resp.obat.satuanbeli_id).trigger('change')
      //$('select[name="satuanjual_id"]').val(resp.obat.satuanjual_id).trigger('change')
      $("input[name='expired_date']").val(resp.newdate);
      $("input[name='hargabeli']").val(resp.obat.hargabeli);
      $("input[name='hargajualumum']").val(resp.obat.hargajual);
      $("input[name='hargajualjkn']").val(resp.obat.hargajual_jkn);
      $("input[name='hargajualdinas']").val(resp.obat.hargajual_kesda);
    })
  }

  function cariBatch() {
    var masterobat_id= $("select[name='masterobat_id']").val();
    $('.cariBacth').attr('href', '/logistikmedik/stok-opname/'+masterobat_id)
  }

  function edit(id) {
    $('#formEditBatch')[0].reset();
    status = 1
    $('#editBatch').modal('show')
    $.get('/logistikmedik/editObatBatch/'+id, function(resp){
      $('.modal-title').text('Edit Batch '+resp.nama)
      $("input[name='id']").val(resp.obat.id)
      $("input[name='masterobat_id']").val(resp.obat.masterobat_id);
      $("input[name='nama_obat']").val(resp.nama);
      $("input[name='nomor_batch']").val(resp.obat.nomorbatch);
      $('select[name="supplier_id"]').val(resp.obat.supplier_id).trigger('change')
      $('select[name="satuanbeli_id"]').val(resp.obat.satuanbeli_id).trigger('change')
      $('select[name="satuanjual_id"]').val(resp.obat.satuanjual_id).trigger('change')
      $("input[name='expired_date']").val(resp.obat.expireddate);
      $("input[name='hargabeli']").val(resp.obat.hargabeli);
      $("input[name='hargajualumum']").val(resp.obat.hargajual_umum);
      $("input[name='hargajualjkn']").val(resp.obat.hargajual_jkn);
      $("input[name='hargajualdinas']").val(resp.obat.hargajual_dinas);
      $("input[name='stok']").val(resp.obat.stok);
    })
  }

  function editBatch(){
      var data = $('#formEditBatch').serialize(), url = '';
      url = '/logistikmedik/editBatch'
      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
      }).done(function(json) {
        if(json.success == true){
          location.reload();
        }else{
          if (json.error.nomor_batch) {
            $('.nomor_batchGroup').addClass('has-error')
            $('.nomor_batchError').text(json.error.nomor_batch[0])
          }
          if (json.error.stok) {
            $('.stokGroup').addClass('has-error')
            $('.stokError').text(json.error.stok[0])
          }
          if (json.error.expired_date) {
            $('.expired_dateGroup').addClass('has-error')
            $('.expired_dateError').text(json.error.expired_date[0])
          }
          if (json.error.hargabeli) {
            $('.hargabeliGroup').addClass('has-error')
            $('.hargabeliError').text(json.error.hargabeli[0])
          }
          if (json.error.hargajualumum) {
            $('.hargajualumumGroup').addClass('has-error')
            $('.hargajualumumError').text(json.error.hargajualumum[0])
          }
          if (json.error.hargajualjkn) {
            $('.hargajualjknGroup').addClass('has-error')
            $('.hargajualjknError').text(json.error.hargajualjkn[0])
          }
          if (json.error.hargajualdinas) {
            $('.hargajualdinasGroup').addClass('has-error')
            $('.hargajualdinasError').text(json.error.hargajualdinas[0])
          }
          if (json.error.supplier_id) {
            $('.supplier_idGroup').addClass('has-error')
            $('.supplier_idError').text(json.error.supplier_id[0])
          }
        }
      })
  }

  function simpanBatch(){
      var data = $('#formTambahBatch').serialize(), url = '';
      url = '/logistikmedik/saveBatch'
      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
      }).done(function(json) {
        if(json.success == true){
          location.reload();
        }else{
          if (json.error.nomor_batch) {
            $('.nomor_batchGroup').addClass('has-error')
            $('.nomor_batchError').text(json.error.nomor_batch[0])
          }
          if (json.error.stok) {
            $('.stokGroup').addClass('has-error')
            $('.stokError').text(json.error.stok[0])
          }
          if (json.error.expired_date) {
            $('.expired_dateGroup').addClass('has-error')
            $('.expired_dateError').text(json.error.expired_date[0])
          }
          if (json.error.hargabeli) {
            $('.hargabeliGroup').addClass('has-error')
            $('.hargabeliError').text(json.error.hargabeli[0])
          }
          if (json.error.hargajualumum) {
            $('.hargajualumumGroup').addClass('has-error')
            $('.hargajualumumError').text(json.error.hargajualumum[0])
          }
          if (json.error.hargajualjkn) {
            $('.hargajualjknGroup').addClass('has-error')
            $('.hargajualjknError').text(json.error.hargajualjkn[0])
          }
          if (json.error.hargajualdinas) {
            $('.hargajualdinasGroup').addClass('has-error')
            $('.hargajualdinasError').text(json.error.hargajualdinas[0])
          }
          if (json.error.supplier_id) {
            $('.supplier_idGroup').addClass('has-error')
            $('.supplier_idError').text(json.error.supplier_id[0])
          }
        }
      })
  }

  $(document).on('click','#btn-opname', function(){
    let id = $(this).attr('data-id');
    let no = $(this).attr('data-attr');
    if( confirm("Apakah Anda Yakin Akan Melakukan Opname No "+no+" ?") ){
      $('#form-opname-'+id).submit();
    }
  })

  $(document).on('click','#btn-delete-opname',function(){
    let id = $(this).attr('data-id');
    let no = $(this).attr('data-attr');
    if( confirm("Apakah Anda Yakin Akan Menghapus Batch No "+no+" ?") ){
      var body = { _token : '{{ csrf_token() }}' };
      url = '/logistikmedik/stok-opname/'+id
      $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json',
        data: body,
      }).done(function(res) {
          if( res.status == false ){
            alert(res.msg)
          }else{
            location.reload();
          }
      })
    }
  })

  // function simpan(id){
	// 	$.ajax({
	// 		url: '/logistikmedik/saveOpname',
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			'id':id,
  //       'logistikbatch_id': $('input[name="logistikbatch_id'+id+'"]').val(),
  //       'masterobat_id': $('input[name="masterobat_id'+id+'"]').val(),
  //       'satuanbeli': $('input[name="satuanbeli'+id+'"]').val(),
  //       'satuanjual': $('input[name="satuanjual'+id+'"]').val(),
  //       'stok': $('input[name="stok'+id+'"]').val(),
  //       'expired': $('input[name="expired'+id+'"]').val(),
	// 			'keterangan': $('input[name="keterangan'+id+'"]').val(),
	// 			'_token' : $('input[name="_token"]').val()
	// 			}
	// 	})
	// 	.done(function(data) {
  //     if(data.success == true){
  //       $('#simpan').click();
  //       alert('Berhasil Opname');
  //       $('#viewData').load('/logistikmedik/getObat/'+data.obat);
  //     }else{

  //     }
	// 	});
	// }

  // $('table').DataTable();

</script>
@endsection
