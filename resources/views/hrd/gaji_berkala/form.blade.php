@extends('master')

@section('header')
  <h1>Gaji Berkala Pegawai</h1>
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
                DATA GAJI BERKALA <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>No. SK KGB</th>
                            <th>Tgl SK KGB</th>
                            <th>Pangkat</th>
                            <th>Gol. Ruang</th>
                            <th>Gaji Pokok (Rp.)</th>
                            <th>TMT KGB</th>
                            <th>TMT Y.a.d</th>
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

    <div id="modalGaji" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formGaji">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                          <label for="noskkgb" class="control-label col-sm-2">NO. SKKGB</label>
                          <div class="col-sm-4 noskkgbGroup">
                              <input type="text" name="noskkgb" class="form-control">
                              <small class="text-danger noskkgbError"></small>
                          </div>
                          <label for="tglskkgb" class="control-label col-sm-2">Tgl. SKKGB</label>
                          <div class="col-sm-4 tglskkgbGroup">
                              <input type="text" name="tglskkgb" class="form-control datepicker">
                              <small class="text-danger tglskkgbError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="pangkat" class="control-label col-sm-2">Pangkat</label>
                          <div class="col-sm-4 pangkatGroup">
                              <input type="text" name="pangkat" class="form-control">
                              <small class="text-danger pangkatError"></small>
                          </div>
                          <label for="golongan" class="control-label col-sm-2">Golongan</label>
                          <div class="col-sm-4 golonganGroup">
                              <input type="text" name="golongan" class="form-control">
                              <small class="text-danger golonganError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="gajipokok" class="control-label col-sm-2">Gaji Pokok</label>
                          <div class="col-sm-4 gajipokokGroup">
                              <input type="text" name="gajipokok" class="form-control uang">
                              <small class="text-danger gajipokokError"></small>
                          </div>
                          <label for="tmtkgb" class="control-label col-sm-2">TMT KGB</label>
                          <div class="col-sm-4 tmtkgbGroup">
                              <input type="text" name="tmtkgb" class="form-control datepicker">
                              <small class="text-danger tmtkgbError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="tmtyad" class="control-label col-sm-2">TMT Y.A.D</label>
                          <div class="col-sm-4 tmtyadGroup">
                              <input type="text" name="tmtyad" class="form-control datepicker">
                              <small class="text-danger tmtyadError"></small>
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
        $('#modalGaji').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Gaji')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formGaji')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get(' /hrd/gaji/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalGaji').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Gaji')
        reset()
        $.get('/hrd/gaji/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="noskkgb"]').val(resp.noskkgb)
            $('input[name="tglskkgb"]').val(resp.Tglskkgb)
            $('input[name="pangkat"]').val(resp.pangkat)
            $('input[name="golongan"]').val(resp.golongan)
            $('input[name="gajipokok"]').val(resp.gajipokok)
            $('input[name="tmtkgb"]').val(resp.Tmtkgb)
            $('input[name="tmtyad"]').val(resp.Tmtyad)
        })
    }

    function reset(){
        $('.noskkgbGroup').removeClass('has-error')
        $('.noskkgbError').text('');
        $('.tglskkgbGroup').removeClass('has-error')
        $('.tglskkgbError').text('');
        $('.pangkatGroup').removeClass('has-error')
        $('.pangkatError').text('');
        $('.golonganGroup').removeClass('has-error')
        $('.golonganError').text('');
        $('.gajipokokGroup').removeClass('has-error')
        $('.gajipokokError').text('');
        $('.tmtkgbGroup').removeClass('has-error')
        $('.tmtkgbError').text('');
        $('.tmtyadGroup').removeClass('has-error')
        $('.tmtyadError').text('');
    }

    function save(){
        var data = $('#formGaji').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/gaji/update/'+id
        }else{
            url = "{{ route('gaji.store') }}"
        }

        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.noskkgb){
                    $('.noskkgbGroup').addClass('has-error')
                    $('.noskkgbError').text(resp.error.noskkgb[0]);
                }
                if(resp.error.tglskkgb){
                    $('.tglskkgbGroup').addClass('has-error')
                    $('.tglskkgbError').text(resp.error.tglskkgb[0]);
                }
                if(resp.error.pangkat){
                    $('.pangkatGroup').addClass('has-error')
                    $('.pangkatError').text(resp.error.pangkat[0]);
                }
                if(resp.error.golongan){
                    $('.golonganGroup').addClass('has-error')
                    $('.golonganError').text(resp.error.golongan[0]);
                }
                if(resp.error.gajipokok){
                    $('.gajipokokGroup').addClass('has-error')
                    $('.gajipokokError').text(resp.error.gajipokok[0]);
                }
                if(resp.error.tmtkgb){
                    $('.tmtkgbGroup').addClass('has-error')
                    $('.tmtkgbError').text(resp.error.tmtkgb[0]);
                }
                if(resp.error.tmtyad){
                    $('.tmtyadGroup').addClass('has-error')
                    $('.tmtyadError').text(resp.error.tmtyad[0]);
                }
            }
            if(resp.sukses == true){
                $('#formGaji')[0].reset()
                $('#modalGaji').modal('hide')
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
        ajax: '{{ route('gaji.data-gaji',$biodata->id) }}',
        columns:[
            {data: 'noskkgb'},
            {data: 'tglskkgb'},
            {data: 'pangkat'},
            {data: 'golongan'},
            {data: 'gaji'},
            {data: 'tmtkgb'},
            {data: 'tmtyad'},
            {data: 'action', searchable: false}
        ]
    })


</script>
@endsection