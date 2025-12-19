@php
  function cekStatusTagihan($no_faktur){
    return Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
  }
@endphp

@foreach ($penjualan as $key => $d)
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th colspan="3"> No. Faktur: {{ $d->no_resep }}</th>
        </tr>
        <tr>
          <th colspan="3" class="text-primary">
            {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->nama }} |
              {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->no_rm }}
            <div class="pull-right">
              {{ $d->created_at->format('d-m-Y') }}
            </div>
          </th>
        </tr>
        <tr>
          <th>Nama Obat</th>
          <th style="width: 10%" class="text-center">Jumlah</th>
          <th class="text-center">Harga</th>
        </tr>
      </thead>
      <tbody>
        @php
          $det = App\Penjualandetail::where('penjualan_id', $d->id)->get();
        @endphp
        @foreach ($det as $key => $d)
          <tr>
            <td>{{ $d->masterobat->nama }}</td>
            <td class="text-center">{{ $d->jumlah }}</td>
            <td class="text-right">{{ number_format($d->hargajual) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="2" class="text-right">Harga Total</th>
          <th class="text-right">{{ number_format($det->sum('hargajual')) }}</th>
        </tr>
        <tr>
          <th>

          </th>
          <th class="text-right" colspan="2">
            <a href="{{ url('farmasi/cetak-detail/'.$d->penjualan_id) }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
          </th>
        </tr>
      </tfoot>
    </table>
  </div>

@endforeach
