@php
  $no =1;
@endphp
<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id="dataOrder">
    <thead class="bg-primary">
      <tr>
        <th class="text-center">No</th>
        <th>Nama Obat</th>
        {{-- <th class="text-center">Jumlah INACBG</th> --}}
        <th class="text-center">Jumlah</th>
        <th class="text-center">Jumlah Kronis</th>
        <th style="width:10%" class="text-center">Harga @</th>
         <th style="width:10%" class="text-center">Uang Racik</th>
        <th style="width:10%" class="text-center">Subtotal </th>
        <th style="width:10%" class="text-center">Cara Bayar </th>
        <th>Etiket</th>
        <th>Cetak</th>
        <th>Hapus</th>
      </tr>
    </thead>
    <tbody>
      @foreach (Cart::content() as $key => $d)
        <tr>
          <td class="text-center">{{ $no++ }}</td>
          <td>{{ $d->name }}</td>
          <td class="text-center">{{ $d->qty }}</td>
          <td class="text-center">{{ $d->options->jml_kronis }}</td>
          <td class="text-right">{{ number_format($d->price) }}</td>
          <td class="text-right">{{ number_format($d->options->uang_racik) }}</td>
          <td class="text-right">{{ number_format($d->options->subtotal) }}</td>
          <td>{{ baca_carabayar($d->options->cara_bayar_id) }}</td>
          <td>{{ $d->options->tiket }}</td>
          <td>{{ $d->options->cetak }}</td>
          <td>
            <button type="button" onclick="deleteCart('{{ $d->rowId }}')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash-o"></i></button>
          </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="6" class="text-right">Total Harga</th>
        <th class="text-right">{{ Cart::subtotal(0,','.',') }}</th>
        <th></th>
        <th></th>
        <th></th>
        <th>
          <button type="button" onclick="destroyCart()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-remove"></i></button>
        </th>
      </tr>
    </tfoot>
  </table>
</div>

