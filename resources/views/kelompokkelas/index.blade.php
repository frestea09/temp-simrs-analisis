@extends('master')
@section('header')
  <h1>Kelompok Kelas / Kamar </h1>
@endsection

@section('content')
    <div class="box box-primary ">
      <div class="box-header with-border">
        <h3 class="box-title">
            Kelompok Kamar&nbsp; &nbsp; <button type="button" onclick="addForm()" class="btn btn-default btn-flat"> <i class="fa fa-plus"></i> </button>
        </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kelompok</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>

<div class="modal fade" id="modalKelompok" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="mappingKamar"  method="post">
          {{ csrf_field() }} {{ method_field('POST') }}
          <input type="hidden" name="id" value="">
          <div class="form-group" id="kelompokGroup">
            <label for="kelompok" class="col-md-3 control-label">Kelompok</label>
            <div class="col-md-9">
            <input type="text" name="kelompok" class="form-control" value="">
              <span class="help-block" id="kelompokError"></span>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" onclick="saveForm()" class="btn btn-primary btn-flat">Simpan</button>
        </div>

      </div>
    </div>
  </div>
</div>


@stop

@section('script')
  <script type="text/javascript">
    var table = $('.table').DataTable({
          'language': {
              'url': '/json/pasien.datatable-language.json',
          },

          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax: '/kelompokkelas/data',
          columns: [
              {data: 'nomorbaris', searchable: false},
              {data: 'kelompok'},
              {data: 'edit', searchable: false}
          ]
    });

    $('#mappingKamar').keypress(function(e){
      var keyCode = e.keyCode || e.which;
      if(keyCode == 13){
        return false;
      }
    })

    function addForm() {
      $('#modalKelompok').modal('show')
      $('.modal-title').text('Kelompok Kelas')
      $('#mappingKamar')[0].reset()
      $('input[name="id"]').val('')
      $('input[name="_method"]').val('POST')

      $('#kelompokGroup').removeClass('has-error')
      $('#kelompokError').html('')

      $('select[name="kelompok"]').on('focus', function() {
        $('#kelompokGroup').removeClass('has-error')
        $('#kelompokError').html('')
      })
    }

    function editForm(id) {
      $('#modalKelompok').modal('show')
      $('.modal-title').text('Edit Kelompok Kelas')
      $('#mappingKamar')[0].reset()
      $('input[name="_method"]').val('PATCH')
      $('#kelompokGroup').removeClass('has-error')
      $('#kelompokError').html('')

      $.ajax({
        url: '/kelompokkelas/'+id+'/edit',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('input[name="id"]').val(data.id)
          $('input[name="kelompok"]').val(data.kelompok)
        }
      })

    }


    function saveForm() {

      var id = $('input[name="id"]').val();
      if( id != "" ){
        url = '/kelompokkelas/'+id
      } else {
        url = '/kelompokkelas/save';
      }
      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: $('#mappingKamar').serialize(),
        success: function (data) {
          console.log(data)
          if(data.sukses == false) {
            $('#kelompokGroup').addClass('has-error')
            $('#kelompokError').html( data.error.kelompok )
          }
          if(data.duplikat == true) {
            $('#kelompokGroup').addClass('has-error')
            $('#kelompokError').html( data.message )
          }
          if(data.sukses == true) {
            $('#mappingKamar')[0].reset()
            $('#modalKelompok').modal('hide')
            table.ajax.reload()
          }
        }
      })
    }

  </script>
@endsection
