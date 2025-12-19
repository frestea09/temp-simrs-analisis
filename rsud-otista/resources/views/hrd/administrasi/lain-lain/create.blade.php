@extends('master')

@section('header')
  <h1>Lain-lain</h1>
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
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>TTL</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>No Hp</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  var table;
    table = $('.table').DataTable({
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
      ajax: '{{ route('biodata.data') }}',
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

</script>
@endsection
