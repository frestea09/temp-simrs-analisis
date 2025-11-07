@extends('master')

@section('header')
  <h1>Parkir</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           LAPORAN KEUANGAN PARKIR
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <form class="form-horizontal" id="formParkir" method="POST">
                <div class="col-sm-6">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jenis Kendaraan</label>
                        <div class="col-sm-8">
                            <select name="jenis" class="form-control select2" style="width: 100%">
                                <option value="1">Kendaraan Roda 2</option>
                                <option value="2">Kendaraan Roda 4 atau lebih</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group tarifGroup">
                        <label class="col-sm-4 control-label">Besaran Tarif</label>
                        <div class="col-sm-8">
                            <input type="text" name="tarif" value="" onkeyup="hitungTotal()" class="form-control uang">
                            <small class="text-danger tarifError"></small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group jmlKendaraanGroup">
                        <label class="col-sm-4 control-label">Jumlah Kendaraan</label>
                        <div class="col-sm-8">
                            <input type="text" name="jml_kendaraan" onkeyup="hitungTotal()" value="" class="form-control uang">
                            <small class="text-danger jml_kendaraanError"></small>
                        </div>
                    </div>
                    <div class="form-group Group">
                        <label class="col-sm-4 control-label">Total</label>
                        <div class="col-sm-8">
                            <input type="text" name="total" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-8">
                            <button type="button" onclick="save()" class="btn btn-primary btn-flat">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="10px" class="text-center">No</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Tarif</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Pendapatan</th>
                        <th class="text-center" width="120px">Aksi</th>
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
    var table = $('.table').DataTable({
        "language": {
        "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/parkir/data-parkir',
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'jenis'},
            {data: 'tarif'},
            {data: 'jml_kendaraan'},
            {data: 'total'},
            {data: 'aksi'},
        ]
    });
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function hitungTotal(){
        var tarif = $('input[name="tarif"]').val()
        var jml = $('input[name="jml_kendaraan"]').val()
        var tarifRp = parseInt(tarif.split(',').join(""));
        var jumlah = parseInt(jml.split(',').join(""));
        var total = tarifRp * jumlah
        $('input[name="total"]').val(ribuan(total))
    }

    function resetForm(){
        $('.tarifGroup').removeClass('has-error');
        $('.tarifError').text('')
        $('.jmlKendaraanGroup').removeClass('has-error');
        $('.jml_kendaraanError').text('')
    }

    function save(){
        var data = $('#formParkir').serialize()
        $.post('/parkir-save', data, function(resp){
            resetForm()
            if(resp.sukses == true){
                table.ajax.reload();
            }else{
                if(resp.error.tarif){
                    $('.tarifGroup').addClass('has-error');
                    $('.tarifError').text(resp.error.tarif[0])
                }
                if(resp.error.jml_kendaraan){
                    $('.jmlKendaraanGroup').addClass('has-error');
                    $('.jml_kendaraanError').text(resp.error.jml_kendaraan[0])
                }
            }
        })
    }

    function hapus(id){
        if(confirm('Yakin akan dihapus?')){
            $.get('/parkir/parkir-batal/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload()
                }
            })
        }
    }

</script>
@endsection
