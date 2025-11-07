<div id="data-list-hasil-lab">
    <div class="table-responsive">
        <table class="table-striped table-bordered table-hover table-condensed table">
            <thead>
                <tr>
                    <th>Registrasi</th>
                    <th>Poli</th>
                    <th>uuid</th>
                    <th>Tindakan</th>
                    <th>Tanggal Periksa</th>
                    <th>Tanggal Expertise</th>
                    <th>Cetak</th>
                </tr>
            </thead>
            <tbody>
                @if (count($hasilrads) > 0)
                    @foreach ($hasilrads as $data)
                        @php
                            $reg = Modules\Registrasi\Entities\Registrasi::find($data->registrasi_id);
                            $folio = Modules\Registrasi\Entities\Folio::where('registrasi_id', '=', $reg->id)->first();
                            $folio_id = $data->folio_id ? $data->folio_id : $folio->id;
                        @endphp
                        <tr>
                            <td>{{ $reg->created_at }}</td>
                            <td>{{ baca_poli($reg->poli_id )}}</td>
                            <td>{{ $data->uuid }}</td>
                            <td>{{ $folio->namatarif }}</td>
                            <td>{{ $data->tglPeriksa }}</td>
                            <td>{{ $data->tanggal_eksp }}</td>
                            <td>
                                <a href="{{ url("radiologi/cetak-ekpertise/".$data->id."/".$reg->id."/".$folio_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $data->no_dokument }} </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            <span style="text-align: center">Tidak Pemeriksaan Radiologi </span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
