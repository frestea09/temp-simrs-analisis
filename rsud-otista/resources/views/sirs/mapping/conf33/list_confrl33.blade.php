@extends('master')
@section('header')
<h1>Master Mapping CONF.RL33</h1>
@endsection

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            Data CONF.RL33
        </h3>
        <!-- <a href="{{route('table_conf_rl33')}}" class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> Rekap Laporan Mapping CONF.RL33 
        </a> -->
    </div>
    <div class="box-body">
        <div >
            <div class='table-responsive'>
                <table id="viewMapping" class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <!-- <th>Nomer</th> -->
                            <th>Kegiatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            KETERANGAN TOMBOL: <br>
            <button type="button" class="btn btn-info btn-flat btn-sm">
                <i class="fa fa-edit"></i>
            </button> EDIT

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <button type="button" class="btn btn-primary btn-flat btn-sm">
                <i class="fa fa-map"></i>
            </button> MAPPING

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <button type="button" class="btn btn-warning btn-flat btn-sm">
                <i class="fa fa-folder-open"></i>
            </button> DETAIL


            <div class="modal fade" id="modalDetailMapping" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id=""></h4>
                        </div>
                        <div class="modal-body">
                            <div class='table-responsive'>
                                <table id='table_conf_rl33' class='table table-striped table-bordered table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kegiatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="modalMapping" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="masterMappingForm" method="post">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" name="id" value="">
                    <!-- <div class="form-group" id="nomerGroup">
                        <label for="nomer" class="col-md-3 control-label">Nomer Mapping</label>
                        <div class="col-md-9">
                            <input type="text" name="nomer" class="form-control">
                            <span class="text-danger" id="nomerError"></span>
                        </div>
                    </div> -->
                    <div class="form-group" id="kegiatanGroup">
                        <label for="kegiatan" class="col-md-3 control-label">Nama kegiatan</label>
                        <div class="col-md-9">
                            <input type="text" name="kegiatan" class="form-control">
                            <span class="text-danger" id="kegiatanError"></span>
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
        var table = $('#viewMapping').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("data-mastermapping_confrl33") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                // {
                //     data: 'nomer',
                //     name: 'nomer'
                // },
                {
                    data: 'kegiatan',
                    name: 'kegiatan'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
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
        $('#nomerGroup').removeClass('has-error');
        $('#nomerError').html('');
        $('kegiatanGroup').removeClass('has-error');
        $('kegiatanError').html('');
        $('#masterMappingForm')[0].reset()
        $('input[name="id"]').val('')
    }

    function editForm(id) {

        $('#modalMapping').modal('show');
        $('.modal-title').text('Edit Mapping');
        $('#nomerGroup').removeClass('has-error');
        $('#nomerError').html('');
        $('#kegiatanGroup').removeClass('has-error');
        $('#kegiatanError').html('');
        $('#masterMappingForm')[0].reset()
       
        $.ajax({
            url: window.location.origin+window.location.pathname+'/'+id+'/edit',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('input[name="id"]').val(data.id_conf_rl33)
                $('input[name="_method"]').val('PATCH')
                $('input[name="kegiatan"]').val(data.kegiatan)
                // $('input[name="nomer"]').val(data.nomer)
            }
        });

    }

    function saveForm() {
        var id = $('input[name="id"]').val();
        if(id == '') {
            url = '{{ route("mastermapping_confrl33.store") }}';
            type = 'POST';
        } else {
            url = window.location.origin+window.location.pathname+"/"+id;
            type = 'PUT';
        }
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: $('#masterMappingForm').serialize(),
            success: function (data) {
                if(data.sukses == false) {
                    $('#kegiatanGroup').addClass('has-error');
                    $('#kegiatanError').html(data.errors.mapping[0]);
                }

                if(data.sukses == true) {
                    $('#viewMapping').DataTable().ajax.reload();
                    $('#modalMapping').modal('hide');
                }
            }
        });
    }
    function detailconfrl33(id) {
        $('#modalDetailMapping').modal('show')
        $.ajax({
            url: window.location.origin+window.location.pathname+"/"+id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-title').text('Conf.RL33  '+data.kegiatan)
            }
        });


        $('#table_conf_rl33').DataTable({
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
          ajax: '/list-detail-conf-rl33/'+id,
          columns: [
              {data: 'DT_RowIndex', searchable: false},
              {data: 'nama'},
              {data: 'total', sClass: 'text-right'},
              {data: 'hapus'}
          ]
        });
    }

    function hapusMapping(conf_rl33_id, tarif_id) {
      if (confirm('Yakin akan dihapus') == true) {
        $.ajax({
          url: '/hapus-conf-rl33/'+tarif_id,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(data) {
            detailconfrl33(conf_rl33_id)
        });

      }
    }
</script>
@endsection