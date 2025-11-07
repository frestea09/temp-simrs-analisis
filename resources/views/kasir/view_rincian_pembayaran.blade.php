<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed'>
    <tbody>
      <tr>
        <th>No. RM</th><td>{{ $reg->pasien->no_rm }}</td>
      </tr>
      <tr>
        <th>Nama</th><td>{{ $reg->pasien->nama }}</td>
      </tr>
      <tr>
        <th>Alamat</th><td>{{ $reg->pasien->alamat }}</td>
      </tr>
      <tr>
        <th>No. Kuitansi</th><td>{{ $pembayaran->no_kwitansi }}</td>
      </tr>
      <tr>
        <th>Tgl Pembayaran</th><td>{{ tanggal($pembayaran->created_at) }}</td>
      </tr>
      <tr>
        <th>Kasir</th><td> {{ App\User::where('id', $pembayaran->user_id)->first()->name }} </td>
      </tr>
    </tbody>
  </table>
</div>
<div class='table-responsive'>
  <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Tarif</th>
        <th class="text-center">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rincian as $key => $d)
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ $d->namatarif }}</td>
          <td class="text-right">{{ number_format($d->total+$jasa_racik) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2" class="text-right">Total Pembayaran</th>
        <th class="text-right">{{ number_format($total+$jasa_racik) }}</th>
      </tr>
    </tfoot>
  </table>
</div>
@if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
<a href="{{ url('kasir/save-batal-bayar/'.$reg->id.'/'.$pembayaran->no_kwitansi) }}" class="btn btn-danger btn-sm btn-flat" onclick="return confirm('Yakin Pembayaran ini akan dibatalkan?')">Batalkan</a>
@else
@endif

