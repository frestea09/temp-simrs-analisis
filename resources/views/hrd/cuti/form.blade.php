@extends('master')

@section('header')
  <h1>Cuti Pegawai</h1>
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
                        @if( isset($biodata->biodata->foto) )
                        <img src="{{ asset('images/pegawai/'.$biodata->biodata->foto) }}" class="img img-responsive" alt="Foto Pegawai" style="height: 100;">
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama" class="col-sm-4 control-label">Nama Pegawai</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{ $biodata->nama }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">TTL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->tmplahir }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->tgllahir }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">Kelamin / TMT CPNS</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ ($biodata->kelamin == 'L') ? 'Laki - Laki': 'Prempuan'  }}">
                            </div>
                            {{-- <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $biodata->biodata->tmtcpns }}">
                            </div> --}}
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
                DATA CUTI 
            </h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Cuti</th>
                        <th>Diambil</th>
                        {{-- <th>Sisa</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach( $data['jenis_cuti'] as $k => $v )
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $v->nama }}</td>
                        <td>
                            @php
                                $diambil = \App\HRD\HrdCuti::where('pegawai_id',$id)->where('jenis_cuti_id',$v->id)->where('status_final','disetujui')->whereYear('created_at',\Carbon\Carbon::now())->count()
                            @endphp
                            {{ $diambil }}
                        </td>
                        {{-- <td></td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                RIWAYAT CUTI <button type="button" onclick="addForm()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4>
            </h3>
        </div>
        <div class="box-body">
            {{-- <div class="table-responsive"> --}}
                <table class="table table-bordered tabel-condensed table-striped" id="tableRiwayat">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tgl. Mulai</th>
                            <th>Tgl. Selesai</th>
                            <th>Lama</th>
                            <th>Tgl. Pengajuan</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                </table>
            {{-- </div> --}}
        </div>
    </div>

    <div id="modalCuti" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formCuti">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="pegawai_id" value="{{ $biodata->id }}">
                        <input type="hidden" name="biodata_id" value="{{ isset($biodata->biodata->id) ? $biodata->biodata->id : null }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Jenis Cuti Yang Diambil</label>
                        </div><hr>
                        <div class="row">
                          @foreach( $data['jenis_cuti'] as $item )
                          <div class="form-group col-sm-6">
                            <label for="tglmulai" class="control-label col-sm-7" style="font-weight: 100;">{{ $item->nama }}</label>
                            <div class="col-sm-5 tglmulaiGroup" style="margin-top: 6px;">
                                <input type="radio" name="jenis_cuti_id" value="{{ $item->id }}" required>
                            </div>
                          </div>
                          @endforeach
                        </div><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Alasan Cuti</label>
                        </div><hr>
                        <div class="form-group">
                            <label for="tglmulai" class="control-label col-sm-2" style="font-weight: 100;">Alasan</label>
                            <div class="col-sm-10 tglmulaiGroup">
                                <textarea class="form-control" name="alasan_cuti" placeholder="Tulis Alasan Cuti Anda..." required></textarea>
                            </div>
                        </div><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Lama Cuti<label>
                        </div><hr>
                        <div class="form-group">
                          <label for="tglmulai" class="control-label col-sm-2" style="font-weight: 100;" required placeholder="Pilih Tanggal Mulai Cuti">Tgl. Mulai</label>
                          <div class="col-sm-4 tglmulaiGroup">
                              <input type="text" name="tglmulai" class="form-control datepicker">
                              <small class="text-danger tglmulaiError"></small>
                          </div>
                          <label for="tglselesai" class="control-label col-sm-2" style="font-weight: 100;" required placeholder="Pilih Tanggal Selesai Cuti">Tgl. Selesai</label>
                          <div class="col-sm-4 tglselesaiGroup">
                              <input type="text" name="tglselesai" class="form-control datepicker">
                              <small class="text-danger tglselesaiError"></small>
                          </div>
                          {{-- <label for="tglselesai" class="control-label col-sm-2" style="font-weight: 100;">Lama</label>
                          <div class="col-sm-2 tglselesaiGroup">
                              <input type="number" name="lama_cuti" class="form-control">
                          </div> --}}
                        </div><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Alamat Selama Menjalankan Cuti</label>
                        </div><hr>
                        <div class="form-group">
                            <label for="nosk" class="control-label col-sm-2" style="font-weight: 100;">Alamat</label>
                            <div class="col-sm-10 noskGroup">
                                <textarea class="form-control" name="alamat_cuti" placeholder="Tulis Alamat Selama Cuti Anda..." required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nosk" class="control-label col-sm-2" style="font-weight: 100;">Telepon</label>
                            <div class="col-sm-10 noskGroup">
                                <input class="form-control" name="telepon" type="text" placeholder="Tulis No Telp Anda..." required>
                            </div>
                        </div><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Pelimpahan Tugas Selama Cuti</label>
                        </div><hr>
                        <div class="form-group mb-5">
                            <label for="nosk" class="control-label col-sm-2" style="font-weight: 100;">Pilih Pegawai</label>
                            <div class="col-sm-10">
                                <select class="form-control myselect" name="pelimpahan_tugas" id="pelimpahan" required>
                                    <option disabled selected>- Silahkan Pilih -</option>
                                    @foreach($pegawai as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
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
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-save" class="btn btn-primary" onclick="save()">Save</button>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Modal -->
<div id="myModalVerify" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="m-title-view">Menunggu Verifikasi</h4>
        </div>
        <div class="modal-body" id="data-approval">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
  
    </div>
  </div>
@endsection

@section('css')
<style>
    /* span.select2-container {
        z-index:10050;
    } */
    .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
</style>
@endsection

@section('script')
<script type="text/javascript">
    let base_url = "{{ url('/') }}";

    $(".myselect").chosen({ width: '100%' });

    $('.select2').select2({
        width : "100%",
        // dropdownParent: $('#modalCuti')
    });

    function addForm(){
        $('#modalCuti').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Tambah Cuti')
        $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
        $('#formCuti')[0].reset()
        reset()
    }

    function hapus(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get('/hrd/cuti/destroy/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

    function edit(id){
        $('#modalCuti').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Cuti')
        reset()
        $.get('/hrd/cuti/'+id+'/show', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="tglmulai"]').val(resp.Tglmulai)
            $('input[name="tglselesai"]').val(resp.Tglselesai)
            $('input[name="nosk"]').val(resp.nosk)
            $('input[name="tglsk"]').val(resp.Tglsk)
        })
    }

    function verify(id){
        $('#myModalVerify').modal('show');
        $.ajax({
            url: base_url+'/hrd/cuti/verifikator/'+id,
            dataType: 'json',
            type: 'GET',
            cache: false,
            beforeSend: function(){
                $('#data-approval').html('<p class="text-center">Tunggu Sebentar...</p>');
            },
            success: function(res){
                $('#data-approval').html(res.html);
            }
        });
    }

    function reset(){
        $('.tglmulaiGroup').removeClass('has-error')
        $('.tglmulaiError').text('');
        $('.tglselesaiGroup').removeClass('has-error')
        $('.tglselesaiError').text('');
        $('.noskGroup').removeClass('has-error')
        $('.noskError').text('');
        $('.tglskGroup').removeClass('has-error')
        $('.tglskError').text('');
    }

    function save(){
        var data = $('#formCuti').serialize()
        var id = $('input[name="id"]').val()

        if(id != ''){
            url = '/hrd/cuti/update/'+id
        }else{
            url = "{{ route('cuti.store') }}"
        }

        // $('#btn-save').prop('disabled', true);

        $.post(url, data, function(resp){
            // $('#btn-save').prop('disabled', false);
            reset()
            if(resp.sukses == false){
                if(resp.error.tglmulai){
                    $('.tglmulaiGroup').addClass('has-error')
                    $('.tglmulaiError').text(resp.error.tglmulai[0]);
                }
                if(resp.error.tglselesai){
                    $('.tglselesaiGroup').addClass('has-error')
                    $('.tglselesaiError').text(resp.error.tglselesai[0]);
                }
                if(resp.error.nosk){
                    $('.noskGroup').addClass('has-error')
                    $('.noskError').text(resp.error.nosk[0]);
                }
                if(resp.error.tglsk){
                    $('.tglskGroup').addClass('has-error')
                    $('.tglskError').text(resp.error.tglsk[0]);
                }
            }
            if(resp.sukses == true){
                $('#formCuti')[0].reset()
                $('#modalCuti').modal('hide')
                table.ajax.reload();
            }
        })
    }

    var table;
    table = $('#tableRiwayat').DataTable({
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
        ajax: '{{ route('cuti.data-cuti',$biodata->id) }}',
        columns:[
            {data: 'DT_RowIndex', searchable: false},
            {data: 'tglmulai'},
            {data: 'tglselesai'},
            {data: 'lama_cuti'},
            {data: 'created_at'},
            // {data: 'nosk'},
            // {data: 'tglsk'},
            {data: 'alasan_cuti'},
            {data: 'status_final'},
            {data: 'action', searchable: false}
        ]
    })
</script>
@endsection