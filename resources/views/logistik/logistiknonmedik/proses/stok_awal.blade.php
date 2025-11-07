@extends('master')

@section('header')
  <h1>Logistik Non Medik <small>Saldo Awal</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
      <form method="POST" id="formAddStock" class="form-horizontal">
        {{ csrf_field() }}
      <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
              <label for="gudang" class="col-sm-3 control-label">Gudang</label>
              <div class="col-sm-9">
                <select name="gudang_id" class="form-control select2" style="width: 100%;">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="supplier" class="col-sm-3 control-label">Supplier</label>
              <div class="col-sm-9">
                <select name="supplier_id" class="form-control select2" style="width: 100%;">
                </select>
              </div>
            </div>
              <div class="form-group">
              <label for="periode_aktif" class="col-sm-3 control-label">Periode Aktif</label>
              <div class="col-sm-9">
                <select name="periode_id" class="form-control select2" style="width: 100%;">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="masterbarang" class="col-sm-3 control-label">Nama Item</label>
              <div class="col-sm-9">
                <select name="masterbarang" class="form-control select2" style="width: 100%;">
                </select>
              </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group nomorbatchGroup">
              <label for="nomorbatch" class="col-sm-3 control-label">Nomor Batch</label>
              <div class="col-sm-9">
                <input type="text" name="batch_no" class="form-control">
                <small class="text-danger nomorbatchError"></small>
              </div>
            </div>
             <div class="form-group expiredGroup">
              <label for="expired_date" class="col-sm-3 control-label">Exprired Date</label>
              <div class="col-sm-9">
                <input type="text" name="expired_date" class="form-control datepicker">
                <small class="text-danger expiredError"></small>
              </div>
            </div>
            <div class="form-group totalGroup">
              <label for="total_batch" class="col-sm-3 control-label">Jumlah</label>
              <div class="col-sm-9">
                <input type="text" name="total_batch" class="form-control">
                <small class="text-danger totalError"></small>
              </div>
            </div>
            <div class="form-group keteranganGroup">
              <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
              <div class="col-sm-9">
                <input type="text" name="keterangan" value="Saldo Awal" readonly="true" class="form-control">
                <small class="text-danger keteranganError"></small>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" onclick="saveSaldo()" class="btn btn-primary btn-flat">SIMPAN</button>
              </div>
            </div>
        </div>
      </div>
      </form>
      <div id="viewStock"> </div>
    </div>
  </div>

  <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:max-content; ">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="my-modal-title">Edit Saldo Awal</h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formEditStok" class="form-horizontal">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                    <label for="gudang" class="col-sm-3 control-label">Gudang</label>
                    <div class="col-sm-9">
                      <select name="gudang_id" class="form-control select2" style="width: 100%;">
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="supplier" class="col-sm-3 control-label">Supplier</label>
                    <div class="col-sm-9">
                      <select name="supplier_id" class="form-control select2" style="width: 100%;">
                      </select>
                    </div>
                  </div>
                    <div class="form-group">
                    <label for="periode_aktif" class="col-sm-3 control-label">Periode Aktif</label>
                    <div class="col-sm-9">
                      <select name="periode_id" class="form-control select2" style="width: 100%;">
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="masterobat_id" class="col-sm-3 control-label">Nama Item</label>
                    <div class="col-sm-9">
                      <select name="masterobat_id" class="form-control select2" style="width: 100%;">
                      </select>
                    </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group nomorbatchGroup">
                    <label for="nomorbatch" class="col-sm-3 control-label">Nomor Batch</label>
                    <div class="col-sm-9">
                      <input type="text" name="batch_no" class="form-control">
                      <small class="text-danger nomorbatchError"></small>
                    </div>
                  </div>
                    <div class="form-group expiredGroup">
                    <label for="expired_date" class="col-sm-3 control-label">Exprired Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="expired_date" class="form-control datepicker">
                      <small class="text-danger expiredError"></small>
                    </div>
                  </div>
                  <div class="form-group totalGroup">
                    <label for="total_batch" class="col-sm-3 control-label">Jumlah</label>
                    <div class="col-sm-9">
                      <input type="text" name="total_batch" class="form-control">
                      <small class="text-danger totalError"></small>
                    </div>
                  </div>
                  <div class="form-group keteranganGroup">
                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                    <div class="col-sm-9">
                      <input type="text" name="keterangan" value="Saldo Awal" readonly="true" class="form-control">
                      <small class="text-danger keteranganError"></small>
                    </div>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="saveEditSaldo()" class="btn btn-primary btn-flat">SIMPAN</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2()
    $.get("{{ route('gudang.data') }}", function(resp){
      $('select[name="gudang_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="gudang_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('supplier.data') }}", function(resp){
      $('select[name="supplier_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="supplier_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('periode.data') }}", function(resp){
      $('select[name="periode_id"]').empty()
      $.each(resp, function(index, val){
          $('select[name="periode_id"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

    $.get("{{ route('barang.data') }}", function(resp){
      $('select[name="masterbarang"]').empty()
      $.each(resp, function(index, val){
          $('select[name="masterbarang"]').append("<option value='"+val.id+"'>"+val.nama+"</option>")
      })
    })

  //getObat
  {{--  $.ajax({
    url: '/logistikmedik/saldoawal/getObat',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(json) {
    $('select[name="masterobat_id"]').empty()
    $.each(json, function(index, val) {
       $('select[name="masterobat_id"]').append('<option value="'+val.id+'">'+val.nama+'</option>')
    });
  });
  //getSupplier
  $.ajax({
    url: '/logistikmedik/saldoawal/getSupplier',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(json) {
    $('select[name="supplier_id"]').empty()
    $.each(json, function(index, val) {\App\Log\App\Logistik\LogistikPeriode\App\Logistik\LogistikPeriodeistik\LogistikPeriode
       $('select[name="supplier_id"]').append('<option value="'+val.id+'">'+val.nama+'</option>')
    });
  });
  //getPeriode
  $.ajax({
    url: '/logistikmedik/saldoawal/getPeriode',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(json) {
    $('select[name="periode_id"]').empty()
    $.each(json, function(index, val) {
       $('select[name="periode_id"]').append('<option value="'+val.id+'">'+val.nama+'</option>')
    });
  });

  function resetForm() {
    $('.nomorbatchGroup').removeClass('has-error')
    $('.nomorbatchError').text('')
    $('.expiredGroup').removeClass('has-error')
    $('.expiredError').text('')
    $('.totalGroup').removeClass('has-error')
    $('.totalError').text('')
  }

  function saveSaldo() {
    resetForm()
    $.ajax({
      url: '/logistikmedik/saldoawal',
      type: 'POST',
      dataType: 'json',
      data: $('#formAddStock').serialize(),
    })
    .done(function(json) {
      if (json.sukses == false) {
        if (json.error.batch_no) {
          $('.nomorbatchGroup').addClass('has-error')
          $('.nomorbatchError').text(json.error.batch_no[0])
        }
        if (json.error.expired_date) {
          $('.expiredGroup').addClass('has-error')
          $('.expiredError').text(json.error.expired_date[0])
        }
        if (json.error.total_batch) {
          $('.totalGroup').addClass('has-error')
          $('.totalError').text(json.error.total_batch[0])
        }
      }
      if (json.sukses == true) {
         $('#viewStock').load('{{ url('logistikmedik/saldoawal/data') }}')
      }
    });

  }

  function editSaldoAwal(id){
    $('#modalEdit').modal({ backdrop:'static', keybord:false});
    $.get('edit-saldo-awal/'+id, function(resp){
      $('select[name="gudang_id"]').val(resp.gudang_id).trigger('change')
      $('select[name="supplier_id"]').val(resp.supplier_id).trigger('change')
      $('select[name="periode_id"]').val(resp.periode_id).trigger('change')
      $('select[name="masterobat_id"]').val(resp.masterobat_id).trigger('change')
      $('input[name="batch_no"]').val(resp.batch_no)
      $('input[name="expired_date"]').val(resp.tanggal)
      $('input[name="total_batch"]').val(resp.total)
      $('input[name="keterangan"]').val(resp.keterangan)
      $('input[name="id"]').val(resp.id)
    });
  }
  function saveEditSaldo(){
    var data = $('#formEditStok').serialize()
    $.post('save-edit-saldo-awal', data, function(resp){
      if(resp.sukses == true){
        $('#modalEdit').modal('hide');
        $('#viewStock').load('{{ url('logistikmedik/saldoawal/data') }}')
        alert('Berhasil di ubah')
      }
    })
  }
  function hapusSaldoAwal(id){
    if(confirm('Yakin akan di hapus!')){
      $.get('hapus-saldo-awal/'+id, function(resp){
        if(resp.sukses == true){
          $('#viewStock').load('{{ url('logistikmedik/saldoawal/data') }}')
        }
      })
    }
  }  --}}
</script>
@endsection
