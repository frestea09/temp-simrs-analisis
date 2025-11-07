@extends('master')
@section('header')
  <h1>Aturan Pakai Obat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ url('farmasi/etiket/create') }}" class="btn btn-default btn-flat">Tambah</a>
    </div>
    <div class="box-body">
      <div class="col-md-6">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Aturan Pakai</th>
                <th>Edit</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($etiket as $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td> <a class="btn btn-primary btn-sm btn-flat" href="{{ url('farmasi/etiket/'.$d->id.'/edit') }}" role="button"> <i class="fa fa-edit"></i> </a> </td>
                  <td> <a class="btn btn-danger btn-sm btn-flat" onclick="destroy({{ $d->id }})" role="button"> <i class="fa fa-trash"></i> </a> </td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection

<script type="text/javascript">




  function destroy(id) {
    confirm('Are you sure you want to destroy');
    $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
    url: '/farmasi/etiket/delete/'+ id,
    type: 'post',
    async: false,
    processData: false,
    contentType: false,
    success: function() {
      alert('sukses hapus');
      location.reload();
    }
  });
  }



//   //HAPUS
// $('#delete').on('click', function () {
//   confirm($(this).attr('data-id'));
//   $.ajax({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//      },
//     url: 'farmasi/etiket/'+$(this).attr('data-id')+'/delete',
//     type: 'post',
//     async: false,
//     processData: false,
//     contentType: false,
//     success: function() {
//       alert('sukses hapus');
//       location.reload();
//     }
//   });
// });
</script>
