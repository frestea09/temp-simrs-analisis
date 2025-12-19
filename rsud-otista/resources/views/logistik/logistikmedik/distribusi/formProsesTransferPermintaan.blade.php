@extends('master')

@section('header')
  <h1><small>Logistik </small>Transfer Permintaan</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>

    <div class="box-body">
      <b>Permintaan dari: {{ $gudang->gudang->nama  }} </b>
      <form method="POST" id="formTransfer">
        {{ csrf_field() }}
        <input type="hidden" name="gudang_asal" value="{{ @$gudang->gudang_asal }}">
        <input type="hidden" name="gudang_tujuan" value="{{ @$gudang->gudang_tujuan }}">
        <input type="hidden" name="nomor_permintaan" value="{{ @$gudang->nomor }}">

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th class="text-center">Stok {{ @$gudang->gudangTujuan->nama }}</th>
                <th class="text-center">Stok {{ @$gudang->gudang->nama }}</th>
                <th class="text-center">Permintaan</th>
                <th style="width: 100px;">Dikirim</th>
                <th style="width: 100px;">Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->barang->nama }} </td>
                  <td>Rp. {{ number_format($d->barang->hargabeli) }} </td>
                  <td class="text-center">
                    {{ \App\LogistikBatch::where('masterobat_id', $d->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->sum('stok')}}
                  </td>
                  <td class="text-center">{{ $d->sisa_stock }}</td>
                  <td class="text-center">{{ $d->jumlah_permintaan }}</td>
                  <td>
                    {{-- <input type="hidden" name="stock{{ $no_stok++ }}" value="{{  !empty(\App\Logistik\LogistikStock::where('masterobat_id', $d->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total) ? \App\Logistik\LogistikStock::where('masterobat_id', $d->masterobat_id)->where('gudang_id', Auth::user()->gudang_id)->latest()->first()->total :0 }}">
                    <input type="hidden" name="permintaan{{ $no_permintaan++ }}" value="{{ $d->jumlah_permintaan }}">
                    <input type="hidden" name="masterobat_id{{ $no_barang++ }}" value="{{ $d->masterobat_id }}">
                    <input type="number" min="0" max="{{ $d->jumlah_permintaan }}" onkeyup="cekStok{{ $no_cek++ }}()" name="jumlah_dikirim{{ $no_dikirim++ }}" class="form-control"> --}}
                    {{-- @if($d->terkirim == $d->jumlah_permintaan || $d->terkirim <= $d->jumlah_permintaan) --}}
                    @if($d->jumlah_permintaan <= $d->terkirim)
                    <button type="button" onclick="lihatKirimBatch({{$d->id}})" class="btn btn-default btn-flat"> <i class="fa fa-icon fa-eye"></i> OBAT TERKIRIM</button>
                    @else
                    <button type="button" onclick="kirimBatch({{$d->id}})" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-send"></i> KIRIM OBAT</button>
                    {{-- <button type="button" onclick="kirimListBatch({{$d->id}})" class="btn btn-primary btn-flat"> <i class="fa fa-icon fa-send"></i> KIRIM OBAT</button> --}}
                    @endif
                  
                   
                  </td>
                  <td>
                    <button type="button" onclick="hapusBatch({{$d->id}})" class="btn btn-danger btn-flat"> <i class="fa fa-icon fa-trash"></i></button>
                  </td>
                </tr>
              @endforeach
              <input type="hidden" name="jml_baris" value="{{ $no_dikirim }}">
            </tbody>
            {{-- <tfoot>
              <tr>
                <th colspan="6">
                  <button type="button" onclick="saveTransfer()" class="btn btn-primary btn-flat pull-right">KIRIM</button>
                </th>
              </tr>
            </tfoot> --}}
          </table>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalKirimBatch">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
          <div class="table-responsive">

            <table class="table table-hover table-bordered table-condensed">
              <tbody>
                <tr>
                  <td>Jumlah Permintaan</td>
                  <td>: <b class="modal-jumlah"></b></td>
                </tr>
                  <td>Jumlah Dikirim</td>
                  <td>: <b class="modal-dikirim"></b></td>
                </tr>
                <tr>
                  <td>Sisa Stok di {{ baca_gudang_logistik(@$gudang->gudang_tujuan) }}</td>
                  <td>: <b class="modal-stok-pusat"></b></td>
                </tr>
                <tr>
                  <td>Total Stok di {{ baca_gudang_logistik(@$gudang->gudang_asal) }}</td>
                  <td>: <b class="modal-stok-farmasi"></b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-body">
          <form id="formKirim" method="post" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="nomor_permintaan">
            <input type="hidden" name="masterobat_id">
            <input type="hidden" name="gudang_asal">
            <input type="hidden" name="gudang_tujuan">
            <input type="hidden" name="nomor_permintaan" value="{{ @$gudang->nomor }}">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data">
                <thead>
                  <tr>
                    <th>Nomor Batch</th>
                    <th>Expired Date</th>
                    <th>Stok</th>
                    <th style="width: 100px;">Dikirim</th>
                    <th style="width: 100px;"></th>
                  </tr>
                </thead>
                <tbody class="listBatches">
                </tbody>
              </table>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Selesai</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalKirimBatch">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
          <div class="table-responsive">

            <table class="table table-hover table-bordered table-condensed">
              <tbody>
                <tr>
                  <td>Jumlah Permintaan</td>
                  <td>: <b class="modal-jumlah"></b></td>
                </tr>
                <tr>
                  <td>Sisa Stok di {{ baca_gudang_logistik(@$gudang->gudang_tujuan) }}</td>
                  <td>: <b class="modal-stok-pusat"></b></td>
                </tr>
                <tr>
                  <td>Total Stok di {{ baca_gudang_logistik(@$gudang->gudang_asal) }}</td>
                  <td>: <b class="modal-stok-farmasi"></b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-body">
          <form id="formKirim" method="post" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="nomor_permintaan">
            <input type="hidden" name="masterobat_id">
            <input type="hidden" name="gudang_asal">
            <input type="hidden" name="gudang_tujuan">
            <input type="hidden" name="nomor_permintaan" value="{{ @$gudang->nomor }}">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed" id="data">
                <thead>
                  <tr>
                    <th>Nomor Batch</th>
                    <th>Expired Date</th>
                    <th>Stok</th>
                    <th style="width: 100px;">Dikirim</th>
                    <th style="width: 100px;"></th>
                  </tr>
                </thead>
                <tbody class="listBatches">
                </tbody>
              </table>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Selesai</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalLihatBatch">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="DetailBatches">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Selesai</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalView">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form id="formKirim" method="post" class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <input type="hidden" name="nomor_permintaan">
          <input type="hidden" name="masterobat_id">
          <input type="hidden" name="gudang_asal">
          <input type="hidden" name="gudang_tujuan">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Nama Barang</th>
                  <th class="text-center">Stok {{ baca_gudang_logistik(@$gudang->gudang_tujuan) }}</th>
                  <th class="text-center">Stok {{ baca_gudang_logistik(@$gudang->gudang_asal) }}</th>
                  <th class="text-center">Permintaan</th>
                  <th style="width: 100px;">Dikirim</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>
                    <h6 class="nama_obat"></h6>
                  </th>
                  <th class="text-center">
                    <h6 class="stok"></h6>
                  </th>
                  <th class="text-center">
                    <h6 class="sisa_stock"></h6>
                  </th>
                  <th class="text-center">
                    <h6 class="permintaan"></h6>
                  </th>
                  <th class="text-center">
                    <h6 class="jumlah_kirim"></h6>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Selesai</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

  function kirimBatch(id) {
    $('#modalKirimBatch').modal('show')
    $.get('/logistikmedik/transfer-permintaan-depo/'+id, function(resp){
      $('.modal-title').text('Kirim '+resp.nama_obat)
      $('.nama_obat').text(resp.nama_obat)
      $('.modal-stok-pusat').text(resp.stok_pusat)
      $('.modal-stok-farmasi').text(resp.permintaan.sisa_stock)
      $('.modal-jumlah').text(resp.permintaan.jumlah_permintaan)
      $('.modal-dikirim').text(resp.permintaan.terkirim)
      $('input[name="gudang_asal"]').val(resp.permintaan.gudang_asal)
      $('input[name="gudang_tujuan"]').val(resp.permintaan.gudang_tujuan)
      $('input[name="masterobat_id"]').val(resp.permintaan.masterobat_id)
      $('.listBatches').empty()
      $.each(resp.batches, function(index, val) {
        $('.listBatches').append('<tr>'+'<td>'+val.nomorbatch+'</td>'+'<td>'+val.expireddate+'</td>'+'<td>'+val.stok+'</td>'+'<td>'+'<input type="number" min="0" max="'+val.stok+'" name="jumlah_dikirim'+val.id+'" id="'+val.id+'" data-max="'+val.stok+'" class="form-control jml">'+'</td>'+'<td>'+'<button type="button" onclick="saveTransfer('+val.id+')" class="btn btn-primary btn-flat pull-right"> <i class="fa fa-icon fa-send"></i> KIRIM</button>'+'</td>'+'</tr>')
      });
    })
  }

  // validate jumlah
  $(document).on('keyup change',"input.jml", function(){
    let id = $(this).attr('id');
    let max = $(this).attr('data-max');
    $("input[name='jumlah_dikirim"+id+"']").attr('style','');
    if( parseInt(max) < parseInt(this.value) ){
      alert('Pengiriman Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah_dikirim"+id+"']").val(max)
    }else if( parseInt(this.value) < 1 ){
      $("input[name='jumlah_dikirim"+id+"']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
    }
  })

  function kirimListBatch(id) {
    $('#modalLihatBatch').modal('show')
    $('.DetailBatches').load('/logistikmedik/transfer-permintaan-depo-baru/'+id)
  }

  function lihatKirimBatch(id) {
    $('#modalView').modal('show')
    $.get('/logistikmedik/transfer-permintaan-depo/'+id, function(resp){
      $('.modal-title').text('Kirim '+resp.nama_obat)
      $('.nama_obat').text(resp.nama_obat)
      $('.stok').text(resp.stok)
      $('.sisa_stock').text(resp.permintaan.sisa_stock)
      $('.jumlah_kirim').text(resp.permintaan.terkirim)
      $('.permintaan').text(resp.permintaan.jumlah_permintaan)
      $('input[name="gudang_asal"').val(resp.permintaan.gudang_asal)
      $('input[name="gudang_tujuan"').val(resp.permintaan.gudang_tujuan)
      $('input[name="masterobat_id"').val(resp.permintaan.masterobat_id)
      $('input[name="nomor_permintaan"').val(resp.permintaan.nomor)
    })
  }

  $('.select2').select2()

  @for ($i = 1; $i < $no_dikirim ; $i++)
    function cekStok{{ $i }}() {
      var stok{{ $i }} = $('input[name="stock{{ $i }}"]').val()
      var permintaan{{ $i }} = $('input[name="permintaan{{ $i }}"]').val()
      var dikirim{{ $i }} = $('input[name="jumlah_dikirim{{ $i }}"]').val()
      if (dikirim{{ $i }} < stok{{ $i }}) {
        //alert('Stok tidak mencukupi')
      }
      if (dikirim{{ $i }} < permintaan{{ $i }}) {
        //alert('Melebihi permintaan')
      }
    }
  @endfor


  function saveTransfer(id) {
    let max = $(this).attr('data-max');
    let stok_input = $("input[name='jumlah_dikirim"+id+"']").val();
    $("input[name='jumlah_dikirim"+id+"']").attr('style','');
    if( parseInt(max) < parseInt(stok_input) ){
      alert('Pengiriman Tidak Boleh Lebih Dari '+max+' !!');
      $("input[name='jumlah_dikirim"+id+"']").val(max)
      return false;
    }else if( parseInt(stok_input) < 1 ){
      $("input[name='jumlah_dikirim"+id+"']").attr('style','color: red;');
      alert('Input Tidak Boleh Nol Atau Minus !!');
      return false;
    }
    var data = $('#formKirim').serialize()
    $.ajax({
      url: '/logistikmedik/save-proses-transfer-permintaan/'+id,
      type: 'PUT',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        alert('Berhasil Transfer !!');
        location.reload()
      }
    });
  }
  


  function hapusBatch(id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
      url: '/logistikmedik/hapus-transfer-permintaan/'+id,
      type: 'POST',
      dataType: 'json',
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        alert('Berhasil hapus!!');
        location.reload()
      }
    });
  }








  
  function saveDetailTransfer(id) {
    var data = $('#formDetailKirim').serialize()
    $.ajax({
      url: '/logistikmedik/save-proses-transfer-permintaan/'+id,
      type: 'PUT',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        alert('Berhasil Transfer !!');
        location.reload()
      }
    });
  }

</script>
@endsection
