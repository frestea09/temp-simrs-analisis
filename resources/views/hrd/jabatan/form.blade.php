@extends('master')

@section('header')
  <h1>Jabatan Pegawai</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                KEPEGAWAIAN
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <form class="form-horizontal">
                    <div class="col-sm-2">
                        <img src="{{ asset('images/pegawai/'.$biodata->foto) }}" class="img img-responsive" alt="Foto Pegawai" style="height: 100;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama" class="col-sm-4 control-label">Nama Pegawai</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{ $biodata->namalengkap }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">TTL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->tmplahir }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->pendidikan_id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">Kelamin / TMT CPNS</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ ($biodata->kelamin == 'L') ? 'Laki - Laki': 'Prempuan'  }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->tmtcpns }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Unit Organisasi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{configrs()->nama}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Unit Kerja</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{configrs()->nama}}" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                DATA JABATAN <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>Nama Jabatan</th>
                            <th>Fungsional Tertentu</th>
                            <th>Unit Organisasi</th>
                            <th>Unit Kerja</th>
                            <th>Eselon</th>
                            <th>Pangkat</th>
                            <th>Gol.Ruang</th>
                            <th>Tgl.SK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalJabatan" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formJabatan">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                          <label for="namajabatan" class="control-label col-sm-2">Nama Jabatan</label>
                          <div class="col-sm-4 namajabatanGroup">
                              <input type="text" name="namajabatan" class="form-control">
                              <small class="text-danger namajabatanError"></small>
                          </div>
                          <label for="fungsionaltertentu" class="control-label col-sm-2">Fungsional Tertentu</label>
                          <div class="col-sm-4 fungsionaltertentuGroup">
                              <input type="text" name="fungsionaltertentu" class="form-control">
                              <small class="text-danger fungsionaltertentuError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="unitorganisasi" class="control-label col-sm-2">Unit Organisasi</label>
                          <div class="col-sm-4 unitorganisasiGroup">
                              <input type="text" name="unitorganisasi" class="form-control">
                              <small class="text-danger unitorganisasiError"></small>
                          </div>
                          <label for="unitkerja" class="control-label col-sm-2">Unit Kerja</label>
                          <div class="col-sm-4 unitkerjaGroup">
                              <input type="text" name="unitkerja" class="form-control">
                              <small class="text-danger unitkerjaError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="eselon" class="control-label col-sm-2">Eselon</label>
                          <div class="col-sm-4 eselonGroup">
                              <input type="text" name="eselon" class="form-control">
                              <small class="text-danger eselonError"></small>
                          </div>
                          <label for="pangkat" class="control-label col-sm-2">Pangkat</label>
                          <div class="col-sm-4 pangkatGroup">
                              <input type="text" name="pangkat" class="form-control">
                              <small class="text-danger pangkatError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="golongan" class="control-label col-sm-2">Golongan</label>
                          <div class="col-sm-4 golonganGroup">
                              <input type="text" name="golongan" class="form-control">
                              <small class="text-danger golonganError"></small>
                          </div>
                          <label for="tglsk" class="control-label col-sm-2">Tanggal SK</label>
                          <div class="col-sm-4 tglskGroup">
                              <input type="text" name="tglsk" class="form-control datepicker">
                              <small class="text-danger tglskError"></small>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
<script type="text/javascript">

    function addForm(){
        $('#modalJabatan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Jabatan')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formJabatan')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get(' /hrd/jabatan/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalJabatan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Jabatan')
        reset()
        $.get('/hrd/jabatan/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="namajabatan"]').val(resp.namajabatan)
            $('input[name="fungsionaltertentu"]').val(resp.fungsionaltertentu)
            $('input[name="unitorganisasi"]').val(resp.unitorganisasi)
            $('input[name="unitkerja"]').val(resp.unitkerja)
            $('input[name="eselon"]').val(resp.eselon)
            $('input[name="pangkat"]').val(resp.pangkat)
            $('input[name="golongan"]').val(resp.golongan)
            $('input[name="tglsk"]').val(resp.tglSK)
        })
    }

    function reset(){
        $('.namajabatanGroup').removeClass('has-error')
        $('.namajabatanError').text('');
        $('.fungsionaltertentuGroup').removeClass('has-error')
        $('.fungsionaltertentuError').text('');
        $('.unitorganisasiGroup').removeClass('has-error')
        $('.unitorganisasiError').text('');
        $('.unitkerjaGroup').removeClass('has-error')
        $('.unitkerjaError').text('');
        $('.eselonGroup').removeClass('has-error')
        $('.eselonError').text('');
        $('.pangkatGroup').removeClass('has-error')
        $('.pangkatError').text('');
        $('.golonganGroup').removeClass('has-error')
        $('.golonganError').text('');
        $('.tglskGroup').removeClass('has-error')
        $('.tglskError').text('');
    }

    function save(){
        var data = $('#formJabatan').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/jabatan/update/'+id
        }else{
            url = "{{ route('jabatan.store') }}"
        }

        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.namajabatan){
                    $('.namajabatanGroup').addClass('has-error')
                    $('.namajabatanError').text(resp.error.namajabatan[0]);
                }
                if(resp.error.fungsionaltertentu){
                    $('.fungsionaltertentuGroup').addClass('has-error')
                    $('.fungsionaltertentuError').text(resp.error.fungsionaltertentu[0]);
                }
                if(resp.error.unitorganisasi){
                    $('.unitorganisasiGroup').addClass('has-error')
                    $('.unitorganisasiError').text(resp.error.unitorganisasi[0]);
                }
                if(resp.error.unitkerja){
                    $('.unitkerjaGroup').addClass('has-error')
                    $('.unitkerjaError').text(resp.error.unitkerja[0]);
                }
                if(resp.error.eselon){
                    $('.eselonGroup').addClass('has-error')
                    $('.eselonError').text(resp.error.eselon[0]);
                }
                if(resp.error.pangkat){
                    $('.pangkatGroup').addClass('has-error')
                    $('.pangkatError').text(resp.error.pangkat[0]);
                }
                if(resp.error.golongan){
                    $('.golonganGroup').addClass('has-error')
                    $('.golonganError').text(resp.error.golongan[0]);
                }
                if(resp.error.tglsk){
                    $('.tglskGroup').addClass('has-error')
                    $('.tglskError').text(resp.error.tglsk[0]);
                }
            }
            if(resp.sukses == true){
                $('#formJabatan')[0].reset()
                $('#modalJabatan').modal('hide')
                table.ajax.reload();
            }
        })
    }

    var table;
    table = $('.table').DataTable({
        'language': {
            'url': '/DataTables/datatable-language.json',
        },
        select: {
            style: 'multi'
        },
        ordering: false,
        autoWidth: false,
        searching: false,
        paging: false,
        lengthChange: false,
        info: false,
        processing: true,
        serverSide: true,
        ajax: '{{ route('jabatan.data-jabatan',$biodata->id) }}',
        columns:[
            {data: 'namajabatan'},
            {data: 'fungsionaltertentu'},
            {data: 'unitorganisasi'},
            {data: 'unitkerja'},
            {data: 'eselon'},
            {data: 'pangkat'},
            {data: 'golongan'},
            {data: 'tglsk'},
            {data: 'action', searchable: false}
        ]
    })


</script>
@endsection