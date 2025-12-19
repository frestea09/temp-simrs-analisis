@extends('master')

@section('header')
  <h1>Logistik <small>PERMINTAAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form method="POST" class="form-horizontal" id="formPermintaan">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nomor" class="col-md-3 control-label">Nomor</label>
              <div class="col-md-9">
                {{--  <input type="text" name="nomor" value="0000/{{ \App\LogistikGudang::where('id', Auth::user()->gudang_id)->first()->nama }}/{{ date('d-m-Y') }}" class="form-control">  --}}
                <input type="text" name="nomor" value="{{  $nomor }}" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Tanggal</label>
              <div class="col-md-9">
                <input type="text" name="tanggal"  value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="nomor" class="col-md-3 control-label">Gudang Asal</label>
              <div class="col-md-9">
                <input type="text" value="{{ $user_gudang }}" class="form-control" readonly="true">
              </div>
            </div>
            <div class="form-group">
              <label for="gudang_tujuan" class="col-md-3 control-label">Gudang Tujuan</label>
              <div class="col-md-9">
                <select name="gudang_tujuan" onchange="cekStok()" class="form-control select2" readonly="true" >
                  @foreach ($gudang as $d)
                      <option value="{{ $d->id }}" {{$d->id == '8' ? 'selected' :''}}>{{ $d->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="masterobat_id" class="col-md-3 control-label">Nama Barang</label>
              <div class="col-md-9">
                <select name="masterobat_id" onchange="cekStok()" class="form-control select2">
                  <option value="">[---]</option>
                  @foreach ($barang as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="sisa_stock" class="col-md-3 control-label">Satuan</label>
              <div class="col-md-9">
                <input type="text" readonly="true" name="satuan" class="form-control">
              </div>
            </div>
            <div class="form-group">
            <label for="sisa_stock" class="col-md-3 control-label">Stok Gudang Asal{{ baca_gudang_logistik($d->id == '8' ? 'selected' :'') }}</label>
              <div class="col-md-9">
                <input type="text" readonly="true" name="sisa_stock" class="form-control" id="sisa_stock">
              </div>
            </div>
            <div class="form-group">
            <label for="sisa_stock" class="col-md-3 control-label">Stok Gudang Tujuan{{ baca_gudang_logistik($d->id == '8' ? 'selected' :'') }}</label>
              <div class="col-md-9">
                <input type="text" readonly="true" name="sisa_stock_tujuan" class="form-control" id="sisa_stock_tujuan">
              </div>
            </div>
             <div class="form-group">
              <label for="jumlah_permintaan" class="col-md-3 control-label">Jumlah Permintaan</label>
              <div class="col-md-9">
                <input type="text" name="jumlah_permintaan" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label for="keterangan" class="col-md-3 control-label">Keterangan</label>
              <div class="col-md-9">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="save" class="col-md-3 control-label">&nbsp;</label>
              <div class="col-md-9">
                <button type="button" class="btn btn-primary btn-flat button-submit" onclick="savePermintaan()" >KIRIM PERMINTAAN</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <hr>

      <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Permintaan</th>
              <th>Nama Barang</th>
              <th class="text-center">Jumlah</th>
              <th>Keterangan</th>
              <th>User</th>
              <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <a href="{{ url('logistikmedik/permintaan') }}" class="btn btn-success btn-flat pull-right">SELESAI</a>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2();

  var table;
  table = $('.table').DataTable({
    autoWidth: false,
    processing: true,
    serverSide: true,
    destroy: true,
    paging: false,
    searching: false,
    info: false,
    ajax: '{{ url('/logistikmedik/data-permintaan') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false},
        {data: 'tanggal'},
        {data: 'barang'},
        {data: 'Jumlah', sClass: 'text-center'},
        {data: 'keterangan'},
        {data: 'user', searchable: false},
        {data: 'hapus'},
    ]
  });

function cekStok() {
  var masterobat_id = $('select[name="masterobat_id"]').val();
  var gudang_tujuan_id = $('select[name="gudang_tujuan"]').val();
    if(masterobat_id == 0){
        $('input[name="sisa_stock"]').val(0)
        $('input[name="satuan"]').val(0)
    }else{
        $.get('/logistikmedik/permintaan/cekStokGudangAsal/'+masterobat_id, function(data){
            $('input[name="sisa_stock"]').val(data)
          })
          $.get('/logistikmedik/permintaan/cekStokGudangTujuan/'+masterobat_id+'/'+gudang_tujuan_id, function(data){
            $('input[name="sisa_stock_tujuan"]').val(data)
            if (data == 0) {
              $('.button-submit').attr("disabled", true);
              $('.button-submit').html("STOK KOSONG");
            } else {
              $('.button-submit').attr("disabled", false);
              $('.button-submit').html("KIRIM PERMINTAAN");
            }
        })
        $.get('/logistikmedik/permintaan/cekSatuanBarang/'+masterobat_id, function(data){
            $('input[name="satuan"]').val(data.nama)
        })
    }
}

function savePermintaan() {
   var data = $('#formPermintaan').serialize();
 

    $.ajax({
         url: '/logistikmedik/permintaan',
         type: 'POST',
         dataType: 'json',
         data: data,
       })
       .done(function(resp) {
        
            $('input[name="jumlah_permintaan"]').val('')
            $('input[name="keterangan"]').val('')
            table.ajax.reload()
          
       });



      // if ($('#sisa_stock').val() != 0) {
      //   $.ajax({
      //    url: '/logistikmedik/permintaan',
      //    type: 'POST',
      //    dataType: 'json',
      //    data: data,
      //  })
      //  .done(function(resp) {
      //     if (resp.sukses == true) {
      //       $('input[name="jumlah_permintaan"]').val('')
      //       $('input[name="keterangan"]').val('')
      //       table.ajax.reload()
      //     }
      //  });
        
      // } else {
      //   confirm('Stok Kosong !!');
      //   table.ajax.reload()
      // }
   }


function editOrder(id){
		$.ajax({
			url: '/logistikmedik/edit-penerimaan',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'jumlah_order': $('input[name="jumlah_order'+id+'"]').val(),
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
			   table.ajax.reload();
			}
			if(data.sukses == true){
				table.ajax.reload();
			}
		});
	}

function hapusPermintaan(id) {
  if (confirm('Yakin akan dihapus?')) {
      $.ajax({
      url: '/logistikmedik/hapus-permintaan/'+id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        table.ajax.reload()
      }
    });
  }
}



</script>
@endsection
