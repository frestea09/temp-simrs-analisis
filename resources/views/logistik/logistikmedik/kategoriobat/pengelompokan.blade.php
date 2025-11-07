@extends('master')

@section('header')
  <h1>
    Pengelompokan Obat
    <small><button type="button" onclick="masterObat()" class="btn btn-primary btn-md btn-flat">BUKA</button></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed obatNarkotik">
            <thead>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Kode</th>
                  <th>Tablet</th>
                  <th>Injeksi</th>
                  <th>Infus</th>
                  <th>Obat Luar</th>
                  <th>BHP</th>
                  <th>Sirup</th> 
                  <th>Generik</th>
                  <th>Non Generik</th>
                  <th>Paten</th>
                  <th>Fornas</th>
                  {{-- <th>Non Fornas</th> --}}
                  <th>Formularium</th>
                  <th>Non Formularium</th>
                  <th>E Katalog</th>
                  <th>Lasa</th>
                  <th>Bebas</th>
                  <th>Bebas Terbatas</th>
                  <th>Keras</th>
                  <th>Psikotropik</th>
                  <th>Narkotik</th>
                  <th>Prekusor</th>
                  <th>Antibiotik</th> 
                  <th>High Alert</th>
                </tr>
              </thead>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
    </div>
  </div>

  {{-- Data Obat --}}
  <div class="modal fade" id="dataObat">
    <div class="modal-dialog modal-lg" style="width: 1200px !important">
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
                  <th>Tablet</th>
                  <th>Injeksi</th>
                  <th>Infus</th>
                  <th>Obat Luar</th>
                  <th>BHP</th>
                  <th>Sirup</th> 
                  <th>Generik</th>
                  <th>Non Generik</th>
                  <th>Paten</th>
                  <th>Fornas</th>
                  {{-- <th>Non Fornas</th> --}}
                  <th>Formularium</th>
                  <th>Non Formularium</th>
                  <th>E Katalog</th>
                  <th>Lasa</th>
                  <th>Bebas</th>
                  <th>Bebas Terbatas</th>
                  <th>Keras</th>
                  <th>Psikotropik</th>
                  <th>Narkotik</th>
                  <th>Prekusor</th>
                  <th>Antibiotik</th> 
                  <th>High Alert</th>
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
            <span style="color:red">Simpan terlebih dahulu sebelum ke halaman selanjutnya</span>
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
        ajax: '/data-obat-pengelompokan',
        columns: [
           {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama', orderable: false},
            {data: 'kode', orderable: false},
            {data: 'tablet', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'injeksi', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'infus', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'obat_luar', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'BHP', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'sirup', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'generik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'non_generik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'paten', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'fornas', orderable: false, searchable: false, sClass: 'text-center'},
            // {data: 'non_fornas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'formularium', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'non_formularium', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'e_katalog', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'lasa', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'bebas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'bebas_terbatas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'keras', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'psikotoprik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'narkotik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'prekusor', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'antibiotik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'high_alert', orderable: false, searchable: false, sClass: 'text-center'},


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
        ajax: '/data-master-obat-pengelompokan',
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama', orderable: false},
            {data: 'kode', orderable: false},
            {data: 'tablet', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'injeksi', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'infus', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'obat_luar', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'BHP', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'sirup', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'generik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'non_generik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'paten', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'fornas', orderable: false, searchable: false, sClass: 'text-center'},
            // {data: 'non_fornas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'formularium', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'non_formularium', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'e_katalog', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'lasa', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'bebas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'bebas_terbatas', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'keras', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'psikotoprik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'narkotik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'prekusor', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'antibiotik', orderable: false, searchable: false, sClass: 'text-center'},
            {data: 'high_alert', orderable: false, searchable: false, sClass: 'text-center'},
        ]
    });

  function masterObat() {
    $('#dataObat').modal('show')
    $('.modal-title').text('Pengelompokan Obat')
    $('input[name="kategoriobat"]').val('generik');
  }

  function saveKategori() {
    var data = $('#formMasterObat').serialize()
    $.ajax({
      url: '{{ route('save-kategori-obat-pengelompokan') }}',
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
