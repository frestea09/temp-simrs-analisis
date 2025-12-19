@extends('master')
@section('header')
  <h1>Logistik Non Medik - TRANSFER</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Transfer
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed tabeldata'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor </th>
                <th>Gudang Asal</th>
                <th>Gudang Tujuan</th>
                <th>Tanggal</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    var table;
    table = $('.tabeldata').DataTable({
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
      ajax: '{{ route('nonmediktransfer.index') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false, orderable: false},
          {data: 'nomor'},
          {data: 'asal'},
          {data: 'tujuan'},
          {data: 'tanggal_permintaan'},
          {data: 'aksi', searchable: false}
      ]
    });
  </script>
@endsection
