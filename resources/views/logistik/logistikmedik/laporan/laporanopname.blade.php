@extends('master')

@section('header')
  <h1>Logistik <small>Laporan Stock Opname</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <form method="POST" action="{{ url('logistikmedik/export') }}" class="form-horizontal" id="filterGudang">
          {{ csrf_field() }}
          <div class="row">
          
            <div class="col-sm-6">
              <div class="form-group">
                <label for="periode" class="col-sm-3 control-label">Periode</label>
                <div class="col-sm-4 {{ $errors->has('tglAwal') ? 'has-error' :'' }}">
                  <input type="text" name="tglAwal" autocomplete="off" value="{{ isset($_POST['tglAwal']) ? $_POST['tglAwal'] : NULL }}" class="form-control datepicker" required>
                </div>
                <div class="col-sm-1 text-center">
                  s/d
                </div>
                <div class="col-sm-4 {{ $errors->has('tglAkhir') ? 'has-error' :'' }}">
                  <input type="text" name="tglAkhir" autocomplete="off" value="{{ isset($_POST['tglAkhir']) ? $_POST['tglAkhir'] : NULL }}" class="form-control datepicker" required>
                </div>
              </div>

              <div class="form-group">
                <label for="periode" class="col-sm-3 control-label">Gudang</label>
                <div class="col-sm-9 {{ $errors->has('gudang') ? 'has-error' :'' }}">
                  <select name="gudang" class="form-control select2" style="width: 100%">
                    <option value="">[--Pilih--]</option>
                    @foreach ($gudang as $id => $nama)
                      <option value="{{ $id }}" {{ !empty($_POST['gudang']) && $_POST['gudang'] == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    {{-- @if (isset($_POST['gudang']) && $_POST['gudang'] == $id)
                      <option value="{{ $id }}" selected="true">{{ $nama }}</option>
                    @else
                      <option value="{{ $id }}">{{ $nama }}</option>
                    @endif --}}
                  @endforeach
                </select>
                </div>
              </div>

              {{-- <div class="form-group">
                <label for="periode" class="col-sm-3 control-label"> Rawat Inap</label>
                <div class="col-sm-9 {{ $errors->has('apotikinap') ? 'has-error' :'' }}">
                  <select name="apotikinap" class="form-control select2" style="width: 100%">
                    <option value="">[--Pilih--]</option>
                    @foreach (\App\Logistik\LogistikGudang::whereIn('id',['21'])->get() as $d)
                    @if (isset($_POST['apotikinap']) && $_POST['apotikinap'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endif
                  @endforeach
                </select>
                </div>
              </div> --}}

              {{-- <div class="form-group">
                <label for="periode" class="col-sm-3 control-label"> IGD</label>
                <div class="col-sm-9 {{ $errors->has('apotikigd') ? 'has-error' :'' }}">
                  <select name="apotikigd" class="form-control select2" style="width: 100%">
                    <option value="">[--Pilih--]</option>
                    @foreach (\App\Logistik\LogistikGudang::whereIn('id',['22'])->get() as $d)
                    @if (isset($_POST['apotikigd']) && $_POST['apotikigd'] == $d->id)
                      <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endif
                  @endforeach
                </select>
                </div>
              </div> --}}
              <div class="form-group">
                {{-- <label for="submit" class="col-sm-4 control-label">&nbsp;</label> --}}
                <div class="col-sm-10">
                  {{-- <input type="button" onclick="tampilkan()" class="btn btn-primary btn-flat fa-file-pdf" value="TAMPILKAN">  --}}
                  <input type="submit" name="tampil" class="btn btn-primary btn-flat fa-file-pdf" value="TAMPILKAN">
                  <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
                  <input type="submit" name="pdf" target="_blank" class="btn btn-warning btn-flat fa-file-pdf" value="PDF">
                  <a href="/logistikmedik/laporan-opname" class="btn btn-default btn-flat fa-file-pdf" > REFRESH </a>
                 
                </div>
              </div>
            </div>
          </div>
        </form>
        <hr/>
        @if (isset($opnames) && !empty($opnames))
        <b>Periode : Tgl {{ $tgl1 }}   s/d  {{ $tgl2 }}</b>
        @endif
        <br/><br/>
        <div class="row">
          <div class="col-sm-12">
            {{--<div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed"> --}}
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Uraian Persediaan</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Awal</th>
                    <th class="text-center">Masuk</th>
                    <th class="text-center">Keluar</th>
                    <th width="120px" class="text-center">Sisa</th>
                    <th width="120px" class="text-center">Selisih</th>
                    <th width="120px" class="text-center">Harga Persatuan</th>
                    <th width="120px" class="text-center">Jumlah Harga</th>
                    <th width="120px" class="text-center">Harga Selisih</th>
                    <th class="text-center">Expired Date</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Tanggal Opname</th>
                    <th class="text-center">Gudang</th>
                    {{--<th class="text-center">Edit</th>
                    <th class="text-center">Hapus</th> --}}
                  </tr>
                </thead>
                <tbody>
                @if (isset($opnames) && !empty($opnames))
                    @foreach ($opnames as $no => $d)
                      {{-- @php
                        $reg    = \Modules\Registrasi\Entities\Registrasi::select('poli_id')->where('id', $d->registrasi_id)->first();
                        $irna   = \App\Rawatinap::select('kamar_id')->where('registrasi_id', $d->registrasi_id)->first();
                        $pasien = \Modules\Pasien\Entities\Pasien::select('nama', 'no_rm', 'kelamin')->where('id', $d->pasien_id)->first();
                        $detail = \App\Penjualandetail::where('penjualan_id', $d->penjualan_id)->get();
                      @endphp --}}
                      <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ @baca_satuan_jual($d->satuanjual_id) }}</td>
                        <td>{{ $d->awal }}</td>
                        <td>{{ $d->masuk }}</td>
                        <td>{{ $d->keluar }}</td>
                        <td>{{ $d->sisa }}</td>
                        <td>{{ $d->awal - $d->sisa }}</td>
                        <td>{{ number_format($d->hargajual_umum) }}</td>
                        <td>{{ number_format($d->jumlah_harga*$d->sisa) }}</td>
                        <td>{{ number_format($d->hargajual_umum) }}</td>
                        <td>{{ $d->expired_date }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>{{ $d->tanggalopname }}</td>
                        <td>{{ baca_gudang_logistik($d->gudang) }}</td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="modal fade" id="opnameEditModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="formOpname">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="">
              <input type="hidden" name="obat_id" value="">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Obat</th>
                    <td>
                      <input type="text" name="nama_item" value="" class="form-control" readonly="true">
                    </td>
                  </tr>
                    <tr>
                  <th>Periode</th>
                    <td>
                      <select class="form-control select2" name="periode"  style="width: 275px;">
                       
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th>Stok Tercatat</th>
                    <td>
                      <input type="number" name="stok_tercatat" value="" class="form-control">
                    </td>
                  </tr>
                  <tr>
                    <th>Stok Sebenarnya</th>
                    <td>
                      <input type="number" name="stok_sebenarnya" value="" class="form-control">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveOpaname()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('script')
  <script>

    $('.select2').select2();

    function tampilkan(){

      $.get('getOpname/'+per+'/'+gdg, function(resp){
        $("#viewData").html(resp);
        $('table').DataTable();
      })
    }

    function edit(id) {
      $('#opnameEditModal').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Edit Opname')
      $.ajax({
        url: '/logistikmedik/getOpnameEdit/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="id"]').val(data.opnames.id)
        $('input[name="nama_item"]').val(data.opnames.nama_item)
        $('input[name="obat_id"]').val(data.opnames.obat_id)
        $('select[name="periode"]').val(data.opnames.periode).trigger('change')
        $('input[name="stok_tercatat"]').val(data.opnames.stok_tercatat)
        $('input[name="stok_sebenarnya"]').val(data.opnames.stok_sebenarnya)
      })
      .fail(function() {

      });
    }

    function saveOpaname() {
      var token = $('input[name="_token"]').val();
      var form_data = new FormData($("#formOpname")[0])

      $.ajax({
        url: '/logistikmedik/saveOpnameEdit',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          alert('Opaneme berhasil diedit.')
          $('#opnameEditModal').modal('hide');
          $("#viewData").html(resp);
        }

      });
    }

  </script>
@endsection
