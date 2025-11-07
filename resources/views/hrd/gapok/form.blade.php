@extends('master')

@section('header')
  <h1>Perubahan Gapok</h1>
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
                DATA GAPOK <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>Jenis</th>
                            <th>No. Sk</th>
                            <th>Tgl. SK</th>
                            <th>TMT</th>
                            <th>Gaji Pokok (Rp.)</th>
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

    <div id="modalGapok" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formGapok">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                          <label for="jenis" class="control-label col-sm-2">Jenis</label>
                          <div class="col-sm-10 jenisGroup">
                              <input type="text" name="jenis" class="form-control">
                              <small class="text-danger jenisError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="nosk" class="control-label col-sm-2">No. SK</label>
                          <div class="col-sm-4 noskGroup">
                              <input type="text" name="nosk" class="form-control">
                              <small class="text-danger noskError"></small>
                          </div>
                          <label for="tglsk" class="control-label col-sm-2">Tgl. SK</label>
                          <div class="col-sm-4 tglskGroup">
                              <input type="text" name="tglsk" class="form-control datepicker">
                              <small class="text-danger tglskError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="tmt" class="control-label col-sm-2">TMT</label>
                          <div class="col-sm-4 tmtGroup">
                              <input type="text" name="tmt" class="form-control datepicker">
                              <small class="text-danger tmtError"></small>
                          </div>
                          <label for="gajipokok" class="control-label col-sm-2">Gaji Pokok</label>
                          <div class="col-sm-4 gajipokokGroup">
                              <input type="text" name="gajipokok" class="form-control uang">
                              <small class="text-danger gajipokokError"></small>
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
    $('.uang').maskNumber({
        thousands: ",",
        integer: true,
    });

    function addForm(){
        $('#modalGapok').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Gapok')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formGapok')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get('/hrd/gapok/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalGapok').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Gapok')
        reset()
        $.get('/hrd/gapok/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="jenis"]').val(resp.jenis)
            $('input[name="nosk"]').val(resp.nosk)
            $('input[name="tglsk"]').val(resp.Tglsk)
            $('input[name="tmt"]').val(resp.Tmt)
            $('input[name="gajipokok"]').val(resp.Gajipokok)
        })
    }

    function reset(){
        $('.jenisGroup').removeClass('has-error')
        $('.jenisError').text('');
        $('.noskGroup').removeClass('has-error')
        $('.noskError').text('');
        $('.tglskGroup').removeClass('has-error')
        $('.tglskError').text('');
        $('.tmtGroup').removeClass('has-error')
        $('.tmtError').text('');
        $('.gajipokokGroup').removeClass('has-error')
        $('.gajipokokError').text('');
    }

    function save(){
        var data = $('#formGapok').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/gapok/update/'+id
        }else{
            url = "{{ route('gapok.store') }}"
        }

        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.jenis){
                    $('.jenisGroup').addClass('has-error')
                    $('.jenisError').text(resp.error.jenis[0]);
                }
                if(resp.error.nosk){
                    $('.noskGroup').addClass('has-error')
                    $('.noskError').text(resp.error.nosk[0]);
                }
                if(resp.error.tglsk){
                    $('.tglskGroup').addClass('has-error')
                    $('.tglskError').text(resp.error.tglsk[0]);
                }
                if(resp.error.tmt){
                    $('.tmtGroup').addClass('has-error')
                    $('.tmtError').text(resp.error.tmt[0]);
                }
                if(resp.error.gajipokok){
                    $('.gajipokokGroup').addClass('has-error')
                    $('.gajipokokError').text(resp.error.gajipokok[0]);
                }
            }
            if(resp.sukses == true){
                $('#formGapok')[0].reset()
                $('#modalGapok').modal('hide')
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
        ajax: '{{ route('gapok.data-gapok',$biodata->id) }}',
        columns:[
            {data: 'jenis'},
            {data: 'nosk'},
            {data: 'tglsk'},
            {data: 'tmt'},
            {data: 'gajipokok'},
            {data: 'action', searchable: false}
        ]
    })


</script>
@endsection