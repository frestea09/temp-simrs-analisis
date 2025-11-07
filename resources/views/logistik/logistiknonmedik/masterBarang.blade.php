@extends('master')
@section('header')
  <h1>Logistik Non Medik - Master Barang</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Master Barang
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Golongan</th>
                <th>Bidang</th>
                <th>Kelompok</th>
                <th>Sub Kelompok</th>
                <th>Kategori</th> 
                <th>Satuan Beli</th>
                <th>Satuan Jual</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Suplier</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
    <div id="Modal" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header bg-green">
                  <button class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                  <form method="POST" class="form-horizontal" id="form">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <input type="hidden" name="id">
                      <div class="box-body">
                          <div class="form-group">
                          <label for="nama" class="col-sm-4 control-label">Nama</label>
                              <div class="col-sm-7 namaGroup">
                                  <input type="text" class="form-control" name="nama" placeholder="nama">
                                  <span class="text-danger namaError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kode</label>
                              <div class="col-sm-7 kodeGroup">
                                  <input type="text" class="form-control" name="kode" placeholder="kode">
                                  <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kategori</label>
                              <div class="col-sm-7 kodeGroup">
                                   <select name="kategori_id" class="form-control select2" id="kategori_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kode Golongan</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="golongan_id" class="form-control select2" id="golongan_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kode Bidang</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="bidang_id" class="form-control select2" id="bidang_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kode Kelompok</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="kelompok_id" class="form-control select2" id="kelompok_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Kode Sub Kelompok</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="sub_kelompok_id" class="form-control select2" id="kelompok_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Supplier</label>
                              <div class="col-sm-7 kodeGroup">
                                   <select name="supplier_id" class="form-control select2" id="supplier_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Satuan Jual</label>
                              <div class="col-sm-7 kodeGroup">
                                <input type="text" class="form-control" name="satuan_jual" placeholder="satuan_jual">
                                <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Satuan Beli</label>
                              <div class="col-sm-7 kodeGroup">
                                  <input type="text" class="form-control" name="satuan_beli" placeholder="satuan_beli">
                                  <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Harga Jual</label>
                              <div class="col-sm-7 kodeGroup">
                                <input type="text" class="form-control uang" name="harga_jual" placeholder="harga_jual">
                                <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-4 control-label">Harga Beli</label>
                              <div class="col-sm-7 kodeGroup">
                                  <input type="text" class="form-control uang" name="harga_beli" placeholder="harga_beli">
                                  <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer bg-green">
                  <button type="button" class="btn bg-orange btn-flat" onclick="save()">SAVE</button>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $('.uang').maskNumber({
        thousands: ",",
        integer: true,
    })
    $('.select2').select2();
    $.get("{{ route('golongan.data') }}", function(resp){
      $('select[name="golongan_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="golongan_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('bidang.data') }}", function(resp){
      $('select[name="bidang_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="bidang_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('kelompok.data') }}", function(resp){
      $('select[name="kelompok_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="kelompok_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('sub.kelompok.data') }}", function(resp){
      $('select[name="sub_kelompok_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="sub_kelompok_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('kategori.data') }}", function(resp){
      $('select[name="kategori_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="kategori_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('supplier.data') }}", function(resp){
      $('select[name="supplier_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="supplier_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })
    
    function tambah(){
      $('#Modal').modal('show')
      $('.modal-title').text('Tambah Barang')
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')
      $('#form')[0].reset();
    }

    function edit(id){
      $('#Modal').modal('show')
      $('.modal-title').text('Edit Barang')
      $('input[name="id"]').val(id)
      $('input[name="_method"]').val('PATCH')
      $.get('/logistiknonmedik/master-barang/'+id+'/edit', function(resp){
          $('input[name="nama"]').val(resp.barang.nama)
          $('input[name="kode"]').val(resp.barang.kode)
          $('select[name="golongan_id"]').val(resp.barang.golongan_id).trigger('change')
          $('select[name="bidang_id"]').val(resp.barang.bidang_id).trigger('change')
          $('select[name="kelompok_id"]').val(resp.barang.kelompok_id).trigger('change')
          $('select[name="sub_kelompok_id"]').val(resp.barang.sub_kelompok_id).trigger('change')
          $('input[name="harga_beli"]').val(resp.barang.harga_beli)
          $('input[name="harga_jual"]').val(resp.barang.harga_jual)
          $('input[name="satuan_beli"]').val(resp.barang.satuan_beli)
          $('input[name="satuan_jual"]').val(resp.barang.satuan_jual)
      })
    }

    function reset(){
      $('.namaGroup').removeClass('has-error')
      $('.namaError').text('');
      $('.kodeGroup').removeClass('has-error')
      $('.kodeError').text('');
    }

    function save(){
        var data = $('#form').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('master-barang.store') }}'
        } else {
            var url = '/logistiknonmedik/master-barang/'+id
        }

        $.post( url, data, function(resp){
            reset()
            if(resp.sukses == false){
              if(resp.error.nama){
                  $('.namaGroup').addClass('has-error')
                  $('.namaError').text(resp.error.nama[0]);
              }
              if(resp.error.kode){
                  $('.kodeGroup').addClass('has-error')
                  $('.kodeError').text(resp.error.kode[0]);
              }
            } if(resp.sukses == true){
              $('#Modal').modal('hide');
              $('#form')[0].reset();
              table.ajax.reload();
            }
        })

    }

    var table;
    table = $('.table').DataTable({
    'language': {
      'url': '/json/pasien.datatable-language.json',
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: '{{ route('master-barang.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'nama'},
        {data: 'kode'},
        {data: 'golongan'},
        {data: 'bidang'},
        {data: 'kelompok'},
        {data: 'subkelompok'},
        {data: 'kategori_id'},
        {data: 'harga_beli'},
        {data: 'harga_jual'},
        {data: 'satuan_beli'},
        {data: 'satuan_jual'},
        {data: 'supplier'},
        {data: 'aksi', searchable: false}
    ]
    });
  </script>
@endsection