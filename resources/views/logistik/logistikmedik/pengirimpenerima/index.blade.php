@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Pengirim / Penerima
           <button class="btn btn-default btn-sm btn-flat" onclick="addForm()"><i class="fa fa-plus"> </i> TAMBAH</button>
      </h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Bahan</th>
                <th>Kode Rek</th>
                <th>Anggaran</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
    </div>
  </div>


  <div class="modal fade" id="modalPengirimPenerima">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formPengirimPenerima" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" value="">

            <div class="form-group kodeGroup">
              <label for="kode" class="col-sm-3 control-label">Kode</label>
              <div class="col-sm-9">
                <input type="text" name="kode" value="" class="form-control">
                <small class="text-danger kodeError"></small>
              </div>
            </div>

            <div class="form-group namaGroup">
              <label for="nama" class="col-sm-3 control-label">Nama Bahan</label>
              <div class="col-sm-9">
                <input type="text" name="nama" value="" class="form-control">
                <small class="text-danger namaError"></small>
              </div>
            </div>

            <div class="form-group nipGroup">
              <label for="nip" class="col-sm-3 control-label">Kode Rek</label>
              <div class="col-sm-9">
                <input type="text" name="nip" value="" class="form-control">
                <small class="text-danger nipError"></small>
              </div>
            </div>

            <div class="form-group departemenGroup">
              <label for="departemen" class="col-sm-3 control-label">Anggaran</label>
              <div class="col-sm-9">
                <input type="text" name="departemen" value="" class="form-control">
                <small class="text-danger departemenError"></small>
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
        ajax: '{{ url('/logistikmedik/pengirimpenerima-data') }}',
        columns: [
          {data: 'DT_RowIndex'},
          {data: 'kode'},
          {data: 'nama'},
          {data: 'nip'},
          {data: 'departemen'},
          {data: 'edit'},
      ]
    });

  function resetForm() {
    $('.namaGroup').removeClass('has-error')
    $('.namaError').text('')
    $('.nipGroup').removeClass('has-error')
    $('.nipError').text('')
    $('.departemenGroup').removeClass('has-error')
    $('.departemenError').text('')

  }

  function addForm() {
    $('#modalPengirimPenerima').modal('show')
    $('.modal-title').text('Tambah Pengirim / Penerima')
    $('input[name="id"]').val('')
    $('input[name="_method"]').val('POST')
    resetForm()
  }

  function editForm(id) {
    resetForm()
    $('#modalPengirimPenerima').modal('show')
    $('.modal-title').text('Update Pengirim / Penerima')
    $.ajax({
      url: '/logistikmedik/pengirimpenerima/'+id+'/edit',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('input[name="id"]').val(json.id)
      $('input[name="_method"]').val('PATCH')
      $('input[name="kode"]').val(json.kode)
      $('input[name="nama"]').val(json.nama)
      $('input[name="nip"]').val(json.nip)
      $('input[name="departemen"]').val(json.departemen)
    });

  }

  function save() {
    resetForm()
    var id = $('input[name="id"]').val()
    var data = $('#formPengirimPenerima').serialize();

    if (id != '') {
      url = '/logistikmedik/pengirimpenerima/'+id
    } else {
      url = '/logistikmedik/pengirimpenerima'
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
        if (json.error.nip) {
          $('.nipGroup').addClass('has-error')
          $('.nipError').text(json.error.nip[0])
        }
        if (json.error.departemen) {
          $('.departemenGroup').addClass('has-error')
          $('.departemenError').text(json.error.departemen[0])
        }
      }
      if (json.sukses == true) {
        $('#modalPengirimPenerima').modal('hide')
        $('#formPengirimPenerima')[0].reset()
        table.ajax.reload();
      }

    });
  }


</script>
@endsection
