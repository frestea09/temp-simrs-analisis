@foreach ($opnames as $o)
    <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>{{ $o->tanggalopname }}</td>
        <td>{{ baca_obat($o->obat_id) }}</td>
        <td>{{ baca_satuan_jual($o->satuanjual_id) }}</td>
        <td class="text-center">{{ batch($o->logistik_batch_id) }}</td>
        {{-- <td>{{ date("m", strtotime($o->created_at ))}}</td> --}}
        <td class="text-center" width="10px">{{ $o->stok_tercatat }}</td>
        <td class="text-center">{{ opnameMasuk($o->id) }}</td>
        <td class="text-center">{{ opnameKeluar($o->id) }}</td>
        <td class="text-center" width="10px">{{ $o->stok_sebenarnya }}</td>
        <td class="text-center">{{ ExpiredDate($o->id) }}</td>
        <td class="text-center">{{ $o->keterangan }}</td>
        {{-- <td class="text-center" width="10px">
            <button type="submit" name="submit" onclick="edit({{ $o->id }})" class="btn btn-success btn-flat btn-sm"><i class="fa fa-pencil"> </i> Edit</button>
        </td>
        <td class="text-center" width="10px">
            <a href="{{ url('logistikmedik/hapus-opname/'.$o->id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i> Hapus</a>
        </td> --}}
    </tr>
@endforeach