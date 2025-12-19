@extends('master')
@section('header')
  <h1>Master Idrg Rincian Biaya</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Master Idrg Rincian Biaya
          <a href="{{ url('idrg-biaya-tarif') }}" class="btn btn-default btn-flat">BUAT IDRG</a>
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" id="dataIdrgBiaya">
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
    $('#dataIdrgBiaya').DataTable({
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
      ajax: '/data-idrg-biaya',
      columns: [
          {data: 'nomorbaris', searchable: false},
          {data: 'kelompok'},
          {data: 'idrg'}
      ]
    });
  </script>
@endsection
