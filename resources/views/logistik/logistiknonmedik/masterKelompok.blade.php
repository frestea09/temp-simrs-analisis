@extends('master')
@section('header')
  <h1>Logistik Non Medik - Master Kelompok</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Master Kelompok
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kelompok</th>
                <th>Kode Kelompok</th>
                <th>Kode Golongan</th>
                <th>Kode Bidang</th>
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
                          <label for="nama" class="col-sm-3 control-label">Nama</label>
                              <div class="col-sm-7 namaGroup">
                                  <input type="text" class="form-control" name="nama" placeholder="nama">
                                  <span class="text-danger namaError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-3 control-label">Kode</label>
                              <div class="col-sm-7 kodeGroup">
                                  <input type="text" class="form-control" name="kode" placeholder="kode">
                                  <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-3 control-label">Kode Golongan</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="golongan_id" class="form-control select2" id="golongan_id" style="width:100%"></select>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode" class="col-sm-3 control-label">Kode Bidang</label>
                              <div class="col-sm-7 kodeGroup">
                                  <select name="bidang_id" class="form-control select2" id="bidang_id" style="width:100%"></select>
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
    
    function tambah(){
      $('#Modal').modal('show')
      $('.modal-title').text('Tambah Kelompok')
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')
      $('#form')[0].reset();
    }

    function edit(id){
      $('#Modal').modal('show')
      $('.modal-title').text('Edit Kelompok')
      $('input[name="id"]').val(id)
      $('input[name="_method"]').val('PATCH')
      $.get('/logistiknonmedik/master-kelompok/'+id+'/edit', function(resp){
          $('input[name="nama"]').val(resp.kelompok.nama)
          $('input[name="kode"]').val(resp.kelompok.kode)
          $('select[name="golongan_id"]').val(resp.kelompok.golongan_id).trigger('change')
          $('select[name="bidang_id"]').val(resp.kelompok.bidang_id).trigger('change')
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
            var url = '{{ route('master-kelompok.store') }}'
        } else {
            var url = '/logistiknonmedik/master-kelompok/'+id
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
    ajax: '{{ route('master-kelompok.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'nama'},
        {data: 'kode'},
        {data: 'golongan'},
        {data: 'bidang'},
        {data: 'aksi', searchable: false}
    ]
    });
  </script>
@endsection