@extends('master')

@section('header')
  <h1>Master PPI</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
           LAPORAN PPI
      </h3> --}}
    </div>
    <div class="box-body">
        <div class="row">
            <div class="box-header with-border">
                {{-- <i class="fa fa-dashboard"></i> --}}
                <button type="button" class="btn btn-info btn-flat btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> TAMBAH</button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
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
</div>
<div id="Modal" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-horizontal" id="form">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" name="id">
                    <div class="box-body">
                        <div class="form-group">
                        <label for="nama" class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-7 namaGroup">
                                <input type="text" class="form-control" name="nama" value="" placeholder="Name" autofocus>
                                <span class="text-danger namaError"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn bg-orange btn-flat" onclick="save()">SAVE</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">

        function tambah(){
            $('#Modal').modal('show')
            $('.modal-title').text('Tambah Master PPI')
            $('input[name="id"]').val('')
        }

        // function hapus(id){
        //     if(confirm('Yakin transaksi ini akan dihapus ?')){
        //         $('input[name="id"]').val()
        //         $('input[name="_method"]').val('PATCH')
        //         $.get('/hapus-anak/'+id+'/delete', function(resp){
        //             if(resp.sukses == false){
        //                 table.ajax.reload();
        //                 swal(resp.pesan);
        //             }

        //             if (resp.sukses== true) {
        //                 table.ajax.reload();
        //                 swal(resp.pesan);
        //             }  
        //         })
        //     }
        // }

        function edit(id){
            $('#Modal').modal('show')
            $('.modal-title').text('Edit Master PPI')
            $('input[name="id"]').val(id)
            $('input[name="_method"]').val('PATCH')
            $.get('/master-ppi/'+id+'/edit', function(resp){
                $('input[name="nama"]').val(resp.ppi.nama)
            })
        }

        function reset(){
            $('.namaGroup').removeClass('has-error')
            $('.namaError').text('');
        }

        function destroy(id){
            confirm('Yakin akan menghapus data ini?')
            $.ajax({
                url: '/master-ppi/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                success: function(response) {
                    table.ajax.reload();
                    console.log('Delete successful', response);
                },
                error: function(error) {
                    alert('Gagal Hapus Data!')
                    console.error('Delete error', error);
                }
            });
        }

        function save(){
            var data = $('#form').serialize()
            var id = $('input[name="id"]').val()

            if(id == ''){
                var url = '{{ route('master-ppi.store') }}'
            } else {
                var url = '/master-ppi/'+id
            }

            $.post( url, data, function(resp){
                reset()
                if(resp.sukses == false){
                    if(resp.error.nama){
                        $('.namaGroup').addClass('has-error')
                        $('.namaError').text(resp.error.nama[0]);
                    }
                } if(resp.sukses == true){
                    $('#Modal').modal('hide');
                    $('#form')[0].reset();
                    table.ajax.reload();
                }
            })

        }

        var table;
        table = $('.table').DataTable({
        'language': {
            'url': '/DataTables/datatable-language.json',
        },
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: '{{ route('master-ppi.index') }}',
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'nama'},
            {data: 'aksi', searchable: false}
        ]
        });

    </script>
@endsection
