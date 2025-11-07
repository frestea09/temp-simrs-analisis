@php
  function cekStatusTagihan($no_faktur){
    return Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
  }
@endphp
@if (count($penjualan) > 0)
@foreach ($penjualan as $key => $d)
  <hr style="border-top: 1px solid red;"/>
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th colspan="4"> No. Faktur: {{ $d->uuid }}</th>
          @if ($d->no_resep)
            <th colspan="4" style="color:blue"> No. Faktur Penjualan: {{ $d->no_resep }}</th>
          @endif
        </tr>
        <tr>
          <th colspan="7" class="text-primary">
            {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->nama }} |
              {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->no_rm }}
            <div class="pull-right">
              {{-- {{ $d->created_at->format('d-m-Y') }} --}}
              {{ date('d-m-Y H:i', strtotime($d->created_at)) }}
            </div>
          </th>
        </tr>
        <tr>
          <th>Nama Obat</th>
          <th style="width: 10%" class="text-center">Batch</th>
          <th style="width: 10%" class="text-center">Jumlah</th> 
          <th>Tiket</th>
          <th>Cara Minum</th>
          <th>Takaran</th>
          <th>Informasi</th>
          <th style="color:red">Catatan</th>
          {{-- <th style="width: 10%" class="text-center">Cara Bayar</th>  --}}
          {{-- <th style="width: 10%" class="text-center">Total INACBG</th>  --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($d->resep_detail as $key => $res)
        @php
            $catatan = '';
            $obat = \App\LogistikBatch::where('id', $res->logistik_batch_id)->first();
            
            if($res->resepnote->penjualan_id){
            $penjualan = \App\Penjualandetail::where('penjualan_id', $res->resepnote->penjualan_id)->where('masterobat_id',@$res->logistik_batch->masterobat_id)->first();
              if($penjualan)
              $catatan = @$penjualan->informasi2;
            }
            
          @endphp
        <tr>
        <td>{{ !empty($res->logistik_batch_id) ? baca_batches($res->logistik_batch_id) : $res->masterobat->nama }}</td>
        <td>{{ !empty($obat->nomorbatch) ? $obat->nomorbatch : '' }}</td>
        <td class="text-center">{{ $res->qty }}</td>
        <td>{{ $res->tiket }}</td>
        <td>{{ $res->cara_minum }}</td>
        <td>{{ $res->takaran }}</td>
        <td>{{ $res->informasi }}</td>
        <td>{{ $catatan }}</td>
        </tr>
        @endforeach
        {{-- @php
          $det = App\Penjualandetail::where('penjualan_id', $d->id)->get();
        @endphp
        @foreach ($det as $key => $d)
          @php
            $obat = \App\LogistikBatch::where('id', $d->logistik_batch_id)->first();
          @endphp
          <tr>
            <td class="text-center">{{ $d->jumlah }}</td>
            <td class="text-center">{{ $d->jml_kronis }}</td>
            <td class="text-center">{{ !empty($d->retur_inacbg) ? $d->retur_inacbg : ''}}</td>
            <td class="text-center">{{ !empty($d->retur_kronis) ? $d->retur_kronis : ''}}</td>
            <td class="text-right">{{ !empty($d->hargajual) ? number_format($d->hargajual) : '' }}</td>
            <td class="text-right">{{ !empty($d->hargajual) ? number_format($d->hargajual_kronis) : '' }}</td>
          </tr>
        @endforeach --}}
      </tbody>
      <tfoot>
        {{-- <tr>
          <th colspan="7" class="text-right">Total INACBG</th>
          <th class="text-right">{{ number_format($det->sum('hargajual')) }}</th>
        </tr>
        <tr>
          <th colspan="7" class="text-right">Total KRONIS</th>
          <th class="text-right">{{ number_format($det->sum('hargajual_kronis')) }}</th>
        </tr> --}}
        <tr>
          <th>

          </th>
          {{-- <th class="text-right" colspan="7">
          {{ $d->created_at }}
            @if($d->created_at <= '2020-04-01 00:00:00')
            <a href="{{ url('farmasi/cetak-detail/'.$d->penjualan_id) }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
            @elseif($d->created_at >= '2020-04-01 00:00:00' && $d->created_at < '2020-04-02 15:51:16')
              <a href="{{ url('farmasi/cetak-detail-baru/'.$d->penjualan_id) }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
            @else
              <a href="{{ url('farmasi/cetak-detail/'.$d->penjualan_id) }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
            @endif
          </th> --}}
        </tr>
      </tfoot>
    </table>
  </div>

@endforeach
    
@else
<p>Belum ada E-Resep Hari ini....</p>
@endif

