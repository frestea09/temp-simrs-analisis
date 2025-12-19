@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Gudang
           <button class="btn btn-default btn-sm btn-flat" onclick="addForm()"><i class="fa fa-plus"> </i> TAMBAH</button>
      </h3>
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Telepon</th>
              <th>No. HP</th>
              <th>Nama Penjabat</th>
              <th>Jabatan</th>
              <th>Status</th>
              <th>Edit</th>
            </tr>
          </thead>
          </tbody>
        </table>
    </div>
  </div>


  <div class="modal fade" id="modalSupplier">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formSupplier" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" value="">

            <div class="form-group namaGroup">
              <label for="nama" class="col-sm-3 control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" name="nama" value="" class="form-control">
                <small class="text-danger namaError"></small>
              </div>
            </div>

            <div class="form-group alamatGroup">
              <label for="alamat" class="col-sm-3 control-label">alamat</label>
              <div class="col-sm-9">
                <input type="text" name="alamat" value="" class="form-control">
                <small class="text-danger alamatError"></small>
              </div>
            </div>

            <div class="form-group teleponGroup">
              <label for="telepon" class="col-sm-3 control-label">Nomor Telepon</label>
              <div class="col-sm-9">
                <input type="text" name="telepon" value="" class="form-control">
                <small class="text-danger teleponError"></small>
              </div>
            </div>

            <div class="form-group nohpGroup">
              <label for="nohp" class="col-sm-3 control-label">Nomor HP</label>
              <div class="col-sm-9">
                <input type="text" name="nohp" value="" class="form-control">
                <small class="text-danger nohpError"></small>
              </div>
            </div>

            <div class="form-group statusGroup">
              <label for="tipe" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <select name="status" class="form-control select2" style="width: 100%">
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
                <small class="text-danger statusError"></small>
              </div>
            </div>

            <div class="form-group nama_pejabatGroup">
              <label for="nama_pejabat" class="col-sm-3 control-label">Nama Pejabat</label>
              <div class="col-sm-9">
                <input type="text" name="nama_pejabat" value="" class="form-control">
                <small class="text-danger nama_pejabatError"></small>
              </div>
            </div>

            <div class="form-group jabatanGroup">
              <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
              <div class="col-sm-9">
                <input type="text" name="jabatan" value="" class="form-control">
                <small class="text-danger jabatanError"></small>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript">

  $('.select2').select2()

  var table;
  table = $('.table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },

      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax: '{{ url('/logistikmedik/supplier-data') }}',
      columns: [
        {data: 'DT_RowIndex'},
        {data: 'nama'},
        {data: 'alamat'},
        {data: 'telepon'},
        {data: 'nohp'},
        {data: 'nama_pejabat'},
        {data: 'jabatan'},
        {data: 'status'},
        {data: 'edit'},
    ]
  });

  function resetForm() {
    $('.namaGroup').removeClass('has-error')
    $('.namaError').text('')
    $('.alamatGroup').removeClass('has-error')
    $('.alamatError').text('')
    $('.teleponGroup').removeClass('has-error')
    $('.teleponError').text('')
    $('.nohpGroup').removeClass('has-error')
    $('.nohpError').text('')
    $('.nama_pejabatGroup').removeClass('has-error')
    $('.nama_pejabatError').text('')
    $('.jabatanGroup').removeClass('has-error')
    $('.jabatanError').text('')
  }

  function addForm() {
    $('#modalSupplier').modal('show')
    $('.modal-title').text('Tambah Supplier')
    $('input[name="id"]').val('')
    $('input[name="_method"]').val('POST')
    resetForm()
  }

  function editForm(id) {
    resetForm()
    $('#modalSupplier').modal('show')
    $('.modal-title').text('Update Supplier')
    $.ajax({
      url: '/logistikmedik/supplier/'+id+'/edit',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('input[name="id"]').val(json.id)
      $('input[name="_method"]').val('PATCH')
      $('input[name="nama"]').val(json.nama)
      $('input[name="alamat"]').val(json.alamat)
      $('input[name="telepon"]').val(json.telepon)
      $('input[name="nohp"]').val(json.nohp)
      $('input[name="nama_pejabat"]').val(json.nama_pejabat)
      $('input[name="jabatan"]').val(json.jabatan)
      $('select[name="status"]').val(json.status).trigger('change')
    });

  }

  function save() {
    resetForm()
    var id = $('input[name="id"]').val()
    var data = $('#formSupplier').serialize();

    if (id != '') {
      url = '/logistikmedik/supplier/'+id
    } else {
      url = '/logistikmedik/supplier'
    }

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(json) {
      if (json.sukses == false) {
        if (json.error.nama) {
          $('.namaGroup').addClass('has-error')
          $('.namaError').text(json.error.nama[0])
        }
        if (json.error.alamat) {
          $('.alamatGroup').addClass('has-error')
          $('.alamatError').text(json.error.alamat[0])
        }
        if (json.error.telepon) {
          $('.teleponGroup').addClass('has-error')
          $('.teleponError').text(json.error.telepon[0])
        }
        if (json.error.nohp) {
          $('.nohpGroup').addClass('has-error')
          $('.nohpError').text(json.error.nohp[0])
        }
        if (json.error.status) {
          $('.statusGroup').addClass('has-error')
          $('.statusError').text(json.error.status[0])
        }
        if (json.error.nama_pejabat) {
          $('.nama_pejabatGroup').addClass('has-error')
          $('.nama_pejabatError').text(json.error.nama_pejabat[0])
        }
        if (json.error.jabatan) {
          $('.jabatanGroup').addClass('has-error')
          $('.jabatanError').text(json.error.jabatan[0])
        }
      }
      if (json.sukses == true) {
        $('#modalSupplier').modal('hide')
        $('#formSupplier')[0].reset()
        table.ajax.reload()
      }

    });
  }


</script>
@endsection
