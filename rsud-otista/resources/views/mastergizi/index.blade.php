@extends('master')
@section('header')
  <h1>Master Gizi <small><button class="btn btn-default" id="tambahGizi"> <i class="fa fa-plus"></i> </button></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-8">
          <div class='table-responsive'>
            <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Gizi</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($gizi as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->gizi }}</td>
                    <td>
                      <button type="button" data-id="{{ $d->id }}" class="btn btn-info btn-sm btn-flat editGizi"> <i class="fa fa-edit"></i> </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


  <div class="modal fade" id="modalGizi" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formGizi">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id" value="">
            <div class="form-group" id="inputGizi">
              <label for="gizi" class="col-md-3">Nama Gizi</label>
              <div class="col-md-9">
                <input type="text" name="gizi" class="form-control" >
                <span class="text-danger"><p id="gizi-error"></p> </span>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-flat" id="saveGizi">Simpan</button>
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
$('#formGizi').keypress(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});
//Add Form
  $('#tambahGizi').on('click', function () {
    $('#modalGizi').modal('show');
    $('.modal-title').text('Tambah Gizi');
    $('#formGizi')[0].reset();
    $('#inputGizi').removeClass('has-error');
    $('#gizi-error').html("");
  });
//Save Gizi
  $('#saveGizi').on('click', function() {
    var id = $('input[name="id"]').val();

    if(id != ''){
      url = '/mastergizi/'+id+'';
    } else {
      url = '{{ route('mastergizi.store') }}';
    }

    $.ajax({
      url: url,
      type:'POST',
      data: $('#formGizi').serialize(),
      success: function (data) {
        console.log(data);
        if(data.errors) {
          if(data.errors.gizi) {
            $('#inputGizi').addClass('has-error');
            $('#gizi-error').html( data.errors.gizi[0] );
          }
        };
        if (data.success == 1) {
          $('#formGizi')[0].reset();
          $('#modalGizi').modal('hide');
          location.reload();
          //document.location.href = '/mastergizi';
        }
      }
    });
  });

  //EDIT
  $('.editGizi').on('click', function () {
    $('#modalGizi').modal('show');
    $('.modal-title').text('Ubah Gizi');
    $('#inputGizi').removeClass('has-error');
    $('#gizi-error').html("");

    $.ajax({
      url: '/mastergizi/'+$(this).attr('data-id')+'/edit',
      type: 'GET',
      success: function(data) {
        $('input[name="id"]').val(data.id);
        $('input[name="gizi"]').val(data.gizi);
        $('input[name="_method"]').val('PATCH');
      }
    });
  });
</script>
@endsection
