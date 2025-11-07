@extends('master')
@section('header')
  <h1>Master ICD O IDRG</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master ICD O IDRG&nbsp;
          {{-- <a href="{{ route('icdo-im.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
          <a href="{{ route('icd10-im.import') }}" class="btn btn-default btn-sm">Import</a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
           <table id='pasienData' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>Code</th>
                <th>Code 2</th>
                <th>Nama ICD O IDRG</th>
                <th>IM</th>
                {{-- <th class="text-center">Aksi</th> --}}
              </tr>
            </thead>
            {{-- <tbody>
              @foreach ($icdoim as $data)
                <tr>
                  <td style="width: 5%;">{{ $no++ }}</td>
                  <td>{{ $data->code }}</td>
                  <td>{{ $data->code2 }}</td>
                  <td>{{ $data->description }}</td>
                  <td>{{ $data->im }}</td>
                  <td class="text-center">
                    <a href="{{ route('icdo-im.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>&nbsp;
                    <a href="{{ route('icdo-im.destroy', $data->id) }}" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody> --}}
          </table>
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
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icdo-im/data',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'code', orderable: false},
            {data: 'code2', orderable: false},
            {data: 'description', orderable: false},
            {data: 'im', orderable: false}
        ]
    });
});
  </script>
@endsection
