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
        <div id="viewData"></div>
    </div>
  </div>


  <div class="modal fade" id="modalGudang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formGudang" class="form-horizontal">
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
              <label for="nama" class="col-sm-3 control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" name="nama" value="" class="form-control">
                <small class="text-danger namaError"></small>
              </div>
            </div>

            <div class="form-group bagianGroup">
              <label for="bagian" class="col-sm-3 control-label">Bagian</label>
              <div class="col-sm-9">
                {{-- <select name="bagian" class="form-control select2" style="width: 100%"></select> --}}
                <input type="text" name="bagian" value="" class="form-control">
                <small class="text-danger bagianError"></small>
              </div>
            </div>
            <div class="form-group kepalaGroup">
              <label for="kepala" class="col-sm-3 control-label">Kepala</label>
              <div class="col-sm-9">
                <input type="text" name="kepala" value="" class="form-control">
                <small class="text-danger kepalaError"></small>
              </div>
            </div>
            <div class="form-group tipeGroup">
              <label for="tipe" class="col-sm-3 control-label">Tipe</label>
              <div class="col-sm-9">
                <select name="tipe" class="form-control select2" style="width: 100%">
                  <option value="Pusat">Pusat</option>
                  <option value="Depo">Depo</option>
                </select>
                <small class="text-danger tipeError"></small>
              </div>
            </div>
            <div class="form-group penanggungjawabGroup">
              <label for="penanggungjawab" class="col-sm-3 control-label">Penanggung Jawab</label>
              <div class="col-sm-9">
                <input type="text" name="penanggungjawab" value="" class="form-control">
                <small class="text-danger penanggungjawabError"></small>
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

  $('#viewData').load('/logistikmedik/gudang-data')
  $('.select2').select2()

  function resetForm() {
    $('.kodeGroup').removeClass('has-error')
    $('.kodeError').text('')
    $('.namaGroup').removeClass('has-error')
    $('.namaError').text('')
    $('.bagianGroup').removeClass('has-error')
    $('.bagianError').text('')
    $('.kepalaGroup').removeClass('has-error')
    $('.kepalaError').text('')
    $('.tipeGroup').removeClass('has-error')
    $('.tipeError').text('')
    $('.penanggungjawabGroup').removeClass('has-error')
    $('.penanggungjawabError').text('')
  }

  function getSatker() {
    $.ajax({
      url: '/logistikmedik/gudang-getSatker',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('select[name="bagian"]').empty()
      $.each(json, function(index, val) {
         $('select[name="bagian"]').append('<option value="'+val.namasatker+'">'+val.namasatker+'</option>')
      });
    });

  }

  function addForm() {
    $('#modalGudang').modal('show')
    $('.modal-title').text('Tambah Gudang')
    $('input[name="id"]').val('')
    $('input[name="_method"]').val('POST')
    resetForm()
    getSatker()
  }

  function editForm(id) {
    resetForm()
    getSatker()
    $('#modalGudang').modal('show')
    $('.modal-title').text('Update Gudang')
    $.ajax({
      url: '/logistikmedik/gudang/'+id+'/edit',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('input[name="id"]').val(json.id)
      $('input[name="_method"]').val('PATCH')
      $('input[name="kode"]').val(json.kode)
      $('input[name="nama"]').val(json.nama)
      $('select[name="bagian"]').val(json.bagian).trigger('change')
      $('input[name="kepala"]').val(json.kepala)
      $('input[name="tipe"]').val(json.tipe)
      $('input[name="penanggungjawab"]').val(json.penanggungjawab)
    });

  }

  function save() {
    resetForm()
    var id = $('input[name="id"]').val()
    var data = $('#formGudang').serialize();

    if (id != '') {
      url = '/logistikmedik/gudang/'+id
    } else {
      url = '/logistikmedik/gudang'
    }

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(json) {
      if (json.sukses == false) {
        if (json.error.kode) {
          $('.kodeGroup').addClass('has-error')
          $('.kodeError').text(json.error.kode[0])
        }
        if (json.error.nama) {
          $('.namaGroup').addClass('has-error')
          $('.namaError').text(json.error.nama[0])
        }
        if (json.error.bagian) {
          $('.bagianGroup').addClass('has-error')
          $('.bagianError').text(json.error.bagian[0])
        }
        if (json.error.kepala) {
          $('.kepalaGroup').addClass('has-error')
          $('.kepalaError').text(json.error.kepala[0])
        }
        if (json.error.tipe) {
          $('.tipeGroup').addClass('has-error')
          $('.tipeError').text(json.error.tipe[0])
        }
        if (json.error.penanggungjawab) {
          $('.penanggungjawabGroup').addClass('has-error')
          $('.penanggungjawabError').text(json.error.penanggungjawab[0])
        }
      }
      if (json.sukses == true) {
        $('#modalGudang').modal('hide')
        $('#formGudang')[0].reset()
        $('#viewData').load('/logistikmedik/gudang-data')
      }

    });
  }


</script>
@endsection
