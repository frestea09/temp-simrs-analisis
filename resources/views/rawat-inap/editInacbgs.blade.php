@extends('master')
@section('header')
  <h1>Edit INACBGS</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h4>Edit INACBGS</h4>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama </th>
              <th>INACBGS 1/2</th>
              <th>INACBGS 2/3</th>
              <th>DPJP</th>
              <th>Registrasi</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($inacbgs as $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->pasien->no_rm }}</td>
              <td>{{ $d->pasien->nama }}</td>
              <td class="text-right">{{ number_format($d->inacbgs1) }}</td>
              <td class="text-right">{{ number_format($d->inacbgs2) }}</td>
              <td>{{ baca_dokter($d->dokter_id) }}</td>
              <td>{{ $d->created_at->format('d-m-Y') }}</td>
              <td>
                <button type="button" onclick="editForm({{ $d->id }})" class="btn btn-flat btn-success">
                  <i class="fa fa-pencil"></i>
                </button>
              </td>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_ajax">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit INACBGS</h4>
        </div>
        <div class="modal-body" style="height: 300px"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function editForm(id){
      jQuery('#modal_ajax').modal('show');
      // SHOW AJAX RESPONSE ON REQUEST SUCCESS
      $.ajax({
        url: '/rawat-inap/data-inacbgs/'+id,
        success: function (response) {
          jQuery('#modal_ajax .modal-body').html(response);
        }
      });
    }
  </script>

@endsection
@section('script')
    <script>

      $('.table').DataTable({
        autoWidth: false,
        processing: true,
        ordering: false,
      });
    </script>
@endsection