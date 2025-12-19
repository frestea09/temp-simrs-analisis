@extends('master')
@section('header')
  <h1>Logistik Non Medik - Master Gudang</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Master Gudang
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Set Gudang Pusat</th>
                <th>Kode Gudang</th>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
    <div id="gudangModal" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header bg-green">
                  <button class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                  <form method="POST" class="form-horizontal" id="formGudang">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <input type="hidden" name="id">
                      <div class="box-body">
                          <div class="form-group">
                          <label for="set_gudang_pusat" class="col-sm-3 control-label">Set Gudang Pusat</label>
                              <div class="col-sm-7 set_gudang_pusatGroup">
                                  <input type="text" class="form-control" name="set_gudang_pusat" value="" placeholder="set_gudang_pusat">
                                  <span class="text-danger set_gudang_pusatError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kode_gudang" class="col-sm-3 control-label">Kode Gudang</label>
                              <div class="col-sm-7 kode_gudangGroup">
                                  <input type="text" class="form-control" name="kode_gudang" placeholder="kode_gudang">
                                  <span class="text-danger kode_gudangError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="nama" class="col-sm-3 control-label">Nama</label>
                              <div class="col-sm-7 namaGroup">
                                  <input type="text" class="form-control" name="nama" placeholder="nama">
                                  <span class="text-danger namaError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="kepala_gudang" class="col-sm-3 control-label">Kepala Gudang</label>
                              <div class="col-sm-7 kepala_gudangGroup">
                                  <input type="text" class="form-control" name="kepala_gudang" placeholder="kepala_gudang">
                                  <span class="text-danger kepala_gudangError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="gudang_pj" class="col-sm-3 control-label">Gudang PJ</label>
                              <div class="col-sm-7 gudang_pjGroup">
                                  <input type="text" class="form-control" name="gudang_pj" placeholder="gudang_pj">
                                  <span class="text-danger gudang_pjError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="bagian" class="col-sm-3 control-label">Bagian</label>
                              <div class="col-sm-7 bagianGroup">
                                  <input type="text" class="form-control" name="bagian" placeholder="bagian">
                                  <span class="text-danger bagianError"></span>
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
      $('#gudangModal').modal('show')
      $('.modal-title').text('Tambah Gudang')
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')
      $('#formGudang')[0].reset();
    }

    function edit(id){
      $('#gudangModal').modal('show')
      $('.modal-title').text('Edit Gudang')
      $('input[name="id"]').val(id)
      $('input[name="_method"]').val('PATCH')
      $.get('/logistiknonmedik/master-gudang/'+id+'/edit', function(resp){
          $('input[name="set_gudang_pusat"]').val(resp.gudang.set_gudang_pusat)
          $('input[name="kode_gudang"]').val(resp.gudang.kode_gudang)
          $('input[name="nama"]').val(resp.gudang.nama)
          $('input[name="kepala_gudang"]').val(resp.gudang.kepala_gudang)
          $('input[name="gudang_pj"]').val(resp.gudang.gudang_pj)
          $('input[name="bagian"]').val(resp.gudang.bagian)
      })
    }

    function reset(){
      $('.set_gudang_pusatGroup').removeClass('has-error')
      $('.set_gudang_pusatError').text('');
      $('.kode_gudangGroup').removeClass('has-error')
      $('.kode_gudangError').text('');
      $('.namaGroup').removeClass('has-error')
      $('.namaError').text('');
      $('.kepala_gudangGroup').removeClass('has-error')
      $('.kepala_gudangError').text('');
      $('.gudang_pjGroup').removeClass('has-error')
      $('.gudang_pjError').text('');
      $('.bagianGroup').removeClass('has-error')
      $('.bagianError').text('');
    }

    function save(){
        var data = $('#formGudang').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('master-gudang.store') }}'
        } else {
            var url = '/logistiknonmedik/master-gudang/'+id
        }

        $.post( url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.set_gudang_pusat){
                    $('.set_gudang_pusatGroup').addClass('has-error')
                    $('.set_gudang_pusatError').text(resp.error.set_gudang_pusat[0]);
                }
                if(resp.error.kode_gudang){
                    $('.kode_gudangGroup').addClass('has-error')
                    $('.kode_gudangError').text(resp.error.kode_gudang[0]);
                }
                if(resp.error.nama){
                    $('.namaGroup').addClass('has-error')
                    $('.namaError').text(resp.error.nama[0]);
                }
                if(resp.error.kepala_gudang){
                    $('.kepala_gudangGroup').addClass('has-error')
                    $('.kepala_gudangError').text(resp.error.kepala_gudang[0]);
                }
                if(resp.error.gudang_pj){
                    $('.gudang_pjGroup').addClass('has-error')
                    $('.gudang_pjError').text(resp.error.gudang_pj[0]);
                }
                if(resp.error.bagian){
                    $('.bagianGroup').addClass('has-error')
                    $('.bagianError').text(resp.error.bagian[0]);
                }
            } if(resp.sukses == true){
                $('#gudangModal').modal('hide');
                $('#formGudang')[0].reset();
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
    ajax: '{{ route('master-gudang.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'set_gudang_pusat'},
        {data: 'kode_gudang'},
        {data: 'nama'},
        {data: 'aksi', searchable: false}
    ]
    });
  </script>
@endsection
