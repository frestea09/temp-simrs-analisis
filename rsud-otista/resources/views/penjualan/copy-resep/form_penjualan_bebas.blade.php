@extends('master')
@section('header')
  <h1>Penjualan Bebas</h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'copy-resep/savepenjualan']) !!}
        {!! Form::hidden('pasien_id', 0) !!}
        {!! Form::hidden('idreg', session('reg_id')) !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
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
        {!! Form::open(['method' => 'POST', 'url' => 'copy-resep/savedetailbebas', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('pasien_id', 0) !!}
            {!! Form::hidden('idreg', session('reg_id')) !!}
            {!! Form::hidden('penjualan_id', Request::segment(5)) !!}
            <input class="form-control" type="hidden" value="{{ Request::segment(5) }}">
            {!! Form::hidden('no_resep', $penjualan->no_resep) !!}
            <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label" style='color: blue;'>Tipe Obat</label>
              {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
              <div class="col-sm-4">
                <select class="form-control select2" name="obat_racik" style="width: 100%;" readonly="readonly">
                  @foreach ($tipe_uang_racik as $d)
                    <option value="{{ $d->nominal }}">{{ $d->nama }}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
                {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    <select class="chosen-select" name="masterobat_id" id="masterobat_id">
                      <option value=""></option>
                      @foreach ($barang as $key => $d)
                          <option value="{{ $d->id }}">{{ $d->nama }} |
                            @if (cek_jenispasien($idreg) == '1')
                              {{ number_format($d->hargajual_jkn) }}
                            @else
                              {{ number_format($d->hargajual) }}
                            @endif
                          </option>
                      @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
                </div>
                <div class="col-sm-2">
                  <input type="number" name="jumlah" value="1" class="form-control">
                </div>
            </div>

            <div class="form-group" id="uang_racik">
                {!! Form::label('uang_racik', 'Uang R.', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                  <input class="form-control uang" type="text" name="uang_racik" value="0" readonly>
                  <small class="text-danger">{{ $errors->first('uang_racik') }}</small>
                </div>
            </div>

            <div class="form-group{{ $errors->has('tiket') ? ' has-error' : '' }}">
                {!! Form::label('tiket', 'E Tiket', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-md-5">
                      {!! Form::select('tiket', $tiket, null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('tiket') }}</small>
                    </div>
                    <div class="col-md-7">
                      {!! Form::select('waktu', $aturan, 'sesudah makan', ['class' => 'chosen-select']) !!}
                    </div>
                  </div>

                </div>
            </div>
            <div class="form-group{{ $errors->has('takaran') ? ' has-error' : '' }}">
                {!! Form::label('takaran', 'Takaran', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="komposisi" class="form-control" value="1">
                    </div>
                    <div class="col-md-9">
                      {!! Form::select('takaran', $takaran, 'Tablet', ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('takaran') }}</small>
                    </div>
                  </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
                {!! Form::label('cetak', 'Cetak Etiket', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'chosen-select']) !!}
                    <small class="text-danger">{{ $errors->first('cetak') }}</small>
                </div>
                <div class="col-sm-2">
                  {!! Form::submit("Tambahkan", ['class' => 'btn btn-primary btn-flat']) !!}
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
                  <td>{{ baca_obat($d->masterobat_id) }}</td>
                  <td class="text-center">{{ $d->jumlah }}</td>
                  <td class="text-right">{{ number_format(($d->hargajual/$d->jumlah)) }}</td>
                  <td class="text-right">{{ number_format($d->hargajual) }}</td>
                  <td>{{ $d->etiket }}</td>
                  <td>{{ $d->cetak }}</td>
                  <td>
                    <a href="{{ url('copy-resep/deleteDetailbebas/'.$d->id.'/0/'.session('reg_id').'/'.$penjualan->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5" class="text-right">Total Harga</th>
                <th class="text-right">{{ number_format($detail->sum('hargajual') + count($detail)) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
        {!! Form::open(['method' => 'POST', 'url' => 'copy-resep/savetotalbebas']) !!}
          <div class="pull-right">
              <input type="hidden" name="id_penjualan" value="{{ $penjualan->id }}">
              {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
              {{-- <a href="{{ url('copy-resep/savetotalbebas/'.$penjualan->id) }}" class="btn btn-success" onclick="return confirm('Yakin sdh selesai?')"><i class="fa fa-save"></i> SIMPAN</a> --}}
          </div>
          <div class="pull-right">
            <div class="form-group">
              {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
              <div class="col-sm-7">
                {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang']) !!}
                <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
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

  $('.select2').select2();
  $(document).ready(function() {
    $('#uang_racik').addClass('hide');
    $("input[name='uang_racik']").val(0);
    $('.uang').maskNumber({
			thousands: ".",
			integer: true,
    });
  });

</script>
@endsection
