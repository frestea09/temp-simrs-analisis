@extends('master')

@section('header')
  <h1><small>Logistik Non Medik </small>Transfer Permintaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>

    <div class="box-body">
      <b>Permintaan dari: {{ \App\LogistikNonMedik\LogistikNonMedikGudang::find($gudang->gudang_asal)->nama  }} </b>
      <form method="POST" id="formTransfer">
        {{ csrf_field() }}
        <input type="hidden" name="gudang_asal" value="{{ $gudang->gudang_asal }}">
        <input type="hidden" name="gudang_tujuan" value="{{ $gudang->gudang_tujuan }}">
        <input type="hidden" name="nomor_permintaan" value="{{ $gudang->nomor }}">

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                {{--  <th class="text-center">Stok Gudang</th>  --}}
                <th class="text-center">Stok Depo</th>
                <th class="text-center">Permintaan</th>
                <th style="width: 100px;">Dikirim</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                {{--  @php
                  $masuk = \App\Logistik\LogistikStock::where('masterobat_id', $d->masterbarang_id)->where('gudang_id', 1)->sum('masuk');
                  $keluar = \App\Logistik\LogistikStock::where('masterobat_id', $d->masterbarang_id)->where('gudang_id', 1)->sum('keluar');
                  $stok_gudang = $masuk - $keluar;
                @endphp  --}}
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ \App\LogistikNonMedik\LogistikNonMedikBarang::find($d->masterbarang_id)->nama }} </td>
                  {{--  <td class="text-center">{{ $stok_gudang }}</td>  --}}
                  <td class="text-center">{{ $d->sisa_stock }}</td>
                  <td class="text-center">{{ $d->jumlah_permintaan }}</td>
                  <td>
                    {{--  <input type="hidden" name="stock{{ $no_stok++ }}" value="{{ $stok_gudang }}">  --}}
                    <input type="hidden" name="permintaan{{ $no_permintaan++ }}" value="{{ $d->jumlah_permintaan }}">
                    <input type="hidden" name="masterbarang_id{{ $no_barang++ }}" value="{{ $d->masterbarang_id }}">
                    <input type="number" min="0" max="{{ $d->jumlah_permintaan }}" onkeyup="cekStok{{ $no_cek++ }}()" name="jumlah_dikirim{{ $no_dikirim++ }}" class="form-control">
                  </td>
                </tr>
              @endforeach
              <input type="hidden" name="jml_baris" value="{{ $no_dikirim }}">
            </tbody>
            <tfoot>
              <tr>
                <th colspan="6">
                  <button type="button" onclick="saveTransfer()" class="btn btn-primary btn-flat pull-right">KIRIM</button>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </form>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
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


  function saveTransfer() {
    var data = $('#formTransfer').serialize()
    $.ajax({
      url: '/logistikmedik/save-proses-transfer-permintaan',
      type: 'POST',
      dataType: 'json',
      data: data,
    })
    .done(function(resp) {
      if (resp.sukses == true) {
        window.location = '{{ url('logistikmedik/transfer-permintaan') }}'
      }
    });

  }


</script>
@endsection
