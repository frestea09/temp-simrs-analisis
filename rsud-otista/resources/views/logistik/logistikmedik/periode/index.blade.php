@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Periode
           <button class="btn btn-default btn-sm btn-flat" onclick="addForm()"><i class="fa fa-plus"> </i> TAMBAH</button>
      </h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Periode Awal</th>
                <th>Periode Akhir</th>
                <th>Transaksi Awal</th>
                <th>Transaksi Akhir</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
    </div>
  </div>


  <div class="modal fade" id="modalPeriode">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formPeriode" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" value="">

            <div class="form-group namaGroup">
              <label for="nama" class="col-sm-3 control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" name="nama" value="" class="form-control">
                <small class="text-danger namaError"></small>
              </div>
            </div>

            <div class="form-group periodeAwalGroup">
              <label for="periodeAwal" class="col-sm-3 control-label">Periode Awal</label>
              <div class="col-sm-9">
                <input type="text" name="periodeAwal" value="" class="form-control datepicker">
                <small class="text-danger periodeAwalError"></small>
              </div>
            </div>

            <div class="form-group periodeAkhirGroup">
              <label for="periodeAkhir" class="col-sm-3 control-label">Periode Akhir</label>
              <div class="col-sm-9">
                <input type="text" name="periodeAkhir" value="" class="form-control datepicker">
                <small class="text-danger periodeAkhirError"></small>
              </div>
            </div>

            <div class="form-group transaksiAwalGroup">
              <label for="transaksiAwal" class="col-sm-3 control-label">Transaksi Awal</label>
              <div class="col-sm-9">
                <input type="text" name="transaksiAwal" value="" class="form-control datepicker">
                <small class="text-danger transaksiAwalError"></small>
              </div>
            </div>

            <div class="form-group transaksiAkhirGroup">
              <label for="transaksiAkhir" class="col-sm-3 control-label">Transaksi Akhir</label>
              <div class="col-sm-9">
                <input type="text" name="transaksiAkhir" value="" class="form-control datepicker">
                <small class="text-danger transaksiAkhirError"></small>
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
        ajax: '{{ url('/logistikmedik/periode-data') }}',
        columns: [
          {data: 'DT_RowIndex'},
          {data: 'nama'},
          {data: 'periodeAwal'},
          {data: 'periodeAkhir'},
          {data: 'transaksiAwal'},
          {data: 'transaksiAkhir'},
          {data: 'edit'},
      ]
    });

  function resetForm() {
    $('.namaGroup').removeClass('has-error')
    $('.namaError').text('')
    $('.periodeAwalGroup').removeClass('has-error')
    $('.periodeAwalError').text('')
    $('.periodeAkhirGroup').removeClass('has-error')
    $('.periodeAkhirError').text('')
    $('.transaksiAwalGroup').removeClass('has-error')
    $('.transaksiAwalError').text('')
    $('.transaksiAkhirGroup').removeClass('has-error')
    $('.transaksiAkhirError').text('')
  }

  function addForm() {
    $('#modalPeriode').modal('show')
    $('.modal-title').text('Tambah Periode')
    $('input[name="id"]').val('')
    $('input[name="_method"]').val('POST')
    resetForm()
  }

  function editForm(id) {
    resetForm()
    $('#modalPeriode').modal('show')
    $('.modal-title').text('Update Periode')
    $.ajax({
      url: '/logistikmedik/periode/'+id+'/edit',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('input[name="id"]').val(json.id)
      $('input[name="_method"]').val('PATCH')
      $('input[name="nama"]').val(json.nama)
      $('input[name="periodeAwal"]').val(json.periodeAwal)
      $('input[name="periodeAkhir"]').val(json.periodeAkhir)
      $('input[name="transaksiAwal"]').val(json.transaksiAwal)
      $('input[name="transaksiAkhir"]').val(json.transaksiAkhir)
    });

  }

  function save() {
    resetForm()
    var id = $('input[name="id"]').val()
    var data = $('#formPeriode').serialize();

    if (id != '') {
      url = '/logistikmedik/periode/'+id
    } else {
      url = '/logistikmedik/periode'
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
        if (json.error.periodeAwal) {
          $('.periodeAwalGroup').addClass('has-error')
          $('.periodeAwalError').text(json.error.periodeAwal[0])
        }
        if (json.error.periodeAkhir) {
          $('.periodeAkhirGroup').addClass('has-error')
          $('.periodeAkhirError').text(json.error.periodeAkhir[0])
        }
        if (json.error.transaksiAwal) {
          $('.transaksiAwalGroup').addClass('has-error')
          $('.transaksiAwalError').text(json.error.transaksiAwal[0])
        }
        if (json.error.transaksiAkhir) {
          $('.transaksiAkhirGroup').addClass('has-error')
          $('.transaksiAkhirError').text(json.error.transaksiAkhir[0])
        }
      }
      if (json.sukses == true) {
        $('#modalPeriode').modal('hide')
        $('#formPeriode')[0].reset()
        table.ajax.reload();
      }

    });
  }


</script>
@endsection
