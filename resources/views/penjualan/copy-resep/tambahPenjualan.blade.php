{!! Form::open(['method' => 'POST', 'id' => 'formTambahPenjualan', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('penjualan_id', $penjualan->id) !!}
    {!! Form::hidden('no_resep', $penjualan->no_resep) !!}
    {!! Form::hidden('registrasi_id', $reg->id) !!}
    {!! Form::hidden('idreg', $reg->id) !!}
    {!! Form::hidden ('tipe_rawat', $reg->status_reg) !!}
    <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label text-primary">Uang Racik</label>
        {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
        <div class="col-sm-4">
          <select class="form-control select2" name="uang_racik" style="width: 100%;">
            <option value=""></option>
            @foreach ($tipe_uang_racik as $d)
              <option value="{{ $d->nominal }}">{{ $d->nama }}</option>
            @endforeach
          </select>
          <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
        {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            <select name="masterobat_id" id="masterObat" class="form-control" style="width: 100%" onchange="cariBatch()">
            </select>
            <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
        </div>
        <div class="col-sm-3">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">INACBG</button>
            </span>
            <input type="number" name="jumlah" value="1" class="form-control">
        </div>
        </div>
        <div class="col-sm-3">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Kronis</button>
            </span>
            <input type="number" name="jml_kronis" value="0" class="form-control">
        </div>
        </div>
        
    </div>

    <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
        <div class="col-sm-2">
            <div class="input-group">
                
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Stok</button>
                </span>
                <input type="text" name="stok" class="form-control">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Batch</button>
                </span>
                <input type="text" name="batch" class="form-control">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Harga</button>
                </span>
                <input type="text" name="harga" class="form-control">
            </div>
        </div>
        
    </div>

    <div class="form-group{{ $errors->has('aturan_pakai') ? ' has-error' : '' }}">
        {!! Form::label('aturan_pakai', 'Aturan Pakai', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-6">
          {!! Form::select('tiket', $tiket, null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
          <small class="text-danger">{{ $errors->first('tiket') }}</small>
        </div>
        <div class="col-sm-3">
          {!! Form::select('takaran', $takaran, 'Tablet', ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
          <small class="text-danger">{{ $errors->first('takaran') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
        {!! Form::label('informasi1', 'Informasi 1', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
        </div>
    </div>

    {{-- <div class="form-group{{ $errors->has('informasi2') ? ' has-error' : '' }}">
        {!! Form::label('informasi2', 'Informasi 2', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('informasi2', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi2') }}</small>
        </div>
    </div> --}}

    <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
        {!! Form::label('cetak', 'Expired', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('expired', null, ['class' => 'form-control datepicker']) !!}
            <small class="text-danger">{{ $errors->first('cetak') }}</small>
        </div>
        {!! Form::label('cetak', 'Cetak', ['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('cetak') }}</small>
        </div>
    </div>

{!! Form::close() !!}

<script>
  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  $('.select2').select2();
  $('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    todayHighlight: true,
    autoclose: true
  });

  $('#masterObat').select2({
      placeholder: "Pilih Obat...",
      ajax: {
          url: '/penjualan/master-obat-baru/',
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
  });

  function cariBatch() {
    var masterobat_id= $("select[name='masterobat_id']").val();
    $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
      $("input[name='expired']").val(resp.obat.expireddate);
      $("input[name='stok']").val(resp.obat.stok);
      $("input[name='batch']").val(resp.obat.nomorbatch);
      $("input[name='harga']").val(ribuan(resp.obat.hargajual_jkn));
    })
  }
</script>
