@extends('master')
@section('header')
  <h1>Penjualan Bebas</h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualanbebasbaru']) !!}
        {!! Form::hidden('pasien_id', 0) !!}
        {!! Form::hidden('idreg', session('reg_id')) !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
              <tr>
                <th style="width: 30%">Tanggal</th>
                <td>
                  {{ date('d-m-Y',strtotime($penj_bebas->created_at))}}
                </td>
              </tr>
              <tr>
                <th style="width: 30%">Nama Pasien</th>
                <td>
                  {{ $penj_bebas->nama }}
                </td>
              </tr>
              <tr>
                <th>Alamat</th> <td>{{ $penj_bebas->alamat }}</td>
              </tr>
              <tr>
                <th>Dokter</th> <td>{{ $penj_bebas->dokter }}</td>
              </tr>
              <tr>
                <th>
                  Pembuat Resep
                </th>
                <td>
                  @if (! session('idpenjualan'))
                    <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }} col-md-6">
                        {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>

                    </div>
                      <div class="col-md-6">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin Apoteker sdh benar?")']) !!}
                      </div>
                  @else
                    <b class="text-primary">{{ baca_apoteker($penjualan->pembuat_resep) }}</b>
                  @endif
                </td>
              </tr>
              @if (session('idpenjualan'))
                <tr>
                  <th>No. Faktur</th>
                  <td>{{ $penjualan->no_resep }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
{!! Form::close() !!}

      @if (session('idpenjualan'))
        {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savedetailbebasbaru', 'class' => 'form-horizontal', 'id' => 'form-tambah']) !!}
            {!! Form::hidden('pasien_id', 0) !!}
            {!! Form::hidden('idreg', session('reg_id')) !!}
            {!! Form::hidden('penjualan_id', Request::segment(5)) !!}
            {!! Form::hidden('no_resep', $penjualan->no_resep) !!}
            <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label" style='color: blue;'>Tipe Obat</label>
              {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
              <div class="col-sm-4">
                {{--  <select class="form-control select2" name="obat_racik" style="width: 100%;">
                  <option value=""></option>
                  <option value="Y">Racikan</option>
                  <option value="N">Bukan Racikan</option>
                </select>  --}}
                <select class="form-control select2" name="uang_racik" style="width: 100%;" required>
                  @foreach ($tipe_uang_racik as $d)
                    <option value="{{ $d->id }}" {{ ( $d->id == 2) ? 'selected' : '' }}>{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('uang_racik') }}</small>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Jumlah</button>
                  </span>
                  {{-- <input class="form-control" readonly="" name="batch" type="text"> --}}
                  <input type="number" name="jumlah" value="1" min="0" class="form-control">
                  <small class="text-danger"></small>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp; </button>
                  </span>
                  {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                  <small class="text-danger">{{ $errors->first('cara_minum_id') }}</small>
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
                {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                  <select class="chosen-select" name="masterobat_id" id="masterobat_id" onchange="cariBatch()">
                    <option value=""></option>
                    @foreach ($barang as $key => $d)
                        <option value="{{ $d->id }}">{{ $d->nama_obat }} | Batch {{ $d->nomorbatch }}  | Stok {{ $d->stok }} | ED: {{ date('d-m-Y', strtotime($d->expireddate)) }}
                          @if (cek_jenispasien($idreg) == '1')
                            {{ number_format($d->hargajual_jkn) }}
                          @else
                            {{ number_format($d->hargajual_umum) }}
                          @endif
                        </option>
                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
                </div>
                <div class="col-sm-3">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">No. Batch</button>
                    </span>
                    {!! Form::text('batch',  null, ['class' => 'form-control', 'readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('batch') }}</small>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Harga</button>
                    </span>
                    {!! Form::text('harga',  null, ['class' => 'form-control','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('harga') }}</small>
                  </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('expired') ? ' has-error' : '' }}">
              {!! Form::label('tiket', 'E Tiket', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-md-4">
                {!! Form::select('tiket', $tiket, null, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('tiket') }}</small>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Expired</button>
                  </span>
                  {!! Form::text('expired',  null, ['class' => 'form-control', 'readonly'=>true]) !!}
                  <small class="text-danger">{{ $errors->first('batch') }}</small>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Stok</button>
                  </span>
                  {!! Form::text('stok',  0, ['class' => 'form-control','readonly'=>true]) !!}
                  <small class="text-danger">{{ $errors->first('harga') }}</small>
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('tiket') ? ' has-error' : '' }}">
              {!! Form::label('informasi1', 'Informasi', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-sm-4">
                {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('informasi1') }}</small>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Cara Minum</button>
                  </span>
                    {!! Form::select('cara_minum_id', $cara_minum, null, ['class' => 'chosen-select']) !!}
                </div>
              </div>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Takaran</button>
                  </span>
                  {!! Form::select('takaran', $takaran, 'Tablet', ['class' => 'form-control select2']) !!}
                  <small class="text-danger">{{ $errors->first('takaran') }}</small>
                </div>
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-7">
            </div>
            {{-- <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp; </button>
                </span>
                {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cara_minum_id') }}</small>
              </div>
            </div> --}}
            <div class="col-sm-3">
              <div class="input-group">
                {!! Form::button("Tambahkan", ['class' => 'btn btn-primary btn-flat', 'id' => 'btn-tambah']) !!}
              </div>
            </div>
          </div>
        {!! Form::close() !!}
      @endif


      <hr>
      @isset($detail)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Nama Obat</th>
                <th class="text-center">Jml</th>
                <th style="width:10%" class="text-center">Harga @</th>
                <th style="width:10%" class="text-center">Uang R.</th>
                <th style="width:10%" class="text-center">Total</th>
                <th>Etiket</th>
                <th>Cetak</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($detail as $key => $d)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) :'' }}</td>
                  <td class="text-center">{{ $d->jumlah }}</td>
                  <td class="text-right">{{ number_format(($d->hargajual/$d->jumlah)) }}</td>
                  <td class="text-right">{{ number_format($d->uang_racik) }}</td>
                  <td class="text-right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
                  <td>{{ $d->etiket }}</td>
                  <td>{{ $d->cetak }}</td>
                  <td>
                    <a href="{{ url('penjualan/deleteDetailbebasbaru/'.$d->id.'/0/'.session('reg_id').'/'.$penjualan->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5" class="text-right">Total Harga</th>
                <th class="text-right">{{ number_format($detail->sum('hargajual') + count($detail) * $d->uang_racik) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
        {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savetotalbebasbaru', 'id' => 'savetotalbebasbaru']) !!}
          {{-- <div class="pull-right">
              
          </div> --}}
          <div class="pull-right">
            <div class="form-group">
              {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7">
                {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang']) !!}
                <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
              </div>
            </div>
            {{-- <p></p> --}}
            <div class="form-group">
              {!! Form::label('diskon', 'Diskon (%)', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7">
                {!! Form::number('diskon', 0, ['class' => 'form-control uang']) !!}
                <small class="text-danger">{{ $errors->first('diskon') }}</small>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-7">
                <input type="hidden" name="id_penjualan" value="{{ $penjualan->id }}">
                {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'id' => 'submitotalbebasbaru']) !!}
              </div>
            </div>
          </div>
        {!! Form::close() !!}
      @endisset
    </div>
  </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History Penjualan Obat Sebelumnya</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistori"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  $('select[name="obat_racik"]').on('change', function () {
    if ($(this).val() != 'Y') {
        $('#uang_racik').removeClass('hide');
        $("input[name='uang_racik']").val({{config('app.uang_racik')}});
    } else {
        $('#uang_racik').addClass('hide');
        $("input[name='uang_racik']").val(0);
    }
  });
  function cariBatch() {
    var masterobat_id= $("select[name='masterobat_id']").val();
    $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
      $("input[name='expired']").val(resp.obat.expireddate);
      $("input[name='stok']").val(resp.obat.stok);
      $("input[name='batch']").val(resp.obat.nomorbatch);
      $("input[name='harga']").val(ribuan(resp.obat.hargajual_umum));
    })
  }
  $('.select2').select2();
  $(document).ready(function() {
    $('select[name="obat_racik"]').on('change', function () {
      if ($(this).val() != 'Y') {
          $('#uang_racik').removeClass('hide');
          $("input[name='uang_racik']").val({{config('app.uang_racik')}});
      } else {
          $('#uang_racik').addClass('hide');
          $("input[name='uang_racik']").val(0);
      }
    });
    $('#uang_racik').addClass('hide');
    $("input[name='uang_racik']").val(0);
    $('.uang').maskNumber({
			thousands: ".",
			integer: true,
    });
  });

  $(document).on('click','#btn-tambah', function(){
    $("input[name='jumlah']").attr('style','');
    let stok_max = $("input[name='stok']").val();
    let stok_input = $("input[name='jumlah']").val();
    if( parseInt(stok_max) < parseInt(stok_input)){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Lebih Dari '+stok_max+' !!');
      return false;
    }else if( parseInt(stok_input) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol atau Minus !!');
      return false;
    }
    $('#form-tambah').submit();
  })

  // validate jumlah
  $(document).on('keyup change',"input[name='jumlah']", function(){
    $("input[name='jumlah']").attr('style','');
    let max = $("input[name='stok']").val();
    if( parseInt(max) < parseInt(this.value) ){
      alert('Stok Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol atau Minus !!');
      return false;
    }
  })

  $('#savetotalbebasbaru').submit(function(){
    $("#submitotalbebasbaru", this)
      .html('"Loading...."')
      .attr('disabled', 'disabled');
    return true;
  });
  

</script>
@endsection
