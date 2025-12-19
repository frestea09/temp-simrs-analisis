@extends('master')

@section('header')
  <h1>Logistik - Retur Obat Rusak ke Supplier</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Retur <span style="font-size: 12">*Akun anda sebagai : {{ baca_gudang_logistik(Auth::user()->gudang_id) }}</span>
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" id="form-retur" class="form-horizontal" action="{{ route('simpan-retur-obat-rusak') }}">
          {{ csrf_field() }}
          {{-- DETAIL PO --}}
          <input type="hidden" name="gudang_id" value="{{ Auth::user()->gudang_id }}">
          <input type="hidden" name="masterobat_id" value="">
          <input type="hidden" name="supplier_id" value="">
          <input type="hidden" name="hargabeli" value="">
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Nomor Batch</th>
                      <th>Expired Date</th>
                      <th>Stok</th>
                      <th>Jumlah Retur</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 25%">
                        <select id="masterObat" name="batch_id" class="form-control" onchange="cariBatch()"></select>
                        <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
                      </td>
                      <td style="width: 10%"><input type="text" name="nomorbatch" class="form-control"></td>
                      
                      <td style="width: 11%">
                        <input type="text" name="expired" value="" class="form-control datepicker">
                      </td>
                     
                      <td style="width: 11%"><input type="number" name="stok" class="form-control" disabled></td>
                      <td style="width: 11%"><input type="number" name="jumlah" min="0" class="form-control"></td>

                      <td style="width: 15%">
                        <input type="text" name="keterangan" value="" class="form-control" required>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
                        <button type="button" id="btn-simpan" class="btn btn-primary btn-flat pull-right">
                          Simpan
                      </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </form>
    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()

  $('#masterObat').select2({
      placeholder: "Klik untuk isi nama obat",
      ajax: {
          url: '/retur-obat-rusak/get-obat',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  function cariBatch() {
    var masterobat_id= $("select[name='batch_id']").val();
    $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
      $("input[name='expired']").val(resp.obat.expireddate);
      $("input[name='stok']").val(resp.obat.stok);
      $("input[name='nomorbatch']").val(resp.obat.nomorbatch);
      $("input[name='masterobat_id']").val(resp.obat.masterobat_id);
      $("input[name='hargabeli']").val(resp.obat.hargabeli);
      $("input[name='supplier_id']").val(resp.obat.supplier_id);
      $('input[name="jumlah"]').attr('max',resp.obat.stok);
    })
  }

  // validate jumlah
  $(document).on('keyup change',"input[name='jumlah']", function(){
    $("input[name='jumlah']").attr('style','');
    let max = $("input[name='stok']").val();
    if( parseInt(max) < parseInt(this.value) ){
      alert('Stok Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
    }
  })

  $(document).on('click','#btn-simpan', function(){
    $("input[name='jumlah']").attr('style','');
    let stok_max = $("input[name='stok']").val();
    let stok_input = $("input[name='jumlah']").val();
    if( parseInt(stok_max) < parseInt(stok_input)){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Lebih Dari '+stok_max+' !!');
      return false;
    }else if( parseInt(stok_input) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    $('#form-retur').submit();
  })
</script>
@endsection
