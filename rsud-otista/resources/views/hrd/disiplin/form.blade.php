@extends('master')

@section('header')
  <h1>Disiplin Pegawai</h1>
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
                DATA DISIPLIN <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>Unit Organisasi</th>
                            <th>Unit Kerja</th>
                            <th>Jabatan</th>
                            <th>Nama Disiplin</th>
                            <th>No SK</th>
                            <th>Tgl SK</th>
                            <th>Tmt Disiplin</th>
                            <th>Tmt Daluarsa</th>
                            <th>pelanggaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalDisiplin" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formDisiplin">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="id">
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
                          <label for="jabatan" class="control-label col-sm-2">Jabatan</label>
                          <div class="col-sm-4 jabatanGroup">
                              <input type="text" name="jabatan" class="form-control">
                              <small class="text-danger jabatanError"></small>
                          </div>
                          <label for="namadisiplin" class="control-label col-sm-2">Nama Disiplin</label>
                          <div class="col-sm-4 namadisiplinGroup">
                              <input type="text" name="namadisiplin" class="form-control">
                              <small class="text-danger namadisiplinError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="nosk" class="control-label col-sm-2">No SK</label>
                          <div class="col-sm-4 noskGroup">
                              <input type="text" name="nosk" class="form-control">
                              <small class="text-danger noskError"></small>
                          </div>
                          <label for="tglsk" class="control-label col-sm-2">Tgl SK</label>
                          <div class="col-sm-4 tglskGroup">
                              <input type="text" name="tglsk" class="form-control datepicker">
                              <small class="text-danger tglskError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="tmtdisiplin" class="control-label col-sm-2">TMT Disiplin</label>
                          <div class="col-sm-4 tmtdisiplinGroup">
                              <input type="text" name="tmtdisiplin" class="form-control datepicker">
                              <small class="text-danger tmtdisiplinError"></small>
                          </div>
                          <label for="tmtdaluarsa" class="control-label col-sm-2">TMT Daluarsa</label>
                          <div class="col-sm-4 tmtdaluarsaGroup">
                              <input type="text" name="tmtdaluarsa" class="form-control datepicker">
                              <small class="text-danger tmtdaluarsaError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          
                          <label for="pelanggaran" class="control-label col-sm-2">Pelanggaran</label>
                          <div class="col-sm-4 pelanggaranGroup">
                              <input type="text" name="pelanggaran" class="form-control">
                              <small class="text-danger pelanggaranError"></small>
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
        $('#modalDisiplin').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Disiplin')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formDisiplin')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get('/hrd/disiplin/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalDisiplin').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Disiplin')
        reset()
        $.get('/hrd/disiplin/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="unitorganisasi"]').val(resp.unitorganisasi)
            $('input[name="unitkerja"]').val(resp.unitkerja)
            $('input[name="jabatan"]').val(resp.jabatan)
            $('input[name="namadisiplin"]').val(resp.namadisiplin)
            $('input[name="nosk"]').val(resp.nosk)
            $('input[name="tglsk"]').val(resp.Tglsk)
            $('input[name="tmtdisiplin"]').val(resp.Tmtdisiplin)
            $('input[name="tmtdaluarsa"]').val(resp.Tmtdaluarsa)
            $('input[name="pelanggaran"]').val(resp.pelanggaran)
        })
    }

    function reset(){
        $('.unitorganisasiGroup').removeClass('has-error')
        $('.unitorganisasiError').text('');
        $('.unitkerjaGroup').removeClass('has-error')
        $('.unitkerjaError').text('');
        $('.jabatanGroup').removeClass('has-error')
        $('.jabatanError').text('');
        $('.namadisiplinGroup').removeClass('has-error')
        $('.namadisiplinError').text('');
        $('.noskGroup').removeClass('has-error')
        $('.noskError').text('');
        $('.tglskGroup').removeClass('has-error')
        $('.tglskError').text('');
        $('.tmtdisiplinGroup').removeClass('has-error')
        $('.tmtdisiplinError').text('');
        $('.tmtdaluarsaGroup').removeClass('has-error')
        $('.tmtdaluarsaError').text('');
        $('.pelanggaranGroup').removeClass('has-error')
        $('.pelanggaranError').text('');
    }

    function save(){
        var data = $('#formDisiplin').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/disiplin/update/'+id
        }else{
            url = "{{ route('disiplin.store') }}"
        }

        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.unitorganisasi){
                    $('.unitorganisasiGroup').addClass('has-error')
                    $('.unitorganisasiError').text(resp.error.unitorganisasi[0]);
                }
                if(resp.error.unitkerja){
                    $('.unitkerjaGroup').addClass('has-error')
                    $('.unitkerjaError').text(resp.error.unitkerja[0]);
                }
                if(resp.error.jabatan){
                    $('.jabatanGroup').addClass('has-error')
                    $('.jabatanError').text(resp.error.jabatan[0]);
                }
                if(resp.error.namadisiplin){
                    $('.namadisiplinGroup').addClass('has-error')
                    $('.namadisiplinError').text(resp.error.namadisiplin[0]);
                }
                if(resp.error.nosk){
                    $('.noskGroup').addClass('has-error')
                    $('.noskError').text(resp.error.nosk[0]);
                }
                if(resp.error.tglsk){
                    $('.tglskGroup').addClass('has-error')
                    $('.tglskError').text(resp.error.tglsk[0]);
                }
                if(resp.error.tmtdisiplin){
                    $('.tmtdisiplinGroup').addClass('has-error')
                    $('.tmtdisiplinError').text(resp.error.tmtdisiplin[0]);
                }
                if(resp.error.tmtdaluarsa){
                    $('.tmtdaluarsaGroup').addClass('has-error')
                    $('.tmtdaluarsaError').text(resp.error.tmtdaluarsa[0]);
                }
                if(resp.error.pelanggaran){
                    $('.pelanggaranGroup').addClass('has-error')
                    $('.pelanggaranError').text(resp.error.pelanggaran[0]);
                }
            }
            if(resp.sukses == true){
                $('#formDisiplin')[0].reset()
                $('#modalDisiplin').modal('hide')
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
        ajax: '{{ route('disiplin.data-disiplin',$biodata->id) }}',
        columns:[
            {data: 'unitorganisasi'},
            {data: 'unitkerja'},
            {data: 'jabatan'},
            {data: 'namadisiplin'},
            {data: 'nosk'},
            {data: 'tglsk'},
            {data: 'tmtdisiplin'},
            {data: 'tmtdaluarsa'},
            {data: 'pelanggaran'},
            {data: 'action', searchable: false}
        ]
    })


</script>
@endsection