@extends('master')

@section('header')
  <h1>Pendidikan Pegawai</h1>
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
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                DATA PENDIDIKAN <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered tabel-condensed table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center" style="vertical-align: middle">No</th>
                            <th class="text-center" style="vertical-align: middle">Pendidikan</th>
                            <th class="text-center" style="vertical-align: middle">Bidang/Jurusan</th>
                            <th class="text-center" style="vertical-align: middle">Sekolah/Kampus</th>
                            <th class="text-center" style="vertical-align: middle">Status</th>
                            <th class="text-center" style="vertical-align: middle">Akreditasi</th>
                            <th class="text-center" style="vertical-align: middle">Alamat Sekolah</th>
                            <th class="text-center" style="vertical-align: middle">Tgl.STTB</th>
                            <th class="text-center" style="vertical-align: middle">Tahun Masuk</th>
                            <th class="text-center" style="vertical-align: middle">Tahun Lulus</th>
                            <th class="text-center" style="vertical-align: middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalPendidikan" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="post" class="form-horizontal" id="fromPendidikan">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="biodata_id" value="{{ isset($biodata) ? $biodata->id :NULL }}">
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="pendidikan_id" class="control-label col-sm-2">Pendidikan</label>
                            <div class="col-sm-4 pendidikan_idGroup">
                                <select class="form-control select2" name="pendidikan_id" style="width:100%;">
                                </select>
                                <small class="text-danger pendidikan_idError"></small>
                            </div>
                            <label for="jurusan" class="control-label col-sm-2">Jurusan</label>
                            <div class="col-sm-4 jurusanGroup">
                                <input type="text" name="jurusan" class="form-control">
                                <small class="text-danger jurusanError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sekolah" class="control-label col-sm-2">Sekolah</label>
                            <div class="col-sm-4 sekolahGroup">
                                <input type="text" class="form-control" name="sekolah">
                                <small class="text-danger sekolahError"></small>
                            </div>
                            <label for="status" class="control-label col-sm-2">Status</label>
                            <div class="col-sm-4 statusGroup">
                                <input type="text" class="form-control" name="status">
                                <small class="text-danger statusError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="akreditasi" class="control-label col-sm-2">Akreditasi</label>
                            <div class="col-sm-4 akreditasiGroup">
                                <input type="text" class="form-control" name="akreditasi">
                                <small class="text-danger akreditasiError"></small>
                            </div>
                            <label for="alamatsekolah" class="control-label col-sm-2">Alamat</label>
                            <div class="col-sm-4 alamatsekolahGroup">
                                <input type="text" class="form-control" name="alamatsekolah">
                                <small class="text-danger alamatsekolahError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tglsttb" class="control-label col-sm-2">Tgl STTB</label>
                            <div class="col-sm-4 tglsttbGroup">
                                <input type="text" class="form-control datepicker" name="tglsttb">
                                <small class="text-danger tglsttbError"></small>
                            </div>
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tahunmasuk" class="control-label col-sm-2">Th. Masuk</label>
                            <div class="col-sm-4 tahunmasukGroup">
                                <select class="form-control select2" name="tahunmasuk" style="width:100%">
                                    @for ($i = 1945; $i < date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger tahunmasukError"></small>
                            </div>
                            <label for="tahunlulus" class="control-label col-sm-2">Th. Lulus</label>
                            <div class="col-sm-4 tahunlulusGroup">
                                <select class="form-control select2" name="tahunlulus" style="width:100%">
                                    @for ($i = 1945; $i < date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger tahunlulusError"></small>
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

    function addForm(){
        $('#modalPendidikan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Pendidikan')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#fromPendidikan')[0].reset()
        reset()
    }

    function edit(id){
        $('#modalPendidikan').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Anak')
        reset()
        $.get('/hrd/pendidikan/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="jurusan"]').val(resp.jurusan)
            $('input[name="sekolah"]').val(resp.sekolah)
            $('input[name="alamatsekolah"]').val(resp.alamatsekolah)
            $('input[name="status"]').val(resp.status)
            $('input[name="akreditasi"]').val(resp.akreditasi)
            $('input[name="tglsttb"]').val(resp.tanggalSTTB)
            $('select[name="tahunmasuk"]').val(resp.tahunmasuk).trigger('change')
            $('select[name="tahunlulus"]').val(resp.tahunlulus).trigger('change')
            $('select[name="pendidikan_id"]').val(resp.pendidikan_id).trigger('change')
        })
    }

    function reset(){
        $('.jurusanGroup').removeClass('has-error')
        $('.jurusanError').text('');
        $('.sekolahGroup').removeClass('has-error')
        $('.sekolahError').text('');
        $('.statusGroup').removeClass('has-error')
        $('.statusError').text('');
        $('.akreditasiGroup').removeClass('has-error')
        $('.akreditasiError').text('');
        $('.alamatsekolahGroup').removeClass('has-error')
        $('.alamatsekolahError').text('');
        $('.tglsttbGroup').removeClass('has-error')
        $('.tglsttbError').text('');
    }

    function save(){
        var data = $('#fromPendidikan').serialize()
        var id = $('input[name="id"]').val()
        
        if(id != ''){
            url = '/hrd/pendidikan/update/'+id
        }else{
            url = "{{ route('pendidikan.store') }}"
        }
        
        $.post(url, data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.jurusan){
                    $('.jurusanGroup').addClass('has-error')
                    $('.jurusanError').text(resp.error.jurusan[0]);
                }
                if(resp.error.sekolah){
                    $('.sekolahGroup').addClass('has-error')
                    $('.sekolahError').text(resp.error.sekolah[0]);
                }
                if(resp.error.status){
                    $('.statusGroup').addClass('has-error')
                    $('.statusError').text(resp.error.status[0]);
                }
                if(resp.error.akreditasi){
                    $('.akreditasiGroup').addClass('has-error')
                    $('.akreditasiError').text(resp.error.akreditasi[0]);
                }
                if(resp.error.alamatsekolah){
                    $('.alamatsekolahGroup').addClass('has-error')
                    $('.alamatsekolahError').text(resp.error.alamatsekolah[0]);
                }
                if(resp.error.tglsttb){
                    $('.tglsttbGroup').addClass('has-error')
                    $('.tglsttbError').text(resp.error.tglsttb[0]);
                }
                
            }
            if(resp.sukses == true){
                $('#fromPendidikan')[0].reset()
                $('#modalPendidikan').modal('hide')
                table.ajax.reload();
            }
        })
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get('/hrd/pendidikan/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    $.get("{{ route('pendidikan.data-pendidikan') }}", function(resp){
        $('select[name="pendidikan_id"]').empty()
        $.each(resp, function(index, val){
            $('select[name="pendidikan_id"]').append("<option value='"+val.id+"'>"+val.pendidikan+"</option>")
        })
    })

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
      ajax: '{{ route('pendidikan.pendidikan',$biodata->id) }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'Pendidikan'},
          {data: 'jurusan'},
          {data: 'sekolah'},
          {data: 'status'},
          {data: 'akreditasi'},
          {data: 'alamatsekolah'},
          {data: 'tglsttb'},
          {data: 'tahunmasuk'},
          {data: 'tahunlulus'},
          {data: 'action', searchable: false}

      ]
    });

</script>
@endsection