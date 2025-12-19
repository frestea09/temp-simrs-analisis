@extends('master')
@section('header')
  <h1>Logistik Non Medik - Master Periode</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Master Periode
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Awal Periode</th>
                <th>Akhir Periode</th>
                <th>Awal Transaksi</th>
                <th>Akhir Transaksi</th>
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
    function tambah(){
      $('#Modal').modal('show')
      $('.modal-title').text('Tambah Periode')
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')
      $('#form')[0].reset();
    }

    function edit(id){
      $('#Modal').modal('show')
      $('.modal-title').text('Edit Periode')
      $('input[name="id"]').val(id)
      $('input[name="_method"]').val('PATCH')
      $.get('/logistiknonmedik/master-periode/'+id+'/edit', function(resp){
          $('input[name="nama"]').val(resp.periode.nama)
          $('input[name="periodeAwal"]').val(resp.periode.periodeAwal)
          $('input[name="periodeAkhir"]').val(resp.periode.periodeAkhir)
          $('input[name="transaksiAwal"]').val(resp.periode.transaksiAwal)
          $('input[name="transaksiAkhir"]').val(resp.periode.transaksiAkhir)
      })
    }

    function reset(){
      $('.namaGroup').removeClass('has-error')
      $('.namaError').text('');
      $('.periodeAwalGroup').removeClass('has-error')
      $('.periodeAwalError').text('');
      $('.periodeAkhirGroup').removeClass('has-error')
      $('.periodeAkhirError').text('');
      $('.transaksiAwalGroup').removeClass('has-error')
      $('.transaksiAwalError').text('');
      $('.transaksiAkhirGroup').removeClass('has-error')
      $('.transaksiAkhirError').text('');

    }

    function save(){
        var data = $('#form').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('master-periode.store') }}'
        } else {
            var url = '/logistiknonmedik/master-periode/'+id
        }

        $.post( url, data, function(resp){
            reset()
            if(resp.sukses == false){
              if(resp.error.nama){
                  $('.namaGroup').addClass('has-error')
                  $('.namaError').text(resp.error.nama[0]);
              }
              if(resp.error.periodeAwal){
                  $('.periodeAwalGroup').addClass('has-error')
                  $('.periodeAwalError').text(resp.error.periodeAwal[0]);
              }
              if(resp.error.periodeAkhir){
                  $('.periodeAkhirGroup').addClass('has-error')
                  $('.periodeAkhirError').text(resp.error.periodeAkhir[0]);
              }
              if(resp.error.transaksiAwal){
                  $('.transaksiAwalGroup').addClass('has-error')
                  $('.transaksiAwalError').text(resp.error.transaksiAwal[0]);
              }
              if(resp.error.transaksiAkhir){
                  $('.transaksiAkhirGroup').addClass('has-error')
                  $('.transaksiAkhirError').text(resp.error.transaksiAkhir[0]);
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
    ajax: '{{ route('master-periode.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'nama'},
        {data: 'periodeAwal'},
        {data: 'periodeAkhir'},
        {data: 'transaksiAwal'},
        {data: 'transaksiAkhir'},
        {data: 'aksi', searchable: false}
    ]
    });
  </script>
@endsection