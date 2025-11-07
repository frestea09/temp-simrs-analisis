@extends('master')
@section('header')
  <h1>Logistik Non Medik - Suplier Non Medik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Suplier Non Medik
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
                <th>Kode</th>
                <th>No SPK</th>
                {{--  <th>Alamat</th>
                <th>Status</th>
                <th>Telepon</th>
                <th>Kontak</th>  --}}
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
                          <label for="kode" class="col-sm-3 control-label">Kode</label>
                              <div class="col-sm-7 kodeGroup">
                                  <input type="text" class="form-control" name="kode" value="" placeholder="kode">
                                  <span class="text-danger kodeError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="no_spk" class="col-sm-3 control-label">No SPK</label>
                              <div class="col-sm-7 no_spkGroup">
                                  <input type="text" class="form-control" name="no_spk" placeholder="no_spk">
                                  <span class="text-danger no_spkError"></span>
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
                          <label for="alamat" class="col-sm-3 control-label"> Alamat</label>
                              <div class="col-sm-7 alamatGroup">
                                  <input type="text" class="form-control" name="alamat" placeholder="alamat">
                                  <span class="text-danger alamatError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="jenis_kelamin" class="col-sm-3 control-label">Jenis Kelamin</label>
                              <div class="col-sm-7 jenis_kelaminGroup">
                                  <select class="form-control select2" name="jenis_kelamin" style="width :100%">
                                      <option value="l">Laki-Laki</option>
                                      <option value="p">Perempuan</option>
                                  </select>
                                  <span class="text-danger jenis_kelaminError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="telepon" class="col-sm-3 control-label">telepon</label>
                              <div class="col-sm-7 teleponGroup">
                                  <input type="text" class="form-control" name="telepon" placeholder="telepon">
                                  <span class="text-danger teleponError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                          <label for="contact" class="col-sm-3 control-label">Kontak</label>
                              <div class="col-sm-7 contactGroup">
                                  <input type="text" class="form-control" name="contact" placeholder="contact">
                                  <span class="text-danger contactError"></span>
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
    function tambah(){
      $('#Modal').modal('show')
      $('.modal-title').text('Tambah Supplier')
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')
      $('#form')[0].reset();
    }

    function edit(id){
      $('#Modal').modal('show')
      $('.modal-title').text('Edit Supplier')
      $('input[name="id"]').val(id)
      $('input[name="_method"]').val('PATCH')
      $.get('/logistiknonmedik/supplier-nonmedik/'+id+'/edit', function(resp){
          $('input[name="kode"]').val(resp.suplier.kode)
          $('input[name="no_spk"]').val(resp.suplier.no_spk)
          $('input[name="nama"]').val(resp.suplier.nama)
          $('input[name="alamat"]').val(resp.suplier.alamat)
          $('input[name="jenis_kelamin"]').val(resp.suplier.jenis_kelamin)
          $('input[name="telepon"]').val(resp.suplier.telepon)
          $('input[name="contact"]').val(resp.suplier.contact)
      })
    }

    function reset(){
      $('.kodeGroup').removeClass('has-error')
      $('.kodeError').text('');
      $('.no_spkGroup').removeClass('has-error')
      $('.no_spkError').text('');
      $('.namaGroup').removeClass('has-error')
      $('.namaError').text('');
      $('.alamatGroup').removeClass('has-error')
      $('.alamatError').text('');
      $('.jenis_kelaminGroup').removeClass('has-error')
      $('.jenis_kelaminError').text('');
      $('.teleponGroup').removeClass('has-error')
      $('.teleponError').text('');
      $('.contactGroup').removeClass('has-error')
      $('.contactError').text('');
    }

    function save(){
        var data = $('#form').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('supplier-nonmedik.store') }}'
        } else {
            var url = '/logistiknonmedik/supplier-nonmedik/'+id
        }

        $.post( url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.kode){
                    $('.kodeGroup').addClass('has-error')
                    $('.kodeError').text(resp.error.kode[0]);
                }
                if(resp.error.no_spk){
                    $('.no_spkGroup').addClass('has-error')
                    $('.no_spkError').text(resp.error.no_spk[0]);
                }
                if(resp.error.nama){
                    $('.namaGroup').addClass('has-error')
                    $('.namaError').text(resp.error.nama[0]);
                }
                if(resp.error.alamat){
                    $('.alamatGroup').addClass('has-error')
                    $('.alamatError').text(resp.error.alamat[0]);
                }
                if(resp.error.jenis_kelamin){
                    $('.jenis_kelaminGroup').addClass('has-error')
                    $('.jenis_kelaminError').text(resp.error.jenis_kelamin[0]);
                }
                if(resp.error.telepon){
                    $('.teleponGroup').addClass('has-error')
                    $('.teleponError').text(resp.error.telepon[0]);
                }
                if(resp.error.contact){
                    $('.contactGroup').addClass('has-error')
                    $('.contactError').text(resp.error.contact[0]);
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
    ajax: '{{ route('supplier-nonmedik.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'nama'},
        {data: 'kode'},
        {data: 'no_spk'},
        {data: 'aksi', searchable: false}
    ]
    });
  </script>
@endsection
