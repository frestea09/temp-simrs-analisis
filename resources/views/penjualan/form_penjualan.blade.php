@extends('master')
@section('header')
  @if ( substr($reg->status_reg, 0, 1) == 'I' )
    <h1>Penjualan Rawat Inap</h1>
  @elseif ( substr($reg->status_reg, 0, 1) == 'G' )
    <h1>Penjualan Rawat Darurat</h1>
  @elseif ( substr($reg->status_reg, 0, 1) == 'J' )
    <h1>Penjualan Rawat Jalan</h1>
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
        {{-- <input type="text" name="bayar" value="{{ baca_carabayar($reg->bayar) }}"> --}}
        {!! Form::hidden('penjualan_id', Request::segment(5)) !!}
        <input type="hidden" name="cara" value="{{ $reg->bayar }}">
        <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
          <label class="col-sm-2 control-label" style='color: blue;'>Tipe Obat</label>
          {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
          <div class="col-sm-4">
            <select class="form-control select2" name="obat_racik" style="width: 100%;">
              <option value=""></option>
              <option value="Y">Racikan</option>
              <option value="N">Bukan Racikan</option>
            </select>
            <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">INACBG</button>
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
        </div>
        <div class="form-group{{ $errors->has('aturan_pakai') ? ' has-error' : '' }}">
          {!! Form::label('aturan_pakai', 'Aturan Pakai', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::select('tiket', $tiket, null, ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('tiket') }}</small>
          </div>
          <div class="col-sm-3">
            {!! Form::select('takaran', $takaran, 'Tablet', ['class' => 'form-control select2']) !!}
            <small class="text-danger">{{ $errors->first('takaran') }}</small>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Expired</button>
              </span>
              {!! Form::text('expired', null, ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('cetak') }}</small>
            </div>
          </div>
        </div>

        <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
          {!! Form::label('informasi1', 'Informasi 1', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('informasi1') }}</small>
          </div>
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Cetak</button>
              </span>
              {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('cetak') }}</small>
            </div>
          </div>

          <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="addItem()">Tambahkan</button>
            </div>
          </div>
        </div>

        <div class="form-group {{ $errors->has('cara_bayar_id') ? ' has-error' : '' }} {{ (substr($reg->status_reg, 0, 1) == 'J') ? 'hidden' : '' }}">
        {{-- <div class="form-group"> --}}
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
        </div>
        <div class="form-group" id="uang_racik">
            {!! Form::label('uang_racik', 'Uang R.', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <input class="form-control uang" type="text" name="uang_racik" value="{{ ($reg->bayar != 1) ? config('app.uang_racik') : 0}}" readonly>
              <small class="text-danger">{{ $errors->first('uang_racik') }}</small>
            </div>
        </div>
        <hr>
        <div id="viewDataOrder"></div>
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
              <button type="button" onclick="savePenjualan()" class="btn btn-success btn-flat">SIMPAN</button>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
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
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
  $('select[name="cara_bayar_id"]').on('change', function () {
    if ($(this).val() != 1) {
        $('#uang_racik').removeClass('hide');
    } else {
        $('#uang_racik').addClass('hide');
    }
  });
  $('select[name="obat_racik"]').on('change', function () {
    if ($(this).val() != 'Y') {
        $('#uang_racik').removeClass('hide');
    } else {
        $('#uang_racik').addClass('hide');
    }
  });
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
      $('#dataHistori').load("/penjualan/"+id+"/history");
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
      url: '/cartAdd',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        $('select[name="masterobat_id"]').empty()
        $('#viewDataOrder').load('{{ url('cartContent') }}')
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
      var  data = $('#formPenjualan').serialize()
      $.ajax({
        url: '/penjualan/new-save-penjualan',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('#showCetak').modal({ backdrop : 'static', keyboad : false });
          $('#non_kronis').attr('href', '/farmasi/cetak-detail/'+resp.id)
          $('#kronis').attr('href', '/farmasi/cetak-fakturkronis/'+resp.id)
          if (resp.jenis == 'J') {
            $('#selesai').attr('href', '/penjualan/jalan')
          }else if( resp.jenis == 'G'){
            $('#selesai').attr('href', '/penjualan/darurat')
          }else if (resp.jenis == 'I') {
            $('#selesai').attr('href', '/penjualan/irna')
          }
          //window.history.back();
        }
      });
    }
  }

</script>
@endsection
