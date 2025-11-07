@extends('master')

@section('header')
  <h1>Master Mapping CONF.RL.31</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data CONF.RL31 &nbsp;
          <a href="{{ url('mastermapping_confrl31/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='conf31'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nomer</th>
                <th>Kegiatan</th>
                <th>Kamar</th>
                <th>Edit</th>
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
  $(function () {
    
    var table = $('#conf31').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        ajax: "{{ route('confrl31.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomer', name: 'nomer'},
            {data: 'kegiatan', name: 'kegiatan'},
            {data: 'kamar', name: 'kamar'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection
