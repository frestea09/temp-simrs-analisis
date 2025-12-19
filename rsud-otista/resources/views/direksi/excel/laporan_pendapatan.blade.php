
            <table class="table table-bordered table-striped"  width="100%" style="font-size:10px">
            @php $no=1; $total = 0; @endphp
            {{-- @if(!empty($kategori)) --}}
              <thead>
                <tr>
                  <th class="text-center" width="35px">NO</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">No. RM</th>
                  <th class="text-center">Cara bayar</th>
                  <th class="text-center">Tgl.Registrasi</th>
                  <th class="text-center">Jenis</th>
                  <th class="text-center">Poli / Ruangan</th>
                  <th class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pembayaran->get() as $item)
                  @php
                      // if (!$item->pasien) {
                      //   @$namapasien = @\Modules\Registrasi\Entities\Registrasi::where('id',$item->registrasi_id)->first();
                      // }
                  @endphp
                  <tr>
                    <td width="35px" class="text-center">{{$no++}}</td>
                    <td style="max-width: 20px;">{!!@$item->pasien->nama ? @$item->pasien->nama : @$namapasien->pasien->nama!!}</td>
                    <td>{{!empty($item->pasien->no_rm) ? $item->pasien->no_rm: @$namapasien->pasien->no_rm}}</td>
                    <td>{{baca_carabayar($item->bayar)}}</td>
                    <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                    <td>{{cek_jenis_reg($item->status_reg)}}</td>
                    <td>
                      @if (@$item->registrasi->poli_id)
                        @if (@$item->registrasi->rawat_inap)
                          {{@baca_kamar($item->registrasi->rawat_inap->kamar_id)}}
                        @else
                          {{@baca_poli($item->registrasi->poli_id)}}
                        @endif
                      @else
                          <i>Penjualan Bebas</i>
                      @endif
                    </td>
                    {{-- <td>{{!empty($item->no_kwitansi) ? $item->no_kwitansi: '-'}}</td>
                    <td class="text-justify text-success"><span class="pull-left">Rp. </span><span class="pull-right">{{ ($item->total) }}</span></td>
                    <td class="text-justify text-red"><span class="pull-left">Rp. </span><span class="pull-right">{{ ($item->diskon_rupiah) }}</span></td> --}}
                    <td class="text-justify text-primary"><span class="pull-left"></span><span class="pull-right">{{ $item->total }}</span></td>
                    {{-- <td class="text-justify">{{@$item->user->name}}</td> --}}
                  </tr>
                  @php
                     $total+= $item->total
                  @endphp
                @endforeach
                  {{-- <tr>
                    <td colspan="2" class="text-right"><b>Total UMUM</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><b>Total JKN</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($JKN) }}</b></td>
                  </tr> --}}
                  <tr>
                    <td colspan="5" class="text-right"><b>Total</b></td>
                    <td class="text-justify"><b class="pull-left">Rp. </b><b class="pull-right">{{ number_format($total) }}</b></td>
                    
                  </tr>
                
              </tbody> 
              </tbody>
            {{-- @endif --}}
            </table> 