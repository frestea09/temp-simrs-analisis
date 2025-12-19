<table>
  <thead>
    <tr>
      <th>No</th>
      <th>No Faktur</th>
      <th>Tanggal Faktur</th>
      <th>Supplier</th>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Satuan</th>
      <th>Jumlah</th>
      <th>Harga Beli Satuan</th>
      <th>Diskon Rp.</th>
      <th>Jumlah Pembelian</th>
      <th>PPN %</th>
      <th>PPN Rp.</th>
      <th>Jenis Pembayaran</th>
    </tr>
  </thead>
  <tbody>
    @if (!empty($po))
      @php
          $no = 1;
          $total = 0;
      @endphp
      @foreach ($po as $key => $items)
        @php
          $rowspan = $items->count();
        @endphp
        @foreach ($items as $st)
          @php
            $total += $st->po->totalHarga;
          @endphp
          <tr>
            {{-- @if ($loop->first) --}}
              
            <td class="text-center" style="vertical-align: middle;">{{ $no++ }}</td>
            <td class="text-center" style="vertical-align: middle;">{{$st->no_faktur}}</td>
            <td class="text-center" style="vertical-align: middle;">{{$st->tgl_faktur}}</td>
            {{-- @endif --}}
            <td>{{$st->supplier}}</td>
            <td>{{@$st->po ? @$st->po->kode_barang : '-'}}</td>
            <td>{{$st->nama_barang}}</td>
            <td>{{@$st->po ? baca_satuan_beli($st->po->satuan) : '-'}}</td>
            <td>{{@$st->po ? $st->po->jumlah : '-'}}</td>
            <td>{{@$st->po ? 'Rp. ' . number_format($st->po->harga) : ''}}</td>
            <td>{{@$st->po ? 'Rp. ' . number_format($st->po->diskon_rupiah): ''}}</td>
            <td>{{@$st->po ? 'Rp. ' . number_format($st->po->totalHarga) : ''}}</td>
            <td>{{$st->po->jml_ppn ?? 0}}%</td>
            <td>
              @php
                $totalPPN = @$st->po ? $st->po->totalHarga * ($st->po->jml_ppn / 100) : 0;
              @endphp
              {{'Rp. ' . number_format($totalPPN)}}
            </td>
            <td>{{$st->jenis_pembayaran == 1 ? 'Cash' : 'Faktur'}}</td>
          </tr>
        @endforeach
      @endforeach
      <tr>
        <td colspan="14">
          Total : {{ 'Rp. ' . number_format($total) }}
        </td>
      </tr>
    @endif
  </tbody>
</table>