<div class="table-responsive">
  <table class="table table-hover table-condensed table-bordered">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th>Nama Obat</th>
        <th class="text-center">Harga @</th>
        <th class="text-center">Uang R/Puyer</th>
        <th class="text-center">Jml</th>
        <th class="text-center">Total</th>
        {{-- <th class="text-center">Tanggal</th> --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($detail as $d)
        <tr>
          <td class="text-center">{{ $no++ }}</td>
          <td>{{ App\Masterobat::find($d->masterobat_id)->nama }}</td>
          <td class="text-right">{{ number_format($d->hargajual / $d->jumlah) }}</td>
          <td class="text-right">{{ number_format($d->uang_racik) }}</td>
          <td class="text-center">{{ $d->jumlah }}</td>
          <td class="text-right">{{ number_format($d->hargajual) }}</td>
          {{-- <td class="text-center">{{ $d->created_at->format('d-m-Y H:i:s') }}</td> --}}
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" class="text-right">Total Harga</th>
        <th class="text-right">{{ number_format($total) }}</th>
      </tr>
    </tfoot>
  </table>
</div>