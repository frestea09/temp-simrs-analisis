@extends('master')
@section('header')
  <h1>Mapping Pembedahan (RL 3.6)</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Master Mapping
      </h3>
      {{-- <div class="text-right">
        <a href="{{ url('rekap-laporan/pembedahan/toExcel') }}" class="btn btn-success">Excel</a>
      </div> --}}
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Mapping</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $data['mapping'] as $key => $item)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $item->nama }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" data-id="{{ $item->id }}" data-name="{{ $item->nama }}" class="btn btn-info btn-flat btn-sm edit">
                    <i class="fa fa-edit"></i>
                  </button>
                  <a href="{{ url('rekap-laporan/pembedahan/mapping/'.$item->id) }}" class="btn btn-primary btn-flat btn-sm"><i
                      class="fa fa-map"></i> </a>
                  <button type="button" onclick="detailMapping({{ $item->id }},'{{ $item->nama }}')" class="btn btn-warning btn-flat btn-sm">
                    <i class="fa fa-folder-open"></i>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalMapping" tabindex="-1"  role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="masterMappingForm" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="">
                <div class="form-group" id="mappingGroup">
                  <label for="mapping" class="col-md-3 control-label">Nama Mapping</label>
                  <div class="col-md-9">
                      <input type="text" name="mapping" class="form-control" >
                      <span class="text-danger" id="mappingError"></span>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="saveForm()" class="btn btn-success btn-flat">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modalDetailMapping" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
              <table id="tableDetailMapping" class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tarif</th>
                    <th>Cara Bayar</th>
                    <th>Hapus</th>
                  </tr>
                </thead>
                <tbody> </tbody>
              </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script>
  $(document).on('click','.edit', function(){
    let id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    $('.modal-title').html(name);
    $('input[name="id"]').val(id);
    $('input[name="mapping"]').val(name);
    $('#modalMapping').modal('show');
  })

  function saveForm(){
    $('#masterMappingForm').submit();
  }

  function detailMapping(id, name = '') {
        $('#modalDetailMapping').modal('show')

        $('.modal-title').text('Mapping '+name)

        $('#tableDetailMapping').DataTable({
          'language': {
              "url": "/json/pasien.datatable-language.json",
          },
          paging      : true,
          lengthChange: false,
          searching   : true,
          ordering    : true,
          info        : false,
          autoWidth   : false,
          destroy     : true,
          processing  : true,
          serverSide  : true,
          ajax: '/rekap-laporan/mapping-detail/rl36/'+id,
          columns: [
              {data: 'DT_RowIndex', searchable: false},
              {data: 'nama'},
              {data: 'carabayar'},
              {data: 'total', sClass: 'text-right'},
              {data: 'hapus'}
          ]
        });
    }

    function hapusMapping(mastermapping_id, tarif_id) {
      if (confirm('Yakin akan dihapus') == true) {
        $.ajax({
          url: '/rekap-laporan/hapus-mapping/rl36/'+tarif_id,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(data) {
          detailMapping(data.ref)
        });

      }
    }
</script>
@endsection