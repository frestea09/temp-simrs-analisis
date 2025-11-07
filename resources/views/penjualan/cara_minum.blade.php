@extends('master')
@section('header')
  <h1>Master Cara Minum <small><button class="btn btn-default" id="tambah"> <i class="fa fa-plus"></i> </button></small></h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class='table-responsive'>
            <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th width="10px" class="text-center">No</th>
                  <th>Nama</th>
                  <th>Edit</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($mastercarabayar as $item)
                  <tr>
                    <td width="10px" class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td width="100px" class="text-center">
                        <button type="button" data-id="{{ $item->id }}" class="btn btn-info btn-sm btn-flat edit"> <i class="fa fa-edit"></i> </button>
                    </td>
                    <td width="100px" class="text-center">
                      <button type="button" data-id="{{ $item->id }}" class="btn btn-danger btn-sm btn-flat delete"> <i class="fa fa-trash"></i> </button>
                  </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="form">
             {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" value="">
            <div class="form-group namaGroup">
                <label for="nama" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan nama !" required>
                  <small class="text-danger namaError"></small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-flat" id="save">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
//disabled enter
$('#form').keypress(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});
//Add Form
  $('#tambah').on('click', function () {
    $('#modal').modal('show');
    $('.modal-title').text('Tambah Cara Minum');
    $('#form')[0].reset();
    $('#inputnama').removeClass('has-error');
    $('#nama-error').html("");
  });
//Save Gizi
  $('#save').on('click', function() {
    var id = $('input[name="id"]').val();
    var form_data = new FormData($("#form")[0])

    if(id != ''){
      url = '/penjualan/master-cara-minum/'+id+'';
    } else {
      url = '{{ route('master-cara-minum.store') }}';
    }

    $.ajax({
      url: url,
      type:'POST',
      data: form_data,
      async: false,
      processData: false,
      contentType: false,
      success: function (data) {
        console.log(data);
        if(data.sukses == false) {
          if(data.errors.nama) {
            $('#inputnama').addClass('has-error');
            $('#nama-error').html( data.errors.nama[0] );
          }
        };
        if(data.sukses == true) {
          $('#form')[0].reset();
          $('#modal').modal('hide');
          location.reload();
          //document.location.href = '/mastergizi';
        }
      }
    });
  });

  //EDIT
  $('.edit').on('click', function () {
    $('#modal').modal('show');
    $('.modal-title').text('Ubah Cara Minum');
    $('#inputnama').removeClass('has-error');
    $('#nama-error').html("");
    $('#inputnominal').removeClass('has-error');
     $('#nominal-error').html("");

    $.ajax({
      url: '/penjualan/master-cara-minum/'+$(this).attr('data-id')+'/edit',
      type: 'GET',
      success: function(data) {
        $('input[name="id"]').val(data.id);
        $('input[name="nama"]').val(data.nama);
        $('input[name="_method"]').val('PATCH');
      }
    });
  });

     //HAPUS
  $('.delete').on('click', function () {
    confirm('Yakin Hapus?');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
      url: '/penjualan/master-cara-minum/'+$(this).attr('data-id')+'',
      type: 'delete',
      async: false,
      processData: false,
      contentType: false,
      success: function() {
        alert('sukses hapus');
        location.reload();
      }
    });
  });








</script>
@endsection
