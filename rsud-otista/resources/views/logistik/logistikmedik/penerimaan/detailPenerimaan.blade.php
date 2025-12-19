<table class="table table-hover table-bordered table-condensed">
    <thead>
    <tr>
        <th>Nama Obat</th>
        <th>Satuan</th>
        <th>Stok Gudang</th>
        <th>Jumlah Dipesan</th>
        <th>Jumlah Dikirim</th>
        <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
        @isset($penerimaan)
            @foreach ($penerimaan as $d)
            <tr>
                <td><input type="text" name="nama[]" value="{{ $d->nama }}" class="form-control" readonly><input type="hidden" name="item[]" value="{{ $d->nama }}"></td>
                <td><input type="text" name="satuan[]" value="{{ $d->nama_satuan }}" class="form-control" readonly></td>
                <td>{{ !empty(\App\Logistik\LogistikStock::where('masterobat_id', $d->masterobat_id)->latest()->first()->total) ? \App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $d->masterobat_id)->latest()->first()->total:0}}</td>
                <td><input type="text" name="jumlah[]" value="{{ $d->jumlah }}" class="form-control" readonly></td>
                <td><input type="number" name="kondisi[]" value="{{ !empty(\App\Logistik\Logistik_BAPB::where('no_po', $d->no_po)->where('nama', $d->nama)->first()->kondisi) ? \App\Logistik\Logistik_BAPB::where('no_po', $d->no_po)->where('nama', $d->nama)->first()->kondisi : 0 }}" class="form-control"></td>
                <td><input type="text" name="keterangan[]" value="{{ $d->keterangan }}" class="form-control"></td>
            </tr>
            @endforeach
        @endisset
    </tbody>
</table>