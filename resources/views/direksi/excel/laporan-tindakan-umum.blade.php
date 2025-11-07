<table class='table table-bordered table-hover' style="font-size:11px;">
    <thead>
        <tr class="text-center">
            <th class="text-center">No. RM</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Total</th>
            <th class="text-center">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tindakan_pasien_new as $item)
        <tr>
            <td>{{$item->no_rm}}</td>
            <td>{{$item->nama_pasien}}</td>
            <td>{{$item->total}}</td>
            <td>{{@date('d-m-Y H:i',strtotime($item->tgl_reg))}}</td>
        </tr>
        @endforeach

    </tbody>
</table>