<div class="col-md-6">

    <div class="form-group" id="groupDiagnosa">
        {!! Form::label('diagnosa', 'Diagnosa ICD10 INACBG', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <button type="button" id="openICD10Inacbg" class="btn btn-default btn-flat">ICD10</button><br />
            <input type="hidden" name="diagnosa_inacbg" id="diagnosaInputInacbg" value="{{ $diagnosa_inacbg ?? '' }}"
                {{ @$klaim->idrg_grouper == 4 ? 'readonly' : '' }}>
            <ul id="diagnosaListInacbg" class="list-group mb-2">
                @if (!empty($diagnosa_inacbg))
                    @foreach (explode('#', $diagnosa_inacbg) as $kode)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-diagnosa-inacbg"
                                data-code="{{ $kode }}">×</button>
                            <span><strong>{{ $kode }}</strong> – {!! baca_diagnosa_im($kode) !!}</span>
                        </li>
                    @endforeach
                @endif
            </ul>

        </div>
    </div>
</div>
<div class="col-md-6">

    <div class="form-group" id="groupProcedure">
        {!! Form::label('procedure', 'Procedure ICD9 INACBG', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <button type="button" id="openICD9Inacbg" class="btn btn-default btn-flat">ICD9</button>
            <!-- Hidden input, tetap pakai name="procedure" agar backend tetap sama -->
            <input type="hidden" name="procedure_inacbg" id="procedureInputInacbg"
                value="{{ $prosedur_inacbg ?? '' }}">
            <ul id="procedureListInacbg" class="list-group mb-2">
                @if (!empty($prosedur_inacbg) && $prosedur_inacbg !== '#')
                    @foreach (explode('#', $prosedur_inacbg) as $kode)
                        @php
                            // Jika ada +qty di kode
                            $parts = explode('+', $kode);
                            $kode_icd = $parts[0];
                            $qty = $parts[1] ?? 1;
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-procedure-inacbg"
                                data-code="{{ $kode_icd }}">×</button>
                            <span><strong>{{ $kode_icd }}</strong> – {!! baca_prosedur_im($kode_icd) !!}</span>
                        </li>
                    @endforeach
                @endif
            </ul>

        </div>
    </div>
</div>
