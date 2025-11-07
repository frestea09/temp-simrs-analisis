@php
  $no =1;
  $idreg = request()->route('idreg');
@endphp
<div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th>Nama Obat</th>
            <th class="text-center">Kronis</th>
            <th class="text-center">Jml</th>
            <th style="width:10%" class="text-center">Harga @</th>
            <th style="width:10%" class="text-center">Racik</th>
            <th style="width:10%" class="text-center">Total</th>
            <th>Etiket/Signa</th>
            <th>Cara Minum</th>
            <th>Informasi</th>
            {{-- <th>Cetak</th> --}}
            <th>Hapus</th>
          </tr>
        </thead>
        <tbody>
          @foreach (Cart::instance('obat'. $idreg)->content() as $key => $d)
            <tr>
              <td class="text-center">{{ $no++ }}</td>
              <td>{{ $d->name }}</td>
              <td class="text-center">
                <select onchange="editStatusKronis('{{ $d->rowId }}', this)">
                  <option value="Y" {{$d->options->is_kronis == 'Y' ? 'selected' : ''}}>Ya</option>
                  <option value="N" {{$d->options->is_kronis == 'N' ? 'selected' : ''}}>Tidak</option>
                </select>
                {{-- {{ $d->options->is_kronis }} --}}
              </td>
              <td class="text-center">
                <input type="number" style="width: 50px;" value="{{ $d->qty }}" onchange="editJumlah('{{ $d->rowId }}', this)">
              </td>
              <td class="text-right">{{ number_format($d->price) }}</td>
              <td class="text-right">{{ number_format($d->options->uang_racik) }}</td>
              <td class="text-right">{{ number_format($d->options->subtotal) }}</td>
              <td>{{ $d->options->tiket }}</td>
              <td>{{ $d->options->cara_minum }}</td>
              <td>{{ $d->options->informasi1 }}</td>
              {{-- <td>{{ $d->cetak }}</td> --}}
              <td>
                {{-- <a href="{{ url('penjualan/deleteDetailBaru/'.@$d->id.'/'.@$pasien->id.'/'.$idreg.'/'.@$penjualan->id.'/'.@$resep->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a> --}}
                <button type="button" onclick="deleteCartEresep('{{ $d->rowId }}', {{ $idreg }})" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class="text-right">Total Harga</th>
            {{-- <th class="text-right">{{ number_format($detail->sum('hargajual') + count($detail) * $d->uang_racik) }}</th> --}}
            <th class="text-right">{{ Cart::instance('obat'. $idreg)->subtotal(0,','.',') }}</th>
          </tr>
        </tfoot>
      </table>
</div>

