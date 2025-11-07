@extends('master')
@section('header')
  @if ( substr($reg->status_reg, 0, 1) == 'I' )
    <h1>Copy Resep - Rawat Inap</h1>
  @elseif ( substr($reg->status_reg, 0, 1) == 'G' )
    <h1>Copy Resep - Rawat Darurat</h1>
  @elseif ( substr($reg->status_reg, 0, 1) == 'J' )
    <h1>Copy Resep - Rawat Jalan</h1>
  @endif
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
              <td>Ruangan</td><td>{{ ($ranap->kamar_id != '') ? baca_kamar($ranap->kamar_id) : '' }}</td>
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
       
      {!! Form::close() !!}
        
      <form method="POST" id="formPenjualan" class="form-horizontal">
        {{ csrf_field() }}
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('idreg', $idreg) !!}
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
        {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
        {{-- <input type="text" name="bayar" value="{{ baca_carabayar($reg->bayar) }}"> --}}
        {{--  <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty($penjualanid) ? $penjualanid : NULL }}">  --}}
        {{--  <input type="hidden" name="cara" value="{{ $reg->bayar }}">  --}}
        <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
          <label class="col-sm-2 control-label text-primary">Uang Racik</label>
          {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
          <div class="col-sm-4">
            <select class="form-control select2" name="uang_racik" style="width: 100%;" readonly="readonly">
              @foreach ($tipe_uang_racik as $d)
                <option value="{{ $d->nominal }}">{{ $d->nama }}</option>
              @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
          </div>
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
              <select name="masterobat_id" id="masterObat" class="form-control"></select>
              <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
          </div>

          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">INACBG&nbsp;&nbsp;  </button>
                {{-- <button class="btn btn-default" type="button">Jumlah</button> --}}
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
                <button class="btn btn-default" type="button">Expired</button>
              </span>
              {!! Form::text('expired', null, ['class' => 'form-control datepicker','required']) !!}
              <small class="text-danger">{{ $errors->first('cetak') }}</small>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Takaran&nbsp;&nbsp; </button>
              </span>
              {!! Form::select('takaran', $takaran, 'Tablet', ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('takaran') }}</small>
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
              <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </span>
            {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('cetak') }}</small>
          </div>
        </div>
    </div>

        <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
          {!! Form::label('informasi1', 'Informasi', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
          </div>
          <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="addItem()">Tambahkan</button>
            </div>
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
                  <th class="text-center">Jml Kronis</th>
                  <th class="text-center">Jml Total</th>
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
                    <td>{{ !empty($d->masterobat_id) ? baca_obat($d->masterobat_id) :'' }}</td>
                    <td class="text-center">{{ $d->jumlah }}</td>
                    <td class="text-center">{{ $d->jml_kronis }}</td>
                    <td class="text-center">{{ $d->jumlah+$d->jml_kronis }}</td>
                    <td class="text-right">{{ number_format((($d->hargajual+$d->hargajual_kronis)/($d->jumlah+$d->jml_kronis))) }}</td>
                    <td class="text-right">{{ number_format($d->uang_racik) }}</td>
                    <td class="text-right">{{ number_format($d->hargajual_kronis+$d->hargajual+$d->uang_racik) }}</td>
                    <td>{{ $d->etiket }}</td>
                    <td>{{ $d->cetak }}</td>
                    {{-- {{dd('A')}} --}}
                    <td>
                      <a href="{{ url('copy-resep/deleteDetail/'.$d->id.'/'.$pasien->id.'/'.$idreg.'/'.@$penjualan->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
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
        <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty(session('penjualanid')) ? session('penjualanid') : NULL }}">
        <input type="hidden" name="cara_bayar" value="{{ $reg->bayar }}">
        {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
        <div class="col-sm-7">
          {{-- <div class="form-group {{ $errors->has('jasa_racik') ? ' has-error' : '' }} {{ ($reg->bayar != 1) ? 'hidden' : '' }}"> --}}
          <div class="form-group">
            {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-7">
              {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang', 'readonly' => 'readonly']) !!}
              <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
            </div>
          </div>
        </div>
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
          <a href="" class="btn btn-default btn-flat"  id="selesai" > SELESAI </a>
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
      $('#dataHistori').load("/copy-resep/"+id+"/history");
    });
  });

  $('.select2').select2();
  $('#viewDataOrder').load('{{ url('cartContent') }}')

  $('#masterObat').select2({
    placeholder: "Klik untuk isi nama obat",
    ajax: {
        url: '/penjualan/master-obat/',
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

  function addItem() {
    var data = $('#formPenjualan').serialize()
    $.ajax({
      url: '/copy-resep/simpan-penjualan-detail',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if( resp.status == false ){
        alert(resp.msg)
      }
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
    if (confirm('Yakin data Copy Resep sudah benar?')) {
      var  data = $('#formTotalPenjualan').serialize()
      $.ajax({
        url: '/copy-resep/simpan-total-penjualan',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('#showCetak').modal({ backdrop : 'static', keyboad : false });
          //$('#non_kronis').attr('href', '/farmasi/cetak-detail-baru/'+resp.id)
          //$('#kronis').attr('href', '/farmasi/cetak-baru-fakturkronis/'+resp.id)
          $('#non_kronis').attr('href', '/copy-resep/cetak-detail-copy-resep/'+resp.id)
          $('#kronis').attr('href', '/copy-resep/cetak-copy-resep-fakturkronis/'+resp.id)
          if (resp.jenis == 'J') {
            $('#selesai').attr('href', '/copy-resep/jalan')
          }else if( resp.jenis == 'G'){
            $('#selesai').attr('href', '/copy-resep/darurat')
          }else if (resp.jenis == 'I') {
            $('#selesai').attr('href', '/copy-resep/irna')
          }
          //window.history.back();
        }
      });
    }
  }

</script>
@endsection
