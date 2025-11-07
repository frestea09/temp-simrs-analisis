@extends('master')

@section('header')
  <h1>
    <small>Kategori Obat</small> Lasa
    <small><button type="button" onclick="masterObat()" class="btn btn-default btn-sm btn-flat">TAMBAH</button></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed obatNarkotik">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kode</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
    </div>
  </div>

  {{-- Data Obat --}}
  <div class="modal fade" id="dataObat">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formMasterObat">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="kategoriobat" value="">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed" id="dataMasterObat">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Kode</th>
                  <th><button class="btn btn-default btn-flat btn-sm"><i class="fa fa-plus"></i></button></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveKategori()">Simpan</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  var table;
  table = $('.obatNarkotik').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/data-obat-lasa',
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama', orderable: false},
            {data: 'kode', orderable: false},
            {data: 'hapus', orderable: false, searchable: false},
        ]
    });

  //MAster Obat
  var masterobat;
    masterobat = $('#dataMasterObat').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        destroy: true,
        serverSide: true,
        ordering: false,
        ajax: '/data-master-obat/lasa',
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama', orderable: false},
            {data: 'kode', orderable: false},
            {data: 'edit', orderable: false, searchable: false, sClass: 'text-center'},
        ]
    });

  function masterObat() {
    $('#dataObat').modal('show')
    $('.modal-title').text('Tambahkan Obat Lasa')
    $('input[name="kategoriobat"]').val('lasa');
  }

  function saveKategori() {
    var data = $('#formMasterObat').serialize()
    $.ajax({
      url: '{{ route('save-kategori-obat') }}',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(json) {
      if (json.update == true) {
        table.ajax.reload()
        masterobat.ajax.reload()
        alert(json.pesan)
      } else {
        alert(json.pesan)
      }
    });
  }

  function hapusKategori(id, kategori) {
    if (confirm("Yakin akan di hapus?")) {
        $.ajax({
        url: '/hapus-kategori-obat/'+id+'/'+kategori,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        if (json.update == true) {
          table.ajax.reload()
          alert(json.pesan)
        }
      });
    }


  }

</script>
@endsection
