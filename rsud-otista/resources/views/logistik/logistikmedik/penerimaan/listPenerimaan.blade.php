@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Berita Acara Penerimaan Barang dari Supplier
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" id="formBerita" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id">
            <input type="hidden" name="no_po" value="{{ !empty($verif->no_po) ? $verif->no_po : '' }}">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Supplier</label>
                  <div class="col-sm-6">
                      <input type="text" name="suplier" value="{{ !empty($verif->supplier) ? $verif->supplier : 'kosong' }}" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nomor Berita Acara</label>
                  <div class="col-sm-6">
                      <input type="text" name="nomor" value="{{ $nomorBAPB }}" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">No Faktur Supplier</label>
                  <div class="col-sm-6">
                      <input type="text" name="no_faktur" value="SP-{{str_slug(baca_kategori_obat($verif->kategori_obat))}}-" class="form-control">
                      <span class="text-danger no_fakturError"></span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Tanggal Terima</label>
                  <div class="col-sm-6">
                      <input type="text" name="tanggal_faktur" value="{{ date('d-m-Y') }}" class="form-control datepicker">
                      <span class="text-danger tanggal_fakturError"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Tanggal Jatuh Tempo</label>
                  <div class="col-sm-6">
                      <input type="text" name="tanggal_jatuh_tempo" value="{{ date('d-m-Y') }}" class="form-control datepicker">
                  </div>
                </div>
              </div>
            </div>
            <div class="table table-responsive">

              <table class="table table-striped table-bordered table-condensed" style="font-size:12px;">
                  <thead>
                  <tr>
                      <th>Nama Obat</th>
                      <th>Satuan</th>
                      <th>Stok Gudang</th>
                      <th>Dipesan</th>
                      {{-- <th>Sisa</th> --}}
                      <th>Dikirim</th>
                      <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>
                      @isset($penerimaan)
                          @foreach ($penerimaan as $d)
                          @php
                            //   $kondisi = \App\Logistik\Logistik_BAPB::where('no_po', $d->no_po)->where('nama', $d->nama)->get();
                            //   Kolom 'kondisi' tidak ada di database
                            //   $kondisi->sum('kondisi') selalu return 0
                          @endphp
                          <tr>
                              <td>
                                {{$d->nama}}
                                <input type="hidden" name="nama[]" value="{{ $d->nama }}" class="form-control" readonly><input type="hidden" name="item[]" value="{{ $d->nama }}">
                              </td>
                              <td><input type="text" name="satuan[]" value="{{ $d->nama_satuan }}" class="form-control" readonly></td>
                              <td>
                                {{ @$stocks->where('masterobat_id', $d->masterobat_id)->first()->stok ? @$stocks->where('masterobat_id', $d->masterobat_id)->first()->stok : 0}}
                              </td>
                              <td>
                                <input type="text" name="jumlah[]" value="{{ $d->jumlah }}" class="form-control" readonly>
                              </td>
                              <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                      @if ($d->jumlah == 0)
                                        {{ 0 }}
                                        <i class="fa fa-check-square bg-green"></i>
                                      @else
                                        <i class="fa fa-check-square bg-red"></i>
                                      @endif
                                    </span>
                                    @if ($d->jumlah == 0)
                                      <input type="text" name="kondisi[]" value="" class="form-control" readonly>
                                    @else
                                      @if ($list->where('no_po',$d->no_po)->where('nama', $d->nama)->first())
                                        <input type="text" name="kondisi[]" value="" class="form-control" readonly>
                                      @else
                                        <input type="number" name="kondisi[]" value="" class="form-control">
                                      @endif
                                    @endif
                                </div>
                              </td>
                              <td>
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    @if ($d->jumlah == 0)
                                      <i class="fa fa-check-square bg-green"></i>
                                    @else
                                      <i class="fa fa-check-square bg-red"></i>
                                    @endif
                                  </span>
                                    @if ($d->jumlah == 0)
                                      <input type="text" name="keterangan[]" class="form-control" readonly>
                                    @else
                                      <input type="text" name="keterangan[]" class="form-control">
                                    @endif
                                </div>
                              </td>
                          </tr>
                          @endforeach
                      @endisset
                  </tbody>
              </table>
            </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-flat" onclick="saveBerita()">Simpan</button>
          <a href="{{ url('logistikmedik/penerimaan') }}" type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-hidden="true">selesai</a>
          {{-- <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button> --}}
        </div>
    </div>
  </div>


@if ($list->first())
    
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Histori Berita Acara
           @php
            $noPO = \App\NoPo::where('no_po',$verif->no_po)->first();
                if(!empty($noPO)){
                      $id = $noPO->id;
                    } else {
                      $id = noPo($verif->no_po);
                }
           @endphp
      </h3>
      
      <a href="{{ url('logistikmedik/penerimaan/add-penerimaan/'.$id) }}" title="Masukkan Obat ke Stok Gudang" class="btn btn-primary btn-md pull-right">MASUKKAN KE GUDANG</a>
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered table-condensed">
            <thead>
            <tr>
                <th>No Faktur</th>
                <th>Tanggal Faktur</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Stok Gudang</th>
                <th>Dipesan</th>
                <th>Dikirim</th>
                <th>Keterangan</th>
                <th>Hapus</th>
            </tr>
            </thead>
            <tbody>
                  @foreach ($list as $d)
                  {{-- @php
                      $obat =  \App\Masterobat::where('nama', $d->nama)->first();
                  @endphp --}}
                  <tr>
                      <td>{{ $d->no_faktur }}</td>  
                      <td>{{ $d->tanggal_faktur }}</td>
                      <td>{{ $d->nama }}</td>
                      <td>
                        {{ $d->satuan }}
                      </td>
                      <td>
                        {{  @$stocks->where('masterobat_id', $d->masterobat_id)->first()->stok ?  @$stocks->where('masterobat_id', $d->masterobat_id)->first()->stok : 0 }}
                      </td>
                      <td><input type="text" name="jumlah[]" value="{{ $d->jumlah_dipesan }}" class="form-control" readonly></td>
                      <td>{{ $d->jumlah_diterima }}</td>
                      <td>{{ $d->keterangan }}</td>
                      <td>
                        {{-- Table LogistikPenerimaan selalu kosong --}}
                        {{-- @if (\App\Logistik\LogistikPenerimaan::where('no_faktur', $d->no_faktur)->where('masterobat_id', $obat->id)->count() > 0)
                          <button class="btn btn-success btn-sm btn-flat"><i class="fa fa-check">Sudah</i></button>
                        @else
                          <a href="{{ url('logistikmedik/bapb-hapus/'.$d->id) }}" class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Yakin transaksi ini akan dihapus ?');" ><i class="fa fa-remove"></i></a>
                        @endif --}}
                        <a href="{{ url('logistikmedik/bapb-hapus/'.$d->id) }}" class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Yakin transaksi ini akan dihapus ?');" ><i class="fa fa-remove"></i></a>
                      </td>
                  </tr>
                  @endforeach
            </tbody>
        </table>
    </div>
  </div>
@endif


@endsection

@section('script')
<script type="text/javascript">
$(".skin-blue").addClass( "sidebar-collapse" );
    function saveBerita() {
      var data = $('#formBerita').serialize()
      var id = $('input[name="id"]').val()

      $.ajax({
        url: '/logistikmedik/bapb',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .fail(function(json) {
        if (json.status === 422) {
          var data = json.responseJSON;
          if (data.errors.no_faktur) {
            $('.no_fakturError').html(data.errors.no_faktur[0]);
          }
          if (data.errors.tanggal_faktur) {
            $('.tanggal_fakturError').html(data.errors.tanggal_faktur[0]);
          }
        }
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $("#formBerita")[0].reset()
          location.reload();
          alert('Berita Acara Berhasil Dibuat!!')
        }
        if (resp.sukses == false) {
          alert('Berita Acara Udah Disimpan!!')
        }
      });
  }
</script>
@endsection
