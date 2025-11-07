@extends('master')
@section('header')
  <h1>Master Mapping Rincian Biaya</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Master Mapping Rincian Biaya
          <a href="{{ url('mapping-biaya-tarif') }}" class="btn btn-default btn-flat">BUAT MAPPING</a>
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" id="dataMappingBiaya">
              <thead>
                <tr>
                  <th>No</th>
                  <th>kelompok</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
    $('#dataMappingBiaya').DataTable({
      'language': {
        "url": "/json/pasien.datatable-language.json",
      },
      paging      : true,
      lengthChange: false,
      searching   : false,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax: '/data-mapping-biaya',
      columns: [
          {data: 'nomorbaris', searchable: false},
          {data: 'kelompok'},
          {data: 'mapping'}
      ]
    });
  </script>
@endsection
