<div class="col-md-12">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>INACBG</strong>
        </div>
        <div class="panel-body">
            {{-- =========================
                 DIAGNOSA
            ========================== --}}

            <div class="form-group" style="padding:10px">
                <label>Diagnosa <small>(ICD-10)</small>:</label>
                <div class="well well-sm" style="margin-bottom: 10px; background: #f9f9f9;">
                    <ul class="list-group" style="margin: 0;">
                        @foreach (explode('#', $diagnosa_inacbg) as $kode)
                            @if (!empty($kode))
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="border: none; background: transparent;">
                                    {{-- <button {{ @$klaim->idrg_grouper == 4 ? 'disabled' : '' }} type="button"
                                            class="btn btn-danger btn-xs remove-diagnosa"
                                            data-code="{{ $kode }}">×</button> --}}
                                    <span>
                                        <strong>{{ strtoupper($kode) }}</strong> – {{ baca_diagnosa_im($kode) }}
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
                        @foreach (explode('#', $prosedur_inacbg) as $kode)
                            @if (!empty($kode))
                                @php
                                    // Jika ada +qty di kode
                                    $parts = explode('+', $kode);
                                    $kode_icd = $parts[0];
                                    $qty = $parts[1] ?? 1;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="border: none; background: transparent;">
                                    {{-- <button {{ @$klaim->idrg_grouper == 4 ? 'disabled' : '' }} type="button"
                                        class="btn btn-danger btn-xs remove-procedure"
                                        data-code="{{ $kode }}">×</button> --}}
                                    <span>
                                        <strong>{{ strtoupper($kode_icd) }}</strong> – {{ baca_prosedur_im($kode_icd) }}
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

            {{-- Hasil Grouping --}}
            {{-- Ambil data dari JSON --}}
            @php
                @$resp = $hasil_grouping_inacbg;
                @$resp2 = $hasil_grouping_inacbg_2;

            @endphp

            <div class="table-responsive">
                <table class="table table-bordered" style="background-color: #f2fff2;">
                    <thead>
                        <tr style="background-color: #d8f5d8;">
                            <th colspan="4" class="text-center">Hasil Grouping INACBG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="30%"><strong>Info</strong></td>
                            <td colspan="2">
                                INACBG @ {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
                                - Versi: {{ @$resp->inacbg_version }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>GROUP</strong></td>
                            <td><b>{{ @$resp->cbg->description }}</b></td>
                            <td><span class="pull-right">{{ @$resp->cbg->code }}</span></td>
                            <td>{{ number_format(@$resp->base_tariff, 0, ',', '.') }}</td>
                        </tr>
                        {{-- Jika ada Special CMG Option --}}
                        @if (!empty($hasil_cmg))
                            <tr style="background-color: #e8f0fe;">
                                <td colspan="4" class="text-center"><strong>Special CMG Options</strong></td>
                            </tr>

                            @php
                                // Kelompokkan hasil_cmg berdasarkan tipe
                                $grouped = collect($hasil_cmg)->groupBy('type');

                                // Ambil hasil grouping ke-2 (yang sudah ada tarif)
                                $resp2 = @$hasil_grouping_inacbg_2;

                                // Data special_cmg yang sudah tersimpan di database
                                $saved_special_cmg = @$klaim->special_cmg ?? ''; // contoh: "RR04Knee#YY01"
                                $saved_codes = array_filter(explode('#', $saved_special_cmg));

                                $selected_cmg = @$resp2->special_cmg ?? [];
                                $selected_by_type = collect($selected_cmg)->groupBy('type');
                            @endphp

                            @foreach ($grouped as $type => $items)
                                @php

                                    $slug = \Illuminate\Support\Str::slug($type, '_');
                                    $selected_items = collect($selected_by_type->get($type, [])); // pastikan collection
                                    $selected = $selected_items->first(); // salah satu item yg dipilih
                                    $selected_codes = $selected_items->pluck('code')->toArray(); // untuk cek selected dropdown
                                @endphp
                                <tr>
                                    <td><strong>{{ $type }}</strong></td>
                                    <td>
                                        <select name="special_cmg[{{ $slug }}]"
                                            class="form-control form-control-sm">
                                            <option value="">None</option>
                                            @foreach ($items as $opt)
                                                <option value="{{ $opt->code }}"
                                                    {{ in_array($opt->code, $saved_codes) ? 'selected' : '' }}>
                                                    {{ $opt->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- INI MENAMPILKAN KODE CMG --}}
                                    <td>
                                        @if ($selected)
                                            <strong>{{ $selected->code }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    {{-- INI MENAMPILKAN TOTAL CMG --}}
                                    <td>
                                        @if ($selected)
                                            Rp{{ number_format($selected->tariff ?? 0, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted">Rp0</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td><strong>Total Klaim</strong></td>
                            <td colspan="3" class="text-right">
                                {{ number_format(@($resp2->tariff ?? 0) != 0 ? $resp2->tariff : ($resp->tariff ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>{{ strtoupper(str_replace('_', ' ', @$resp->kelas)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="{{ @$resp->status_cd == 'normal' ? 'text-success' : 'text-danger' }}">
                                    {{ strtoupper(@$resp->status_cd) }}
                                </span>
                            </td>
                        </tr>
                        @if (!empty($hasil_cmg))
                            <tr>
                                <td colspan="2">
                                    @if (in_array(@$klaim->status_step, ['grouping_inacbg', 'final_claim']))
                                        <button type="button" id="grouping_stage_2"
                                            class="btn btn-danger btn-flat btn-pull-right">
                                            GROUPING 2
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>


            {{-- <a href="#" class="small">[ debug ]</a> --}}
            @if (in_array(@$klaim->status_step, ['done', 'final_claim']) && @$klaim->final_klaim !== 'Y')
                <button type="button" id="edit_klaim_inacb" class="btn btn-primary btn-flat btn-pull-right">
                    EDIT ULANG INACBG
                </button>
            @endif
        </div>
    </div>
</div>
