<div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
        <tr>
        <th class="text-center">No</th>
        <th>Nama Obat</th>
        <th class="text-center">Jumlah INACBG</th>
        <th class="text-center">Jumlah Kronis</th>
        <th class="text-center">Jml</th>
        <th style="width:10%" class="text-center">Harga @</th>
        <th>Etiket</th>
        <th>Cetak</th>
        <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail as $key => $d)
        <tr>
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ $d->masterobat->nama }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center">{{ $d->jumlah }}</td>
            <td class="text-right">{{ number_format($d->hargajual) }}</td>
            <td>{{ $d->etiket }}</td>
            <td>{{ $d->cetak }}</td>
            <td>
            <a href="{{ url('penjualan/deleteDetail/'.$d->id.'/'.$pasien->id.'/'.$idreg.'/'.$penjualan->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
        <th colspan="3" class="text-right">Total Harga</th>
        <th class="text-right">{{ number_format($detail->sum('hargajual')) }}</th>
        </tr>
    </tfoot>
    </table>
</div>
<div class="pull-right">
    <a href="{{ url('penjualan/savetotal/'.$penjualan->id) }}" class="btn btn-success" onclick="return confirm('Yakin sdh selesai?')"><i class="fa fa-save"></i> SIMPAN</a>
</div>