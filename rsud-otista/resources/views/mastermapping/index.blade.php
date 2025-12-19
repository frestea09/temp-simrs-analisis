@extends('master')
@section('header')
  <h1>Master Mapping Tarif INACBG</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Mapping
        <button type="button" onclick="addForm()"  class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> TAMBAH
        </button>

        <a href="{{url('mastermapping/edit-tarif')}}" class="btn btn-default btn-flat">
          <i class="fa fa-edit"></i> EDIT TARIF
        </a>
      </h3>
    </div>
    <div class="box-body">
        <div id="viewMapping"></div>

    </div>
  </div>

  <div class="modal fade" id="modalMapping" tabindex="-1"  role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="masterMappingForm"  method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="id" value="">
                <div class="form-group" id="mappingGroup">
                  <label for="mapping" class="col-md-3 control-label">Nama Mapping</label>
                  <div class="col-md-9">
                      <input type="text" name="mapping" class="form-control" >
                      <span class="text-danger" id="mappingError"></span>
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
         $('#viewMapping').load('{{ route('data-mastermapping') }}')
    });

    $('#masterMappingForm').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });

    function addForm() {
        $('#modalMapping').modal('show');
        $('.modal-title').text('Tambah Mapping')
        $('#mappingGroup').removeClass('has-error');
        $('#mappingError').html('');
        $('#masterMappingForm')[0].reset()
        $('input[name="id"]').val('')
    }

    function editForm(id) {

        $('#modalMapping').modal('show');
        $('.modal-title').text('Edit Mapping')
        $('#mappingGroup').removeClass('has-error');
        $('#mappingError').html('');
        $('#masterMappingForm')[0].reset()

        $.ajax({
            url: '/mastermapping/'+id+'/edit',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('input[name="id"]').val(data.id)
                $('input[name="_method"]').val('PATCH')
                $('input[name="mapping"]').val(data.mapping)
            }
        });

    }

    function saveForm() {
        var id = $('input[name="id"]').val();
        if(id == '') {
            url = '{{ route('mastermapping.store') }}';
        } else {
            url = '/mastermapping/'+id;
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $('#masterMappingForm').serialize(),
            success: function (data) {
                console.log(data);
                if(data.sukses == false) {
                    $('#mappingGroup').addClass('has-error');
                    $('#mappingError').html(data.errors.mapping[0]);
                }

                if(data.sukses == true) {
                    $('#viewMapping').load('{{ route('data-mastermapping') }}')
                    $('#modalMapping').modal('hide');
                }
            }
        });
    }


    function detailMapping(id) {
        $('#modalDetailMapping').modal('show')

        $.ajax({
            url: 'mastermapping/'+id+'/show',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-title').text('Mapping '+data.mapping)
            }
        });


        $('#tableDetailMapping').DataTable({
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
          ajax: '/mappingdetail/'+id,
          columns: [
              {data: 'DT_RowIndex', searchable: false},
              {data: 'nama'},
              {data: 'total', sClass: 'text-right'},
              {data: 'carabayar'},
              {data: 'hapus'}
          ]
        });
    }

    function hapusMapping(mastermapping_id, tarif_id) {
      if (confirm('Yakin akan dihapus') == true) {
        $.ajax({
          url: '/hapus-mapping/'+tarif_id,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(data) {
          detailMapping(mastermapping_id)
        });

      }
    }


</script>
@endsection
