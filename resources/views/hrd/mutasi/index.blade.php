@extends('master')

@section('header')
  <h1>BIODATA KEPEGAWAIAN MUTASI</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           {{-- KEPEGAWAIAN <a href="{{ route('biodata.create') }}" class="btn btn-default btn-flad">TAMBAH</a> --}}
      </h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table2">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>TTL</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>No Hp</th>
                  <th>Status</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>

  <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Mutasi Pegawai</h4>
      </div>
      <div class="modal-body" style="display:grid;">
        <div class="form-group">
          <label class="col-sm-3 control-label">Nama</label>
          <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">TTL</label>
          <div class="col-sm-9">
              <input type="text" name="ttl" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Alamat</label>
          <div class="col-sm-9">
              <input type="text" name="alamat" class="form-control" readonly>
          </div>
        </div>

        <table class="table table-strip">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Mutasi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody id="dataTable">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

  let base_url = "{{ url('/') }}";

  var table;
    table = $('.table2').DataTable({
      'language': {
          'url': '/DataTables/datatable-language.json',
      },
      select: {
      	style: 'multi'
      },
      ordering: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: '{{ url('hrd/mutasi/data') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'nama'},
          {data: 'ttl'},
          {data: 'kelamin'},
          {data: 'alamat'},
          {data: 'nohp'},
          {data: 'status'},
          {data: 'action', searchable: false}

      ]
    });

    $(document).on('click','.btn-hapus',function(){
      let id = $(this).attr('data-id');
      let body = { "_token" : $('input[name=_token]').val() };
      if( confirm('Yakin Akan Batal Mutasi ?') ){
        $.ajax({
            url: base_url+'/hrd/mutasi/'+id,
            type: "DELETE",
            data: body,
            success: function (res) {
              location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
        });
      }
    })

    $(document).on('click','.btn-detail',function(){
      let id = $(this).attr('data-id');
      $.ajax({
            url: base_url+'/hrd/mutasi/detail/'+id,
            type: "GET",
            success: function (res) {
              $('input[name="nama"]').val(res.data.nama);
              $('input[name="ttl"]').val(res.data.ttl);
              $('input[name="alamat"]').val(res.data.alamat);
              $('#myModal').modal('show');
              $('#dataTable').html(res.html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
        });
    })
</script>
@endsection
