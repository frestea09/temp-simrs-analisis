@extends('master')
@section('header')
  <h1>Histori User Login <small></small>
    <button class="btn btn-success btn-flat" onclick="download()"><i class="fa fa-download"></i> Download</button>
  </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed">
          <thead>
            <tr class="bg-primary">
              <th>No</th>
              <th>Nama</th>
              <th>IP Address</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>

<div class="modal fade" id="modalDownload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="formTglHistori" accept-charset="utf-8">
          <div class="form-group">
            <label for="tga" class="col-sm-3 control-label">Tanggal Awal</label>
            <div class="col-sm-9">
              <input type="text" name="tga" value="{{ date('1-m-Y') }}" class="form-control datepicker">
            </div>
          </div>
          <div class="form-group">
            <label for="tgb" class="col-sm-3 control-label">Tanggal Akhir</label>
            <div class="col-sm-9">
              <input type="text" name="tgb" value="{{ date('d-m-Y') }}" class="form-control datepicker">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success btn-flat" onclick="downloadExcel()">Download</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    function downloadExcel() {
      tga = $('input[name="tga"]').val()
      tgb = $('input[name="tgb"]').val()
      window.location.href = '/histori-user-excel/'+tga+'/'+tgb
    }
    function download() {
      $('#modalDownload').modal('show')
      $('.modal-title').text('Download Excel Histori')
    }

    //SHOW DATA
    var table;
    var bulan = $('input[name="bulan"]').val()
    $('input[name="bulan"]').change(function() {
      bulan = $(this).val();
      table.ajax.reload();
    });

    table = $('.table').DataTable({
      'language': {
          'url': '/json/pasien.datatable-language.json',
      },
      autoWidth: false,
      processing: true,
      serverSide: true,
      ordering: false,
      ajax: '/histori-user-data/'+bulan,
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'nama'},
          {data: 'ip_address'},
          {data: 'tanggal'},
      ]
    });

  </script>
@endsection
