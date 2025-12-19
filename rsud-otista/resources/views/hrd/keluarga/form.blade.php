@extends('master')

@section('header')
  <h1>Keluarga Pegawai</h1>
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
                        <img src="{{ asset('images/pegawai/'.$biodata->foto) }}" class="img img-responsive" alt="Foto Pegawai">
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
    <form method="POST" class="form-horizontal" id="formOrangTua">
        {{ csrf_field() }} {{ method_field('POST') }}
        <input type="hidden" name="biodata_id" value="{{ isset($biodata) ? $biodata->id :NULL }}">
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Data Ayah</h4>
                        <div class="form-group namaayahGroup">
                            <label for="namaayah" class="col-sm-4 control-label">Nama Lengkap Ayah</label>
                            <div class="col-sm-8">
                                <input type="text" name="namaayah" class="form-control" value="{{ isset($keluarga) ? $keluarga->namaayah :NULL }}">
                                <small class="text-danger namaayahError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">TTL</label>
                            <div class="col-sm-4 tmplahirayahGroup">
                                <input type="text" name="tmplahirayah" class="form-control" value="{{ isset($keluarga) ? $keluarga->tmplahirayah :NULL }}">
                                <small class="text-danger tmplahirayahError"></small>
                            </div>
                            <div class="col-sm-4 tgllahirayahGroup">
                                <input type="text" name="tgllahirayah" class="form-control datepicker" value="{{ isset($keluarga) ? $keluarga->tanggalLahirAyah :NULL }}">
                                <small class="text-danger tgllahirayahError"></small>
                            </div>
                        </div>
                        <div class="form-group alamatayahGroup">
                            <label for="alamatayah" class="col-sm-4 control-label">Alamat Tinggal</label>
                            <div class="col-sm-8">
                                <input type="text" name="alamatayah" class="form-control" value="{{ isset($keluarga) ? $keluarga->alamatayah :NULL }}">
                                <small class="text-danger alamatayahError"></small>
                            </div>
                        </div>
                        <div class="form-group nohpayahGroup">
                            <label for="nohpayah" class="col-sm-4 control-label">Telepone</label>
                            <div class="col-sm-8">
                                <input type="text" name="nohpayah" class="form-control" value="{{ isset($keluarga) ? $keluarga->nohpayah :NULL }}">
                                <small class="text-danger nohpayahError"></small>
                            </div>
                        </div>
                        <div class="form-group pekerjaanayah_idGroup">
                            <label for="pekerjaanayah_id" class="col-sm-4 control-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 kerja" name="pekerjaanayah_id">
                                    @foreach ($pekerjaan as $item)
                                        @if (isset($keluarga) && $keluarga->pekerjaanayah_id == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger pekerjaanayah_idError"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-success">
                    <div class="box-body">
                        <h4>Data Ibu</h4>
                        <div class="form-group namaibuGroup">
                            <label for="namaibu" class="col-sm-4 control-label">Nama Lengkap Ibu</label>
                            <div class="col-sm-8">
                                <input type="text" name="namaibu" class="form-control" value="{{ isset($keluarga) ? $keluarga->namaibu :NULL }}">
                                <small class="text-danger namaibuError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">TTL</label>
                            <div class="col-sm-4 tmplahiribuGroup">
                                <input type="text" name="tmplahiribu" class="form-control" value="{{ isset($keluarga) ? $keluarga->tmplahiribu :NULL }}">
                                <small class="text-danger tmplahiribuError"></small>
                            </div>
                            <div class="col-sm-4 tgllahiribuGroup">
                                <input type="text" name="tgllahiribu" class="form-control datepicker"  value="{{ isset($keluarga) ? $keluarga->tanggalLahirIbu :NULL }}">
                                <small class="text-danger tgllahiribuError"></small>
                            </div>
                        </div>
                        <div class="form-group alamatibuGroup">
                            <label for="alamatibu" class="col-sm-4 control-label">Alamat Tinggal</label>
                            <div class="col-sm-8">
                                <input type="text" name="alamatibu" class="form-control" value="{{ isset($keluarga) ? $keluarga->alamatibu :NULL }}">
                                <small class="text-danger alamatibuError"></small>
                            </div>
                        </div>
                        <div class="form-group nohpibuGroup">
                            <label for="nohpibu" class="col-sm-4 control-label">Telepone</label>
                            <div class="col-sm-8">
                                <input type="text" name="nohpibu" class="form-control" value="{{ isset($keluarga) ? $keluarga->nohpibu :NULL }}">
                                <small class="text-danger nohpibuError"></small>
                            </div>
                        </div>
                        <div class="form-group pekerjaanibu_idGroup">
                            <label for="pekerjaanibu_id" class="col-sm-4 control-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 kerja" name="pekerjaanibu_id">
                                    @foreach ($pekerjaan as $item)
                                        @if (isset($keluarga) && $keluarga->pekerjaanibu_id == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger pekerjaanibu_idError"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-warning">
                    <div class="box-body">
                        <h4>Data Pasangan</h4>
                        <div class="form-group namapasanganGroup">
                            <label for="namapasangan" class="col-sm-4 control-label">Nama Lengkap Pasangan</label>
                            <div class="col-sm-8">
                                <input type="text" name="namapasangan" class="form-control" value="{{ isset($keluarga) ? $keluarga->namapasangan :NULL }}">
                                <small class="text-danger namapasanganError"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ttl" class="col-sm-4 control-label">TTL</label>
                            <div class="col-sm-4 tmplahirpasanganGroup">
                                <input type="text" name="tmplahirpasangan" class="form-control"  value="{{ isset($keluarga) ? $keluarga->tmplahirpasangan :NULL }}">
                                <small class="text-danger tmplahirpasanganError"></small>
                            </div>
                            <div class="col-sm-4 tgllahirpasanganGroup">
                                <input type="text" name="tgllahirpasangan" class="form-control datepicker" value="{{ isset($keluarga) ? $keluarga->tanggalLahirPasangan :NULL }}">
                                <small class="text-danger tgllahirpasanganError"></small>
                            </div>
                        </div>
                        <div class="form-group tglnikahGroup">
                            <label for="tglnikah" class="col-sm-4 control-label">Tanggal Nikah</label>
                            <div class="col-sm-8">
                                <input type="text" name="tglnikah" class="form-control datepicker" value="{{ isset($keluarga) ? $keluarga->tanggalNikah :NULL }}">
                                <small class="text-danger tglnikahError"></small>
                            </div>
                        </div>
                        <div class="form-group pendidikan_idGroup">
                            <label for="pendidikan_id" class="col-sm-4 control-label">Pendidikan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="pendidikan_id">
                                    @foreach ($pendidikan as $item)
                                        @if (isset($keluarga) && $keluarga->pendidikan_id == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->pendidikan }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->pendidikan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger pendidikan_idError"></small>
                            </div>
                        </div>
                        <div class="form-group pekerjaanpasangan_idGroup">
                            <label for="pekerjaanpasangan_id" class="col-sm-4 control-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 kerja" name="pekerjaanpasangan_id">
                                    @foreach ($pekerjaan as $item)
                                        @if (isset($keluarga) && $keluarga->pekerjaanpasangan_id == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger pekerjaanpasangan_idError"></small>
                            </div>
                        </div>
                         <button class="btn btn-primary btn-flat pull-right" type="button" onclick="save()">SIMPAN</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Data Anak <button type="button" onclick="tambahAnak()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> TAMBAH</button></h4> 
                        <div class="table-responsive">
                            <table class="table table-bordered tabel-condensed table-striped">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle">No</th>
                                        <th class="text-center" style="vertical-align: middle">Nama Anak</th>
                                        <th class="text-center" style="vertical-align: middle">L/P</th>
                                        <th class="text-center" style="vertical-align: middle">TTL</th>
                                        <th class="text-center" style="vertical-align: middle">Anak Ke</th>
                                        <th class="text-center" style="vertical-align: middle">Pendidikan</th>
                                        <th class="text-center" style="vertical-align: middle">Pekerjaan</th>
                                        <th class="text-center" style="width:70px; vertical-align: middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <div class="modal fade" id="modalAnak" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="form-horizontal" id="formAnak">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <input type="hidden" name="biodata_id" value="{{ isset($biodata) ? $biodata->id :NULL }}">
                            <input type="hidden" name="id" value="">
                            <div class="form-group namaGroup">
                                <label for="nama" class="control-label col-sm-4">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama" class="form-control">
                                    <small class="text-danger namaError"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tmplahir" class="control-label col-sm-4">TTL</label>
                                <div class="col-sm-4 tmplahirGroup">
                                    <input type="text" name="tmplahir" class="form-control">
                                    <small class="text-danger tmplahirError"></small>
                                </div>
                                <div class="col-sm-4 tgllahirGroup">
                                    <input type="text" name="tgllahir" class="form-control datepicker">
                                    <small class="text-danger tgllahirError"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelamin" class="control-label col-sm-4">Kelamin / Anakke</label>
                                <div class="col-sm-4 kelaminGroup">
                                    <select class="form-control select2" name="kelamin" style="width:100%">
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <small class="text-danger kelaminError"></small>
                                </div>
                                <div class="col-sm-4 anakkeGroup">
                                    <select class="form-control select2" name="anakke" style="width:100%">
                                        @for ($i = 1; $i < 20; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <small class="text-danger anakkeError"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_id" class="control-label col-sm-4">Pendidikan / Pekerjaan</label>
                                <div class="col-sm-4 pendidikan_idGroup">
                                    <select class="form-control select2" name="pendidikan_id" style="width:100%;">
                                    </select>
                                    <small class="text-danger pendidikan_idError"></small>
                                </div>
                                <div class="col-sm-4 pekerjaan_idGroup">
                                    <select class="form-control select2" name="pekerjaan_id" style="width:100%;">
                                    </select>
                                    <small class="text-danger pekerjaan_idError"></small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveDataAnak()">Save</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2()
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
      ajax: '{{ route('keluarga.data-anak',$biodata->id) }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'nama'},
          {data: 'kelamin'},
          {data: 'ttl'},
          {data: 'anakke'},
          {data: 'sekolah'},
          {data: 'kerja'},
          {data: 'action', searchable: false}

      ]
    });

    function resetAnak(){
        $('.namaGroup').removeClass('has-error')
        $('.namaError').text('');
        $('.tmplahirGroup').removeClass('has-error')
        $('.tmplahirError').text('');
        $('.tgllahirGroup').removeClass('has-error')
        $('.tgllahirError').text('');
    }

    function saveDataAnak(){
        var data = $('#formAnak').serialize()
        var id = $('input[name="id"]').val()
        if(id != ''){
            url = '/hrd/keluarga/update-anak/'+id
        }else{
            url = "{{ route('keluarga.save-anak') }}"
        }

        $.post(url, data, function(resp){
            resetAnak()
            if(resp.sukses == false){
                if(resp.error.nama){
                    $('.namaGroup').addClass('has-error')
                    $('.namaError').text(resp.error.nama[0]);
                }
                if(resp.error.tmplahir){
                    $('.tmplahirGroup').addClass('has-error')
                    $('.tmplahirError').text(resp.error.tmplahir[0]);
                }
                if(resp.error.tgllahir){
                    $('.tgllahirGroup').addClass('has-error')
                    $('.tgllahirError').text(resp.error.tgllahir[0]);
                }
            }
            if(resp.sukses == true){
                $('#formAnak')[0].reset()
                $('#modalAnak').modal('hide')
                table.ajax.reload();
            }
        })
    }

    function reset(){
        $('.namaayahGroup').removeClass('has-error')
        $('.namaayahError').text('');
        $('.tmplahirayahGroup').removeClass('has-error')
        $('.tmplahirayahError').text('');
        $('.tgllahirayahGroup').removeClass('has-error')
        $('.tgllahirayahError').text('');
        $('.alamatayahGroup').removeClass('has-error')
        $('.alamatayahError').text('');
        $('.nohpayahGroup').removeClass('has-error')
        $('.nohpayahError').text('');
        $('.pekerjaanayah_idGroup').removeClass('has-error')
        $('.pekerjaanayah_idError').text('');
        $('.namaibuGroup').removeClass('has-error')
        $('.namaibuError').text('');
        $('.tmplahiribuGroup').removeClass('has-error')
        $('.tmplahiribuError').text('');
        $('.tgllahiribuGroup').removeClass('has-error')
        $('.tgllahiribuError').text('');
        $('.alamatibuGroup').removeClass('has-error')
        $('.alamatibuError').text('');
        $('.nohpibuGroup').removeClass('has-error')
        $('.nohpibuError').text('');
        $('.pekerjaanibu_idGroup').removeClass('has-error')
        $('.pekerjaanibu_idError').text('');
        $('.namapasanganGroup').removeClass('has-error')
        $('.namapasanganError').text('');
        $('.tmplahirpasanganGroup').removeClass('has-error')
        $('.tmplahirpasanganError').text('');
        $('.tgllahirpasanganGroup').removeClass('has-error')
        $('.tgllahirpasanganError').text('');
        $('.tglnikahGroup').removeClass('has-error')
        $('.tglnikahError').text('');
        $('.pendidikan_idGroup').removeClass('has-error')
        $('.pendidikan_idError').text('');
        $('.pekerjaanpasangan_idGroup').removeClass('has-error')
        $('.pekerjaanpasangan_idError').text('');              
    }

    function save(){
       var data = $('#formOrangTua').serialize()
       var id = $('input[name="id"]').val()

       $.post("{{ route('keluarga.store') }}", data, function(resp){
            reset()
            if(resp.sukses == false){
                if(resp.error.namaayah){
                    $('.namaayahGroup').addClass('has-error')
                    $('.namaayahError').text(resp.error.namaayah[0]);
                }
                if(resp.error.tmplahirayah){
                    $('.tmplahirayahGroup').addClass('has-error')
                    $('.tmplahirayahError').text(resp.error.tmplahirayah[0]);
                }
                if(resp.error.tgllahirayah){
                    $('.tgllahirayahGroup').addClass('has-error')
                    $('.tgllahirayahError').text(resp.error.tgllahirayah[0]);
                }
                if(resp.error.alamatayah){
                    $('.alamatayahGroup').addClass('has-error')
                    $('.alamatayahError').text(resp.error.alamatayah[0]);
                }
                if(resp.error.nohpayah){
                    $('.nohpayahGroup').addClass('has-error')
                    $('.nohpayahError').text(resp.error.nohpayah[0]);
                }
                if(resp.error.pekerjaanayah_id){
                    $('.pekerjaanayah_idGroup').addClass('has-error')
                    $('.pekerjaanayah_idError').text(resp.error.pekerjaanayah_id[0]);
                }
                if(resp.error.namaibu){
                    $('.namaibuGroup').addClass('has-error')
                    $('.namaibuError').text(resp.error.namaibu[0]);
                }
                if(resp.error.tmplahiribu){
                    $('.tmplahiribuGroup').addClass('has-error')
                    $('.tmplahiribuError').text(resp.error.tmplahiribu[0]);
                }
                if(resp.error.tgllahiribu){
                    $('.tgllahiribuGroup').addClass('has-error')
                    $('.tgllahiribuError').text(resp.error.tgllahiribu[0]);
                }
                if(resp.error.alamatibu){
                    $('.alamatibuGroup').addClass('has-error')
                    $('.alamatibuError').text(resp.error.alamatibu[0]);
                }
                if(resp.error.nohpibu){
                    $('.nohpibuGroup').addClass('has-error')
                    $('.nohpibuError').text(resp.error.nohpibu[0]);
                }
                if(resp.error.pekerjaanibu_id){
                    $('.pekerjaanibu_idGroup').addClass('has-error')
                    $('.pekerjaanibu_idError').text(resp.error.pekerjaanibu_id[0]);
                }
                if(resp.error.namapasangan){
                    $('.namapasanganGroup').addClass('has-error')
                    $('.namapasanganError').text(resp.error.namapasangan[0]);
                }
                if(resp.error.tmplahirpasangan){
                    $('.tmplahirpasanganGroup').addClass('has-error')
                    $('.tmplahirpasanganError').text(resp.error.tmplahirpasangan[0]);
                }
                if(resp.error.tgllahirpasangan){
                    $('.tgllahirpasanganGroup').addClass('has-error')
                    $('.tgllahirpasanganError').text(resp.error.tgllahirpasangan[0]);
                }
                if(resp.error.tglnikah){
                    $('.tglnikahGroup').addClass('has-error')
                    $('.tglnikahError').text(resp.error.tglnikah[0]);
                }
                if(resp.error.pendidikan_id){
                    $('.pendidikan_idGroup').addClass('has-error')
                    $('.pendidikan_idError').text(resp.error.pendidikan_id[0]);
                }
                if(resp.error.pekerjaanpasangan_id){
                    $('.pekerjaanpasangan_idGroup').addClass('has-error')
                    $('.pekerjaanpasangan_idError').text(resp.error.pekerjaanpasangan_id[0]);
                }
                
            }
            if(resp.sukses == true){
                location.reload();
            }
       })
    }

    function tambahAnak(){
      $('#modalAnak').modal({
        backdrop : 'static',
        keyboard : false,
      })
       $('.modal-title').text('Tambah Anak')
       $('input[name="_method"]').val('POST')
        $('input[name="id"]').val('')
       $('#formAnak')[0].reset()
       resetAnak()
    }
    
    $.get("{{ route('keluarga.data-pendidikan') }}", function(resp){
        $('select[name="pendidikan_id"]').empty()
        $.each(resp, function(index, val){
            $('select[name="pendidikan_id"]').append("<option value='"+val.id+"'>"+val.pendidikan+"</option>")
        })
    })

    $.get("{{ route('keluarga.data-pekerjaan') }}", function(resp){
        $('select[name="pekerjaan_id"]').empty()
        $.each(resp, function(index, val){
            $('select[name="pekerjaan_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
        })
    })

    function editAnak(id){
        $('#modalAnak').modal({
            backdrop : 'static',
            keyboard : false,
        })
        $('.modal-title').text('Edit Anak')
        resetAnak()
        $.get('/hrd/keluarga/'+id+'/edit-anak', function(resp){  
            $('input[name="_method"]').val('PUT') 
            $('input[name="id"]').val(resp.id)
            $('input[name="biodata_id"]').val(resp.biodata_id) 
            $('input[name="nama"]').val(resp.nama)
            $('input[name="tmplahir"]').val(resp.tmplahir)
            $('input[name="tgllahir"]').val(resp.tanggalLahir)
            $('select[name="kelamin"]').val(resp.kelamin).trigger('change')
            $('select[name="anakke"]').val(resp.anakke).trigger('change')
            $('select[name="pendidikan_id"]').val(resp.pendidikan_id).trigger('change')
            $('select[name="pekerjaan_id"]').val(resp.pekerjaan_id).trigger('change')
        })
    }

    function hapusAnak(id){
        if(confirm('Yakin data ini akan dihapus?')){
            $.get('/hrd/keluarga/hapus-anak/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload();
                }
            })
        }
    }

</script>
@endsection