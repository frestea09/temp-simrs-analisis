@extends('master')

@section('header')
  <h1>Kepangkatan Pegawai</h1>
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
                DATA KEPANGKATAN <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>Jenis</th>
                            <th>Pangkat</th>
                            <th>Gol.Ruang</th>
                            <th>No.SK</th>
                            <th>Tgl.SK</th>
                            <th>TMT Pangkat</th>
                            <th>MKG Thn</th>
                            <th>MKG Bln</th>
                            <th>Gaji Pokok</th>
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

    <div id="modalKepangkatan" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formKepangakatan">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                          <label for="jenis" class="control-label col-sm-2">Jenis</label>
                          <div class="col-sm-4 jenisGroup">
                              <input type="text" name="jenis" class="form-control">
                              <small class="text-danger jenisError"></small>
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
                          <label for="nosk" class="control-label col-sm-2">No SK</label>
                          <div class="col-sm-4 noskGroup">
                              <input type="text" name="nosk" class="form-control">
                              <small class="text-danger noskError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="tglsk" class="control-label col-sm-2">Tgl SK</label>
                          <div class="col-sm-4 tglskGroup">
                              <input type="text" name="tglsk" class="form-control datepicker">
                              <small class="text-danger tglskError"></small>
                          </div>
                          <label for="tmtpangkat" class="control-label col-sm-2">TMT Pangkat</label>
                          <div class="col-sm-4 tmtpangkatGroup">
                              <input type="text" name="tmtpangkat" class="form-control datepicker">
                              <small class="text-danger tmtpangkatError"></small>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="mkgtahun" class="control-label col-sm-2">Mkg Tahun</label>
                          <div class="col-sm-4 mkgtahunGroup">
                              <input type="text" name="mkgtahun" class="form-control">
                              <small class="text-danger mkgtahunError"></small>
                          </div>
                          <label for="mkgbulan" class="control-label col-sm-2">Mkg Bulan</label>
                          <div class="col-sm-4 mkgbulanGroup">
                              <input type="text" name="mkgbulan" class="form-control">
                              <small class="text-danger mkgbulanError"></small>
                          </div>
                        </div>
                        <div class="form-group">
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
    $('.select2').select2()
    $('.uang').maskNumber({
        thousands: ",",
        integer: true,
    });

    function addForm(){
        $('#modalKepangkatan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Kepangkatan')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formKepangakatan')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get(' /hrd/kepangkatan/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalKepangkatan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Kepangkatan')
        reset()
        $.get('/hrd/kepangkatan/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="jenis"]').val(resp.jenis)
            $('input[name="pangkat"]').val(resp.pangkat)
            $('input[name="golongan"]').val(resp.golongan)
            $('input[name="nosk"]').val(resp.nosk)
            $('input[name="tglsk"]').val(resp.tglSK)
            $('input[name="tmtpangkat"]').val(resp.tmtPangkat)
            $('input[name="mkgtahun"]').val(resp.mkgtahun)
            $('input[name="mkgbulan"]').val(resp.mkgbulan)
            $('input[name="gajipokok"]').val(resp.Gajipokok)
        })
    }

    function reset(){
        $('.jenisGroup').removeClass('has-error')
        $('.jenisError').text('');
        $('.pangkatGroup').removeClass('has-error')
        $('.pangkatError').text('');
        $('.golonganGroup').removeClass('has-error')
        $('.golonganError').text('');
        $('.noskGroup').removeClass('has-error')
        $('.noskError').text('');
        $('.tglskGroup').removeClass('has-error')
        $('.tglskError').text('');
        $('.tmtpangkatGroup').removeClass('has-error')
        $('.tmtpangkatError').text('');
        $('.mkgtahunGroup').removeClass('has-error')
        $('.mkgtahunError').text('');
        $('.mkgbulanGroup').removeClass('has-error')
        $('.mkgbulanError').text('');
        $('.gajipokokGroup').removeClass('has-error')
        $('.gajipokokError').text('');
    }

    function save(){
        var data = $('#formKepangakatan').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/kepangkatan/update/'+id
        }else{
            url = "{{ route('kepangkatan.store') }}"
        }
        
        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.jenis){
                    $('.jenisGroup').addClass('has-error')
                    $('.jenisError').text(resp.error.jenis[0]);
                }
                if(resp.error.pangkat){
                    $('.pangkatGroup').addClass('has-error')
                    $('.pangkatError').text(resp.error.pangkat[0]);
                }
                if(resp.error.golongan){
                    $('.golonganGroup').addClass('has-error')
                    $('.golonganError').text(resp.error.golongan[0]);
                }
                if(resp.error.nosk){
                    $('.noskGroup').addClass('has-error')
                    $('.noskError').text(resp.error.nosk[0]);
                }
                if(resp.error.tglsk){
                    $('.tglskGroup').addClass('has-error')
                    $('.tglskError').text(resp.error.tglsk[0]);
                }
                if(resp.error.tmtpangkat){
                    $('.tmtpangkatGroup').addClass('has-error')
                    $('.tmtpangkatError').text(resp.error.tmtpangkat[0]);
                }
                if(resp.error.mkgtahun){
                    $('.mkgtahunGroup').addClass('has-error')
                    $('.mkgtahunError').text(resp.error.mkgtahun[0]);
                }
                if(resp.error.mkgbulan){
                    $('.mkgbulanGroup').addClass('has-error')
                    $('.mkgbulanError').text(resp.error.mkgbulan[0]);
                }
                if(resp.error.gajipokok){
                    $('.gajipokokGroup').addClass('has-error')
                    $('.gajipokokError').text(resp.error.gajipokok[0]);
                }
            }
            if(resp.sukses == true){
                $('#formKepangakatan')[0].reset()
                $('#modalKepangkatan').modal('hide')
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
        ajax: '{{ route('kepangkatan.data-kepangkatan',$biodata->id) }}',
        columns:[
            {data: 'jenis'},
            {data: 'pangkat'},
            {data: 'golongan'},
            {data: 'nosk'},
            {data: 'tglsk'},
            {data: 'tmtpangkat'},
            {data: 'mkgtahun'},
            {data: 'mkgbulan'},
            {data: 'gajipokok'},
            {data: 'action', searchable: false}
        ]
    })


</script>
@endsection