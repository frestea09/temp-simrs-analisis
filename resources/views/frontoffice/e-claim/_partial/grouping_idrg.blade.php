<div class="col-md-12">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>iDRG</strong>
        </div>
        <div class="panel-body">
            {{-- =========================
                 DIAGNOSA
            ========================== --}}

            <div class="form-group" style="padding:10px">
                <label>Diagnosa <small>(ICD-10)</small>:</label>
                <div class="well well-sm" style="margin-bottom: 10px; background: #f9f9f9;">
                    <ul class="list-group" style="margin: 0;">
                        @foreach (explode('#', $diagnosa) as $kode)
                            @if (!empty($kode))
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="border: none; background: transparent;">
                                    {{-- <button {{ @$klaim->idrg_grouper == 4 ? 'disabled' : '' }} type="button"
                                            class="btn btn-danger btn-xs remove-diagnosa"
                                            data-code="{{ $kode }}">×</button> --}}
                                    <span>
                                        <strong>{{ strtoupper($kode) }}</strong> – {{ baca_diagnosa($kode) }}
                                        @if (@$loop->first)
                                            <span class="badge badge-primary mr-1">Primary</span>
                                        @endif
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>



            {{-- =========================
                 PROSEDUR
            ========================== --}}
            <div class="form-group" style="padding:10px">
                <label>Prosedur <small>(ICD-9-CM)</small>:</label>
                <div class="well well-sm" style="margin-bottom: 10px; background: #f9f9f9;">
                    <ul class="list-group" style="margin: 0;">
                        @foreach (explode('#', $prosedur) as $kode)
                            @php
                                // Jika ada +qty di kode
                                $parts = explode('+', $kode);
                                $kode_icd = $parts[0];
                                $qty = $parts[1] ?? 1;
                            @endphp
                            @if (!empty($kode))
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="border: none; background: transparent;">
                                    <span>
                                        <strong>{{ $kode_icd }}</strong> -
                                        {{ baca_prosedur($kode_icd) }}</span>
                                    @if (@$loop->first)
                                        <span class="badge badge-primary mr-1"
                                            style="float:none !important">Primary</span>
                                    @endif

                                    @if ($qty > 1)
                                        <b>{{ $qty }} Kali</b>
                                    @endif
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Hasil Grouping --}}
            {{-- Ambil data dari JSON --}}
            @php
                @$resp = $table_final_idrg;
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered" style="background-color: #f2fff2;">
                    <thead>
                        <tr style="background-color: #d8f5d8;">
                            <th colspan="2" class="text-center">Hasil Grouping iDRG - Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="30%"><strong>Info</strong></td>
                            <td>
                                INACBG @ {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
                                - {{ @$resp->script_version }} / {{ @$resp->logic_version }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>MDC</strong></td>
                            <td><b>{{ @$resp->mdc_description }}</b>
                                <span class="pull-right">{{ @$resp->mdc_number }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>DRG</strong></td>
                            <td>{{ @$resp->drg_description }}
                                <span class="pull-right">{{ @$resp->drg_code }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Cost Weight <sup>**</sup></strong></td>
                            <td>{{ @$resp->cost_weight }}</td>
                        </tr>
                        <tr>
                            <td><strong>NBR <sup>**</sup></strong></td>
                            <td>{{ number_format(@$resp->nbr, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="{{ @$resp->status_cd == 'normal' ? 'text-success' : 'text-danger' }}">
                                    {{ @$resp->status_cd }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-muted">
                <strong>**)</strong> Catatan: Nilai belum final, sewaktu-waktu bisa berubah
            </p>

            {{-- <a href="#" class="small">[ debug ]</a> --}}
            @if (@$klaim->status_step !== 'done')
            <button type="button" id="edit_idrg" class="btn btn-primary btn-flat btn-pull-right">
                EDIT ULANG IDRG
            </button>
            @endif
        </div>
    </div>
</div>
