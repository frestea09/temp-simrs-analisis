@extends('master')
@section('header')
  <h1>Master Tarif IDRG</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Idrg
        <button type="button" onclick="addForm()"  class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> TAMBAH
        </button>

        <a href="{{url('masteridrg/edit-tarif')}}" class="btn btn-default btn-flat">
          <i class="fa fa-edit"></i> EDIT TARIF
        </a>
      </h3>
    </div>
    <div class="box-body">
        <div id="viewIdrg"></div>

    </div>
  </div>

  <div class="modal fade" id="modalIdrg" tabindex="-1"  role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="masterIdrgForm"  method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="id" value="">
                <div class="form-group" id="idrgGroup">
                  <label for="idrg" class="col-md-3 control-label">Nama Idrg</label>
                  <div class="col-md-9">
                      <input type="text" name="idrg" class="form-control" >
                      <span class="text-danger" id="idrgError"></span>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="saveForm()" class="btn btn-success btn-flat">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(e) {
         $('#viewIdrg').load('{{ route('data-masteridrg') }}')
    });

    $('#masterIdrgForm').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });

    function addForm() {
        $('#modalIdrg').modal('show');
        $('.modal-title').text('Tambah Idrg')
        $('#idrgGroup').removeClass('has-error');
        $('#idrgError').html('');
        $('#masterIdrgForm')[0].reset()
        $('input[name="id"]').val('')
    }

    function editForm(id) {

        $('#modalIdrg').modal('show');
        $('.modal-title').text('Edit Idrg')
        $('#idrgGroup').removeClass('has-error');
        $('#idrgError').html('');
        $('#masterIdrgForm')[0].reset()

        $.ajax({
            url: '/masteridrg/'+id+'/edit',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('input[name="id"]').val(data.id)
                $('input[name="_method"]').val('PATCH')
                $('input[name="idrg"]').val(data.idrg)
            }
        });

    }

    function saveForm() {
        var id = $('input[name="id"]').val();
        if(id == '') {
            url = '{{ route('masteridrg.store') }}';
        } else {
            url = '/masteridrg/'+id;
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $('#masterIdrgForm').serialize(),
            success: function (data) {
                console.log(data);
                if(data.sukses == false) {
                    $('#idrgGroup').addClass('has-error');
                    $('#idrgError').html(data.errors.idrg[0]);
                }

                if(data.sukses == true) {
                    $('#viewIdrg').load('{{ route('data-masteridrg') }}')
                    $('#modalIdrg').modal('hide');
                }
            }
        });
    }


    function detailIdrg(id) {
        $('#modalDetailIdrg').modal('show')

        $.ajax({
            url: 'masteridrg/'+id+'/show',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-title').text('Idrg '+data.idrg)
            }
        });


        $('#tableDetailIdrg').DataTable({
          'language': {
              "url": "/json/pasien.datatable-language.json",
          },
          paging      : true,
          lengthChange: false,
          searching   : true,
          ordering    : true,
          info        : false,
          autoWidth   : false,
          destroy     : true,
          processing  : true,
          serverSide  : true,
          ajax: '/idrgdetail/'+id,
          columns: [
              {data: 'DT_RowIndex', searchable: false},
              {data: 'nama'},
              {data: 'total', sClass: 'text-right'},
              {data: 'carabayar'},
              {data: 'hapus'}
          ]
        });
    }

    function hapusIdrg(masteridrg_id, tarif_id) {
      if (confirm('Yakin akan dihapus') == true) {
        $.ajax({
          url: '/hapus-idrg/'+tarif_id,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(data) {
          detailIdrg(masteridrg_id)
        });

      }
    }


</script>
@endsection
