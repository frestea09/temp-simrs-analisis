<div class="col-md-12">
    <button type="button" class="btn btn-primary btn-new-{{ $type }}"> <i class="fa fa-plus"></i> Tambah Baru</button>
</div>
<hr>
<table class="table table-striped table-bordered table-hover table-condensed dataTable no-footer" id="data-{{ $type }}">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th class="text-center">Aksi</th>
            <th class="text-center">Pilih</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $data as $key => $val )
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $val->nama }}</td>
            <td>{{ $val->alamat }}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-editx" data-type="{{ $type }}" data-id="{{ $val->id }}" data-name="{{ $val->nama }}" data-source='[{
                    "nama": "{{ $val->nama }}",
                    "alamat": "{{ $val->alamat }}"
                }]'><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-deletex" data-type="{{ $type }}" data-id="{{ $val->id }}" data-name="{{ $val->nama }}"><i class="fa fa-trash-o"></i></button>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-pilihx" data-type="{{ $type }}" data-id="{{ $val->id }}" data-name="{{ $val->nama }}"><i class="fa fa-check"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#data-{{ $type }}').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
</script>