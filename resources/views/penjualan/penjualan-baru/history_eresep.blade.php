@php
  function cekStatusTagihan($no_faktur){
    return Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
  }
@endphp
@if (count($penjualan) > 0)
@foreach ($penjualan as $key => $d)
  @if ($d->registrasi)
    <hr style="border-top: 1px solid red;"/>
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th colspan="4"> No. Resep: {{ $d->uuid }}</th>
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
            <th>Kronis</th>
            <th>Informasi</th>
            <th style="color:red">Catatan</th>
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
            <td>{{ $res->kronis ?? 'N' }}</td>
            <td>{{ $res->informasi }}</td>
            <td>{{ $catatan }}</td>
            </tr>
          @endforeach
          <tr>
            <td><button type="button" data-toggle="collapse" data-target="#obat_farmasi{{$d->id}}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Lihat Obat Dari Farmasi</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    
    <div class="accordian-body collapse" id="obat_farmasi{{$d->id}}"> 
      <table class="table table-striped"> 
          <h5 style="font-weight: bold;" class="text-center">Obat Farmasi</h5>
          <thead>
                @if (@$d->penjualan->penjualandetail)
                        <div class='table-responsive'>
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th style="width: 10%" class="text-center">Jumlah</th>
                                        <th style="width: 10%" class="text-center">Tiket</th>
                                        <th style="width: 10%" class="text-center">Cara Minum</th>
                                        <th style="width: 10%" class="text-center">Takaran</th>
                                        <th style="width: 10%" class="text-center">Kronis</th>
                                        <th style="width: 10%" class="text-center">Informasi</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($d->penjualan->penjualandetail as $key => $detail)
                                        @php
                                            $obat = \App\LogistikBatch::where('id', $detail->logistik_batch_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ !empty($detail->logistik_batch_id) ? baca_batches($detail->logistik_batch_id) : $detail->masterobat->nama }}
                                            </td>
                                            <td class="text-center">{{ $detail->jumlah }}</td>
                                            <td class="text-center">{{ $detail->etiket }}</td>
                                            <td class="text-center">{{ $detail->cara_minum }}</td>
                                            <td class="text-center">{{ $detail->takaran }}</td>
                                            <td class="text-center">{{ $detail->is_kronis }}</td>
                                            <td class="text-center">{{ $detail->informasi1 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                @endif
          </thead>
      </table>
    </div>
  @endif
@endforeach
    
@else
<p>Belum ada E-Resep Hari ini....</p>
@endif

