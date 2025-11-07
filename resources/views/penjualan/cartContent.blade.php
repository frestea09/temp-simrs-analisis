@php
  $no =1;
  $idreg = request()->route('idreg');
  // dd(Cart::content())
@endphp
<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id="dataOrder">
    <thead class="bg-primary">
      <tr>
        <th class="text-center">No</th>
        <th>Nama Obat</th>
        {{-- <th class="text-center">Jumlah INACBG</th> --}}
        <th class="text-center">Jumlah</th>
        {{-- <th class="text-center">Jumlah Kronis</th> --}}
        <th class="text-center">Kronis</th>
        <th style="width:10%" class="text-center">Harga @</th>
         {{-- <th style="width:10%" class="text-center">Uang Racik</th> --}}
        <th style="width:10%" class="text-center">Subtotal </th>
        <th style="width:10%" class="text-center">Cara Bayar </th>
        <th>Cara Minum</th>
        <th>Etiket</th>
        <th>Cetak</th>
        <th>Hapus</th>
      </tr>
    </thead>
    <tbody>
      @php
          $subtotal = 0;
      @endphp
      @foreach (Cart::content() as $key => $d)
      @php
          $subtotal += $d->options->subtotal;
      @endphp
        <tr>
          <td class="text-center">{{ $no++ }}</td>
          <td>{{ $d->name }}</td>
          <td class="text-center">
            <input type="number" style="width: 50px;" value="{{ $d->qty }}" onchange="editJumlah('{{ $d->rowId }}', this)">
          </td>
          <td class="text-center">
            <select onchange="editStatusKronis('{{ $d->rowId }}', this)">
              <option value="Y" {{$d->options->is_kronis == 'Y' ? 'selected' : ''}}>Ya</option>
              <option value="N" {{$d->options->is_kronis == 'N' ? 'selected' : ''}}>Tidak</option>
            </select>
          </td>
          <td class="text-right">{{ number_format($d->price) }}</td>
          {{-- <td class="text-right">{{ number_format($d->options->uang_racik) }}</td> --}}
          <td class="text-right">{{ number_format($d->options->subtotal) }}</td>
          <td>{{ baca_carabayar($d->options->cara_bayar_id) }}</td>
          <td>{{ @\App\masterCaraMinum::where('id',@$d->options->cara_minum_id)->first()->nama }}</td>
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
        <th class="text-right">{{ number_format($subtotal) }}</th>
        <th></th>
        <th></th>
        <th></th>
        {{-- <th>
          <button type="button" onclick="destroyCart()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-remove"></i></button>
        </th> --}}
      </tr>
    </tfoot>
  </table>
</div>

