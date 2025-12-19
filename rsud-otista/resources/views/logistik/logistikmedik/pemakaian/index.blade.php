@extends('master')

@section('header')
  <h1>Logistik <small>PEMAKAIAN</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div id="puter">
        
          <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">PEMAKAIAN</a></li>
                <li><a data-toggle="tab" href="#menu1">EXPORT</a></li> 
              </ul>
              
              <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                  <form method="POST" class="form-horizontal" id="formPemakaian">
                    {{ csrf_field() }}
                    <div class="col-sm-8">
                    <span style="color:red">*</span>Barang yang muncul sesuai dengan gudang yang login
                    <div class="form-group" style="margin-top:50px;">
                      <label for="barang" class="col-sm-3 control-label">Nama Barang</label>
                      <div class="col-sm-9">
                        {{--  <select name="masterobat_id" class="form-control select2" style="width: 100%;">
                          @foreach (\App\Masterobat::get() as $d)
                            @php
                              $stock = \App\Logistik\LogistikStock::where('gudang_id', Auth::user()->gudang_id)->where('masterobat_id', $d->id)->get();
                              $saldo = $stock->sum('masuk') - $stock->sum('keluar');
                            @endphp
                            <option value="{{ $d->id }}">{{ $d->nama }} | {{ $saldo }} | {{ number_format($d->hargajual) }}</option>
                          @endforeach
                        </select>  --}}
                        <select name="masterobat_id" id="masterObat" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group jumlahGroup">
                      <label for="jumlah" class="col-sm-3 control-label">Jumlah Stok</label>
                      <div class="col-sm-9">
                        <input type="number" name="jumlah_stok" class="form-control" min="1" readonly>
                        <small class="text-danger jumlahError"></small>
                      </div>
                    </div>
                    <div class="form-group jumlahGroup">
                      <label for="jumlah" class="col-sm-3 control-label">Jumlah</label>
                      <div class="col-sm-9">
                        <input type="number" name="jumlah" class="form-control">
                        <small class="text-danger jumlahError"></small>
                      </div>
                    </div>
                    <div class="form-group keteranganGroup">
                      <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" name="keterangan" class="form-control" value="-" required>
                        <small class="text-danger keteranganError"></small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                      {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {!! Form::text('tanggal', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                          <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="keterangan" class="col-sm-3 control-label">&nbsp;</label>
                      <div class="col-sm-9">
                        <button type="button" class="btn btn-primary btn-flat" onclick="saveForm()">SIMPAN</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                  <div class="col-sm-8">
                    <form method="POST" action="{{url('/logistikmedik/pemakaian/excel')}}" class="form-horizontal" id="formPemakaian">
                    {{ csrf_field() }}  
                    <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}"  style="margin-top:50px;">
                      {!! Form::label('tga', 'Dari Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {!! Form::text('tga', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => 'required']) !!}
                          <small class="text-danger">{{ $errors->first('tga') }}</small>
                      </div>
                    </div>
                    <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                      {!! Form::label('tgb', 'Sampai Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => 'required']) !!}
                          <small class="text-danger">{{ $errors->first('tga') }}</small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="keterangan" class="col-sm-3 control-label">&nbsp;</label>
                      <div class="col-sm-9">
                        <button type="submit" class="btn btn-success btn-flat">EXPORT EXCEL</button>
                      </div>
                    </div> 
                  </div>
                </div> 
              </div>
            </div>
          </form>
          </div>
        
      </div>

      <hr>
      <div class="table-responsive">
        {{-- <a class="btn btn-success btn-flat pull-right"  href="">EXPORT EXCEL</a> --}}
        <table class="table table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              {{--  <th>No Batch</th>  --}}
              <th class="text-center">Jumlah</th>
              <th>Keterangan</th>
              <th>User</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  let temp;
  $('.select2').select2()

  var table;
  table = $('.table').DataTable({
    autoWidth: false,
    processing: true,
    serverSide: true,
    destroy: true,
    ajax: '{{ url('/logistikmedik/pemakaian-data') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false, orderable: false},
        {data: 'barang'},
        {data: 'jumlah', sClass: 'text-center'},
        {data: 'keterangan'},
        {data: 'user', searchable: false},
        {data: 'tanggal', searchable: false},
        {data: 'aksi', searchable: false}
    ]
  });

  $('#masterObat').select2({
      placeholder: "Pilih Obat...",
      ajax: {
          url: '/logistikmedik/master-obat/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
            temp = data
              return {
                  results: data
              };
          },
          cache: true
      }
  })

  $(document).on('change','#masterObat', function(){
    let id = this.value;
    temp.forEach(function(item) {
        if( id == item.id){
          $('input[name="jumlah_stok"]').val(item.saldo);
        }
    });
  })

  function editJumlah(id){
		$.ajax({
			url: '/logistikmedik/edit-pemakaian',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'jumlah': $('input[name="jumlah'+id+'"]').val(),
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
        alert('Jumlah Berhasil di ubah!!')
			}
		});
	}

  function resetForm() {
    $('.jumlahGroup').removeClass('has-error')
    $('.jumlahError').text('')
    $('.keteranganGroup').removeClass('has-error')
    $('.keteranganError').text('')
  }

  function saveForm() {
    let ket = $("input[name='keterangan']").val();
    let tgl = $("input[name='tanggal']").val();
    if( ket == "" || tgl == "" ){
      alert('Bidang isian tidak boleh ada yang kosong');
      return false;
    }
    let stok_max = $("input[name='jumlah_stok']").val();
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
    resetForm()
    var data = $('#formPemakaian').serialize()
    $.ajax({
      url: '/logistikmedik/pemakaian',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(json) {
      if (json.sukses == false) { 
        alert(json.msg)
      }

      if (json.sukses == true) {
        $('#formPemakaian')[0].reset()
        /*table.ajax.reload()*/
        if(!alert('Sukses update pemakaian')){window.location.reload();}
        // location.reload();
      }

      if (json.gagal == true) {
        alert('Pemakaian Lebih Dari Stok!!')
      }

    });

  }

  // validate jumlah
  $(document).on('keyup change',"input[name='jumlah']", function(){
    $("input[name='jumlah']").attr('style','');
    let max = $("input[name='jumlah_stok']").val();
    if( parseInt(max) < parseInt(this.value) ){
      alert('Input Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    
  })

</script>
@endsection
