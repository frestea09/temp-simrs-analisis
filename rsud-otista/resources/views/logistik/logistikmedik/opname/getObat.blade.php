{{-- @foreach ($obat as $item)
    @php
        $satuan = App\Satuanjual::where('id', $item->satuanjual_id)->first();
    @endphp
    <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>
            <input class="form-control" type="hidden" name="obat_id[]" value="{{ $item->id }}" readonly>
            <input class="form-control" type="text" value="{{ $item->nama }}" readonly>
        </td>
        <td><input class="form-control" type="text" value="{{ $satuan->nama }}" readonly></td>
        <td><input class="form-control text-center" type="number" name="stok_sebenarnya[{{ $item->id }}]"></td>
        <input type="text" class="form-control" name="obat_id[]" value="{{ $item->id }}">
    </tr>
@endforeach --}}
@foreach ($obat as $item)
{{-- {!! Form::model($item, ['route' => ['rincianlab.update', $item->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!} --}}

    <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>
            <input class="form-control" type="hidden" name="logistikbatch_id" value="{{ $item->id }}" readonly>
            <input class="form-control" type="text" name="masterobat_id" value="{{ baca_obat($item->masterobat_id) }}" readonly>
        </td>
        <td><input class="form-control" type="text" name="satuanbeli" value="{{ baca_satuan_beli($item->satuanbeli_id) }}" readonly></td>
        <td><input class="form-control" type="text" name="satuanjual" value="{{ $item->nomorbatch }}" readonly></td>
        {{-- <td width="10px"><input class="form-control text-center" type="number" name="stok_tercatat[]" value="{{ stokTercatat($item->id, $per, Auth::user()->gudang_id) }}" readonly></td> --}}
        <td><input class="form-control text-center" name="stok{{ $item->id }}" type="number" value="{{ $item->stok }}"></td>
        <td><input class="form-control text-center" name="expired{{ $item->id }}" type="text" value="{{ $item->expireddate }}"></td>
        <td><input class="form-control text-center" name="keterangan{{ $item->id }}" type="text" name="keterangan" value="{{ !empty($opname->keterangan) ? $opname->keterangan : NULL }}"></td>
        {{-- <td><input class="form-control" type="text" name="keterangan[]" value="{{ keteranganOpname($item->id, $per) }}"></td> --}}
        <td><button type="button" onclick="edit({{ $item->id }})" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-icon fa-pencil-square-o"></i></button></td>
        <td>
            @if (cekBatchOpname($item->id))
                <button class="btn btn-default btn-flat" disabled><i class="fa fa-check"> <del>Opname</del></i></button>
            @else
                <button type="button" onclick="simpan({{ $item->id }})" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-save"></i> Opname</button>
            @endif
        </td>
    </tr>
    {{-- {!! Form::close() !!} --}}

@endforeach
