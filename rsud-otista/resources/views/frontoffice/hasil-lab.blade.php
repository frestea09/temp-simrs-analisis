<div id="data-list-hasil-lab">
    <div class="table-responsive">
        <table class="table-striped table-bordered table-hover table-condensed table">
            <thead>
                <tr>
                    <th>Registrasi</th>
                    <th>Poli</th>
                    <th>No. Lab</th>
                    <th>Waktu Pemeriksaan</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @if (count($hasillabs) > 0)
                    @foreach ($hasillabs as $data)
                        @php
                            $reg = Modules\Registrasi\Entities\Registrasi::find($data->registrasi_id);
                        @endphp
                        <tr>
                            <td>{{ $reg->created_at }}</td>
                            <td>{{ baca_poli($reg->poli_id )}}</td>
                            <td>{{ $data->no_lab }}</td>
                            <td>{{ date('d-m-Y', strtotime($data->tgl_pemeriksaan)) }} {{ $data->jam }}</td>
                            <td>
                                <a href="{{ url('cetak-lis-pdf/' . @$data->no_lab . '/' . @$reg->id) }}"
                                    target="_blank" class="btn btn-sm btn-danger btn-flat"> <i class="fa fa-print"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            <span style="text-align: center">Tidak Pemeriksaan Lab </span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
