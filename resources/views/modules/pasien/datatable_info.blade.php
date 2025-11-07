@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class='table-responsive'>
          <table id='pasienData' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>No. RM</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>L/P</th>
                <th>Tgl Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                @if (Auth::user()->hasRole(['administrator','rekammedis','admission','loketigd'])) 
                <th style="width:15%;">Edit / View / Histori / TTD</th>
                @else
                  <th>View / Histori</th>
                @endif
              </tr>
            </thead>

          </table>
        </div>

      </div>
    </div>

    <div class="modal fade" id="pasienModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Data Lengkap Pasien</h4>
          </div>
          <div class="modal-body">
            <div id="dataPasien"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
    $(function() {
    $('#pasienData').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
            searchPlaceholder: "No RM/Nama/Tgl Lahir"
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/pasien/getdata-datatable-info',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'nik', orderable: false},
            {data: 'kelamin', orderable: false},
            {data: 'tgllahir', orderable: false},
            {data: 'umur', orderable: false},
            {data: 'alamat', orderable: false},
            {data: 'kelurahan', orderable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});
  </script>
@endsection
