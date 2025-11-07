@extends('master')

@section('header')
  <h1>RIWAYAT PENDIDIKAN</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           KEPEGAWAIAN <a href="{{ route('pendidikan.create') }}" class="btn btn-default btn-flad">TAMBAH</a>
      </h3>
      </h3>
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                {{--  <th>Bidang / Jurusan</th>
                <th>Sekolah / Kampus</th>
                <th>Status</th>  --}}
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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
      ajax: '{{ route('pendidikan.data-pegawai') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false},
          {data: 'namalengkap'},
          {data: 'action', searchable: false}

      ]
    });

</script>
@endsection
