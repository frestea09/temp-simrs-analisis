@php
    function cekStatusTagihan($no_faktur)
    {
        return Modules\Registrasi\Entities\Folio::where('namatarif', $no_faktur)->count();
    }

@endphp
<div>
    <div class="input-group">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button">Registrasi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </span>
        <select class="form-control select2" id="registrasi_select">
            @foreach ($registrasis as $registrasi)
                <option value="{{ $registrasi->id }}" {{ @$reg->id == $registrasi->id ? 'selected' : '' }}>
                    [{{ Carbon\Carbon::parse($registrasi->created_at)->format('d-m-Y H:i') }}] -
                    {{ baca_poli($registrasi->poli_id) }}
                </option>
            @endforeach
        </select>
    </div>
</div>


@if ($penjualan == null)
    <span style="text-align: center">Tidak History Penjualan</span>
@else
    <div id="data-list">
        @foreach ($penjualan as $key => $d)
            @php
                $reg_id = $d->registrasi_id;
                $nofaktur = $d->no_resep;
                $eresep = \App\ResepNote::where('penjualan_id', $d->id)->first();
            @endphp
            @if ($d->penjualandetail)
                <form method="POST" action="{{ url('penjualan/cetak-eresep-manual/' . $d->id) }}" target="blank"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="penjualan_id" value="{{ $d->id }}">
                    <div class='table-responsive'>
                        <table class='table-striped table-bordered table-hover table-condensed table'>
                            <thead>
                                <tr>
                                    <th colspan="3"> No. Faktur: {{ $d->no_resep }}
                                    </th>
    
                                    @if ($eresep)
                                        <th colspan="3" style="color:blue"> ERESEP: {{ $eresep->uuid }}</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-primary">
                                        {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->nama }} |
                                        {{ Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id)->pasien->no_rm }}
                                        <div class="pull-right">
                                            {{-- {{ $d->created_at->format('d-m-Y') }} --}}
                                            {{ date('d-m-Y H:i', strtotime($d->created_at)) }}
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
                                    <th>Nama Obat</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th style="width: 10%" class="text-center">Jumlah</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @php
                                    $penjualan_id = $d->id;
                                    $total_ina = 0;
                                @endphp
                                @foreach ($d->penjualandetail as $key => $d)
                                    @php
                                        $obat = \App\LogistikBatch::where('id', $d->logistik_batch_id)->first();
                                        $total_ina += $d->jumlahHarga; 
                                    @endphp
                                    <tr>
                                        <td colspan="2">{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) : $d->masterobat->nama }}
                                            @if ($d->is_kronis == 'Y')
                                                (<b><span style="color:red">KRONIS</span></b>)
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-center">{{ $d->jumlahTotal }}</td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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

