@extends('master')

@section('header')
  <h1>Logistik - Pengembalian Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Pengembalian Obat
      </h3>
    </div>
    <div class="box-body">
      <form class="form-horizontal" method="POST" action="{{ url('pengembalian/save') }}">
        {{ csrf_field() }}
      <input type="hidden" name="pinjam_id" value="{{ $peminjaman->id }}">  
      <h5>Peminjaman Pada: </h5>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nomorberita" class="col-sm-4 control-label">Berita Acara Pinjam</label>
                <div class="col-sm-8">
                  <input type="text" name="beritaacarapinjam" value="{{ $peminjaman->nomorberitaacara }}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="pinjamdari" class="col-sm-4 control-label">Pinjam Dari</label>
                <div class="col-sm-8">
                  <input type="hidden" name="rspinjam" value="{{ $peminjaman->pinjam_dari }}" class="form-control" readonly>
                  <input type="text" name="pinjamdari" value="{{ \App\Rstujuanpinjam::where('id', $peminjaman->pinjam_dari)->first()->nama }}" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ date('d-m-Y', strtotime($peminjaman->tgl_pinjam)) }}" name="tanggalpinjam" class="form-control datepicker" readonly>
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>
              
            </div>
          </div>
              
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Pinjam </th>
                  {{-- <th>Hapus</th> --}}
                </tr>
              </thead>
              @isset($rincian)
                <tbody>
                  @foreach ($rincian as $i)
                  @php
                      $pinjam = $peminjaman->id;
                  @endphp
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ baca_obat($i->masterobat_id) }}</td>
                      <td>{{ $i->jumlah }}</td>
                      {{-- <td><a href="{{ url('hapus-pinjam-obat/'.$i->id) }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-icon fa-trash"></i> </a></td> --}}
                      <td>
                        <a onclick="detail({{ $i->masterobat_id }}, {{ $pinjam }})" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-icon fa-eye"></i> Detail</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              @endisset
            </table>
          </div>
          <hr>

          @if (empty($pengembalian))
          <h5>Pengembalian Pada:</h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nomorberita" class="col-sm-4 control-label">Berita Pengembalian</label>
                <div class="col-sm-8">
                  @if (!empty($pengembalian))
                  <input type="text" name="beritapengembalian" value="{{ $pengembalian->nomorberitaacara }}" class="form-control" readonly>
                  @else
                  <input type="text" name="beritapengembalian" value="" class="form-control">
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="pinjamdari" class="col-sm-4 control-label">Dikembalikan Kepada: </label>
                <div class="col-sm-8">
                  <input type="text" name="dikembalikan" value="{{ \App\Rstujuanpinjam::where('id', $peminjaman->pinjam_dari)->first()->nama }}" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  @if (!empty($pengembalian))
                  <input type="text" value="{{ date('d-m-Y', strtotime($pengembalian->tgl_pengembalian)) }}" name="tanggalpengembalian" class="form-control datepicker" readonly>
                  @else
                  <input type="text" value="" name="tanggalpengembalian" class="form-control datepicker">
                  @endif
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>

              @if (!empty($pengembalian))
                  
              @else
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                  <button type="submit" class="btn btn-primary btn-flat">
                      Simpan
                  </button>
                  
                </div>
              </div>
              @endif
            </div>
          </div>
          @endif
        </form>
    </div>
  </div>

  @if (!empty($pengembalian))
      
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form Pengembalian Obat
      </h3>
    </div>
    <div class="box-body">

      @if (!empty($pengembalian))
          <h5>Pengembalian Pada:</h5>
          <div class="row form-horizontal">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nomorberita" class="col-sm-4 control-label">Berita Pengembalian</label>
                <div class="col-sm-8">
                  @if (!empty($pengembalian))
                  <input type="text" name="beritapengembalian" value="{{ $pengembalian->nomorberitaacara }}" class="form-control" readonly>
                  @else
                  <input type="text" name="beritapengembalian" value="" class="form-control">
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="pinjamdari" class="col-sm-4 control-label">Dikembalikan Kepada: </label>
                <div class="col-sm-8">
                  <input type="text" name="dikembalikan" value="{{ \App\Rstujuanpinjam::where('id', $peminjaman->pinjam_dari)->first()->nama }}" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  @if (!empty($pengembalian))
                  <input type="text" value="{{ date('d-m-Y', strtotime($pengembalian->tgl_pengembalian)) }}" name="tanggalpengembalian" class="form-control datepicker" readonly>
                  @else
                  <input type="text" value="" name="tanggalpengembalian" class="form-control datepicker">
                  @endif
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>

              @if (!empty($pengembalian))
                  
              @else
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                  <button type="submit" class="btn btn-primary btn-flat">
                      Simpan
                  </button>
                  
                </div>
              </div>
              @endif
            </div>
          </div>
          @endif

        <form method="POST" class="form-horizontal" action="{{ route('simpan-rincian-pengembalian-obat') }}">
          {{ csrf_field() }}
          <input type="hidden" name="batch_id" value="" class="form-control">
          <input type="hidden" name="namabatch" value="" class="form-control">
          <input type="hidden" value="{{ $pengembalian->id }}" name="pengembalian_id">
          <input type="hidden" value="{{ $pengembalian->nomorberitaacara }}" name="nomorberita">
          <input type="hidden" value="{{ App\Rstujuanpinjam::where('id', $pengembalian->rspinjam_id)->first()->nama }}" name="rskembali">
           
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Nomor Batch</th>
                      <th>Jumlah Pengembalian</th>
                      <th>Satuan</th>
                      <th>Expired Date</th>
                      <th>Harga Beli</th>
                      <th>Harga Jual</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 25%">
                        <select name="masterobat_id" onchange="masterObat()" class="form-control select2" style="width: 100%">
                          <option value="0">[ -- ]</option>
                          @foreach ($masterobat as $d)
                            <option value="{{ $d->id }}">{{ $d->nama_obat  }} | {{ $d->nomorbatch  }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td style="width: 10%" class="kolomJumlah">
                        <input type="text" name="nomorbatch" value="" class="form-control">
                      </td>
                      <td style="width: 9%" class="kolomJumlah"><input type="number" name="jumlah" class="form-control"></td>
                      <td style="width: 15%">
                        <select name="satuan"  class="form-control select2" readonly>
                            <option value="0">[ -- ]</option>
                            @foreach ($satuan as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                      </td>
                      <td style="width: 11%">
                        <input type="text" name="expired" value="" class="form-control datepicker">
                      </td>
                      <td style="width: 15%">
                        <input type="number" name="hargabeli" value="" class="form-control">
                      </td>
                      <td style="width: 15%">
                        <input type="number" name="hargajual" value="" class="form-control">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
                        <a href="{{ url('peminjaman') }}" class="btn btn-default btn-flat pull-right"> Selesai</a>

                        <button type="submit" class="btn btn-primary btn-flat pull-right">
                          Simpan
                      </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </form>

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Nomor Batch </th>
                <th>Jumlah Dikembalikan </th>
                {{-- <th>Hapus</th> --}}
              </tr>
            </thead>
            @isset($rincianpengembalian)
              <tbody>
                @foreach ($rincianpengembalian as $i)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ baca_obat($i->masterobat_id) }}</td>
                    <td>{{ batch($i->logistik_batch_id) }}</td>
                    <td>{{ $i->jumlah }}</td>
                    {{-- <td><a href="{{ url('hapus-pengembalian-obat/'.$i->id) }}" class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-icon fa-trash"></i> </a></td> --}}
                  </tr>
                @endforeach
              </tbody>
            @endisset
          </table>
        </div>
    </div>
  </div>
  @endif

  <div class="modal fade" id="modalDetailObat">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Nomer Batch</th>
                  <th>Nama Barang</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
                <tbody class="nomorBatch">
                    <tr>
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()

  function detail(masterobat_id, pinjam_id) {
    $('#modalDetailObat').modal({
      backdrop: 'static',
      keyboard : false,
    })
    $.ajax({
      url: '/pengembalian/detail-batch/'+masterobat_id+'/'+pinjam_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(data) {
      $('.nomorBatch').empty()
      $.each(data.obat, function(index, val) {
        $('.nomorBatch').append('<tr>'+'<td>'+val.nomorbatch+'</td>'+'<td>'+val.nama_obat+'</td>'+'<td>'+val.jumlah+'</td>'+'</tr>')
      });
    })
  }

  function masterObat() {
    var nomorbatch = $('select[name="masterobat_id"]').val()
    $.ajax({
      url: '/pengembalian/detail-obat-batch/'+nomorbatch,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      if (json.sukses == true) {
        $('input[name="namabatch"]').val(json.obat.nama_obat);
        $('input[name="nomorbatch"]').val(json.obat.nomorbatch);
        $('input[name="batch_id"]').val(json.obat.id);
        $('input[name="expired"]').val(json.obat.expireddate);
        $('input[name="hargabeli"]').val(json.obat.hargabeli);
        $('input[name="hargajual"]').val(json.obat.hargajual_umum);
        $('select[name="satuan"]').val(json.obat.satuanjual_id).trigger('change');
      }
      if (json.sukses == false) {
        $('input[name="expired"]').val('');
        $('input[name="hargabeli"]').val('');
        $('input[name="hargajual"]').val('');
        $('input[name="namabatch"]').val('');
        $('input[name="nomorbatch"]').val('');
        $('select[name="satuan"]').val('');
      }
    });
  }
</script>
@endsection
