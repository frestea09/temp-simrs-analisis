@extends('master')
@section('header')
  <h1>Penjualan Operasi</h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualan']) !!}
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('idreg', $idreg) !!}
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <tbody>
            <tr>
              <td style="width: 30%">Nama Pasien / No. RM</td>
              <td>
                {{ strtoupper($pasien->nama) }} / {{ $pasien->no_rm }} / {{ (!empty($pasien->tgllahir)) ? hitung_umur($pasien->tgllahir) : 'tgl lahir kosonglo' }}
                  <button type="button" id="historipenjualan" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
                    <i class="fa fa-th-list"></i> HISTORY
                  </button>
              </td>
            </tr>
            <tr>
            @if ( $reg->status_reg == 'I2' )
              {{-- <td>Ruangan</td><td>{{ ($ranap->kamar_id != '') ? baca_kamar($ranap->kamar_id) : '' }}</td> --}}
              <td>Ruangan</td><td>
                        @isset($ranap->kamar_id)
                            {{ baca_kamar($ranap->kamar_id) }}
                        @endisset
              </td>
            @else
              <td>Klinik</td><td>{{ strtoupper(baca_poli($reg->poli_id)) }}</td>
            @endif
            </tr>

            <tr>
              <td> <b> Histori Kunjungan Pasien: </b></td>
              @if ($histori_irj->first())
              <td>
                @foreach ($histori_irj as $item)
                 <p> - Poli {{ strtoupper(baca_poli($item->poli_id)) }}</p>
                @endforeach
              </td>
              @endif
            </tr>

            @if ($histori_igd->first())
            <tr>
              <td>History : </td>
              <td>
                @foreach ($histori_igd as $item)
                 - {{ strtoupper(baca_poli($item->poli_id)) }}
                @endforeach
              </td>
            </tr>
            @endif

            <tr>
              <td>Dokter</td>
              <td>
                {{--  {{ baca_dokter($reg->dokter_id) }}  --}}
                {!! Form::select('dokter_id', $dokter, $reg->dokter_id, ['class' => 'form-control select2']) !!}
              </td>
            </tr>
            <tr>
              <td>Jenis Pasien</td><td>{{ baca_carabayar($reg->bayar) }}</td>
            </tr>
            <tr>
              <td>Alamat</td> <td>{{ strtoupper($pasien->alamat) }} RT. {{ $pasien->rt }} / RW. {{ $pasien->rw }} {{ baca_kelurahan($pasien->village_id) }} {{ baca_kecamatan($pasien->district_id) }}</td>
            </tr>
          </tbody>
        </table>
        @if(isset($resep->id))
        <div class="row">
          <div class="col-sm-12">
            <h3>E-Resep</h3>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th colspan="2">{{ $resep->uuid }}</th>
                </tr>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Qty</th>
                  <th>Cara Bayar</th>
                  <th>Tiket</th>
                  <th>Cara Minum</th>
                  <th>Takaran</th>
                  <th>Informasi</th>
                  @if (satusehat())
                  <th>Medication Request Satu Sehat</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($resep->resep_detail as $a => $b)
                <tr>
                  <td>{{ ($a+1) }}</td>
                  <td>{{ $b->logistik_batch->master_obat->nama }}</td>
                  <td>{{ $b->qty }}</td>
                  <td>{{ $b->cara_bayar }}</td>
                  <td>{{ $b->tiket }}</td>
                  <td>{{ $b->cara_minum }}</td>
                  <td>{{ $b->takaran }}</td>
                  <td>{{ $b->informasi }}</td>
                  @if (satusehat())
                  <td>{{ @$b->id_medication_request }}</td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endif
      {!! Form::close() !!}

      <form method="POST" id="formPenjualan" class="form-horizontal">
        {{ csrf_field() }}
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('idreg', $idreg) !!}
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
        {{-- <input type="text" name="bayar" value="{{ baca_carabayar($reg->bayar) }}"> --}}
        {{--  <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty($penjualanid) ? $penjualanid : NULL }}">  --}}
        {{--  <input type="hidden" name="cara" value="{{ $reg->bayar }}">  --}}
          <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label text-primary">Uang Racik</label>
            {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
            <div class="col-sm-4">
              <select class="form-control select2" name="uang_racik" style="width: 100%;">
                @foreach ($tipe_uang_racik as $d)
                  <option value="{{ $d->id }}" {{ ( $d->id == 2) ? 'selected' : '' }}>{{ $d->nama }}</option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">JUMLAH&nbsp;&nbsp;  </button>
                  {{-- <button class="btn btn-default" type="button">Jumlah</button> --}}
                </span>
                <input type="number" name="jumlah" value="1" min="1" class="form-control">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </span>
                {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cetak') }}</small>
              </div>
            </div>
            {{-- <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Kronis</button>
                </span>
                <input type="number" name="jml_kronis" value="0" min="1" class="form-control">
              </div>
            </div> --}}
          </div>

          <div id="racikan">
            <div class="form-group{{ $errors->has('racikan') ? ' has-error' : '' }}">
              {!! Form::label('racikan', 'Harga Racikan', ['class' => 'col-sm-2 control-label']) !!}
              <div class="col-sm-4">
                {!! Form::text('racikan', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('racikan') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
          {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                <select name="masterobat_id" id="masterObat" class="form-control" onchange="cariBatch()"></select>
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

          <div class="form-group">
            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <select class="form-control select2" name="cara_bayar_id" style="width: 100%;">
                @foreach ($carabayar as $d)
                    @if ($reg->bayar == $d->id)
                        <option value="{{ $d->id }}" selected>{{ $d->carabayar }}</option>
                    @else
                        <option value="{{ $d->id }}" >{{ $d->carabayar }}</option>
                    @endif
                @endforeach
              </select>
              {{-- {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'select2 form-control', 'placeholder'=>'']) !!} --}}
              <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Expired&nbsp;&nbsp;&nbsp;</button>
                </span>
                {!! Form::text('expired', null, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('expired') }}</small>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Stok&nbsp;&nbsp;</button>
                </span>
                {!! Form::text('stok', 0, ['class' => 'form-control','readonly'=>true]) !!}
                <small class="text-danger">{{ $errors->first('stok') }}</small>
              </div>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('etiket', 'E-Tiket', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                <select class="form-control select2" name="tiket" style="width: 100%;">
                  @foreach ($tiket as $d)
                    <option value="{{ $d->nama }}" >{{ $d->nama }}</option>
                  @endforeach
                </select>
              <small class="text-danger">{{ $errors->first('tiket') }}</small>
            </div>
           
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cara Minum&nbsp;&nbsp; </button>
                </span>
                {!! Form::select('cara_minum_id', $cara_minum, null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cara_minum_id') }}</small>
                <span class="input-group-btn">
                  <a href="{{ url('/penjualan/master-cara-minum') }}" class="btn btn-primary" type="button"><i class="fa fa-pencil"></i></a>
                 
                </span>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Diskon&nbsp;&nbsp; </button>
                </span>
                    <input type="number" name="diskon" class="form-control"> 
                <span class="input-group-btn">
                     <button class="btn btn-default" type="button" disabled>%</button>
                </span>    
                <small class="text-danger">{{ $errors->first('Diskon') }}</small>
              </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
          {!! Form::label('informasi1', 'Informasi', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Jenis&nbsp;&nbsp;&nbsp;</button>
              </span>
              <input type="text" class="form-control" readonly name="jenis">
              <small class="text-danger">{{ $errors->first('expired') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="addItem()">Tambahkan</button>
            </div>
          </div>
        </div>
        <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
          {!! Form::label('informasi1', 'Kronis', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::select('kronis', ['Y'=>'Ya', 'N'=>'Tidak'], 'N', ['class' => 'form-control select2']) !!}
            {{-- <input type="checkbox" name="kronis" value="1"> --}}
            {{-- {!! Form::text('informasi1', null, ['class' => 'form-control']) !!} --}}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
          </div> 
        </div>
        
        <hr>
        <div>
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Nama Obat</th>
                  <th class="text-center">Jml</th>
                  <th class="text-center">Kronis</th>
                  <th class="text-center">Jml Total</th>
                  <th style="width:10%" class="text-center">Harga @</th>
                  <th style="width:10%" class="text-center">Uang R.</th>
                  <th style="width:10%" class="text-center">Total</th>
                  <th>Etiket</th>
                  @if (satusehat())
                  <th>Medication Despence Satu Sehat</th>
                  @endif
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
                    <td class="text-center">{{ $d->is_kronis == 'Y' ? 'Ya' : 'Tidak'}}</td>
                    <td class="text-center">{{ $d->jumlah+$d->jml_kronis }}</td>
                    <td class="text-right">{{ number_format((($d->hargajual+$d->hargajual_kronis)/($d->jumlah+$d->jml_kronis))) }}</td>
                    <td class="text-right">{{ number_format($d->uang_racik) }}</td>
                    <td class="text-right">{{ number_format($d->hargajual_kronis+$d->hargajual+$d->uang_racik) }}</td>
                    <td>{{ $d->etiket }}</td>
                    @if (satusehat())
                    <td>{{ @$d->id_medication_dep }}</td>
                    @endif
                    <td>{{ $d->cetak }}</td>
                    <td>
                      <a href="{{ url('penjualan/deleteDetailBaru/'.@$d->id.'/'.@$pasien->id.'/'.@$idreg.'/'.@$penjualan->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
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
        </div>
        {!! Form::close() !!}
        <form method="POST" id="formTotalPenjualan" class="form-horizontal">
        {{ csrf_field() }}
        <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty($penjualanid) ? $penjualanid : NULL }}">
        <input type="hidden" name="cara_bayar" value="{{ $reg->bayar }}">
        <input type="hidden" name="reg_id" value="{{ $reg->id }}">
        @if(isset($resep->id))
        <input type="hidden" name="resep_uuid" value="{{ $resep->uuid }}">
        @endif
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
        <div class="col-sm-7">
          {{-- <div class="form-group {{ $errors->has('jasa_racik') ? ' has-error' : '' }} {{ ($reg->bayar != 1) ? 'hidden' : '' }}"> --}}
          <div class="form-group">
            {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-7">
              {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang']) !!}
              <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
            </div>
          </div>
        </div>
        @if(isset($resep->id))
        <div class="col-sm-5">
          <div class="form-group{{ $errors->has('ket_resep') ? ' has-error' : '' }}">
            {!! Form::label('ket_resep', 'Keterangan E-Resep', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
              <input class="form-control" name="ket_resep">
              <small class="text-danger">{{ $errors->first('ket_resep') }}</small>
            </div>
          </div>
        </div>
        @endif
        <div class="col-sm-7">
          <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }}">
            {!! Form::label('pembuat_resep', 'Pelaksana Layanan', ['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-7">
              {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>
            </div>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="form-group">
            {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
              {!! Form::text('created_at', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('informasi2') }}</small>
            </div>
            <div class="col-sm-4">
              {{--  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}  --}}
              <button type="button" onclick="savePenjualan()" class="btn btn-success btn-flat">SIMPAN</button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="overlay hidden">
      <i class="fa fa-refresh fa-spin"></i>
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
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Cetak ======================================================================== --}}
  <div class="modal fade" id="showCetak" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          {{--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  --}}
          <h4 class="modal-title" id="">Cetak Nota</h4>
        </div>
        <div class="modal-body text-center">
          <a href="" class="btn btn-primary btn-flat" id="non_kronis"  target="_blank"> <i class="fa fa-file-pdf-o"></i> CETAK FAKTUR NON KRONIS </a>
          <a href="" class="btn btn-danger btn-flat"  id="kronis" target="_blank"> <i class="fa fa-file-pdf-o"></i> CETAK FAKTUR KRONIS </a>
        </div>
        <div class="modal-footer">
          <a href="" class="btn btn-default btn-flat"  id="inap" > IBS Inap </a>
          <a href="" class="btn btn-default btn-flat"  id="jalan" > IBS Jalan </a>
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

  $(document).ready(function() {
    if ($('input[name="cara"]').val() != 1) {
        $('#uang_racik').removeClass('hide');
    } else {
        $('#uang_racik').addClass('hide');
    }
    $('select[name="obat_racik"]').on('change', function () {
    if ($(this).val() != 'Y') {
        $('#uang_racik').removeClass('hide');
      } else {
        $('#uang_racik').addClass('hide');
      }
    });
    $('.uang').maskNumber({
			thousands: ".",
			integer: true,
    });

    $(document).on('click', '#historipenjualan', function (e) {
      var id = $(this).attr('data-registrasiID');
      $('#showHistoriPenjualan').modal('show');
      $('#dataHistori').load("/penjualan/"+id+"/history-baru");
    });
  });

  $('.select2').select2();
  $('#viewDataOrder').load('{{ url('cartContent') }}')

  $('#masterObat').select2({
      placeholder: "Klik untuk isi nama obat",
      ajax: {
          url: '/penjualan/master-obat-baru-ibs/',
          dataType: 'json',
          data: function (params) {
              return {
                  j: {{ $reg->bayar }},
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
    var masterobat_id= $("select[name='masterobat_id']").val();
    $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
      $("input[name='expired']").val(resp.obat.expireddate);
      $("input[name='stok']").val(resp.obat.stok);
      $("input[name='jenis']").val(resp.kategori_obat);
      $("input[name='batch']").val(resp.obat.nomorbatch);
      $("input[name='harga']").val(ribuan(resp.obat.hargajual_jkn));
      $("input[name='jumlah']").attr('max',resp.obat.stok);
    })
  }

  function addItem() {
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
    var data = $('#formPenjualan').serialize()
    $.ajax({
      url: '/penjualan/simpan-penjualan-detail',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('#formTotalPenjualan')[0].reset();
        $("input[name='expired']").val('');
        $("input[name='stok']").val('');
        $("input[name='batch']").val('');
        $("input[name='harga']").val('');
        $('select[name="masterobat_id"]').empty()
        location.reload();
      }
    });
  }

  function destroyCart() {
    if (confirm('Yakin akan di hapus semua?')) {
      $.ajax({
        url: '/cartDestroy',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('select[name="masterobat_id"]').empty()
          $('#viewDataOrder').load('{{ url('cartContent') }}')
        }
      });

    }
  }

  function deleteCart(rowId) {
    $.ajax({
      url: '/cartDelete/'+rowId,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('select[name="masterobat_id"]').empty()
        $('#viewDataOrder').load('{{ url('cartContent') }}')
      }
    });
  }

  function savePenjualan() {
    if (confirm('Yakin data penjualan sudah benar?')) {
      var  data = $('#formTotalPenjualan').serialize()
      $.ajax({
        url: '/penjualan/simpan-total-penjualan',
        type: 'POST',
        dataType: 'json',
        data: data,
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
           $('.overlay').addClass('hidden')
        }
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('#showCetak').modal({ backdrop : 'static', keyboad : false });
          //$('#non_kronis').attr('href', '/farmasi/cetak-detail-baru/'+resp.id)
          //$('#kronis').attr('href', '/farmasi/cetak-baru-fakturkronis/'+resp.id)
          $('#non_kronis').attr('href', '/farmasi/cetak-detail/'+resp.id)
          $('#kronis').attr('href', '/farmasi/cetak-fakturkronis/'+resp.id)
          $('#inap').attr('href', '/penjualan/ibs-baru')
          $('#jalan').attr('href', '/penjualan/ibs-jalan-baru')
          //window.history.back();
        }else{
          alert('Gagal Simpan karena '+resp.message)
        }

      });
    }
  }

  // validate jumlah
  $(document).on('keyup change',"input[name='jumlah']", function(){
    $("input[name='jumlah']").attr('style','');
    let max = $("input[name='stok']").val();
    if( parseInt(max) < parseInt(this.value) ){
      alert('Input Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    
  });

  $(document).on('change', '#filterSelect', function(e) {
          // alert($('#filterSelect').val())
           let id = $('#registrasi_select').val();
           let penjualanId = $('#filterSelect').val();
           $('#shoWHistoriPenjualan').modal('show');
           $('#dataHistori').load("/penjualan/"+id+"/"+penjualanId+"/history-baru-filter");
    });

</script>
@endsection
