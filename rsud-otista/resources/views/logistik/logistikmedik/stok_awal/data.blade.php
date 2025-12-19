<div class="table-responsive">
  <table class="table table-hover table-bordered table-condensed">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Item</th>
        <th>Batch No</th>
        <th>Expired Date</th>
        <th>Supplier</th>
        <th class="text-center">Total Batch</th>
        <th>Edit</th>
        <th>Hapus</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $d)
        @php
            $totalItem = \App\Logistik\LogistikStock::where('masterobat_id', $d->masterobat_id)->get();
        @endphp
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->item->nama }}</td>
        <td>{{ $d->batch_no }}</td>
        <td>{{ $d->expired_date }}</td>
        <td>{{ $d->supplier->nama }}</td>
        <td class="text-center">{{ $d->total }}</td>
        <td><button class="btn btn-info btn-sm btn-flat" onclick="editSaldoAwal({{ $d->id }})"><i class="fa fa-pencil-square-o"></i></button></td>
        <td><button class="btn btn-danger btn-sm btn-flat" onclick="hapusSaldoAwal({{ $d->id }})"><i class="fa fa-trash-o"></i></button></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
