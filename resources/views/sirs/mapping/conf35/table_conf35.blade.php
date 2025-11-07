@extends('master')
@section('header')
<h1>Table Mapping CONF.RL36</h1>
@endsection

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            Data CONF.RL36
        </h3>
        <!-- <a href="{{route('mastermapping_confrl36.index')}}" class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> List Mapping CONF.RL36 
        </a>         -->
    </div>
    <div class="box-body">
        <div>
            <div class='table-responsive'>
                <table id="viewMapping" class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Propinsi</th>
                            <th>KAB/KOTA</th>
                            <th>Kode RS</th>
                            <th>Nama RS</th>
                            <th>Tahun</th>
                            <th>Jenis Kegiatan</th>
                            <!-- <th>Nomer</th> -->
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


            <div class="modal fade" id="modalDetailMapping" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id=""></h4>
                        </div>
                        <div class="modal-body">
                            <div class='table-responsive'>
                                <table id='table_conf_rl36' class='table table-striped table-bordered table-hover table-condensed'>
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
                    <div class="form-group" id="nomerGroup">
                        <label for="nomer" class="col-md-3 control-label">Nomer Mapping</label>
                        <div class="col-md-9">
                            <input type="text" name="nomer" class="form-control">
                            <span class="text-danger" id="nomerError"></span>
                        </div>
                    </div>
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
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
@endsection
@section('script')
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"> </script>
<script type="text/javascript">
    $(document).ready(function(e) {
        var table = $('#viewMapping').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"html5buttons">Blfrtip',
            language: {
                buttons: {
                    colvis: 'show / hide', // label button show / hide
                    colvisRestore: "Reset Kolom" //lael untuk reset kolom ke default
                }
            },
            buttons: [{
                    extend: 'excel',
                    title: 'CONF RL 3.7'
                },

            ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'all']
            ],
            ajax: {
                url: '{{ route("data-mastermapping_confrl36") }}',
                data: {
                    jenis: 'laporan'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                {
                    data: 'kode_propinsi',
                    name: 'kode_propinsi'
                },
                {
                    data: 'kabupaten',
                    name: 'kabupaten'
                },
                {
                    data: 'kode_rs',
                    name: 'kode_rs'
                },
                {
                    data: 'nama_rs',
                    name: 'nama_rs'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'kegiatan',
                    name: 'kegiatan'
                },
                // {
                //     data: 'nomer',
                //     name: 'nomer'
                // },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
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
            url: window.location.origin + window.location.pathname + '/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('input[name="id"]').val(data.id_conf_rl36)
                $('input[name="_method"]').val('PATCH')
                $('input[name="kegiatan"]').val(data.kegiatan)
                $('input[name="nomer"]').val(data.nomer)
            }
        });

    }

    function saveForm() {
        var id = $('input[name="id"]').val();
        if (id == '') {
            url = '{{ route("mastermapping_confrl36.store") }}';
            type = 'POST';
        } else {
            url = window.location.origin + window.location.pathname + "/" + id;
            type = 'PUT';
        }
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: $('#masterMappingForm').serialize(),
            success: function(data) {
                if (data.sukses == false) {
                    $('#kegiatanGroup').addClass('has-error');
                    $('#kegiatanError').html(data.errors.mapping[0]);
                }

                if (data.sukses == true) {
                    $('#viewMapping').DataTable().ajax.reload();
                    $('#modalMapping').modal('hide');
                }
            }
        });
    }

    function detailconfrl36(id) {
        $('#modalDetailMapping').modal('show')
        $.ajax({
            url: window.location.origin + window.location.pathname + "/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('.modal-title').text('Conf.RL36  ' + data.kegiatan)
            }
        });


        $('#table_conf_rl36').DataTable({
            'language': {
                "url": "/json/pasien.datatable-language.json",
            },
            paging: true,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: false,
            autoWidth: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: '/list-detail-conf-rl36/' + id,
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'total',
                    sClass: 'text-right'
                },
                {
                    data: 'hapus'
                }
            ]
        });
    }

    function hapusMapping(conf_rl36_id, tarif_id) {
        if (confirm('Yakin akan dihapus') == true) {
            $.ajax({
                    url: '/hapus-conf-rl36/' + tarif_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    detailconfrl36(conf_rl36_id)
                });

        }
    }
</script>

@endsection