@extends('master')
@section('header')
  <h1>PO </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            Data PO &nbsp; &nbsp;    <a href="{{ url('po-order') }}" class="btn btn-default btn-sm btn-flat">ORDER BARU</a>
        </h3>
      </div>
      <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed tableData'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>No. PO</th>
                  <th>Supplier</th>
                  <th>Tanggal PO</th>
                  <th>Tanggal Penerimaan</th>
                  <th>Petugas</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
      </div>
    </div>

{{-- DETAIL PO --}}
<div class="modal fade" id="detailPO" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
          <table class='table table-striped table-bordered table-hover table-condensed'>
              <tbody>
                 <tr>
                     <th>Tanggal</th> <td id="tanggal">  </td>
                 </tr>
                <tr>
                  <th>No. PO</th> <td id="no_po">  </td>
                </tr>
                <tr>
                  <th>Distributor</th> <td id="distributor">  </td>
                </tr>
                <tr>
                    <th>Petugas</th> <td id='user_create'>  </td>
                </tr>
              </tbody>
          </table>

          <div class='table-responsive'>
            <table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>

                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
    <script type="text/javascript">
    $('.tableData').DataTable({
          'language': {
              'url': '/json/pasien.datatable-language.json',
          },

          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax: '/po-data',
          columns: [
              {data: 'rownum'},
              {data: 'no_po'},
              {data: 'supplier'},
              {data: 'tanggal'},
              {data: 'tgl_penerimaan'},
              {data: 'user_create'},
              {data: 'aksi'}
          ]
    });

    //DETAIL PO
    $(document).on('click', '.view',function () {
        $('#detailPO').modal('show');
        $('.modal-title').text('Detail PO');
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'po-data-detail/'+id,
            type: 'GET',
            success: function (data) {
                $('#tanggal').html(data.tanggal);
                $('#no_po').html(data.po.no_po);
                $('#distributor').html(data.distributor);
                $('#user_create').html(data.po.user_create);
            }
        })

        //DATA DETAIL ON MODAL
            $('#dataDetailPO').DataTable().destroy();
            var table = $('#dataDetailPO').DataTable({
                  'language': {
                      'url': '/json/pasien.datatable-language.json',
                  },
                  lengthChange: false,
                  paging      : false,
                  searching   : false,
                  ordering    : false,
                  autoWidth   : false,
                  processing  : false,
                  info        : false,
                  serverSide  : true,
                  ajax: '/po-detail/'+id,
                  columns: [
                      {data: 'rownum'},
                      {data: 'kode_item'},
                      {data: 'nama_item'},
                      {data: 'jumlah'},
                      {data: 'satuan'},


                  ]
            });

    });


    </script>
@endsection
