@extends('master')
@section('header')
  <h1>Logistik Medik - Pejabat Pengadaan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Pejabat Pengadaan
        <button class="btn btn-default btn-sm btn-flat" onclick="addPejabat()"><i class="fa fa-plus"> </i> TAMBAH</button>
        {{--  <a href="{{ url('logistikmedik/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>  --}}
      </h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
          <thead>
            <tr>
              <th width="10px" class="text-center">No</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)
                <tr>
                  <td width="10px" class="text-center">{{ $no++ }}</td>
                  <td>{{ $item->nip }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->jabatan }}</td>
                  <td width="10px">
                    <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="editPejabat({{ $item->id }})">
                      <i class="fa fa-edit"></i>
                    </button>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <div class="modal fade" id="addPejabat">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form id="formPejabat" method="post" class="form-horizontal">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id" value="">
              <div class="form-group nipGroup">
                <label for="nip" class="col-sm-3 control-label">NIP</label>
                <div class="col-sm-9">
                  <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP !" required>
                  <small class="text-danger nipError"></small>
                </div>
              </div>
              <div class="form-group namaGroup">
                <label for="nama" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama !" required>
                  <small class="text-danger namaError"></small>
                </div>
              </div>
              <div class="form-group jabatanGroup">
                <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
                <div class="col-sm-9">
                  <input type="text" name="jabatan" class="form-control" placeholder="Masukkan Jabatan !" required>
                  <small class="text-danger jabatanError"></small>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanPejabat()">Simpan</button>
          </div>
        </div>
      </div>
  </div>
@endsection

@section('script')
  <script>
    var status = 0, id = 0
    function addPejabat() {
      status = 0
      $('#addPejabat').modal('show')
      $('.modal-title').text('Tambah Pejabat Pengadaan')
      $('#formPejabat')[0].reset();
    }
    function editPejabat(id){
      status = 1
      $('#addPejabat').modal('show')
      $('.modal-title').text('Edit Pejabat Pengadaan')
      $.get('getPejabat/'+id, function(resp){
        $("input[name='id']").val(resp.id)
        $("input[name='nip']").val(resp.nip)
        $("input[name='nama']").val(resp.nama)
        $("input[name='jabatan']").val(resp.jabatan)
      })
    }
    function simpanPejabat(){
      var data = $('#formPejabat').serialize(), url = '';
      if(status == 0){
        url = '/logistikmedik/pejabatCreate'
      }else{
        url = '/logistikmedik/pejabatUpdate'
      }
      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data,
      }).done(function(json) {
        if(json.success == true){
          location.reload();
        }else{
          if (json.error.nip) {
            $('.nipGroup').addClass('has-error')
            $('.nipError').text(json.error.nip[0])
          }
          if (json.error.nama) {
            $('.namaGroup').addClass('has-error')
            $('.namaError').text(json.error.nama[0])
          }
          if (json.error.jabatan) {
            $('.jabatanGroup').addClass('has-error')
            $('.jabatanError').text(json.error.jabatan[0])
          }
        }
      })
    }
  </script>
@endsection
