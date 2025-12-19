@php
    function cekStatusTagihan($no_faktur)
    {
        return Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
    }

@endphp


@if ($penjualan == null)
    <span style="text-align: center">Tidak History Penjualan</span>
@else
    <div id="data-list">
        @foreach ($penjualan as $key => $d)
            @php
                $cek_dets = App\Penjualandetail::where('penjualan_id', $d->id)->count();
                $reg_id = $d->registrasi_id;
                $nofaktur = $d->no_resep;
                $eresep = \App\ResepNote::where('penjualan_id', $d->id)->first();
                $gudang = Modules\Registrasi\Entities\Folio::where('namatarif', $d->no_resep)->where('registrasi_id',$d->registrasi_id)->first();
            @endphp
            @if ($cek_dets > 0)
                <form method="POST" action="{{ url('penjualan/cetak-eresep-manual/' . $d->id) }}" target="blank"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    {{-- <input class="form-control" type="hidden" name="penjualan_id" value="{{ !empty($penjualanid) ? $penjualanid : NULL }}"> --}}
                    <input type="hidden" name="penjualan_id" value="{{ $d->id }}">
                    {{-- <input type="hidden" name="reg_id" value="OKE"> --}}
    
    
    
                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th colspan="6"> No. Faktur: {{ $d->no_resep }} <b
                                            style="color:red">{{ @$gudang->gudang_id ? '(' . @baca_gudang_logistik($gudang->gudang_id) . ')' : '' }}</b>
                                        @if (!$gudang)
                                            <b style="color:orange">( Butuh Disinkronkan )</b>
                                        @endif
                                    </th>
    
                                    @if ($eresep)
                                        <th colspan="6" style="color:blue"> ERESEP: {{ $eresep->uuid }}</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-primary">
                                        {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->nama }} |
                                        {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->no_rm }}
                                        <div class="pull-right">
                                            {{-- {{ $d->created_at->format('d-m-Y') }} --}}
                                            {{ date('d-m-Y', strtotime($d->created_at)) }}
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-primary">
                                        Tanggal Registrasi Pasien |
                                        {{ date('d-m-Y', strtotime(Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->created_at)) }}
                                    </th>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <th class="text-center"><input type="checkbox" id="check-all"></th>
                                    <th>Nama Obat</th>
                                    <th style="width: 10%" class="text-center">Batch</th>
                                    {{-- <th style="width: 10%" class="text-center">Catatan</th> --}}
                                    <th style="width: 10%" class="text-center">Penjualan INACBG</th>
                                    {{-- <th style="width: 10%" class="text-center">Penjualan KRONIS</th> --}}
                                    <th style="width: 10%" class="text-center">Retur INACBG</th>
                                    {{-- <th style="width: 10%" class="text-center">Retur KRONIS</th> --}}
                                    <th style="width: 10%" class="text-center">Total INACBG</th>
                                    {{-- <th style="width: 10%" class="text-center">Total KRONIS</th> --}}
                                </tr>
                            </thead>
    
                            <tbody>
                                @php
                                    $penjualan_id = $d->id;
                                    $det = App\Penjualandetail::where('penjualan_id', $d->id)->get();
                                @endphp
                                @foreach ($det as $key => $d)
                                    @php
                                        $obat = \App\LogistikBatch::where('id', $d->logistik_batch_id)->first();
                                    @endphp
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="check-item"
                                                name="penjualandetail_id[]" value="{{ $d->id }}" /></td>
                                        <td>{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) : $d->masterobat->nama }}
                                        </td>
                                        <td>{{ !empty($obat->nomorbatch) ? $obat->nomorbatch : '' }}</td>
                                        {{-- <td class="text-center">{{ @$d->informasi2 }}</td> --}}
                                        <td class="text-center">{{ $d->jumlah }}</td>
                                        {{-- <td class="text-center">{{ $d->jml_kronis }}</td> --}}
                                        <td class="text-center">{{ !empty($d->retur_inacbg) ? $d->retur_inacbg : '-' }}</td>
                                        {{-- <td class="text-center">{{ !empty($d->retur_kronis) ? $d->retur_kronis : ''}}</td> --}}
                                        <td class="text-right">{{ !empty($d->hargajual) ? number_format($d->hargajual) : '' }}
                                        </td>
                                        {{-- <td class="text-right">{{ !empty($d->hargajual) ? number_format($d->hargajual_kronis) : '' }}</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total INACBG</th>
                                    <th class="text-right">{{ number_format($det->sum('hargajual')) }}</th>
                                </tr>
                                {{-- <tr>
                    <th colspan="8" class="text-right">Total KRONIS</th>
                    <th class="text-right">{{ number_format($det->sum('hargajual_kronis')) }}</th>
                </tr> --}}
                                <tr>
                                    <th>
    
                                    </th>
                                    <th class="text-right" colspan="7">
                                        <span class="pull-left">{{ $d->created_at }}</span>
                                        @if ($d->created_at <= '2020-04-01 00:00:00')
                                            <a href="{{ url('farmasi/cetak-detail/' . $d->penjualan_id) }}"
                                                class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
                                        @elseif($d->created_at >= '2020-04-01 00:00:00' && $d->created_at < '2020-04-02 15:51:16')
                                            <a href="{{ url('farmasi/cetak-detail-baru/' . $d->penjualan_id) }}"
                                                class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></a>
                                        @else
                                            <a href="{{ url('/penjualan/tab-infus/' . $reg_id ) }}" target="_blank" class="btn btn-success btn-flat btn-sm">Infus</a>
                                            <a href="{{ url('farmasi/cetak-detail/' . $d->penjualan_id) }}"
                                                class="btn btn-danger btn-flat btn-sm">Detail</a>
                                            {{-- <a target="_blank" href="{{ url('/farmasi/cetak-copy-resep/'.$d->penjualan_id) }}" class="btn btn-warning btn-flat btn-sm">Copy Resep</a>&nbsp; --}}
                                            <a target="_blank" href="{{ url('/farmasi/laporan/etiket/' . $d->penjualan_id) }}"
                                                class="btn btn-info btn-flat btn-sm">Semua Etiket</a>&nbsp;
    
                                            @if ($eresep)
                                                <a target="_blank" href="{{ url('/farmasi/cetak-eresep/' . $d->penjualan_id) }}"
                                                    class="btn btn-primary btn-flat btn-sm">Eresep</a>&nbsp;
                                            @endif
                                        @endif
                                        <button type="submit" class="btn btn-warning btn-sm">Cetak Etiket Dipilih</button>
                                        <a onclick="return confirm('Harga akan disinkronkan ke Faktur, yakin akan memproses ?')"
                                            href="{{ url('penjualan-sinkron-faktur/' . $nofaktur . '/' . $reg_id . '/' . $det->sum('hargajual')) }}"
                                            class="btn btn-success btn-flat btn-sm">Sinkronkan Dengan Faktur</a><br />
                                        <small class="pull-left" style="font-weight:400"><span class="text-red">*</span> Tombol
                                            "<b>Sinkronkan Dengan Faktur</b>" digunakan jika harga difaktur tidak sesuai dengan
                                            history penjualan</small>
    
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            @endif
        @endforeach
    </div>
@endif
<script>
    document.getElementById('check-all').addEventListener('change', function() {
        var checkboxes = document.getElementsByClassName('check-item');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>

