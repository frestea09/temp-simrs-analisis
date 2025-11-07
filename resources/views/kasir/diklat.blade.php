@extends('master')

@section('header')
  <h1>Kasir</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Pembayaran Diklat
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" id="formDiklat" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group namaGroup">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" class="form-control">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Tarif / Diklat</label>
                        <div class="col-sm-9">
                            <select name="tarif_id" class="form-control select2" style="width: 100%">
                                @foreach ($tarif as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }} || Rp. {{ number_format($d->total) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group keteranganGroup">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" name="keterangan" class="form-control">
                            <small class="text-danger keteranganError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-9">
                            <button type="button" onclick="save()" class="btn btn-primary btn-flat">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tarif Diklat</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
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
    $('.select2').select2()
    var table;
    table = $('.table').DataTable({
        "language": {
        "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/kasir/diklat-data',
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'nama'},
            {data: 'namatarif'},
            {data: 'total'},
            {data: 'keterangan'},
            {data: 'aksi'},
        ]
    });

    function resetForm(){
        $('.namaGroup').removeClass('has-error');
        $('.namaError').text('')
        $('.keteranganGroup').removeClass('has-error');
        $('.keteranganError').text('')
    }

    function save(){
        var data = $('#formDiklat').serialize()
        $.post('/kasir/diklat-save', data, function(resp){
            resetForm()
            if(resp.sukses == false){
                if(resp.error.nama){
                    $('.namaGroup').addClass('has-error');
                    $('.namaError').text(resp.error.nama[0])
                }
                if(resp.error.keterangan){
                    $('.keteranganGroup').addClass('has-error');
                    $('.keteranganError').text(resp.error.keterangan[0])
                }
            }
            if(resp.sukses == true){
                $('#formDiklat')[0].reset()
                resetForm()
                table.ajax.reload()
                alert('Pembayaran diklat berhasil disimpan')
            }
        })
    }

    function hapus(id){
        if(confirm('Yakin akan dihapus?')){
            $.get('/kasir/diklat-batal/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload()
                }
            })
        }
    }

</script>
@endsection
